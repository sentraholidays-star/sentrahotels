<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationRequestMail;

class BookingController extends Controller
{
    /**
     * Handle the incoming reservation request.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $validatedData = $request->validate([
            'hotel_name'    => 'required|string|max:255',
            'check_in'      => 'required|date',
            'check_out'     => 'required|date|after:check_in',
            'room_count'    => 'required|integer|min:1',
            'meals'         => 'required|string|max:100',
            'room_type'     => 'required|string|max:100',
            'customer_name' => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
        ]);

        try {
            // 2. Pengiriman Email ke Admin Sentra Holidays
            Mail::to('reservation@sentraholidays.com')->send(new ReservationRequestMail($validatedData, true));

            // 3. Pengiriman Email Konfirmasi ke Tamu (Customer)
            Mail::to($validatedData['email'])->send(new ReservationRequestMail($validatedData, false));

            // 4. Return Redirect dengan Session Alert Success
            return back()->with('success', 'Terima kasih, ' . $validatedData['customer_name'] . '! Request Anda telah kami terima. Tim konsultan Sentra Holidays akan segera mengirimkan penawaran harga terbaik melalui email dan WhatsApp Anda.');

        } catch (\Exception $e) {
            // Error Handling jika konfigurasi SMTP email belum disetel
            return back()->withInput()->with('error', 'Maaf, terjadi kesalahan saat mengirim data reservasi. Silakan hubungi kami via WhatsApp.');
        }
    }
}
