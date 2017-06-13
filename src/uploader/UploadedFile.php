<?php

namespace Arthur\Uploader;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadedFile extends Model
{
    /**
     * Define model table
     *
     * @var string
     */
    protected $table = 'uploaded_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_name',
        'original_name',
        'storage',
        'mime',
        'extension',
        'size',
    ];

    /**
     * @return string
     */
    public function getPath()
    {
        return storage_path('app/public/'.$this->getStoragePath());
    }

    /**
     * @return string
     */
    public function getStoragePath()
    {
        return $this->storage.DIRECTORY_SEPARATOR.$this->unique_name;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return asset('storage'.DIRECTORY_SEPARATOR.$this->storage.DIRECTORY_SEPARATOR.$this->unique_name);
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        switch ($this->extension){
            case 'pdf':
                return url(config('uploader.thumbnails.pdf'));
                break;
            case 'xls':
            case 'xlsx':
                return url(config('uploader.thumbnails.xls'));
                break;
            case 'doc':
            case 'docx':
                return url(config('uploader.thumbnails.doc'));
                break;
            default:
                return url(config('uploader.thumbnails.unknown'));
        }
    }
}