<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(50)->create();
        //\App\Models\WhCInvoice::factory(15)->create();
        //\App\Models\WhPInvoice::factory(5)->create();
        \App\Models\WhBpartner::factory(150)->create();
        \App\Models\WhWarehouse::factory(10)->create();
    }

    

}
