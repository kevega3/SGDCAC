<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test</title>
	<script type="text/javascript" src="https://js.live.net/v7.2/OneDrive.js"></script>
</head>
<body>
	<script type="text/javascript">
		function launchSaveToOneDrive(){
			var odOptions = {
				clientId: "1a4d686d-26a2-465b-ae28-b5e45a6302d6",
				action: "save",
				sourceInputElementId: "fileUploadControl",
				sourceUri: "",
				openInNewWindow: false,
				viewType: "files",
				nameConflictBehavior: false,
				advanced: {},
			success: function(files) { /* success handler */ },
		progress: function(percent) { /* progress handler */ },
	cancel: function() { /* cancel handler */ },
error: function(error) { /* error handler */ }
}
OneDrive.save(odOptions);
}
</script>

<input id="fileUploadControl" name="fileUploadControl" type="file" />
<button onclick="launchSaveToOneDrive()">Save to OneDrive</button>

</body>
</html>