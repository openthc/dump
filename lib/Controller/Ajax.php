<?php
/**
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 *
 * AJAX Controller
 */

namespace App\Controller;

class Ajax extends \OpenTHC\Controller\Base
{
	/**
	 * Extenders should implement this
	 */
	function __invoke($REQ, $RES, $ARG)
	{
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				// Cool
				break;
			case 'POST':
				return $this->post($RES);
		}

		return $RES->withJSON([
			'data' => []
			, 'meta' => []
		]);

	}

	/**
	 * POST Handler
	 */
	function post($RES)
	{
		switch ($_POST['a']) {
			case 'download-all':

				$cmd = [];
				$cmd[] = sprintf('%s/bin/download-leafdata.php', APP_ROOT);
				$cmd[] = sprintf('--license=%s', escapeshellarg($_SESSION['cre-auth']['license']));
				$cmd[] = sprintf('--license-key=%s', escapeshellarg($_SESSION['cre-auth']['license-key']));
				$cmd[] = sprintf('>%s/var/%s.log', APP_ROOT, $_SESSION['cre-auth']['license']);
				$cmd[] = '2>&1';
				$cmd[] = '&';
				$cmd = implode(' ', $cmd);
				$buf = shell_exec($cmd);

				// ([
				// 	'data' => [
				// 		'cmd' => $cmd
				// 		, 'out' => $buf
				// 	]
				// 	, 'meta' => []
				// ]);
				$_SESSION['download-live'] = true;

				return $RES->withRedirect('/home');

				break;

			case 'download-sql':

				header(sprintf('content-disposition: attachment; filename="%s.sqlite"', $_SESSION['cre-auth']['license']));
				header('content-type: application/x-sqlite3; charset=binary');

				readfile($_SESSION['sql-file']);

				exit(0);

			case 'download-zip':

				$sql_file = sprintf('%s/var/%s.sqlite', APP_ROOT, md5(sprintf('%s:%s', $_SESSION['cre-auth']['license'], $_SESSION['cre-auth']['license-key'])));
				$zip_file = sprintf('%s/var/%s.zip', APP_ROOT, md5(sprintf('%s:%s', $_SESSION['cre-auth']['license'], $_SESSION['cre-auth']['license-key'])));

				$cmd = implode(' ', [
					'/usr/bin/zip',
					'--junk-paths',
					$zip_file,
					$sql_file,
				]);
				$buf = shell_exec($cmd);

				header(sprintf('content-disposition: attachment; filename="%s.zip"', $_SESSION['cre-auth']['license']));
				header('content-length: ' . filesize($zip_file));
				header('content-type: application/zip; charset=binary');

				readfile($zip_file);

				exit(0);

			case 'ping':

				$download_live = false;
				$log_file = sprintf("%s/var/%s.log", APP_ROOT, $_SESSION['cre-auth']['license']);
				$cmd = sprintf('/usr/bin/tac %s | /usr/bin/head -n1', $log_file);
				$buf = shell_exec($cmd);
				if (preg_match('/^DONE: \w+/', $buf)) {
					$download_live = true;
				}

				return $RES->withJSON([
					'data' => [
						'download_live' => $download_live,
					]
					, 'meta' => []
				]);

		}
	}
}
