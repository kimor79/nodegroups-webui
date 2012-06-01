<?php

include_once 'nodegroups/webui/includes/init.php';
include_once 'nodegroups/webui/includes/top.php';

$details = $apiclient->getDetails('/v1/r/get_nodegroup.php', array(
	'get' => array('nodegroup' => $wui->getGET('nodegroup'))));

?>

<?php
if(!$details) {
	echo 'No such nodegroup...&lt;insert fancy 404 page here&gt;<br>';

	if(!is_array($details)) {
		echo 'message: ' . $apiclient->getMessage();
		echo '<br><pre>';
		print_r($apiclient->getInfo());
		echo '</pre>';
	}
} else {
?>

<div class="yui-ge">
 <div class="yui-u first wui-boxa">
  <form id="modify-nodegroup" method="POST" action="<?php echo $api_uri; ?>/v1/w/modify_nodegroup.php?outputFormat=json">
   <table>
    <tr>
     <td><label>Nodegroup: </label><?php echo $details['nodegroup']; ?></td>
    </tr>
    <tr>
     <td><label for="description">Description:</label></td>
    </tr>
    <tr>
     <td>
      <textarea name="description"><?php echo $details['description']; ?></textarea>
     </td>
    </tr>
    <tr>
     <td><label for="expression">Expression:</label></td>
    </tr>
    <tr>
     <td>
      <textarea name="expression"><?php echo htmlentities($details['expression']); ?></textarea>
     </td>
    </tr>
   </table>
   <div class="align-right">
    <input type="button" class="preview-nodegroup" value="Preview">
    <input type="button" class="modify-nodegroup" value="Save">
    <input type="reset" value="Reset">
    <input type="hidden" name="nodegroup" value="<?php echo $details['nodegroup']; ?>">
    <a href="<?php $wui->showSelfURN('/nodegroups/details.php?nodegroup=' . $details['nodegroup']); ?>" class="a-button cancel">
     <button>Cancel</button>
    </a>
   </div>
  </form>
 </div>
</div>

<div class="space"></div>

<div id="preview" class="hidden">
 <h3>Preview</h3>
 <textarea id="nodes-list" readonly="readonly"></textarea>
</div>

<?php
}

include_once 'nodegroups/webui/includes/bottom.php';

?>
