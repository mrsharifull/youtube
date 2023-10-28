<?php
namespace App\Http\Traits;

use App\Jobs\UploadVideoToSFTP;
use App\Jobs\UploadThumbnailToSFTP;

trait sftpVideo {



    public function upload_file_sftp($filesPaths){
        $temporaryVideo = $filesPaths['videoPath'];
        $temporaryThumbnail = $filesPaths['thumbnailPath'];
            UploadVideoToSFTP::dispatch($temporaryVideo);
            UploadThumbnailToSFTP::dispatch($temporaryThumbnail);

    }


}


?>
