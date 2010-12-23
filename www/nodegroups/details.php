<?php

include_once('Nodegroups/includes/ro.inc');
include_once('Nodegroups/www/www.inc');

if(empty($_GET['nodegroup'])) {
        $www->giveRedirect('/nodegroups/search.php');
        exit(0);
}

$r_details = $ng->getNodegroupDetails(array('nodegroup' => $_GET['nodegroup']));

if(count($r_details) != 1) {
        $www->giveRedirect('/nodegroups/search.php?nodegroup=' . urlencode($_GET['nodegroup']));
        exit(0);
}

$details = reset($r_details);

if($_GET['nodegroup'] != $details['nodegroup']) {
// Partial/wildcard was given, redirect to proper nodegroup
        $www->giveRedirect('/nodegroups/details.php?nodegroup=' . urlencode($details['nodegroup']));
        exit(0);
}

include('top.inc');
?>

<br>

<div id="divNodeGroupDetailsForm">
 <div class="hd"></div>
 <div class="bd">
<form name="formNodeGroupDetails" method="POST" action="/api/w/v2/addmodify_nodegroup.php">
<input type="hidden" name="nodegroup" value="<?php echo $details['nodegroup']; ?>">
<table>
 <tr><td><b>Name:</b></td><td><?php echo $details['nodegroup']; ?></td></tr>
 <tr>
  <td><label for="description">Description:</label></td>
  <td><textarea name="description" rows="5" cols="30"><?php echo $details['description']; ?></textarea></td>
 </tr>
 <tr>
  <td><label for="expression">Expression:</label></td>
  <td><textarea name="expression" rows="10" cols="80"><?php echo $details['expression']; ?></textarea></td>
 </tr>
</table>
</form>
 </div>
 <div class="ft"></div>
</div>

<br>

<h3>Priorities <img class="clickable" id="imgAddNodeGroupPriority" src="/img/add.png"></h3>
<div id="divListPriority"></div>

<h3>History</h3>
<div id="divListHistory"></div>

<h3>Events</h3>
<div id="divListEvents"></div>

<h3>Members <img id="imgDownloadNodeGroupMembers" class="clickable" src="/img/download.gif" title="Save as text file" alt="Save as text file"></h3>
<textarea id="textareaNodeGroupMembers" readonly rows="50" cols="100"></textarea>

</p>

<div id="divNodeGroupPriorityForm">
 <div class="hd"></div>
 <div class="bd">
<form name="formAddModifyPriority" method="POST" action="/api/w/v2/addmodify_priority.php">
<input type="hidden" name="nodegroup" value="<?php echo $details['nodegroup']; ?>">
<table>
 <tr>
  <td><label for="app">App:</label></<td><td><input type="text" name="app" size="30"></td>
 </tr>
 <tr>
  <td><label for="priority">Priority:</label></<td><td><input type="text" name="priority" size="5"></td>
 </tr>
</table>
</form>
 </div>
 <div class="ft"></div>
</div>

<div id="divPanelNodegroupPreview">
 <div class="hd">Preview</div>
 <div class="bd">
  <iframe name="iframeNodegroupPreview" width="100%" height="100%" frameborder="0" src=""></iframe>
 </div>
</div>

</body>
</html>
<script type="text/javascript">
YAHOO.util.Event.addListener(window, "load", function() {
	var panel = new YAHOO.widget.Panel("divPanelNodegroupPreview", {
		visible:false, draggable:true, close:true, fixedcenter:true
	});

	panel.render();

	var handleCancel = function() {
		panel.hide();
		this.form.reset();
	};

	var handleSubmit = function() {
		panel.hide();
		this.submit();
	};

	var handlePreview = function() {
		var previewUrl = '/api/r/v2/list_nodes.php?format=list&expression=';
		previewUrl += encodeURIComponent(myDialog.getData().expression);
		window.frames["iframeNodegroupPreview"].location.href = previewUrl;

		panel.cfg.setProperty("fixedcenter", true);
		panel.cfg.setProperty("visible", true);
		panel.show();

	};

	var myButtons = [
		{ text:"Update", handler:handleSubmit },
		{ text:"Preview", handler:handlePreview, isDefault:true },
		{ text:"Reset", handler:handleCancel }
	];

	var myDialog = new YAHOO.widget.Dialog("divNodeGroupDetailsForm",
		{
			close: false,
			draggable: false,
			fixedcenter: false,
			hideaftersubmit: false,
			underlay: "none",
			visible: true,
			width: "675px",
			zIndex: 0
		}
	);
	myDialog.cfg.queueProperty("buttons", myButtons);
	myDialog.render();

	myDialog.validate = function() {
		return nodeGroupValidate(this, false);
	};

	var myPriorityColumnDefs = [
		{key:"app", label:"App", sortable:true, resizeable:true},
		{key:"priority", label:"Priority", sortable:true, resizeable:true},
		{key:"delete_priority", label:"", className:"center", formatter:YAHOO.BG.formatDeleteIcon}
	];

	var sPriorityUrl = '/api/r/v2/list_priority.php?nodegroup=<?php echo $details['nodegroup']; ?>&';

	var myPriorityDataSource = new YAHOO.util.DataSource(sPriorityUrl);
	myPriorityDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myPriorityDataSource.responseSchema = {
		resultsList: "records",
		fields: [
			{key:"app"},
			{key:"priority", parser:"number"}
		],
		metaFields: {
			totalRecords: "totalRecords"
		}
	};

	var myPriorityConfigs = {
		initialRequest: 'sort=app&dir=asc&startIndex=0&results=25',
		draggableColumns: true,
		dynamicData: true,
		sortedBy: {key:"app", dir:"asc"},
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage:25,
			rowsPerPageOptions: [ 25, 50, 100, 250, 500, 1000 ],
			template: "{FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink} {RowsPerPageDropdown}"
		})
	};

	var myPriorityDataTable = new YAHOO.widget.DataTable("divListPriority", myPriorityColumnDefs,
			myPriorityDataSource, myPriorityConfigs);

	myPriorityDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	};

	myPriorityDataTable.subscribe("rowMouseoverEvent", myPriorityDataTable.onEventHighlightRow);
	myPriorityDataTable.subscribe("rowMouseoutEvent", myPriorityDataTable.onEventUnhighlightRow);

	var myHistoryColumnDefs = [
		{key:"c_time", label:"When", sortable:true, resizeable:true, formatter:YAHOO.widget.DataTable.formatDate},
		{key:"user", label:"Who", sortable:true, resizeable:true},
		{key:"field", label:"What", sortable:true, resizeable:true},
		{key:"old_value", label:"Old", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString},
		{key:"new_value", label:"New", sortable:true, resizeable:true, formatter:YAHOO.BG.formatLongString}
	];

	var sHistoryUrl = '/api/r/v2/list_nodegroup_history.php?nodegroup=<?php echo $details['nodegroup']; ?>&';

	var myHistoryDataSource = new YAHOO.util.DataSource(sHistoryUrl);
	myHistoryDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myHistoryDataSource.responseSchema = {
		resultsList: "records",
		fields: [
			{key:"c_time", parser:YAHOO.util.DataSource.parseDate},
			{key:"user"},
			{key:"field"},
			{key:"old_value"},
			{key:"new_value"}
		],
		metaFields: {
			totalRecords: "totalRecords"
		}
	};

	var myHistoryConfigs = {
		initialRequest: 'sort=c_time&dir=desc&startIndex=0&results=25',
		draggableColumns: true,
		dynamicData: true,
		sortedBy: {key:"c_time", dir:"desc"},
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage:25,
			rowsPerPageOptions: [ 25, 50, 100, 250, 500, 1000 ],
			template: "{FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink} {RowsPerPageDropdown}"
		})
	};

	var myHistoryDataTable = new YAHOO.widget.DataTable("divListHistory", myHistoryColumnDefs,
			myHistoryDataSource, myHistoryConfigs);

	myHistoryDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	};

	var myEventsColumnDefs = [
		{key:"c_time", label:"When", sortable:true, resizeable:true, formatter:YAHOO.widget.DataTable.formatDate},
		{key:"user", label:"Who", sortable:true, resizeable:true},
		{key:"event", label:"Action", sortable:true, resizeable:true},
		{key:"node", label:"node", sortable:true, resizeable:true}
	];

	var sEventsUrl = '/api/r/v2/list_events.php?format=json&nodegroup=<?php echo $details['nodegroup']; ?>&';

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

	var membersSuccess = function(o) {
		document.getElementById("textareaNodeGroupMembers").innerHTML = o.responseText;
	};

	var membersFailure = function(o) {
		document.getElementById("textareaNodeGroupMembers").innerHTML = o.statusText;
	};

	membersUrl = '/api/r/v2/list_nodes.php?format=list&nodegroup=<?php echo urlencode($details['nodegroup']); ?>';

	myDialog.callback.success = function(o) {
		YAHOO.BG.dialogOnSuccess(o);
		YAHOO.BG.refreshDataTable(myHistoryDataTable);
		YAHOO.BG.refreshDataTable(myEventsDataTable);

		YAHOO.util.Connect.asyncRequest('GET', membersUrl, {
			success: membersSuccess,
			failure: membersFailure
		});

		var output;
		try {
			output = YAHOO.lang.JSON.parse(o.responseText);
		} catch(e) {
			YAHOO.BG.updateStatusDiv('red', o.responseText + e);
			return true;
		}

		if(typeof(output.status) == "undefined") {
			YAHOO.BG.updateStatusDiv('orange', o.responseText);
		} else {
			switch(output.status) {
				case "200":
					document.formNodeGroupDetails.description.value = output.details.description;
					document.formNodeGroupDetails.expression.value = output.details.expression;
					break;
				case "400":
					YAHOO.BG.updateStatusDiv('orange', output.message);
					break;
				case "500":
					YAHOO.BG.updateStatusDiv('red', output.message);
					break;
			}
		}
	};
	myDialog.callback.failure = YAHOO.BG.dialogOnFailure;

	var handlePriorityCancel = function() {
		this.cancel();
	};

	var handlePrioritySubmit = function() {
		this.submit();
	};

	var myPriorityButtons = [
		{ text:"Submit", handler:handlePrioritySubmit, isDefault:true },
		{ text:"Cancel", handler:handlePriorityCancel }
	];

	var myPriorityDialog = new YAHOO.widget.Dialog("divNodeGroupPriorityForm",
		{
			close: true,
			draggable: true,
			fixedcenter: true,
			hideaftersubmit: true,
			underlay: "none",
			visible: false,
			width: "400px",
			zIndex: 0
		}
	);
	myPriorityDialog.cfg.queueProperty("buttons", myPriorityButtons);
	myPriorityDialog.render();
	myPriorityDialog.setHeader('Set Priority');
	myPriorityDialog.callback.failure = YAHOO.BG.dialogOnFailure;
	myPriorityDialog.callback.success = function(o) {
		YAHOO.BG.dialogOnSuccess(o, myPriorityDialog.form);
		YAHOO.BG.refreshDataTable(myPriorityDataTable);
		YAHOO.BG.refreshDataTable(myHistoryDataTable);
	};

	YAHOO.util.Connect.asyncRequest('GET', membersUrl, {
		success: membersSuccess,
		failure: membersFailure
	});

	YAHOO.util.Event.addListener("imgDownloadNodeGroupMembers", "click", function() {
		document.getElementById("iframeDownload").src = membersUrl;
	});

	YAHOO.util.Event.addListener("imgAddNodeGroupPriority", "click", function() {
		myPriorityDialog.show();
	});

	myPriorityDataTable.subscribe("cellClickEvent", function(oArgs) {
		var target = oArgs.target;
		var record = this.getRecord(target);
		var app = record.getData("app");

		if(this.getColumn(target).getKey() == 'delete_priority') {
			YAHOO.BG.handleYesNoYes = function() {
				var postData = 'delete=yes&nodegroup=<?php echo $details['nodegroup']; ?>&app=' + app;
				var sUrl = "/api/w/v2/delete_priority.php";

				var callback = {
					success: function(o) {
						YAHOO.BG.dialogOnSuccess(o);
						YAHOO.BG.refreshDataTable(myPriorityDataTable);
						YAHOO.BG.refreshDataTable(myHistoryDataTable);
					},
					failure: YAHOO.BG.dialogOnFailure
				};

				YAHOO.BG.showLoading("show");
				YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postData);
			};

			YAHOO.BG.yesNoDialog.setBody("Delete priority for " + app + "?");
			YAHOO.BG.yesNoDialog.show();
			return;
		}

		document.formAddModifyPriority.app.value = app;
		document.formAddModifyPriority.priority.value = record.getData('priority');
		myPriorityDialog.show();
	});
});
</script>
