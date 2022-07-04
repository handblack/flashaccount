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
CREATE TRIGGER `cinvoice_upate_amount` AFTER INSERT ON `wh_c_invoice_lines` 
FOR EACH ROW BEGIN
	UPDATE wh_c_invoices SET 
		amountbase = ( SELECT SUM(amountbase) FROM wh_c_invoice_lines WHERE invoice_id = NEW.invoice_id),
		amountexo = ( SELECT SUM(amountexo) FROM wh_c_invoice_lines WHERE invoice_id = NEW.invoice_id),
		amounttax = ( SELECT SUM(amounttax) FROM wh_c_invoice_lines WHERE invoice_id = NEW.invoice_id),
		amountgrand = ( SELECT SUM(amountgrand) FROM wh_c_invoice_lines WHERE invoice_id = NEW.invoice_id),
		amountopen = amountgrand
	WHERE id = NEW.invoice_id;
END;
";    
        DB::unprepared($sql);
        // ------------------------------------------------------------------------------------------------------------------------------------
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER `cinvoice_upate_amount`;");
    }
}
