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
    protected $fileName;
    protected $temporaryFilePath;

    public function __construct($fileName, $temporaryFilePath)
    {
        $this->fileName = $fileName;
        $this->temporaryFilePath = $temporaryFilePath;
    }

    public function handle()
    {
        // $fileContent = Storage::disk('public')->get($this->temporaryFilePath);
        // Upload the file to the SFTP server
        $filesystem = Storage::disk('remote-sftp');
        $filesystem->put("video/" . $this->fileName, Storage::disk('public')->path($this->temporaryFilePath), 'public');

        // Delete the temporary file
        Storage::disk('public')->delete($this->temporaryFilePath);
    }
}
