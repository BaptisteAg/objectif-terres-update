<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StorageDocumentsLink extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'storage:documents-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from "public/documents" to "storage/app/documents"';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        if (file_exists(public_path('documents'))) {
            $this->error('The "public/documents" directory already exists.');
        }

        if (is_link(public_path('documents'))) {
            $this->laravel->make('files')->delete(public_path('documents'));
        }

        $this->laravel->make('files')->link(
            storage_path('app/documents'), public_path('documents')
        );

        $this->info('The [public/documents] directory has been linked.');
    }
}
