<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoOffDuty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-off-duty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto mark off duty all user if they forget to make off duty';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
