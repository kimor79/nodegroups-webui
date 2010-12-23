<?php

$project = 'nodegroups';
$title = 'Nodegroups';
include('Ops/head.inc');

include('Nodegroups/www/www.inc');

$tabs = array(
	'search.php' => 'Search',
	'details.php' => 'Details',
	'preview.php' => 'Preview',
	'history.php' => 'History',
);

?>

<body class="yui-skin-sam">

<?php

include('Nodegroups/www/body_top.inc');
$www->showSubTabs($tabs, '/nodegroups', 'search.php');

?>
