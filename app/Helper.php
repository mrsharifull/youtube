<?php

use Illuminate\Support\Facades\Storage;

function videoSftpLink($path) {
    return env('VIDEO_REMOTE_SERVER_URL').$path;
}
function imageSftpLink($path) {
    return env('IMAGE_REMOTE_SERVER_URL').$path;
}
function storage_link($path){
    return asset('storage/'.$path);
}








?>
