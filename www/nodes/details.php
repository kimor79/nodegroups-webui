<?php

include_once('Nodegroups/includes/ro.inc');
include_once('Nodegroups/www/www.inc');

if(empty($_GET['node'])) {
	$www->giveRedirect('/nodes/search.php');
	exit(0);
}

$r_details = $ng->getNodegroupDetails(array('node' => $_GET['node']));

if(count($r_details) < 1) {
	$www->giveRedirect('/nodes/search.php?node=' . urlencode($_GET['node']));
	exit(0);
}

$details = reset($r_details);

include('top.inc');
?>

<br>

<h2><?php echo $_GET['node']; ?></h2>

<h3>Events</h3>
<div id="divListEvents"></div>

<h3>Nodegroups</h3>
<div id="divListNodeGroups"></div>

</body>
</html>
<script type="text/javascript">
YAHOO.util.Event.addListener(window, "load", function() {
	var myNodeGroupColumnDefs = [
		{key:"nodegroup", label:"Nodegroup", sortable:true, resizeable:true},
		{key:"description", label:"Description", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString},
		{key:"expression", label:"Expression", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString}
	];

	var sNodeGroupUrl = '/api/r/v2/list_nodegroups.php?node=<?php echo $_GET['node']; ?>&';

	var myNodeGroupDataSource = new YAHOO.util.DataSource(sNodeGroupUrl);
	myNodeGroupDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myNodeGroupDataSource.responseSchema = {
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

	var myNodeGroupConfigs = {
		initialRequest: 'sort=nodegroup&dir=asc&startIndex=0&results=100',
		draggableColumns: true,
		dynamicData: true,
		sortedBy: {key:"nodegroup", dir:"asc"},
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage:100,
			rowsPerPageOptions: [ 25, 50, 100, 250, 500, 1000 ],
			template: "{FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink} {RowsPerPageDropdown}"
		})
	};

	var myNodeGroupDataTable = new YAHOO.widget.DataTable("divListNodeGroups", myNodeGroupColumnDefs,
			myNodeGroupDataSource, myNodeGroupConfigs);

	myNodeGroupDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	};

	myNodeGroupDataTable.subscribe("rowMouseoverEvent", myNodeGroupDataTable.onEventHighlightRow);
	myNodeGroupDataTable.subscribe("rowMouseoutEvent", myNodeGroupDataTable.onEventUnhighlightRow);

	myNodeGroupDataTable.subscribe("rowClickEvent", function(oArgs) {
		var target = oArgs.target;
		var record = this.getRecord(target);
		var nodegroup = record.getData('nodegroup');

		window.location = '/nodegroups/details.php?nodegroup=' + nodegroup;
	});

	var myEventsColumnDefs = [
		{key:"c_time", label:"When", sortable:true, resizeable:true, formatter:YAHOO.widget.DataTable.formatDate},
		{key:"user", label:"Who", sortable:true, resizeable:true},
		{key:"event", label:"Action", sortable:true, resizeable:true},
		{key:"nodegroup", label:"Nodegroup", sortable:true, resizeable:true}
	];

	var sEventsUrl = '/api/r/v2/list_events.php?format=json&node=<?php echo $_GET['node']; ?>&';

	var myEventsDataSource = new YAHOO.util.DataSource(sEventsUrl);
	myEventsDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myEventsDataSource.responseSchema = {
		resultsList: "records",
		fields: [
			{key:"c_time", parser:YAHOO.util.DataSource.parseDate},
			{key:"event"},
			{key:"node"},
			{key:"nodegroup"},
			{key:"user"}
		],
		metaFields: {
			totalRecords: "totalRecords"
		}
	};

	var myEventsConfigs = {
		initialRequest: 'sort=c_time&dir=desc&startIndex=0&results=25',
		draggableColumns: true,
		dynamicData: true,
		sortedBy: {key:"c_time", dir:"desc"},
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage: 25,
			rowsPerPageOptions: YAHOO.BG.paginatorRowsPerPageOptions,
			template: YAHOO.BG.paginatorTemplate
		})
	};

	var myEventsDataTable = new YAHOO.widget.DataTable("divListEvents", myEventsColumnDefs,
			myEventsDataSource, myEventsConfigs);

	myEventsDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	};
});
</script>
