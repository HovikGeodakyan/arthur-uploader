<?php

namespace Arthur\Uploader;

use Illuminate\Http\UploadedFile;
use Arthur\Uploader\UploadedFile as File;
use Illuminate\Support\Facades\Storage;

class Uploader
{
    /**
     * @var
     */
    private $file;

    /**
     * @var mixed
     */
    private $storage;

    /**
     * @var
     */
    private $unique_name;

    /**
     * Uploader constructor.
     */
    public function __construct()
    {
        $this->storage = config('uploader.storage');
    }

    /**
     * @param UploadedFile $file
     * @return array
     */
    public function upload(UploadedFile $file)
    {
        $this->file = $file;

        $this->generateUniqueName();

        return $this->transform($this->storeFile());
    }

    /**
     * Store file in storage and return uploaded file object
     *
     * @return mixed
     */
    private function storeFile()
    {
        if(!$this->file || !($this->file instanceof UploadedFile)){
            throw new \RuntimeException('File object has not been created');
        }

        if(!$this->file->isValid()){
            throw new \RuntimeException($this->file->getErrorMessage());
        }

        if(!$this->file->storeAs($this->storage, $this->unique_name)){
            throw new \RuntimeException('Failed to save file in storage');
        }

        return File::create($this->prepare($this->file));
    }

    /**
     * Generate storage unique name
     */
    private function generateUniqueName()
    {
        $this->unique_name = uniqid().'.'.$this->file->getClientOriginalExtension();
    }

    /**
     * @return array
     */
    private function prepare()
    {
        return [
            'unique_name' => $this->unique_name,
            'storage' => $this->storage,
            'original_name' => $this->file->getClientOriginalName(),
            'mime' => $this->file->getClientMimeType(),
            'extension' => $this->file->getClientOriginalExtension(),
            'size' => $this->file->getClientSize(),
        ];
    }

    /**
     * @param \Arthur\Uploader\UploadedFile $file
     * @return array
     */
    public function transform(File $file)
    {
        $transformed = $file->toArray();

        $transformed['url'] = $file->getUrl();
        $transformed['thumbnail'] = $file->getThumbnail();

        return $transformed;
    }

    /**
     * @param \Arthur\Uploader\UploadedFile $file
     * @param $storage
     * @return bool
     */
    public function moveFile(File $file, $storage)
    {
        Storage::move($file->storage.'/'.$file->unique_name, $storage.'/'.$file->unique_name);

        $file->storage = $storage;

        return $file->save();
    }

    /**
     * @param \Arthur\Uploader\UploadedFile $file
     * @return bool|null
     */
    public function removeFile(File $file)
    {
        return Storage::delete($file->storage.'/'.$file->unique_name);
    }
}