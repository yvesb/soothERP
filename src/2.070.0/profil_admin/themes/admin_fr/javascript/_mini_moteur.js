// mini_moteur recherche article
function reset_mini_moteur(id_form, init_request, init_categ, input_1, select_1, id_resulat) {
	 $(init_request).value="";
	 $(input_1).value="";
	 $(select_1).selectedIndex=0;
	 $(init_categ).innerHTML="Toutes";
	 $(id_resulat).innerHTML="";
}

// moteur simple recherche article
function reset_moteur_s (id_form, init_request, init_categ) {
	 $(id_form).reset();
	 $(init_request).value="";
	 $(init_categ).innerHTML="Toutes";
	 
}
// moteur avancé recherche article
function reset_moteur_a (id_form, init_request, init_categ) {
	 $(id_form).reset();
	 $(init_request).value="";
	 $(init_categ).innerHTML="Toutes";
	 
}
	
//chargement des caracteristiques simple pour moteur de recherche article avancé
function charger_carac_simple (ref_art_categ, id_cible) {
			var AppelAjax = new Ajax.Updater(
									id_cible, 
									"catalogue_recherche_categ_caract_simple.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { ref_art_categ: ref_art_categ},
									evalScripts:true, 
									onLoading:S_loading, onException: function (){S_failure();}, 
									onComplete:H_loading}
									);

}
//chargement des caracteristiques avancee pour moteur de recherche article avancé
function charger_carac_avancee (ref_art_categ, id_cible) {
			var AppelAjax = new Ajax.Updater(
									id_cible, 
									"catalogue_recherche_categ_caract_avancee.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { ref_art_categ: ref_art_categ},
									evalScripts:true, 
									onLoading:S_loading, onException: function (){S_failure();}, 
									onComplete:H_loading}
									);

}
// fonction ferme moteur
function close_mini_moteur() {
	$('pop_up_mini_moteur').hide(); 
	$('pop_up_mini_moteur_iframe').hide(); 
	reset_mini_moteur ('form_mini_recherche', 'ref_art_categ_s', 'lib_art_categ_s', 'lib_article_s', 'ref_constructeur_s', 'resultat');
}


//fonction de retour du choix 
function show_mini_moteur_articles (fonction_retour, param_retour) {
	$('pop_up_mini_moteur').style.display='block'; 
	$('pop_up_mini_moteur_iframe').style.display='block'; 
	$('liste_de_categorie_selectable_s').style.width =	return_width_element('lib_art_categ_link_select_s')+'px';
	$('iframe_liste_de_categorie_selectable_s').style.width =	 return_width_element('lib_art_categ_link_select_s')+'px';
	$('fonction_retour_s').value = fonction_retour;
	$('param_retour_s').value	=	param_retour;
	$('lib_article_s').focus();
}



// fonction ferme moteur contact
function close_mini_moteur_contacts() {
	$('pop_up_mini_moteur').hide(); 
	$('pop_up_mini_moteur_iframe').hide(); 
	$('form_recherche_mini').reset();
	$('resultat_contact_mini').innerHTML="";
}
//fonction d'affichage du mini moteur de recherche d'un contact
function show_mini_moteur_contacts (fonction_retour, param_retour) {
	$('pop_up_mini_moteur').style.display='block'; 
	$('pop_up_mini_moteur_iframe').style.display='block'; 
	$('fonction_retour_m').value = fonction_retour;
	$('param_retour_m').value	=	param_retour;
	$('nom_m').focus();
}

//fonction de mise à jour du contact depuis le mini moteur de recherche de contact

function recherche_docu_set_contact (id_ref_contact, id_lib_contact, ref_contact, lib_contact) {
	$(id_ref_contact).value = ref_contact;
	$(id_lib_contact).innerHTML = lib_contact;
	
}
//fonction de mise à jour de la ref_contact pour les comptes bancaire depuis le mini moteur de recherche de contact

function recherche_compte_b_set_contact (id_ref_contact, id_lib_contact, ref_contact, lib_contact) {
	$(id_ref_contact).value = ref_contact;
	$(id_lib_contact).value = lib_contact;
	
}
//fonction de mise à jour de la ref_commercial
function recherche_client_set_contact (id_ref_contact, id_lib_contact, ref_contact, lib_contact) {
	$(id_ref_contact).value = ref_contact;
	$(id_lib_contact).value = lib_contact;
	
}
//fonction de mise à jour de la transporteur pour livraiosns modes
function recherche_livraison_set_contact (id_ref_contact, id_lib_contact, ref_contact, lib_contact) {
	$(id_ref_contact).value = ref_contact;
	$(id_lib_contact).value = lib_contact;
	
}



// function de raz du moteur  de recherche simple de documents
// moteur avancé recherche article
function reset_moteur_doc_s (id_form, init_request, init_categ, etat_select) {
	 $(id_form).reset();
   $(etat_select).innerHTML = "";
   option = document.createElement("option");
   option.setAttribute("value", "");
   option.innerHTML = "Tous";
   $(etat_select).appendChild(option);
	 $(init_request).value="";
	 $(init_categ).innerHTML="Tous";
	 
}

// fonction ferme mini moteur documents
function close_mini_moteur_documents() {
	$('pop_up_mini_moteur_doc').hide(); 
	$('pop_up_mini_moteur_doc_iframe').hide(); 
	 reset_moteur_doc_s ('form_recherche_doc_m', 'ref_contact_doc_m', 'ref_contact_nom_doc_m', 'id_etat_doc_doc_m');
}
//fonction d'affichage du mini moteur de recherche d'un document
function show_mini_moteur_documents (fonction_retour, param_retour) {
	$('pop_up_mini_moteur_doc').style.display='block'; 
	$('pop_up_mini_moteur_doc_iframe').style.display='block'; 
	$('fonction_retour_doc_m').value = fonction_retour;
	$('param_retour_doc_m').value	=	param_retour;
}

//résumé des stocks dans les recherches d'articles

function show_resume_stock (ref_article, evt) {
	if (	$('resume_stock').style.display == 'block'  ) {
		$('resume_stock').style.display='none'; 
		$('resume_stock_iframe').style.display='none';
	} else {
		$('resume_stock').style.display='none'; 
		$('resume_stock_iframe').style.display='none'; 
		
		var AppelAjax = new Ajax.Updater(
								"resume_stock", 
								"catalogue_articles_resume_stock.php", {
								method: 'post',
								asynchronous: true,
								contentType:  'application/x-www-form-urlencoded',
								encoding:     'UTF-8',
								parameters: { ref_article: ref_article},
								evalScripts:true, 
								onLoading:S_loading, onException: function (){S_failure();}, 
								onComplete:function () {
										$("resume_stock_iframe").style.height = return_height_element("resume_stock") +"px";
										$("resume_stock_iframe").style.width = return_width_element("resume_stock") +"px"; 
										centrage_element('resume_stock');
										centrage_element('resume_stock_iframe');
										$('resume_stock').style.display='block'; 
										$('resume_stock_iframe').style.display='block'; 
										H_loading(); 
										H_loading(); 
										}
								}
								);
	}
}

function show_resume_stock2 (ref_article) {
	if (	$('resume_stock').style.display =='block'  ) {
		$('resume_stock').style.display='none'; 
		$('resume_stock_iframe').style.display='none';
	} else {
		$('resume_stock').style.display='none'; 
		$('resume_stock_iframe').style.display='none'; 
		
		var AppelAjax = new Ajax.Updater(
								"resume_stock", 
								"catalogue_articles_resume_stock.php", {
								method: 'post',
								asynchronous: true,
								contentType:  'application/x-www-form-urlencoded',
								encoding:     'UTF-8',
								parameters: { ref_article: ref_article},
								evalScripts:true, 
								onLoading:S_loading, onException: function (){S_failure();}, 
								onComplete:function () {
									$('resume_stock').style.display='block'; 
									$('resume_stock_iframe').style.display='block'; 
									$("resume_stock_iframe").style.height = return_height_element("resume_stock") +"px";
									$("resume_stock_iframe").style.width = return_width_element("resume_stock") +"px"; 
									$("resume_stock").style.top = $("resultat").style.top+180+"px"; 
									$("resume_stock").style.left = $("resultat").style.left+"px";
									$("resume_stock_iframe").style.top = $("resultat").style.top+180+"px"; 
									$("resume_stock_iframe").style.left = $("resultat").style.left+"px";
									
									H_loading(); 
									}
								}
								);
	}
}

// fonction ferme résumé des stocks
function close_resume_stock() {
	$('resume_stock').hide(); 
	$('resume_stock_iframe').hide(); 
	$('resume_stock').innerHTML=""; 
}


// fonction ouvre moteur choix compte plan comptable
function ouvre_compta_plan_mini_moteur() {
	$("aff_plan_mini").innerHTML = "";
	$('pop_up_compta_plan_mini_moteur').style.display='block'; 
}
// fonction ferme moteur choix compte plan comptable
function close_compta_plan_mini_moteur() {
	$('pop_up_compta_plan_mini_moteur').style.display='none'; 
}

//chargement des caracteristiques avancee pour moteur de recherche article avancé
function charger_compta_plan_mini_moteur (url_page_plan_recherche) {
			var AppelAjax = new Ajax.Updater(
									"aff_plan_mini", 
									url_page_plan_recherche, {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									evalScripts:true, 
									onLoading:S_loading,
									onComplete:H_loading}
									);

}

// fonction ouvre pop-up paramètrage de pdf
function ouvre_mini_moteur_doc_type() {
	$("aff_pop_up_mini_moteur_doc_type").innerHTML = "";
	$('pop_up_mini_moteur_doc_type').style.display='block'; 
}
// fonction ferme e pop-up paramètrage de pdf
function close_mini_moteur_doc_type() {
	$('pop_up_mini_moteur_doc_type').style.display='none'; 
}
// fonction ouvre pop up verification journal
function ouvre_compta_verify() {
				$("framealert").style.display = "block";
				$("alert_pop_up").style.display = "block";
	$('verify_journal').hide(); 
	$('verify_journal').innerHTML = ""; 
	$("progverify").style.width = "0%";
	$('verify_journal_start').show(); 
	$('pop_up_compta_verify').style.display='block'; 
}
// fonction ferme moteur choix compte plan comptable
function close_compta_verify() {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
	$('pop_up_compta_verify').style.display='none'; 
}

//chargement paramètrage de pdf
function charger_param_pdf (url_page_param_pdf) {
			var AppelAjax = new Ajax.Updater(
									"aff_pop_up_mini_moteur_doc_type", 
									url_page_param_pdf, {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									evalScripts:true, 
									onLoading:S_loading,
									onComplete:H_loading}
									);

}

//recherche de resultat pour la recherche de plan comptable

function load_result_plan_compte_recherche(search_type, search_value, url_search) {
		var AppelAjax = new Ajax.Updater(
									"result_search_compte", 
									url_search, {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { search_type: search_type, search_value: search_value},
									evalScripts:true, 
									onLoading:S_loading, onException: function (){S_failure();}, 
									onComplete:H_loading}
									);
	}
	
//fonction ouvre pop-up paramètrage de pdf
function ouvre_mini_moteur_courrier_type() {
	$("aff_pop_up_mini_moteur_courrier_type").innerHTML = "";
	$('pop_up_mini_moteur_courrier_type').style.display='block';
}

// fonction ferme e pop-up paramètrage de pdf
function close_mini_moteur_courrier_type() {
	$('pop_up_mini_moteur_courrier_type').style.display='none';
}