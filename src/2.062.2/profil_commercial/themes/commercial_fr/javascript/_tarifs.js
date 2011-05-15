// calcul tarif et gestion assistant tarifs

function new_ligne_tarif(){
	
	
	var nb_ligne_prix	=	$("nb_ligne_prix").value;
	var nb_liste_tarif	=	$("nb_liste_tarif").value;
	
	var AppelAjax = new Ajax.Updater(
																	'tableau_des_tarifs', 
																	'catalogue_articles_tarifs_newqte.php?ref_art_categ='+$("ref_art_categ").value+'&nb_ligne_prix='+nb_ligne_prix	, 
																	{
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete:H_loading,
																	insertion: Insertion.Bottom
																	}
																	);
	}
function edition_new_ligne_tarif(ref_article){
	
	
	var nb_ligne_prix	=	$("nb_ligne_prix").value;
	var nb_liste_tarif	=	$("nb_liste_tarif").value;
	
	var AppelAjax = new Ajax.Updater(
																	"tableau_des_tarifs", 
																	"catalogue_articles_edition_tarifs_newqte.php?ref_article="+ref_article+"&ref_art_categ="+$("ref_art_categ").value+"&nb_ligne_prix="+nb_ligne_prix	, 
																	{
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete:H_loading,
																	insertion: Insertion.Bottom
																	}
																	);
	}
	
	
function grille_calcul_tarif (num_ligne_qte) {
	
	var nb_ligne_prix	=	$("nb_ligne_prix").value;
	var nb_liste_tarif	=	$("nb_liste_tarif").value;
	
	
	var prix_public_ht	=	 $("prix_public_ht").value.replace("," , ".");
	var taxation_pp	=	$("taxation_pp_ht").checked;
	var pp=0;	

	if ($("prix_achat_ht").value != "" &&  parseFloat($("prix_achat_ht").value) != 0 && $("prix_achat_ht").up('span').style.display != "none") {
		var prix_achat_ht	=	$("prix_achat_ht").value.replace("," , ".");
		var taxation_pa	=	$("taxation_pa_ht").checked;
		var id_pa = "prix_achat_ht";
		var pa=0;
	} else {
		var prix_achat_ht	=	$("paa_ht").value.replace("," , ".");
		var taxation_pa	=	$("taxation_paa_ht").checked;
		var id_pa = "paa_ht";
		var pa=0;
		
	}
	
	var tarif_tva	=	$("tarif_tva").value;
	
	if (isNaN(prix_public_ht)) {
		$("prix_public_ht").className="alerteform_hsize";
	}
	else {
		$("prix_public_ht").className="classinput_hsize";
	if (taxation_pp) {
		pp = prix_public_ht;
	} else {
		pp =	prix_public_ht / (1+tarif_tva/100);
	}
	}
		
	if (isNaN(prix_achat_ht)) {
		$(id_pa).className="alerteform_hsize";
	}
	else {
		$(id_pa).className="classinput_hsize";
	if (taxation_pa) {
		pa = prix_achat_ht;
	} else {
		pa =	prix_achat_ht / (1+tarif_tva/100);
	}
	}
	check_qte_dbl_nan ();
	
	if (!isNaN(num_ligne_qte)) {
		
		requete=",,";
			for (j=0; j<nb_liste_tarif; j++) {
				Try.these( function () {
					requete+="|"+((($("formule_tarif_"+j+"_"+num_ligne_qte).value)+","+$("qte_tarif_"+num_ligne_qte).value+","+"aff_tarif_"+j+"_"+num_ligne_qte));
				});
			}
	} else {
		requete=",,";
			for (i=0; i<nb_ligne_prix; i++) {
				for (j=0; j<nb_liste_tarif; j++) {
					
					Try.these( function () {
						requete+="|"+((($("formule_tarif_"+j+"_"+i).value)+","+$("qte_tarif_"+i).value+","+"aff_tarif_"+j+"_"+i));
					});
				}
			}
	}
	
						var AppelAjax = new Ajax.Request(
																			"catalogue_articles_tarifs_calcul.php", 
																			{
																			parameters: {req:escape(requete), prix_a: pa, prix_p: pp, tva:tarif_tva },
																			evalScripts:true, 
																			onLoading:S_loading,
																			onSuccess: function (requester){
																			requester.responseText.evalScripts();
																			//	alert (requester.responseText.truncate(1500));
																			}
																			}
																			);
}

	
function grille_calcul_tarif_edition (num_ligne_qte) {
	
	var nb_ligne_prix	=	$("nb_ligne_prix").value;
	var nb_liste_tarif	=	$("nb_liste_tarif").value;
	
	
	var prix_public_ht	=	 $("prix_public_ht").value.replace("," , ".");
	var taxation_pp	=	$("taxation_pp_ht").checked;
	var pp=0;	

	if ($("prix_achat_ht").value != "" && parseFloat($("prix_achat_ht").value) != 0 && $("prix_achat_ht").up('span').style.display != "none") {
		var prix_achat_ht	=	$("prix_achat_ht").value.replace("," , ".");
		var taxation_pa	=	$("taxation_pa_ht").checked;
		var id_pa = "prix_achat_ht";
		var pa=0;
	} else {
		var prix_achat_ht	=	$("paa_ht").value.replace("," , ".");
		var taxation_pa	=	$("taxation_paa_ht").checked;
		var id_pa = "paa_ht";
		var pa=0;
		
	}
	
	var tarif_tva	=	$("tarif_tva").value;
	
	if (isNaN(prix_public_ht)) {
		$("prix_public_ht").className="alerteform_hsize";
	}
	else {
		$("prix_public_ht").className="classinput_hsize";
	if (taxation_pp) {
		pp = prix_public_ht;
	} else {
		pp =	prix_public_ht / (1+tarif_tva/100);
	}
	}
		
	if (isNaN(prix_achat_ht)) {
		$(id_pa).className="alerteform_hsize";
	}
	else {
		$(id_pa).className="classinput_hsize";
	if (taxation_pa) {
		pa = prix_achat_ht;
	} else {
		pa =	prix_achat_ht / (1+tarif_tva/100);
	}
	}
	check_qte_dbl_nan ();
	
	if (!isNaN(num_ligne_qte)) {
		
		requete=",,";
			for (j=0; j<nb_liste_tarif; j++) {
				Try.these( function () {
					requete+="|"+((($("formule_tarif_"+j+"_"+num_ligne_qte).value)+","+$("qte_tarif_"+num_ligne_qte).value+","+"aff_tarif_"+j+"_"+num_ligne_qte));
				});
			}
	} else {
		requete=",,";
			for (i=0; i<nb_ligne_prix; i++) {
				for (j=0; j<nb_liste_tarif; j++) {
					
					Try.these( function () {
						requete+="|"+((($("formule_tarif_"+j+"_"+i).value)+","+$("qte_tarif_"+i).value+","+"aff_tarif_"+j+"_"+i));
					});
				}
			}
	}
	
}


function reset_assistant_tarif(id_assist, id_iframe, id_form, step2, step3, step4) {
	$(id_assist).hide();
	$(id_iframe).hide();
	$(step2).hide();
	$(step3).hide();
	$(step4).hide();
	$(id_form).reset();
	}

function recup_previous_qte (id_newqte) {
	var new_qte_value = parseInt($(id_newqte).previous().down('input').value)+1;
	if (isNaN(new_qte_value)) {
 	$(id_newqte).down('input').value	=	"1";
	} else {
 	$(id_newqte).down('input').value	=	new_qte_value;
	}
}

function check_qte_dbl_nan () {
	var nb_ligne_prix	=	$("nb_ligne_prix").value;
	var array_qte	=	new Array();
	var array_qte_uniq	=	new Array();
	for (i=1; i<nb_ligne_prix; i++) {
	
	Try.these( function () {
		$("qte_tarif_"+i).className="assistant_input";
			if(isNaN($("qte_tarif_"+i).value)||$("qte_tarif_"+i).value=="") {
			$("qte_tarif_"+i).className="alerte_assistant_input";
			}
					for (k=0; k<array_qte.length; k++) {
						if (array_qte[k]==parseInt($("qte_tarif_"+i).value)) {
						$("qte_tarif_"+i).className="alerte_assistant_input";
							}
							
					}
					array_qte.push(parseInt($("qte_tarif_"+i).value));
											 }
		);
	
	}
	
}

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

//fonction qui enlève de l'affichage les prix si aucune formule n'est définie
function shoot_price_if_noformule (id_tofill, valeur_to_fill) {
	//alert ($("formule_cree_"+id_tofill.replace("aff_tarif_","")).value);
	if ($("formule_cree_"+id_tofill.replace("aff_tarif_","")) && $("formule_cree_"+id_tofill.replace("aff_tarif_","")).value != "0") {
		$(id_tofill).innerHTML = valeur_to_fill;
	}	else {
		if ($("formule_cree_"+id_tofill.replace("aff_tarif_","")) || $("formule_exist_"+id_tofill.replace("aff_tarif_",""))) {
		 $(id_tofill).innerHTML = "&nbsp;";
	 	} else {
		$(id_tofill).innerHTML = valeur_to_fill;	
		}
	}
}