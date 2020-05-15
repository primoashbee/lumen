<?php

namespace App\Console\Commands;

use App\DepositAccount;
use Illuminate\Console\Command;

class PostInterestOnDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit:post_interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post the accrued interest for all of the accounts';

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

        $this->info('Starting....');
        $list = DepositAccount::listForInterestPosting();

        $list->map(function($item){
            $item->postInterest();
        });

        $this->info('Done....');

    }
}
