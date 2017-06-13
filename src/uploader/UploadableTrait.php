<?php

namespace Arthur\Uploader;

trait UploadableTrait
{
    /**
     * @return mixed
     */
    public function getFile()
    {
        return UploadedFile::find($this->file_id);
    }
}