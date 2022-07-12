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
$sql = "      
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
DB::unprepared($sql);
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$sql = "      
DROP PROCEDURE IF EXISTS `pax_cinvoice_actualiza_saldos`;        
CREATE PROCEDURE `pax_cinvoice_actualiza_saldos`(p_id BIGINT)
BEGIN
    DECLARE l_total_payment DOUBLE(12,5);
    DECLARE l_total_income DOUBLE(12,5);
    SET l_total_income = ( 
                                SELECT SUM(amount)
                                FROM `wh_b_income_lines`
                                WHERE invoice_id = p_id
                            );
    SET l_total_payment = (
                                SELECT SUM(amount)
                                FROM `wh_b_allocate_lines`
                                WHERE cinvoice_id = p_id
                            );
    /* Actualizando SALDO */
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
        a.amountgrand = IFNULL(b.total,0),
        a.amountopen = IFNULL(b.total,0) - (IFNULL(l_total_payment,0) + IFNULL(l_total_income,0))
    WHERE a.id = p_id;
END;              
";
DB::unprepared($sql);
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$sql = "      
DROP PROCEDURE IF EXISTS `pax_bank_income_actualiza_saldos`;        
CREATE PROCEDURE `pax_bank_income_actualiza_saldos`(p_id BIGINT)
BEGIN
    DECLARE total_income DOUBLE(12,5); 
    DECLARE total_allocate DOUBLE(12,5);
    SET total_income = (
                            SELECT SUM(amount)
                            FROM `wh_b_income_lines`
                            WHERE income_id = p_id
                            GROUP BY income_id
                        );
    SET total_allocate = (
                            SELECT SUM(amount) AS total
                            FROM `wh_b_allocate_payments` 
                            WHERE income_id = p_id 
                            GROUP BY income_id
                        );
    UPDATE `wh_b_incomes` a
    SET a.amountopen = IFNULL(a.amount,0) - (IFNULL(total_income,0) + IFNULL(total_allocate,0))
    WHERE a.id = p_id;
END;              
";
DB::unprepared($sql);
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$sql = "      
DROP PROCEDURE IF EXISTS `pax_bank_expense_actualiza_saldos`;        
CREATE PROCEDURE `pax_bank_expense_actualiza_saldos`(p_id BIGINT)
BEGIN
    SELECT 0;
END;              
";
DB::unprepared($sql);
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$sql = "      
DROP PROCEDURE IF EXISTS `pax_cinvoice_actualiza_totales`;        
CREATE PROCEDURE `pax_cinvoice_actualiza_totales`(p_id BIGINT)
BEGIN
/*
    Aqui se debe de modificar para que busque saldos de pagos
*/
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
        a.amountgrand = IFNULL(b.total,0),
        a.amountopen = IFNULL(b.total,0)
    WHERE a.id = p_id;
    
END;              
";
DB::unprepared($sql);
// ---------------------------------------------------------------------------------------------------------------------------------------------------
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
            a.amountgrand = IFNULL(b.total,0),
            a.amountopen = IFNULL(b.total,0)
        WHERE a.id = p_id;
    ELSEIF p_module = 'order' THEN
        UPDATE wh_c_orders a
        INNER JOIN (
            SELECT order_id,
                SUM(amountbase) AS tbase,
                SUM(amountexo) AS texo,
                SUM(amounttax) AS tigv,
                SUM(amountgrand) AS total
            FROM wh_c_order_lines 
            WHERE order_id = p_id 
            GROUP BY order_id
        ) b ON b.order_id = a.id
        SET 
            a.amountbase = IFNULL(b.tbase,0),
            a.amountexo = IFNULL(b.texo,0),
            a.amounttax = IFNULL(b.tigv,0),
            a.amountgrand = IFNULL(b.total,0)
        WHERE a.id = p_id;
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
        DB::unprepared($sql);
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
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_bank_expense_actualiza_saldos`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_bank_income_actualiza_saldos`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_cinvoice_actualiza_saldos`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_cinvoice_actualiza_totales`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_rpt_invoice_open_customers`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_rpt_invoice_open_supplier`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_rpt_bpartner_move`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `pax_update_amount`");
    }
}
