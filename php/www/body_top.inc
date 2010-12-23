<iframe id="iframeDownload" frameborder="0" width="0%" height="0%" scrolling="no" src=""></iframe>

<table id="tableBodyTop" width="99%" border="0">
 <tr><td width="30%">
  <a href="/"><img border="0" src="/img/bg_logo_transparent.png"></a>
 </td><td id="tdStatusUpdate">
 </td>
 <td align="right" width="30%">
  <button id="buttonCreateNodeGroup">Create nodegroup</button>
 </td></tr>
</table>

<?php
$main_tabs = array(
	'/nodegroups' => 'Nodegroups',
	'/nodes' => 'Nodes',
	'/events' => 'Events',
	'/docs' => 'Docs',
);

$www->showMainTabs($main_tabs, '/nodegroups');

?>

<div id="divCreateNodeGroup" class="dialog">
 <div class="hd">Create a nodegroup</div>
 <div class="bd">
  <form name="formCreateNodeGroup" method="POST" action="/api/w/v2/addmodify_nodegroup.php">
  <input type="hidden" name="create_only" value="true">
  <label for="nodegroup">Name</label><input type="text" size="30" name="nodegroup">
  <label for="description">Description</label><textarea name="description" rows="5" cols="30"></textarea>
  <div class="clear"></div>
  <label for="expression">Expression</label><textarea name="expression" rows="10" cols="80"></textarea>
  </form>
 </div>
</div>
