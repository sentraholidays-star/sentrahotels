<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class AiArticleService
{
    /**
     * Generate an article using Jina Reader and Gemini API.
     *
     * @param string|null $sourceUrls (comma or newline separated)
     * @param string|null $brief
     * @param string $tone
     * @return string Generated HTML content
     */
    public function generateArticle(?string $sourceUrls, ?string $brief, string $tone): string
    {
        $scrapedContent = '';

        // 1. Scrape URLs using Jina Reader if provided
        if (!empty($sourceUrls)) {
            $urls = preg_split('/[\s,]+/', $sourceUrls, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($urls as $url) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    try {
                        $response = Http::timeout(10)->get("https://r.jina.ai/" . $url);
                        if ($response->successful()) {
                            $scrapedContent .= "\n\n--- Source: $url ---\n" . $response->body();
                        }
                    } catch (Exception $e) {
                        // Silently ignore failing URLs
                    }
                }
            }
        }

        // 2. Prepare Prompt
        $systemPrompt = "You are a professional luxury hotel copywriter working for 'Sentra Hotels'. Your task is to write a well-structured, SEO-friendly, and engaging article in Indonesian.
Format the output purely in HTML (use <h2>, <h3>, <p>, <ul>, <li>, <strong>) without any Markdown wrapping or ```html block. Just the raw HTML.
Tone of voice: $tone.
";

        $userPrompt = "Please write a new article based on the following instructions:\n\n";
        if (!empty($brief)) {
            $userPrompt .= "Brief / Instructions:\n$brief\n\n";
        }
        if (!empty($scrapedContent)) {
            $userPrompt .= "Source Material (synthesize this information, do not plagiarize, rewrite in Sentra Hotels tone):\n$scrapedContent\n\n";
        }

        if (empty($brief) && empty($scrapedContent)) {
            throw new Exception("Anda harus mengisi setidaknya Link Referensi atau Instruksi Tambahan.");
        }

        // 3. Call Gemini API
        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey)) {
            throw new Exception("GEMINI_API_KEY belum dikonfigurasi di file .env");
        }

        $geminiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";
        
        $response = Http::timeout(45)->post($geminiUrl, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $systemPrompt . "\n\n" . $userPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 3000,
            ]
        ]);

        if ($response->failed()) {
            throw new Exception("Gagal terhubung ke Gemini API: " . $response->body());
        }

        $data = $response->json();
        
        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new Exception("Format balasan Gemini tidak sesuai harapan.");
        }

        $text = $data['candidates'][0]['content']['parts'][0]['text'];

        // Clean up markdown wrapper if AI disobeys
        $text = preg_replace('/^```html\s*/i', '', $text);
        $text = preg_replace('/^```\s*/i', '', $text);
        $text = preg_replace('/\s*```$/i', '', $text);
        
        return trim($text);
    }
}
