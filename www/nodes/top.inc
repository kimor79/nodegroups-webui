<?php

$project = 'nodegroups';
$title = 'Nodegroups';
include('Ops/head.inc');

include('Nodegroups/www/www.inc');

$tabs = array(
	'search.php' => 'Search',
	'details.php' => 'Details',
);

?>

<body class="yui-skin-sam">

<?php

include('Nodegroups/www/body_top.inc');
$www->showSubTabs($tabs, '/nodes', 'search.php');

?>
