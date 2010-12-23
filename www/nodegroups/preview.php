<?php

include_once('Nodegroups/www/www.inc');

include('top.inc');

$expression = (get_magic_quotes_gpc()) ? stripslashes($_GET['expression']) : $_GET['expression'];
?>

<br>

<div id="divNodegroupPreviewForm">
 <div class="hd"></div>
 <div class="bd">
<form name="formNodegroupPreview" method="GET" action="">
<table>
 <tr>
  <td><label for="expression">Expression:</label></td>
  <td><textarea name="expression" rows="10" cols="80"><?php echo $expression; ?></textarea></td>
 </tr>
</table>
</form>
 </div>
 <div class="ft"></div>
</div>

<br>

<h3>Members <img id="imgDownloadNodegroupMembers" class="clickable" src="/img/download.gif" title="Save as text file" alt="Save as text file"></h3>
<textarea id="textareaNodegroupMembers" readonly rows="50" cols="100"></textarea>

</body>
</html>
<script type="text/javascript">
YAHOO.util.Event.addListener(window, "load", function() {
	var handleSubmit = function() {
		var searchRequest = '';

		if(myDialog.getData().expression != '') {
			searchRequest += '&expression=' + encodeURIComponent(myDialog.getData().expression);
		}

		window.location = '?' + searchRequest;
	};

	var myButtons = [
		{ text:"Preview", handler:handleSubmit, isDefault:true }
	];

	var myDialog = new YAHOO.widget.Dialog("divNodegroupPreviewForm", {
		close: false,
		draggable: false,
		fixedcenter: false,
		hideaftersubmit: false,
		underlay: "none",
		visible: true,
		width: "675px",
		zIndex: 0
	});

	myDialog.cfg.queueProperty("buttons", myButtons);
	myDialog.render();

	var membersSuccess = function(o) {
		document.getElementById("textareaNodegroupMembers").innerHTML = o.responseText;
	};

	var membersFailure = function(o) {
		document.getElementById("textareaNodegroupMembers").innerHTML = o.statusText;
	};

	membersUrl = '/api/r/v2/list_nodes.php?format=list&expression=<?php echo urlencode($expression); ?>';

	YAHOO.util.Connect.asyncRequest('GET', membersUrl, {
		success: membersSuccess,
		failure: membersFailure
	});

	YAHOO.util.Event.addListener("imgDownloadNodegroupMembers", "click", function() {
		document.getElementById("iframeDownload").src = membersUrl;
	});
});
</script>
