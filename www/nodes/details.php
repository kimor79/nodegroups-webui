<?php

include_once 'nodegroups/webui/includes/init.php';
include_once 'nodegroups/webui/includes/top.php';

if(!$wui->getGET('node')) {
	$wui->showRedirect('/nodes/search.php');
}

?>

<div class="yui-ge">
 <div class="yui-u first wui-boxa">
  <table>
   <tr>
    <td><label>Node: </label><?php $wui->showGET('node'); ?></td>
   </tr>
  </table>
 </div>
</div>

<div class="space"></div>

<div class="yui-g">
 <div class="yui-u first">
  <h3>Events</h3>
  <div id="node-events"></div>
 </div>
</div>

<div class="yui-g">
 <div class="yui-u first">
  <h3>Nodegroups</h3>
  <div id="node-nodegroups"></div>
 </div>
</div>

<?php

include_once 'nodegroups/webui/includes/bottom.php';

?>
<script type="text/javascript">
sNode = '<?php $wui->showGET('node'); ?>';
</script>
