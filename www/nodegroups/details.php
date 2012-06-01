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
  <table>
   <tr>
    <td><label>Nodegroup: </label><?php echo $details['nodegroup']; ?></td>
   </tr>
   <tr>
    <td><label>Description:</label></td>
   </tr>
   <tr>
    <td>
     <div class="scroll-box"><?php echo $details['description']; ?></div>
    </td>
   </tr>
   <tr>
    <td><label>Expression:</label></td>
   </tr>
   <tr>
    <td>
     <div class="scroll-box"><?php echo htmlentities($details['expression']); ?></div>
    </td>
   </tr>
  </table>
  <div class="align-right">
   <a class="a-button" href="<?php
$wui->showSelfURN('/nodegroups/modify.php?nodegroup=' . $details['nodegroup']);
?>"><button>Modify</button></a>
  </div>
 </div>
</div>

<div class="space"></div>

<div class="yui-g">
 <div class="yui-u first">
  <h3>Members</h3>
  <textarea id="nodes-list" readonly="readonly"></textarea>
 </div>
 <div class="yui-u">
  <h3>Order&nbsp;<img id="show-set-nodegroup-order" class="clickable" src="<?php echo $silk_uri; ?>/add.png"></h3>
  <div id="nodegroup-order"></div>
 </div>
</div>

<div class="space"></div>

<div class="yui-g">
 <div class="yui-u first">
  <h3>History</h3>
  <div id="nodegroup-history"></div>
 </div>
 <div class="yui-u">
  <h3>Events</h3>
  <div id="nodegroup-events"></div>
 </div>
</div>

<div id="set-nodegroup-order" class="hidden">
 <div class="hd">Set Order</div>
 <div class="bd">
  <form name="set-nodegroup-order" method="POST" action="<?php echo $api_uri; ?>/v1/w/set_order.php?outputFormat=json">
   <input type="hidden" name="nodegroup" value="<?php echo $details['nodegroup']; ?>">
   <table>
    <tr>
     <td><label for="order">Order:</label></td>
     <td><input type="text" name="order" size="5"></td>
    </tr>
    <tr>
     <td><label for="app">App:</label></td>
     <td><input type="text" name="app" size="30"></td>
    </tr>
   </table>
  </form>
 </div>
</div>

<?php
}

include_once 'nodegroups/webui/includes/bottom.php';

if($details) {
?>
<script type="text/javascript">
sNodegroup = '<?php echo $details['nodegroup']; ?>';
</script>
<?php
}

?>
