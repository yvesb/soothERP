//mettre le compte tpe à actif
function set_active_compte_tpe (id_compte_tpe) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_tpes_active_compte.php", 
									{
									parameters: {id_compte_tpe: id_compte_tpe},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//mettre le compte tpe à inactif
function set_desactive_compte_tpe (id_compte_tpe) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_tpes_desactive_compte.php", 
									{
									parameters: {id_compte_tpe: id_compte_tpe},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//mettre le compte tpv à actif
function set_active_compte_tpv (id_compte_tpv) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_tpv_active_compte.php", 
									{
									parameters: {id_compte_tpv: id_compte_tpv},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//mettre le compte tpv à inactif
function set_desactive_compte_tpv (id_compte_tpv) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_tpv_desactive_compte.php", 
									{
									parameters: {id_compte_tpv: id_compte_tpv},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}