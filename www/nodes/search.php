<?php
include('top.inc');

?>

<br>

<div id="divSearchNodes">
 <div class="hd"></div>
 <div class="bd">
<form name="formSearchModels" method="GET" action="">
<table>
 <tr><td><label for="node">Node:<label></td><td><input type="text" name="node" size="30" value="<?php echo $_GET['node']; ?>"></td></tr>
</table>
</form>
 </div>
 <div class="ft"></div>
</div>

<br><div></div><br>

<div id="divListNodes"></div>

</body>
</html>
<script type="text/javascript">
YAHOO.util.Event.addListener(window, "load", function() {
	var handleCancel = function() {
		this.form.reset();
	};

	var handleSubmit = function() {
		var searchRequest = '';

		if(myDialog.getData().node != '') {
			searchRequest += '&node=' + encodeURIComponent(myDialog.getData().node);
		}

		window.location = '?' + searchRequest;
	};

	var myButtons = [
		{ text:"Search", handler:handleSubmit, isDefault:true },
		{ text:"Reset", handler:handleCancel }
	];

	var myDialog = new YAHOO.widget.Dialog("divSearchNodes", {
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

	var myEnterDialog = new YAHOO.util.KeyListener("divSearchNodes", { keys:13 }, { fn:handleSubmit });
	myEnterDialog.enable();

<?php
$api_url_requests = array();

if(isset($_GET['node'])) {
	$api_url_requests[] = sprintf("node=%s", urlencode('%' . $_GET['node'] . '%'));
}

?>
	var myColumnDefs = [
		{key:"node", label:"Nodes", sortable:true, resizeable:true},
		{key:"nodegroups", label:"Nodegroups", sortable:true, resizeable:true}
	];

	var sUrl = '/api/r/v2/search_nodes.php?format=json&<?php echo implode('&', $api_url_requests); ?>&';

	var myDataSource = new YAHOO.util.DataSource(sUrl);
	myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myDataSource.responseSchema = {
		resultsList: "records",
		fields: [
			{key:"node"},
			{key:"nodegroups", parser:"number"}
		],
		metaFields: {
			totalRecords: "totalRecords"
		}
	};

	var myConfigs = {
		initialRequest: 'sort=node&dir=asc&startIndex=0&results=100',
		draggableColumns: true,
		dynamicData: true,
		sortedBy: {key:"node", dir:"asc"},
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage:100,
			rowsPerPageOptions: [ 50, 100, 250, 500, 1000 ],
			template: "{FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink} {RowsPerPageDropdown}"
		})
	};

	myDataTable = new YAHOO.widget.DataTable("divListNodes", myColumnDefs, myDataSource, myConfigs);

	myDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	};

	myDataTable.subscribe("rowMouseoverEvent", myDataTable.onEventHighlightRow);
	myDataTable.subscribe("rowMouseoutEvent", myDataTable.onEventUnhighlightRow);

	myDataTable.subscribe("rowClickEvent", function(oArgs) {
		var target = oArgs.target;
		var record = this.getRecord(target);
		var node = record.getData('node');

		window.location = '/nodes/details.php?node=' + node;
	});
});
</script>
