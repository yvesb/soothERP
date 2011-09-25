//stocks


function chek_used_stock(id_stock) {

	var AppelAjax = new Ajax.Request(
									"catalogue_stockage_sup.php", 
									{
									parameters: {id_stock: id_stock},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading();
									}
									}
									);
}
 

function choix_stock_do_article (id_stock) {
	$("id_stock_to_del").value = id_stock;
	$("lib_stock_to_move").innerHTML = $("lib_stock_"+id_stock).value;
	$("pop_up_choix_transfert_articles").style.display = "block";
}


function recherche_livraison_stock_set_contact (id_ref_contact, id_lib_contact, ref_contact, lib_contact) {
	$(id_ref_contact).value = ref_contact;
	$(id_lib_contact).value = lib_contact;
	
}


function livrer_stock_and_delete(id_stock, ref_contact) {

	var AppelAjax = new Ajax.Request(
									"catalogue_stockage_sup_deplace_art.php", 
									{
									parameters: {id_stock: id_stock, ref_contact: ref_contact, type_doc: "BLC"},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading();
									}
									}
									);
}


function transferer_stock_and_delete(id_stock, new_id_stock) {

	var AppelAjax = new Ajax.Request(
									"catalogue_stockage_sup_deplace_art.php", 
									{
									parameters: {id_stock: id_stock, new_id_stock: new_id_stock, type_doc: "TRM"},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading();
									}
									}
									);
}