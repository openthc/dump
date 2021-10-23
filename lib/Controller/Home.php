<?php
/**
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 *
 * Home Controller
 */

namespace App\Controller;

class Home extends \OpenTHC\Controller\Base
{
	function __invoke($REQ, $RES, $ARG)
	{
		$data = array(
			'Page' => array('title' => 'Home'),
			'Pipe' => array('sid' => $_SESSION['pipe-token']),
		);

		// if (empty($_SESSION['pipe-token'])) {
			// return $this->render('home-empty', $data);
		// }

		// Determine Last Sync
		$data['Sync'] = array(
			'Object' => 'Time',
		);

		$sql_file = sprintf('%s/var/%09d/data.db', APP_ROOT, $_SESSION['ubi']);
		if (is_file($sql_file)) {
			$data['Sync']['complete'] = true;
		}

		return $this->render('home.php', $data);

	}

}
