// gestion assistant formule tarif

function reset_assistant_tarif(id_assist, id_iframe, id_form, step2, step3, step4) {
	$(id_assist).hide();
	$(id_iframe).hide();
	$(step2).hide();
	$(step3).hide();
	$(step4).hide();
	$(id_form).reset();
	}

function reset_assistant_comm_commission(id_assist, id_iframe, id_form, step2) {
	$(id_assist).hide();
	$(id_iframe).hide();
	$(step2).hide();
	$(id_form).reset();
	}

//gestion des grilles tarifaires
//alerte de suppression d'une grille tarifaire avec  de saisie avec texte d'erreur envoyé par la fonction (un seul bouton)
function alerte_sup_grille_tarif (alerte_titre, alerte_texte, alerte_bouton, formtosend, champs_select, retour_input) {
	
		$("titre_alert").innerHTML = alerte_titre;
		$("texte_alert").innerHTML = alerte_texte;
		$("bouton_alert").innerHTML = alerte_bouton;
	
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
		}
		$("bouton1").onclick= function () {
			if ($(champs_select).selectedIndex != 0) {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			$(retour_input).value = $(champs_select).value;
			submitform (formtosend);
			}
		}
	}
	
//fonction équivalente à celle présente dans tarif.js du profil collab	
//récupération des information d'un formule tarifaire pour mise à jour des informations de l'assistant des tarifs

function edition_formule_tarifaire (id_field_formule) {
	var formule = $(id_field_formule).value;
	var resultat = formule.substring(0, formule.indexOf("="));
	var arrondi_formule = "";
	var type_calcul = "AUCUN";
	var formule_de_base = formule.substring(formule.indexOf("=")+1 , formule.length);
	if (formule.indexOf("[")>0) {
	var arrondi_formule = formule.substring(formule.indexOf("["), formule.length );
	var formule_de_base = formule.substring(formule.indexOf("=")+1 , formule.indexOf("["));
	}
	
	if (formule_de_base.indexOf("PP") >=0 || formule_de_base.indexOf("PA") >=0) {
	
		if (formule_de_base.indexOf("PP") >=0) {
			$("assistant_rep_step1_PP").checked = true;
		}
		if (formule_de_base.indexOf("PA") >=0) {
			$("assistant_rep_step1_PA").checked = true;
		}
			$("assistant_rep_step2_0").checked = true;
			
		if (formule_de_base.indexOf("+") >=0 || formule_de_base.indexOf("-") >=0) {
			type_calcul = "ADD";
		}
		if (formule_de_base.indexOf("%") >=0) {
			type_calcul = "MARGE";
		}
		if (formule_de_base.indexOf("*") >=0) {
			type_calcul = "MULTI";
		}
		
		switch (type_calcul) {
			case "MARGE": 
			$("assistant_rep_step2_marge").checked = true;
			if (formule_de_base.indexOf("-") >=0) {
				$("assistant_val_step2_marge").value = formule_de_base.substring(2 , formule_de_base.indexOf("%"));
			} else {
				$("assistant_val_step2_marge").value = formule_de_base.substring(3 , formule_de_base.indexOf("%"));
			}
			break;

			case "MULTI": 
			$("assistant_rep_step2_multi").checked = true;
			$("assistant_val_step2_multi").value = formule_de_base.substring(3 , formule_de_base.length);
			break;

			case "ADD": 
			$("assistant_rep_step2_add").checked = true;
			if (formule_de_base.indexOf("-") >=0) {
				$("assistant_val_step2_addition").value = formule_de_base.substring(2 , formule_de_base.length);
			} else {
				$("assistant_val_step2_addition").value = formule_de_base.substring(3 , formule_de_base.length);
			}
			break;

			case "AUCUN": 
			break;

		}
		$('assistant_form_step2').show();
		$('assistant_form_step3').show();
		$('assistant_form_step4').show();
		
	} else {
		if ($("assistant_rep_step1_AR")) {
		$("assistant_rep_step1_AR").checked = true;
		$("assistant_val_step1_arb").value = formule_de_base;
		$('assistant_form_step4').show();
		} else {
		$("assistant_val_step1_arb").value = formule_de_base;
		}
	}
	if ($("assistant_rep_step3_arrondi")) {
	if (arrondi_formule == "") {
		$("assistant_rep_step3_arrondi").selectedIndex = 0;
	} else {
		if (arrondi_formule.indexOf("=") >= 0) {$("assistant_rep_step3_arrondi").selectedIndex = 1; pas_arrondi = arrondi_formule.substring(arrondi_formule.indexOf("=")+1, arrondi_formule.length-1);}
		if (arrondi_formule.indexOf("<") >= 0) {$("assistant_rep_step3_arrondi").selectedIndex = 2; pas_arrondi = arrondi_formule.substring(arrondi_formule.indexOf("<")+1, arrondi_formule.length-1);}
		if (arrondi_formule.indexOf(">") >= 0) {$("assistant_rep_step3_arrondi").selectedIndex = 3; pas_arrondi = arrondi_formule.substring(arrondi_formule.indexOf(">")+1, arrondi_formule.length-1);}
		$("assistant_rep_step3_pas").value = pas_arrondi;
	}
	}
	if (resultat == "PU_HT") {
	$("assistant_rep_step4_ht").checked = true;
	} else {
	$("assistant_rep_step4_ttc").checked = true;
	}
	
}




//edition commission
function edition_formule_commission (id_field_formule) {
	var formule = $(id_field_formule).value;
	var mg_in = formule.substring(formule.indexOf("+")+1 , formule.indexOf("("));
	var ca_in = formule.substring(0 , formule.indexOf("+"));
	
	var variablemg = mg_in.substring(0, mg_in.indexOf("%"));
	var variableca = ca_in.substring(0, ca_in.indexOf("%"));
	
	if (variableca == "") { variableca = 0;}
	if (variablemg == "") { variablemg = 0;}
	var acquisition = formule.substring(formule.indexOf("(")+1 , formule.indexOf(")"));
	
	$("assistant_comm_val_step1_Mg").value = variablemg;
	$("assistant_comm_val_step1_CA").value = variableca;
		
	if (acquisition.indexOf("CDC") >=0) {
		$("assistant_comm_rep_step2_CDC").checked = true;
	}
	if (acquisition.indexOf("FAC") >=0) {
		$("assistant_comm_rep_step2_FAC").checked = true;
	}
	if (acquisition.indexOf("RGM") >=0) {
		$("assistant_comm_rep_step2_RGM").checked = true;
	}
	$('assistant_comm_form_step2').show();
	
}
//edition commission
function edition_formule_commission_limited (id_field_formule, original_formule) {
	var formule = $(id_field_formule).value;
	var mg_in = formule.substring(formule.indexOf("+")+1 , formule.indexOf("("));
	var ca_in = formule.substring(0 , formule.indexOf("+"));
	
	var variablemg = mg_in.substring(0, mg_in.indexOf("%"));
	var variableca = ca_in.substring(0, ca_in.indexOf("%"));
	
	if (variableca == "") { variableca = 0;}
	if (variablemg == "") { variablemg = 0;}
	var acquisition = original_formule.substring(original_formule.indexOf("(")+1 , original_formule.indexOf(")"));
	
	$("assistant_comm_val_step1_Mg").value = variablemg;
	$("assistant_comm_val_step1_CA").value = variableca;
		
	if (acquisition.indexOf("CDC") >=0) {
		$("assistant_comm_rep_step2_CDC").checked = true;
		$("assistant_comm_rep_step2_CDC").disabled = "";
		$("assistant_comm_tex_step2_CDC").style.display = "";
		$("assistant_comm_rep_step2_RGM").disabled = "disabled";
		$("assistant_comm_tex_step2_RGM").style.display = "none";
		$("assistant_comm_rep_step2_FAC").disabled = "disabled";
		$("assistant_comm_tex_step2_FAC").style.display = "none";
	}
	if (acquisition.indexOf("FAC") >=0) {
		$("assistant_comm_rep_step2_FAC").checked = true;
		$("assistant_comm_rep_step2_FAC").disabled = "";
		$("assistant_comm_tex_step2_FAC").style.display = "";
		$("assistant_comm_tex_step2_CDC").style.display = "none";
		$("assistant_comm_rep_step2_CDC").disabled = "disabled";
		$("assistant_comm_tex_step2_RGM").style.display = "none";
		$("assistant_comm_rep_step2_RGM").disabled = "disabled";
		
	}
	if (acquisition.indexOf("RGM") >=0) {
		$("assistant_comm_rep_step2_RGM").checked = true;
		$("assistant_comm_rep_step2_RGM").disabled = "";
		$("assistant_comm_tex_step2_RGM").style.display = "";
		$("assistant_comm_tex_step2_CDC").style.display = "none";
		$("assistant_comm_rep_step2_CDC").disabled = "disabled";
		$("assistant_comm_tex_step2_FAC").style.display = "none";
		$("assistant_comm_rep_step2_FAC").disabled = "disabled";
	}
	$('assistant_comm_form_step2').show();
	
}