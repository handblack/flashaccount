/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - db_flash
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/* Procedure structure for procedure `pax_rpt_bpartner_move` */

/*!50003 DROP PROCEDURE IF EXISTS  `pax_rpt_bpartner_move` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pax_rpt_bpartner_move`(
	IN p_session VARCHAR(60),
	IN p_dateinit DATE,
	IN p_dateend DATE,
	IN p_bpartner_id BIGINT
)
BEGIN
	select 0;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `pax_rpt_invoice_open_customers` */

/*!50003 DROP PROCEDURE IF EXISTS  `pax_rpt_invoice_open_customers` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pax_rpt_invoice_open_customers`(
	in p_session varchar(60),
	in p_datetrx DATE,
	IN p_bpartner_id bigint
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
												where
													i.dateinvoiced <= p_datetrx
													and bpartner_id LIKE case when p_bpartner_id = 0 theN '%' ELSE p_bpartner_id END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pax_rpt_invoice_open_supplier` */

/*!50003 DROP PROCEDURE IF EXISTS  `pax_rpt_invoice_open_supplier` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pax_rpt_invoice_open_supplier`(
	in p_session varchar(60),
	in p_datetrx DATE,
	IN p_bpartner_id bigint
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
												where
													i.dateinvoiced <= p_datetrx
													and bpartner_id LIKE case when p_bpartner_id = 0 theN '%' ELSE p_bpartner_id END;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
