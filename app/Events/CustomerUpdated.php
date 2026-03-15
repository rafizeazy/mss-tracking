<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Ini kunci utamanya
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Wajib menambahkan "implements ShouldBroadcastNow" agar langsung terkirim ke Pusher detik itu juga
class CustomerUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        // Biarkan kosong. Kita hanya butuh event ini sebagai "Pelatuk" (Trigger)
        // agar komponen Livewire tahu ada perubahan dan segera me-refresh dirinya.
    }

    /**
     * Tentukan di saluran (channel) mana pengumuman ini disiarkan.
     */
    public function broadcastOn(): array
    {
        return [
            // Gunakan Channel biasa (publik) dengan nama 'mss-updates'
            new Channel('mss-updates'),
        ];
    }
}