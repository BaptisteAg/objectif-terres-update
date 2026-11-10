<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resize:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Storage::allFiles('documents');

        $bar = $this->output->createProgressBar(count($files));

        $bar->start();

        foreach ($files as $fileName) {

            try {
                $image = \Image::make(storage_path('app/'.$fileName));

                if ($image->getWidth() > 1600 || $image->getHeight() > 1600) {
                    $this->info('Resizing '.$fileName);
                    $resizedImage = $image->resize(1600, 1600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save();

                    $this->info('Old size : '.$this->readableBytes($image->filesize()).'. New size : '.$this->readableBytes($resizedImage->filesize()));
                }
            } catch (\Exception $e) {

            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
    }

    /**
     * Converts a long string of bytes into a readable format e.g KB, MB, GB, TB, YB
     *
     * @param {Int} num The number of bytes.
     */
    private function readableBytes($bytes)
    {
        $i = floor(log($bytes) / log(1024));

        $sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 .' '.$sizes[$i];
    }
}
