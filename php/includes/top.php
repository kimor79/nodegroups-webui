<?php

include_once 'init.php';

?>
<html>
<head>
 <title>Nodegroups</title>

<script type="text/javascript">
<?php
printf("base_uri = '%s';\n", $base_uri);
printf("api_uri = '%s';\n", $api_uri);
printf("silk_uri = '%s';\n", $silk_uri);
?>
</script>
<?php
$wui->showCSSLinks($css_links);
$wui->showJSLinks($js_links);
?>
</head>

<body class="yui-skin-sam">
<div id="doc4">
 <div id="hd">

<table id="masthead">
 <tr>
  <td><a id="logo" href="<?php $wui->showSelfURN('/'); ?>">Home</a></td>
  <td class="align-right"><button id="show-create-nodegroup">Create Nodegroup</button></td>
 </tr>
</table>

<?php
$wui->showTabs('nav-main', array(
	'/nodegroups/' => 'Nodegroups',
	'/nodes/' => 'Nodes',
	'/preview/' => 'Preview',
), '/nodegroups/');
?>

 </div><!-- end header -->
 <div id="bd">
  <div id="doc2">
   <div class="space"></div>
