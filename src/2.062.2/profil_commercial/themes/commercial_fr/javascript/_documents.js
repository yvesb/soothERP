
function liaisons_insert_pack(ref_doc,debut_pack,pack_size){

	var addlinespack = new Array();
	var addlinesstr = "";
    var a_php = "";
    var total = 0;
										
	for (i=debut_pack;i<debut_pack+pack_size;i++){
		addlinespack[$("liaison_ref_article_"+i).value]=$("qte_"+i).value;
		}
	for (var key in addlinespack)
    {
       if (total<pack_size) {
		++ total;
        addlinesstr = addlinesstr + "s:" +
                String(key).length + ":\\\"" + String(key) + "\\\";s:" +
                String(addlinespack[key]).length + ":\"" + String(addlinespack[key]) + "\";";
       }
    } 
	addlinesstr = "a:" + total + ":{" + addlinesstr + "}";
	
	var AppelAjax = new Ajax.Request(
			"documents_line_add_liaisons_bloc.php",
			{
			parameters: {ref_doc: ref_doc, lines_data: addlinesstr, type_of_line: "article"},
			evalScripts:true,
			onLoading:S_loading, onException: function () {S_failure();},
			onSuccess: function (requester){
			requester.responseText.evalScripts();
			}
			}
			);	
	
}


//Maj pop_up des liaisons
function maj_pop_up_link(id_article, ref_doc, qte_article){

var AppelAjax = new Ajax.Updater(
																"pop_up_link_content",
																"catalogue_article_liste_liaisons.php",
																{
																parameters: {ref_article: id_article, ref_doc: ref_doc, qte_article: qte_article},
																evalScripts:true,
																onLoading:S_loading,
																onSuccess:H_loading
																}
																);
}
//ajout d'un d'article
function add_new_line_article (ref_doc, ref_article, qte_article, num_serie) {
	var AppelAjax = new Ajax.Request(
									"documents_line_add.php",
									{
									parameters: {ref_doc: ref_doc, ref_article: ref_article, qte_article: qte_article, type_of_line: "article", num_serie: num_serie},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									}
									}
									);
}
//ajout d'une ligne de sous total
function add_new_line_other_type (ref_doc, type_of_line) {
	var AppelAjax = new Ajax.Request(
									"documents_line_add.php",
									{
									parameters: {ref_doc: ref_doc, type_of_line: type_of_line  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									}
									}
									);
}

//ajout des lignes du modele de contenu
function add_content_model(ref_doc, ref_doc_mod){
	var AppelAjax = new Ajax.Request(
									"documents_model_content_add.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_mod: ref_doc_mod  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									}
									}
									);
}

//ajout d'une ligne d'information
function add_new_line_info_modele (ref_doc, type_of_line, id_doc_info_line) {
	var AppelAjax = new Ajax.Request(
									"documents_line_add.php",
									{
									parameters: {ref_doc: ref_doc, type_of_line: type_of_line, id_doc_info_line: id_doc_info_line  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									}
									}
									);
}

//ajout d'une ligne de frais de port
function add_new_line_livraison_mode (ref_doc, id_livraison_mode) {
	var AppelAjax = new Ajax.Request(
									"documents_line_livraison_add.php",
									{
									parameters: {ref_doc: ref_doc, id_livraison_mode: id_livraison_mode  },
									evalScripts:true,
									onLoading:S_loading,
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									}
									}
									);
}
////ajout d'une ligne
//function add_document_line(ref_doc_line, type_of_line ) {
//	var indentation_contenu = $("indentation_contenu").value;
//	$("indentation_contenu").value = parseFloat($("indentation_contenu").value)+1;
//	var liste_art_doc= $("lignes");
//	var addtag= document.createElement("li");
//			addtag.setAttribute ("id", ref_doc_line+"_"+indentation_contenu);
//	liste_art_doc.appendChild(addtag);
//	last_parent_doc_line = indentation_contenu;
//
//	var AppelAjax = new Ajax.Updater(
//									ref_doc_line+"_"+indentation_contenu,
//									"documents_line_insert.php",
//									{
//									parameters: {ref_doc_line: ref_doc_line, type_of_line: type_of_line, indentation_contenu: indentation_contenu },
//									evalScripts:true,
//									onLoading:S_loading, onException: function () {S_failure();},
//									onComplete: function() {
//															H_loading();
//															Sortable.create('lignes',{dropOnEmpty:true, ghosting:true,scroll:'block_lignes_articles', handle: 'composant_li_lib_handle'});
//															},
//									insertion: Insertion.Top
//									}
//									);
//
//}
//
////ajout d'une ligne enfant dans un parent
//function add_document_line_enfant (ref_doc_line, type_of_line, ref_doc_line_parent ) {
//
//	var indentation_contenu = $("indentation_contenu").value;
//	$("indentation_contenu").value = parseFloat($("indentation_contenu").value)+1;
//
//	var parent_line= $(ref_doc_line_parent+"_"+last_parent_doc_line);
//	var addtag= document.createElement("div");
//			addtag.setAttribute ("id", ref_doc_line+"_"+indentation_contenu);
//	parent_line.appendChild(addtag);
//
//	var AppelAjax = new Ajax.Updater(
//									ref_doc_line+"_"+indentation_contenu,
//									"documents_line_insert.php",
//									{
//									parameters: {ref_doc_line: ref_doc_line, type_of_line: type_of_line, indentation_contenu: indentation_contenu },
//									evalScripts:true,
//									onLoading:S_loading, onException: function () {S_failure();},
//									onComplete: H_loading()
//									}
//									);
//
//}

//mise à jour des articles lors de changement dans la liste de resultats
function article_maj_from_moteur (ref_article, type) {

	switch (type)
{
  case "blur":
    if (($("new_moteur_article_"+ref_article).value=="1") && ($("qte_moteur_article_"+ref_article).value=="0")) {
		} else if ($("new_moteur_article_"+ref_article).value=="1") {
			$("new_moteur_article_"+ref_article).value="0";
			add_new_line_article ($("ref_doc").value, ref_article, $("qte_moteur_article_"+ref_article).value, $("numero_serie_"+ref_article).value);
		} else {
			if ($("ref_doc_line_indentation_"+ref_article).value != "") {
				affichage_sn_update ($("ref_doc_line_indentation_"+ref_article).value, $("qte_moteur_article_"+ref_article).value, $("qte_old_"+$("ref_doc_line_indentation_"+ref_article).value).value);

				$("qte_"+$("ref_doc_line_indentation_"+ref_article).value).value = $("qte_moteur_article_"+ref_article).value;
				$("qte_old_"+$("ref_doc_line_indentation_"+ref_article).value).value = $("qte_moteur_article_"+ref_article).value;
			 maj_line_qte ($("qte_moteur_article_"+ref_article).value, $("ref_doc_line_article_"+ref_article).value, ref_article, $("ref_doc_line_indentation_"+ref_article).value);
			}
		}
   break;

  case "add":
	 	if ($("new_moteur_article_"+ref_article).value=="1") {
     	$("new_moteur_article_"+ref_article).value="0";
			$("qte_moteur_article_"+ref_article).value=parseFloat($("qte_moteur_article_"+ref_article).value)+1;
			add_new_line_article ($("ref_doc").value, ref_article, $("qte_moteur_article_"+ref_article).value, $("numero_serie_"+ref_article).value);
		} else {
			if ($("ref_doc_line_indentation_"+ref_article).value != "") {
				$("qte_moteur_article_"+ref_article).value=parseFloat($("qte_moteur_article_"+ref_article).value)+1;

				affichage_sn_update ($("ref_doc_line_indentation_"+ref_article).value, $("qte_moteur_article_"+ref_article).value, $("qte_old_"+$("ref_doc_line_indentation_"+ref_article).value).value);

				$("qte_"+$("ref_doc_line_indentation_"+ref_article).value).value = $("qte_moteur_article_"+ref_article).value;
				$("qte_old_"+$("ref_doc_line_indentation_"+ref_article).value).value = $("qte_moteur_article_"+ref_article).value;
				maj_line_qte ($("qte_moteur_article_"+ref_article).value, $("ref_doc_line_article_"+ref_article).value, ref_article, $("ref_doc_line_indentation_"+ref_article).value);
			}
		}
		break;

  case "sub":
	 	if ($("new_moteur_article_"+ref_article).value=="1") {
     	$("new_moteur_article_"+ref_article).value="0";
			$("qte_moteur_article_"+ref_article).value=parseFloat($("qte_moteur_article_"+ref_article).value)-1;
			add_new_line_article ($("ref_doc").value, ref_article, $("qte_moteur_article_"+ref_article).value, $("numero_serie_"+ref_article).value);
		} else {
			if ($("ref_doc_line_indentation_"+ref_article).value != "") {
				$("qte_moteur_article_"+ref_article).value=parseFloat($("qte_moteur_article_"+ref_article).value)-1;

				affichage_sn_update ($("ref_doc_line_indentation_"+ref_article).value, $("qte_moteur_article_"+ref_article).value, $("qte_old_"+$("ref_doc_line_indentation_"+ref_article).value).value);

				$("qte_"+$("ref_doc_line_indentation_"+ref_article).value).value = $("qte_moteur_article_"+ref_article).value;
				$("qte_old_"+$("ref_doc_line_indentation_"+ref_article).value).value = $("qte_moteur_article_"+ref_article).value;

				maj_line_qte ($("qte_moteur_article_"+ref_article).value, $("ref_doc_line_article_"+ref_article).value, ref_article, $("ref_doc_line_indentation_"+ref_article).value);
			}
		}
    break;

  default:

   break;
}


}


	//fonction de mise à jour du contact depuis lla création d'un contact

function docu_maj_contact_request (ref_doc, ref_contact) {
		var AppelAjax = new Ajax.Request(
									"documents_contact_maj_request.php",
									{
									parameters: {ref_doc: ref_doc, ref_contact: ref_contact },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
//fonction de mise à jour du contact depuis le mini moteur de recherche de contact

function docu_maj_contact (ref_doc, ref_contact, lib_contact) {
		var AppelAjax = new Ajax.Updater(
									"block_head",
									"documents_contact_maj.php",
									{
									parameters: {ref_doc: ref_doc, ref_contact: ref_contact },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															update_document_liaisons ();
															charger_contenu_reglements();
															}
									}
									);
}

//fonction de mise à jour des infos texte du contact

function docu_maj_contact_infos (ref_doc, id_info_content) {
		var AppelAjax = new Ajax.Request(
									"documents_contact_maj_infos.php",
									{
									parameters: {ref_doc: ref_doc, id_info_content: id_info_content, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}


// affichage liste déroulante des adresses pour un contact sur un document

function pre_start_adresse_doc (survol, bt_survol, ref_contact, lib_adresse, user_adresse, choix_adresse, iframe_adresse, pagecible, ref_doc, type_adresse) {

//effet de survol sur le faux select
	Event.observe(survol, "mouseover",  function(){$(bt_survol).src=dirtheme+"images/bt_doc_choix_adresses_hover.gif";}, false);
	Event.observe(survol, "mousedown",  function(){$(bt_survol).src=dirtheme+"images/bt_doc_choix_adresses_down.gif";}, false);
	Event.observe(survol, "mouseup",  function(){$(bt_survol).src=dirtheme+"images/bt_doc_choix_adresses.gif";}, false);
	Event.observe(survol, "mouseout",  function(){$(bt_survol).src=dirtheme+"images/bt_doc_choix_adresses.gif";}, false);

//affichage des choix
	Event.observe(survol, "click",  function(evt){Event.stop(evt); start_adresse_doc (ref_contact, lib_adresse, user_adresse, choix_adresse, iframe_adresse, pagecible, ref_doc, type_adresse);}, false);

}

//affichage des adresses présentes dans la base de données pour un contact.
function start_adresse_doc (ref_contact, idtextarea, idinput, cible, iframecible, targeturl, ref_doc, type_adresse) {

if ($(cible).style.display=="none") {
	var AppelAjax = new Ajax.Updater(
																	cible,
																	targeturl,
																	{parameters: {ref_contact: ref_contact, choix_adresse: cible, iframe_choix_adresse: iframecible, input: idinput, textarea: idtextarea, ref_doc: ref_doc, type_adresse: type_adresse},
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function(requester) {
																						H_loading();
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}

//lance la mise à jour  d'une adresse de contact (selon le type d'adresse à changer

function documents_maj_adresse (ref_adresse, type_adresse, ref_doc, ref_contact) {
		var AppelAjax = new Ajax.Updater(
									"block_head",
									"documents_contact_maj_adresse.php",
									{
									parameters: {ref_doc: ref_doc, ref_contact: ref_contact, ref_adresse: ref_adresse, type_adresse: type_adresse },
									evalScripts:true,
									onLoading:S_loading
									}
									);
}



//***************************************************
//Mise à jour des lignes d'articles d'un document
//***************************************************

//maj de la ref_externe
function maj_line_ref_externe (ref_externe, old_ref_externe, ref_doc_line, ref_article, indentation) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_ref_externe.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, ref_article: ref_article, ref_externe: ref_externe, old_ref_externe: old_ref_externe, indentation: indentation },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//maj de l'ordre
function doc_line_maj_ordre (indent_ligne) {

	var ref_doc = $("ref_doc").value;
	var id_liste = indent_ligne.id;
	var ref_doc_line = $("ref_doc_line_"+id_liste.split("_")[1]).value;
	var newordre = 1;
	if (!$("lignes").empty()) {
		var liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
		t_liste = liste.split("&");
		document_calcul_tarif ();

		for (i=0; i < t_liste.length; i++) {
			if (t_liste[i] == id_liste.split("_")[1]) {
				var AppelAjax = new Ajax.Request(
										"documents_line_maj_ordre.php",
										{
										parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, ordre: newordre},
										evalScripts:true,
										onLoading: S_loading,
										onSuccess: function (requester){
											requester.responseText.evalScripts();
											H_loading();
										}
										}
										);
			}
			newordre = parseInt($("ordre_"+t_liste[i]).value) + 1;
		}
	}
}


//set_visible
function set_doc_line_visible (ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_set_visible.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										document_calcul_tarif ();
									}
									}
									);
}
//set_unvisible
function set_doc_line_unvisible (ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_set_unvisible.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										document_calcul_tarif ();
									}
									}
									);
}

//maj de la qte
function maj_line_qte (qte_article, ref_doc_line, ref_article, indentation) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_qte.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, ref_article: ref_article, qte_article: qte_article, indentation: indentation },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										document_calcul_tarif ();
									}
									}
									);
}

//maj lib_article
function maj_line_lib_article (id_lib_article, ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_lib_article.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, lib_article: escape ($(id_lib_article).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//maj desc_article
function maj_line_desc_article (id_desc_article, ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_desc_article.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, desc_article: escape($(id_desc_article).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//maj pu_ht
function maj_line_pu_ht (id_pu_ht, ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_pu_ht.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, pu_ht: $(id_pu_ht).value },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										document_calcul_tarif ();
									}
									}
									);
}
//maj remise
function maj_line_remise (remise, ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_remise.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, remise: remise },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										document_calcul_tarif ();
									}
									}
									);
}
//maj tva
function maj_line_tva (tva, ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_tva.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, tva: tva },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										document_calcul_tarif ();
									}
									}
									);
}

//sup ligne
function doc_sup_line (ref_doc_line) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_sup.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										document_calcul_tarif ();
									}
									}
									);
}

//add d'un numéro de série
function add_line_sn (ref_doc_line, sn, art_sn) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_add_sn.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, sn: sn, art_sn: art_sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//maj d'un numéro de série
function maj_line_sn (ref_doc_line, sn, new_sn, art_sn) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_sn.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, sn: sn, new_sn: new_sn, art_sn: art_sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//del d'un numéro de série
function del_line_sn (ref_doc_line, sn) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_del_sn.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, sn: sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}



function observe_RETURN_for_doc_line_sn (event, name, indent_art, indent_sn) {
	var key = event.which || event.keyCode;
	switch (key) {
	case Event.KEY_RETURN:
	if ($(name+"_"+indent_art+"_"+indent_sn)) {
		$(name+"_"+indent_art+"_"+indent_sn).focus();
	} else {
		if ($("art_gest_sn_finliste_"+indent_art)) {
			$("art_gest_sn_finliste_"+indent_art).focus();
		}
	}
	Event.stop(event);
	break;
	}
}

//double click sur champ sn incrémente les sn suivant si non déjà remplis
function incremente_sn(indentation_art, indentation_sn) {
	var ref_doc_line = $("ref_doc_line_"+indentation_art).value
	var nombre_ligne_sn =  Math.abs($("qte_"+indentation_art).value);

	if (nombre_ligne_sn >=  doc_aff_qte_sn) { nombre_ligne_sn = doc_aff_qte_sn;}
	var sn_de_depart = $("art_sn_"+indentation_art+"_"+indentation_sn).value;
	var u_field_num = Array.from(sn_de_depart);
	var defaut_num_serie = 0;
	var last_car_index = -1;
	var sn_indent = parseFloat (indentation_sn);
	for( i=0; i < u_field_num.length; i++ ) {
		if (isNaN(u_field_num[i])){
  	 last_car_index = i;
		}
	}

	first_sn_part = sn_de_depart.substring (0, last_car_index+1);
	num_sn_part = sn_de_depart.substring (last_car_index+1);

	if (num_sn_part !="") {
		zero_in_num_sn =  Array.from(num_sn_part);
		zero_before_increment = "";
		nomore_zero = false;
		count_zero = 0;
		for( j=0; j < zero_in_num_sn.length; j++ ) {
			if ((zero_in_num_sn[j] == "0") && (!nomore_zero )){
			 count_zero ++;
			} else {
				nomore_zero = true;
			}
		}

		new_increment_sn = parseFloat(num_sn_part.substring (count_zero));
		longeur_incre_onstart = (new_increment_sn.toString()) ;
		if (quantite_locked) {
			alert_qte_locked ();
		} else {
			for(i = 0; i< nombre_ligne_sn; i++) {
				zero_before_increment = "";
				if ($("art_sn_"+indentation_art+"_"+i) && (i > indentation_sn) ) {
					new_increment_sn++;
					reste_zero = count_zero - ((new_increment_sn.toString()).length - longeur_incre_onstart.length);
					if (reste_zero >0) {
						for( k=0; k < reste_zero; k++ ) {
							zero_before_increment += "0";
						}
					}

					if ($("art_sn_"+indentation_art+"_"+i).value == "") {
						$("old_art_sn_"+indentation_art+"_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;
						$("art_sn_"+indentation_art+"_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;
						add_line_sn (ref_doc_line, first_sn_part + "" + zero_before_increment + new_increment_sn, "art_sn_"+indentation_art+"_"+i);
					}
				}
			}
		}
	}

}

// sn remplis
function is_sn_filled () {
	var less_sn = false;
	var alarm_stock = false;
	if (!$("lignes").empty()) {
		if ($("livraison_pret") || $("livraison_livree") || $("bon_recept_pret") || $("trm_pret") || $("inventaire_valider")|| $("fab_terminee")) {
			var liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
			t_liste = liste.split("&");
			for (i=0; i < t_liste.length; i++) {
				if ($("qte_"+t_liste[i])) {
				nb_sn = parseInt(Math.abs($("qte_"+t_liste[i]).value));
					for (j=0; j < nb_sn; j++) {
						if ($("art_sn_"+t_liste[i]+"_"+j)) {
						 if ($("art_sn_"+t_liste[i]+"_"+j).value == "") {
								$("more_sn_"+t_liste[i]+"_"+j).className = "more_sn_class_r" ;
								less_sn = true;
							} else {
								$("more_sn_"+t_liste[i]+"_"+j).className = "more_sn_class" ;
							}
						}
					}
				}
				if (t_liste[i] != "undefined") {
					if ($("qte_"+t_liste[i]) && $("qte_"+t_liste[i]).style.color == "rgb(255, 0, 0)") {
					alarm_stock = true;
					}
				}
			}
					if (less_sn || alarm_stock) {
						if ($("livraison_pret")) {
							$("livraison_pret").src = dirtheme+"images/bt_blc_pret_r.gif";
						}
						if ($("livraison_livree_img")) {
							$("livraison_livree_img").src = dirtheme+"images/bt_blc_livrer_r.gif";
						}
						if ($("bon_recept_pret")) {
							$("bon_recept_pret").src = dirtheme+"images/bt_blf_reception_r.gif";
						}
						if ($("trm_pret")) {
							$("trm_pret").src = dirtheme+"images/bt_trm_pret_r.gif";
						}
					} else {
						if ($("livraison_pret")) {
							$("livraison_pret").src = dirtheme+"images/bt_blc_pret.gif";
						}
						if ($("livraison_livree_img")) {
							$("livraison_livree_img").src = dirtheme+"images/bt_blc_livrer.gif";
						}
						if ($("bon_recept_pret")) {
							$("bon_recept_pret").src = dirtheme+"images/bt_blf_reception.gif";
						}
						if ($("trm_pret")) {
							$("trm_pret").src = dirtheme+"images/bt_trm_pret.gif";
						}
					}

					if (less_sn) {
						$("doc_message_info").innerHTML = "Les num&eacute;ros de s&eacute;rie doivent &ecirc;tre renseign&eacute;s."
					} else {
						$("doc_message_info").innerHTML = "";
					}

			if ($("doc_alerte_stock") && gestion_stock) {
				if (alarm_stock) {
					$("doc_alerte_stock").innerHTML = "Stock insuffisant";
				} else {
					$("doc_alerte_stock").innerHTML = "";
				}
			}
		}
	}
}


//alerte de qté depassant le stock
function depasse_stock () {
	// pour eviter la surcharge la fonction a été intégrée à is_sn_filled
	is_sn_filled ();
}



//fonction de lancement des observateur d'event pour ligne de sn insérées par javascript
function pre_start_observer_sn (indentation_art, indentation_sn, ref_doc_line, art_sn, old_art_sn, sup_sn, more_sn, ref_article, choix_div, choix_iframe) {
	Event.observe("art_sn_"+indentation_art+"_"+indentation_sn, "keypress", function(evt){
								observe_RETURN_for_doc_line_sn (evt, "art_sn", indentation_art, parseInt(indentation_sn)+1);
								}, false);

	Event.observe("art_sn_"+indentation_art+"_"+indentation_sn, "dblclick", function(evt){
								incremente_sn(indentation_art, indentation_sn);
								is_sn_filled ();
								}, false);

	Event.observe(sup_sn, "click", function(evt){Event.stop(evt);
			del_line_sn (ref_doc_line, $(old_art_sn).value);
			$(old_art_sn).value = $(art_sn).value = "";
			is_sn_filled ();
			}, false);


	Event.observe(more_sn, "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				start_choix_sn (ref_article, art_sn, choix_div, choix_iframe, "documents_liste_choix_sn.php");
				is_sn_filled ();
			}
			}, false);

	Event.observe(art_sn, "blur", function(evt){
		if (quantite_locked) {
			if ($(art_sn).value != $(old_art_sn).value) {
				$(art_sn).value = $(old_art_sn).value;
				alert_qte_locked ();
			}
		} else {
			if ($(art_sn).value != $(old_art_sn).value) {
				if ($(old_art_sn).value != "") {
					if ($(art_sn).value == "") {
					del_line_sn (ref_doc_line, $(old_art_sn).value);
					$(old_art_sn).value = $(art_sn).value;
					} else {
					maj_line_sn (ref_doc_line, $(old_art_sn).value, $(art_sn).value, art_sn);
					$(old_art_sn).value = $(art_sn).value;
					}
				} else {
					add_line_sn (ref_doc_line, $(art_sn).value, art_sn);
					$(old_art_sn).value = $(art_sn).value;
				}
			}
		is_sn_filled ();
		}
	}, false);

	is_sn_filled ();
}

//fonction d'affichege des listes de sn pour un article

function start_choix_sn (ref_article, idinput, cible, iframecible, targeturl) {
	if ($(cible).style.display=="none") {
		var ref_doc = "";
		if ($("ref_doc")) {ref_doc = $("ref_doc").value; }

		var AppelAjax = new Ajax.Updater(
																	cible,
																	targeturl,
																	{parameters: {ref_article: ref_article, choix_sn: cible, iframe_choix_sn: iframecible, input: idinput, ref_doc: ref_doc},
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function(requester) {
																						H_loading();
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}




//numeros de lots

//del d'un numéro de lot
function del_line_nl (ref_doc_line, nl, qte_nl) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_del_nl.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, nl: nl, qte_nl: qte_nl},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}



function observe_RETURN_for_doc_line_nl (event, name, indent_art, indent_nl, qte_nl) {
	var key = event.which || event.keyCode;
	switch (key) {
	case Event.KEY_RETURN:
	if ($(name+"_"+indent_art+"_"+indent_sn)) {
		$(name+"_"+indent_art+"_"+indent_sn).focus();
	} else {
		if ($("art_gest_nl_finliste_"+indent_art)) {
			$("art_gest_nl_finliste_"+indent_art).focus();
		}
	}
	Event.stop(event);
	break;
	}
}

//fonction d'affichege des listes de sn pour un article

function start_choix_nl (ref_article, idinput, cible, iframecible, targeturl) {
	if ($(cible).style.display=="none") {
		var ref_doc = "";
		if ($("ref_doc")) {ref_doc = $("ref_doc").value; }

		var AppelAjax = new Ajax.Updater(
																	cible,
																	targeturl,
																	{parameters: {ref_article: ref_article, choix_sn: cible, iframe_choix_sn: iframecible, input: idinput, ref_doc: ref_doc},
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function(requester) {
																						H_loading();
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}



//maj d'un numéro de série
function maj_line_nl (ref_doc_line, nl, new_nl, old_qte_nl, new_qte_nl, art_nl, qte_nl) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_line_maj_nl.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_line: ref_doc_line, nl: nl, new_nl: new_nl, old_qte_nl: old_qte_nl, new_qte_nl: new_qte_nl, art_nl: art_nl, qte_nl: qte_nl},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}

//fonction de lancement des observateur d'event pour ligne de snlinsérées par javascript
function pre_start_observer_nl (indentation_art, indentation_nl, ref_doc_line, art_nl, old_art_nl, sup_nl, more_nl, ref_article, choix_div, choix_iframe, qte_nl, old_qte_nl) {
	Event.observe("art_nl_"+indentation_art+"_"+indentation_nl, "keypress", function(evt){
								observe_RETURN_for_doc_line_nl (evt, "qte_nl", indentation_art, parseInt(indentation_nl)+1, qte_nl);
								}, false);

	Event.observe(sup_nl, "click", function(evt){Event.stop(evt);
			del_line_nl (ref_doc_line, $(old_art_nl).value, $(qte_nl).value);
			$(old_art_nl).value = $(art_nl).value = "";
			$(old_qte_nl).value = $(qte_nl).value = "";
			}, false);


	Event.observe(more_nl, "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				start_choix_nl (ref_article, art_nl, choix_div, choix_iframe, "documents_liste_choix_nl.php");
				is_sn_filled ();
			}
			}, false);

	Event.observe(art_nl, "blur", function(evt){
		if (quantite_locked) {
			if ($(art_nl).value != $(old_art_nl).value) {
				$(art_nl).value = $(old_art_nl).value;
				alert_qte_locked ();
			}
		} else {
			if ($(art_nl).value != $(old_art_nl).value) {
					if ($(art_nl).value == "") {
						del_line_nl (ref_doc_line, $(old_art_nl).value, $(old_qte_nl).value);
						$(old_art_nl).value = $(art_nl).value = "";
						$(old_qte_nl).value = $(qte_nl).value = "";
					} else {
						maj_line_nl (ref_doc_line, $(old_art_nl).value, $(art_nl).value, $(old_qte_nl).value, $(qte_nl).value, art_nl, qte_nl);
						$(old_art_nl).value = $(art_nl).value;
						$(old_qte_nl).value = $(qte_nl).value;
					}
				}
		}
	}, false);

	Event.observe(qte_nl, "blur", function(evt){
		if (quantite_locked) {
			if ($(qte_nl).value != $(old_qte_nl).value) {
				$(qte_nl).value = $(old_qte_nl).value;
				alert_qte_locked ();
			}
		} else {
			if ($(qte_nl).value != $(old_qte_nl).value) {
					if ($(qte_nl).value == "") {
						del_line_nl (ref_doc_line, $(old_art_nl).value, $(old_qte_nl).value);
						$(old_art_nl).value = $(art_nl).value = "";
						$(old_qte_nl).value = $(qte_nl).value = "";
					} else {
						maj_line_nl (ref_doc_line, $(old_art_nl).value, $(art_nl).value, $(old_qte_nl).value, $(qte_nl).value, art_nl, qte_nl);
						$(old_art_nl).value = $(art_nl).value;
						$(old_qte_nl).value = $(qte_nl).value;
					}
				}
		}
	}, false);

}



//fonction d'insertion de ligne de nl par javascript
function insert_line_nl (indentation_art, indentation_nl) {
	var ref_doc_line = $("ref_doc_line_"+indentation_art).value;
	var zone= $("art_gest_nl_"+indentation_art);
	$("art_gest_nl_finliste_"+indentation_art).value = parseInt(indentation_nl)+1;
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "num_nl_"+indentation_art+"_"+indentation_nl);
	zone.appendChild(adddiv);

	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "more_nl_"+indentation_art+"_"+indentation_nl);
		addspan.setAttribute ("class", "more_sn_class");
		addspan.setAttribute ("className", "more_sn_class");
	$("num_nl_"+indentation_art+"_"+indentation_nl).appendChild(addspan);
	$("more_nl_"+indentation_art+"_"+indentation_nl).innerHTML = "Lot:";
	new Insertion.Bottom ($("num_nl_"+indentation_art+"_"+indentation_nl), " ");

	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "art_nl_"+indentation_art+"_"+indentation_nl);
		inputtext.setAttribute ("name", "art_nl_"+indentation_art+"_"+indentation_nl);
		inputtext.setAttribute ("type", "text");
		inputtext.setAttribute ("value", "");
		inputtext.setAttribute ("size", "10");
	$("num_nl_"+indentation_art+"_"+indentation_nl).appendChild(inputtext);
	new Insertion.Bottom ($("num_nl_"+indentation_art+"_"+indentation_nl), " ");

	var inputhidden= document.createElement("input");
		inputhidden.setAttribute ("id", "old_art_nl_"+indentation_art+"_"+indentation_nl);
		inputhidden.setAttribute ("name", "old_art_nl_"+indentation_art+"_"+indentation_nl);
		inputhidden.setAttribute ("type", "hidden");
		inputhidden.setAttribute ("value", "");
	$("num_nl_"+indentation_art+"_"+indentation_nl).appendChild(inputhidden);

	var inputtext2= document.createElement("input");
		inputtext2.setAttribute ("id", "qte_nl_"+indentation_art+"_"+indentation_nl);
		inputtext2.setAttribute ("name", "qte_nl_"+indentation_art+"_"+indentation_nl);
		inputtext2.setAttribute ("type", "text");
		inputtext2.setAttribute ("value", "");
		inputtext2.setAttribute ("size", "3");
	$("num_nl_"+indentation_art+"_"+indentation_nl).appendChild(inputtext2);

	var inputhidden2= document.createElement("input");
		inputhidden2.setAttribute ("id", "old_qte_nl_"+indentation_art+"_"+indentation_nl);
		inputhidden2.setAttribute ("name", "old_qte_nl_"+indentation_art+"_"+indentation_nl);
		inputhidden2.setAttribute ("type", "hidden");
		inputhidden2.setAttribute ("value", "");
	$("num_nl_"+indentation_art+"_"+indentation_nl).appendChild(inputhidden2);

	var addsup= document.createElement("a");
		addsup.setAttribute ("id", "sup_nl_"+indentation_art+"_"+indentation_nl);
		addsup.setAttribute ("href", "#");
		addsup.setAttribute ("class", "sn_a_none");
		addsup.setAttribute ("className", "sn_a_none");
	$("num_nl_"+indentation_art+"_"+indentation_nl).appendChild(addsup);
	$("sup_nl_"+indentation_art+"_"+indentation_nl).innerHTML = "&nbsp;";

	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
	$("sup_nl_"+indentation_art+"_"+indentation_nl).appendChild(addimgsup);

	var adddiv_block_nl= document.createElement("div");
		adddiv_block_nl.setAttribute ("id", "block_choix_nl_"+indentation_art+"_"+indentation_nl);
		adddiv_block_nl.setAttribute ("class", "sn_block_choix");
		adddiv_block_nl.setAttribute ("className", "sn_block_choix");
	$("num_nl_"+indentation_art+"_"+indentation_nl).appendChild(adddiv_block_nl);

	var addiframe_choix_nl= document.createElement("div");
		addiframe_choix_nl.setAttribute ("id", "iframe_liste_choix_nl_"+indentation_art+"_"+indentation_nl);
		addiframe_choix_nl.setAttribute ("frameborder", "0");
		addiframe_choix_nl.setAttribute ("scrolling", "no");
		addiframe_choix_nl.setAttribute ("src", "about:_blank");
		addiframe_choix_nl.setAttribute ("class", "choix_liste_choix_sn");
		addiframe_choix_nl.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_nl_"+indentation_art+"_"+indentation_nl).appendChild(addiframe_choix_nl);
		$("iframe_liste_choix_nl_"+indentation_art+"_"+indentation_nl).setStyle({   display: 'none' });

	var adddiv_choix_nl= document.createElement("div");
		adddiv_choix_nl.setAttribute ("id", "choix_liste_choix_nl_"+indentation_art+"_"+indentation_nl);
		adddiv_choix_nl.setAttribute ("class", "choix_liste_choix_sn");
		adddiv_choix_nl.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_nl_"+indentation_art+"_"+indentation_nl).appendChild(adddiv_choix_nl);
		$("choix_liste_choix_nl_"+indentation_art+"_"+indentation_nl).setStyle({   display: 'none' });

pre_start_observer_nl (indentation_art, indentation_nl, ref_doc_line, "art_nl_"+indentation_art+"_"+indentation_nl ,"old_art_nl_"+indentation_art+"_"+indentation_nl, "sup_nl_"+indentation_art+"_"+indentation_nl, "more_nl_"+indentation_art+"_"+indentation_nl, $("ref_article_"+indentation_art).value, "choix_liste_choix_nl_"+indentation_art+"_"+indentation_nl, "iframe_liste_choix_nl_"+indentation_art+"_"+indentation_nl, "qte_nl_"+indentation_art+"_"+indentation_nl ,"old_qte_nl_"+indentation_art+"_"+indentation_nl );
}


//fonction d'affichege des listes de sn pour un article

function start_choix_ref_externe (ref_article, idinput, cible, iframecible, targeturl) {
	if ($(cible).style.display=="none") {
		var ref_doc = "";
		if ($("ref_doc")) {ref_doc = $("ref_doc").value; }

		var AppelAjax = new Ajax.Updater(
																	cible,
																	targeturl,
																	{parameters: {ref_article: ref_article, choix_ref_externe: cible, iframe_choix_ref_externe: iframecible, input: idinput, ref_doc: ref_doc},
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function(requester) {
																						H_loading();
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}

//fonction d'insertion de ligne de sn par javascript
function insert_line_sn (indentation_art, indentation_sn) {
	var ref_doc_line = $("ref_doc_line_"+indentation_art).value;
	var zone= $("art_gest_sn_"+indentation_art);
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "num_sn_"+indentation_art+"_"+indentation_sn);
	zone.appendChild(adddiv);

	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "more_sn_"+indentation_art+"_"+indentation_sn);
		addspan.setAttribute ("class", "more_sn_class");
		addspan.setAttribute ("className", "more_sn_class");
	$("num_sn_"+indentation_art+"_"+indentation_sn).appendChild(addspan);
	$("more_sn_"+indentation_art+"_"+indentation_sn).innerHTML = "sn: ";

	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "art_sn_"+indentation_art+"_"+indentation_sn);
		inputtext.setAttribute ("name", "art_sn_"+indentation_art+"_"+indentation_sn);
		inputtext.setAttribute ("type", "text");
		inputtext.setAttribute ("value", "");
	$("num_sn_"+indentation_art+"_"+indentation_sn).appendChild(inputtext);

	var inputhidden= document.createElement("input");
		inputhidden.setAttribute ("id", "old_art_sn_"+indentation_art+"_"+indentation_sn);
		inputhidden.setAttribute ("name", "old_art_sn_"+indentation_art+"_"+indentation_sn);
		inputhidden.setAttribute ("type", "hidden");
		inputhidden.setAttribute ("value", "");
	$("num_sn_"+indentation_art+"_"+indentation_sn).appendChild(inputhidden);

	var addsup= document.createElement("a");
		addsup.setAttribute ("id", "sup_sn_"+indentation_art+"_"+indentation_sn);
		addsup.setAttribute ("href", "#");
		addsup.setAttribute ("class", "sn_a_none");
		addsup.setAttribute ("className", "sn_a_none");
	$("num_sn_"+indentation_art+"_"+indentation_sn).appendChild(addsup);
	$("sup_sn_"+indentation_art+"_"+indentation_sn).innerHTML = "&nbsp;";

	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
	$("sup_sn_"+indentation_art+"_"+indentation_sn).appendChild(addimgsup);

	var adddiv_block_sn= document.createElement("div");
		adddiv_block_sn.setAttribute ("id", "block_choix_sn_"+indentation_art+"_"+indentation_sn);
		adddiv_block_sn.setAttribute ("class", "sn_block_choix");
		adddiv_block_sn.setAttribute ("className", "sn_block_choix");
	$("num_sn_"+indentation_art+"_"+indentation_sn).appendChild(adddiv_block_sn);

	var addiframe_choix_sn= document.createElement("div");
		addiframe_choix_sn.setAttribute ("id", "iframe_liste_choix_sn_"+indentation_art+"_"+indentation_sn);
		addiframe_choix_sn.setAttribute ("frameborder", "0");
		addiframe_choix_sn.setAttribute ("scrolling", "no");
		addiframe_choix_sn.setAttribute ("src", "about:_blank");
		addiframe_choix_sn.setAttribute ("class", "choix_liste_choix_sn");
		addiframe_choix_sn.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_sn_"+indentation_art+"_"+indentation_sn).appendChild(addiframe_choix_sn);
		$("iframe_liste_choix_sn_"+indentation_art+"_"+indentation_sn).setStyle({   display: 'none' });

	var adddiv_choix_sn= document.createElement("div");
		adddiv_choix_sn.setAttribute ("id", "choix_liste_choix_sn_"+indentation_art+"_"+indentation_sn);
		adddiv_choix_sn.setAttribute ("class", "choix_liste_choix_sn");
		adddiv_choix_sn.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_sn_"+indentation_art+"_"+indentation_sn).appendChild(adddiv_choix_sn);
		$("choix_liste_choix_sn_"+indentation_art+"_"+indentation_sn).setStyle({   display: 'none' });

pre_start_observer_sn (indentation_art, indentation_sn, ref_doc_line, "art_sn_"+indentation_art+"_"+indentation_sn ,"old_art_sn_"+indentation_art+"_"+indentation_sn, "sup_sn_"+indentation_art+"_"+indentation_sn, "more_sn_"+indentation_art+"_"+indentation_sn, $("ref_article_"+indentation_art).value, "choix_liste_choix_sn_"+indentation_art+"_"+indentation_sn, "iframe_liste_choix_sn_"+indentation_art+"_"+indentation_sn );
}

//modifier le nombre de ligne de numéro de série en cas e changement de quantité
function affichage_sn_update (indentation_art, new_qte, old_qte) {
	var maj_qte = parseInt(Math.abs(new_qte));
	var prev_qte = parseInt(Math.abs(old_qte));
	if ($("aff_all_sn_"+indentation_art)) {$("aff_all_sn_"+indentation_art).style.display= "none";}
	if (prev_qte >=  doc_aff_qte_sn) {
		prev_qte = doc_aff_qte_sn;
	}
	if (maj_qte >  doc_aff_qte_sn) {
		if ($("aff_all_sn_"+indentation_art)) {$("aff_all_sn_"+indentation_art).style.display= "";}
	}
	if (maj_qte >=  doc_aff_qte_sn) {
		maj_qte = doc_aff_qte_sn;
	}
		if (($("art_gest_sn_"+indentation_art)) && (maj_qte != prev_qte)) {
			if (maj_qte > prev_qte) {
				diff = maj_qte-prev_qte;
				for (k=prev_qte ; k <maj_qte; k++) {
					if (diff != 0) {
						insert_line_sn (indentation_art, maj_qte-diff );
						diff = diff-1;
					}
				}

			} else {
				diff= prev_qte-maj_qte ;
				for (j=0 ; j <prev_qte; j++) {
					if (j < maj_qte) {
					} else {
						if (diff != 0) {
							if ($("old_art_sn_"+indentation_art+"_"+j) && $("old_art_sn_"+indentation_art+"_"+j).value!="") {
								del_line_sn ($("ref_doc_line_"+indentation_art).value, $("old_art_sn_"+indentation_art+"_"+j).value)
							}
							if ($("num_sn_"+indentation_art+"_"+j)) {
								remove_tag("num_sn_"+indentation_art+"_"+j);
							}
							diff = diff-1;
						}
					}
				}


			}

		}
}

//***************************************************************
//MAJ INFOS DOCUMENT
//***************************************************************

//fonction de maj app_tarif
function maj_app_tarifs (new_app_tarifs) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_app_tarifs.php",
									{
									parameters: {ref_doc: ref_doc, new_app_tarifs: new_app_tarifs},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);

}

//maj date_livraison
function maj_date_livraison  (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_date_livraison.php",
									{
									parameters: {ref_doc: ref_doc, id_info_content: id_info_content, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
//maj_date_validite
function maj_date_validite  (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
									"block_head",
									"documents_entete_maj_date_validite.php",
									{
									parameters: {ref_doc: ref_doc, id_info_content: id_info_content, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															$(id_info_content).style.color = requester.responseText;
															H_loading();
															}
									}
									);
}
//maj date_creation
function maj_date_creation  (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_date_creation.php",
									{
									parameters: {ref_doc: ref_doc, id_info_content: id_info_content, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															$(id_info_content).style.color = requester.responseText;
															H_loading();
															}
									}
									);
}
//maj date_echeance
function maj_date_echeance  (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_date_echeance.php",
									{
									parameters: {ref_doc: ref_doc, id_info_content: id_info_content, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															$(id_info_content).style.color = requester.responseText;
															H_loading();
															}
									}
									);
}
//maj_allow_rmb
function maj_allow_rmb  (new_allow_rmb) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
									"block_head",
									"documents_entete_maj_allow_rmb.php",
									{
									parameters: {ref_doc: ref_doc, new_allow_rmb: new_allow_rmb },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															$(id_info_content).style.color = requester.responseText;
															H_loading();
															}
									}
									);
}
//maj ref_doc_externe
function maj_ref_doc_externe  (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_ref_doc_externe.php",
									{
									parameters: {ref_doc: ref_doc, info_content : escape($F(id_info_content)) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}

//maj ref_doc_description
function maj_doc_description  (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_maj_doc_description.php",
									{
									parameters: {ref_doc: ref_doc, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
//maj de l'etat du doc ne demandant qu'un rechargement de l'entete
function maj_etat_doc (new_etat_doc) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
																"block_head",
																"documents_entete_maj_etat_doc.php",
																{
																parameters: {ref_doc: ref_doc, etat_doc: new_etat_doc },
																evalScripts:true,
																onLoading:S_loading, onException: function () {S_failure();},
															 	onComplete: function() {
																	charger_contenu_options();
																	update_document_liaisons ();
																}
																}
																);
}
//maj de l'etat du doc ne demandant qu'un rechargement de l'entete et gestion du cycle de vente
function maj_etat_doc_cycle (new_etat_doc, global_option) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
																"block_head",
																"documents_entete_maj_etat_doc.php",
																{
																parameters: {ref_doc: ref_doc, etat_doc: new_etat_doc, global_option: global_option },
																evalScripts:true,
																onLoading:S_loading, onException: function () {S_failure();},
															 	onComplete: function() {
																	charger_contenu_options();
																	update_document_liaisons ();
																}
																}
																);
}
//maj de l'etat du document demandant un chargement dun autre document en lieu et place de l'autre
//ex: devis accepte -> commande client
function maj_etat_open_doc (new_etat_doc) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															 "sub_content",
															 "documents_entete_maj_etat_open_doc.php",
															 {
															 parameters: {ref_doc: ref_doc, etat_doc: new_etat_doc },
															 evalScripts:true,
															 onLoading:S_loading
															 }
															 );
}
function maj_etat_open_doc_cycle (new_etat_doc, global_option) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															 "sub_content",
															 "documents_entete_maj_etat_open_doc.php",
															 {
															 parameters: {ref_doc: ref_doc, etat_doc: new_etat_doc, global_option: global_option },
															 evalScripts:true,
															 onLoading:S_loading
															 }
															 );
}
//generer un document
function generer_document (fonction_generer) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															 "sub_content",
															 "documents_edition_generer.php",
															 {
															 parameters: {ref_doc: ref_doc, fonction_generer: fonction_generer },
															 evalScripts:true,
															 onLoading:S_loading
															 }
															 );
}
//generer un document ref_doc en variable
function generer_document_doc (fonction_generer, ref_doc) {

	var AppelAjax = new Ajax.Request(
															 "documents_edition_generer_blank.php",
															 {
															 parameters: {ref_doc: ref_doc, fonction_generer: fonction_generer },
															 evalScripts:true,
																onSuccess: function (requester){
																	requester.responseText.evalScripts();
																	H_loading();
																}
															 }
															 );
}

//chargement du contenu pour la création d'un modèle de contenu
function charger_contenu_modeles(){
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															"mod_contenu_content",
															"documents_mod_contenu.php",
															{
															parameters: {ref_doc: ref_doc},
															evalScripts:true,
															onLoading:S_loading, onException: function () {S_failure();},
															onComplete: function() {
																						H_loading();
																						}
															}
															);

}

//chargement du contenu des evennements pour un document
function charger_contenu_events() {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															"historique_content",
															"documents_events.php",
															{
															parameters: {ref_doc: ref_doc},
															evalScripts:true,
															onLoading:S_loading, onException: function () {S_failure();},
															onComplete: function() {
																						H_loading();
																						}
															}
															);
}

//chargement du contenu des options avancees pour un document
function charger_contenu_options() {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															"options_avancees",
															"documents_options.php",
															{
															parameters: {ref_doc: ref_doc},
															evalScripts:true,
															onLoading:S_loading, onException: function () {S_failure();},
															onComplete: function() {
																						H_loading();
																						}
															}
															);
}


//chargement du contenu des règlements pour un document
function charger_contenu_reglements() {
	param_get= "";
	if (montant_total_neg) {
	param_get= "?montant_neg=1";
	}
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															"reglements_content",
															"documents_reglements.php"+param_get,
															{
															parameters: {ref_doc: ref_doc},
															evalScripts:true,
															onLoading:S_loading, onException: function () {S_failure();},
															onComplete: function() {
																						H_loading();
																						}
															}
															);
}

//maj d'un event

function maj_doc_event (ref_doc_event, date_event, id_event_type, d_event) {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_events_maj.php",
									{
									parameters: {ref_doc: ref_doc, ref_doc_event : $(ref_doc_event).value , date_event : $(date_event).value, id_event_type : $(id_event_type).value , d_event : $(d_event).value  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}

// fonction de maj de l'id_magasin pour un FAC
function maj_entete_id_magasin (id_magasin) {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_id_magasin.php",
									{
									parameters: {ref_doc: ref_doc, id_magasin : $(id_magasin).value  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
// fonction de maj de l'id stock pour un BLC CDC BLF CDF
function maj_entete_id_stock (id_stock) {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_id_stock.php",
									{
									parameters: {ref_doc: ref_doc, id_stock : $(id_stock).value  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
// fonction de maj de l'id stock source pour un TRM
function maj_entete_id_stock_source (id_stock_source) {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_id_stock_source.php",
									{
									parameters: {ref_doc: ref_doc, id_stock_source : $(id_stock_source).value  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
// fonction de maj de l'id stock cible pour un TRM
function maj_entete_id_stock_cible (id_stock_cible) {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_id_stock_cible.php",
									{
									parameters: {ref_doc: ref_doc, id_stock_cible : $(id_stock_cible).value  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
//maj date_echeance
function maj_date_next_relance  (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_date_next_relance.php",
									{
									parameters: {ref_doc: ref_doc, id_info_content: id_info_content, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}
//maj id_niveau_relance
function maj_id_niveau_relance (id_info_content) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
									"block_head",
									"documents_entete_maj_id_niveau_relance.php",
									{
									parameters: {ref_doc: ref_doc, info_content : $(id_info_content).value },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}

//fonction de mise à jour de la ref_contact pour les entete de document depuis le mini moteur de recherche de contact

function recherche_doc_transporteur_set_contact (id_ref_contact, id_lib_contact, ref_contact, lib_contact) {
	$(id_ref_contact).value = ref_contact;
	$(id_lib_contact).value = lib_contact;
	 maj_entete_ref_transporteur (ref_contact);
}
function maj_entete_ref_transporteur (ref_transporteur) {

	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_entete_maj_ref_transporteur.php",
									{
									parameters: {ref_doc: ref_doc, ref_transporteur : ref_transporteur  },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}

// gestion de changement d'affichage dans un document si total négatif
function total_negatif (bool) {
	if (montant_total_neg != bool) {
		montant_total_neg = bool;
		var ref_doc = $("ref_doc").value;
		if (montant_total_neg && $("reglement_choix_type")) {
		var AppelAjax = new Ajax.Updater(
										"reglement_choix_type",
										"documents_reglements_choix.php",
										{
										parameters: {ref_doc: ref_doc, montant_neg : 1 },
										evalScripts:true,
										onLoading:S_loading, onException: function () {S_failure();},
										onComplete: function() {
																H_loading();
																}
										}
										);
		}
		if (!montant_total_neg && $("reglement_choix_type")) {
		var AppelAjax = new Ajax.Updater(
										"reglement_choix_type",
										"documents_reglements_choix.php",
										{
										parameters: {ref_doc: ref_doc},
										evalScripts:true,
										onLoading:S_loading, onException: function () {S_failure();},
										onComplete: function() {
																H_loading();
																}
										}
										);
		}
	}
	//if (bool && $("facture_a_regler")) {
	//	$("facture_a_regler").src = dirtheme+"images/bt_avc_generer.gif"
	//}else if ($("facture_a_regler")) {
	//	$("facture_a_regler").src = dirtheme+"images/bt_fac_aregler.gif"
	//}
	//if (bool && $("a_facturer")) {
	//	$("a_facturer").src = dirtheme+"images/bt_avc_generer.gif"
	//}else if ($("a_facturer")) {
	//	$("a_facturer").src = dirtheme+"images/bt_blc_facturer.gif"
	//}
}

//lancement de la fonction en cas d'ajout de ligne
function add_loaded_line_doc () {
	loaded_line_doc ++;
	if (wait_for_x_line_doc == loaded_line_doc) {
		document_calcul_tarif ();
	}
}

//******************************************************
//fonction de calcul des tarifs affichés
//******************************************************

function document_calcul_tarif (bool) {

	start_date2 = new Date;
	//$("sub_content").setStyle({background: '#FF0000'});
	var pt_ht = 0;
	var pt_ttc = 0;
	var toto_tva = 0;
	var distinct_tva = new Array();
	var aff_distinct_intit_tva = "";
	var aff_distinct_tva = "";
	var tva_count = 0;
	var last_sstoto = 0;
//	var panier_content = new Array();

	if (!$("lignes").empty()) {
		//alert("calcul");
		var liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
		t_liste = liste.split("&");

	interm_date = new Date;

		if ($("prix_afficher_ht").checked) {
		app_tarif= $("prix_afficher_ht").value;
		$("col_pu").innerHTML = "PU HT";
		$("col_pt").innerHTML = "PT HT";
		} else {
		app_tarif= $("prix_afficher_ttc").value;
		$("col_pu").innerHTML = "PU TTC";
		$("col_pt").innerHTML = "PT TTC";
		}

		for (i=0; i < t_liste.length; i++) {
			if ($("pt_"+t_liste[i])) {
				//calcul en fonction du prix
				prix_u = (parseFloat ($("pu_ht_"+t_liste[i]).value)).toFixed(calcul_tarifs_nb_decimales);
				qte_a = parseFloat ($("qte_"+t_liste[i]).value);
				remise_a = 1 - (parseFloat ($("remise_"+t_liste[i]).value)/100);
				tva_a = 1 + (parseFloat ($("tva_"+t_liste[i]).value)/100);

				if (app_tarif == "HT") {

					$("pu_"+t_liste[i]).value = (prix_u*1).toFixed(tarifs_nb_decimales);

					$("pt_"+t_liste[i]).value = ((prix_u * qte_a) * remise_a).toFixed(tarifs_nb_decimales);

				}	else {

					$("pu_"+t_liste[i]).value = (prix_u * tva_a).toFixed(tarifs_nb_decimales);

					$("pt_"+t_liste[i]).value = (((prix_u * qte_a) * remise_a) * tva_a).toFixed(tarifs_nb_decimales);

				}
				if (($("visible_"+t_liste[i]).style.display != "none")) {
					if (!distinct_tva[$("tva_"+t_liste[i]).value]) {
						distinct_tva[$("tva_"+t_liste[i]).value] = ((((prix_u * qte_a) * remise_a) * tva_a) - ((prix_u * qte_a) * remise_a));
						tva_count++;
					} else {
						distinct_tva[$("tva_"+t_liste[i]).value] = parseFloat (distinct_tva[$("tva_"+t_liste[i]).value]) + ((((prix_u * qte_a) * remise_a) * tva_a) - ((prix_u * qte_a) * remise_a));

					}


					// totaux
					pt_ht = pt_ht + ((prix_u * qte_a) * remise_a);

					pt_ttc = pt_ttc + (((prix_u * qte_a) * remise_a) * tva_a) ;

					toto_tva = toto_tva + ((((prix_u * qte_a) * remise_a) * tva_a) - ((prix_u * qte_a) * remise_a));

					//ajout au panier
					//panier_content.push(t_liste[i]);
				}
			}
			// ligne sous total
			if ($("ss_toto_"+t_liste[i])){
				if ($("prix_afficher_ht").checked) {
					$("ss_toto_"+t_liste[i]).innerHTML = (parseFloat (pt_ht).toFixed(tarifs_nb_decimales) -  parseFloat (last_sstoto).toFixed(tarifs_nb_decimales)).toFixed(tarifs_nb_decimales);
					$("pu_ht_"+t_liste[i]).value = (parseFloat (pt_ht).toFixed(tarifs_nb_decimales) -  parseFloat (last_sstoto).toFixed(tarifs_nb_decimales)).toFixed(tarifs_nb_decimales);
					last_sstoto =  parseFloat (pt_ht).toFixed(tarifs_nb_decimales);
				} else {
					$("ss_toto_"+t_liste[i]).innerHTML = (parseFloat (pt_ttc).toFixed(tarifs_nb_decimales) - parseFloat (last_sstoto).toFixed(tarifs_nb_decimales)).toFixed(tarifs_nb_decimales);
					$("pu_ht_"+t_liste[i]).value = (parseFloat (pt_ht).toFixed(tarifs_nb_decimales) -  parseFloat (last_sstoto).toFixed(tarifs_nb_decimales)).toFixed(tarifs_nb_decimales);
					last_sstoto = parseFloat (pt_ttc).toFixed(tarifs_nb_decimales);
				}
				if ($("pu_ht_old_"+t_liste[i]).value != "" && $("pu_ht_"+t_liste[i]).value != $("pu_ht_old_"+t_liste[i]).value && bool!=true) {
					$("pu_ht_old_"+t_liste[i]).value = $("pu_ht_"+t_liste[i]).value;
					maj_line_pu_ht ("pu_ht_"+t_liste[i], $("ref_doc_line_"+t_liste[i]).value);
				}
			}
		}


	}
	d=0;
	for (var propriete in distinct_tva)  {
		if (!isNaN(propriete)) {
			aff_distinct_intit_tva = aff_distinct_intit_tva + propriete + "% : <br />";
			aff_distinct_tva = aff_distinct_tva +  Number (distinct_tva[propriete]).toFixed(tarifs_nb_decimales) + " " + monnaie_html + "<br />";
		}
	d++ ;
	}

	 $("distinct_intit_tva").innerHTML = aff_distinct_intit_tva;
	 $("distinct_toto_tva").innerHTML = aff_distinct_tva;

	//affichage des totaux
	$("pt_ht").innerHTML = parseFloat (pt_ht).toFixed(tarifs_nb_decimales) + " " + monnaie_html;
	$("pt_ttc").innerHTML = parseFloat (pt_ttc).toFixed(tarifs_nb_decimales) + " " + monnaie_html;
	$("toto_tva").innerHTML = parseFloat (toto_tva).toFixed(tarifs_nb_decimales) + " " + monnaie_html;
	$("d_toto_tva").innerHTML = parseFloat (toto_tva).toFixed(tarifs_nb_decimales) + " " + monnaie_html;

	//alert en cas de résultat négatif
	if (pt_ht < 0) {
		total_negatif (true);
	} else {
		total_negatif (false);
	}
	//recharger l'entete si l'encours

	if ($("encours") && bool!= true) {
		if ((parseFloat($("encours").value) < parseFloat (pt_ttc).toFixed(tarifs_nb_decimales)) && allow_recalcul_encours) {
			page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc='+$("ref_doc").value,'true','block_head');
			allow_recalcul_encours = false;
		}
		if ((parseFloat($("encours").value) >= parseFloat (pt_ttc).toFixed(tarifs_nb_decimales)) && !allow_recalcul_encours) {
			page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc='+$("ref_doc").value,'true','block_head');
			allow_recalcul_encours = true;
		}
	}


	// calcul du reste dûe si il existe
	if ($("montant_acquite")) {
			$("affichage_paiement_rapide").show();
		montant_restant_due = ((parseFloat (pt_ttc).toFixed(tarifs_nb_decimales)) - (parseFloat ($("montant_acquite").innerHTML).toFixed(tarifs_nb_decimales))).toFixed(tarifs_nb_decimales);

		if (montant_total_neg) {
		montant_restant_due = (parseFloat (pt_ttc)+(parseFloat ($("montant_acquite").innerHTML))).toFixed(tarifs_nb_decimales);
		}
			if ((montant_restant_due <= 0 && !montant_total_neg) || (montant_restant_due >= 0 && montant_total_neg)) {
				$("affichage_paiement_rapide").hide();
				if ($("reglement_done")) {
					$("reglement_done").show();
					$("reglement_partiel").hide();
				}
				$("montant_due").innerHTML = montant_restant_due;
				if ($("reglement_done2")) {
					$("reglement_done2").show();
					$("reglement_partiel2").hide();
					$("reglements_types").hide();
					$("liste_docs_nonreglees").hide();
				}
					if ($("cree_avoir")) {
						$("cree_avoir").hide();
					}
				if ($("reglement_partiel2")) {
					$("montant_due2").innerHTML = montant_restant_due;
				}
			} else {
					if ($("cree_avoir")) {
						$("cree_avoir").hide();
					}
				if ($("reglement_done")) {
					$("reglement_partiel").show();
					$("reglement_done").hide();
				}
				$("montant_due").innerHTML = montant_restant_due;
				if ($("reglement_done2")) {
					$("reglement_done2").hide();
					$("reglement_partiel2").show();
					$("reglements_types").show();
					$("liste_docs_nonreglees").show();
				}
					if ($("cree_avoir") && montant_restant_due < 0 && montant_total_neg && ($("ref_contact") && $("ref_contact").value != "" )) {
						$("cree_avoir").show();
					}
			if ($("reglement_partiel2")) {
				$("montant_due2").innerHTML = montant_restant_due;
			}

		}
		if ($("montant_reglement")) {
			$("montant_reglement").value = montant_restant_due;
		}
	}

	if ($("montant_total_reglement")) {
		$("montant_total_reglement").innerHTML = parseFloat (pt_ttc).toFixed(tarifs_nb_decimales);
		if ($("montant_total_reglement2")) {
			$("montant_total_reglement2").innerHTML = parseFloat (pt_ttc).toFixed(tarifs_nb_decimales);
		}
		if ($("document_contact_entete")) {
			if (return_height_element("document_contact_entete") > return_height_element("document_reglement_entete")) {
			$("document_reglement_entete").style.height = return_height_element("document_contact_entete") +"px";
			} else {
			$("document_contact_entete").style.height = return_height_element("document_reglement_entete") +"px";
			}
		}
	}
	//total dans panier
	$("panier_total").innerHTML = "";
	if ($("prix_afficher_ht").checked) {
		$("panier_total").innerHTML = parseFloat (pt_ht).toFixed(tarifs_nb_decimales) + " " + monnaie_html + " HT ";
	} else {
		$("panier_total").innerHTML = parseFloat (pt_ttc).toFixed(tarifs_nb_decimales) + " " + monnaie_html + " TTC ";
	}


	aff_panier ();

	end_date = new Date;
	//alert ((parseInt(start_date.getTime())-parseInt(start_date2.getTime()))+"..."+(parseInt(start_date.getTime())-parseInt(interm_date.getTime()))+"..."+(parseInt(start_date.getTime())-parseInt(end_date.getTime())));
	H_loading();

$("wait_calcul_content").style.display= "none";
}

//fonction de création de l'affichage du panier
function aff_panier (){
	var panier_cc= $("panier_content");
	$("panier_content").innerHTML = "";
	var ref_doc = $("ref_doc").value;

		var AppelAjax = new Ajax.Updater(
										"panier_content",
										"documents_edition_panier.php",
										{
										parameters: {ref_doc: ref_doc},
										evalScripts:true,
										onLoading:S_loading, onException: function () {S_failure();},
										onComplete: function() {
																H_loading();
																}
										}
										);
}

//fonction de calcul pour un reglement sur plusieurs documents
function add_doc_to_toto( ref_doc, montant_doc) {
	if ($("montant_due2")) {
		if ($("montant_reglement")) {
			$("montant_reglement").value = Math.abs(parseFloat (montant_doc) + parseFloat ($("montant_due2").innerHTML)).toFixed(tarifs_nb_decimales);
		}
		$("montant_due2").innerHTML = (parseFloat (montant_doc) + parseFloat ($("montant_due2").innerHTML)).toFixed(tarifs_nb_decimales);
		if ($("montant_total_reglement2")){
                    $("montant_total_reglement2").innerHTML = (parseFloat (montant_doc) + parseFloat ($("montant_total_reglement2").innerHTML)).toFixed(tarifs_nb_decimales);
                }
		reglement_set_doc (ref_doc);
	}
}

function del_doc_to_toto( ref_doc, montant_doc) {
	if ($("montant_due2")) {
		if ($("montant_reglement")) {
			$("montant_reglement").value = Math.abs(parseFloat ($("montant_due2").innerHTML) - parseFloat (montant_doc)).toFixed(tarifs_nb_decimales);
		}
		$("montant_due2").innerHTML = (parseFloat ($("montant_due2").innerHTML) - parseFloat (montant_doc)).toFixed(tarifs_nb_decimales);
                if ($("montant_total_reglement2")){
                    $("montant_total_reglement2").innerHTML = (parseFloat ($("montant_total_reglement2").innerHTML) - parseFloat (montant_doc)).toFixed(tarifs_nb_decimales);
                }
		remove_tag("docs_"+ref_doc);
	}
}

function reglement_set_doc (ref_doc) {
	var zone= $("docs_liste");
	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "docs_"+ref_doc);
		inputtext.setAttribute ("name", "docs_"+ref_doc);
		inputtext.setAttribute ("type", "hidden");
		inputtext.setAttribute ("value", ref_doc);
	zone.appendChild(inputtext);
}

//*****************************************************************
//fonction pour les actions sur les lignes d'articles sélectionnées
//*****************************************************************
// cocher / decocher / inverser selection des lignes

function all_line_coche (type_action) {

	if (!$("lignes").empty()) {
		var liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
		t_liste = liste.split("&");
		for (i = 0; i < t_liste.length; i++) {

			if (t_liste[i] != "undefined") {
				switch (type_action) {
					case "inv_coche" :
						if ($("check_"+t_liste[i]).checked == false) {
							$("check_"+t_liste[i]).checked = true;
						}
						else {
							$("check_"+t_liste[i]).checked = false;
						}
						break;
					case 'coche' :
							$("check_"+t_liste[i]).checked = true;
						break;
					case 'decoche'  :
							$("check_"+t_liste[i]).checked = false;
						break;
					default :
					break;
				}
			}
		}
	}
}



// action sur les lignes selectionnées
function action_line_coche (proto_name) {
	this.proto_name = proto_name;
	this.type_action = "";
	this.id_tarif = "";
	this.lignes = new Array();
}

action_line_coche.prototype = {
	initialize : function() {
	},
	//verification qu'un message d'alerte ne dois pas être déclenché
	action : function(type_action) {
		this.type_action = type_action;
		this.lignes = new Array();
		if (!$("lignes").empty()) {
			this.liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
			t_liste = this.liste.split("&");
			for (i = 0; i < t_liste.length; i++) {
				if (t_liste[i] != "undefined") {
					if ($("check_"+t_liste[i]).checked) {
						this.lignes.push ($("ref_doc_line_"+t_liste[i]).value);
					}
				}
			}
			if (this.lignes.length >0) {
				if (this.type_action.match('set_pu_ht_to_id_tarif')) {
					this.id_tarif = this.type_action.replace("set_pu_ht_to_id_tarif_", "");
					this.type_action = 'set_pu_ht_to_id_tarif';
					this.confirmer_action_selection ('Confirmer l\'action', "Changer le tarif pour la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
				}

				switch (this.type_action) {
								case "delete_multiples_lines" :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case "copie_line_to_doc" :
									if ($("ref_contact") && $("ref_contact").value != "") {
										$("ref_contact_doc_m").value = $("ref_contact").value;
										 $("ref_contact_nom_doc_m").innerHTML = $("nom_contact").value.substring(0,26);
									}
									show_mini_moteur_documents ('copie_lines_to_doc', '\''+$("ref_doc").value+'\'');
									break;
								case "copie_line_to_newdoc" :
									if ($("ref_contact") && $("ref_contact").value != "") {
										$("ref_contact_doc_nm").value = $("ref_contact").value;
										 $("ref_contact_nom_doc_nm").innerHTML = $("nom_contact").value.substring(0,26);
									}
									show_mini_moteur_newdocuments ('copie_lines_to_new_doc', $("ref_doc").value);
									break;
								case 'generer_commande_client' :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_bl_client'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_devis_client'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_retour_client'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_facture_avoir_client'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'reset_pu_ht'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_fa_fournisseur'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_br_fournisseur'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_retour_fournisseur'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_commande_fournisseur'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'generer_devis_fournisseur'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'lines_maj_pa'  :
									this.confirmer_action_selection ('Confirmer l\'action', "Confirmer l\'action sur la sélection.<br/>",'<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
									break;
								case 'maj_tva_liste'  :
									$('pop_up_lines_liste_tva_doc').style.display = "block";
									break;
								default :
								break;
				}
			} else {
			$("coche_action").selectedIndex = 0;
			}
		}

	},
	confirmer_action_selection : function  (alerte_titre, alerte_texte, alerte_bouton) {

		$("titre_alert").innerHTML = alerte_titre;
		$("texte_alert").innerHTML = alerte_texte;
		$("bouton_alert").innerHTML = alerte_bouton;

		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";

		Event.observe("bouton0", "click", this.undo_selected_action, false);
		Event.observe("bouton1", "click", this.do_selected_action, false);

	},
	do_selected_action : function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		this.ref_doc = $("ref_doc").value;
		this.type_action = $("coche_action").value;

		if (this.type_action.match('set_pu_ht_to_id_tarif')) {
			this.id_tarif = this.type_action.replace("set_pu_ht_to_id_tarif_", "");
			this.type_action = 'set_pu_ht_to_id_tarif';
		}

		this.lignes = new Array();
		if (!$("lignes").empty()) {
			this.liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
			t_liste = this.liste.split("&");
			for (i = 0; i < t_liste.length; i++) {
				if (t_liste[i] != "undefined") {
					if ($("check_"+t_liste[i]).checked) {
						this.lignes.push ($("ref_doc_line_"+t_liste[i]).value);
					}
				}
			}
		}

			parametres = new Array();
			parametres.push("ref_doc=" + this.ref_doc + "");
			parametres.push("action=" + this.type_action + "");
			parametres.push("id_tarif=" + this.id_tarif + "");
			for (i = 0; i < this.lignes.length; i++) {
				parametres.push("lines[]=" + this.lignes[i] + "");
			}
			send_param = parametres.join("&");
		var AppelAjax = new Ajax.Request(
											"documents_edition_select_action.php?"+send_param,
											{
											evalScripts: true,
											onLoading: S_loading,
											onSuccess: function (requester){
											requester.responseText.evalScripts();
											}
											}
											);
	},
	undo_selected_action : function () {
		$("coche_action").selectedIndex = 0;
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";

	}

}

//action de copie de ligne vers un document
function copie_lines_to_doc (ref_doc, ref_doc_cible) {
			lignes = new Array();
		if (!$("lignes").empty()) {
			liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
			t_liste = liste.split("&");
			for (i = 0; i < t_liste.length; i++) {
				if (t_liste[i] != "undefined") {
					if ($("check_"+t_liste[i]).checked) {
						lignes.push ($("ref_doc_line_"+t_liste[i]).value);
					}
				}
			}
		}

			parametres = new Array();
			parametres.push("ref_doc=" + ref_doc_cible + "");
			for (i = 0; i < this.lignes.length; i++) {
				parametres.push("lines[]=" + this.lignes[i] + "");
			}
			send_param = parametres.join("&");
	var AppelAjax = new Ajax.Updater(
																"sub_content",
																"documents_edition_copie_line.php?"+send_param,
																{
																parameters: {old_ref_doc : ref_doc},
															 	evalScripts:true,
																onLoading:S_loading, onException: function () {S_failure();},
																onComplete: function() {
																	H_loading();
																}
																}
																);

}



//action de copie de ligne vers un document
function maj_tva_lines_doc (new_taux) {
			lignes = new Array();
		if (!$("lignes").empty()) {
			liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
			t_liste = liste.split("&");
			for (i = 0; i < t_liste.length; i++) {
				if (t_liste[i] != "undefined") {
					if ($("check_"+t_liste[i]).checked) {
							if ($("tva_"+t_liste[i])) {
								$("tva_"+t_liste[i]).value = new_taux;
								$("tva_old_"+t_liste[i]).value = new_taux;
								maj_line_tva (new_taux, $("ref_doc_line_"+t_liste[i]).value);
								$("check_"+t_liste[i]).checked = false;
							}
					}
				}
			}
		}

		$("coche_action").selectedIndex = 0;

}
//action de copie de ligne vers un nouveau document
function copie_lines_to_new_doc (ref_doc, id_type_doc, ref_contact, link_old_ref_doc) {
			lignes = new Array();
		if (!$("lignes").empty()) {
			liste = serialisation("lignes", "li").replace(/lignes\[\]=/g,"");
			t_liste = liste.split("&");
			for (i = 0; i < t_liste.length; i++) {
				if (t_liste[i] != "undefined") {
					if ($("check_"+t_liste[i]).checked) {
						lignes.push ($("ref_doc_line_"+t_liste[i]).value);
					}
				}
			}
		}

			parametres = new Array();
			for (i = 0; i < this.lignes.length; i++) {
				parametres.push("lines[]=" + this.lignes[i] + "");
			}
			send_param = parametres.join("&");
	var AppelAjax = new Ajax.Updater(
																"sub_content",
																"documents_nouveau_copie_line.php?"+send_param,
																{
																parameters: {old_ref_doc : ref_doc, ref_contact : ref_contact, id_type_doc: id_type_doc,  link_old_ref_doc: link_old_ref_doc},
															 	evalScripts:true,
																onLoading:S_loading, onException: function () {S_failure();},
																onComplete: function() {
																	H_loading();
																}
																}
																);

}


//action sur un document (fonction d'appel indépendante
function action_doc (action) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_edition_select_action.php",
									{
									parameters: {ref_doc: ref_doc, action : action },
									evalScripts: true,
									onLoading: S_loading,
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									}
									}
									);
}

//***********************************************************************************
//fonctions concernant les nombres de lignes et de caractère pour des champ textarea
//***********************************************************************************

//observer le retour chariot lors de la saisie sur un textarea pour mettre le nombre de lignes correspondantes
function setToMaxRow_if_Key_RETURN (evt, mini_row, maxcol) {

	var id_field = Event.element(evt);
	var key = evt.which || evt.keyCode;
	switch (key) {
	case Event.KEY_RETURN:
	setToMaxRow (id_field.id, mini_row, maxcol);
	break;
	case Event.KEY_BACKSPACE:
	setToMaxRow (id_field.id, mini_row, maxcol);
	break;
	case Event.KEY_DELETE:
	setToMaxRow (id_field.id, mini_row, maxcol);
	break;
	}
}
//fonction de mise à hauteur d'un textarea en fonction du nombre de lignes qui le compose

function setToMaxRow (id_field, mini_row, maxcol) {
	array_lignes = escape($(id_field).value).split("%0A");
  nbrlignes = array_lignes.length;
	for (i=0; i<array_lignes.length ; i++) {
		if (unescape(array_lignes[i]).length > maxcol) {
			nbrlignes = nbrlignes + Math.floor(unescape(array_lignes[i]).length/maxcol);
		}
	}
	if (nbrlignes > mini_row) {
		$(id_field).rows = (nbrlignes+1);
	} else {
		$(id_field).rows = mini_row;
		if (mini_row <= 1) {
			force_rows (id_field, mini_row);
		} else {
			force_rows (id_field, mini_row-1);
		}
	}
}

//fonction qui force le nombre de row d'un textarea si on est pas sous IE
function force_rows (id_textarea, nb_rows) {
	if (navigator.appName != 'Microsoft Internet Explorer') {
		$(id_textarea).rows = nb_rows;
	}
}

function auto_count_lines (id_field, max_line) {
	array_lignes = ($(id_field).value).split("\n");
  nbrlignes = array_lignes.length;
	tmpaff = new Array();
	if (nbrlignes > max_line) {
	for (i=0; i<max_line ; i++) {
		tmpaff.push(array_lignes[i]);
	}
	} else {
		tmpaff = array_lignes ;
	}
	$(id_field).value = tmpaff.join("\n");

}
function limite_car_line (id_field, max_car) {
	array_lignes = new Array();
	array_lignes = ($(id_field).value).split("\n");
	array_lignes.push("");
  nbrlignes = array_lignes.length;
	tmpaff = new Array();
	for (i=0; i<nbrlignes ; i++) {
		if (array_lignes[i].length >= max_car) {
		//	array_lignes[i+1] = array_lignes[i].substring(max_car)+array_lignes[i+1];
		tmpaff.push(array_lignes[i]);
		} else {
			alert (array_lignes[i]);
		tmpaff.push(array_lignes[i]);
		}
	}
	$(id_field).value = tmpaff.join("\n");

}
//observer le retour chariot et les touches de suppression pour stopper l'event si ce n'est pas le cas
function stop_Key (evt, id_field, max_line) {

	var id_field = Event.element(evt);
	var key = evt.which || evt.keyCode;
	switch (key) {
	case Event.KEY_RETURN:
	 auto_count_car_lines (id_field, max_line)
	break;
	case Event.KEY_BACKSPACE:
	 auto_count_car_lines (id_field, max_line)
	break;
	case Event.KEY_DELETE:
	 auto_count_car_lines (id_field, max_line)
	break;
	default:
		Event.stop(evt);
	break;
	}
}
//****************************************************************************************
//gestion des reglements
//****************************************************************************************

function insert_form_new_reglement (id_cible, value_mode) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
															id_cible,
															"documents_reglements_addform.php",
															{
															parameters: {ref_doc: ref_doc, id_reglement_mode: value_mode},
															evalScripts:true,
															onLoading:S_loading, onException: function () {S_failure();},
															onComplete: function() {
																						H_loading();
																						}
															}
															);
}

//Lier deux document entre eux
function link_document_from (ref_doc, ref_doc_from) {
	var AppelAjax = new Ajax.Request(
										"documents_edition_block_liaisons_link.php",
										{
										parameters: {ref_doc_cible: ref_doc, ref_doc_liaison_pos: ref_doc_from },
										evalScripts: true,
										onLoading: S_loading,
										onSuccess: function (requester){
										requester.responseText.evalScripts();
										}
										}
										);
}
//chargement des liaisons
function update_document_liaisons () {
	var ref_doc = $("ref_doc").value;
		var AppelAjax = new Ajax.Updater(
											"block_liaisons",
											"documents_edition_block_liaisons.php",
											{
											parameters: { ref_doc: ref_doc },
											evalScripts:true,
											onLoading:S_loading, onException: function () {S_failure();},
											onComplete: function (){
																	H_loading();
																	}
											}
											);
}

//interdiction de modification
function alert_qte_locked () {
	alerte.alerte_erreur ('Modification impossible', 'La modification de certains éléments de ce document est interdite. <br /> Vous ne pouvez modifier les quantités, prix  et les numéros de série de ces articles.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}

function pre_start_ref_externe (ref_article, ref_doc_line, indentation) {

		// maj ref_article_externe
		Event.observe("ref_article_externe_"+indentation , "blur", function(evt){
			if ($("ref_article_externe_"+indentation ).value != $("old_ref_article_externe_"+indentation ).value) {

					maj_line_ref_externe ($("ref_article_externe_"+indentation ).value, $("old_ref_article_externe_"+indentation ).value , ""+ref_doc_line , ""+ref_article, ""+indentation);
					//$("old_ref_article_externe_"+indentation ).value = $("ref_article_externe_"+indentation ).value;

			}

		}, false);


		Event.observe("more_ref_article_externe_"+indentation, "click", function(evt){
			if ($("ref_contact" ) &&  $("ref_contact" ).value != "") {
				start_choix_ref_externe (ref_article, "ref_article_externe_"+indentation, "choix_liste_choix_ref_externe_"+indentation, "iframe_liste_choix_ref_externe_"+indentation, "documents_liste_choix_ref_externe.php");
			}
		}, false);
}

//lancement des observateurs d'évenement pour une ligne d'article

function pre_start_article_line (ref_article, ref_doc_line, indentation) {


		Event.observe("link_to_art_"+indentation , "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article='+ref_article),'true','_blank');}, false);


		//on injecte si il existe, dans les résultats du moteur le numéro d'intendation afin de rendre valide la mise à jour de la qté depuis le moteur
		if ($("ref_doc_line_article_"+ref_article )) {
			if ($("ref_doc_line_article_"+ref_article ).value == ""+ref_doc_line ) {
				$("ref_doc_line_indentation_"+ref_article ).value = ""+indentation ;
			}
		}



		// set_visible
		Event.observe("visible_"+indentation , "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				set_doc_line_unvisible (""+ref_doc_line );
				Element.toggle("visible_"+indentation );
				Element.toggle("unvisible_"+indentation );
				//document_calcul_tarif ();
			}
		}, false);
		// set_unvisible
		Event.observe("unvisible_"+indentation , "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				set_doc_line_visible (""+ref_doc_line );
				Element.toggle("visible_"+indentation );
				Element.toggle("unvisible_"+indentation );
				//document_calcul_tarif ();
			}
		}, false);


		// maj qte
		Event.observe("qte_"+indentation , "blur", function(evt){
			if (quantite_locked) {
				if ($("qte_"+indentation ).value != $("qte_old_"+indentation ).value) {
					$("qte_"+indentation ).value = $("qte_old_"+indentation ).value;
					alert_qte_locked ();
				}
			} else {
				if (($("qte_"+indentation ).value != $("qte_old_"+indentation ).value) && (nummask(evt, $("qte_old_"+indentation ).value, "X.X"))) {
						affichage_sn_update (""+indentation , $("qte_"+indentation ).value, $("qte_old_"+indentation ).value);

					maj_line_qte ($("qte_"+indentation ).value, ""+ref_doc_line , ""+ref_article , ""+indentation );
					$("qte_old_"+indentation ).value = $("qte_"+indentation ).value;
				//	document_calcul_tarif ();
				}
			}
		}, false);

		//maj lib_article
		Event.observe("lib_article_"+indentation , "blur", function(evt){
				if ($("lib_article_"+indentation ).value != $("lib_article_old_"+indentation ).innerHTML) {
					maj_line_lib_article ("lib_article_"+indentation , ""+ref_doc_line );
					$("lib_article_old_"+indentation ).innerHTML = $("lib_article_"+indentation ).value;
					setToMaxRow ("lib_article_"+indentation , 1, 70)	;
					}
				}, false);

		Event.observe("lib_article_"+indentation , "keypress", function(evt){
				setToMaxRow_if_Key_RETURN (evt, 1, 70)
				}, false);

		//maj desc_article
		Event.observe("desc_article_"+indentation , "blur", function(evt){
				if ($("desc_article_"+indentation ).value != $("desc_article_old_"+indentation ).innerHTML) {
					maj_line_desc_article ("desc_article_"+indentation , ""+ref_doc_line );
					$("desc_article_old_"+indentation ).innerHTML = $("desc_article_"+indentation ).value;
					setToMaxRow ("desc_article_"+indentation , 2, 70)	;
					}
				}, false);


		Event.observe("desc_article_"+indentation , "keypress", function(evt){
				setToMaxRow_if_Key_RETURN (evt, 2, 70)
				}, false);

		//maj du pu_ht


		Event.observe("pu_"+indentation , "blur", function(evt){
			if (quantite_locked) {
				if ($("prix_afficher_ht").checked) {
					$("pu_"+indentation ).value =  $("pu_ht_old_"+indentation ).value;
				} else {
					$("pu_"+indentation ).value =  (parseFloat($("pu_ht_old_"+indentation ).value)*(1+parseFloat ($("tva_"+indentation ).value)/100)).toFixed(calcul_tarifs_nb_decimales);
				}
				alert_qte_locked ();
			} else {
				if (nummask(evt, $("pu_ht_old_"+indentation ).value, "X.XY")) {
					if ($("prix_afficher_ht").checked) {
						$("pu_ht_"+indentation ).value =  $("pu_"+indentation ).value;
						if ($("pu_ht_old_"+indentation ).value !=  $("pu_"+indentation ).value) {
							$("pu_ht_old_"+indentation ).value =  $("pu_"+indentation ).value;
							maj_line_pu_ht ("pu_ht_"+indentation , ""+ref_doc_line );
						//	document_calcul_tarif ();
						}
					} else {
						$("pu_ht_"+indentation ).value =   (parseFloat($("pu_"+indentation ).value)/(1+parseFloat ($("tva_"+indentation ).value)/100)).toFixed(calcul_tarifs_nb_decimales);
						if ($("pu_ht_old_"+indentation ).value !=  (parseFloat($("pu_"+indentation ).value)/(1+parseFloat ($("tva_"+indentation ).value)/100)).toFixed(calcul_tarifs_nb_decimales)) {
						 $("pu_ht_old_"+indentation ).value =  (parseFloat($("pu_"+indentation ).value)/(1+parseFloat ($("tva_"+indentation ).value)/100)).toFixed(calcul_tarifs_nb_decimales);
							maj_line_pu_ht ("pu_ht_"+indentation , ""+ref_doc_line );
							//document_calcul_tarif ();
						}
					}
				}
			}
		}, false);


		// maj remise
		Event.observe("remise_"+indentation , "blur", function(evt){
			if (quantite_locked) {
				$("remise_"+indentation ).value = $("remise_old_"+indentation ).value;
				alert_qte_locked ();
			} else {
				if (($("remise_"+indentation ).value != $("remise_old_"+indentation ).value) && (nummask(evt, $("remise_old_"+indentation ).value, "X.X"))) {
					maj_line_remise ($("remise_"+indentation ).value, ""+ref_doc_line );
					$("remise_old_"+indentation ).value = $("remise_"+indentation ).value;
				//	document_calcul_tarif ();
				}
			}
		}, false);


		// maj tva
		Event.observe("tva_"+indentation , "blur", function(evt){
			if (quantite_locked) {
				$("tva_"+indentation ).value = $("tva_old_"+indentation ).value;
				alert_qte_locked ();
			} else {
						if (($("tva_"+indentation ).value != $("tva_old_"+indentation ).value) && (nummask(evt, $("tva_old_"+indentation ).value, "X.X"))) {
							maj_line_tva ($("tva_"+indentation ).value, ""+ref_doc_line );
							$("tva_old_"+indentation ).value = $("tva_"+indentation ).value;
						//	document_calcul_tarif ();
						}
			}
		}, false);



		// supprime ligne
		Event.observe("sup_"+indentation , "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
						Event.stop(evt);
						doc_sup_line(""+ref_doc_line );
						remove_tag(ref_doc_line+"_"+indentation );
			}
		}, false);



		//afficher masquer description ligne

		Event.observe("show_desc_"+indentation , "click", function(evt){
						Event.stop(evt);
						Element.toggle("show_desc_"+indentation );
						Element.toggle("unshow_desc_"+indentation );
						Element.toggle("div_desc_article_"+indentation );
						Element.hide("lignes");
						Element.show("lignes");
						}, false);
		Event.observe("unshow_desc_"+indentation , "click", function(evt){
						Event.stop(evt);
						Element.toggle("show_desc_"+indentation );
						Element.toggle("unshow_desc_"+indentation );
						Element.toggle("div_desc_article_"+indentation );
						Element.hide("lignes");
						Element.show("lignes");
						}, false);

		// Liaisons article
		Event.observe("link_"+indentation , "click", function(evt){
			Event.stop(evt);
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				maj_pop_up_link(ref_article,$("ref_doc").value,$("qte_"+indentation ).value);
				$("pop_up_link").style.display = "block";
			}
		}, false);

		//mettre la description et le lib au max de lignes / contenu

		setToMaxRow ("lib_article_"+indentation , 1, 70)	;
		setToMaxRow ("desc_article_"+indentation , 2, 70)	;

}

//lancement des observateurs d'évenement pour une ligne de taxes

function pre_start_taxes_line (ref_article, ref_doc_line, indentation) {
// set_visible
		Event.observe("visible_"+indentation, "click", function(evt){
					set_doc_line_unvisible (ref_doc_line);
					Element.toggle("visible_"+indentation);
					Element.toggle("unvisible_"+indentation);
				}, false);
// set_unvisible
		Event.observe("unvisible_"+indentation, "click", function(evt){
					set_doc_line_visible (ref_doc_line);
					Element.toggle("visible_"+indentation);
					Element.toggle("unvisible_"+indentation);
				}, false);

		Event.observe("pu_"+indentation , "blur", function(evt){
				 if (nummask(evt, $("pu_"+indentation ).value, "X.XY")) {
							maj_line_pu_ht ("pu_"+indentation , ""+ref_doc_line );
				 }
		}, false);

}

//lancement des observateurs d'évenement pour une ligne d'information

function pre_start_information_line (ref_article, ref_doc_line, indentation) {
// set_visible
		Event.observe("visible_"+indentation, "click", function(evt){
					set_doc_line_unvisible (ref_doc_line);
					Element.toggle("visible_"+indentation);
					Element.toggle("unvisible_"+indentation);
				}, false);
// set_unvisible
		Event.observe("unvisible_"+indentation, "click", function(evt){
					set_doc_line_visible (ref_doc_line);
					Element.toggle("visible_"+indentation);
					Element.toggle("unvisible_"+indentation);
				}, false);


//maj lib_article
Event.observe("lib_article_"+indentation, "blur", function(evt){
		if ($("lib_article_"+indentation).value != $("lib_article_old_"+indentation).innerHTML) {
			maj_line_lib_article ("lib_article_"+indentation, ref_doc_line);
			$("lib_article_old_"+indentation).innerHTML = $("lib_article_"+indentation).value;
			setToMaxRow ("lib_article_"+indentation, 1, 70)	;
			}
		}, false);

Event.observe("lib_article_"+indentation, "keypress", function(evt){
		setToMaxRow_if_Key_RETURN (evt, 1, 70)
		}, false);

//maj desc_article
Event.observe("desc_article_"+indentation, "blur", function(evt){
		if ($("desc_article_"+indentation).value != $("desc_article_old_"+indentation).innerHTML) {
			maj_line_desc_article ("desc_article_"+indentation, ref_doc_line);
			$("desc_article_old_"+indentation).innerHTML = $("desc_article_"+indentation).value;
			setToMaxRow ("desc_article_"+indentation, 2, 70)	;
			}
		}, false);

Event.observe("desc_article_"+indentation, "keypress", function(evt){
		setToMaxRow_if_Key_RETURN (evt, 2, 70)
		}, false);



// supprime ligne
Event.observe("sup_"+indentation, "click", function(evt){Event.stop(evt);
				doc_sup_line(ref_doc_line);
				remove_tag(ref_doc_line+"_"+indentation);
				}, false);


//afficher masquer description ligne

Event.observe("show_desc_"+indentation, "click", function(evt){
				Element.toggle("show_desc_"+indentation);
				Element.toggle("unshow_desc_"+indentation);
				Element.toggle("div_desc_article_"+indentation);
				Element.hide("lignes");
				Element.show("lignes");
				}, false);
Event.observe("unshow_desc_"+indentation, "click", function(evt){
				Element.toggle("show_desc_"+indentation);
				Element.toggle("unshow_desc_"+indentation);
				Element.toggle("div_desc_article_"+indentation);
				Element.hide("lignes");
				Element.show("lignes");
				}, false);

//mettre la description et le lib au max de lignes / contenu

setToMaxRow ("lib_article_"+indentation, 1, 70)	;
setToMaxRow ("desc_article_"+indentation, 2, 70)	;
}

//lancement des observateurs d'évenement pour une ligne de sous-total

function pre_start_sstotal_line (ref_article, ref_doc_line, indentation) {
// set_visible
	Event.observe("visible_"+indentation, "click", function(evt){
					set_doc_line_unvisible (ref_doc_line);
					Element.toggle("visible_"+indentation);
					Element.toggle("unvisible_"+indentation);
				}, false);
// set_unvisible
	Event.observe("unvisible_"+indentation, "click", function(evt){
					set_doc_line_visible (ref_doc_line);
					Element.toggle("visible_"+indentation);
					Element.toggle("unvisible_"+indentation);
				}, false);

//maj lib_article
Event.observe("lib_article_"+indentation, "blur", function(evt){
		if ($("lib_article_"+indentation).value != $("lib_article_old_"+indentation).innerHTML) {
			maj_line_lib_article ("lib_article_"+indentation, ref_doc_line);
			$("lib_article_old_"+indentation).innerHTML = $("lib_article_"+indentation).value;
			setToMaxRow ("lib_article_"+indentation, 1, 70)	;
			}
		}, false);

Event.observe("lib_article_"+indentation, "keypress", function(evt){
		setToMaxRow_if_Key_RETURN (evt, 1, 70)
		}, false);

// supprime ligne
	Event.observe("sup_"+indentation, "click", function(evt){Event.stop(evt);
				doc_sup_line(ref_doc_line);
				remove_tag(ref_doc_line+"_"+indentation);
				}, false);


}

//ajout d'une compensation à un document

function add_avoir (ref_doc_neg, ref_doc) {
		var AppelAjax = new Ajax.Request(
											"documents_reglements_cree_comp.php",
											{
											parameters: {ref_doc_neg: ref_doc_neg, ref_doc: ref_doc },
											evalScripts:true,
											onLoading: S_loading,
											onSuccess: function (requester){
											requester.responseText.evalScripts();
											charger_contenu_reglements();
											page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc='+ref_doc,'true','block_head');
											}
											}
											);
}
//ajout d'un reglement non attribué

function add_regmnt (ref_reglement, ref_doc) {
		var AppelAjax = new Ajax.Request(
											"documents_reglements_add_reg.php",
											{
											parameters: {ref_reglement: ref_reglement, ref_doc: ref_doc },
											evalScripts:true,
											onLoading: S_loading,
											onSuccess: function (requester){
											requester.responseText.evalScripts();
											charger_contenu_reglements();
											page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc='+ref_doc,'true','block_head');
											}
											}
											);
}

//création d'une compensation à un document

function cree_avoir (ref_doc) {
		var AppelAjax = new Ajax.Request(
											"documents_reglements_cree_avoir.php",
											{
											parameters: {ref_doc: ref_doc },
											evalScripts:true,
											onLoading: S_loading,
											onSuccess: function (requester){
											requester.responseText.evalScripts();
											charger_contenu_reglements();
											page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc='+ref_doc,'true','block_head');
											}
											}
											);
}


//spécifique au document inventaire

function add_all_art_categ_to_inv(nb_lignes) {
	for (i=0; i < nb_lignes ; i++) {
		$("ins_art_"+i).checked = true;
	}
}

function del_all_art_categ_to_inv(nb_lignes) {
	for (i=0; i < nb_lignes ; i++) {
		$("ins_art_"+i).checked = false;
	}
}

//chargement de la liste des art_categ pour attribution à un inventaire
function load_content_inv_list_art_categ () {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
									"liste_art_categ_inventaire",
									"documents_inventaire_choix_art_categ.php",
									{
									parameters: {ref_doc: ref_doc},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function() {
															H_loading();
															}
									}
									);
}


//supprime_art_categ
function supprime_art_categ  (art_categ) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Updater(
									"block_head",
									"documents_entete_sup_art_categ.php",
									{
									parameters: {ref_doc: ref_doc, art_categ :art_categ},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															H_loading();
															}
									}
									);
}

//ajout d'un art_categ dans un inventaire
function add_inv_content_art_categ (art_categ, preremplir, ref_constructeur) {
	var ref_doc = $("ref_doc").value;
	var AppelAjax = new Ajax.Request(
									"documents_inventaire_art_categ_add.php",
									{
									parameters: {ref_doc: ref_doc, art_categ: art_categ, preremplir: preremplir, ref_constructeur: ref_constructeur },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									}
									}
									);
}

//fonction permettant de temporiser l'envois de la recherche rapide
function wait_recherche_rapide_allow(){
wait_recherche_rapide = false;
}

//document fab
function set_ref_article_to_fab (ref_doc, qte_fab, ref_article, lib_article, valo_indice) {
	close_mini_moteur_cata();

	var AppelAjax = new Ajax.Updater(
									"sub_content",
									"documents_fabrication_set_ref_article.php",
									{
									parameters: {ref_doc: ref_doc, qte_fab: qte_fab, ref_article: ref_article, fill_content: "1" },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															H_loading();
															}

									}
									);
}

//document des
function set_ref_article_to_des (ref_doc, qte_des, ref_article, lib_article, valo_indice) {
	close_mini_moteur_cata();

	var AppelAjax = new Ajax.Updater(
									"sub_content",
									"documents_desassemblage_set_ref_article.php",
									{
									parameters: {ref_doc: ref_doc, qte_des: qte_des, ref_article: ref_article, fill_content: "1" },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															H_loading();
															}

									}
									);
}

//maj de la qté à fabriquer
function set_qte_to_fab (ref_doc, qte_fab, fill_content) {
	var AppelAjax = new Ajax.Updater(
									"sub_content",
									"documents_fabrication_set_qte_to_fab.php",
									{
									parameters: {ref_doc: ref_doc, qte_fab: qte_fab, fill_content: fill_content },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															H_loading();
															}

									}
									);
}

//maj de la qté à desassembler
function set_qte_to_des (ref_doc, qte_des, fill_content) {
	var AppelAjax = new Ajax.Updater(
									"sub_content",
									"documents_desassemblage_set_qte_to_des.php",
									{
									parameters: {ref_doc: ref_doc, qte_des: qte_des, fill_content: fill_content },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete: function (requester){
															H_loading();
															}

									}
									);
}

function observe_RETURN_for_doc_fab_sn (event, name, indent_sn) {
	var key = event.which || event.keyCode;
	switch (key) {
	case Event.KEY_RETURN:
	if ($(name+"_"+indent_sn)) {
		$(name+"_"+indent_sn).focus();
	} else {
		if ($("art_gest_sn_finliste")) {
			$("art_gest_sn_finliste").focus();
		}
	}
	Event.stop(event);
	break;
	}
}

//fonction de lancement des observateur d'event pour ligne de sn insérées par javascript
function pre_start_observer_fab_sn ( indentation_sn, ref_doc, art_sn, old_art_sn, sup_sn) {
	Event.observe("art_sn_"+indentation_sn, "keypress", function(evt){
								observe_RETURN_for_doc_fab_sn (evt, "art_sn", parseInt(indentation_sn)+1);
								}, false);

	Event.observe("art_sn_"+indentation_sn, "dblclick", function(evt){
								incremente_fab_sn(ref_doc, indentation_sn);
								is_fab_sn_filled ();
								}, false);

	Event.observe(sup_sn, "click", function(evt){Event.stop(evt);
			del_fab_sn (ref_doc, $(old_art_sn).value);
			$(old_art_sn).value = $(art_sn).value = "";
			is_fab_sn_filled ();
			}, false);

	Event.observe(art_sn, "blur", function(evt){
		if (quantite_locked) {
			if ($(art_sn).value != $(old_art_sn).value) {
				$(art_sn).value = $(old_art_sn).value;
				alert_qte_locked ();
			}
		} else {
			if ($(art_sn).value != $(old_art_sn).value) {
				if ($(old_art_sn).value != "") {
					if ($(art_sn).value == "") {
					del_fab_sn (ref_doc, $(old_art_sn).value);
					$(old_art_sn).value = $(art_sn).value;
					} else {
					maj_fab_sn (ref_doc, $(old_art_sn).value, $(art_sn).value, art_sn);
					$(old_art_sn).value = $(art_sn).value;
					}
				} else {
					add_fab_sn (ref_doc, $(art_sn).value, art_sn);
					$(old_art_sn).value = $(art_sn).value;
				}
			}
		is_fab_sn_filled ();
		}
	}, false);

	is_fab_sn_filled ();
}


//add d'un numéro de série d'un article à fabriquer
function add_fab_sn (ref_doc, sn, art_sn) {
	var AppelAjax = new Ajax.Request(
									"documents_fab_add_sn.php",
									{
									parameters: {ref_doc: ref_doc, sn: sn, art_sn: art_sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//maj d'un numéro de séried'un article à fabriquer
function maj_fab_sn (ref_doc, sn, new_sn, art_sn) {
	var AppelAjax = new Ajax.Request(
									"documents_fab_maj_sn.php",
									{
									parameters: {ref_doc: ref_doc, sn: sn, new_sn: new_sn, art_sn: art_sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//del d'un numéro de série d'un article à fabriquer
function del_fab_sn (ref_doc, sn) {
	var AppelAjax = new Ajax.Request(
									"documents_fab_del_sn.php",
									{
									parameters: {ref_doc: ref_doc, sn: sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}


//double click sur champ sn incrémente les sn suivant si non déjà remplis
function incremente_fab_sn(ref_doc, indentation_sn) {
	var nombre_ligne_sn =  Math.abs($("qte_fab").value);

	var sn_de_depart = $("art_sn_"+indentation_sn).value;
	var u_field_num = Array.from(sn_de_depart);
	var defaut_num_serie = 0;
	var last_car_index = -1;
	var sn_indent = parseFloat (indentation_sn);
	for( i=0; i < u_field_num.length; i++ ) {
		if (isNaN(u_field_num[i])){
  	 last_car_index = i;
		}
	}

	first_sn_part = sn_de_depart.substring (0, last_car_index+1);
	num_sn_part = sn_de_depart.substring (last_car_index+1);

	if (num_sn_part !="") {
		zero_in_num_sn =  Array.from(num_sn_part);
		zero_before_increment = "";
		nomore_zero = false;
		count_zero = 0;
		for( j=0; j < zero_in_num_sn.length; j++ ) {
			if ((zero_in_num_sn[j] == "0") && (!nomore_zero )){
			 count_zero ++;
			} else {
				nomore_zero = true;
			}
		}

		new_increment_sn = parseFloat(num_sn_part.substring (count_zero));
		longeur_incre_onstart = (new_increment_sn.toString()) ;
		if (quantite_locked) {
			alert_qte_locked ();
		} else {
			for(i = 0; i< nombre_ligne_sn; i++) {
				zero_before_increment = "";
				if ($("art_sn_"+i) && (i > indentation_sn) ) {
					new_increment_sn++;
					reste_zero = count_zero - ((new_increment_sn.toString()).length - longeur_incre_onstart.length);
					if (reste_zero >0) {
						for( k=0; k < reste_zero; k++ ) {
							zero_before_increment += "0";
						}
					}

					if ($("art_sn_"+i).value == "") {
						$("old_art_sn_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;
						$("art_sn_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;
						add_fab_sn ( ref_doc, first_sn_part + "" + zero_before_increment + new_increment_sn, "art_sn_"+i);
					}
				}
			}
		}
	}

}

// sn remplis
function is_fab_sn_filled () {
	var less_sn = false;
	if (!$("fab_liste_sn").empty()) {
		if ($("qte_fab")) {
		nb_sn = parseInt(Math.abs($("qte_fab").value));
			for (j=0; j < nb_sn; j++) {
				if ($("art_sn_"+j)) {
					if ($("art_sn_"+j).value == "") {
						$("more_sn_"+j).className = "more_sn_class_r" ;
						less_sn = true;
					} else {
						$("more_sn_"+j).className = "more_sn_class" ;
					}
				}
			}
		}
		if (less_sn) {
			return false;
		} else {
			return true;
		}


	} else {
		return true;
	}
}


//fonction d'insertion de ligne de nl par javascript
function insert_line_fab_nl (indentation_nl, ref_article, ref_doc) {
	var zone= $("fab_liste_sn");
	$("art_gest_nl_finliste").value = parseInt(indentation_nl)+1;
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "num_fab_nl_"+indentation_nl);
	zone.appendChild(adddiv);

	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "more_nl_"+indentation_nl);
		addspan.setAttribute ("class", "more_sn_class");
		addspan.setAttribute ("className", "more_sn_class");
	$("num_fab_nl_"+indentation_nl).appendChild(addspan);
	$("more_nl_"+indentation_nl).innerHTML = "Lot:";
	new Insertion.Bottom ($("num_fab_nl_"+indentation_nl), " ");

	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "art_nl_"+indentation_nl);
		inputtext.setAttribute ("name", "art_nl_"+indentation_nl);
		inputtext.setAttribute ("type", "text");
		inputtext.setAttribute ("value", "");
		inputtext.setAttribute ("size", "10");
	$("num_fab_nl_"+indentation_nl).appendChild(inputtext);
	new Insertion.Bottom ($("num_fab_nl_"+indentation_nl), " ");

	var inputhidden= document.createElement("input");
		inputhidden.setAttribute ("id", "old_art_nl_"+indentation_nl);
		inputhidden.setAttribute ("name", "old_art_nl_"+indentation_nl);
		inputhidden.setAttribute ("type", "hidden");
		inputhidden.setAttribute ("value", "");
	$("num_fab_nl_"+indentation_nl).appendChild(inputhidden);

	var inputtext2= document.createElement("input");
		inputtext2.setAttribute ("id", "qte_nl_"+indentation_nl);
		inputtext2.setAttribute ("name", "qte_nl_"+indentation_nl);
		inputtext2.setAttribute ("type", "text");
		inputtext2.setAttribute ("value", "");
		inputtext2.setAttribute ("size", "3");
	$("num_fab_nl_"+indentation_nl).appendChild(inputtext2);

	var inputhidden2= document.createElement("input");
		inputhidden2.setAttribute ("id", "old_qte_nl_"+indentation_nl);
		inputhidden2.setAttribute ("name", "old_qte_nl_"+indentation_nl);
		inputhidden2.setAttribute ("type", "hidden");
		inputhidden2.setAttribute ("value", "");
	$("num_fab_nl_"+indentation_nl).appendChild(inputhidden2);

	var addsup= document.createElement("a");
		addsup.setAttribute ("id", "sup_nl_"+indentation_nl);
		addsup.setAttribute ("href", "#");
		addsup.setAttribute ("class", "sn_a_none");
		addsup.setAttribute ("className", "sn_a_none");
	$("num_fab_nl_"+indentation_nl).appendChild(addsup);
	$("sup_nl_"+indentation_nl).innerHTML = "&nbsp;";

	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
	$("sup_nl_"+indentation_nl).appendChild(addimgsup);

	var adddiv_block_nl= document.createElement("div");
		adddiv_block_nl.setAttribute ("id", "block_choix_nl_"+indentation_nl);
		adddiv_block_nl.setAttribute ("class", "sn_block_choix");
		adddiv_block_nl.setAttribute ("className", "sn_block_choix");
	$("num_fab_nl_"+indentation_nl).appendChild(adddiv_block_nl);

	var addiframe_choix_nl= document.createElement("div");
		addiframe_choix_nl.setAttribute ("id", "iframe_liste_choix_nl_"+indentation_nl);
		addiframe_choix_nl.setAttribute ("frameborder", "0");
		addiframe_choix_nl.setAttribute ("scrolling", "no");
		addiframe_choix_nl.setAttribute ("src", "about:_blank");
		addiframe_choix_nl.setAttribute ("class", "choix_liste_choix_sn");
		addiframe_choix_nl.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_nl_"+indentation_nl).appendChild(addiframe_choix_nl);
		$("iframe_liste_choix_nl_"+indentation_nl).setStyle({   display: 'none' });

	var adddiv_choix_nl= document.createElement("div");
		adddiv_choix_nl.setAttribute ("id", "choix_liste_choix_nl_"+indentation_nl);
		adddiv_choix_nl.setAttribute ("class", "choix_liste_choix_sn");
		adddiv_choix_nl.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_nl_"+indentation_nl).appendChild(adddiv_choix_nl);
		$("choix_liste_choix_nl_"+indentation_nl).setStyle({   display: 'none' });

pre_start_observer_fab_nl (indentation_nl, ref_doc, "art_nl_"+indentation_nl ,"old_art_nl_"+indentation_nl, "sup_nl_"+indentation_nl, "qte_nl_"+indentation_nl ,"old_qte_nl_"+indentation_nl, "more_nl_"+indentation_nl, ref_article, "choix_liste_choix_nl_"+indentation_nl, "iframe_liste_choix_nl_"+indentation_nl );
}


//fonction de lancement des observateur d'event pour ligne de sn insérées par javascript
function pre_start_observer_fab_nl ( indentation_nl, ref_doc, art_nl, old_art_nl, sup_nl, qte_nl, old_qte_nl, more_nl, ref_article, choix_div, choix_iframe) {

	Event.observe(sup_nl, "click", function(evt){Event.stop(evt);
			del_fab_nl (ref_doc, $(old_art_nl).value, $(old_qte_nl).value);
			$(old_art_nl).value = $(art_nl).value = "";
	}, false);

	Event.observe(more_nl, "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				start_choix_nl (ref_article, art_nl, choix_div, choix_iframe, "documents_liste_choix_nl.php");
			}
	}, false);

	Event.observe(art_nl, "blur", function(evt){
		if (quantite_locked) {
			if ($(art_nl).value != $(old_art_nl).value) {
				$(art_nl).value = $(old_art_nl).value;
				$(qte_nl).value = $(old_qte_nl).value;
				alert_qte_locked ();
			}
		} else {
			if ($(art_nl).value != $(old_art_nl).value) {
					if ($(art_nl).value == "") {
					del_fab_nl (ref_doc, $(old_art_nl).value, $(old_qte_nl).value);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					} else {
					maj_fab_nl (ref_doc, $(old_art_nl).value, $(art_nl).value, art_nl, $(old_qte_nl).value, $(qte_nl).value, qte_nl);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					}
			}
		}
	}, false);

	Event.observe(qte_nl, "blur", function(evt){
		if (quantite_locked) {
			if ($(qte_nl).value != $(old_qte_nl).value) {
				$(art_nl).value = $(old_art_nl).value;
				$(qte_nl).value = $(old_qte_nl).value;
				alert_qte_locked ();
			}
		} else {
			if ($(qte_nl).value != $(old_qte_nl).value) {
					if ($(qte_nl).value == "") {
					del_fab_nl (ref_doc, $(old_art_nl).value, $(old_qte_nl).value);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					} else {
					maj_fab_nl (ref_doc, $(old_art_nl).value, $(art_nl).value, art_nl, $(old_qte_nl).value, $(qte_nl).value, qte_nl);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					}
			}
		}
	}, false);

}

//maj d'un numéro de séried'un article à fabriquer
function maj_fab_nl (ref_doc, nl, new_nl, art_nl, qte, new_qte, qte_nl) {
	var AppelAjax = new Ajax.Request(
									"documents_fab_maj_nl.php",
									{
									parameters: {ref_doc: ref_doc, nl: nl, new_nl: new_nl, art_nl: art_nl, qte: qte, new_qte: new_qte, qte_nl: qte_nl},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//del d'un numéro de série d'un article à fabriquer
function del_fab_nl (ref_doc, nl, qte) {
	var AppelAjax = new Ajax.Request(
									"documents_fab_del_nl.php",
									{
									parameters: {ref_doc: ref_doc, nl: nl, qte:qte},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}



//fonction d'insertion de ligne de nl par javascript
function insert_line_des_nl (indentation_nl, ref_article, ref_doc) {
	var zone= $("des_liste_sn");
	$("art_gest_nl_finliste").value = parseInt(indentation_nl)+1;
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "num_des_nl_"+indentation_nl);
	zone.appendChild(adddiv);

	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "more_nl_"+indentation_nl);
		addspan.setAttribute ("class", "more_sn_class");
		addspan.setAttribute ("className", "more_sn_class");
	$("num_des_nl_"+indentation_nl).appendChild(addspan);
	$("more_nl_"+indentation_nl).innerHTML = "Lot:";
	new Insertion.Bottom ($("num_des_nl_"+indentation_nl), " ");

	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "art_nl_"+indentation_nl);
		inputtext.setAttribute ("name", "art_nl_"+indentation_nl);
		inputtext.setAttribute ("type", "text");
		inputtext.setAttribute ("value", "");
		inputtext.setAttribute ("size", "10");
	$("num_des_nl_"+indentation_nl).appendChild(inputtext);
	new Insertion.Bottom ($("num_des_nl_"+indentation_nl), " ");

	var inputhidden= document.createElement("input");
		inputhidden.setAttribute ("id", "old_art_nl_"+indentation_nl);
		inputhidden.setAttribute ("name", "old_art_nl_"+indentation_nl);
		inputhidden.setAttribute ("type", "hidden");
		inputhidden.setAttribute ("value", "");
	$("num_des_nl_"+indentation_nl).appendChild(inputhidden);

	var inputtext2= document.createElement("input");
		inputtext2.setAttribute ("id", "qte_nl_"+indentation_nl);
		inputtext2.setAttribute ("name", "qte_nl_"+indentation_nl);
		inputtext2.setAttribute ("type", "text");
		inputtext2.setAttribute ("value", "");
		inputtext2.setAttribute ("size", "3");
	$("num_des_nl_"+indentation_nl).appendChild(inputtext2);

	var inputhidden2= document.createElement("input");
		inputhidden2.setAttribute ("id", "old_qte_nl_"+indentation_nl);
		inputhidden2.setAttribute ("name", "old_qte_nl_"+indentation_nl);
		inputhidden2.setAttribute ("type", "hidden");
		inputhidden2.setAttribute ("value", "");
	$("num_des_nl_"+indentation_nl).appendChild(inputhidden2);

	var addsup= document.createElement("a");
		addsup.setAttribute ("id", "sup_nl_"+indentation_nl);
		addsup.setAttribute ("href", "#");
		addsup.setAttribute ("class", "sn_a_none");
		addsup.setAttribute ("className", "sn_a_none");
	$("num_des_nl_"+indentation_nl).appendChild(addsup);
	$("sup_nl_"+indentation_nl).innerHTML = "&nbsp;";

	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
	$("sup_nl_"+indentation_nl).appendChild(addimgsup);

	var adddiv_block_nl= document.createElement("div");
		adddiv_block_nl.setAttribute ("id", "block_choix_nl_"+indentation_nl);
		adddiv_block_nl.setAttribute ("class", "sn_block_choix");
		adddiv_block_nl.setAttribute ("className", "sn_block_choix");
	$("num_des_nl_"+indentation_nl).appendChild(adddiv_block_nl);

	var addiframe_choix_nl= document.createElement("div");
		addiframe_choix_nl.setAttribute ("id", "iframe_liste_choix_nl_"+indentation_nl);
		addiframe_choix_nl.setAttribute ("frameborder", "0");
		addiframe_choix_nl.setAttribute ("scrolling", "no");
		addiframe_choix_nl.setAttribute ("src", "about:_blank");
		addiframe_choix_nl.setAttribute ("class", "choix_liste_choix_sn");
		addiframe_choix_nl.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_nl_"+indentation_nl).appendChild(addiframe_choix_nl);
		$("iframe_liste_choix_nl_"+indentation_nl).setStyle({   display: 'none' });

	var adddiv_choix_nl= document.createElement("div");
		adddiv_choix_nl.setAttribute ("id", "choix_liste_choix_nl_"+indentation_nl);
		adddiv_choix_nl.setAttribute ("class", "choix_liste_choix_sn");
		adddiv_choix_nl.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_nl_"+indentation_nl).appendChild(adddiv_choix_nl);
		$("choix_liste_choix_nl_"+indentation_nl).setStyle({   display: 'none' });

pre_start_observer_des_nl (indentation_nl, ref_doc, "art_nl_"+indentation_nl ,"old_art_nl_"+indentation_nl, "sup_nl_"+indentation_nl, "qte_nl_"+indentation_nl ,"old_qte_nl_"+indentation_nl, "more_nl_"+indentation_nl, ref_article, "choix_liste_choix_nl_"+indentation_nl, "iframe_liste_choix_nl_"+indentation_nl );
}

//fonction de lancement des observateur d'event pour ligne de sn insérées par javascript
function pre_start_observer_des_nl ( indentation_nl, ref_doc, art_nl, old_art_nl, sup_nl, qte_nl, old_qte_nl, more_nl, ref_article, choix_div, choix_iframe) {

	Event.observe(sup_nl, "click", function(evt){Event.stop(evt);
			del_des_nl (ref_doc, $(old_art_nl).value, $(old_qte_nl).value);
			$(old_art_nl).value = $(art_nl).value = "";
	}, false);

	Event.observe(more_nl, "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				start_choix_nl (ref_article, art_nl, choix_div, choix_iframe, "documents_liste_choix_nl.php");
			}
	}, false);

	Event.observe(art_nl, "blur", function(evt){
		if (quantite_locked) {
			if ($(art_nl).value != $(old_art_nl).value) {
				$(art_nl).value = $(old_art_nl).value;
				$(qte_nl).value = $(old_qte_nl).value;
				alert_qte_locked ();
			}
		} else {
			if ($(art_nl).value != $(old_art_nl).value) {
					if ($(art_nl).value == "") {
					del_des_nl (ref_doc, $(old_art_nl).value, $(old_qte_nl).value);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					} else {
					maj_des_nl (ref_doc, $(old_art_nl).value, $(art_nl).value, art_nl, $(old_qte_nl).value, $(qte_nl).value, qte_nl);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					}
			}
		}
	}, false);

	Event.observe(qte_nl, "blur", function(evt){
		if (quantite_locked) {
			if ($(qte_nl).value != $(old_qte_nl).value) {
				$(art_nl).value = $(old_art_nl).value;
				$(qte_nl).value = $(old_qte_nl).value;
				alert_qte_locked ();
			}
		} else {
			if ($(qte_nl).value != $(old_qte_nl).value) {
					if ($(qte_nl).value == "") {
					del_des_nl (ref_doc, $(old_art_nl).value, $(old_qte_nl).value);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					} else {
					maj_des_nl (ref_doc, $(old_art_nl).value, $(art_nl).value, art_nl, $(old_qte_nl).value, $(qte_nl).value, qte_nl);
					$(old_art_nl).value = $(art_nl).value;
					$(old_qte_nl).value = $(qte_nl).value;
					}
			}
		}
	}, false);

}

//maj d'un numéro de séried'un article à désassembler
function maj_des_nl (ref_doc, nl, new_nl, art_nl, qte, new_qte, qte_nl) {
	var AppelAjax = new Ajax.Request(
									"documents_des_maj_nl.php",
									{
									parameters: {ref_doc: ref_doc, nl: nl, new_nl: new_nl, art_nl: art_nl, qte: qte, new_qte: new_qte, qte_nl: qte_nl},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}

//del d'un numéro de série d'un article à désassembler
function del_des_nl (ref_doc, nl, qte) {
	var AppelAjax = new Ajax.Request(
									"documents_des_del_nl.php",
									{
									parameters: {ref_doc: ref_doc, nl: nl, qte:qte},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}



function observe_RETURN_for_doc_des_sn (event, name, indent_sn) {
	var key = event.which || event.keyCode;
	switch (key) {
	case Event.KEY_RETURN:
	if ($(name+"_"+indent_sn)) {
		$(name+"_"+indent_sn).focus();
	} else {
		if ($("art_gest_sn_finliste")) {
			$("art_gest_sn_finliste").focus();
		}
	}
	Event.stop(event);
	break;
	}
}
//fonction de lancement des observateur d'event pour ligne de sn insérées par javascript
function pre_start_observer_des_sn ( indentation_sn, ref_doc, art_sn, old_art_sn, sup_sn, more_sn, ref_article, choix_div, choix_iframe) {
	Event.observe("art_sn_"+indentation_sn, "keypress", function(evt){
								observe_RETURN_for_doc_des_sn (evt, "art_sn", parseInt(indentation_sn)+1);
								}, false);

	Event.observe("art_sn_"+indentation_sn, "dblclick", function(evt){
								incremente_des_sn(ref_doc, indentation_sn);
								is_des_sn_filled ();
								}, false);

	Event.observe(sup_sn, "click", function(evt){Event.stop(evt);
			del_des_sn (ref_doc, $(old_art_sn).value);
			$(old_art_sn).value = $(art_sn).value = "";
			is_des_sn_filled ();
			}, false);

	Event.observe(more_sn, "click", function(evt){
			if (quantite_locked) {
				alert_qte_locked ();
			} else {
				start_choix_sn (ref_article, art_sn, choix_div, choix_iframe, "documents_liste_choix_sn.php");
				is_des_sn_filled ();
			}
			}, false);

	Event.observe(art_sn, "blur", function(evt){
		if (quantite_locked) {
			if ($(art_sn).value != $(old_art_sn).value) {
				$(art_sn).value = $(old_art_sn).value;
				alert_qte_locked ();
			}
		} else {
			if ($(art_sn).value != $(old_art_sn).value) {
				if ($(old_art_sn).value != "") {
					if ($(art_sn).value == "") {
					del_des_sn (ref_doc, $(old_art_sn).value);
					$(old_art_sn).value = $(art_sn).value;
					} else {
					maj_des_sn (ref_doc, $(old_art_sn).value, $(art_sn).value, art_sn);
					$(old_art_sn).value = $(art_sn).value;
					}
				} else {
					add_des_sn (ref_doc, $(art_sn).value, art_sn);
					$(old_art_sn).value = $(art_sn).value;
				}
			}
		is_des_sn_filled ();
		}
	}, false);

	is_des_sn_filled ();
}


//add d'un numéro de série d'un article à fabriquer
function add_des_sn (ref_doc, sn, art_sn) {
	var AppelAjax = new Ajax.Request(
									"documents_des_add_sn.php",
									{
									parameters: {ref_doc: ref_doc, sn: sn, art_sn: art_sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//maj d'un numéro de séried'un article à fabriquer
function maj_des_sn (ref_doc, sn, new_sn, art_sn) {
	var AppelAjax = new Ajax.Request(
									"documents_des_maj_sn.php",
									{
									parameters: {ref_doc: ref_doc, sn: sn, new_sn: new_sn, art_sn: art_sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}
//del d'un numéro de série d'un article à fabriquer
function del_des_sn (ref_doc, sn) {
	var AppelAjax = new Ajax.Request(
									"documents_des_del_sn.php",
									{
									parameters: {ref_doc: ref_doc, sn: sn},
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}


//double click sur champ sn incrémente les sn suivant si non déjà remplis
function incremente_des_sn(ref_doc, indentation_sn) {
	var nombre_ligne_sn =  Math.abs($("qte_des").value);

	var sn_de_depart = $("art_sn_"+indentation_sn).value;
	var u_field_num = Array.from(sn_de_depart);
	var defaut_num_serie = 0;
	var last_car_index = -1;
	var sn_indent = parseFloat (indentation_sn);
	for( i=0; i < u_field_num.length; i++ ) {
		if (isNaN(u_field_num[i])){
  	 last_car_index = i;
		}
	}

	first_sn_part = sn_de_depart.substring (0, last_car_index+1);
	num_sn_part = sn_de_depart.substring (last_car_index+1);

	if (num_sn_part !="") {
		zero_in_num_sn =  Array.from(num_sn_part);
		zero_before_increment = "";
		nomore_zero = false;
		count_zero = 0;
		for( j=0; j < zero_in_num_sn.length; j++ ) {
			if ((zero_in_num_sn[j] == "0") && (!nomore_zero )){
			 count_zero ++;
			} else {
				nomore_zero = true;
			}
		}

		new_increment_sn = parseFloat(num_sn_part.substring (count_zero));
		longeur_incre_onstart = (new_increment_sn.toString()) ;
		if (quantite_locked) {
			alert_qte_locked ();
		} else {
			for(i = 0; i< nombre_ligne_sn; i++) {
				zero_before_increment = "";
				if ($("art_sn_"+i) && (i > indentation_sn) ) {
					new_increment_sn++;
					reste_zero = count_zero - ((new_increment_sn.toString()).length - longeur_incre_onstart.length);
					if (reste_zero >0) {
						for( k=0; k < reste_zero; k++ ) {
							zero_before_increment += "0";
						}
					}

					if ($("art_sn_"+i).value == "") {
						$("old_art_sn_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;
						$("art_sn_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;
						add_des_sn ( ref_doc, first_sn_part + "" + zero_before_increment + new_increment_sn, "art_sn_"+i);
					}
				}
			}
		}
	}

}

// sn remplis
function is_des_sn_filled () {
	var less_sn = false;
	if (!$("des_liste_sn").empty()) {
		if ($("qte_des")) {
		nb_sn = parseInt(Math.abs($("qte_des").value));
			for (j=0; j < nb_sn; j++) {
				if ($("art_sn_"+j)) {
					if ($("art_sn_"+j).value == "") {
						$("more_sn_"+j).className = "more_sn_class_r" ;
						less_sn = true;
					} else {
						$("more_sn_"+j).className = "more_sn_class" ;
					}
				}
			}
		}
		if (less_sn) {
			return false;
		} else {
			return true;
		}


	} else {
		return true;
	}
}

//fusion de documents

function doc_edition_fusion (ref_doc, second_ref_doc) {
			var AppelAjax = new Ajax.Request(
																	'document_edition_fusion.php',
																	{
																	parameters: {ref_doc: ref_doc, second_ref_doc: second_ref_doc},
																	evalScripts:true,
																	onLoading:S_loading,
																	onSuccess: function (requester){
																			H_loading();
																			requester.responseText.evalScripts();
																			}
																	}
																	);
}


//nouvelle quantité ajouté à la dernière ref_doc_line insérée dans le document

function check_multiply_ref_doc_line_qte() {
	var array_num=new Array;
	var multiply_numbers = "";
	if ($("lib_article_r") && last_ssearch_ref_doc_line != "") {
		u_field_num = Array.from($("lib_article_r").value);
		for( i=0; i < u_field_num.length; i++ ) {
			if ((!isNaN(u_field_num[i]) || u_field_num[i]=="*") && u_field_num[i]!=" "){
			 array_num.push(u_field_num[i]);
			} else {
				return false;
			}
		}
		if (array_num.length >= 2 && array_num[0] == "*") {
			for ( i=1; i < array_num.length; i++ ) {
				if (!isNaN(array_num[i])) {
				multiply_numbers += array_num[i];
				}
			}
			//on recherche le champ de quantité correspondant à la ref_doc_line
			for (var j = 0; j < parseFloat($("indentation_contenu").value); j++) {
				if ($("ref_doc_line_"+j) && $("ref_doc_line_"+j).value == last_ssearch_ref_doc_line) {
					$("qte_"+j).value = multiply_numbers;
						if (quantite_locked) {
							if ($("qte_"+j ).value != $("qte_old_"+j ).value) {
								$("qte_"+j ).value = $("qte_old_"+j ).value;
								alert_qte_locked ();
							}
						} else {
							if (($("qte_"+j ).value != $("qte_old_"+j ).value)) {
								affichage_sn_update (""+j , $("qte_"+j ).value, $("qte_old_"+j ).value);

								maj_line_qte ($("qte_"+j ).value, ""+last_ssearch_ref_doc_line , ""+$("ref_article_"+j).value , ""+j );
								$("qte_old_"+j ).value = $("qte_"+j ).value;
							//	document_calcul_tarif ();
							}
						}
					$("lib_article_r").value = "";
					return true;
				}
			}
		}
	}
	return false;
}


//fonction de verification du total HT des lignes de comptabilité d'un document avec le montant HT du document
function check_document_compta_lignes () {
	var indent = parseInt($("indentation_compta_lignes").value);
	var total_lines_ht = 0;
	var total_lines_tva = 0;
	var total_lines_ttc = 0;
	var retour = true;
	for (var j = 0; j < indent; j++) {
		if ($("montant_"+j) && !$("montant_"+j).disabled) {
			if ($("id_journal_"+j).value == "3") {total_lines_ht += parseFloat($("montant_"+j).value);}
			if ($("id_journal_"+j).value == "4") {total_lines_tva += parseFloat($("montant_"+j).value);}
			if ($("id_journal_"+j).value == "5") {total_lines_ttc += parseFloat($("montant_"+j).value);}
			if ($("id_journal_"+j).value == "6") {total_lines_ht += parseFloat($("montant_"+j).value);}
			if ($("id_journal_"+j).value == "7") {total_lines_tva += parseFloat($("montant_"+j).value);}
			if ($("id_journal_"+j).value == "8") {total_lines_ttc += parseFloat($("montant_"+j).value);}

		}
	}
	if (Math.abs(parseFloat($("doc_compta_montant_ht").value))-0.01<=Math.abs(parseFloat (total_lines_ht).toFixed(tarifs_nb_decimales)) && Math.abs(parseFloat (total_lines_ht).toFixed(tarifs_nb_decimales)) <= Math.abs(parseFloat($("doc_compta_montant_ht").value))+0.01) {
		$("doc_compta_tot_montant_ht_ok").style.color ="#66CC33";
		$("doc_compta_tot_montant_ht_ok").innerHTML = parseFloat (total_lines_ht).toFixed(tarifs_nb_decimales)+" "+monnaie_html;
		$("doc_compta_tot_montant_ht_nok").hide();
	} else {
		$("doc_compta_tot_montant_ht_nok").show();
		$("doc_compta_tot_montant_ht_ok").style.color ="#FF0000";
		$("doc_compta_tot_montant_ht_ok").innerHTML = parseFloat (total_lines_ht).toFixed(tarifs_nb_decimales)+" "+monnaie_html;
		retour = false;
	}
	if (Math.abs(parseFloat($("doc_compta_montant_tva").value))-0.01 <= Math.abs(parseFloat (total_lines_tva).toFixed(tarifs_nb_decimales)) && Math.abs(parseFloat (total_lines_tva).toFixed(tarifs_nb_decimales)) <= Math.abs(parseFloat($("doc_compta_montant_tva").value))+0.01) {
		$("doc_compta_tot_montant_tva_ok").style.color ="#66CC33";
		$("doc_compta_tot_montant_tva_nok").hide();
		$("doc_compta_tot_montant_tva_ok").innerHTML = parseFloat (total_lines_tva).toFixed(tarifs_nb_decimales)+" "+monnaie_html;
	} else {
		$("doc_compta_tot_montant_tva_nok").show();
		$("doc_compta_tot_montant_tva_ok").style.color ="#FF0000";
		$("doc_compta_tot_montant_tva_ok").innerHTML = parseFloat (total_lines_tva).toFixed(tarifs_nb_decimales)+" "+monnaie_html;
		retour = false;
	}
	if (Math.abs(parseFloat($("doc_compta_montant_ttc").value)-0.01) <= Math.abs(parseFloat (total_lines_ttc).toFixed(tarifs_nb_decimales)) && Math.abs(parseFloat (total_lines_ttc).toFixed(tarifs_nb_decimales)) <= Math.abs(parseFloat($("doc_compta_montant_ttc").value)+0.01)) {
		$("doc_compta_tot_montant_ttc_ok").style.color ="#66CC33";
		$("doc_compta_tot_montant_ttc_nok").hide();
		$("doc_compta_tot_montant_ttc_ok").innerHTML = parseFloat (total_lines_ttc).toFixed(tarifs_nb_decimales)+" "+monnaie_html;
	} else {
		$("doc_compta_tot_montant_ttc_nok").show();
		$("doc_compta_tot_montant_ttc_ok").style.color ="#FF0000";
		$("doc_compta_tot_montant_ttc_ok").innerHTML = parseFloat (total_lines_ttc).toFixed(tarifs_nb_decimales)+" "+monnaie_html;
		retour = false;
	}
	return retour;
}

function insert_compta_line (id_journal) {
	var indent = parseInt($("indentation_compta_lignes").value);
	var AppelAjax = new Ajax.Updater(
									"liste_comptes_"+id_journal,
									"documents_compta_line.php",
									{
									parameters: {ref_doc: $("ref_doc_compta").value, indent: indent, id_journal : id_journal},
									evalScripts:true,
									onLoading:S_loading,
									onComplete: function() {
															H_loading();
															},
									insertion: Insertion.Bottom
									}
									);
	$("indentation_compta_lignes").value = indent+1;
}





//fonction de verification du totaldes part des commerciaux  sur un document
function check_document_commerciaux_attribution (nombre_lignes) {
	var indent = parseInt(nombre_lignes);
	var total_lines = 0;
	var retour = true;
	for (var j = 0; j <= indent; j++) {
		if ($("part_"+j) && !$("part_"+j).disabled) {
			total_lines += parseFloat($("part_"+j).value);
		}
	}
	if (parseInt(total_lines) > 100 ) {
		alerte.alerte_erreur ('Erreur dans la répartition', 'La répartition entre les commerciaux doit être inférieure ou égale à 100%','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		retour = false;
	}
	return retour;
}