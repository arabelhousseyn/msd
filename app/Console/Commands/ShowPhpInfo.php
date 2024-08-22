<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowPhpInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'php:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         ob_start();

        // Execute phpinfo()
        phpinfo();

        // Get the content of the output buffer
        $phpinfo = ob_get_clean();

        // Display the phpinfo content as text in the terminal
        $this->line(strip_tags($phpinfo));
    }
}
