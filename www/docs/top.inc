<?php

$project = 'nodegroups';
$title = 'Nodegroups';
include('Ops/head.inc');

include('Nodegroups/www/www.inc');

$tabs = array(
	'definitions.php' => 'Definitions',
	'examples.php' => 'Examples',
	'best_practices.php' => 'Best Practices',
	'api.php' => 'API',
	'auto_generated.php' => 'Auto-Generated',
	'changelog.php' => 'Changelog',
);

?>

<body class="yui-skin-sam">

<?php

include('Nodegroups/www/body_top.inc');
$www->showSubTabs($tabs, '/docs', 'definitions.php');

?>
