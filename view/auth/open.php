<?php
/**
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 *
 * Authenticate
 */

?>

<form method="post">
<div class="container mt-4">

<div class="row card-wrap mb-4 justify-content-center">
	<div class="col-md-6">
	<div class="card">
		<div class="card-header">OpenTHC Account</div>
		<div class="card-body">
			<p>If you have an OpenTHC Account you should sign-in with that.</p>
			<button class="btn btn-primary" name="a" type="submit" value="connect-auth">Connect</button>
		</div>
	</div>
	</div>
</div>


<div class="row card-wrap justify-content-center">

	<div class="col-md-6">
	<div class="card">
		<div class="card-header">Pipe Key</div>
		<div class="card-body">
			<h4>Connection Key</h4>
			<p>Once the Pipe service has connected it will share a key to use here</p>
			<form method="post">
			<div class="input-group">
				<input class="form-control"name="pipe-token" value="{{ pipe_token }}">
				<div class="input-group-append">
					<button class="btn btn-outline-primary" name="a" type="submit" value="open">Go</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	</div>

</div>


</div> <!-- /.container -->
</form>
