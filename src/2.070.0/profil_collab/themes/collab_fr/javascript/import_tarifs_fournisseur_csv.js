
function tarifs_fournisseur_import() {
	var AppelAjax = new Ajax.Updater(
								"resultat_imports", 
								"import_tarifs_fournisseur_csv_liste_result.php", {
								method: 'post',
								asynchronous: true,
								contentType:  'application/x-www-form-urlencoded',
								encoding:     'UTF-8',
								parameters: { recherche: '1',
									page_to_show: $F('page_to_show_s'), 
									orderby: $F('orderby_s'), 
									orderorder: $F('orderorder_s')},
								evalScripts:true, 
								onLoading:S_loading, onException: function (){S_failure();}, 
								onComplete:H_loading}
	);
}

//cochage des lignes de resultat de tarifs_fournisseur_import
function coche_line_tarifs_fournisseur_import(type_action, nom_champ , length_list) {
	for (i = 0; i < length_list; i++) {
		if ($(nom_champ + i)) {
			switch (type_action) {
				case "inv_coche" :
					if ($(nom_champ + i).checked == false) {
						$(nom_champ + i).checked = true;
					}
					else {
						$(nom_champ + i).checked = false;
					}
					break;
				case 'coche' :
						$(nom_champ + i).checked = true;
					break;
				case 'decoche'  :
						$(nom_champ + i).checked = false;
					break;
				default :
				break;
			}
		}
	}
}

//action sur les lignes de resultat catalogue_import
function action_tarifs_fournisseur_import(action_selection, nom_champ , length_list) {
	var liste_doc = "";
	for (i = 0; i < length_list; i++) {
		if ($(nom_champ + i)) {
			if ($(nom_champ + i).checked) {
				liste_doc += "&id_rec" + i + "=" + $(nom_champ + i).value;
			}
		}
	}
	if (action_selection == "import") {
		$("titre_alert").innerHTML = "Confirmer l'action";
		$("texte_alert").innerHTML = "Confirmer l'import de la sélection.<br/>";
		$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" />';
		$("bouton_alert").innerHTML += '<input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
	}
	
	if (action_selection == "supprimer") {
		$("titre_alert").innerHTML = "Confirmer l'action";
		$("texte_alert").innerHTML = "Confirmer la suppression de la sélection.<br/>";
		$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" />';
		$("bouton_alert").innerHTML += '<input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
	}

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
				"import_tarifs_fournisseur_csv_action.php?fonction_generer="+action_selection+liste_doc, 
				{
					evalScripts: true, 
					parameters: { recherche: '1', page_to_show: $F('page_to_show_s'), 
									orderby: $F('orderby_s'), orderorder: $F('orderorder_s')},
					onLoading: S_loading,
					onSuccess: function (requester){ requester.responseText.evalScripts(); }, 
					onComplete:function () { H_loading(); }
				}
		);
		$("coche_action_s").selectedIndex = 0;
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		tarifs_fournisseur_import();
	}, false);
}
	
function supprime_import_ligne_tarifs_fournisseur (ligne) {
	$("titre_alert").innerHTML = "Confirmer la suppression";
	$("texte_alert").innerHTML = "Confirmer la suppression de la ligne.<br/>";
	$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" />';
	$("bouton_alert").innerHTML += '<input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
	
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
					"import_tarifs_fournisseur_csv_action.php?fonction_generer=supprimer&id_rec"+ligne+"="+ligne, 
					{
						evalScripts: true,
						onLoading: S_loading,
						onSuccess: function (requester){ 
							requester.responseText.evalScripts();
						},
						onComplete:function () { H_loading(); }
					}
		);
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
	}, false);
}

function choix_ref_article_existant(id_ligne, ref_article, lib_article, valo_indice){
	close_mini_moteur_cata();
	$('ref_article_existant_' + id_ligne).innerHTML = ref_article;
	id_ligne = $("check_s_" + id_ligne).value;
	var AppelAjax = new Ajax.Request(
			"import_tarifs_fournisseur_csv_maj_ref_article_existant.php", {
				method: 'post',
				asynchronous: true,
				contentType:  'application/x-www-form-urlencoded',
				encoding:     'UTF-8',
				parameters: { ref_article_existant: ref_article, id_ligne: id_ligne},
				evalScripts:true, 
				onLoading:S_loading, onException: function (){S_failure();}, 
				onSuccess: function (requester){ 
					requester.responseText.evalScripts();
				},
				onComplete:H_loading
			}
	);
}