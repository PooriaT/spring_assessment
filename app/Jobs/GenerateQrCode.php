<?php

namespace App\Jobs;

use App\Models\Participant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateQRCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function handle(): void
    {
        // $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://www.google.com/maps/place/{$this->participant->address}";
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={$this->participant->address}";
        $qrCodeImage = file_get_contents($qrCodeUrl);

        $directory = 'public/qrImages/';
        Storage::makeDirectory($directory);

        $filename = Str::slug($this->participant->name) . '_qr.png';

        Storage::put($directory . $filename, $qrCodeImage);

        $this->participant->update(['qr_code_filename' => $filename]);
    }
}
