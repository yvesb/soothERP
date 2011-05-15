//mettre le compte bancaire à actif
function set_active_compte_caisse (id_compte_caisse) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_caisse_active_compte.php", 
									{
									parameters: {id_compte_caisse: id_compte_caisse},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//mettre le compte bancaire à inactif
function set_desactive_compte_caisse (id_compte_caisse) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_caisse_desactive_compte.php", 
									{
									parameters: {id_compte_caisse: id_compte_caisse},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}