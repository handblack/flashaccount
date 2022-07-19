<?php

namespace Database\Seeders;

use App\Models\WhCOrder;
use App\Models\WhPOrder;
use Hashids\Hashids;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        \App\Models\WhBpartner::factory(150)->create();
        \App\Models\WhWarehouse::factory(25)->create();
        \App\Models\WhCOrder::factory(100)->create();
        \App\Models\WhCOrderLine::factory(300)->create();
        #\App\Models\WhCInvoice::factory(15)->create();
        #\App\Models\WhCInvoiceLine::factory(15)->create();
        \App\Models\WhPOrder::factory(100)->create();
        \App\Models\WhPOrderLine::factory(300)->create();
        #\App\Models\WhPInvoice::factory(5)->create();
        \App\Models\WhBIncome::factory(100)->create();
        

        // Corrigiendo valores de la CORDER
        $hash = new Hashids(env('APP_HASH','miasoftware'));
        $result = WhCOrder::all();
        foreach($result as $line){
            $line->token = $hash->encode($line->id);
            $line->save();
            DB::select('CALL pax_corder_actualiza_totales(?)',[$line->id]);
        }
        $result = WhPOrder::all();
        foreach($result as $line){
            $line->token = $hash->encode($line->id);
            $line->save();
            DB::select('CALL pax_porder_actualiza_totales(?)',[$line->id]);
        }


    }

    

}
