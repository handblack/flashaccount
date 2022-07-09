<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
$sql = "
CREATE TRIGGER `cinvoicelines_upate_amount` AFTER INSERT ON `wh_c_invoice_lines` 
FOR EACH ROW BEGIN
    CALL pax_update_amount('invoice',NEW.id);
END;
";    
#DB::unprepared($sql);
// ------------------------------------------------------------------------------------------------------------------------------------
$sql = "
CREATE TRIGGER `ccreditlines_update_amount` AFTER INSERT ON `wh_c_credit_lines` 
FOR EACH ROW BEGIN
    CALL pax_update_amount('credit',NEW.id);
END;
";    
#DB::unprepared($sql);
// ------------------------------------------------------------------------------------------------------------------------------------
$sql = "
CREATE TRIGGER `corderlines_update_amount` AFTER INSERT ON `wh_c_order_lines` 
FOR EACH ROW BEGIN
    CALL pax_update_amount('order',NEW.id);
END;
";    
#DB::unprepared($sql);
// ------------------------------------------------------------------------------------------------------------------------------------
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        #DB::unprepared("DROP TRIGGER `cinvoicelines_upate_amount`;");
        #DB::unprepared("DROP TRIGGER `ccreditlines_update_amount`;");
        #DB::unprepared("DROP TRIGGER `corderlines_update_amount`;");
    }
}
