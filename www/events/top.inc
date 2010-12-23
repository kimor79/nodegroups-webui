<?php

$project = 'nodegroups';
$title = 'Nodegroups';
include('Ops/head.inc');

include('Nodegroups/www/www.inc');

$tabs = array(
	'search.php' => 'Search',
);

?>

<body class="yui-skin-sam">

<?php

include('Nodegroups/www/body_top.inc');
$www->showSubTabs($tabs, '/events', 'search.php');

?>
