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
/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_bank_allocate_lines` */

DROP TABLE IF EXISTS `temp_bank_allocate_lines`;

CREATE TABLE `temp_bank_allocate_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `income_id` bigint(20) unsigned NOT NULL,
  `expense_id` bigint(20) unsigned NOT NULL,
  `cinvoice_id` bigint(20) unsigned NOT NULL,
  `pinvoice_id` bigint(20) unsigned NOT NULL,
  `allocate_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_bank_allocate_lines_allocate_id_foreign` (`allocate_id`),
  CONSTRAINT `temp_bank_allocate_lines_allocate_id_foreign` FOREIGN KEY (`allocate_id`) REFERENCES `temp_bank_allocates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_bank_allocates` */

DROP TABLE IF EXISTS `temp_bank_allocates`;

CREATE TABLE `temp_bank_allocates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `bankaccount_id` bigint(20) unsigned NOT NULL,
  `rate` double(8,2) NOT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_bank_expense_lines` */

DROP TABLE IF EXISTS `temp_bank_expense_lines`;

CREATE TABLE `temp_bank_expense_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned DEFAULT NULL,
  `income_id` bigint(20) unsigned DEFAULT NULL,
  `amount` double(12,5) NOT NULL DEFAULT 0.00000,
  `expense_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_bank_expense_lines_expense_id_foreign` (`expense_id`),
  CONSTRAINT `temp_bank_expense_lines_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `temp_bank_expenses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_bank_expenses` */

DROP TABLE IF EXISTS `temp_bank_expenses`;

CREATE TABLE `temp_bank_expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datetrx` date DEFAULT NULL,
  `bankaccount_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `bpartner_id` bigint(20) unsigned DEFAULT NULL,
  `paymentmethod_id` bigint(20) unsigned DEFAULT NULL,
  `rate` double NOT NULL DEFAULT 1,
  `documentno` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(12,5) DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_bank_income_lines` */

DROP TABLE IF EXISTS `temp_bank_income_lines`;

CREATE TABLE `temp_bank_income_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned DEFAULT NULL,
  `payment_id` bigint(20) unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetrx` date DEFAULT NULL,
  `datedue` date DEFAULT NULL,
  `amount` double(12,5) NOT NULL DEFAULT 0.00000,
  `income_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_bank_income_lines_income_id_foreign` (`income_id`),
  CONSTRAINT `temp_bank_income_lines_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `temp_bank_incomes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_bank_income_payments` */

DROP TABLE IF EXISTS `temp_bank_income_payments`;

CREATE TABLE `temp_bank_income_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datetrx` date DEFAULT NULL,
  `bankaccount_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `paymentmethod_id` bigint(20) unsigned NOT NULL,
  `rate` double NOT NULL DEFAULT 1,
  `documentno` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(12,5) NOT NULL,
  `amountreference` double(12,5) NOT NULL DEFAULT 0.00000,
  `income_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_bank_income_payments_income_id_foreign` (`income_id`),
  CONSTRAINT `temp_bank_income_payments_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `temp_bank_incomes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_bank_incomes` */

DROP TABLE IF EXISTS `temp_bank_incomes`;

CREATE TABLE `temp_bank_incomes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `datetrx` date NOT NULL,
  `amount` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountopen` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountanticipation` double(12,5) NOT NULL DEFAULT 0.00000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_headers` */

DROP TABLE IF EXISTS `temp_headers`;

CREATE TABLE `temp_headers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `sequence_id` bigint(20) unsigned NOT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `warehouse_id` bigint(20) unsigned DEFAULT NULL,
  `amountgrand` double(12,5) NOT NULL DEFAULT 0.00000,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetrx` date DEFAULT NULL,
  `dateacct` date DEFAULT NULL,
  `datedue` date DEFAULT NULL,
  `amount` double(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_invoice_opens` */

DROP TABLE IF EXISTS `temp_invoice_opens`;

CREATE TABLE `temp_invoice_opens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetrx` date NOT NULL,
  `datedue` date NOT NULL,
  `bpartner_id` bigint(20) unsigned DEFAULT NULL,
  `invoice_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `amount` double(12,5) NOT NULL,
  `amountopen` double(12,5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=897 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `temp_lines` */

DROP TABLE IF EXISTS `temp_lines`;

CREATE TABLE `temp_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `temp_id` bigint(20) unsigned DEFAULT NULL,
  `orderline_id` bigint(20) unsigned DEFAULT NULL,
  `session` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `typeproduct` enum('P','S') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'P',
  `typeoperation_id` bigint(20) unsigned DEFAULT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `tax_id` bigint(20) unsigned DEFAULT NULL,
  `um_id` bigint(20) unsigned DEFAULT NULL,
  `umname` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umshortname` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productcode` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` double(12,5) NOT NULL DEFAULT 0.00000,
  `priceunit` double(12,5) NOT NULL DEFAULT 0.00000,
  `priceunittax` double(12,5) DEFAULT 0.00000,
  `amountbase` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountexo` double(12,5) NOT NULL DEFAULT 0.00000,
  `amounttax` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountgrand` double(12,5) NOT NULL DEFAULT 0.00000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_allocate_lines` */

DROP TABLE IF EXISTS `wh_b_allocate_lines`;

CREATE TABLE `wh_b_allocate_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_allocates` */

DROP TABLE IF EXISTS `wh_b_allocates`;

CREATE TABLE `wh_b_allocates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_expense_lines` */

DROP TABLE IF EXISTS `wh_b_expense_lines`;

CREATE TABLE `wh_b_expense_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned DEFAULT NULL,
  `income_id` bigint(20) unsigned DEFAULT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `expense_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wh_b_expense_lines_expense_id_foreign` (`expense_id`),
  CONSTRAINT `wh_b_expense_lines_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `wh_b_expenses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_expense_payments` */

DROP TABLE IF EXISTS `wh_b_expense_payments`;

CREATE TABLE `wh_b_expense_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `expense_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wh_b_expense_payments_expense_id_foreign` (`expense_id`),
  CONSTRAINT `wh_b_expense_payments_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `wh_b_expenses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_expenses` */

DROP TABLE IF EXISTS `wh_b_expenses`;

CREATE TABLE `wh_b_expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datetrx` date NOT NULL,
  `bankaccount_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `paymentmethod_id` bigint(20) unsigned NOT NULL,
  `rate` double NOT NULL DEFAULT 1,
  `documentno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountopen` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountanticipation` double(12,5) NOT NULL DEFAULT 0.00000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_income_lines` */

DROP TABLE IF EXISTS `wh_b_income_lines`;

CREATE TABLE `wh_b_income_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned DEFAULT NULL,
  `payment_id` bigint(20) unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetrx` date DEFAULT NULL,
  `datedue` date DEFAULT NULL,
  `amount` double(12,5) NOT NULL DEFAULT 0.00000,
  `income_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wh_b_income_lines_income_id_foreign` (`income_id`),
  CONSTRAINT `wh_b_income_lines_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `wh_b_incomes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_income_payments` */

DROP TABLE IF EXISTS `wh_b_income_payments`;

CREATE TABLE `wh_b_income_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datetrx` date NOT NULL,
  `bankaccount_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `paymentmethod_id` bigint(20) unsigned NOT NULL,
  `rate` double NOT NULL DEFAULT 1,
  `documentno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountreference` double(12,5) NOT NULL DEFAULT 0.00000,
  `income_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wh_b_income_payments_income_id_foreign` (`income_id`),
  CONSTRAINT `wh_b_income_payments_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `wh_b_incomes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_b_incomes` */

DROP TABLE IF EXISTS `wh_b_incomes`;

CREATE TABLE `wh_b_incomes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datetrx` date NOT NULL,
  `bankaccount_id` bigint(20) unsigned NOT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `amount` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountopen` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountanticipation` double(12,5) NOT NULL DEFAULT 0.00000,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_bank_accounts` */

DROP TABLE IF EXISTS `wh_bank_accounts`;

CREATE TABLE `wh_bank_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint(20) unsigned NOT NULL,
  `accountno` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_bpartners` */

DROP TABLE IF EXISTS `wh_bpartners`;

CREATE TABLE `wh_bpartners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bpartnercode` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bpartnername` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wh_bpartners_bpartnercode_unique` (`bpartnercode`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_c_credit_lines` */

DROP TABLE IF EXISTS `wh_c_credit_lines`;

CREATE TABLE `wh_c_credit_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_c_credits` */

DROP TABLE IF EXISTS `wh_c_credits`;

CREATE TABLE `wh_c_credits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_c_invoice_lines` */

DROP TABLE IF EXISTS `wh_c_invoice_lines`;

CREATE TABLE `wh_c_invoice_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `typeproduct` enum('S','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `typeoperation_id` bigint(20) unsigned NOT NULL,
  `orderline_id` bigint(20) unsigned DEFAULT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `um_id` bigint(20) unsigned NOT NULL,
  `tax_id` bigint(20) unsigned NOT NULL,
  `quantity` double(12,5) NOT NULL DEFAULT 0.00000,
  `priceunit` double(12,5) NOT NULL DEFAULT 0.00000,
  `priceunittax` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountbase` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountexo` double(12,5) NOT NULL DEFAULT 0.00000,
  `amounttax` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountgrand` double(12,5) NOT NULL DEFAULT 0.00000,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wh_c_invoice_lines_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `wh_c_invoice_lines_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `wh_c_invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_c_invoices` */

DROP TABLE IF EXISTS `wh_c_invoices`;

CREATE TABLE `wh_c_invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dateinvoiced` date NOT NULL,
  `dateacct` date DEFAULT NULL,
  `datedue` date DEFAULT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `sequence_id` bigint(20) unsigned NOT NULL,
  `serial` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `documentno` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `warehouse_id` bigint(20) unsigned DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amountgrand` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountopen` double(12,5) NOT NULL DEFAULT 0.00000,
  `docstatus` enum('O','C') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'O',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_c_order_lines` */

DROP TABLE IF EXISTS `wh_c_order_lines`;

CREATE TABLE `wh_c_order_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `typeproduct` enum('S','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `typeoperation_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `um_id` bigint(20) unsigned NOT NULL,
  `tax_id` bigint(20) unsigned NOT NULL,
  `quantity` double(12,5) NOT NULL DEFAULT 0.00000,
  `priceunit` double(12,5) NOT NULL DEFAULT 0.00000,
  `priceunittax` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountbase` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountexo` double(12,5) NOT NULL DEFAULT 0.00000,
  `amounttax` double(12,5) NOT NULL DEFAULT 0.00000,
  `amountgrand` double(12,5) NOT NULL DEFAULT 0.00000,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wh_c_order_lines_order_id_foreign` (`order_id`),
  CONSTRAINT `wh_c_order_lines_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `wh_c_orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_c_orders` */

DROP TABLE IF EXISTS `wh_c_orders`;

CREATE TABLE `wh_c_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dateorder` date NOT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `sequence_id` bigint(20) unsigned NOT NULL,
  `serial` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `documentno` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `warehouse_id` bigint(20) unsigned DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(12,2) NOT NULL DEFAULT 0.00,
  `docstatus` enum('O','C','A') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'O',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_currencies` */

DROP TABLE IF EXISTS `wh_currencies`;

CREATE TABLE `wh_currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `currencyname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currencyiso` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `prefix` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wh_currencies_currencyiso_unique` (`currencyiso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_doc_types` */

DROP TABLE IF EXISTS `wh_doc_types`;

CREATE TABLE `wh_doc_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctypename` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctypecode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortname` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1,
  `group_id` bigint(20) unsigned DEFAULT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_families` */

DROP TABLE IF EXISTS `wh_families`;

CREATE TABLE `wh_families` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `familyname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_lines` */

DROP TABLE IF EXISTS `wh_lines`;

CREATE TABLE `wh_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `linename` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_p_invoices` */

DROP TABLE IF EXISTS `wh_p_invoices`;

CREATE TABLE `wh_p_invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dateinvoiced` date NOT NULL,
  `bpartner_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  `doctype_id` bigint(20) unsigned NOT NULL,
  `serial` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `documentno` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amountgrand` double(8,2) NOT NULL DEFAULT 0.00,
  `amountopen` double(8,2) NOT NULL DEFAULT 0.00,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_p_order_lines` */

DROP TABLE IF EXISTS `wh_p_order_lines`;

CREATE TABLE `wh_p_order_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_p_orders` */

DROP TABLE IF EXISTS `wh_p_orders`;

CREATE TABLE `wh_p_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_params` */

DROP TABLE IF EXISTS `wh_params`;

CREATE TABLE `wh_params` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identity` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `isrequired` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `isfixed` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `orden` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_products` */

DROP TABLE IF EXISTS `wh_products`;

CREATE TABLE `wh_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `productcode` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_id` bigint(20) unsigned NOT NULL,
  `line_id` bigint(20) unsigned NOT NULL,
  `um_id` bigint(20) unsigned NOT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wh_products_productcode_unique` (`productcode`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_sequences` */

DROP TABLE IF EXISTS `wh_sequences`;

CREATE TABLE `wh_sequences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctype_id` bigint(20) unsigned DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastnumber` int(11) NOT NULL DEFAULT 0,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `isdocref` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `isfex` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `warehouse_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_taxes` */

DROP TABLE IF EXISTS `wh_taxes`;

CREATE TABLE `wh_taxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `taxname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ratio` double(12,5) NOT NULL DEFAULT 0.00000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_team_grants` */

DROP TABLE IF EXISTS `wh_team_grants`;

CREATE TABLE `wh_team_grants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_id` bigint(20) unsigned NOT NULL,
  `isgrant` enum('Y','N','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `iscreate` enum('Y','N','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `isread` enum('Y','N','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `isupdate` enum('Y','N','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `isdelete` enum('Y','N','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `isactive` enum('Y','N','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_teams` */

DROP TABLE IF EXISTS `wh_teams`;

CREATE TABLE `wh_teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `teamname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_ums` */

DROP TABLE IF EXISTS `wh_ums`;

CREATE TABLE `wh_ums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `umname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_users` */

DROP TABLE IF EXISTS `wh_users`;

CREATE TABLE `wh_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_team_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `isadmin` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wh_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `wh_warehouses` */

DROP TABLE IF EXISTS `wh_warehouses`;

CREATE TABLE `wh_warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `warehousename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isactive` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* Procedure structure for procedure `pax_rpt_invoice_open_customers` */

/*!50003 DROP PROCEDURE IF EXISTS  `pax_rpt_invoice_open_customers` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pax_rpt_invoice_open_customers`(
	in p_session varchar(60),
	in p_datetrx DATE,
	IN p_bpartner_id bigint
)
BEGIN
	INSERT INTO `temp_invoice_opens`(`session`,datetrx,cinvoice_id,bpartner_id) SELECT 
													p_session
													,i.dateinvoiced
													,i.id
													,i.bpartner_id
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
