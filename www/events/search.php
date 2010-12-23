<?php
include('top.inc');
?>

<br>

<div id="divSearchEvents">
 <div class="hd"></div>
 <div class="bd">
<form name="formSearchEvents" method="GET" action="">
<table>
 <tr><td><label for="nodegroup">Nodegroup:<label></td><td><input type="text" name="nodegroup" size="30" value="<?php echo $_GET['nodegroup']; ?>"></td></tr>
 <tr><td><label for="user">User:<label></td><td><input type="text" name="user" size="30" value="<?php echo $_GET['user']; ?>"></td></tr>
 <tr><td><label for="event">Event:<label></td><td><input type="text" name="event" size="30" value="<?php echo $_GET['event']; ?>"></td></tr>
 <tr><td><label for="node">Node:<label></td><td><input type="text" name="node" size="30" value="<?php echo $_GET['node']; ?>"></td></tr>
</table>
</form>
 </div>
 <div class="ft"></div>
</div>

<br><div></div><br>

<div id="divListEvents"></div>

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

		if(myDialog.getData().user != '') {
			searchRequest += '&user=' + encodeURIComponent(myDialog.getData().user);
		}

		if(myDialog.getData().event != '') {
			searchRequest += '&event=' + encodeURIComponent(myDialog.getData().event);
		}

		if(myDialog.getData().node != '') {
			searchRequest += '&node=' + encodeURIComponent(myDialog.getData().node);
		}

		window.location = '?' + searchRequest;
	};

	var myButtons = [
		{ text:"Search", handler:handleSubmit, isDefault:true },
		{ text:"Reset", handler:handleCancel }
	];

	var myDialog = new YAHOO.widget.Dialog("divSearchEvents", {
		close: false,
		draggable: false,
		fixedcenter: false,
		hideaftersubmit: false,
		underlay: "none",
		visible: true,
		width: "350px",
		zIndex: 0
	});

	myDialog.cfg.queueProperty("buttons", myButtons);
	myDialog.render();

	var myEnterDialog = new YAHOO.util.KeyListener("divSearchEvent", { keys:13 }, { fn:handleSubmit });
	myEnterDialog.enable();

<?php
$api_url_requests = array();

if(isset($_GET['nodegroup'])) {
	$api_url_requests[] = sprintf("nodegroup=%s", urlencode('%' . $_GET['nodegroup'] . '%'));
}

if(isset($_GET['user'])) {
	$api_url_requests[] = sprintf("user=%s", urlencode('%' . $_GET['user'] . '%'));
}

if(isset($_GET['event'])) {
	$api_url_requests[] = sprintf("event=%s", urlencode('%' . $_GET['event'] . '%'));
}

if(isset($_GET['node'])) {
	$api_url_requests[] = sprintf("node=%s", urlencode('%' . $_GET['node'] . '%'));
}
?>

	var myEventsColumnDefs = [
		{key:"c_time", label:"When", sortable:true, resizeable:true, formatter:YAHOO.widget.DataTable.formatDate},
		{key:"user", label:"Who", sortable:true, resizeable:true},
		{key:"nodegroup", label:"Nodegroup", sortable:true, resizeable:true},
		{key:"event", label:"Action", sortable:true, resizeable:true},
		{key:"node", label:"node", sortable:true, resizeable:true}
	];

	var sEventsUrl = '/api/r/v2/list_events.php?format=json&<?php echo implode('&', $api_url_requests); ?>&';

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
		initialRequest: 'sort=c_time&dir=desc&startIndex=0&results=100',
		draggableColumns: true,
		dynamicData: true,
		sortedBy: {key:"c_time", dir:"desc"},
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage: 100,
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
