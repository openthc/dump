<?php
/**
 *
 */

namespace App\Controller\Auth;

use Edoceo\Radix;
use Edoceo\Radix\Session;

class Open extends \OpenTHC\Controller\Auth\oAuth2
{
	function __invoke($REQ, $RES, $ARG)
	{
		$data = array(
			'Page' => array('title' => 'Connect to CRE')
		);

		$_SESSION['auth-form'] = $_POST;

		switch ($_POST['a']) {
		case 'auth-cre':
			return $this->connect($REQ, $RES, $ARG);
			break;
		case 'open':

			$_SESSION['pipe-token'] = $_POST['pipe-token'];
			$_SESSION['sql-hash'] = $_SESSION['pipe-token'];

			$cre = new \OpenTHC\RCE($_SESSION['pipe-token']);
			$res = $cre->ping();

			if ('success' == $res['status']) {
				return $RES->withRedirect('/home');
			}

			return $RES->withJSON($res, 500);

			break;

		case 'connect-auth':

			$p = $this->getProvider($ret);
			$url = $p->getAuthorizationUrl([
				'scope' => 'contact company profile cre',
			]);

			$_SESSION['oauth2-state'] = $p->getState();

			return $RES->withRedirect($url);

		}

		$data['cre_code'] = $_GET['cre'];
		$data['cre_list'] = \OpenTHC\CRE::getEngineList();
		// $_SESSION['auth-form']
		$data['company'] = $_SESSION['auth-form']['company'];
		$data['license'] = $_SESSION['auth-form']['license'];
		$data['license-key'] = $_SESSION['auth-form']['license-key'];

		$data['pipe_token'] = $_GET['pipe-token'];

		return $RES->write( $this->render('auth/open', $data) );

	}

	/**
	 * Connect
	 */
	function connect($REQ, $RES, $ARG)
	{
		//$RES = $this->validateCaptcha($RES);
		// if (200 != $RES->getStatusCode()) {
		// 	return $RES;
		// }

		$cre = $this->validateCRE();

		if (empty($cre)) {
			return $RES->withJson([
				'data' => null,
				'meta' => [ 'detail' => sprintf('Invalid CRE: "%s" [CAC#017]', strtolower(trim($_POST['cre']))) ],
			], 400);
		}

		$_SESSION['cre'] = $cre;
		$_SESSION['cre-auth'] = array();
		$_SESSION['sql-name'] = null;

		switch ($cre['engine']) {
		case 'biotrack':
			$RES = $this->connect_biotrack($RES);
			break;
		case 'leafdata':
			$RES = $this->connect_leafdata($RES);
			break;
		case 'metrc':
			$RES = $this->connect_metrc($RES);
			break;
		}

		if (200 != $RES->getStatusCode()) {
			return $RES;
		}

		return $RES->withRedirect('/data');

	}

	/**
	 *
	 */
	function connect_biotrack($RES)
	{

	}

	/**
	 *
	 */
	function connect_leafdata($RES)
	{
		$lic = trim($_POST['license']);
		$lic = strtoupper($lic);

		$key = trim($_POST['license-key']);

		if (!preg_match('/^(G|J|L|M|R|T)\w+$/', $lic)) {
			return $RES->withJSON(array(
				'meta' => [ 'detail' => 'Invalid License [CAO-209]' ],
			), 400);
		}

		if (empty($key)) {
			return $RES->withJSON(array(
				'meta' => [ 'detail' => 'Invalid API Key [CAO-216]' ],
			), 400);
		}

		$_SESSION['cre-auth'] = array(
			'license' => $lic,
			'license-key' => $key,
		);

		$cfg = array_merge($_SESSION['cre'], $_SESSION['cre-auth']);

		$cre = \OpenTHC\CRE::factory($cfg);
		$res = $cre->ping();

		if (empty($res)) {
			return $RES->withJSON(array(
				'meta' => [ 'detail' => 'Invalid License or API Key [CAO-239]' ],
			), 403);
		}

		// $_SESSION['sql-name'] = sprintf('openthc_bong_%s', md5($_SESSION['cre-auth']['license']));

		return $RES->withJSON([
			'data' => session_id(),
			'meta' => [],
		]);

	}

	/**
	 *
	 */
	function connect_metrc($RES)
	{

	}

	/**
	 * Validate the CRE
	 */
	private function validateCRE()
	{
		$cre_want = strtolower(trim($_POST['cre']));
		$cre_info = \OpenTHC\CRE::getEngine($cre_want);

		if (!empty($cre_info)) {
			return $cre_info;
		}

		return false;

	}

}
