<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DatabaseCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace local database with one from another server ( production usually )';

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
        $dumpName = 'databasecopy-'.date('YmdHis');

        $dumpScript = 'mysqldump '.
            config('database-copy.dump-opts').
            ' -B '.
            config('database-copy.remote.database.name').
            ' -h '.config('database-copy.remote.database.host').
            ' -u '.config('database-copy.remote.database.user').
            ' -P '.config('database-copy.remote.database.port').
            ' > /tmp/'.$dumpName.'.sql && '.
            'cd /tmp/ && '.
            'tar -czf '.$dumpName.'.tar.gz '.$dumpName.'.sql && '.
            'rm '.$dumpName.'.sql';

        $process = new Process([
            'ssh '.
            config('database-copy.remote.ssh.user').'@'.config('database-copy.remote.ssh.host').
            " -i '".config('database-copy.remote.ssh.private_key')."'",
        ]);
        $process->mustRun(function ($type, $buffer) {
            if ($type === Process::ERR) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }
}
