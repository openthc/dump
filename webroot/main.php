<?php
/**
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 *
 * Main Controller for dump.openthc
 */


require_once(dirname(dirname(__FILE__)) . '/boot.php');

// Slim Application
//$cfg = [];
$cfg['debug'] = true;
$app = new \OpenTHC\App($cfg);


// Authentication
$app->group('/auth', function() {

	$this->get('/open', 'App\Controller\Auth\Open');
	$this->post('/open', 'App\Controller\Auth\Open');

	$this->map(['GET', 'POST'], '/connect', 'OpenTHC\Controller\Auth\Connect');

	$this->get('/back', function($REQ, $RES) {
		return $RES->withRedirect('/home');
	});

	$this->get('/ping', 'OpenTHC\Controller\Auth\Ping');

	$this->get('/shut', 'OpenTHC\Controller\Auth\Shut');

})->add('OpenTHC\Middleware\Session');

$app->get('/home', 'App\Controller\Home')->add('OpenTHC\Middleware\Session');
$app->map([ 'GET', 'POST' ], '/ajax', 'App\Controller\Ajax')->add('OpenTHC\Middleware\Session');


$app->run();
