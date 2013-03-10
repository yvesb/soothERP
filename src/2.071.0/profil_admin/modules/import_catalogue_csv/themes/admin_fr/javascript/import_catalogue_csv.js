
function catalogue_import() {
		var AppelAjax = new Ajax.Updater(
									"resultat_imports", 
									"modules/import_catalogue_csv/import_catalogue_csv_liste_result.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { recherche: '1', ref_art_categ: $F('ref_art_categ_s'), page_to_show: $F('page_to_show_s'), orderby: $F('orderby_s'), orderorder: $F('orderorder_s')},
									evalScripts:true, 
									onLoading:S_loading, onException: function (){S_failure();}, 
									onComplete:H_loading}
									);
	}
	
	
//cochage des lignes de resultat de catalogue_import

function coche_line_catalogue_import (type_action, second_id , length_list) {
	
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
//action sur les lignes de resultat catalogue_import
function action_catalogue_import(action_selection, second_id , length_list) {

		var liste_doc = "";
		for (i = 0; i < length_list; i++) {
			if ($("check"+second_id+"_"+i)) {
				if ($("check"+second_id+"_"+i).checked) {
					liste_doc += "&id_rec"+i+"="+$("check"+second_id+"_"+i).value;
				}
			}
		}
		if (action_selection == "import") {
				var AppelAjax = new Ajax.Request(
													"modules/import_catalogue_csv/import_catalogue_csv_action.php?fonction_generer="+action_selection+liste_doc, 
													{
													evalScripts: true, 
													onLoading: S_loading,
													parameters: { recherche: '1', ref_art_categ: $F('ref_art_categ_s'), page_to_show: $F('page_to_show_s'), orderby: $F('orderby_s'), orderorder: $F('orderorder_s')},
													onSuccess: function (requester){
																			requester.responseText.evalScripts();
																			}, 
													onComplete:function () {
																			H_loading(); 
																			}
													}
													);
		} 
		
		
		if (action_selection == "supprimer") {
			
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
													"modules/import_catalogue_csv/import_catalogue_csv_action.php?fonction_generer="+action_selection+liste_doc, 
													{
													evalScripts: true, 
													parameters: { recherche: '1', ref_art_categ: $F('ref_art_categ_s'), page_to_show: $F('page_to_show_s'), orderby: $F('orderby_s'), orderorder: $F('orderorder_s')},
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


function catalogue_import_maj_limite(limite) {
		var AppelAjax = new Ajax.Request(
									"modules/import_catalogue_csv/import_catalogue_csv_maj_limite.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { limite: limite},
									evalScripts:true, 
									onLoading:S_loading, onException: function (){S_failure();}, 
									onComplete:H_loading}
									);
	}
	
function supprime_import_ligne_catalogue (ligne) {

	$("titre_alert").innerHTML = "Confirmer la suppression";
	$("texte_alert").innerHTML = "Confirmer la suppression de la ligne.<br/>";
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
											"modules/import_catalogue_csv/import_catalogue_csv_action.php?fonction_generer=supprimer&id_rec"+ligne+"="+ligne, 
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
		
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
	}, false);
			
}