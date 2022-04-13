<?php

namespace App\Services;


class UploadFile {

    public static function image($file) {
        $imageFile = '/images/'. 'wisata_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $imageFile);

        return $imageFile;
    }
}