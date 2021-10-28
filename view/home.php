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
	  <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	  </button>
	  <ul class="dropdown-menu">
		<li><a class="download-option" data-format="xls" data-obj="<?= $obj ?>" href="#">as Excel/XLS</a></li>
		<li><a class="download-option" data-format="tsv" data-obj="<?= $obj ?>" href="#">as TSV</a></li>
		<li><a class="download-option" data-format="csv" data-obj="<?= $obj ?>" href="#">as CSV</a></li>
		<li><a class="download-option" data-format="json" data-obj="<?= $obj ?>" href="#">as JSON</a></li>
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
if ( ! empty($_SESSION['download-live'])) {
	echo '<div class="alert alert-success">Download is running...</div>';
	unset($_SESSION['download-live']);
} elseif ( ! empty($_SESSION['sql-file']) && ! is_file($_SESSION['sql-file'])) {
	echo '<div class="alert alert-warning">No Database File Yet. Execute <strong>FETCH ALL</strong></div>';
}
echo <<<HTML
<div class="alert alert-success" id="download-live" style="display: none;">Download is ready. Choose format to <strong>Download All</strong>
</div>
HTML;

?>

<h2>Select the Downloads</h2>

<table class="table">
<tr>
	<td>License Data<br><small id="note-license"></small></td>
	<td>Vendor List, QA Labs and Third Party Transporters</td>
	<td class="r"><?= _draw_object_button('license') ?></td>
</tr>

<tr>
	<td>Plant Data<br><small id="note-plants"></small></td>
	<td>Plants, Wet and Dry Collections (aka: Plant Derivatives)</td>
	<td class="r"><?= _draw_object_button('plants') ?></td>
</tr>

<tr>
	<td>Inventory Data</td>
	<td>Inventory, Adjustments</td>
	<td class="r"><?= _draw_object_button('inventory') ?></td>
</tr>

<tr>
	<td>Lab Result Data</td>
	<td>Lab Samples and Results</td>
	<td class="r"><?= _draw_object_button('lab_result') ?></td>
</tr>

<tr>
	<td>Transfer Data</td>
	<td>Manifests, Manifest Stops and Manifest Items</td>
	<td class="r"><?= _draw_object_button('b2b') ?></td>
</tr>

<tr>
	<td>Retail Data</td>
	<td>All Retail Sales</td>
	<td class="r"><?= _draw_object_button('b2c') ?></td>
</tr>

<tr>
	<td>Section Data</td>
	<td>The Plant and Inventory rooms</td>
	<td class="r"><?= _draw_object_button('rooms') ?></td>
</tr>

<tr>
	<td>Vehicle Data</td>
	<td>All Vehicles</td>
	<td class="r"><?= _draw_object_button('vehicles') ?></td>
</tr>

</table>

<div class="form-actions">
	<button class="btn btn-primary" name="a" type="submit" value="download-all"><i class="fas fa-sync"></i> Fetch All</button>
	<button class="btn btn-outline-primary" name="a" type="submit" value="download-zip"><i class="fas fa-archive"></i> Download All as ZIP</button>
	<button class="btn btn-outline-primary" name="a" type="submit" value="download-sql"><i class="fas fa-archive"></i> Download All as Sqlite</button>
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
		if (res.data.download_live) {
			$(".container .alert").hide();
			$("#download-live").show();
		}
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
