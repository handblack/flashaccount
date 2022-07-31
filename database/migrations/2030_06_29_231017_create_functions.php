<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
$sql = "
DROP FUNCTION IF EXISTS `fn_cinvoice_open`;
CREATE  FUNCTION `fn_cinvoice_open`(p_id BIGINT,
												p_datetrx DATE 
											) RETURNS FLOAT
BEGIN
	DECLARE l_payment FLOAT;
	DECLARE l_amount FLOAT;
	SET l_amount = (SELECT amountgrand FROM wh_c_invoices WHERE id = p_id);
	SET l_payment =  (
						SELECT SUM(a.amount) 
						FROM wh_b_income_lines a
						INNER JOIN wh_b_incomes b ON ( b.id = a.income_id )
						WHERE a.invoice_id = p_id
						AND b.datetrx <= p_datetrx
					);		
	RETURN (l_amount - IFNULL(l_payment,0));

END;
";    
DB::unprepared($sql);
// ------------------------------------------------------------------------------------------------------------------------------------
$sql = "
DROP FUNCTION IF EXISTS `fn_income_open`;
CREATE  FUNCTION `fn_income_open`(p_id BIGINT,
												p_datetrx DATE 
											) RETURNS FLOAT
BEGIN
	DECLARE l_payment FLOAT;
	DECLARE l_amount FLOAT;
	SET l_amount = (SELECT amountgrand FROM wh_c_invoices WHERE id = p_id);
	SET l_payment =  (
						SELECT SUM(a.amount) 
						FROM wh_b_income_lines a
						INNER JOIN wh_b_incomes b ON ( b.id = a.income_id )
						WHERE a.invoice_id = p_id
						AND b.datetrx <= p_datetrx
					);		
	RETURN (l_amount - IFNULL(l_payment,0));

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
        DB::unprepared("DROP FUNCTION IF EXISTS `fn_cinvoice_open`;");
        #DB::unprepared("DROP TRIGGER `ccreditlines_update_amount`;");
        #DB::unprepared("DROP TRIGGER `corderlines_update_amount`;");
    }
}
