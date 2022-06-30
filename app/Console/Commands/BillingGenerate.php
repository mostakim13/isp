<?php

namespace App\Console\Commands;

use App\Helpers\Billing;
use Illuminate\Console\Command;

class BillingGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Is for Billing Generate';

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
     * @return int
     */
    public function handle()
    {
        $billing = new Billing();
        $billing->start();
        return "Billing Update successfully";
    }
}
