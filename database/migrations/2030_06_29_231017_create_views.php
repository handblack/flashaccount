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
$sql = "
DROP VIEW IF EXISTS v_rpt_kardex;
CREATE VIEW `v_rpt_kardex` AS
SELECT
`a`.`datetrx` AS `datetrx`,
`a`.`warehouse_id` AS `warehouse_id`,
`b`.`product_id` AS `product_id`,
`b`.`quantity` AS `quantity`
FROM
(
  `wh_l_inputs` `a`
  JOIN `wh_l_input_lines` `b`
    ON (`b`.`input_id` = `a`.`id`)
)
UNION
ALL
SELECT
`a1`.`datetrx` AS `datetrx`,
`a1`.`warehouse_id` AS `warehouse_id`,
`b1`.`product_id` AS `product_id`,
`b1`.`quantity` AS `quantity`
FROM
(
  `wh_l_transfers` `a1`
  JOIN `wh_l_transfer_lines` `b1`
    ON (`b1`.`transfer_id` = `a1`.`id`)
)
UNION
ALL
SELECT
`a2`.`datetrx` AS `datetrx`,
`a2`.`warehouse_id` AS `warehouse_id`,
`b2`.`product_id` AS `product_id`,
`b2`.`quantity` AS `quantity`
FROM
(
  `wh_l_inventories` `a2`
  JOIN `wh_l_inventory_lines` `b2`
    ON (`b2`.`inventory_id` = `a2`.`id`)
)
WHERE `a2`.`movetype` = 'I'
UNION
ALL
SELECT
`a3`.`datetrx` AS `datetrx`,
`a3`.`warehouse_id` AS `warehouse_id`,
`b3`.`product_id` AS `product_id`,
`b3`.`quantity` AS `quantity`
FROM
(
  `wh_l_inventories` `a3`
  JOIN `wh_l_inventory_lines` `b3`
    ON (`b3`.`inventory_id` = `a3`.`id`)
)
WHERE `a3`.`movetype` = 'O'
UNION
ALL
SELECT
`a4`.`datetrx` AS `datetrx`,
`a4`.`warehouse_to_id` AS `warehouse_id`,
`b4`.`product_id` AS `product_id`,
`b4`.`quantity` AS `quantity`
FROM
(
  `wh_l_transfers` `a4`
  JOIN `wh_l_transfer_lines` `b4`
    ON (`b4`.`transfer_id` = `a4`.`id`)
)
UNION
ALL
SELECT
`a5`.`datetrx` AS `datetrx`,
`a5`.`warehouse_id` AS `warehouse_id`,
`b5`.`product_id` AS `product_id`,
`b5`.`quantity` AS `quantity`
FROM
(
  `wh_l_outputs` `a5`
  JOIN `wh_l_output_lines` `b5`
    ON (`b5`.`output_id` = `a5`.`id`)
);


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
        DB::unprepared("DROP VIEW IF EXISTS v_rpt_bpartner_move;");
        DB::unprepared("DROP VIEW IF EXISTS v_rpt_kardex;");
    }
}
