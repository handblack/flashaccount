<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
$sql = "
DROP VIEW IF EXISTS v_rpt_bpartner_move;
CREATE VIEW `v_rpt_bpartner_move` AS (
SELECT
	a.dateinvoiced AS datetrx,
  'cinvoice' AS typemove,
  a.id AS record_id,
  a.amountgrand AS cargo,
  0 AS abono
FROM `wh_c_invoices` a

UNION ALL

SELECT
a.datetrx,
'income' AS typemove,
a.id AS record_id,
0 AS cargo,
a.amount AS abono
FROM `wh_b_incomes` a
);";
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
        DB::unprepared("DROP VIEW IF EXISTS v_rpt_bpartner_move;");
    }
}
