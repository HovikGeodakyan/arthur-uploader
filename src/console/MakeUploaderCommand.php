<?php

namespace Arthur\Uploader\Console;

use Illuminate\Console\Command;

class MakeUploaderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:uploader';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploader routes and controller';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        file_put_contents(
            app_path('Http/Controllers/UploadController.php'),
            file_get_contents(__DIR__.'/stubs/UploadController.stub')
        );

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/stubs/routes.stub'),
            FILE_APPEND
        );

        $this->info('Uploader controller and routes generated successfully.');
    }
}
