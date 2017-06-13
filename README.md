#Uploader

This package provides a flexible way to upload file in Laravel application

##Installation

1. Add this `"arthur/uploader": "dev-master"` package to the list of required packages, inside `composer.json`

2. Go to `app/config/app.php`

  * add to providers `'Arthur\Uploader\UploaderServiceProvider'`
  * add to aliases `'Uploader' => 'Arthur\Uploader\Uploader'`

3. Run `composer update`

4. Run `php artisan vendor:publish` to publish `uploader.php` config file

5. Run `php artisan migrate` to create `uploaded_files` table

6. Run `php artisan make:uploader` to create `UploaderController.php` in `app\Http\Controllers` folder with already existing upload logic, and upload route in `routes/web.php` file

You can now access Uploader with the `Uploader` alias.

##Simple example
```php
Uploader::upload($file);
```

#Functions

##upload($file)

$file should be instance of `Illuminate\Http\UploadedFile` and will return object instanceof `Arthur\Uploader\UploadedFile`.

##transform($file)

$file should be instance of `Arthur\Uploader\UploadedFile` and will return array with all information about uploaded file including thumbnail url according to `uploader.php` config file.

##moveFile($file, $storage)

$file should be instance of `Arthur\Uploader\UploadedFile`, $storage is related path to your storage folder. This will move file to another storage directory and update file storage field in uploaded_table

##removeFile($file)

$file should be instance of `Arthur\Uploader\UploadedFile` and will remove file from storage,