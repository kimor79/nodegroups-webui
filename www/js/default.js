function cancelForm() {
	var oCancels = YAHOO.util.Dom.getElementsByClassName('cancel');

	for (var i = 0, len = oCancels.length; i < len; i++) {
		var oCancel = oCancels[i];
		YAHOO.util.Event.addListener(oCancel, 'click', function(evt) {
			YAHOO.util.Event.preventDefault(evt);
			window.location = this.href;
		});
	}
}

function createNodegroup() {
	var doCancel = function() {
		this.cancel();
	};

	var doSubmit = function() {
		W.loadingPanel('show');
		this.submit();
	};

	var onSuccess = function(o) {
		var oOutput = W.api.onSuccess(o);
		if(oOutput != false) {
			oDialog.hide();
			var sUrl = base_uri + '/nodegroups/details.php' +
				'?nodegroup=' +
				encodeURIComponent(oOutput.details.nodegroup);
			window.location = sUrl;
		}
	};

	YAHOO.util.Dom.removeClass('create-nodegroup', 'hidden');

	var oDialog = new YAHOO.widget.Dialog('create-nodegroup', {
		buttons: [
			{ text: 'Create', handler: doSubmit, isDefault: true },
			{ text: 'Cancel', handler: doCancel }
		],
		fixedcenter: true,
		hideaftersubmit: false,
		visible: false
	});
	oDialog.callback.failure = W.api.onFailure;
	oDialog.callback.success = onSuccess;
	oDialog.render();

	YAHOO.util.Event.addListener('show-create-nodegroup', 'click',
		oDialog.show, oDialog, true);
}

function dTformatDeleteIcon(elCell, oRecord, oColumn, oData) {
	elCell.innerHTML = '<img alt="delete" src="' + silk_uri +
		'/delete.png" title="Delete">';
}

function dTformatNodeName(elCell, oRecord, oColumn, oData) {
	var sOutput = '<a href="' + base_uri +
		'/nodes/details.php?node=' + encodeURIComponent(oData) + '">' +
		YAHOO.lang.escapeHTML(oData) + '</a>';

	elCell.innerHTML = sOutput;
}

function dTformatNodegroupName(elCell, oRecord, oColumn, oData) {
	var sOutput = '<a href="' + base_uri + '/nodegroups/details.php?' +
		'nodegroup=' + encodeURIComponent(oData) + '">' +
		YAHOO.lang.escapeHTML(oData) + '</a>';

	elCell.innerHTML = sOutput;
}

function modifyNodegroup() {
	var onSuccess = function(o) {
		var oOutput = W.api.onSuccess(o);
		if(oOutput != false) {
			var sUrl = base_uri + '/nodegroups/details.php' +
				'?nodegroup=' +
				encodeURIComponent(oOutput.details.nodegroup);
			window.location = sUrl;
		}
	};

	W.form.submitPOSTClick('modify-nodegroup', {
		failure: W.api.onFailure,
		success: onSuccess
	});
}

function previewExpression(sClass) {
	var oElements = YAHOO.util.Dom.getElementsByClassName(sClass);

	YAHOO.util.Event.addListener(oElements, 'click', function(evt) {
		W.loadingPanel('show');
		YAHOO.util.Event.preventDefault(evt);
		showPreview(this.form.expression.value, 'nodes-list');
		YAHOO.util.Dom.removeClass('preview', 'hidden');
		W.loadingPanel('hide');
	});
}

function removeNodegroupOrder(oDataTable) {
	var doCancel = function() {
		this.cancel();
	};

	var doSubmit = function() {
		W.loadingPanel('show');
		this.submit();
	};

	var onSuccess = function(o) {
		var oOutput = W.api.onSuccess(o);
		if(oOutput != false) {
			oDialog.hide();
			W.dt.refreshDataTable(oDataTable);
		}
	};

	var oDialog = new YAHOO.widget.Dialog('rm-order', {
		buttons: [
			{ text: 'Yes', handler: doSubmit },
			{ text: 'No', handler: doCancel, isDefault: true }
		],
		fixedcenter: true,
		hideaftersubmit: true,
		modal: true,
		visible: false,
		zIndex: 99
	});
	oDialog.callback.failure = W.api.onFailure;
	oDialog.callback.success = onSuccess;
	oDialog.render(document.body);

	return oDialog;
}

function searchNodegroups() {
	var sUrl = api_uri + '/v1/r/search_nodegroups.php' +
		'?outputFormat=json&outputFields=nodegroup,description';

	var sQuery = W.getQueryString();
	if(sQuery) {
		sUrl += '&' + sQuery;
	}

	var sColumns = [
		{ key: 'nodegroup', label: 'Nodegroup', sortable: true,
			resizable: true, className: 'txt-wrap',
			formatter: dTformatNodegroupName },
		{ key: 'description', label: 'Description', sortable: true,
			resizable: true, className: 'txt-wrap-long',
			formatter: 'text' }
	];

	var oDataSource = W.ds.newDataSource(sUrl, [
		{ key: 'description' },
		{ key: 'nodegroup' }
	]);

	var oConfigs = W.dt.config('nodegroup', 100);

	W.dt.newDataTable('search-results', sColumns, oDataSource, oConfigs);
}

function searchNodes() {
	var sUrl = api_uri + '/v1/r/search_nodes.php?outputFormat=json';

	var sQuery = W.getQueryString();
	if(sQuery) {
		sUrl += '&' + sQuery;
	}

	var sColumns = [
		{ key: 'node', label: 'Node', sortable: true,
			resizable: true, className: 'txt-wrap',
			formatter: dTformatNodeName },
		{ key: 'nodegroups', label: 'Nodegroups', sortable: true,
			resizable: true, formatter: 'number' }
	];

	var oDataSource = W.ds.newDataSource(sUrl, [
		{ key: 'node' },
		{ key: 'nodegroups', parser: 'number' }
	]);

	var oConfigs = W.dt.config('node', 100);

	W.dt.newDataTable('search-results', sColumns, oDataSource, oConfigs);
}

function setNodegroupOrder(oDataTable) {
	var doCancel = function() {
		this.cancel();
	};

	var doSubmit = function() {
		W.loadingPanel('show');
		this.submit();
	};

	var onSuccess = function(o) {
		var oOutput = W.api.onSuccess(o);
		if(oOutput != false) {
			oDialog.hide();
			oDialog.form.reset();
			W.dt.refreshDataTable(oDataTable);
		}
	};

	YAHOO.util.Dom.removeClass('set-nodegroup-order', 'hidden');

	var oDialog = new YAHOO.widget.Dialog('set-nodegroup-order', {
		buttons: [
			{ text: 'Set', handler: doSubmit, isDefault: true },
			{ text: 'Cancel', handler: doCancel }
		],
		fixedcenter: true,
		hideaftersubmit: false,
		visible: false
	});
	oDialog.callback.failure = W.api.onFailure;
	oDialog.callback.success = onSuccess;
	oDialog.render();

	YAHOO.util.Event.addListener('show-set-nodegroup-order', 'click',
		oDialog.show, oDialog, true);
}

function showNodeEvents(sNode) {
	var sUrl = api_uri + '/v1/r/get_node_events.php?' +
		'outputFormat=json&node=' + encodeURIComponent(sNode);

	var sColumns = [
		{ key: 'c_time', label: 'Time', sortable: true,
			resizable: true, formatter: W.dt.formatDate },
		{ key: 'user', label: 'User', sortable: true,
			resizable: true, formatter: 'text' },
		{ key: 'event', label: 'Event', sortable: true,
			resizable: true, formatter: 'text' },
		{ key: 'nodegroup', label: 'Nodegroup', sortable: true,
			resizable: true, formatter: dTformatNodegroupName }
	];

	var oDataSource = W.ds.newDataSource(sUrl, [
		{ key: 'c_time', parser: W.ds.parseDate },
		{ key: 'event' },
		{ key: 'nodegroup' },
		{ key: 'user' }
	]);

	var oConfigs = W.dt.config('c_time', 25, 'desc');

	var oDT = W.dt.newDataTable('node-events', sColumns,
		oDataSource, oConfigs);
}

function showNodeNodegroups(sNode) {
	var sUrl = api_uri + '/v1/r/list_nodegroups_from_nodes.php?' +
		'outputFormat=json&node=' + encodeURIComponent(sNode);

	var sColumns = [
		{ key: 'nodegroup', label: 'Nodegroup', sortable: true,
			resizable: true, className: 'txt-wrap',
			formatter: dTformatNodegroupName },
		{ key: 'description', label: 'Description', sortable: true,
			resizable: true, className: 'txt-wrap-long',
			formatter: 'text' }
	];

	var oDataSource = W.ds.newDataSource(sUrl, [
		{ key: 'description' },
		{ key: 'nodegroup' }
	]);

	var oConfigs = W.dt.config('nodegroup', 100);

	var oDT = W.dt.newDataTable('node-nodegroups', sColumns,
		oDataSource, oConfigs);
}

function showNodegroupEvents(sNodegroup) {
	var sUrl = api_uri + '/v1/r/get_nodegroup_events.php?' +
		'outputFormat=json&nodegroup=' + encodeURIComponent(sNodegroup);

	var sColumns = [
		{ key: 'c_time', label: 'Time', sortable: true,
			resizable: true, formatter: W.dt.formatDate },
		{ key: 'user', label: 'User', sortable: true,
			resizable: true, formatter: 'text' },
		{ key: 'event', label: 'Event', sortable: true,
			resizable: true, formatter: 'text' },
		{ key: 'node', label: 'Node', sortable: true,
			resizable: true, formatter: dTformatNodeName }
	];

	var oDataSource = W.ds.newDataSource(sUrl, [
		{ key: 'c_time', parser: W.ds.parseDate },
		{ key: 'event' },
		{ key: 'node' },
		{ key: 'user' }
	]);

	var oConfigs = W.dt.config('c_time', 25, 'desc');

	var oDT = W.dt.newDataTable('nodegroup-events', sColumns,
		oDataSource, oConfigs);
}

function showNodegroupHistory(sNodegroup) {
	var sUrl = api_uri + '/v1/r/get_nodegroup_history.php?' +
		'outputFormat=json&nodegroup=' + encodeURIComponent(sNodegroup);

	var sColumns = [
		{ key: 'c_time', label: 'Time', sortable: true,
			resizable: true, formatter: W.dt.formatDate },
		{ key: 'user', label: 'User', sortable: true,
			resizable: true, formatter: 'text' },
		{ key: 'action', label: 'Action', sortable: true,
			resizable: true, formatter: 'text' }
	];

	var oDataSource = W.ds.newDataSource(sUrl, [
		{ key: 'action' },
		{ key: 'c_time', parser: W.ds.parseDate },
		{ key: 'description' },
		{ key: 'expression' },
		{ key: 'user' }
	]);

	var oConfigs = W.dt.config('c_time', 25, 'desc');

	var oDT = W.dt.newDataTable('nodegroup-history', sColumns,
		oDataSource, oConfigs);

	var oPanel = new YAHOO.widget.Panel('historypanel', {
		constraintoviewport: true,
		preventcontextoverlap: true,
		visible: false,
		zIndex: 1000
	});
	oPanel.setHeader('');
	oPanel.render(document.body);

	oDT.subscribe('rowMouseoverEvent', oDT.onEventHighlightRow);
	oDT.subscribe('rowMouseoutEvent', oDT.onEventUnhighlightRow);

	oDT.subscribe('rowClickEvent', function(oArgs) {
		var oTarget = oArgs.target;
		var oRecord = this.getRecord(oTarget);
		var sDesc = oRecord.getData('description');
		var sExpr = oRecord.getData('expression');

		oPanel.setBody('<table>' +
			'<tr><td>Description</td><td>Expression</td></tr>' +
			'<tr valign="top">' +
			'<td class="txt-wrap pre">' + sDesc + '</td>' +
			'<td class="txt-wrap pre">' + sExpr + '</td>' +
			'</tr></table>');
		oPanel.cfg.setProperty('context', [
			oTarget, 'tl', 'br', ['beforeShow', 'windowResize']]);
		oPanel.show();
	});
}

function showNodegroupOrder(sNodegroup) {
	var sUrl = api_uri + '/v1/r/get_nodegroup_order.php?' +
		'outputFormat=json&nodegroup=' + encodeURIComponent(sNodegroup);

	var sColumns = [
		{ key: 'order', label: 'Order', sortable: true,
			resizable: true },
		{ key: 'app', label: 'App', sortable: true,
			resizable: true, formatter: 'text' },
		{ key: '_remove', label: '',
			className: ['clickable', 'dt-highlight-row'],
			formatter: dTformatDeleteIcon }
	];

	var oDataSource = W.ds.newDataSource(sUrl, [
		{ key: 'app' },
		{ key: 'nodegroup' },
		{ key: 'order', parser: 'number' }
	]);

	var oConfigs = W.dt.config('order', 25, 'desc');

	var oDT = W.dt.newDataTable('nodegroup-order', sColumns,
		oDataSource, oConfigs);

	var highlightEditableCell = function(oArgs) {
		var elCell = oArgs.target;
		if(YAHOO.util.Dom.hasClass(elCell, 'dt-highlight-row')) {
			this.highlightRow(elCell);
		}
	};

	setNodegroupOrder(oDT);
	var oRemoveDialog = removeNodegroupOrder(oDT);

	oDT.subscribe('cellMouseoverEvent', highlightEditableCell);
	oDT.subscribe('cellMouseoutEvent', oDT.onEventUnhighlightRow);

	var showRemove = function(oRecord) {
		var sApp = oRecord.getData('app');
		var sForm = '<form method="POST" action="' + api_uri +
			'/v1/w/remove_order.php?outputFormat=json">' +
			'<input type="hidden" name="nodegroup" value="' +
			encodeURIComponent(sNodegroup) + '">' +
			'<input type="hidden" name="app" value="' +
			encodeURIComponent(sApp) + '"></form> Remove ' +
			"'" + YAHOO.lang.escapeHTML(sApp) + "' from " +
			sNodegroup + '?';

		oRemoveDialog.setBody(sForm);
		oRemoveDialog.show();
	};

	oDT.subscribe('cellClickEvent', function(oArgs) {
		var oTarget = oArgs.target;
		var oColumn = this.getColumn(oTarget);
		var oRecord = this.getRecord(oTarget);

		if(oColumn.key == '_remove') {
			showRemove(oRecord);
		}
	});
}

function showNodesList(sNodegroup, sId) {
	var sUrl = api_uri + '/v1/r/list_nodes.php?' +
		'outputFormat=list&nodegroup=' + encodeURIComponent(sNodegroup);

	YAHOO.util.Connect.asyncRequest('GET', sUrl, {
		failure: function(o) {
			document.getElementById(sId).innerHTML = o.statusText;
		},
		success: function(o) {
			document.getElementById(sId).innerHTML = o.responseText;
		}
	});
}

function showPreview(sExpression, sId) {
	var sUrl = api_uri + '/v1/r/list_nodes.php?outputFormat=list&' +
		'expression=' + encodeURIComponent(sExpression);

	YAHOO.util.Connect.asyncRequest('GET', sUrl, {
		failure: function(o) {
			document.getElementById(sId).innerHTML = o.statusText;
		},
		success: function(o) {
			document.getElementById(sId).innerHTML = o.responseText;
		}
	});
}

YAHOO.util.Event.onDOMReady(function() {
	W.form.submitGETClick('search-form');
	W.form.submitGETEnter('enter-submit');

	cancelForm();
	createNodegroup();

	if(document.getElementById('search-nodegroups')) {
		searchNodegroups();
	}

	if(document.getElementById('search-nodes')) {
		searchNodes();
	}

	if(typeof(sNode) == 'string') {
		showNodeNodegroups(sNode);
		showNodeEvents(sNode);
	}

	if(typeof(sNodegroup) == 'string') {
		showNodesList(sNodegroup, 'nodes-list');
		showNodegroupEvents(sNodegroup);
		showNodegroupHistory(sNodegroup);
		showNodegroupOrder(sNodegroup);
	}

	if(document.getElementById('modify-nodegroup')) {
		modifyNodegroup();
		previewExpression('preview-nodegroup');
	}

	if(document.getElementById('preview-expression')) {
		previewExpression('preview-expression');
	}
});
