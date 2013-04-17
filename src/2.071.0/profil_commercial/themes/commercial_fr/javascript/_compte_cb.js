//mettre le compte cb à actif
function set_active_compte_cb (id_compte_cb) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_cbs_active_compte.php", 
									{
									parameters: {id_compte_cb: id_compte_cb},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//mettre le compte cb à inactif
function set_desactive_compte_cb (id_compte_cb) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_cbs_desactive_compte.php", 
									{
									parameters: {id_compte_cb: id_compte_cb},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}