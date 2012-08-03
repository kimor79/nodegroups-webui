<?php

define('WEBUI_PRODUCER_MYAPP', 'nodegroups_webui');

include 'api_consumer/v2/classes/consumer.php';
include 'webui_producer/v2/classes/base.php';

try {
	$wui = new WebUIProducerV2Base();
} catch (Exception $e) {
	echo $e->getMessage();
	exit(0);
}

$api_uri = $wui->buildURI('nodegroups-api');
$api_uri = rtrim($api_uri, '/');

$apiclient = new APIConsumerV2(array(
	'base_uri' => $api_uri,
));

$base_uri = $wui->buildURI();
$base_uri = rtrim($base_uri, '/');

$silk_uri = $wui->buildURI('silk-icons');
$silk_uri = rtrim($silk_uri, '/');

$wui_uri = $wui->buildURI('webui');
$wui_uri = rtrim($wui_uri, '/');

$yui_uri = $wui->buildURI('yui');
$yui_uri = rtrim($yui_uri, '/');

$css_links = array(
	$yui_uri . '/reset-fonts-grids/reset-fonts-grids.css',
	$yui_uri . '/base/base-min.css',
	$yui_uri . '/assets/skins/sam/skin.css',
	$wui_uri . $wui->getConfig('webui', 'base_css'),
	$wui->buildSelfURN('/css/default.css'),
);

if($wui->getConfig('theme', 'css_path')) {
	$css_links[] = $wui->buildSelfURN($wui->getConfig('theme', 'css_path'));
}

$js_links = array(
	$yui_uri . '/utilities/utilities.js',
	$yui_uri . '/button/button-min.js',
	$yui_uri . '/calendar/calendar-min.js',
	$yui_uri . '/container/container-min.js',
	$yui_uri . '/datasource/datasource-min.js',
	$yui_uri . '/paginator/paginator-min.js',
	$yui_uri . '/datatable/datatable-min.js',
	$yui_uri . '/element-delegate/element-delegate-min.js',
	$yui_uri . '/selector/selector-min.js',
	$yui_uri . '/event-delegate/event-delegate-min.js',
	$yui_uri . '/event-mouseenter/event-mouseenter-min.js',
	$yui_uri . '/json/json-min.js',
	$yui_uri . '/resize/resize-min.js',
	$yui_uri . '/tabview/tabview-min.js',
	$wui_uri . $wui->getConfig('webui', 'base_js'),
	$wui->buildSelfURN('/js/default.js'),
);

if($wui->getConfig('js_path')) {
	$js_links[] = $wui->buildSelfURN($wui->getConfig('js_path'));
}

?>
