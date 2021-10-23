<?php
/**
 * (c) 2017 OpenTHC, Inc.
 * This file is part of OpenTHC API released under MIT License
 * SPDX-License-Identifier: GPL-3.0-only
 *
 */
function _draw_object_button($obj)
{
	ob_start();
?>
	<button class="btn btn-primary btn-download" id="exec-pull-<?= $obj ?>" type="button" value="<?= $obj ?>" title="Queue Download"><i class="fas fa-sync"></i> Fetch</button>
	<div class="btn-group">
	  <button class="btn btn-outline-secondary" disabled id="exec-download-<?= $obj ?>" name="a" type="submit" value="download-<?= $obj ?>-tsv"><i class="fas fa-download"></i> Download as TSV</button>
	  <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	  </button>
	  <ul class="dropdown-menu">
		<li><a class="download-option" data-format="xls" data-obj="<?= $obj ?>" href="#">as Excel/XLS</a></li>
		<li><a class="download-option" data-format="tsv" data-obj="<?= $obj ?>" href="#">as TSV</a></li>
		<li><a class="download-option" data-format="csv" data-obj="<?= $obj ?>" href="#">as CSV</a></li>
		<li><a class="download-option" data-format="json" data-obj="<?= $obj ?>" href="#">as JSON</a></li>
		<!-- <li><a class="download-option" data-format="xml" data-obj="<?= $obj ?>" href="#">as XML</a></li> -->
		<!-- <li role="separator" class="divider"></li> -->
		<!-- <li><a href="#"><i class="fas fa-sync"></i> Refresh</a></li> -->
	  </ul>
	</div>
<?php
	return ob_get_clean();
}

?>


<h1>OpenTHC :: Data Dumps</h1>

<form action="/ajax" autocomplete="off" method="post">
<div class="container">
<?php

$sql_file = sprintf('%s/%s.sqlite', APP_ROOT, $_SESSION['sql-hash']);
if ( ! is_file($sql_file)) {
	echo '<div class="alert alert-warning">No Database File Yet. Execute the <strong>FULL FETCH</strong></div>';
}

?>

<h2>Select the Downloads</h2>

<table class="table">
<tr>
	<td>License Data<br><small id="note-license"></small></td>
	<td>Vendor List, QA Labs and Third Party Transporters<br><?= $stat['license'] ?> Records</td>
	<td class="r"><?= _draw_object_button('license') ?></td>
</tr>

<tr>
	<td>Plant Data<br><small id="note-plants"></small></td>
	<td>Plants, Wet and Dry Collections (aka: Plant Derivatives)<br><?= $stat['plant'] ?> Plants / <?= $stat['plant_collect'] ?> Collections</td>
	<td class="r"><?= _draw_object_button('plants') ?></td>
</tr>

<tr>
	<td>Inventory Data<br><small id="note-inventory"></small></td>
	<td>Inventory, Adjustments</td>
	<td class="r"><?= _draw_object_button('inventory') ?></td>
</tr>

<tr>
	<td>QA Data<br><small id="note-lab_result"></small></td>
	<td>QA Samples and Results</td>
	<td class="r"><?= _draw_object_button('lab_result') ?></td>
</tr>

<tr>
	<td>Transfer Data<br><small id="note-b2b"></small></td>
	<td>Manifests, Manifest Stops and Manifest Items</td>
	<td class="r"><?= _draw_object_button('b2b') ?></td>
</tr>

<tr>
	<td>Retail Data<br><small id="note-b2c"></small></td>
	<td>All Retail Sales<br><?= $stat['b2c'] ?> Records</td>
	<td class="r"><?= _draw_object_button('b2c') ?></td>
</tr>

<tr>
	<td>Room Data<br><small id="note-rooms"></small></td>
	<td>The Plant and Inventory rooms</td>
	<td class="r"><?= _draw_object_button('rooms') ?></td>
</tr>

<tr>
	<td>Vehicle Data<br><small id="note-vehicles"></small></td>
	<td>All Vehicles</td>
	<td class="r"><?= _draw_object_button('vehicles') ?></td>
</tr>

<tr>
	<td>Everything!</td>
	<td>All Data as SQLite format.</td>
	<td class="r"><?= _draw_object_button('sqlite') ?></td>
</tr>

</table>

<div class="form-actions">
	<button class="btn btn-primary" name="a" type="submit" value="download-all"><i class="fas fa-sync"></i> Fetch All</button>
	<button class="btn btn-primary" name="a" type="submit" value="download-zip"><i class="fas fa-archive"></i> Download All as ZIP</button>
	<!-- <button class="btn btn-primary" name="a" type="submit" value="autopull-day"><i class="fas fa-history"></i> Refresh Every Day</button> -->
</div>

</div> <!-- /.container -->
</form>


<script>
function ping()
{
	var arg = {
		a: 'ping',
	};
	$.post('/ajax', arg, function(res, ret) {
		// _.forOwn(res.result, function(val, key) {
		// 	$('#note-' + key).html('Updated: ' + val.time);
		// 	$('#exec-pull-' + key).html('<i class="fas fa-sync"></i> Fetch');
		// 	$('#exec-download-' + key).removeAttr('disabled');
		// });
	});

}

$(function() {

	$('.btn-download').on('click', function() {

		var $btn = $(this);

		$btn.html('<i class="fas fa-sync fa-spin"></i>');

		var arg = {
			a: 'pull-data',
			item: $btn.val(),
		};

		$.post('/ajax', arg, function(res, ret) {
			$btn.html(res.data);
		});

	});

	$('.download-option').on('click', function() {

		var fmt = $(this).data('format');
		var obj = $(this).data('obj');
		var txt = $(this).text();

		var bid = '#exec-download-' + obj;
		var val = 'download-' + obj + '-' + fmt;

		$(bid).html('<i class="fas fa-download"></i> Download ' + txt);
		$(bid).val(val);

	});

	ping();

	setInterval(ping, 15000);

});
</script>
