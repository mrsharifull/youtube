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

class UploadVideoToSFTP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $temporaryVideo;
    protected $existingFilePath;

    public function __construct($temporaryVideo, $existingFilePath= false)
    {
        $this->temporaryVideo = $temporaryVideo;
        $this->existingFilePath = $existingFilePath;
    }

    public function handle()
    {
        $filesystem = Storage::disk('remote-sftp');
        // $filesystem->putFile("video/", Storage::disk('public')->path($this->temporaryVideo));
        $destinationDirectory = "video/";
        $localPath = Storage::disk('public')->path($this->temporaryVideo);
        $originalFilename = pathinfo($localPath, PATHINFO_BASENAME);
        $remotePath = $destinationDirectory . $originalFilename;
        $filesystem->put($remotePath, file_get_contents($localPath));
        if($this->existingFilePath != false){
            $filesystem->delete($this->existingFilePath);
        }
        Storage::disk('public')->delete($this->temporaryVideo);
    }
}
