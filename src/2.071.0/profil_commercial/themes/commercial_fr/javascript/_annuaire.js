//------------------------------------------
//------------------------------------------
//fonctions destinées à l'annuaire contact
//------------------------------------------
//------------------------------------------

// insertion d'un tableau pour les adresses coordonnées et site pour un nouveau contact
function createnewtagmobil( idzone, nomtag, contenttag, unused) {
	var zone= $(idzone);
	var addli= document.createElement(nomtag);
	addli.setAttribute ("id", contenttag+"_li_"+id_index_contentcoord);
	var contentzone= Remplace($(contenttag).innerHTML,"%//%", ""+id_index_contentcoord+"");
	zone.appendChild(addli);
	$(contenttag+"_li_"+id_index_contentcoord).innerHTML=contentzone;
	// lancer les villes par code dans les adresses
	if (contenttag=="adressecontent") {
	pre_start_commune("adresse_code"+id_index_contentcoord, "adresse_ville"+id_index_contentcoord, "choix_adresse_ville"+id_index_contentcoord, "iframe_choix_adresse_ville"+id_index_contentcoord, "liste_ville.php?cp=", "adresse_id_pays"+id_index_contentcoord);
	}	
	supp_new_caiu("link_sup_"+contenttag+"_li_"+id_index_contentcoord, contenttag+"_li_"+id_index_contentcoord);

	$("compte_info").value=id_index_contentcoord;
	id_index_contentcoord=id_index_contentcoord+1;
}


// insertion d'un tableau pour les adresses coordonnées et site nouveau pour un contact existant
function createtagmobil( idzone, nomtag, contenttag, targetname) {
	var zone= $(idzone);
	var addli= document.createElement(nomtag);
		addli.setAttribute ("id", contenttag+"_li_"+id_index_contentcoord);
	var formli= document.createElement("form");
		formli.setAttribute ("id", "annu_"+targetname+id_index_contentcoord);
		formli.setAttribute ("name", "annu_"+targetname+id_index_contentcoord);
		formli.setAttribute ("method", "post");
		formli.setAttribute ("action", "annuaire_"+targetname+".php");
		formli.setAttribute ("target", "formFrame");
	var divli= document.createElement("div");
		divli.setAttribute ("id", "div_annu_"+targetname+id_index_contentcoord);
		divli.setAttribute("class","infotable_form") ;
		divli.setAttribute ("className", "infotable_form");
		
	var inputid= document.createElement("input");
		inputid.setAttribute ("name", "ref_idform");
		inputid.setAttribute ("type", "hidden");
		inputid.setAttribute ("value", id_index_contentcoord);
	var inputcontact= document.createElement("input");
		inputcontact.setAttribute ("name", "ref_contact"+id_index_contentcoord);
		inputcontact.setAttribute ("type", "hidden");
		inputcontact.setAttribute ("value", $("ref_contact").value);
	var divaj= document.createElement("div");
		divaj.setAttribute ("id", "div_aj_"+targetname+id_index_contentcoord);
		divaj.setAttribute("class","rightalign") ;
		divaj.setAttribute ("className", "rightalign");
	var inputajout= document.createElement("input");
		inputajout.setAttribute ("id", "ajouter"+id_index_contentcoord);
		inputajout.setAttribute ("name", "ajouter"+id_index_contentcoord);
		inputajout.setAttribute ("type", "image");
		inputajout.setAttribute ("src", dirtheme+"images/bt-ajouter.gif");
	var contentzone= Remplace($(contenttag).innerHTML,"%//%", ""+id_index_contentcoord+"");
	zone.appendChild(addli);
	$(contenttag+"_li_"+id_index_contentcoord).appendChild(formli);
	$("annu_"+targetname+id_index_contentcoord).appendChild(divli);
	$("div_annu_"+targetname+id_index_contentcoord).innerHTML=contentzone;
	$("div_annu_"+targetname+id_index_contentcoord).appendChild(inputid);
	$("div_annu_"+targetname+id_index_contentcoord).appendChild(inputcontact);
	$("div_annu_"+targetname+id_index_contentcoord).appendChild(divaj);
	$("div_aj_"+targetname+id_index_contentcoord).appendChild(inputajout);
	// lancer les villes par code dans les adresses
	if (contenttag=="adressecontent") {
pre_start_commune("adresse_code"+id_index_contentcoord, "adresse_ville"+id_index_contentcoord, "choix_adresse_ville"+id_index_contentcoord, "iframe_choix_adresse_ville"+id_index_contentcoord, "liste_ville.php?cp=", "adresse_id_pays"+id_index_contentcoord);
	}
	if (contenttag=="usercontent") {
//fonction de choix de coordonnees
 pre_start_coordonnee ("coordonnee_choisie"+id_index_contentcoord, "bt_coordonnee_choisie"+id_index_contentcoord, $("ref_contact").value, "lib_coordonnee_choisie"+id_index_contentcoord, "user_coord"+id_index_contentcoord, "choix_liste_choix_coordonnee"+id_index_contentcoord, "iframe_liste_choix_coordonnee"+id_index_contentcoord, "annuaire_liste_choix_coordonnee.php")
					
	}
	
	supp_new_caiu("link_sup_"+contenttag+"_li_"+id_index_contentcoord, contenttag+"_li_"+id_index_contentcoord);

	// lancer les infobulles sur la coche utilisateur
//	if (contenttag=="coordcontent") {
//		inf_bulle="email_user_creation_info"+id_index_contentcoord;
//	new Event.observe("email_user_creation"+id_index_contentcoord, "mouseover", function(){$(inf_bulle).style.display = "block";}, false);
//	new Event.observe("email_user_creation"+id_index_contentcoord, "mouseout", function(){$(inf_bulle).style.display = "none";}, false);
//	}				
	$("compte_info").value=id_index_contentcoord;
	id_index_contentcoord=id_index_contentcoord+1;
}



// switch d'un tableau pour les adresses coordonnées et site pour un contact
//nouveau validé switch vers présentation existant
function switchtagmobil( idzone, nomtag, contenttag, pagetogo, ref_caiu) {
	var zone= $(idzone);
	var addli= document.createElement(nomtag);
	addli.setAttribute ("id", contenttag+"_li_"+id_index_contentcoord);
	zone.appendChild(addli);

	var AppelAjax = new Ajax.Updater(contenttag+"_li_"+id_index_contentcoord, 
									pagetogo+".php", {
									method: "post",
									asynchronous: true,
									contentType:  "application/x-www-form-urlencoded",
									encoding:     "UTF-8",
									parameters: { ref_contact: $("ref_contact").value, ref: ref_caiu, compte_info : id_index_contentcoord},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading});

	//Sortable.create(idzone,{scroll:pagetogo});
	$("compte_info").value=id_index_contentcoord;
	id_index_contentcoord=id_index_contentcoord+1;
}


// rafraichissement d'un tableau pour les adresses coordonnées et site pour un contact
//modifié et validé qui retourne à la présentation visuelle.
function refreshtagmobil( idzone, nomtag, contenttag, pagetogo, ref_caiu, num_caiu) {
	if (num_caiu=="" || num_caiu) {
	num_caiu	=	$(ref_caiu).value;
	}
	var AppelAjax = new Ajax.Updater(contenttag+"_li_"+num_caiu, 
									pagetogo+".php", {
									method: "post",
									asynchronous: true,
									contentType:  "application/x-www-form-urlencoded",
									encoding:     "UTF-8",
									parameters: { ref_contact: $("ref_contact").value, ref: ref_caiu, compte_info : num_caiu},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading});
}



// affichage des formulaires de profil à la création d'une nouvelle fiche contact
function affiche_annu_nvlf_profil (nprofil) {
	if ($("profils"+nprofil).checked) {
		var npzone=$("zoneprofils");
		var npadd=document.createElement("div");
		npadd.setAttribute ("id", "typeprofil"+nprofil);
		npzone.appendChild (npadd);
		page.traitecontent("profil"+nprofil,"annuaire_nouvelle_fiche_profil"+nprofil+".php?crea=1", true ,"typeprofil"+nprofil);
	}
	else
	{
		remove_tag("typeprofil"+nprofil);
	}
}


// affichage des formulaires de profil (profil ajouté) à l'édition d'une fiche contact
function affiche_annu_edif_profil (nprofil, intitule_profil) {
	if ($("profils"+nprofil).checked) {
		var npzone=$("zoneprofils");
		var npadd=document.createElement("div");
			npadd.setAttribute("class","menu_link_affichage") ;
			npadd.setAttribute ("className", "menu_link_affichage");
			npadd.setAttribute ("id", "x_typeprofil"+nprofil);
		var npclass=document.createElement("div");
			npclass.setAttribute("class","contactview_corps") ;
			npclass.setAttribute ("className", "contactview_corps");
			npclass.setAttribute ("id", "typeprofil"+nprofil);
		var formp= document.createElement("form");
			formp.setAttribute ("id", "provil_edif_ajout"+nprofil);
			formp.setAttribute ("name", "provil_edif_ajout"+nprofil);
			formp.setAttribute ("method", "post");
			formp.setAttribute ("action", "annuaire_edition_profil_nouvelle.php");
			formp.setAttribute ("target", "formFrame");
		var inputid= document.createElement("input");
			inputid.setAttribute ("name", "id_profil");
			inputid.setAttribute ("type", "hidden");
			inputid.setAttribute ("value", nprofil);
		var inputcontact= document.createElement("input");
			inputcontact.setAttribute ("name", "ref_contact");
			inputcontact.setAttribute ("type", "hidden");
			inputcontact.setAttribute ("value", $("ref_contact").value);
		var vidediv=document.createElement("div");
			vidediv.setAttribute ("id", "vide_typeprofil"+nprofil);
			vidediv.setAttribute("class","profil_reduce") ;
			vidediv.setAttribute ("className", "profil_reduce");
		var p_inputajout=document.createElement("p");
			p_inputajout.setAttribute ("id", "p_ajouter_"+nprofil);
			p_inputajout.setAttribute("class","bt_ajout_center_profil") ;
			p_inputajout.setAttribute ("className", "bt_ajout_center_profil");
		var inputajout= document.createElement("input");
			inputajout.setAttribute ("id", "ajouter"+id_index_contentcoord);
			inputajout.setAttribute ("name", "ajouter"+id_index_contentcoord);
			inputajout.setAttribute ("type", "image");
			inputajout.setAttribute ("src", dirtheme+"images/bt-ajouter.gif");
		npzone.appendChild (npadd);
		npadd.appendChild (npclass);
		$("typeprofil"+nprofil).setStyle({   overflow: 'auto' });
		//Element.hide($("typeprofil"+nprofil));
		$("typeprofil"+nprofil).appendChild (formp);
		$("provil_edif_ajout"+nprofil).appendChild (inputid);
		$("provil_edif_ajout"+nprofil).appendChild (inputcontact);
		$("provil_edif_ajout"+nprofil).appendChild (vidediv);
		$("provil_edif_ajout"+nprofil).appendChild (p_inputajout);
		$("p_ajouter_"+nprofil).appendChild (inputajout);
		page.traitecontent("profil"+nprofil,"annuaire_nouvelle_fiche_profil"+nprofil+".php", true , "vide_typeprofil"+nprofil);
		
		insert_profil_button(nprofil, intitule_profil);
		
		set_tomax_height("x_typeprofil"+nprofil , -46);
		set_tomax_height("typeprofil"+nprofil , -52);
		Event.observe(window, "resize", function(){set_tomax_height("x_typeprofil"+nprofil , -46);set_tomax_height("typeprofil"+nprofil, -52);}, false);
	}
	else
	{
		remove_provil_visu (nprofil);
	}
}

//insertion du bouton correspondant à un nouveau profil choisi 
function insert_profil_button(nprofil, intitule_profil) {

		new Insertion.Before ($('insertprof_before'), "<li id='exist_profil_"+nprofil+"'></li>");
		$("exist_profil_"+nprofil).innerHTML = "<a href=\"#\" id=\"typeprofil_menu_"+nprofil+"\" class=\"menu_unselect\">"+intitule_profil+"</a>";
		
		Event.observe("typeprofil_menu_"+nprofil, "click",  function(evt){Event.stop(evt); view_menu_1( "x_typeprofil"+nprofil, "typeprofil_menu_"+nprofil, array_menu_v_contact); set_tomax_height("x_typeprofil"+nprofil , -46); set_tomax_height("typeprofil"+nprofil , -52);}, false);
		
		view_menu ( "x_typeprofil"+nprofil, "typeprofil_menu_"+nprofil, "menu_ul", "contactview");
}



// rétabli la coche sur un profil existant si la supression a été annulée
function check_profil (profil_check) {
$(profil_check).checked="checked";
}

// suppréssion du profil et du bouton dans l'affichage d'un contact
function remove_provil_visu (nprofil) {
	remove_tag("exist_profil_"+nprofil);
	remove_tag("x_typeprofil"+nprofil);
}


//swicth un profil mode nouveau en mode edition 
//
function switchprofil_new_edit(id_profil, div_target, page_include) {

	var AppelAjax = new Ajax.Updater(div_target, 
									page_include+".php", {
									method: "post",
									asynchronous: true,
									contentType:  "application/x-www-form-urlencoded",
									encoding:     "UTF-8",
									parameters: { ref_contact: $("ref_contact").value, id_profil : id_profil},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading});

}

//
//swicth un profil mode nouveau en mode edition 
//
function refreshprofil_edit(id_profil, div_target, page_include) {

	var AppelAjax = new Ajax.Updater(div_target, 
									page_include+".php", {
									method: "post",
									asynchronous: true,
									contentType:  "application/x-www-form-urlencoded",
									encoding:     "UTF-8",
									parameters: { ref_contact: $("ref_contact").value, id_profil : id_profil},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading});

}




// edition d'une fiche (efet roll over remplacé par champs du formulaire)
function showform (appear, unshow) {
	$(appear).style.display="block";
	$(appear).focus();
	$(unshow).style.display="none";
}
function show_edit_form(formname, visuname, formfocus) {

	$(formname).style.display="";
	$(visuname).style.display="none";
	$(formfocus).focus();
}



//fonction d'appel de page en fonction de la catégorie de client qui rempli les champs concernés par leur valeur par defaut
function annu_client_categ_preselect (id_client_categ) {
		var AppelAjax = new Ajax.Request(
									"annuaire_profil_client_preselect.php", 
									{
									parameters: {id_client_categ: id_client_categ  },
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									H_loading();
									requester.responseText.evalScripts();
									}
									}
									);
}


//fusionner deux contact
function fusionner_contact (ref_contact, new_ref_contact) {
	$("new_ref_contact").value = new_ref_contact;
	alerte.confirm_supprimer('fusionner_contact', 'annu_fusion');
}



////pas utilisé mais pour mémoire


function change_ordre_caiu_down (ele, bt, ref_c, ord1, ord2, page2call){


//var this_tag	=	($(bt).up("li").id).replace(ele,"");
//alert("-1 "+this_tag);
//var next_tag	=	($($(bt).up("li").id).next().id).replace(ele,"");
//alert("-2 "+next_tag);

//switch_element(ele+this_tag, ele+next_tag);
//switch_inner_element('up_arrow_'+this_tag, 'up_arrow_'+next_tag);
//switch_inner_element('down_arrow_'+this_tag, 'down_arrow_'+next_tag); 

var AppelAjax = new Ajax.Request(
									page2call, {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { ref_contact: ref_c, ordre : ord1, ordre_other: ord2}
									}
									);

}


//modification des position de CAIU lors du clic sur un bouton haut
function change_ordre_caiu_up (ele, bt, ref_c, ord1, ord2, page2call){


//var this_tag	=	($(bt).up("li").id).replace(ele,"");
//alert("-1 "+this_tag);
//var previous_tag	=	($($(bt).up("li").id).previous().id).replace(ele,"");
//alert("-2 "+previous_tag);

//switch_element(ele+this_tag, ele+previous_tag);
//switch_inner_element('up_arrow_'+this_tag, 'up_arrow_'+previous_tag);
//switch_inner_element('down_arrow_'+this_tag, 'down_arrow_'+previous_tag); 


var AppelAjax = new Ajax.Request(
									page2call, {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { ref_contact: ref_c, ordre : ord1, ordre_other: ord2}
									}
									);
}


// fin des " pas utilisés"

//ajout d'un fonction de collab
function add_fonction_collab (id_fonction, ref_contact, maj_user_perms) {
	var AppelAjax = new Ajax.Request(
									"annuaire_edition_collab_add_fonction.php", 
									{
									parameters: {id_fonction: id_fonction, ref_contact: ref_contact, maj_user_perms: maj_user_perms  },
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (){
															H_loading(); 
									}
									}
									);
}


//suppression d'un fonction de collab
function del_fonction_collab (id_fonction, ref_contact, maj_user_perms) {
	var AppelAjax = new Ajax.Request(
									"annuaire_edition_collab_del_fonction.php", 
									{
									parameters: {id_fonction: id_fonction, ref_contact: ref_contact, maj_user_perms: maj_user_perms  },
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (){
															H_loading(); 
									}
									}
									);
}




function set_master(ref_user) {
	
				var AppelAjax = new Ajax.Request(
									"utilisateur_set_master.php", 
									{
									parameters: {ref_user: ref_user},
									evalScripts:true, 
									onLoading:S_loading, 
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}


//charge le contenu de la popup plus d'infos de la page de validation des inscriptions
function chargerInfValIns(id_contact_tmp, id_interface) {
	var AppelAjax = new Ajax.Updater( 
															"popup_more_infos", 
															"annuaire_val_ins_infos.php",  
															{ 
															parameters: {id_contact_tmp: id_contact_tmp, id_interface: id_interface}, 
															evalScripts:true,  
															onLoading:S_loading, onException: function () {S_failure();}, 
															onComplete: function() {
																						H_loading(); 
																						}
															} 
															);
	
}

// fonction qui charge la page qui valide ou non le contact
function validInfValIns(id_contact_tmp, id_interface, etat) {
	var AppelAjax = new Ajax.Request(
			"annuaire_val_ins.php", 
			{
			parameters: {id_contact_tmp: id_contact_tmp, id_interface: id_interface, etat: etat},
			evalScripts:true, 
			onLoading:S_loading, 
			onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading(); 
									}
			}
			);
}


function chargerInsSansMail(val_mail){
	var AppelAjax = new Ajax.Updater( 
			"valid_inscription", 
			"annuaire_valider_inscriptions.php",  
			{ 
			parameters: {val_mail: val_mail}, 
			evalScripts:true,  
			onLoading:S_loading, onException: function () {S_failure();}, 
			onComplete: function() {
										H_loading(); 
										}
			} 
			);

}

function chargerModSansMail(val_mail){
	var AppelAjax = new Ajax.Updater( 
			"valid_inscription", 
			"annuaire_valider_inscriptions.php",  
			{ 
			parameters: {val_mail: val_mail, modifs: true}, 
			evalScripts:true,  
			onLoading:S_loading, onException: function () {S_failure();}, 
			onComplete: function() {
										H_loading(); 
										}
			} 
			);

}