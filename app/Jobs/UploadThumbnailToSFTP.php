<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use phpseclib\Net\SFTP;

class UploadThumbnailToSFTP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $fileName;
    protected $temporaryFilePath;
    protected $existingFilePath;

    public function __construct($fileName, $temporaryFilePath, $existingFilePath= false)
    {
        $this->fileName = $fileName;
        $this->temporaryFilePath = $temporaryFilePath;
        $this->existingFilePath = $existingFilePath;
    }

    public function handle()
    {
        $filesystem = Storage::disk('remote-sftp');
        $filesystem->put("thumbnail/" . $this->fileName, Storage::disk('public')->path($this->temporaryFilePath), 'public');
        if($this->existingFilePath != false){
            $filesystem->delete($this->existingFilePath);
        }
        Storage::disk('public')->delete($this->temporaryFilePath);
    }
}
