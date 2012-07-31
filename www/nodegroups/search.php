<?php

include_once 'nodegroups/webui/includes/init.php';
include_once 'nodegroups/webui/includes/top.php';

$saveas_url = $api_uri . '/v2/r/nodegroups/get_nodegroups.php?';

if(array_key_exists('QUERY_STRING', $_SERVER) &&
		$_SERVER['QUERY_STRING'] != '') {
	$saveas_url .= $_SERVER['QUERY_STRING'] . '&';
}

?>

<div class="yui-gd">
 <div class="yui-u first wui-boxa">
  <form id="search-nodegroups" name="search" class="enter-submit" method="GET" action="">
   <table>
    <tr>
     <td><label for="nodegroup_re">Nodegroup</label></td>
     <td><input type="text" id="wui-focus" name="nodegroup_re" value="<?php $wui->showGET('nodegroup_re'); ?>"></td>
    </tr>
    <tr>
     <td><label for="description_re">Description</label></td>
     <td><input type="text" name="description_re" value="<?php $wui->showGET('description_re'); ?>"></td>
    </tr>
    <tr>
     <td><label for="expression_re">Expression</label></td>
     <td><input type="text" name="expression_re" value="<?php $wui->showGET('expression_re'); ?>"></td>
    </tr>
   </table>
   <div class="align-right">
    <input type="button" class="search-form" value="Search">
   </div>
  </form>
 </div>
</div>

<div class="space-large"></div>

<div>
Save results as:&nbsp;
<a href="<? echo $saveas_url . 'outputFormat=csv'; ?>">CSV</a> |&nbsp;
<a href="<? echo $saveas_url . 'outputFormat=json'; ?>">JSON</a>
</div>

<div id="search-results"></div>

<?php

include_once 'nodegroups/webui/includes/bottom.php';

?>
