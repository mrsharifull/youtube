<?php

use Illuminate\Support\Facades\Storage;

function sftpLink($path) {
    return env('REMOTE_SERVER_URL').$path;
}
function storage_link($path){
    return asset('storage/'.$path);
}








?>
