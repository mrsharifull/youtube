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
    protected $temporaryThumbnail;
    protected $existingFilePath;

    public function __construct($temporaryThumbnail, $existingFilePath= false)
    {
        $this->temporaryThumbnail = $temporaryThumbnail;
        $this->existingFilePath = $existingFilePath;
    }

    public function handle()
    {
        $filesystem = Storage::disk('remote-sftp');
        // $filesystem->putFile("thumbnail/", Storage::disk('public')->path($this->temporaryThumbnail));
        $destinationDirectory = "thumbnail/";

        $localPath = Storage::disk('public')->path($this->temporaryThumbnail);
        $originalFilename = pathinfo($localPath, PATHINFO_BASENAME);
        $remotePath = $destinationDirectory . $originalFilename;
        $filesystem->put($remotePath, file_get_contents($localPath));

        if($this->existingFilePath != false){
            $filesystem->delete($this->existingFilePath);
        }
        Storage::disk('public')->delete($this->temporaryThumbnail);
    }
}
