#!/usr/bin/php
<?php
/**
 * LeafData
 */

/*
// area
// batch
disposal
// inventory_type
// inventory
// inventory_adjustment
// inventory_transfer
// lab_result
mme
// plant
sale
// strain
users
*/

use Edoceo\Radix\DB\SQL;

require_once(dirname(dirname(__FILE__)) . '/boot.php');

$t0 = time();

$opt = getopt('', [
	'license:'
	, 'license-key:'
]);

$_ENV['license'] = $opt['license'];
$_ENV['license-key'] = $opt['license-key'];

printf("INIT: %s at %s\n", $_ENV['license'], date(\DateTime::ISO8601, $t0));

// $output_path = sprintf('%s/var/%s', APP_ROOT, $_ENV['license']);
// if (!is_dir($output_path)) {
// 	mkdir($output_path, 0755, true);
// }

// $sql_file = sprintf('%s/var/%s.sqlite', APP_ROOT, $_ENV['license']);
$sql_file = sprintf('%s/var/%s.sqlite', APP_ROOT, md5(sprintf('%s:%s', $_ENV['license'], $_ENV['license-key'])));
$sql_good = is_file($sql_file);

$dbc = new SQL(sprintf('sqlite:%s', $sql_file));
if ( ! $sql_good) {

	$dbc->query('CREATE TABLE section (id, meta)');
	$dbc->query('CREATE TABLE product (id, meta)');
	$dbc->query('CREATE TABLE variety (id, meta)');
	// $dbc->query('CREATE TABLE batch (id, meta)');
	$dbc->query('CREATE TABLE crop (id, meta)');
	$dbc->query('CREATE TABLE lot (id, meta)');
	// $dbc->query('CREATE TABLE lot_adjust (id, meta)');
	$dbc->query('CREATE TABLE lab_result (id, meta)');
	$dbc->query('CREATE TABLE b2b (id, meta)');
	$dbc->query('CREATE TABLE b2b_item (id, b2b_id, meta)');
	$dbc->query('CREATE TABLE b2c (id, meta)');
	$dbc->query('CREATE TABLE b2c_item (id, b2c_id, meta)');

}

$tab_list = [
	'/areas' => 'section'
	, '/strains' => 'variety'
	, '/inventory_types' => 'product'
	// , '/batches' => 'batch'
	, '/plants' => 'crop'
	, '/inventories' => 'lot'
	// , '/inventory_adjustments' => 'lot_adjust',
	, '/lab_results' => 'lab_result'
	, '/inventory_transfers' => 'b2b'
	// , '/' => 'b2b_item'
	, '/sales' => 'b2c'
	// , '/' => 'b2c_item'
];


foreach ($tab_list as $tab_source => $tab_output) {

	// Area
	$idx = 0;
	$max = 1;
	do {

		$idx++;

		$res = _leafdata_get($tab_source, [
			'page' => $idx
			, '_page_max' => $max
		]);

		foreach ($res['data'] as $rec) {
			$dbc->insert($tab_output, [
				'id' => $rec['global_id']
				, 'meta' => json_encode($rec)
			]);
		}

		$max = $res['last_page'];

	} while ($idx < $max);


}

// Speical Case for Each Manifest Line Item
// $res_b2b = $dbc->fetchAll('SELECT id FROM b2b');
// foreach ($res_b2b as $b2b) {
// 	$res = _leafdata_get('/inventory_transfers/%s');
// 	print_r($res);
// 	exit;
// }

$t1 = time();

printf("DONE: %s at %s (%d seconds)\n", $_ENV['license'], date(\DateTime::ISO8601, $t1), $t1 - $t0);

exit(0);


/**
 *
 */
function _leafdata_get($path, $args=[])
{
	// $url = sprintf('https://watest.leafdatazone.com/api/v1/%s?%s', ltrim($path, '/'), http_build_query($args));
	$url = sprintf('https://traceability.lcb.wa.gov/api/v1/%s?%s', ltrim($path, '/'), http_build_query($args));
	echo "GET: $url\n";

	$req = _curl_init($url);
	$head = array(
		'content-type: application/json',
		sprintf('x-mjf-mme-code: %s', $_ENV['license']),
		sprintf('x-mjf-key: %s', $_ENV['license-key']),
	);
	curl_setopt($req, CURLOPT_HTTPHEADER, $head);

	$res = curl_exec($req);
	$inf = curl_getinfo($req);
	curl_close($req);

	if (200 != $inf['http_code']) {
		echo "ERR: {$inf['http_code']}\n";
		return [
			'data' => [],
			'last_page' => 0,
		];
	}

	$res = json_decode($res, true);

	return $res;

}
