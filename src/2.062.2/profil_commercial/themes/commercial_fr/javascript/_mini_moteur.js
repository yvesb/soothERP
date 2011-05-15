// mini_moteur recherche article
function reset_mini_moteur(id_form, init_request, init_categ, input_1, select_1, id_resulat) {
	 $(init_request).value="";
	 $(input_1).value="";
	 $(select_1).selectedIndex=0;
	 if ($(init_categ)) {
	 	$(init_categ).innerHTML="Toutes";
	 }
	 $(id_resulat).innerHTML="";
}

// mini_moteur recherche article
function reset_mini_moteur_cata(id_form, init_request,  input_1, select_1, id_resulat) {
	 $(init_request).value="";
	 $(input_1).value="";
	 $(select_1).selectedIndex=0;
	 $(id_resulat).innerHTML="";
}

// moteur simple recherche article
function reset_moteur_s (id_form, init_request) {
	 $(id_form).reset();
	 $(init_request).selectedIndex=0;
	 
}
// moteur avancé recherche article
function reset_moteur_a (id_form, init_request, init_categ) {
	 $(id_form).reset();
	 $(init_request).selectedIndex=0;
	 
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
									onLoading:S_loading, onException: function () {S_failure();}, 
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
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading}
									);

}
// fonction ferme moteur
function close_mini_moteur() {
	$('pop_up_mini_moteur').hide(); 
	$('pop_up_mini_moteur_iframe').hide(); 
	reset_mini_moteur ('form_mini_recherche', 'ref_art_categ_s', 'lib_art_categ_s', 'lib_article_s', 'ref_constructeur_s', 'resultat');
}
// fonction ferme moteur
function close_mini_moteur_cata() {
	$('pop_up_mini_moteur_cata').hide(); 
	$('pop_up_mini_moteur_cata_iframe').hide(); 
	reset_mini_moteur ('form_mini_recherche_cata', 'ref_art_categ_cata_m', 'lib_art_categ_cata_m', 'lib_article_cata_m', 'ref_constructeur_cata_m', 'resultat_cata');
}

//fonction de retour du choix 
function show_mini_moteur_articles (fonction_retour, param_retour) {
	$('pop_up_mini_moteur_cata').style.display='block'; 
	$('pop_up_mini_moteur_cata_iframe').style.display='block'; 
	$('fonction_retour_cata_m').value = fonction_retour;
	$('param_retour_cata_m').value	=	param_retour;
	$('lib_article_cata_m').focus();
}


//fonction ouverture pop up gestion
function show_mini_pop_up_article_sn (ref_doc, ref_doc_line, page_to_show) {
	$('pop_up_mini_article_sn').style.display='block'; 
	$('pop_up_mini_article_sn_iframe').style.display='block';
		var AppelAjax = new Ajax.Updater(
								"resultat_article_sn", 
								"documents_line_article_sn_list.php", {
								method: 'post',
								asynchronous: true,
								contentType:  'application/x-www-form-urlencoded',
								encoding:     'UTF-8',
								parameters: { ref_doc: ref_doc, ref_doc_line:ref_doc_line, page_to_show:page_to_show},
								evalScripts:true, 
								onLoading:S_loading, 
								onComplete:function () {
										H_loading(); 
										}
								}
								);
}

// fonction ferme pop up ligne d'article gestion sn
function close_mini_pop_up_article_sn() {
	$('pop_up_mini_article_sn').hide(); 
	$('pop_up_mini_article_sn_iframe').hide(); 
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
	if (navigator.appName == 'Microsoft Internet Explorer') {
	$('pop_up_mini_moteur_iframe').style.display='block'; 
	}
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

//fonction d'affichage pour création d'un nouveau document d'aprés les lignes d'articles
function show_mini_moteur_newdocuments (fonction_retour, param_retour) {
	$('pop_up_newmini_moteur_doc').style.display='block'; 
	$('pop_up_newmini_moteur_doc_iframe').style.display='block'; 
	$('fonction_retour_doc_nm').value = fonction_retour;
	$('param_retour_doc_nm').value	=	param_retour;
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
								onLoading:S_loading, 
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
								onLoading:S_loading, 
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

//résumé des stocks dans articles à renouveller

function show_resume_stock_all (ref_article, evt) {
	if (	$('resume_stock').style.display == 'block'  ) {
		$('resume_stock').style.display='none'; 
		$('resume_stock_iframe').style.display='none';
	} else {
		$('resume_stock').style.display='none'; 
		$('resume_stock_iframe').style.display='none'; 
		
		var AppelAjax = new Ajax.Updater(
								"resume_stock", 
								"catalogue_articles_resume_stock_all.php", {
								method: 'post',
								asynchronous: true,
								contentType:  'application/x-www-form-urlencoded',
								encoding:     'UTF-8',
								parameters: { ref_article: ref_article},
								evalScripts:true, 
								onLoading:S_loading, 
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
// fonction ferme résumé des stocks
function close_resume_stock() {
	$('resume_stock').hide(); 
	$('resume_stock_iframe').hide(); 
	$('resume_stock').innerHTML=""; 
}

//fonction de chargement de liste de categorie
function load_liste_categ (url_to_load, id_cible) {
	
		var AppelAjax = new Ajax.Updater(
								id_cible, 
								url_to_load, 
								{
								method: 'post',
								asynchronous: true,
								encoding:     'UTF-8',
								evalScripts:true, 
								onLoading:S_loading, onException: function () {S_failure();}, 
								onComplete:function () {
									H_loading(); 
									}
								}
								);
}


//cochage des lignes de resultat de recherche avancée de documents

function coche_line_search_docs (type_action, second_id , length_list) {
	
		for (i = 0; i < length_list; i++) {
			if ($("check"+second_id+"_"+i)) {
				switch (type_action) {
					case "inv_coche" :
						if ($("check"+second_id+"_"+i).checked == false) {
							$("check"+second_id+"_"+i).checked = true;
						}
						else {
							$("check"+second_id+"_"+i).checked = false;
						}
						break;
					case 'coche' :
							$("check"+second_id+"_"+i).checked = true;
						break;
					case 'decoche'  :
							$("check"+second_id+"_"+i).checked = false;
						break;
					default :
					break;
				}
			}
		}
	
}
//action sur les lignes de resultat de recherche avancée de documents
function action_recherche(action_selection, second_id , length_list) {

		var liste_doc = "";
		for (i = 0; i < length_list; i++) {
			if ($("check"+second_id+"_"+i)) {
				if ($("check"+second_id+"_"+i).checked) {
					liste_doc += "&ref_doc"+i+"="+$("check"+second_id+"_"+i).value;
				}
			}
		}
		if (action_selection == "print") {
 			window.open("documents_recherche_result_action.php?fonction_generer="+action_selection+liste_doc,"_blank");
		} 
		
		
		if (action_selection == "annuler_docs") {
			
			$("titre_alert").innerHTML = "Confirmer l'action";
			$("texte_alert").innerHTML = "Confirmer l'action sur la sélection.<br/>";
			$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
		
			$("alert_pop_up_tab").style.display = "block";
			$("framealert").style.display = "block";
			$("alert_pop_up").style.display = "block";
			
			Event.observe("bouton0", "click", function() {
				$("coche_action_s").selectedIndex = 0;
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
		 }, false);
			
			Event.observe("bouton1", "click", function () {
				var AppelAjax = new Ajax.Request(
													"documents_recherche_result_action.php?fonction_generer="+action_selection+liste_doc, 
													{
													evalScripts: true, 
													onLoading: S_loading,
													onSuccess: function (requester){
																			requester.responseText.evalScripts();
																			}, 
													onComplete:function () {
																			H_loading(); 
																			}
													}
													);
				$("coche_action_s").selectedIndex = 0;
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
			}, false);
			
		} 
	
}

// fonction ouvrepop up gestion des ref_externes depuis un article
function ouvre_article_ref_externe() {
	$("aff_ref_externe_content").innerHTML = "";
	$('pop_up_article_ref_externe_content').style.display='block'; 
}
// fonction ferme pop up gestion des ref_externes depuis un article
function close_article_ref_externe() {
	$('pop_up_article_ref_externe_content').style.display='none'; 
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