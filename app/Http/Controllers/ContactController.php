<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 1. SIMPAN KE DATABASE
        try {
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'is_read' => false,
            ]);

            Log::info('Contact saved to database', ['id' => $contact->id]);
        } catch (\Exception $e) {
            Log::error('Failed to save contact to database: ' . $e->getMessage());
        }

        // 2. KIRIM KE WHATSAPP VIA FONNTE
        $whatsappSent = $this->sendWhatsAppNotification($validated, $request);

        // 3. REDIRECT RESPONSE
        if ($whatsappSent) {
            return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah kami terima. Tim kami akan segera menghubungi Anda via WhatsApp.');
        } else {
            return redirect()->back()->with('warning', 'Pesan Anda telah kami terima. Tim kami akan segera menghubungi Anda via email.');
        }
    }

    private function sendWhatsAppNotification($data, $request)
    {
        // Format pesan WhatsApp
        $waMessage = "*📢 PESAN BARU DARI FARISA WO WEBSITE*\n\n" .
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n" .
            "*👤 Nama:* " . $data['name'] . "\n" .
            "*📧 Email:* " . $data['email'] . "\n" .
            "*📱 Telepon:* " . ($data['phone'] ?? '-') . "\n" .
            "*📌 Subjek:* " . $data['subject'] . "\n" .
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
            "*💬 Pesan:*\n" . $data['message'] . "\n\n" .
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n" .
            "⏰ *Dikirim:* " . now()->format('d/m/Y H:i:s') . "\n" .
            "🌐 *IP Address:* " . $request->ip() . "\n" .
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n" .
            "_✨ Pesan ini dikirim otomatis dari website Farisa WO_";

        // Encode untuk URL (spaces, newlines, etc.)
        $encodedMessage = urlencode($waMessage);

        // Cek konfigurasi Fonnte
        $apiKey = env('FONNTE_API_KEY');
        $targetPhone = env('FONNTE_PHONE');

        if (!$apiKey || !$targetPhone) {
            Log::error('Fonnte: API Key atau nomor target tidak dikonfigurasi');
            return false;
        }

        try {
            // Kirim ke Fonnte API
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => $apiKey,
            ])->post('https://api.fonnte.com/send', [
                'target' => $targetPhone,
                'message' => $waMessage, // Kirim as-is, jangan encoded
                'type' => 'text',
                'countryCode' => '62',
            ]);

            $result = $response->json();

            Log::info('Fonnte Response:', [
                'status_code' => $response->status(),
                'response' => $result
            ]);

            if ($response->successful() && isset($result['status']) && $result['status'] == true) {
                Log::info('WhatsApp notification sent successfully');
                return true;
            } else {
                $errorMsg = $result['reason'] ?? 'Unknown error';
                Log::error('Fonnte Error: ' . json_encode($result));
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Fonnte Exception: ' . $e->getMessage());
            return false;
        }
    }
}
