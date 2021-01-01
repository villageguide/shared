<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'filepath',
        'extension'
    ];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attachment that owns the file.
     */
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    /**
     * Get the village that owns the file.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the care home that owns the file.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }

    /**
     * Get the operator that owns the file.
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * Get the operator that owns the file.
     */
    public function propertyPhoto()
    {
        return $this->belongsTo(PropertyPhoto::class);
    }

    /**
     *  Delete file in the storage
     */
    public function delete()
    {
        parent::delete();
        Storage::delete($this->filepath);
    }

    /**
     * Get the manager that owns the file.
     */
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }


    /**
     * Resize image for template
     * @param $width
     * @param $height
     *
     * @return mixed
     */
    public function resize($width, $height)
    {
        $hash = md5($width . $height);

        $filePathParts = explode('.'.$this->extension, $this->filepath);

        $resizedFilePath = sprintf('%s_%s.%s', $filePathParts[0], $hash, $this->extension);

        if (file_exists($resizedFilePath)) {
            return $resizedFilePath;
        }

        if (file_exists($this->filepath)) {
            Image::make($this->filepath)->fit($width, $height)->crop($width, $height)->save($resizedFilePath);
        }

        return $resizedFilePath;
    }

    /**
     * Resize image for template
     * @param $width
     * @param $height
     *
     * @return mixed
     */
    public function resizeVideo($width, $height)
    {
        $hash = md5($width . $height);

        $filePathParts = explode('.'.$this->extension, $this->filepath);

        $resizedFilePath = sprintf('%s_%s.%s', $filePathParts[0], $hash, $this->extension);

        if (file_exists($resizedFilePath)) {
            return $resizedFilePath;
        }

        if (file_exists($this->filepath)) {
            Image::make($this->filepath)->crop($width, $height)->save($resizedFilePath);
        }

        return $resizedFilePath;
    }

    /**
     * @param $width
     *
     * @return string
     */
    public function widen($width)
    {
        $hash = md5($width);

        $filePathParts = explode('.'.$this->extension, $this->filepath);
        $resizedFilePath = sprintf('%s_%s.%s', $filePathParts[0], $hash, $this->extension);

        if (file_exists($resizedFilePath)) {
            return $resizedFilePath;
        }

        if (file_exists($this->filepath)) {
            Image::make($this->filepath)->widen($width)->save($resizedFilePath);
        }

        return $resizedFilePath;
    }
}
