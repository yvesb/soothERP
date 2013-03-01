function createBackup(){ 
	var AppelAjax = new Ajax.Request(
		"serveur_backup_add.php", 
		{
		evalScripts:true, 
		onLoading:S_loading, onException: function () {S_failure();},
		onSuccess: function (requester){
		requester.responseText.evalScripts();
		H_loading();
		}
		}
		);
}

function restoreBackup(path){
	var AppelAjax = new Ajax.Request(
		"serveur_backup_restore.php", 
		{
		parameters: { path: path },
		evalScripts:true, 
		onLoading:S_loading, onException: function () {S_failure();},
		onSuccess: function (requester){
		requester.responseText.evalScripts();
		H_loading();
		}
		}
		);
}