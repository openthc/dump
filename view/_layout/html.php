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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.openthc.com/bootstrap/5.1.1/bootstrap.min.css" integrity="sha256-sAcc18zvMnaJZrNT4v8J0T4HqzEUiUTlVFgDIywjQek=" crossorigin="anonymous" referrerpolicy="no-referrer">
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

<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
<div class="container-fluid">

<a class="navbar-brand" href="/"><i class="fas fa-home"></i></a>

<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu0" aria-expanded="false" aria-controls="menu0">
	<span class="navbar-toggler-icon"></span>
</button>

<div class="navbar-collapse collapse" id="menu0">

</div>

</div>
</nav>

<main>
<?= $this->body ?>
</main>

<?= $this->block('footer') ?>

<script src="https://cdn.openthc.com/jquery/3.4.1/jquery.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.openthc.com/jqueryui/1.12.1-custom/jquery-ui.min.js" integrity="sha256-ComsX7C0zMiJupTpYuHb0QYhmRDmTnuxzgAY+7rcFMc=" crossorigin="anonymous"></script>
<script src="https://cdn.openthc.com/bootstrap/5.1.1/bootstrap.min.js" integrity="sha256-/hGxZHGQ57fXLp+NDusFZsZo/PG21Bp2+hXYV5a6w+g=" crossorigin="anonymous"></script>
<?= $this->foot_script ?>
</body>
</html>
