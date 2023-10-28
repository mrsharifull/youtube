<?php

use Illuminate\Support\Facades\Storage;

function sftpLink($path) {
    $disk = 'remote-sftp';
    // dd(Storage::disk($disk)->exists($path));
    if (Storage::disk($disk)->exists($path)) {
        return Storage::disk($disk)->url($path);
    }

    return "null";
}








?>
