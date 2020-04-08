<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Client::class,1000)->create();
    }
}
