<?php

namespace App\Console\Commands;

use App\Services\ValidateInput;
use Illuminate\Console\Command;

class ChechPrime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:prime {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check prime number';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $number = $this->argument('number');
        if (ValidateInput::checkPrime($number)) {
            $this->info("$number is prime");
        } else {
            $this->info("$number is not prime");
        }        
        return Command::SUCCESS;
    }
}
