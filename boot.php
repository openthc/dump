<?php
/**
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 *
 * Bootstrap dump.openthc
 */

use Edoceo\Radix\DB\SQL;

define('APP_NAME', 'OpenTHC | Dump');
define('APP_ROOT', __DIR__);
define('APP_BUILD', '420.18.245');

error_reporting(E_ALL & ~ E_NOTICE);

openlog('openthc-dump', LOG_ODELAY|LOG_PID, LOG_LOCAL0);

require_once(APP_ROOT . '/vendor/autoload.php');

\OpenTHC\Config::init(__DIR__);


function is_valid_session()
{
	return !empty($_SESSION['cre']);
}

//SQL::init(sprintf('sqlite:%s/var/dump.db', APP_ROOT));
//SQL::query('DROP TABLE dump_task');
//SQL::query('CREATE TABLE dump_task (created_at, hash, contact, meta)');
//SQL::query('CREATE TABLE dump_done (created_at, contact)');

function _format_column($col, $val)
{
	switch ($col) {
	//case '_kind':
	//case 'address1':
	//case 'address2':
	//case 'city':
	//case 'converted':
	//case 'curecollect':
	//case 'currentroom':
	//case 'deleted':
	//case 'harvestcollect':
	//case 'harvestscheduled':
	//case 'id':
	//case 'in_process':
	//case 'inventoryid':
	//case 'inventoryparentid':
	//case 'inventorystatus':
	//case 'inventorytype':
	//case 'is_medical':
	//case 'is_sample':
	//case 'lab_license':
	//case 'location':
	//case 'locationtype':
	//case 'medical':
	//case 'mother':
	//case 'name':
	//case 'net_package':
	//case 'parentid':
	//case 'plantid':
	//case 'processor':
	//case 'producer':
	//case 'productname':
	//case 'quantity':
	//case 'remaining_quantity':
	//case 'removereason':
	//case 'removescheduled':
	//case 'retail':
	//case 'result':
	//case 'room':
	//case 'sample_use':
	//case 'seized':
	//case 'source_id':
	//case 'state':
	//case 'strain':
	//case 'transactionid':
	//case 'transactionid_original':
	//case 'ubi':
	//case 'usable_weight':
	//case 'wet':
	//case 'zip':
	//	break;
	case 'completion_date':
	case 'deletetime':
	case 'harvestscheduletime':
	case 'inventorystatustime':
	case 'removescheduletime':
	case 'sessiontime':
		if (empty($val)) {
			$val = '-';
		} else {
			$val = strftime('%Y-%m-%d %H:%M:%S', $val);
		}
		break;
	//default:
	//	die("col:$col\n");
	}

	return $val;

}
