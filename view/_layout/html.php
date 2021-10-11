<?php
/*
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, width=device-width">
<meta name="application-name" content="OpenTHC Dump">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-TxKWSXbsweFt0o2WqfkfJRRNVaPdzXJ/YLqgStggBVRREXkwU7OKz+xXtqOU4u8+" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.openthc.com/bootstrap/4.4.1/bootstrap.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.openthc.com/css/www/0.0.2/www.css">
<title><?= strip_tags($data['Page']['title'] ?: 'OpenTHC') ?></title>
<style>
.auth-open-wrap {
	margin: 2vh auto 0 auto;
	max-width: 690px;
}
.auth-open-wrap .card {
	margin-bottom: 0.50rem;
}
</style>
</head>
<body>

<?= $this->block('menu-zero') ?>

<?= $this->body ?>

<?= $this->block('footer') ?>

<script src="https://cdn.openthc.com/jquery/3.4.1/jquery.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.openthc.com/jqueryui/1.12.1-custom/jquery-ui.min.js" integrity="sha256-ComsX7C0zMiJupTpYuHb0QYhmRDmTnuxzgAY+7rcFMc=" crossorigin="anonymous"></script>
<script src="https://cdn.openthc.com/bootstrap/4.4.1/bootstrap.js" integrity="sha256-OUFW7hFO0/r5aEGTQOz9F/aXQOt+TwqI1Z4fbVvww04=" crossorigin="anonymous"></script>
<?= $this->foot_script ?>
</body>
</html>
