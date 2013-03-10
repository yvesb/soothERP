//***************************************************************
//FONCTIONS LIEES à la compta
//***************************************************************

//fonction de chargement des factures non reglées (compta)
function load_facture_nonreglees (id_client_categ, id_niveau_relance, id_mode_regmt, action) {
    var AppelAjax = new Ajax.Updater(
        "fac_liste_content",
        "compta_factures_client_nonreglees_liste.php",
        {
            parameters: {
                id_client_categ: id_client_categ,
                id_niveau_relance: id_niveau_relance,
                id_mode_regmt: id_mode_regmt,
                action: action,
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete: function() {
                H_loading ();
            }
        }
        );
}

//Affichage factures clients nonreglees avec pagination
function load_facture_nonreglees_page (id_client_categ, id_niveau_relance, id_mode_regmt) {
    var AppelAjax = new Ajax.Updater(
        "fac_liste_content",
        "compta_factures_client_nonreglees_liste.php",
        {
            parameters: {
                id_client_categ: id_client_categ,
                id_niveau_relance: id_niveau_relance,
                id_mode_regmt: id_mode_regmt,
                page_to_show: $F('page_to_show'),
                orderby: $F('orderby'),
                orderorder: $F('orderorder')
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete: function() {
                H_loading ();
            }
        }
        );
}

//fonction de chargement des factures non reglées (compta)
function load_facture_nonreglees_fournisseur (id_fournisseur_categ) {
    var AppelAjax = new Ajax.Updater(
        "fac_liste_content",
        "compta_factures_fournisseur_nonreglees_liste.php",
        {
            parameters: {
                id_fournisseur_categ: id_fournisseur_categ
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete: function() {
                H_loading ();
            }
        }
        );
}

//fonction de chargement des livraison non facturée (compta)
function load_livraison_nonfacturees (id_stock, orderorder, orderby) {
    var AppelAjax = new Ajax.Updater(
        "lcnf",
        "compta_livraisons_client_nonfacturees_liste.php",
        {
            parameters: {
                id_stock: id_stock,
                orderorder: orderorder,
                orderby: orderby
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete: function() {
                H_loading ();
            }
        }
        );
}
//fonction de chargement des livraisons fournisseurs non facturée (compta)
function load_livraison_fournisseur_nonfacturees (id_stock, orderorder, orderby) {
    var AppelAjax = new Ajax.Updater(
        "lcnf",
        "compta_livraisons_fournisseur_nonfacturees_liste.php",
        {
            parameters: {
                id_stock: id_stock,
                orderorder: orderorder,
                orderby: orderby
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete: function() {
                H_loading ();
            }
        }
        );
}


function coche_line (type_action, second_id , ul_list) {
	
    if (!$(ul_list).empty()) {
        var tag = "li";
        var items = $(ul_list).childNodes;
        var t_liste = new Array();
		
        for(var i=0; i<items.length; i++){
            if(items[i].tagName && items[i].tagName==tag.toUpperCase()) {
                t_liste.push(encodeURIComponent(items[i].id.split("_")[1]));
            }
        }
        for (i = 0; i < t_liste.length; i++) {
		
            if ($("check"+second_id+"_"+t_liste[i])) {
                switch (type_action) {
                    case "inv_coche" :
                        if ($("check"+second_id+"_"+t_liste[i]).checked == false) {
                            $("check"+second_id+"_"+t_liste[i]).checked = true;
                        }
                        else {
                            $("check"+second_id+"_"+t_liste[i]).checked = false;
                        }
                        break;
                    case 'coche' :
                        $("check"+second_id+"_"+t_liste[i]).checked = true;
                        break;
                    case 'decoche'  :
                        $("check"+second_id+"_"+t_liste[i]).checked = false;
                        break;
                    default :
                        break;
                }
            }
        }
    }
}



//maj id_niveau_relance
function maj_niveau_relance (ref_doc, id_niveau_relance) {
    var AppelAjax = new Ajax.Request(
        "compta_document_maj_niveau_relance.php",
        {
            parameters: {
                ref_doc: ref_doc,
                id_niveau_relance : id_niveau_relance
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete: function() {
                H_loading();
            }
        }
        );
}
//action sur lignes selectionnées dans la liste des BLC ou BLF non facturés
function action_BLC(action_selection, second_id , ul_list) {
    if (!$(ul_list).empty()) {
        var tag = "li";
        var items = $(ul_list).childNodes;
        var t_liste = new Array();
        var liste_doc = "";
        for(var i=0; i<items.length; i++){
            if(items[i].tagName && items[i].tagName==tag.toUpperCase()) {
                t_liste.push(encodeURIComponent(items[i].id.split("_")[1]));
            }
        }
        for (i = 0; i < t_liste.length; i++) {
		
            if ($("check"+second_id+"_"+t_liste[i])) {
                switch (action_selection) {
                    case "generer_fa_client" :
                        if ($("check"+second_id+"_"+t_liste[i]).checked) {
                            liste_doc += "&ref_doc"+t_liste[i]+"="+$("refdoc_"+second_id+"_"+t_liste[i]).value;
                            remove_tag ("licommande_"+t_liste[i]);
                        }
                        break;
                    case "generer_fa_fournisseur" :
                        if ($("check"+second_id+"_"+t_liste[i]).checked) {
                            liste_doc += "&ref_doc"+t_liste[i]+"="+$("refdoc_"+second_id+"_"+t_liste[i]).value;
                            remove_tag ("licommande_"+t_liste[i]);
                        }
                        break;
                    default :
                        break;
					
                }
				
            }
        }
        switch (action_selection) {
            case "generer_fa_client" :
                var AppelAjax = new Ajax.Request(
                    "compta_action_generer.php",
                    {
                        parameters: "fonction_generer=generer_fa_client"+liste_doc,
                        evalScripts: true,
                    }
                    );
                break;
            case "generer_fa_fournisseur" :
                var AppelAjax = new Ajax.Request(
                    "compta_action_generer.php",
                    {
                        parameters: "fonction_generer=generer_fa_fournisseur"+liste_doc,
                        evalScripts: true,
                    }
                    );
                break;
            default :
                break;
					
        }
        H_loading();
    }
}

//action sur lignes selectionnées dans la liste des FAC  non réglées
function action_FAC_np(action_selection, second_id , ul_list) {
    if (!$(ul_list).empty()) {
        var tag = "li";
        var items = $(ul_list).childNodes;
        var t_liste = new Array();
        var liste_doc = "";
        for(var i=0; i<items.length; i++){
            if(items[i].tagName && items[i].tagName==tag.toUpperCase()) {
                t_liste.push(encodeURIComponent(items[i].id.split("_")[1]));
            }
        }
        for (i = 0; i < t_liste.length; i++) {
            if ($("check"+second_id+"_"+t_liste[i]) && (Math.abs(action_selection) != "NaN" )) {
                if ($("check"+second_id+"_"+t_liste[i]).checked) {
                    liste_doc += "&ref_doc"+t_liste[i]+"="+$("refdoc"+second_id+"_"+t_liste[i]).value;
                    if ($("choix_niveau_relance_"+action_selection+"_"+t_liste[i])) {
                        $("niveau_relance_"+t_liste[i]).innerHTML = $("choix_niveau_relance_"+action_selection+"_"+t_liste[i]).innerHTML;
                    }
                    $("check"+second_id+"_"+t_liste[i]).checked = false;
                }
            }
        }
        if (action_selection == "print") {
            window.open("compta_action_on_fac.php?fonction_generer="+action_selection+liste_doc,"_blank");
        } else {
            var AppelAjax = new Ajax.Request(
                "compta_action_on_fac.php",
                {
                    parameters: "fonction_generer="+action_selection+liste_doc,
                    evalScripts: true,
                }
                );
            H_loading();
        }
    }
}
//action sur lignes selectionnées dans la liste des FAF non réglées
function action_FAF_np(action_selection, second_id , ul_list) {
    if (!$(ul_list).empty()) {
        var tag = "li";
        var items = $(ul_list).childNodes;
        var t_liste = new Array();
        var liste_doc = "";
        for(var i=0; i<items.length; i++){
            if(items[i].tagName && items[i].tagName==tag.toUpperCase()) {
                t_liste.push(encodeURIComponent(items[i].id.split("_")[1]));
            }
        }
        for (i = 0; i < t_liste.length; i++) {
            if ($("check"+second_id+"_"+t_liste[i]) && (Math.abs(action_selection) != "NaN" )) {
                if ($("check"+second_id+"_"+t_liste[i]).checked) {
                    liste_doc += "&ref_doc"+t_liste[i]+"="+$("refdoc"+second_id+"_"+t_liste[i]).value;
					
                    $("check"+second_id+"_"+t_liste[i]).checked = false;
                }
            }
        }
        if (action_selection == "print") {
            window.open("compta_action_on_fac.php?fonction_generer="+action_selection+liste_doc,"_blank");
        }
    }
}

function unlink_doc_to_reglement (ref_doc, ref_reglement, id_tag, maj_ref_doc, maj_ref_contact) {
    var AppelAjax = new Ajax.Request(
        "compta_reglements_delier.php",
        {
            parameters: {
                ref_doc: ref_doc,
                ref_reglement : ref_reglement,
                id_tag: id_tag,
                maj_ref_doc: maj_ref_doc,
                maj_ref_contact: maj_ref_contact
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete: function(requester) {
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function prestart_coche_liste_fac_np(identifiant) {
    Event.observe("all_coche_"+identifiant, "click", function(evt){
        Event.stop(evt);
        coche_line ("coche", "", "factures_"+identifiant);
    });
    Event.observe("all_decoche_"+identifiant, "click", function(evt){
        Event.stop(evt);
        coche_line ("decoche", "", "factures_"+identifiant);
    });
    Event.observe("all_inv_coche_"+identifiant, "click", function(evt){
        Event.stop(evt);
        coche_line ("inv_coche", "", "factures_"+identifiant);
    });
}

function prestart_choix_niveau_relance (identifiant, indentation, ref_doc, lib_niveau) {
    Event.observe("choix_niveau_relance_"+identifiant+"_"+indentation, "click", function(evt){
        Event.stop(evt);
        maj_niveau_relance (ref_doc, identifiant);
        $("niveau_relance_"+indentation).innerHTML = lib_niveau;
        $("choix_niveau_relance_"+indentation).toggle();
    }, false);
}

function prestart_ligne_fac_np (dir_profil, ref_doc, ref_contact, indentation) {
    Event.observe(ref_doc, 'click',  function(evt){
        Event.stop(evt);
        window.open( dir_profil+escape("documents_edition.php?ref_doc="+ref_doc),'_blank');
    }, false);

    Event.observe(ref_doc+'ctc', 'click',  function(evt){
        Event.stop(evt);
        if (ref_contact != "") {
            window.open( dir_profil+escape("annuaire_view_fiche.php?ref_contact="+ref_contact),'_blank');
        }
    }, false);

    Event.observe("choix_niveau_relance_0_"+indentation, "click", function(evt){
        Event.stop(evt);
        maj_niveau_relance (ref_doc, "");
        $("niveau_relance_"+indentation).innerHTML = "Non transmise";
        $("choix_niveau_relance_"+indentation).toggle();
    }, false);

    Event.observe("niveau_relance_"+indentation, "click", function(evt){
        $("choix_niveau_relance_"+indentation).toggle();
    }, false);
}

function prestart_ligne_fac_fourn_np (dir_profil, ref_doc, ref_contact, indentation) {
    Event.observe(ref_doc, 'click',  function(evt){
        Event.stop(evt);
        window.open( dir_profil+escape("documents_edition.php?ref_doc="+ref_doc),'_blank');
    }, false);

    Event.observe(ref_doc+'ctc', 'click',  function(evt){
        Event.stop(evt);
        if (ref_contact != "") {
            window.open( dir_profil+escape("annuaire_view_fiche.php?ref_contact="+ref_contact),'_blank');
        }
    }, false);

}




//
//affichage des lettrages communs
//
function show_lettrage(classe, contener) {
    var lettrage_selected = document.getElementsByClassName(classe, contener);
    for (var i=0; i < lettrage_selected.length;i++) {
        $(lettrage_selected[i]).style.backgroundColor = "#94B9D8";
    }
}
function hide_lettrage(classe, contener) {
    var lettrage_selected = document.getElementsByClassName(classe, contener);
    for (var i=0; i < lettrage_selected.length;i++) {
        $(lettrage_selected[i]).style.backgroundColor = "";
    }
}

//fonction d'affichage des resultats de l'etat des caisses
function	etat_caisse_result () {
    reglements_modes = $("id_reglement_mode").getValue().join(", ");
    $("print_mouvement_caisse").style.display = "block";
    var AppelAjax = new Ajax.Updater(
        "etat_caisse_result",
        "compta_mouvement_caisse_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                id_compte_caisse: $("choix_id_caisse").value,
                id_reglement_mode: reglements_modes,
                page_to_show: $("page_to_show_s").value ,
                date_debut: $("date_debut").value,
                date_fin: $("date_fin").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

//*******************************
//calcul des controles de caisses
//*******************************
function calcul_controle_caisse () {
    var toto_esp_theo = 0;
    var toto_chq_theo = 0;
    var toto_cb_theo = 0;
    var toto_theo = 0;
    var toto_saisie = 0;
    var toto_diff = 0;
    var m_toto_theo = 0;
    //correction du total théorique
    indentation_controle_ope_spe = parseInt($("indentation_controle_ope_spe").value);
	
    for (i=1; i<=indentation_controle_ope_spe ; i++) {
        if (!isNaN(parseFloat($("OPE_"+i).value)) && $("OPE_"+i).value != "0") {
            if ($("ADD_OPE_"+i).checked) {
                m_toto_theo += parseFloat($("OPE_"+i).value);
            } else {
                m_toto_theo -= parseFloat($("OPE_"+i).value);
            }
        }
    }
    $("toto_esp_theorique").innerHTML = $("toto_esp_theorique2").innerHTML = (parseFloat($("real_esp_theorique").value) + m_toto_theo).toFixed(tarifs_nb_decimales);
	
	
    if ($("pass_esp").checked) {
        var toto_esp_saisie = parseFloat($("toto_esp_theorique").innerHTML);
    } else {
        var toto_esp_saisie = parseFloat($("TT_ESP").innerHTML);
    }
    if ($("pass_chq").checked) {
        var toto_chq_saisie = parseFloat($("toto_chq_theorique").innerHTML);
    } else {
        var toto_chq_saisie = parseFloat($("TT_CHQ").innerHTML);
    }
	
    if ($("pass_cb").checked) {
        var toto_cb_saisie = parseFloat($("toto_cb_theorique").innerHTML);
    } else {
        var toto_cb_saisie = parseFloat($("TT_CB").innerHTML);
    }
    var alerte_totaux = false;
	
	
    if ($("toto_esp_theorique").innerHTML != "") {
        toto_theo += toto_esp_theo = parseFloat($("toto_esp_theorique").innerHTML);
    }
    if ($("toto_chq_theorique").innerHTML != "") {
        toto_theo += toto_chq_theo = parseFloat($("toto_chq_theorique").innerHTML);
    }
    if ($("toto_cb_theorique").innerHTML != "") {
        toto_theo += toto_cb_theo = parseFloat($("toto_cb_theorique").innerHTML);
    }
	
    if ($("pass_esp").checked) {
        $("toto_esp_saisie").innerHTML = $("toto_esp_saisie2").innerHTML = $("montant_controle_esp").value  = (parseFloat($("toto_esp_theorique").innerHTML).toFixed(tarifs_nb_decimales));
        $("toto_esp_saisie").style.color = "#999999";
    } else {
        $("toto_esp_saisie").innerHTML = $("toto_esp_saisie2").innerHTML = $("montant_controle_esp").value  = toto_esp_saisie.toFixed(tarifs_nb_decimales);
        $("toto_esp_saisie").style.color = "#000000";
    }
    if ($("pass_chq").checked) {
        $("toto_chq_saisie").innerHTML = $("toto_chq_saisie2").innerHTML = $("montant_controle_chq").value  = (parseFloat($("toto_chq_theorique").innerHTML).toFixed(tarifs_nb_decimales));
        $("toto_chq_saisie").style.color = "#999999";
    } else {
        $("toto_chq_saisie").innerHTML = $("toto_chq_saisie2").innerHTML = $("montant_controle_chq").value  = toto_chq_saisie.toFixed(tarifs_nb_decimales);
        $("toto_chq_saisie").style.color = "#000000";
    }
	
    if ($("pass_cb").checked) {
        $("toto_cb_saisie").innerHTML = $("toto_cb_saisie2").innerHTML = $("montant_controle_cb").value   = (parseFloat($("toto_cb_theorique").innerHTML).toFixed(tarifs_nb_decimales));
        $("toto_cb_saisie").style.color = "#999999";
    } else {
        $("toto_cb_saisie").innerHTML = $("toto_cb_saisie2").innerHTML = $("montant_controle_cb").value  = toto_cb_saisie.toFixed(tarifs_nb_decimales);
        $("toto_cb_saisie").style.color = "#000000";
    }
	
    toto_saisie = (toto_esp_saisie+toto_chq_saisie+toto_cb_saisie).toFixed(tarifs_nb_decimales);
	
    $("diff_esp").innerHTML = $("diff_esp2").innerHTML = $("montant_erreur_esp").value = (toto_esp_saisie-toto_esp_theo).toFixed(tarifs_nb_decimales);
    if (toto_esp_saisie-toto_esp_theo >0) {
        $("diff_esp").innerHTML = $("diff_esp2").innerHTML = "+"+(toto_esp_saisie-toto_esp_theo).toFixed(tarifs_nb_decimales);
    }
    $("diff_chq").innerHTML = $("diff_chq2").innerHTML = $("montant_erreur_chq").value = (toto_chq_saisie-toto_chq_theo).toFixed(tarifs_nb_decimales);
    if (toto_chq_saisie-toto_chq_theo >0) {
        $("diff_chq").innerHTML = $("diff_chq2").innerHTML = "+"+(toto_chq_saisie-toto_chq_theo).toFixed(tarifs_nb_decimales);
    }
    $("diff_cb").innerHTML = $("diff_cb2").innerHTML = $("montant_erreur_cb").value = (toto_cb_saisie-toto_cb_theo).toFixed(tarifs_nb_decimales);
    if (toto_cb_saisie-toto_cb_theo >0) {
        $("diff_cb").innerHTML = $("diff_cb2").innerHTML = "+"+(toto_cb_saisie-toto_cb_theo).toFixed(tarifs_nb_decimales);
    }
    toto_diff = (toto_esp_saisie-toto_esp_theo + toto_chq_saisie-toto_chq_theo + toto_cb_saisie-toto_cb_theo).toFixed(tarifs_nb_decimales);
	
    $("toto_saisie").innerHTML = $("montant_controle").value = toto_saisie;
    $("toto_diff").innerHTML = toto_diff;
    $("toto_theo").innerHTML = $("montant_theorique").value = toto_theo.toFixed(tarifs_nb_decimales);
	
    if (toto_esp_theo.toFixed(tarifs_nb_decimales) != toto_esp_saisie.toFixed(tarifs_nb_decimales)) {
        $("diff_esp").style.color = "#FF0000";
        $("diff_esp2").style.color = "#FF0000";
        alerte_totaux = true;
    }
    else
    {
        $("diff_esp").style.color = "#000000";
        $("diff_esp2").style.color = "#000000";
    }
	
    if (toto_chq_theo.toFixed(tarifs_nb_decimales) != toto_chq_saisie.toFixed(tarifs_nb_decimales)) {
        $("diff_chq").style.color = "#FF0000";
        $("diff_chq2").style.color = "#FF0000";
        alerte_totaux = true;
    } else {
        $("diff_chq").style.color = "#000000";
        $("diff_chq2").style.color = "#000000";
    }
	
	
    if (toto_cb_theo.toFixed(tarifs_nb_decimales) != toto_cb_saisie.toFixed(tarifs_nb_decimales)) {
        $("diff_cb").style.color = "#FF0000";
        $("diff_cb2").style.color = "#FF0000";
        alerte_totaux = true;
    } else {
        $("diff_cb").style.color = "#000000";
        $("diff_cb2").style.color = "#000000";
    }
	

	
    $("montant_especes").value = toto_esp_saisie;
	
    if (alerte_totaux) {
        $("commentaire_add").innerHTML = "Une erreur de caisse est signalée, veuillez en préciser l'origine.";
    } else {
        $("commentaire_add").innerHTML = "";
    }
	
    var total_op_cheque = 0;
	
    if (!$("pass_chq").checked) {
        indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
        indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
        for (j=0; j<=indentation_exist_cheques ; j++) {
            if ($("CHK_EXIST_CHQ_"+j).checked) {
                total_op_cheque ++;
            }
        }
        for (i=0; i<=indentation_controle_cheques ; i++) {
            if (!isNaN(parseFloat($("CHQ_"+i).value)) && $("CHQ_"+i).value != "0") {
                total_op_cheque ++;
            }
        }
    }
    $("saisie_op_cheques").innerHTML = $("saisie_op_cheques2").innerHTML = total_op_cheque;
	
    var total_op_cb = 0;
    if (!$("pass_cb").checked) {
        indentation_exist_cb = parseInt($("indentation_exist_cb").value);
        for (i=0; i<=indentation_exist_cb ; i++) {
            if ($("CHK_EXIST_CB_"+i).checked) {
                total_op_cb ++;
            }
        }
        indentation_controle_cb = parseInt($("indentation_controle_cb").value);
        for (i=0; i<=indentation_controle_cb ; i++) {
            if (!isNaN(parseFloat($("CB_"+i).value)) && $("CB_"+i).value != "0") {
                total_op_cb ++;
            }
        }
    }
    $("saisie_op_cb").innerHTML = $("saisie_op_cb2").innerHTML = total_op_cb;
}

//gestion du menu controle de caisse
function step_menu_controle (id_contenu, id_menu, array_id) {
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
    calcul_controle_caisse ();
}

//calcul des totaux espèces
function calcul_controle_caisse_esp (array_especes)  {
    var montant_tt_espece = 0;
    for (i=0; i<array_especes.length; i++) {
        if (!isNaN(parseFloat($("ESP_"+array_especes[i].replace(".", "")).value))) {
            $("T_ESP_"+array_especes[i].replace(".", "")).innerHTML = (parseFloat(array_especes[i]) * parseFloat($("ESP_"+array_especes[i].replace(".", "")).value)).toFixed(tarifs_nb_decimales);
            montant_tt_espece += parseFloat($("T_ESP_"+array_especes[i].replace(".", "")).innerHTML);
        }
    }
    $("TT_ESP").innerHTML = montant_tt_espece.toFixed(tarifs_nb_decimales);
}

//insertion d'une nouvelle ligne d'opération 
function insert_new_line_ope_spe () {
    indentation_controle_ope_spe = parseInt($("indentation_controle_ope_spe").value);
    new_indentation_controle_ope_spe = indentation_controle_ope_spe+1;
    new Insertion.Bottom($("liste_ope_spe"),
        '<div  id="ligne_ope_spe_'+new_indentation_controle_ope_spe+'">'+
        '<table><tr><td style="width:85px">'+
        '<div style="width:85px; display:block"><input name="ST_OPE_'+new_indentation_controle_ope_spe+'" type="radio" id="ADD_OPE_'+new_indentation_controle_ope_spe+'" value="+" checked="checked" />&nbsp;/&nbsp;<input name="ST_OPE_'+new_indentation_controle_ope_spe+'" type="radio" id="SUB_OPE_'+new_indentation_controle_ope_spe+'" value="-" /></div>'+
        '</td><td>'+
        '<input name="OPE_'+new_indentation_controle_ope_spe+'" type="text" class="classinput_nsize" id="OPE_'+new_indentation_controle_ope_spe+'" size="15" style="text-align:right"/>&nbsp;'+
        '</td><td>'+monnaie_html+'&nbsp;'+
        '</td><td>'+
        '<input name="DESC_OPE_'+new_indentation_controle_ope_spe+'" type="text" class="classinput_nsize" id="OPE_'+new_indentation_controle_ope_spe+'" size="35" />'+
        '<script type="text/javascript">'+
        'Event.observe($("OPE_'+new_indentation_controle_ope_spe+'"), "blur", function(evt){'+
        'Event.stop(evt);	nummask(evt, 0, "X.X");  calcul_controle_caisse ();});'+
        'Event.observe($("ADD_OPE_'+new_indentation_controle_ope_spe+'"), "click", function(evt){'+
        'calcul_controle_caisse ();});'+
        'Event.observe($("SUB_OPE_'+new_indentation_controle_ope_spe+'"), "click", function(evt){'+
        'calcul_controle_caisse ();});'+
        '</script>'+
        '</td></tr></table>'+
        '<div style="height:5px"></div></div>');
    $("indentation_controle_ope_spe").value = new_indentation_controle_ope_spe;
    calcul_controle_caisse ();
    $("OPE_"+new_indentation_controle_ope_spe).focus();
}
//calcul des totaux chèques
function calcul_controle_caisse_chq () {
    var montant_tt_cheque = 0;
    indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
    indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
    for (j=0; j<=indentation_exist_cheques ; j++) {
        if ($("CHK_EXIST_CHQ_"+j).checked) {
            montant_tt_cheque += parseFloat($("CHK_EXIST_CHQ_"+j).value);
        }
    }
    for (i=0; i<=indentation_controle_cheques ; i++) {
        if (!isNaN(parseFloat($("CHQ_"+i).value))) {
            montant_tt_cheque += parseFloat($("CHQ_"+i).value);
        }
    }
    $("TT_CHQ").innerHTML = montant_tt_cheque.toFixed(tarifs_nb_decimales);
}

//insertion d'une nouvelle ligne de chèques
function insert_new_line_chq () {
    indentation_controle_chq = parseInt($("indentation_controle_cheques").value);
    new_indentation_controle_chq = indentation_controle_chq+1;
    new Insertion.After($("ligne_chq_"+indentation_controle_chq),
        '<div class="ligne_chq" id="ligne_chq_'+new_indentation_controle_chq+'"><div class="inner_ligne_chq" style="width:55px">&nbsp;</div><input name="CHQ_'+new_indentation_controle_chq+'" type="text" class="classinput_nsize" id="CHQ_'+new_indentation_controle_chq+'" size="15" style="text-align:right"/> &nbsp;'+monnaie_html+''+
        '<script type="text/javascript">'+
        'Event.observe($("CHQ_'+new_indentation_controle_chq+'"), "blur", function(evt){'+
        'Event.stop(evt);	nummask(evt, 0, "X.X"); calcul_controle_caisse_chq (); calcul_controle_caisse ();});'+
        '</script><div style="height:5px"></div></div>');
    $("indentation_controle_cheques").value = new_indentation_controle_chq;
    calcul_controle_caisse_chq ();
    $("CHQ_"+new_indentation_controle_chq).focus();
}

//calcul des totaux CB
function calcul_controle_caisse_cb () {
    var montant_tt_cb = 0;
    indentation_controle_cb = parseInt($("indentation_controle_cb").value);
    indentation_exist_cb = parseInt($("indentation_exist_cb").value);
    for (j=0; j<=indentation_exist_cb ; j++) {
        if ($("CHK_EXIST_CB_"+j).checked) {
            montant_tt_cb += parseFloat($("CHK_EXIST_CB_"+j).value);
        }
    }
    for (i=0; i<=indentation_controle_cb ; i++) {
        if (!isNaN(parseFloat($("CB_"+i).value))) {
            montant_tt_cb += parseFloat($("CB_"+i).value);
        }
    }
    $("TT_CB").innerHTML = montant_tt_cb.toFixed(tarifs_nb_decimales);
}

//insertion d'une nouvelle ligne CB
function insert_new_line_cb () {
    indentation_controle_cb = parseInt($("indentation_controle_cb").value);
    new_indentation_controle_cb = indentation_controle_cb+1;
    new Insertion.After($("ligne_cb_"+indentation_controle_cb),
        '<div class="ligne_cb" id="ligne_cb_'+new_indentation_controle_cb+'"><div class="inner_ligne_cb" style="width:55px">&nbsp;</div><input name="CB_'+new_indentation_controle_cb+'" type="text" class="classinput_nsize" id="CB_'+new_indentation_controle_cb+'" size="15" style="text-align:right"/>  &nbsp;'+monnaie_html+''+
        '<script type="text/javascript">'+
        'Event.observe($("CB_'+new_indentation_controle_cb+'"), "blur", function(evt){'+
        'Event.stop(evt);	nummask(evt, 0, "X.X"); calcul_controle_caisse_cb ();calcul_controle_caisse ();});'+
        '</script><div style="height:5px"></div></div>');
    $("indentation_controle_cb").value = new_indentation_controle_cb;
    calcul_controle_caisse_cb ();
    $("CB_"+new_indentation_controle_cb).focus();
}




//*******************************
//calcul des transferts de caisses
//*******************************
function calcul_transfert_caisse () {
    var toto_esp_theo = 0;
    var toto_chq_theo = 0;
    var toto_theo = 0;
    var toto_saisie = 0;
    var toto_diff = 0;
	
    var toto_esp_saisie = parseFloat($("TT_ESP").innerHTML);
    var toto_chq_saisie = parseFloat($("TT_CHQ").innerHTML);
    var alerte_totaux = false;
	
    $("selected_caisse_dest").innerHTML = $("id_compte_caisse_destination").options[$("id_compte_caisse_destination").selectedIndex].text;
	
    if ($("toto_esp_theorique").innerHTML != "") {
        toto_theo += toto_esp_theo = parseFloat($("toto_esp_theorique").innerHTML);
    }
	
    if (parseFloat(toto_esp_theo.toFixed(tarifs_nb_decimales)) < parseFloat(toto_esp_saisie.toFixed(tarifs_nb_decimales))) {
        $("TT_ESP").innerHTML = toto_esp_theo.toFixed(tarifs_nb_decimales);
    }
    if (0 > parseFloat(toto_esp_saisie).toFixed(tarifs_nb_decimales)) {
        $("TT_ESP").innerHTML = (0).toFixed(tarifs_nb_decimales);
    }
    toto_esp_saisie = parseFloat($("TT_ESP").innerHTML);
	
    if ($("toto_chq_theorique").innerHTML != "") {
        toto_theo += toto_chq_theo = parseFloat($("toto_chq_theorique").innerHTML);
    }
	
    $("toto_esp_saisie").innerHTML = $("montant_transfert_esp").value  = toto_esp_saisie.toFixed(tarifs_nb_decimales);
    $("toto_esp_saisie").style.color = "#000000";
    $("toto_chq_saisie").innerHTML = $("montant_transfert_chq").value  = toto_chq_saisie.toFixed(tarifs_nb_decimales);
    $("toto_chq_saisie").style.color = "#000000";
	
    toto_saisie = (toto_esp_saisie+toto_chq_saisie).toFixed(tarifs_nb_decimales);
	
    $("diff_esp").innerHTML = $("RT_ESP").innerHTML = (toto_esp_theo-toto_esp_saisie).toFixed(tarifs_nb_decimales);
    if (toto_esp_theo-toto_esp_saisie >0) {
        $("diff_esp").innerHTML = "+"+(toto_esp_theo-toto_esp_saisie).toFixed(tarifs_nb_decimales);
    }
    $("diff_chq").innerHTML = (toto_chq_theo-toto_chq_saisie).toFixed(tarifs_nb_decimales);
    if (toto_chq_theo-toto_chq_saisie >0) {
        $("diff_chq").innerHTML = "+"+(toto_chq_theo-toto_chq_saisie).toFixed(tarifs_nb_decimales);
    }
	
    toto_diff = (toto_esp_theo-toto_esp_saisie + toto_chq_theo-toto_chq_saisie).toFixed(tarifs_nb_decimales);
	
    $("toto_saisie").innerHTML = $("montant_transfert").value = toto_saisie;
    $("toto_diff").innerHTML = toto_diff;
    $("toto_theo").innerHTML = $("montant_theorique").value = toto_theo.toFixed(tarifs_nb_decimales);
	
    if (toto_esp_theo.toFixed(tarifs_nb_decimales) < toto_esp_saisie.toFixed(tarifs_nb_decimales)) {
        $("diff_esp").style.color = "#FF0000";
        alerte_totaux = true;
    }
    else
    {
        $("diff_esp").style.color = "#000000";
    }
	
    if (toto_chq_theo.toFixed(tarifs_nb_decimales) < toto_chq_saisie.toFixed(tarifs_nb_decimales)) {
        $("diff_chq").style.color = "#FF0000";
        alerte_totaux = true;
    } else {
        $("diff_chq").style.color = "#000000";
    }
	
	
	
	
    var total_op_cheque = 0;
	
    indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
    indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
    for (j=0; j<=indentation_exist_cheques ; j++) {
        if ($("CHK_EXIST_CHQ_"+j).checked) {
            total_op_cheque ++;
        }
    }
    for (i=0; i<=indentation_controle_cheques ; i++) {
        if (!isNaN(parseFloat($("CHQ_"+i).value)) && $("CHQ_"+i).value != "0") {
            total_op_cheque ++;
        }
    }
    $("saisie_op_cheques").innerHTML =  total_op_cheque;
	
}
//gestion du menu transfert de caisse
function step_menu_transfert (id_contenu, id_menu, array_id) {
    array_id.each(function(j) {
        if(j!=undefined) {
            if ($(j[0])) {
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
    calcul_transfert_caisse ();
}

//calcul des totaux espèces
function calcul_transfert_caisse_esp (array_especes)  {
    var montant_tt_espece = 0;
    for (i=0; i<array_especes.length; i++) {
        if (!isNaN(parseFloat($("ESP_"+array_especes[i].replace(".", "")).value))) {
            $("T_ESP_"+array_especes[i].replace(".", "")).innerHTML = (parseFloat(array_especes[i]) * parseFloat($("ESP_"+array_especes[i].replace(".", "")).value)).toFixed(tarifs_nb_decimales);
            montant_tt_espece += parseFloat($("T_ESP_"+array_especes[i].replace(".", "")).innerHTML);
        }
    }
    $("TT_ESP").innerHTML = montant_tt_espece.toFixed(tarifs_nb_decimales);
}

//calcul des totaux chèques
function calcul_transfert_caisse_chq () {
    var montant_tt_cheque = 0;
    indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
    indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
    for (j=0; j<=indentation_exist_cheques ; j++) {
        if ($("CHK_EXIST_CHQ_"+j).checked) {
            montant_tt_cheque += parseFloat($("CHK_EXIST_CHQ_"+j).value);
        }
    }
    for (i=0; i<=indentation_controle_cheques ; i++) {
        if (!isNaN(parseFloat($("CHQ_"+i).value))) {
            montant_tt_cheque += parseFloat($("CHQ_"+i).value);
        }
    }
    $("TT_CHQ").innerHTML = montant_tt_cheque.toFixed(tarifs_nb_decimales);
}
//insertion d'une nouvelle ligne de chèques pour transferts
function insert_new_transfert_line_chq () {
    indentation_controle_chq = parseInt($("indentation_controle_cheques").value);
    new_indentation_controle_chq = indentation_controle_chq+1;
    new Insertion.After($("ligne_chq_"+indentation_controle_chq),
        '<div class="ligne_chq" id="ligne_chq_'+new_indentation_controle_chq+'"><div class="inner_ligne_chq" style="width:55px">&nbsp;</div><input name="CHQ_'+new_indentation_controle_chq+'" type="text" class="classinput_nsize" id="CHQ_'+new_indentation_controle_chq+'" size="15" style="text-align:right"/>  &nbsp;'+monnaie_html+''+
        '<script type="text/javascript">'+
        'Event.observe($("CHQ_'+new_indentation_controle_chq+'"), "blur", function(evt){'+
        'Event.stop(evt);	nummask(evt, 0, "X.X"); calcul_transfert_caisse (); calcul_transfert_caisse_chq ();});'+
        '</script><div style="height:5px"></div></div>');
    $("indentation_controle_cheques").value = new_indentation_controle_chq;
    calcul_transfert_caisse_chq ();
    $("CHQ_"+new_indentation_controle_chq).focus();
}





//*******************************
//calcul des depots de caisses
//*******************************
function calcul_depot_banque () {
    var toto_esp_theo = 0;
    var toto_chq_theo = 0;
    var toto_theo = 0;
    var toto_saisie = 0;
    var toto_diff = 0;
	
    var toto_esp_saisie = parseFloat($("TT_ESP").innerHTML);
    var toto_chq_saisie = parseFloat($("TT_CHQ").innerHTML);
    var alerte_totaux = false;
	
    $("selected_bancaire_dest").innerHTML = $("id_compte_bancaire_destination").options[$("id_compte_bancaire_destination").selectedIndex].text;
	
    if ($("toto_esp_theorique").innerHTML != "") {
        toto_theo += toto_esp_theo = parseFloat($("toto_esp_theorique").innerHTML);
    }
	
    toto_esp_saisie = parseFloat($("TT_ESP").innerHTML);
	
    if ($("toto_chq_theorique").innerHTML != "") {
        toto_theo += toto_chq_theo = parseFloat($("toto_chq_theorique").innerHTML);
    }
	
    $("toto_esp_saisie").innerHTML = $("montant_depot_esp").value  = toto_esp_saisie.toFixed(tarifs_nb_decimales);
    $("toto_esp_saisie").style.color = "#000000";
    $("toto_chq_saisie").innerHTML = $("montant_depot_chq").value  = toto_chq_saisie.toFixed(tarifs_nb_decimales);
    $("toto_chq_saisie").style.color = "#000000";
	
    toto_saisie = (toto_esp_saisie+toto_chq_saisie).toFixed(tarifs_nb_decimales);
	
    $("diff_esp").innerHTML = $("RT_ESP").value = (toto_esp_theo-toto_esp_saisie).toFixed(tarifs_nb_decimales);
    if (toto_esp_theo-toto_esp_saisie >0) {
        $("diff_esp").innerHTML = "+"+(toto_esp_theo-toto_esp_saisie).toFixed(tarifs_nb_decimales);
    }
    $("diff_chq").innerHTML = (toto_chq_theo-toto_chq_saisie).toFixed(tarifs_nb_decimales);
    if (toto_chq_theo-toto_chq_saisie >0) {
        $("diff_chq").innerHTML = "+"+(toto_chq_theo-toto_chq_saisie).toFixed(tarifs_nb_decimales);
    }
	
    toto_diff = (toto_esp_theo-toto_esp_saisie + toto_chq_theo-toto_chq_saisie).toFixed(tarifs_nb_decimales);
	
    $("toto_saisie").innerHTML = $("montant_depot").value = toto_saisie;
    $("toto_diff").innerHTML = toto_diff;
    $("toto_theo").innerHTML = $("montant_theorique").value = toto_theo.toFixed(tarifs_nb_decimales);
	
    if ((toto_esp_theo-toto_esp_saisie).toFixed(tarifs_nb_decimales) < 0) {
        $("diff_esp").style.color = "#FF0000";
        alerte_totaux = true;
    }
    else
    {
        $("diff_esp").style.color = "#000000";
    }
	
    if (toto_chq_theo.toFixed(tarifs_nb_decimales) < toto_chq_saisie.toFixed(tarifs_nb_decimales)) {
        $("diff_chq").style.color = "#FF0000";
        alerte_totaux = true;
    } else {
        $("diff_chq").style.color = "#000000";
    }
	
	
	
    var total_op_cheque = 0;
	
    indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
    indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
    for (j=0; j<=indentation_exist_cheques ; j++) {
        if ($("CHK_EXIST_CHQ_"+j).checked) {
            total_op_cheque ++;
        }
    }
    for (i=0; i<=indentation_controle_cheques ; i++) {
        if (!isNaN(parseFloat($("CHQ_"+i).value)) && $("CHQ_"+i).value != "0") {
            total_op_cheque ++;
        }
    }
    $("saisie_op_cheques").innerHTML =  total_op_cheque;
	
}

//gestion du menu depot de caisse
function step_menu_depot (id_contenu, id_menu, array_id) {
    array_id.each(function(j) {
        if(j!=undefined) {
            if ($(j[0])) {
                $(j[0]).style.display="none";
                if ($(j[1]+"_2")) {
                    $(j[1]+"_2").className="chemin_numero_gris";
                }
                if ($(j[1]+"_3")) {
                    $(j[1]+"_3").className="chemin_texte_gris";
                }
            }
        }
    }
    );

    $(id_contenu).style.display="block";
    $(id_menu+"_2").className="chemin_numero_choisi";
    $(id_menu+"_3").className="chemin_texte_choisi";
    set_tomax_height(id_contenu , -32);
    calcul_depot_banque ();
}

//calcul des totaux prelevements
function calcul_prelev_banque () {
    var montant_tt_cheque = 0;
    indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
    indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
    for (j=0; j<=indentation_exist_cheques ; j++) {
        if ($("CHK_EXIST_CHQ_"+j).checked) {
            montant_tt_cheque += parseFloat($("CHK_EXIST_CHQ_"+j).value);
        }
    }
//    for (i=0; i<=indentation_controle_cheques ; i++) {
//        if (!isNaN(parseFloat($("CHQ_"+i).value))) {
//            montant_tt_cheque += parseFloat($("CHQ_"+i).value);
//        }
//    }
    $("toto_prelev_select").innerHTML = montant_tt_cheque.toFixed(tarifs_nb_decimales);
    $("TT_CHQ").innerHTML = montant_tt_cheque.toFixed(tarifs_nb_decimales);
    $("toto_prelev_diff").innerHTML = (parseFloat($("toto_prelev_theorique").innerHTML)-montant_tt_cheque).toFixed(tarifs_nb_decimales);
}

//calcul des totaux traites NA
function calcul_traitena_banque () {
    var montant_tt_cheque = 0;
    indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
    indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
    for (j=0; j<=indentation_exist_cheques ; j++) {
        if ($("CHK_EXIST_CHQ_"+j).checked) {
            montant_tt_cheque += parseFloat($("CHK_EXIST_CHQ_"+j).value);
        }
    }
//    for (i=0; i<=indentation_controle_cheques ; i++) {
//        if (!isNaN(parseFloat($("CHQ_"+i).value))) {
//            montant_tt_cheque += parseFloat($("CHQ_"+i).value);
//        }
//    }
    $("toto_traitena_select").innerHTML = montant_tt_cheque.toFixed(tarifs_nb_decimales);
    $("TT_CHQ").innerHTML = montant_tt_cheque.toFixed(tarifs_nb_decimales);
    $("toto_traitena_diff").innerHTML = (parseFloat($("toto_traitena_theorique").innerHTML)-montant_tt_cheque).toFixed(tarifs_nb_decimales);
}

//gestion du menu prelevements
function step_menu_prelev (id_contenu, id_menu, array_id) {
    array_id.each(function(j) {
        if(j!=undefined) {
            if ($(j[0])) {
                $(j[0]).style.display="none";
                if ($(j[1]+"_2")) {
                    $(j[1]+"_2").className="chemin_numero_gris";
                }
                if ($(j[1]+"_3")) {
                    $(j[1]+"_3").className="chemin_texte_gris";
                }
            }
        }
    }
    );

    $(id_contenu).style.display="block";
    $(id_menu+"_2").className="chemin_numero_choisi";
    $(id_menu+"_3").className="chemin_texte_choisi";
    set_tomax_height(id_contenu , -32);
    //calcul_depot_banque ();
}
//calcul des totaux espèces
function calcul_depot_caisse_esp (array_especes)  {
    var montant_tt_espece = 0;
    for (i=0; i<array_especes.length; i++) {
        if (!isNaN(parseFloat($("ESP_"+array_especes[i].replace(".", "")).value))) {
            $("T_ESP_"+array_especes[i].replace(".", "")).innerHTML = (parseFloat(array_especes[i]) * parseFloat($("ESP_"+array_especes[i].replace(".", "")).value)).toFixed(tarifs_nb_decimales);
            montant_tt_espece += parseFloat($("T_ESP_"+array_especes[i].replace(".", "")).innerHTML);
        }
    }
    $("TT_ESP").innerHTML = montant_tt_espece.toFixed(tarifs_nb_decimales);
}

//calcul des totaux chèques
function calcul_depot_banque_chq () {
    var montant_tt_cheque = 0;
    indentation_exist_cheques = parseInt($("indentation_exist_cheques").value);
    indentation_controle_cheques = parseInt($("indentation_controle_cheques").value);
    for (j=0; j<=indentation_exist_cheques ; j++) {
        if ($("CHK_EXIST_CHQ_"+j).checked) {
            montant_tt_cheque += parseFloat($("CHK_EXIST_CHQ_"+j).value);
        }
    }
    for (i=0; i<=indentation_controle_cheques ; i++) {
        if (!isNaN(parseFloat($("CHQ_"+i).value))) {
            montant_tt_cheque += parseFloat($("CHQ_"+i).value);
        }
    }
    $("TT_CHQ").innerHTML = montant_tt_cheque.toFixed(tarifs_nb_decimales);
}

//insertion d'une nouvelle ligne de chèques pour depots
function insert_new_depot_line_chq () {
    indentation_controle_chq = parseInt($("indentation_controle_cheques").value);
    new_indentation_controle_chq = indentation_controle_chq+1;
    new Insertion.After($("ligne_chq_"+indentation_controle_chq),
        '<div id="ligne_chq_'+new_indentation_controle_chq+'">'+
        '	<table width="100%">'+
        '	<td style="width:55px">'+
        '<div>&nbsp;</div>'+
        '	</td>'+
        '	<td style="width:75px; text-align:right; padding-right:5px">'+
        '<input name="CHQ_'+new_indentation_controle_chq+'" type="text" class="classinput_lsize" id="CHQ_'+new_indentation_controle_chq+'" size="15" style="text-align:right"/>  &nbsp;'+monnaie_html+''+
        '<script type="text/javascript">'+
        '	Event.observe($("CHQ_'+new_indentation_controle_chq+'"), "blur", function(evt){'+
        '		nummask(evt, 0, "X.X");'+
        '		Event.stop(evt); '+
        '		calcul_depot_banque ();'+
        '		calcul_depot_banque_chq ();'+
        '	}'+
        '	);'+
        '</script>'+
        '</td>'+
        '<td style="width:75px">'+
        '<input name="NUM_'+new_indentation_controle_chq+'" type="text" id="NUM_'+new_indentation_controle_chq+'" value="" class="classinput_xsize"  />'+
        '	</td>'+
        '<td style="width:75px">'+
        '<input name="BNQ_'+new_indentation_controle_chq+'" type="text" id="BNQ_'+new_indentation_controle_chq+'" value="" class="classinput_xsize"   />'+
        '</td>'+
        '<td style="width:75px">'+
        '<input name="POR_'+new_indentation_controle_chq+'" type="text" id="POR_'+new_indentation_controle_chq+'" value="" class="classinput_xsize" />'+
        '</td>'+
        '<td style="width:75px; text-align:center">'+
        '&nbsp;'+
        '</td>'+
        '</tr>'+
        '</table>');
			
			
			
			
    $("indentation_controle_cheques").value = new_indentation_controle_chq;
    calcul_depot_banque_chq ();
    $("CHQ_"+new_indentation_controle_chq).focus();
}



//*******************************
//calcul des retraits de caisses
//*******************************
function calcul_retrait_banque (array_especes)  {
	
	
    var montant_tt_espece = 0;
	
    var toto_esp_theo = 0;
    var toto_theo = 0;
    var toto_saisie = 0;
    var toto_diff = 0;
	
		
    var alerte_totaux = false;
	
    for (i=0; i<array_especes.length; i++) {
        if (!isNaN(parseFloat($("ESP_"+array_especes[i].replace(".", "")).value))) {
            $("T_ESP_"+array_especes[i].replace(".", "")).innerHTML = (parseFloat(array_especes[i]) * parseFloat($("ESP_"+array_especes[i].replace(".", "")).value)).toFixed(tarifs_nb_decimales);
            montant_tt_espece += parseFloat($("T_ESP_"+array_especes[i].replace(".", "")).innerHTML);
        }
    }
    var toto_esp_saisie = $("TT_ESP").innerHTML = montant_tt_espece.toFixed(tarifs_nb_decimales);
	
    $("selected_bancaire_sour").innerHTML = $("id_compte_bancaire_source").options[$("id_compte_bancaire_source").selectedIndex].text;
	
    if ($("toto_esp_theorique").innerHTML != "") {
        toto_theo += toto_esp_theo = parseFloat($("toto_esp_theorique").innerHTML);
    }
	
    if (0 > parseFloat(toto_esp_saisie).toFixed(tarifs_nb_decimales)) {
        $("TT_ESP").innerHTML = (0).toFixed(tarifs_nb_decimales);
    }
    toto_esp_saisie = parseFloat($("TT_ESP").innerHTML);
	
    $("toto_esp_saisie").innerHTML = $("montant_retrait_esp").value  = toto_esp_saisie.toFixed(tarifs_nb_decimales);
    $("toto_esp_saisie").style.color = "#000000";
	
    toto_saisie = (toto_esp_saisie).toFixed(tarifs_nb_decimales);
	
    $("diff_esp").innerHTML = $("RT_ESP").innerHTML = (toto_esp_theo+toto_esp_saisie).toFixed(tarifs_nb_decimales);
    if (toto_esp_theo+toto_esp_saisie >0) {
        $("diff_esp").innerHTML = "+"+(toto_esp_theo+toto_esp_saisie).toFixed(tarifs_nb_decimales);
    }
	
    toto_diff = (toto_esp_theo+toto_esp_saisie).toFixed(tarifs_nb_decimales);
	
    $("toto_saisie").innerHTML = $("montant_retrait").value = toto_saisie;
    $("toto_diff").innerHTML = toto_diff;
    $("toto_theo").innerHTML = $("montant_theorique").value = toto_theo.toFixed(tarifs_nb_decimales);

	
	
}
//gestion du menu retrait de caisse
function step_menu_retrait (id_contenu, id_menu, array_id) {
    array_id.each(function(j) {
        if(j!=undefined) {
            if ($(j[0])) {
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
//calcul_retrait_banque ();
}


//*******************************
//calcul des ar de fonds de caisses
//*******************************
function calcul_ar_fonds () {
    var toto_esp_theo = 0;
    var toto_theo = 0;
    var toto_saisie = 0;
    var toto_diff = 0;
	
    var toto_esp_saisie = parseFloat($("TT_ESP").value);
    var alerte_totaux = false;
	
    if ($("toto_esp_theorique").innerHTML != "") {
        toto_theo += toto_esp_theo = parseFloat($("toto_esp_theorique").innerHTML);
    }
	
	
    if (0 > parseFloat(toto_esp_saisie.toFixed(tarifs_nb_decimales))) {
        $("TT_ESP").value = (0).toFixed(tarifs_nb_decimales);
    }
	
    toto_esp_saisie = parseFloat($("TT_ESP").value);
	
    //si ajout de fonds
    if ($("ajout_fonds").checked) {
        $("type_ar_text").innerHTML = "Ajout";
        $("toto_esp_saisie").innerHTML = $("montant_ar_esp").value  = toto_esp_saisie.toFixed(tarifs_nb_decimales);
        $("toto_esp_saisie").style.color = "#000000";
		
        toto_saisie = (toto_esp_saisie).toFixed(tarifs_nb_decimales);
		
        $("diff_esp").innerHTML = $("RT_ESP").value = (toto_esp_theo+toto_esp_saisie).toFixed(tarifs_nb_decimales);
		
        if (toto_esp_theo+toto_esp_saisie >0) {
            $("diff_esp").innerHTML = "+"+(toto_esp_theo+toto_esp_saisie).toFixed(tarifs_nb_decimales);
        }
		
        toto_diff = (toto_esp_theo+toto_esp_saisie).toFixed(tarifs_nb_decimales);
		
        $("toto_saisie").innerHTML = $("montant_ar").value = (parseFloat(toto_saisie)).toFixed(tarifs_nb_decimales);
        $("toto_diff").innerHTML = toto_diff;
        $("toto_theo").innerHTML = $("montant_theorique").value = toto_theo.toFixed(tarifs_nb_decimales);
        $("diff_esp").style.color = "#000000";
    }
    //retrait de fonds
    if ($("retrait_fonds").checked) {
        $("type_ar_text").innerHTML = "Retrait";
		
        $("toto_esp_saisie").innerHTML = $("montant_ar_esp").value  = (-parseFloat(toto_esp_saisie)).toFixed(tarifs_nb_decimales);
        $("toto_esp_saisie").style.color = "#000000";
		
        toto_saisie = (toto_esp_saisie).toFixed(tarifs_nb_decimales);
		
        $("diff_esp").innerHTML = $("RT_ESP").value = (toto_esp_theo-toto_esp_saisie).toFixed(tarifs_nb_decimales);
		
        toto_diff = (toto_esp_theo-toto_esp_saisie).toFixed(tarifs_nb_decimales);
		
        $("toto_saisie").innerHTML = $("montant_ar").value = (-parseFloat(toto_saisie)).toFixed(tarifs_nb_decimales);
        $("toto_diff").innerHTML = toto_diff;
        $("toto_theo").innerHTML = $("montant_theorique").value = toto_theo.toFixed(tarifs_nb_decimales);
		
        if (parseFloat(toto_diff).toFixed(tarifs_nb_decimales) < 0) {
            $("diff_esp").style.color = "#FF0000";
            alerte_totaux = true;
        }
        else
        {
            $("diff_esp").style.color = "#000000";
        }
    }
	
	
	

	
	
}
//gestion du menu ar de caisse
function step_menu_ar (id_contenu, id_menu, array_id) {
    array_id.each(function(j) {
        if(j!=undefined) {
            if ($(j[0])) {
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
    calcul_ar_fonds ();
}


//cochage des lignes de resultat de recherche avancée de documents

function coche_line_gest_caisse (type_action, second_id , length_list) {
	
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


//fonction d'affichage des resultats des controle d'une caisse
function	controle_caisse_historique_result () {
    id_move_type = $("id_move_type").getValue().join(", ");
    var AppelAjax = new Ajax.Updater(
        "controle_caisse_historique_result_content",
        "compta_controle_caisse_historique_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                id_compte_caisse: $("choix_id_caisse").value,
                id_move_type: id_move_type,
                page_to_show: $("page_to_show_s").value ,
                date_debut: $("date_debut").value,
                date_fin: $("date_fin").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}




//fonction d'affichage des resultats du compta_journal_achats
function	compta_journal_achats_result () {
    var AppelAjax = new Ajax.Updater(
        "compta_journal_achats_result_content",
        "compta_journal_achats_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                page_to_show: $("page_to_show_s").value ,
                date_debut: $("date_debut").value,
                date_fin: $("date_fin").value,
                ref_contact: $("ref_contact").value,
                numero_compte: $("numero_compte").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}
//fonction d'affichage des resultats du journal achats uniquement par exercice
function	compta_journal_achats_result_byexercice () {
    $("date_debut").value="";
    $("date_fin").value="";
    var AppelAjax = new Ajax.Updater(
        "compta_journal_achats_result_content",
        "compta_journal_achats_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                page_to_show: $("page_to_show_s").value ,
                date_exercice: $("date_exercice").value,
                ref_contact: $("ref_contact").value,
                numero_compte: $("numero_compte").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}


//fonction d'affichage des resultats du compta_journal_ventes
function	compta_journal_ventes_result () {
    var AppelAjax = new Ajax.Updater(
        "compta_journal_ventes_result_content",
        "compta_journal_ventes_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                page_to_show: $("page_to_show_s").value ,
                date_debut: $("date_debut").value,
                date_fin: $("date_fin").value,
                ref_contact: $("ref_contact").value,
                numero_compte: $("numero_compte").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

//fonction d'affichage des resultats du journal ventes uniquement par exercice
function	compta_journal_ventes_result_byexercice () {
    $("date_debut").value="";
    $("date_fin").value="";
    var AppelAjax = new Ajax.Updater(
        "compta_journal_ventes_result_content",
        "compta_journal_ventes_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                page_to_show: $("page_to_show_s").value ,
                date_exercice: $("date_exercice").value,
                ref_contact: $("ref_contact").value,
                numero_compte: $("numero_compte").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

//fonction d'affichage des resultats du compta_journal_tresorerie
function	compta_journal_tresorerie_result () {
    var AppelAjax = new Ajax.Updater(
        "compta_journal_tresorerie_result_content",
        "compta_journal_tresorerie_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                id_journal: $("id_journal").value,
                page_to_show: $("page_to_show_s").value ,
                date_debut: $("date_debut").value,
                date_fin: $("date_fin").value,
                ref_contact: $("ref_contact").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}
//fonction d'affichage des resultats du journal tresorerie uniquement par exercice
function	compta_journal_tresorerie_result_byexercice () {
    $("date_debut").value="";
    $("date_fin").value="";
    var AppelAjax = new Ajax.Updater(
        "compta_journal_tresorerie_result_content",
        "compta_journal_tresorerie_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                id_journal: $("id_journal").value,
                page_to_show: $("page_to_show_s").value ,
                date_exercice: $("date_exercice").value,
                ref_contact: $("ref_contact").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}



//************************************************
//************************************************
// commissionnement commerciaux
//************************************************

//fonction d'affichage des resultats d'un commercial
function	compta_situation_commerciaux_result () {
    var AppelAjax = new Ajax.Updater(
        "compta_situation_commerciaux_result_content",
        "compta_situation_commerciaux_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                page_to_show: $("page_to_show_s").value ,
                date_debut: $("date_debut").value,
                date_fin: $("date_fin").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

//fonction d'affichage des resultats d'un commercial par exercice
function	compta_situation_commerciaux_result_byexercice () {
    $("date_debut").value="";
    $("date_fin").value="";
    var AppelAjax = new Ajax.Updater(
        "compta_situation_commerciaux_result_content",
        "compta_situation_commerciaux_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                recherche: '1',
                page_to_show: $("page_to_show_s").value ,
                date_exercice: $("date_exercice").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_bonus_commerciaux_add(){
    var AppelAjax = new Ajax.Updater(
        "compta_bonus_commerciaux_add",
        "compta_bonus_commerciaux_addvalid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                ref_commercial: $("ref_commercial").value,
                lib_bonus: $("lib_bonus").value ,
                desc_bonus: $("desc_bonus").value,
                montant: $("montant").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_bonus_commerciaux_edit(){
    var AppelAjax = new Ajax.Updater(
        "compta_bonus_commerciaux_edit",
        "compta_bonus_commerciaux_editvalid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                id_bonus: $("id_bonus").value,
                ref_commercial: $("ref_commercial").value,
                lib_bonus: $("lib_bonus").value ,
                desc_bonus: $("desc_bonus").value,
                montant: $("montant").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_bonus_commerciaux_result(){
    var AppelAjax = new Ajax.Updater(
        "compta_bonus_commerciaux_result_content",
        "compta_bonus_commerciaux_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                ref_commercial: $("ref_commercial_search").value,
                date_deb: $("date_debut").value ,
                date_fin: $("date_fin").value ,
                lib_bonus: $("lib_search").value,
                order: $("order_search").value,
                montant: $("montant").value,
                delta: $("delta_montant").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}


function compta_prelevements_result(){
    var params = new Array();
    if($("search_client") != null)
        params.push("ref_contact="+$("search_client").value);
    if($("id_categ_client") != null)
        params.push("categ_client="+$("id_categ_client").value);
    if($("num_compte_search") != null)
        params.push("num_compte="+$("num_compte_search").value);
    var request = params.join("&");
    
    var AppelAjax = new Ajax.Updater(
        "resultats",
        "compta_gest_prelevements_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: request,
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_prelevements_contact_result(){
    var params = new Array();
    if($("search_client") != null)
        params.push("ref_contact="+$("search_client").value);
    if($("id_categ_client") != null)
        params.push("categ_client="+$("id_categ_client").value);
    if($("num_compte_search") != null)
        params.push("num_compte="+$("num_compte_search").value);
    var request = params.join("&");

    var AppelAjax = new Ajax.Updater(
        "resultats",
        "compta_gest_prelevements_contact_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: request,
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}


function compta_prelevement_add(){
    var AppelAjax = new Ajax.Updater(
        "",
        "compta_gest_prelevements_valid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                compte_src: $("id_compte_src").value ,
                piece_jointe: $("id_pj_prelev").value,
                mode_regl: "6",
                compte_dest: $("id_compte_dest").value,
                ref_client: $("ref_client").value,
                id_rgmnt_fav: $("id_rgmnt_fav").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_prelevement_del(){
    var AppelAjax = new Ajax.Updater(
        "",
        "compta_gest_prelevements_del.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                aut_to_del: $("aut_to_del").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_traitena_add(){
    var AppelAjax = new Ajax.Updater(
        "",
        "compta_gest_prelevements_valid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                compte_src: $("id_compte_src").value ,
                piece_jointe: $("id_pj_traitena").value,
                mode_regl: "5",
                compte_dest: $("id_compte_dest").value,
                ref_client: $("ref_client").value,
                id_rgmnt_fav: $("id_rgmnt_fav").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}


function compta_prelevement_edit(){
     var AppelAjax = new Ajax.Updater(
        "",
        "compta_gest_prelevements_valid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                compte_src: $("id_compte_src").value ,
                piece_jointe: $("id_pj_prelev").value,
                mode_regl: "6",
                id_prelevement: $("id_prelevement").value,
                edit: "true",
                compte_dest: $("id_compte_dest").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_traitena_edit(){
     var AppelAjax = new Ajax.Updater(
        "",
        "compta_gest_prelevements_valid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                compte_src: $("id_compte_src").value ,
                piece_jointe: $("id_pj_traitena").value,
                mode_regl: "5",
                id_prelevement: $("id_prelevement").value,
                edit: "true",
                compte_dest: $("id_compte_dest").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_traites_result(){
    var params = new Array();
    if($("search_client") != null)
        params.push("ref_contact="+$("search_client").value);
    if($("id_categ_client") != null)
        params.push("categ_client="+$("id_categ_client").value);
    if($("num_compte_search") != null)
        params.push("num_compte="+$("num_compte_search").value);
    var request = params.join("&");
    
    var AppelAjax = new Ajax.Updater(
        "resultats",
        "compta_gest_traites_result.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: request,
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}

function compta_traites_add(){
    var AppelAjax = new Ajax.Updater(
        "",
        "compta_gest_traites_valid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                compte_src: $("id_compte_src").value ,
                piece_jointe: $("id_pj_traites").value,
                mode_regl: "18",
                compte_dest: $("id_compte_dest").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}
function compta_traites_edit(){
     var AppelAjax = new Ajax.Updater(
        "",
        "compta_gest_traites_valid.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                compte_src: $("id_compte_src").value ,
                piece_jointe: $("id_pj_traites").value,
                mode_regl: "18",
                id_traites: $("id_traites").value,
                edit: "true",
                compte_dest: $("id_compte_dest").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
}
function compta_compte_add(){
    var AppelAjax = new Ajax.Updater(
        "",
        "compta_compte_bancaire_contact_add.php",
        {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                ref_contact: $("ref_client").value,
                lib_compte: $("lib_compte").value ,
                ref_banque: $("ref_banque").value,
                code_banque: $("code_banque").value,
                code_guichet: $("code_guichet").value,
                numero_compte: $("numero_compte").value,
                cle_rib: $("cle_rib").value,
                iban: $("iban").value,
                swift: $("swift").value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onComplete:H_loading
        }
        );
    $("lib_compte").value = "";
    $("ref_banque").value = "";
    $("code_banque").value = "";
    $("code_guichet").value = "";
    $("numero_compte").value = "";
    $("cle_rib").value = "";
    $("iban").value = "";
    $("swift").value = "";
}

function envoi_relance (ref_client, id_edition_mode, id_niveau_relance, mode) {
var AppelAjax = new Ajax.Request(
                    "compta_factures_client_"+mode+"_maj.php",
                    {
                    parameters: {ref_client: ref_client, id_edition_mode : id_edition_mode, id_niveau_relance : id_niveau_relance},
                    evalScripts:true,
                    onLoading:S_loading, onException: function () {S_failure();},
                    onComplete: function() {H_loading();},
                    onSuccess: function (requester){
                    requester.responseText.evalScripts();
                    }
                    }
                    );
}

function factures_nonreglees_liste_test (factures, orderorder, orderby) {
var AppelAjax = new Ajax.Request(
                    "compta_factures_client_nonreglees_imprimer.php",
                    {
                    parameters: {factures: factures, orderorder: orderorder, orderby : orderby},
                    evalScripts:true,
                    onLoading:S_loading, onException: function () {S_failure();},
                    onComplete: function() {H_loading();},
                    onSuccess: function (requester){
                    requester.responseText.evalScripts();
                    }
                    }
                    );
}