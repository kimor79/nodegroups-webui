<?php
include('top.inc');
?>

<br>

<div id="divSearchHistory">
 <div class="hd"></div>
 <div class="bd">
<form name="formSearchHistory" method="GET" action="">
<table>
 <tr><td><label for="nodegroup">Nodegroup:<label></td><td><input type="text" name="nodegroup" size="30" value="<?php echo $_GET['nodegroup']; ?>"></td></tr>
 <tr><td><label for="user">User:<label></td><td><input type="text" name="user" size="30" value="<?php echo $_GET['user']; ?>"></td></tr>
 <tr><td><label for="field">Field:<label></td><td><input type="text" name="field" size="30" value="<?php echo $_GET['field']; ?>"></td></tr>
 <tr><td><label for="old_value">Old:<label></td><td><input type="text" name="old_value" size="30" value="<?php echo $_GET['old_value']; ?>"></td></tr>
 <tr><td><label for="new_value">New:<label></td><td><input type="text" name="new_value" size="30" value="<?php echo $_GET['new_value']; ?>"></td></tr>
</table>
</form>
 </div>
 <div class="ft"></div>
</div>

<br><div></div><br>

<div id="divListHistory"></div>

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

		if(myDialog.getData().field != '') {
			searchRequest += '&field=' + encodeURIComponent(myDialog.getData().field);
		}

		if(myDialog.getData().old_value != '') {
			searchRequest += '&old_value=' + encodeURIComponent(myDialog.getData().old_value);
		}

		if(myDialog.getData().new_value != '') {
			searchRequest += '&new_value=' + encodeURIComponent(myDialog.getData().new_value);
		}

		window.location = '?' + searchRequest;
	};

	var myButtons = [
		{ text:"Search", handler:handleSubmit, isDefault:true },
		{ text:"Reset", handler:handleCancel }
	];

	var myDialog = new YAHOO.widget.Dialog("divSearchHistory", {
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

	var myEnterDialog = new YAHOO.util.KeyListener("divSearchHistory", { keys:13 }, { fn:handleSubmit });
	myEnterDialog.enable();

<?php
$api_url_requests = array();

if(isset($_GET['nodegroup'])) {
	$api_url_requests[] = sprintf("nodegroup=%s", urlencode('%' . $_GET['nodegroup'] . '%'));
}

if(isset($_GET['user'])) {
	$api_url_requests[] = sprintf("user=%s", urlencode('%' . $_GET['user'] . '%'));
}

if(isset($_GET['field'])) {
	$api_url_requests[] = sprintf("field=%s", urlencode('%' . $_GET['field'] . '%'));
}

if(isset($_GET['old_value'])) {
	$api_url_requests[] = sprintf("old_value=%s", urlencode('%' . $_GET['old_value'] . '%'));
}

if(isset($_GET['new_value'])) {
	$api_url_requests[] = sprintf("new_value=%s", urlencode('%' . $_GET['new_value'] . '%'));
}
?>

	var myHistoryColumnDefs = [
		{key:"c_time", label:"When", sortable:true, resizeable:true, formatter:YAHOO.widget.DataTable.formatDate},
		{key:"user", label:"Who", sortable:true, resizeable:true},
		{key:"nodegroup", label:"Nodegroup", sortable:true, resizeable:true},
		{key:"field", label:"What", sortable:true, resizeable:true},
		{key:"old_value", label:"Old", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString},
		{key:"new_value", label:"New", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString}
	];

	var sHistoryUrl = '/api/r/v2/list_nodegroup_history.php?format=json&<?php echo implode('&', $api_url_requests); ?>&';

	var myHistoryDataSource = new YAHOO.util.DataSource(sHistoryUrl);
	myHistoryDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myHistoryDataSource.responseSchema = {
		resultsList: "records",
		fields: [
			{key:"c_time", parser:YAHOO.util.DataSource.parseDate},
			{key:"user"},
			{key:"nodegroup"},
			{key:"field"},
			{key:"old_value"},
			{key:"new_value"}
		],
		metaFields: {
			totalRecords: "totalRecords"
		}
	};

	var myHistoryConfigs = {
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

	var myHistoryDataTable = new YAHOO.widget.DataTable("divListHistory", myHistoryColumnDefs,
			myHistoryDataSource, myHistoryConfigs);

	myHistoryDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	};
});
</script>
