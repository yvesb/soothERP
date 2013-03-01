//import


//fonction d'import d'une categorie d'article

function import_art_categ (ref_art_categ, lib_art_categ, modele, desc_art_categ, defaut_id_tva, duree_dispo, ref_art_categ_parent, array_groupe_carac, array_carac) {	
	var params = "";
	params += "ref_art_categ="+ref_art_categ+"&lib_art_categ="+encodeURIComponent(lib_art_categ)+"&modele="+modele+"&desc_art_categ="+encodeURIComponent(desc_art_categ)+"&defaut_id_tva="+defaut_id_tva+"&duree_dispo="+duree_dispo+"&ref_art_categ_parent="+ref_art_categ_parent;

	for (i = 0; i < array_groupe_carac.length; i++) {
		params += "&carac_groupes["+i+"][ref_carac_groupe]="+(array_groupe_carac[i][0]);
		params += "&carac_groupes["+i+"][lib_carac_groupe]="+encodeURIComponent(array_groupe_carac[i][1]);
		params += "&carac_groupes["+i+"][ordre]="+(array_groupe_carac[i][2]);
	}
	for (i = 0; i < array_carac.length; i++) {
		params += "&carac["+i+"][ref_carac]="+				(array_carac[i][0]);
		params += "&carac["+i+"][lib_carac]="+				encodeURIComponent(array_carac[i][1]);
		params += "&carac["+i+"][unite]="+						encodeURIComponent(array_carac[i][2]);
		params += "&carac["+i+"][allowed_values]="+		encodeURIComponent(array_carac[i][3]);
		params += "&carac["+i+"][default_value]="+		encodeURIComponent(array_carac[i][4]);
		params += "&carac["+i+"][moteur_recherche]="+	(array_carac[i][5]);
		params += "&carac["+i+"][variante]="+					encodeURIComponent(array_carac[i][6]);
		params += "&carac["+i+"][affichage]="+				encodeURIComponent(array_carac[i][7]);
		params += "&carac["+i+"][ref_carac_groupe]="+	encodeURIComponent(array_carac[i][8]);
		params += "&carac["+i+"][ordre]="+						encodeURIComponent(array_carac[i][9]);
	}
	
	
	
//alert(params);
	var AppelAjax = new Ajax.Updater(
									"content_art_categs",
									"serveur_import_catalogue_categorie_inc_add.php", 
									{
									parameters: params,
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (){
									H_loading();
									}
									}
									);
	
}


//ajout ou non d'un impex à l'import

function maj_import_type (ref_serveur_import, id_impex_type, autorise) {

	var AppelAjax = new Ajax.Request(
									"serveur_import_types_maj.php", 
									{
									parameters: {ref_serveur_import: ref_serveur_import, id_impex_type: id_impex_type, autorise: autorise },
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading();
									}
									}
									);
}
 
 