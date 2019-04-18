<?php

namespace App\Traits;

use App\Models\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

trait FileTrait
{
    /**
     * @param $uploadFile
     * @param string $assetFolder
     * @param bool $isImage
     * @param int $widthRatio
     *
     * @return mixed
     */
    public function storeFile($uploadFile, $assetFolder, $isImage = false, $widthRatio = 1200)
    {
        $file       = new File();
        $randomName = Str::random(40) . '.' . $uploadFile->extension();

        if ($isImage) {
            $path = $this->imageResize($uploadFile, $assetFolder, $randomName, $widthRatio);
        } else {
            $path = $uploadFile->store(sprintf('assets/%s', $assetFolder));
        }

        $file->filename  = $uploadFile->getClientOriginalName();
        $file->title     = $uploadFile->getClientOriginalName();
        $file->filepath  = $path;
        $file->extension = $uploadFile->extension();
        $file->save();

        return $file->id;
    }


    /**
     * @param string $file
     * @param string $assetFolder
     * @param string $randomName
     * @param integer $widthRatio
     *
     * @return string
     */
    public function imageResize($file, $assetFolder, $randomName, $widthRatio = 1200)
    {
        $path = sprintf('assets/%s/%s', $assetFolder, $randomName);
        $img  = Image::make($file);
        $img->resize($widthRatio, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($path);

        return $path;
    }
}
