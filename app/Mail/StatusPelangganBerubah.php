<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusPelangganBerubah extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array<string, string> */
    public array $statusConfig;

    public function __construct(
        public readonly Customer $customer,
        public readonly string $newStatus,
    ) {
        $this->statusConfig = $this->resolveStatusConfig($newStatus);
    }

    public function envelope(): Envelope
    {
        $ccAddresses = [];

        if ($this->customer->finance_email) {
            $ccAddresses[] = new Address($this->customer->finance_email, $this->customer->finance_name ?? 'Finance PIC');
        }

        if ($this->customer->technical_email) {
            $ccAddresses[] = new Address($this->customer->technical_email, $this->customer->technical_name ?? 'Technical PIC');
        }

        return new Envelope(
            subject: '[MSS] '.$this->statusConfig['subject'],
            cc: $ccAddresses,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.status-pelanggan-berubah',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    /** @return array<string, string> */
    private function resolveStatusConfig(string $status): array
    {
        return match ($status) {
            'menunggu_invoice' => [
                'subject' => 'Registrasi Anda Disetujui — Invoice Sedang Disiapkan',
                'headline' => 'Selamat! Registrasi Anda Telah Disetujui',
                'body' => 'Tim marketing kami telah memverifikasi data registrasi Anda. Invoice biaya registrasi sedang disiapkan oleh tim Finance dan akan segera dikirimkan ke dashboard Anda.',
                'cta_label' => 'Pantau Status di Dashboard',
                'color' => '#70bb63',
                'icon' => '✅',
            ],
            'menunggu_pembayaran' => [
                'subject' => 'Invoice Diterbitkan — Silakan Lakukan Pembayaran',
                'headline' => 'Invoice Telah Diterbitkan',
                'body' => 'Invoice biaya registrasi layanan internet Anda telah diterbitkan. Silakan login ke dashboard untuk melihat detail tagihan dan mengunggah bukti pembayaran setelah transfer dilakukan.',
                'cta_label' => 'Lihat Invoice & Bayar',
                'color' => '#ebb751',
                'icon' => '🧾',
            ],
            'proses_instalasi' => [
                'subject' => 'Pembayaran Dikonfirmasi — Jadwal Instalasi Diproses',
                'headline' => 'Pembayaran Anda Telah Dikonfirmasi',
                'body' => 'Terima kasih atas pembayaran Anda. Tim NOC kami sedang memproses jadwal instalasi perangkat di lokasi Anda. Kami akan segera menghubungi Anda untuk koordinasi lebih lanjut.',
                'cta_label' => 'Pantau Progres Instalasi',
                'color' => '#60addf',
                'icon' => '🔧',
            ],
            'menunggu_baa' => [
                'subject' => 'Instalasi Selesai — Silakan Tanda Tangani BAA',
                'headline' => 'Instalasi Internet Anda Telah Selesai',
                'body' => 'Tim NOC kami telah berhasil menyelesaikan instalasi dan aktivasi layanan internet di lokasi Anda. Berita Acara Aktivasi (BAA) telah siap untuk ditandatangani. Silakan login ke dashboard dan lakukan tanda tangan digital.',
                'cta_label' => 'Tanda Tangani BAA Sekarang',
                'color' => '#ebb751',
                'icon' => '📄',
            ],
            'selesai' => [
                'subject' => 'Selamat! Layanan Internet Anda Telah Aktif',
                'headline' => 'Layanan Internet Anda Resmi Aktif! 🎉',
                'body' => 'Seluruh proses aktivasi layanan internet MSS untuk perusahaan Anda telah selesai. ID pelanggan Anda adalah <strong>'.($this->customer->customer_number ?? '-').'</strong>. Simpan ID ini untuk keperluan komunikasi dengan tim support kami.',
                'cta_label' => 'Lihat Detail Layanan',
                'color' => '#70bb63',
                'icon' => '🌐',
            ],
            default => [
                'subject' => 'Update Status Layanan Anda',
                'headline' => 'Ada Pembaruan Status Layanan Anda',
                'body' => 'Terdapat perubahan status pada layanan internet MSS Anda. Silakan login ke dashboard untuk melihat informasi terbaru.',
                'cta_label' => 'Buka Dashboard',
                'color' => '#1e5d87',
                'icon' => 'ℹ️',
            ],
        };
    }
}
