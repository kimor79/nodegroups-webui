nodeGroupValidate = function(oForm, sCancel) {
	var data = oForm.getData();
	var myErrors = new Array();

	var reName = new RegExp(/^[-\w\.]+$/i);
	var reExpr = new RegExp(/^[-\w\s\.\(\)\&\@\,\!\#]+$/i);
	var nameResult;
	var exprResult;

	if(data.nodegroup != "" && data.description != "") {
		nameResult = reName.test(data.nodegroup);

		if(data.expression == "") {
			exprResult = true;
		} else {
			if(data.expression.indexOf('&regex') == '-1') {
				exprResult = reExpr.test(data.expression);
			} else {
				exprResult = true;
			}
		}

		if(nameResult == true && exprResult == true) {
			YAHOO.BG.showLoading('show');
			return true;
		}
	}

	if(data.nodegroup == "") {
			myErrors.push('Missing nodegroup name');
	} else {
		nameResult = reName.test(data.nodegroup);
		if(nameResult != true) {
			myErrors.push('Invalid characters in nodegroup name');
		}
	}

	if(data.description == "") {
			myErrors.push('Missing nodegroup description');
	}

	if(data.expression != "") {
		exprResult = reExpr.test(data.expression);
		if(exprResult != true) {
			myErrors.push('Invalid characters in nodegroup expression');
		}
	}

	YAHOO.BG.updateStatusDiv('orange', myErrors.join('<br>'));

	if(sCancel == true) {
		oForm.cancel();
	}
	return false;
};

YAHOO.util.Event.addListener(window, "load", function() {

var createNodeGroupDialog = function() {
	var handleCancel = function() {
		this.cancel();
	};

	var handleSubmit = function() {
		this.submit();
	};

	var myButtons = [
		{ text:"Create", handler:handleSubmit, isDefault:true },
		{ text:"Cancel", handler:handleCancel }
	];

	var myDialog = new YAHOO.widget.Dialog("divCreateNodeGroup",
		{
			fixedcenter: true,
			visible: false,
			zIndex: 100
		}
	);
	myDialog.cfg.queueProperty("buttons", myButtons);
	myDialog.render();

	myDialog.validate = function() {
		return nodeGroupValidate(this, true);
	}

	myDialog.callback.success = function(o) {
		var output;
		try {
			output = YAHOO.lang.JSON.parse(o.responseText);
		} catch(e) {
			YAHOO.BG.dialogOnSuccess(o, myDialog.form);
			return true;
		}

		if(typeof(output.status) != "undefined") {
			if(output.status == "200" && typeof(output.details) != "undefined") {
				window.location = '/nodegroups/details.php?nodegroup=' + encodeURIComponent(output.details.nodegroup);
			}
		}

		YAHOO.BG.dialogOnSuccess(o, myDialog.form);
	};

	myDialog.callback.failure = YAHOO.BG.dialogOnFailure;

	YAHOO.util.Event.addListener("buttonCreateNodeGroup", "click", myDialog.show, myDialog, true);
};
createNodeGroupDialog();

// End of window load listener
});
