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
			'Page' => array('title' => 'Connect to OpenTHC')
		);

		switch ($_POST['a']) {
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

		$data['cre_list'] = \OpenTHC\CRE::getEngineList();
		$data['pipe_token'] = $_GET['pipe-token'];

		return $RES->write( $this->render('auth/open', $data) );

	}

}
