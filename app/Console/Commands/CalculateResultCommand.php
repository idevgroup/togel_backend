<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class CalculateResultCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:result {gamecode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate result by game';

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
       $getResult = DB::select('select calcProfit(25,80) as result')[0]->result;     
       $this->info('My Command Working !!! Thanks ='.$getResult );
       
      
    }
}
