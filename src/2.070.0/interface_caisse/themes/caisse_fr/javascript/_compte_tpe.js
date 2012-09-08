//mettre le compte tpe à actif
function set_active_compte_tpe (id_compte_tpe) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_tpes_active_compte.php", 
									{
									parameters: {id_compte_tpe: id_compte_tpe},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//mettre le compte tpe à inactif
function set_desactive_compte_tpe (id_compte_tpe) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_tpes_desactive_compte.php", 
									{
									parameters: {id_compte_tpe: id_compte_tpe},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//fonction d'affichage des resultats des paiements TP
function	etat_tp_result () {
		var AppelAjax = new Ajax.Updater(
									"etat_tp_result", 
									"compta_tp_mouvement_result.php", 
									{
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { recherche: '1', id_compte_tp: $("choix_id_tp").value, tp_type: $("tp_type").value, page_to_show: $("page_to_show_s").value , date_debut: $("date_debut").value, date_fin: $("date_fin").value},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading
									}
									);
	}


//fonction d'affichage de l'histyorique des télécollectes
function	etat_telecollecte_result () {
		var AppelAjax = new Ajax.Updater(
									"etat_telecollecte_result", 
									"compta_tp_telecollecte_historique_result.php", 
									{
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { recherche: '1', id_compte_tp: $("choix_id_tp").value, tp_type: $("tp_type").value, page_to_show: $("page_to_show_s").value , date_debut: $("date_debut").value, date_fin: $("date_fin").value},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading
									}
									);
	}

//*******************************
//calcul des télécollecte TP
//*******************************
function calcul_telecollecte_tp () {
	var montant_telecollecte = 0;
	
	$("aff_date_telecollecte").innerHTML = $("date_telecollecte").value;
	
	
	
}

//gestion du menu controle de caisse
function step_menu_telecollecte (id_contenu, id_menu, array_id) {
array_id.each(function(j) {
								if(j!=undefined) {
									if ($(j[0]) && $(j[1]+"_2").className!="chemin_numero_grisse") {
										$(j[0]).style.display="none";
										$(j[1]+"_2").className="chemin_numero_gris";
										$(j[1]+"_3").className="chemin_texte_gris";
									}
								}
							}
						);

$(id_contenu).style.display="block";
$(id_menu+"_2").className="chemin_numero_choisi";
$(id_menu+"_3").className="chemin_texte_choisi";
set_tomax_height(id_contenu , -32);
calcul_telecollecte_tp ();
}

//calcul des totaux CB
function calcul_telecollecte_tp_cb () {
	var montant_tt_cb = 0;
	var count_ope = 0;
	var com_ope = parseFloat($("com_ope").value);
	var com_var = parseFloat($("com_var").value);
	var montant_commission = 0;
	indentation_telecollecte_cb = parseInt($("indentation_telecollecte_cb").value);
	indentation_exist_cb = parseInt($("indentation_exist_cb").value);
	for (j=0; j<=indentation_exist_cb ; j++) {
		if ($("CHK_EXIST_CB_"+j).checked) {
			montant_commission += parseFloat(com_ope + (parseFloat($("CHK_EXIST_CB_"+j).value)*(1+parseFloat (com_var)/100))-parseFloat($("CHK_EXIST_CB_"+j).value));
			montant_tt_cb += parseFloat($("CHK_EXIST_CB_"+j).value);
			count_ope++;
		}
	}
	for (i=0; i<=indentation_telecollecte_cb ; i++) {
		if (!isNaN(parseFloat($("CB_"+i).value)) && parseFloat($("CB_"+i).value) != 0) {
			montant_commission += parseFloat(com_ope + (parseFloat($("CB_"+i).value)*(1+parseFloat (com_var)/100))-parseFloat($("CB_"+i).value));
			montant_tt_cb += parseFloat($("CB_"+i).value);
			count_ope++;
		}
	}
	//calcul des commission
	
	
	$("TT_CB").innerHTML = $("aff_montant_total").innerHTML = $("toto_cb_saisie2").innerHTML = $("montant_total").value = montant_tt_cb.toFixed(tarifs_nb_decimales);
	$("saisie_op_cb2").innerHTML = $("aff_nombre_ope").innerHTML = $("nombre_ope").value = count_ope;
	$("aff_montant_commission").innerHTML = $("montant_commission").value = parseFloat (montant_commission).toFixed(tarifs_nb_decimales);
	$("aff_montant_transfere").innerHTML = $("montant_transfere").value = parseFloat (montant_tt_cb - parseFloat (montant_commission)).toFixed(tarifs_nb_decimales);
	
}

//insertion d'une nouvelle ligne CB
function insert_new_line_tp_cb () {
	indentation_telecollecte_cb = parseInt($("indentation_telecollecte_cb").value);
	new_indentation_telecollecte_cb = indentation_telecollecte_cb+1;
      new Insertion.After($("ligne_cb_"+indentation_telecollecte_cb), 
       '<div class="ligne_cb" id="ligne_cb_'+new_indentation_telecollecte_cb+'"><div class="inner_ligne_cb" style="width:55px">&nbsp;</div><input name="CB_'+new_indentation_telecollecte_cb+'" type="text" class="classinput_nsize" id="CB_'+new_indentation_telecollecte_cb+'" size="15" style="text-align:right"/>  &nbsp;'+monnaie_html+''+
			 '<script type="text/javascript">'+
			 'Event.observe($("CB_'+new_indentation_telecollecte_cb+'"), "blur", function(evt){'+
				'Event.stop(evt);	nummask(evt, 0, "X.X"); calcul_telecollecte_tp_cb ();calcul_telecollecte_tp ();});'+
	'</script><div style="height:5px"></div></div>');
			$("indentation_telecollecte_cb").value = new_indentation_telecollecte_cb;
			calcul_telecollecte_tp_cb ();
			$("CB_"+new_indentation_telecollecte_cb).focus();
}


//cochage des lignes de resultat de recherche avancée de documents

function coche_line_gest_tp (type_action, second_id , length_list) {
	
		for (i = 0; i <= length_list; i++) {
			if ($("CHK_EXIST_"+second_id+"_"+i)) {
				switch (type_action) {
					case "inv_coche" :
						if ($("CHK_EXIST_"+second_id+"_"+i).checked == false) {
							$("CHK_EXIST_"+second_id+"_"+i).checked = true;
						}
						else {
							$("CHK_EXIST_"+second_id+"_"+i).checked = false;
						}
						break;
					case 'coche' :
							$("CHK_EXIST_"+second_id+"_"+i).checked = true;
						break;
					case 'decoche'  :
							$("CHK_EXIST_"+second_id+"_"+i).checked = false;
						break;
					default :
					break;
				}
			}
		}
	
}


