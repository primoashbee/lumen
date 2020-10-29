<?php

namespace App\Console\Commands;

use App\LoanAccount;
use Illuminate\Console\Command;

class RecalculateLoanDues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate loan dues based on the current date. Call this command on 12mn';

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
        // $accounts = LoanAccount::all();
      
        $total = LoanAccount::active()->count();

        $accounts = LoanAccount::limit(500)->offset(0);
        
        foreach($accounts->chunk(100) as $chunk){
            foreach ($chunk as $item) {
                $item->updateDueInstallments();
                $item->updateStatus();
                
            }
        }
        return $this->info('Done');
    }
}
