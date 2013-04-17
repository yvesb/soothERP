//***************************************************************
//FONCTIONS LIEES AUX TACHES et AUX FAVORIS
//***************************************************************

//maj de la note d'une tache
function maj_tache_note (id_note, id_tache) {
	var AppelAjax = new Ajax.Request(
									"planning_taches_maj_note.php", 
									{
									parameters: {id_tache: id_tache, note: escape($(id_note).value)},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading(); 
									}
									}
									);
}


//maj de l'etat d'une tache
function maj_etat_tache (etat, id_tache) {
	var AppelAjax = new Ajax.Request(
									"planning_taches_maj_etat.php", 
									{
									parameters: {id_tache: id_tache, etat: etat},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading(); 
									}
									}
									);
}

//add_collab à un tache
function add_collab_tache (id_tache, id_increment_tache, id_contener, ref_contact, lib_contact) {
	var AppelAjax = new Ajax.Request(
									"planning_taches_add_collab.php", 
									{
									parameters: {id_tache: id_tache, ref_contact: ref_contact},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										tache_set_contact_edition (id_tache, id_increment_tache, id_contener, ref_contact, lib_contact);
										H_loading(); 
									}
									}
									);
}
//del_collab à un tache
function del_collab_tache (id_tache, id_tag, ref_contact) {
	var AppelAjax = new Ajax.Request(
									"planning_taches_del_collab.php", 
									{
									parameters: {id_tache: id_tache, ref_contact: ref_contact},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										remove_tag(id_tag);
										H_loading(); 
									}
									}
									);
}


//add_fonction à un tache
function add_fonction_tache (id_tache, id_fonction) {
	var AppelAjax = new Ajax.Request(
									"planning_taches_add_fonction.php", 
									{
									parameters: {id_tache: id_tache, id_fonction: id_fonction},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading(); 
									}
									}
									);
}
//del_fonction à un tache
function del_fonction_tache (id_tache, id_fonction) {
	var AppelAjax = new Ajax.Request(
									"planning_taches_del_fonction.php", 
									{
									parameters: {id_tache: id_tache, id_fonction: id_fonction},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading(); 
									}
									}
									);
}



//maj de l'etat d'une tache
function tache_edition (id_tache) {
	$("nouvelle_tache_content").innerHTML="";
	var AppelAjax = new Ajax.Updater(
									"edition_tache",
									"planning_taches_edition.php", 
									{
									parameters: {id_tache: id_tache},
									evalScripts:true, 
									onLoading:S_loading, 
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										$("edition_tache").show();
										$("edition_tache_iframe").show();
										H_loading(); 
									}
									}
									);
}

//recharger la page de liste des taches
function tache_reload_crees () {
	var page_to_show = $("page_to_show").value;
	var all_etat_tache = "0";
	var order_by_date = "";
	var order_by_urgence = "";
	var order_by_importance = "";
	if ($("order_by_date")) {order_by_date = $("order_by_date").value;}
	if ($("order_by_urgence")) {order_by_urgence = $("order_by_urgence").value;}
	if ($("order_by_importance")) {order_by_importance = $("order_by_importance").value;}
	if ($("all_etat_tache").checked) {all_etat_tache = "1";}
	
	var AppelAjax = new Ajax.Updater(
									"taches_crees_content",
									"planning_taches_crees_liste.php", 
									{
									parameters: {all_etat_tache: all_etat_tache, page_to_show: page_to_show, order_by_date: order_by_date, order_by_urgence: order_by_urgence, order_by_importance: order_by_importance},
									evalScripts:true, 
									onLoading:S_loading, 
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading(); 
									}
									}
									);
}
//recharger la page de liste des taches
function tache_reload_todo () {
	var page_to_show = $("page_to_show").value;
	var all_etat_tache = "0";
	var order_by_date = "";
	var order_by_urgence = "";
	var order_by_importance = "";
	if ($("order_by_date")) {order_by_date = $("order_by_date").value;}
	if ($("order_by_urgence")) {order_by_urgence = $("order_by_urgence").value;}
	if ($("order_by_importance")) {order_by_importance = $("order_by_importance").value;}
	if ($("all_etat_tache").checked) {all_etat_tache = "1";}
	
	var AppelAjax = new Ajax.Updater(
									"liste_taches_content",
									"planning_taches_liste.php", 
									{
									parameters: {all_etat_tache: all_etat_tache, page_to_show: page_to_show, order_by_date: order_by_date, order_by_urgence: order_by_urgence, order_by_importance: order_by_importance},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading(); 
									}
									}
									);
}


//fonction d'ajout de contact dans la liste des collab assignés à une tache

function tache_set_contact (id_increment_tache, id_contener, ref_contact, lib_contact) {
	var increment_tache = parseInt($(id_increment_tache).value);
	var zone= $(id_contener);
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "contact_collab_"+increment_tache);
		adddiv.setAttribute ("class", "height_div");
		adddiv.setAttribute ("className", "height_div");
	zone.appendChild(adddiv);
	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("id","sup_collab_"+increment_tache) ;
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
		addimgsup.setAttribute ("class", "img_float_r");
		addimgsup.setAttribute ("className", "img_float_r");
	$("contact_collab_"+increment_tache).appendChild(addimgsup);
	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "nom_collab_"+increment_tache);
	$("contact_collab_"+increment_tache).appendChild(addspan);
	$("nom_collab_"+increment_tache).innerHTML = lib_contact;
	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "ref_contact_collab_"+increment_tache);
		inputtext.setAttribute ("name", "ref_contact_collab_"+increment_tache);
		inputtext.setAttribute ("type", "hidden");
		inputtext.setAttribute ("value", ref_contact);
	$("contact_collab_"+increment_tache).appendChild(inputtext);
	
	pre_start_sup_collab_tache ("sup_collab_"+increment_tache, "contact_collab_"+increment_tache);
	increment_tache ++;
	$(id_increment_tache).value = increment_tache;
}

function pre_start_sup_collab_tache (id_bt, id_tag) {
	Event.observe(id_bt, "click",  function(evt){Event.stop(evt); remove_tag(id_tag);}, false);

}


//fonction d'ajout de contact dans la liste des collab assignés à une tache en mode EDITION

function tache_set_contact_edition (id_tache, id_increment_tache, id_contener, ref_contact, lib_contact) {
	var increment_tache = parseInt($(id_increment_tache).value);
	var zone= $(id_contener);
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "contact_collab_"+increment_tache);
		adddiv.setAttribute ("class", "height_div");
		adddiv.setAttribute ("className", "height_div");
	zone.appendChild(adddiv);
	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("id","sup_collab_"+increment_tache) ;
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
		addimgsup.setAttribute ("class", "img_float_r");
		addimgsup.setAttribute ("className", "img_float_r");
	$("contact_collab_"+increment_tache).appendChild(addimgsup);
	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "nom_collab_"+increment_tache);
	$("contact_collab_"+increment_tache).appendChild(addspan);
	$("nom_collab_"+increment_tache).innerHTML = lib_contact;
	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "ref_contact_collab_"+increment_tache);
		inputtext.setAttribute ("name", "ref_contact_collab_"+increment_tache);
		inputtext.setAttribute ("type", "hidden");
		inputtext.setAttribute ("value", ref_contact);
	$("contact_collab_"+increment_tache).appendChild(inputtext);
	
	pre_start_sup_collab_tache_edition (id_tache, "sup_collab_"+increment_tache, "contact_collab_"+increment_tache, ref_contact);
	increment_tache ++;
	$(id_increment_tache).value = increment_tache;
}

function pre_start_sup_collab_tache_edition (id_tache, id_bt, id_tag, ref_contact) {
	Event.observe(id_bt, "click",  function(evt){Event.stop(evt); del_collab_tache (id_tache, id_tag, ref_contact);}, false);

}


//**********************************************************************************************
//GESTION DES FAVORIS
//**********************************************************************************************

//maj de l'ordre
function lien_maj_ordre (indent_ligne) {

	var id_liste = indent_ligne.id;
	var id_web_link = $("id_web_link_"+id_liste.split("_")[1]).value;
	var newordre = 1;
	if (!$("vos_liens").empty()) {
		var liste = serialisation("vos_liens", "li").replace(/vos_liens\[\]=/g,"");
		t_liste = liste.split("&");
		
		for (i=0; i < t_liste.length; i++) {
			if (t_liste[i] == id_liste.split("_")[1]) {
				var AppelAjax = new Ajax.Request(
										"planning_liens_ordre.php", 
										{
										parameters: { id_web_link: id_web_link , ordre: newordre},
										evalScripts:true, 
										onLoading: S_loading,
										onSuccess: function (requester){
											requester.responseText.evalScripts();
											H_loading();
										}
										}
										);
			}
			newordre++;
		}
	}
}
