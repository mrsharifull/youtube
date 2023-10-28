<?php

use Illuminate\Support\Facades\Storage;

function sftpLink($path) {
    $disk = 'remote-sftp';
    if (Storage::disk($disk)->exists($path)) {
        return Storage::disk($disk)->url($path);
    }

    return null;
}








?>
