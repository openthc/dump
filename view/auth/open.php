<?php
/**
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 *
 * Authenticate
 */

?>

<form autocomplete="off" method="post">
<div class="auth-open-wrap">


	<?php
	require_once(__DIR__ . '/open-cre.php');
	?>


	<div class="card">
		<h2 class="card-header">OpenTHC Account</h2>
		<div class="card-body">
			<p>If you have an OpenTHC Account you should sign-in with that.</p>
		</div>
		<div class="card-footer">
			<button class="btn btn-primary" name="a" type="submit" value="connect-auth">Connect</button>
		</div>
	</div>


	<!--
	<div class="card">
		<h2 class="card-header">Pipe Key</h2>
		<div class="card-body">
			<h4>Connection Key</h4>
			<p>Once the Pipe service has connected it will share a key to use here</p>
			<form method="post">
			<div class="input-group">
				<input class="form-control"name="pipe-token" value="<?= h($data['pipe_token']) ?>">
				<div class="input-group-append">
					<button class="btn btn-outline-primary" name="a" type="submit" value="open">Go</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	-->

</div> <!-- /.auth-wrap -->
</form>


