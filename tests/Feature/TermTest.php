<?php
namespace Tests\Feature;
use Tests\TestCase;
class TermTest extends TestCase
{
    public function test_create_page()
    {
        $user = \App\Models\User::first();
        $response = $this->actingAs($user)->get('/admin/term-and-conditions/create');
        if ($response->status() === 500) {
            echo strip_tags($response->content());
        }
        $response->assertStatus(200);
    }
}
