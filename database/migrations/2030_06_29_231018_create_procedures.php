<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "      
        DROP PROCEDURE IF EXISTS `pax_rpt_invoice_open_customers`;        
        CREATE PROCEDURE `pax_rpt_invoice_open_customers`(
            IN p_session VARCHAR(60),
            IN p_datetrx DATE,
            IN p_bpartner_id BIGINT
        )
        BEGIN
            INSERT INTO `temp_invoice_opens`(`session`,datetrx,cinvoice_id,bpartner_id,amount,amountopen) SELECT 
                                                            p_session
                                                            ,i.dateinvoiced
                                                            ,i.id
                                                            ,i.bpartner_id
                                                            ,i.amountgrand
                                                            ,i.amountopen
                                                        FROM
                                                            `wh_c_invoices` i
                                                        WHERE
                                                            i.dateinvoiced <= p_datetrx
                                                            AND bpartner_id LIKE CASE WHEN p_bpartner_id = 0 THEN '%' ELSE p_bpartner_id END;
        END;              
        ";
        
        DB::unprepared($procedure);
$sql = "      
DROP PROCEDURE IF EXISTS `pax_update_amount`;        
CREATE PROCEDURE `pax_update_amount`(p_module VARCHAR(30),p_id BIGINT)
BEGIN
/*
	Actualiza los totales en los documentos (header)
*/
    IF p_module = 'invoice' THEN
        UPDATE wh_c_invoices a
        INNER JOIN (
            SELECT invoice_id,
                SUM(amountbase) AS tbase,
                SUM(amountexo) AS texo,
                SUM(amounttax) AS tigv,
                SUM(amountgrand) AS total
            FROM wh_c_invoice_lines 
            WHERE invoice_id = p_id 
            GROUP BY invoice_id
        ) b ON b.invoice_id = a.id
        SET 
            a.amountbase = IFNULL(b.tbase,0),
            a.amountexo = IFNULL(b.texo,0),
            a.amounttax = IFNULL(b.tigv,0),
            a.amountgrand = IFNULL(b.total,0)
        WHERE a.id = p_id;
        /*UPDATE wh_c_invoices SET 
            amountbase = ( SELECT SUM(IFNULL(amountbase,0)) FROM wh_c_invoice_lines WHERE invoice_id = p_id),
            amountexo = ( SELECT SUM(IFNULL(amountexo,0)) FROM wh_c_invoice_lines WHERE invoice_id = p_id),
            amounttax = ( SELECT SUM(IFNULL(amounttax,0)) FROM wh_c_invoice_lines WHERE invoice_id = p_id),
            amountgrand = ( SELECT SUM(IFNULL(amountgrand,0)) FROM wh_c_invoice_lines WHERE invoice_id = p_id),
            amountopen = amountgrand
        WHERE id = p_id;*/
    ELSEIF p_module = 'order' THEN
        UPDATE wh_c_orders SET 
            amountbase = ( SELECT SUM(amountbase) FROM wh_c_order_lines WHERE order_id = p_id),
            amountexo = ( SELECT SUM(amountexo) FROM wh_c_order_lines WHERE order_id = p_id),
            amounttax = ( SELECT SUM(amounttax) FROM wh_c_order_lines WHERE order_id = p_id),
            amountgrand = ( SELECT SUM(amountgrand) FROM wh_c_order_lines WHERE order_id = p_id),
            amountopen = amountgrand
        WHERE id = p_id;
    ELSEIF p_module = 'credit' THEN
        UPDATE wh_c_credits SET 
            amountbase = ( SELECT SUM(amountbase) FROM wh_c_credit_lines WHERE credit_id = p_id),
            amountexo = ( SELECT SUM(amountexo) FROM wh_c_credit_lines WHERE credit_id = p_id),
            amounttax = ( SELECT SUM(amounttax) FROM wh_c_credit_lines WHERE credit_id = p_id),
            amountgrand = ( SELECT SUM(amountgrand) FROM wh_c_credit_lines WHERE credit_id = p_id),
            amountopen = amountgrand
        WHERE id = p_id;    
    END IF;
END;              
";
DB::unprepared($sql);
        // ------------------------------------------------------------------------------------------------------------------------------------
        $sql = "
        DROP PROCEDURE IF EXISTS `pax_rpt_invoice_open_supplier`;
        CREATE PROCEDURE `pax_rpt_invoice_open_supplier`(
            IN p_session VARCHAR(60),
            IN p_datetrx DATE,
            IN p_bpartner_id BIGINT
        )
        BEGIN
        INSERT INTO `temp_invoice_opens`(`session`,datetrx,cinvoice_id,bpartner_id,amount,amountopen) SELECT 
                                                p_session
                                                ,i.dateinvoiced
                                                ,i.id
                                                ,i.bpartner_id
                                                ,i.amountgrand
                                                ,i.amountopen
                                            FROM
                                                `wh_c_invoices` i
                                            WHERE
                                                i.dateinvoiced <= p_datetrx
                                                AND bpartner_id LIKE CASE WHEN p_bpartner_id = 0 THEN '%' ELSE p_bpartner_id END;
        END;
        ";
        DB::unprepared($procedure);
        // ------------------------------------------------------------------------------------------------------------------------------------
        $sql = "
        DROP PROCEDURE IF EXISTS `pax_rpt_bpartner_move`;
        CREATE PROCEDURE `pax_rpt_bpartner_move`(
            IN p_session VARCHAR(60),
            IN p_dateinit DATE,
            IN p_dateend DATE,
            IN p_bpartner_id BIGINT
        )
        BEGIN
            SELECT 0;
        END;
        ";
        DB::unprepared($procedure);
// ------------------------------------------------------------------------------------------------------------------------------------        
 
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_rpt_invoice_open_customers`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_rpt_invoice_open_supplier`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_rpt_bpartner_move`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_update_amount`");
    }
}
