<?php
include('top.inc');

?>

<br>

<div id="divSearchNodegroups">
 <div class="hd"></div>
 <div class="bd">
<form name="formSearchModels" method="GET" action="">
<table>
 <tr><td><label for="nodegroup">Name:<label></td><td><input type="text" name="nodegroup" size="30" value="<?php echo $_GET['nodegroup']; ?>"></td></tr>
 <tr><td><label for="description">Description:<label></td><td><input type="text" name="description" size="30" value="<?php echo $_GET['description']; ?>"></td></tr>
 <tr><td><label for="expression">Expression:<label></td><td><input type="text" name="expression" size="30" value="<?php echo $_GET['expression']; ?>"></td></tr>
</table>
</form>
 </div>
 <div class="ft"></div>
</div>

<br><div></div><br>

<div id="divListNodegroups"></div>

</body>
</html>
<script type="text/javascript">
YAHOO.util.Event.addListener(window, "load", function() {
	var handleCancel = function() {
		this.form.reset();
	};

	var handleSubmit = function() {
		var searchRequest = '';

		if(myDialog.getData().nodegroup != '') {
			searchRequest += '&nodegroup=' + encodeURIComponent(myDialog.getData().nodegroup);
		}

		if(myDialog.getData().description != '') {
			searchRequest += '&description=' + encodeURIComponent(myDialog.getData().description);
		}

		if(myDialog.getData().expression != '') {
			searchRequest += '&expression=' + encodeURIComponent(myDialog.getData().expression);
		}

		window.location = '?' + searchRequest;
	};

	var myButtons = [
		{ text:"Search", handler:handleSubmit, isDefault:true },
		{ text:"Reset", handler:handleCancel }
	];

	var myDialog = new YAHOO.widget.Dialog("divSearchNodegroups", {
		close: false,
		draggable: false,
		fixedcenter: false,
		hideaftersubmit: false,
		underlay: "none",
		visible: true,
		width: "400px",
		zIndex: 0
	});

	myDialog.cfg.queueProperty("buttons", myButtons);
	myDialog.render();

	var myEnterDialog = new YAHOO.util.KeyListener("divSearchNodegroups", { keys:13 }, { fn:handleSubmit });
	myEnterDialog.enable();

<?php
$api_url_requests = array();

if(isset($_GET['nodegroup'])) {
	$api_url_requests[] = sprintf("nodegroup=%s", urlencode('%' . $_GET['nodegroup'] . '%'));
}

if(isset($_GET['description'])) {
	$api_url_requests[] = sprintf("description=%s", urlencode('%' . $_GET['description'] . '%'));
}

if(isset($_GET['expression'])) {
	$api_url_requests[] = sprintf("expression=%s", urlencode('%' . $_GET['expression'] . '%'));
}

?>
	var myColumnDefs = [
		{key:"nodegroup", label:"Name", sortable:true, resizeable:true},
		{key:"description", label:"Description", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString},
		{key:"expression", label:"Expression", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString}
	];

	var sUrl = '/api/r/v2/list_nodegroups.php?format=json&<?php echo implode('&', $api_url_requests); ?>&';

	var myDataSource = new YAHOO.util.DataSource(sUrl);
	myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myDataSource.responseSchema = {
		resultsList: "records",
		fields: [
			{key:"nodegroup"},
			{key:"description"},
			{key:"expression"}
		],
		metaFields: {
			totalRecords: "totalRecords"
		}
	};

	var myConfigs = {
		initialRequest: 'sort=nodegroup&dir=asc&startIndex=0&results=100',
		draggableColumns: true,
		dynamicData: true,
		sortedBy: {key:"nodegroup", dir:"asc"},
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage:100,
			rowsPerPageOptions: [ 50, 100, 250, 500, 1000 ],
			template: "{FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink} {RowsPerPageDropdown}"
		})
	};

	myDataTable = new YAHOO.widget.DataTable("divListNodegroups", myColumnDefs, myDataSource, myConfigs);

	myDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	};

	myDataTable.subscribe("rowMouseoverEvent", myDataTable.onEventHighlightRow);
	myDataTable.subscribe("rowMouseoutEvent", myDataTable.onEventUnhighlightRow);

	myDataTable.subscribe("rowClickEvent", function(oArgs) {
		var target = oArgs.target;
		var record = this.getRecord(target);
		var nodegroup = record.getData('nodegroup');

		window.location = '/nodegroups/details.php?nodegroup=' + nodegroup;
	});
});
</script>
