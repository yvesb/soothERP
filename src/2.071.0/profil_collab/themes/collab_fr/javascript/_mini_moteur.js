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
            parameters: {
                ref_art_categ: ref_art_categ
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
//chargement des caracteristiques avancee pour moteur de recherche article avancé
function charger_carac_avancee (ref_art_categ, id_cible) {
    var AppelAjax = new Ajax.Updater(
        id_cible,
        "catalogue_recherche_categ_caract_avancee.php", {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                ref_art_categ: ref_art_categ
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
            parameters: {
                ref_doc: ref_doc,
                ref_doc_line:ref_doc_line,
                page_to_show:page_to_show
            },
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

Array.prototype.in_array = function(p_val) {
    for(var i = 0, l = this.length; i < l; i++) {
        if(typeof(this[i]) == "string"){
            rowid = i;
            p_val = p_val.toString();
            return (this[i].toLowerCase() == p_val.toLowerCase());
        }
        else if(this[i] == p_val) {
            rowid = i;
            return true;
        }
    }
    return false;
}

//fonction d'affichage du mini moteur de recherche d'un contact
//syntaxe des filtres : "lib=val1,val2,val3;actif=val1;id=val1,val2"
function show_mini_moteur_contacts (fonction_retour, param_retour, filtres) {
    $('pop_up_mini_moteur').style.display='block';
    if (navigator.appName == 'Microsoft Internet Explorer') {
        $('pop_up_mini_moteur_iframe').style.display='block';
    }
    $('fonction_retour_m').value = fonction_retour;
    $('param_retour_m').value	=	param_retour;
    $('nom_m').focus();

    //Traitement des filtres de profil
    var opt;
    $("id_profil_m").innerHTML = "";
    if(filtres == null || filtres == undefined || filtres == ''){ // pas de filtres
        for(i=0; i<profils.length; i++){
            opt = new Option(profils[i]["lib"],profils[i]["id"]);
            if(profils[i]["actif"] == 2)
                opt.style.color = "#888888";
            else if(profils[i]["actif"] == 3)
                opt.style.color = "#00FF00";
            $("id_profil_m").appendChild(opt);
        }
    } else { // Parsage des filtres
        var arrayFiltresTmp = filtres.split(";");
        var arrayFiltres = new Array();
        arrayFiltres["lib"] = new Array();
        arrayFiltres["id"] = new Array();
        arrayFiltres["actif"] = new Array();

        for(i=0; i<arrayFiltresTmp.length; i++){
            var sep = arrayFiltresTmp[i].indexOf("=");
            var id = arrayFiltresTmp[i].substring(0, sep);
            var values = arrayFiltresTmp[i].substring(sep+1, arrayFiltresTmp[i].length).split(",");
            arrayFiltres[id] = values;
        }
        for(i=0; i<profils.length; i++){
            if((arrayFiltres["lib"].length==0 || arrayFiltres["lib"].in_array(profils[i]["lib"]))
                    && (arrayFiltres["id"].length==0 || arrayFiltres["id"].in_array(profils[i]["id"]))
                    && (arrayFiltres["actif"].length==0 || arrayFiltres["actif"].in_array(profils[i]["actif"]))){
                opt = new Option(profils[i]["lib"],profils[i]["id"]);
                if(profils[i]["actif"] == 2)
                    opt.style.color = "#888888";
                else if(profils[i]["actif"] == 3)
                    opt.style.color = "#00FF00";
                $("id_profil_m").appendChild(opt);
            }
        }
    }
}

//fonction de mise à jour du contact depuis le mini moteur de recherche de contact
function recherche_docu_set_contact (id_ref_contact, id_lib_contact, ref_contact, lib_contact) {
    $(id_ref_contact).value = ref_contact;
    $(id_lib_contact).innerHTML = lib_contact;

}

//fonction la plus générale de mise à jour de champ select popup
function update_field_anu(id_ref_contact, id_lib_contact, ref_contact, lib_contact){
    $(id_ref_contact).value = ref_contact;
    $(id_lib_contact).innerHTML = lib_contact;
}

function update_autorisations_compte(id_ref_contact, id_lib_contact, ref_contact, lib_contact){
    $(id_ref_contact).value = ref_contact;
    $(id_lib_contact).innerHTML = lib_contact;
    traite_infos_contact(ref_contact);
    if(lib_contact == ""){
        $("field_compte_src_add").hide();
        $("pop_up_piecej_add").hide();
    }
}

function traite_infos_contact(ref_contact){
    var AppelAjax = new Ajax.Request(
    "compta_get_infos_contact.php", {
        method: 'post',
        asynchronous: false,
        contentType:  'application/x-www-form-urlencoded',
        encoding:     'UTF-8',
        parameters: {
            ref_contact: ref_contact
        },
        evalScripts:true,
        onLoading:S_loading,
        onSuccess: function (response){
            //update_infos_contact(response.responseXML);
            response.evalScript = true;
        },
        onComplete:function () {
            H_loading();
        }
    }
);
}

function update_infos_contact(xmlDoc){
    //xmlDoc.getElementsByTagName("nom")[0];
    var comptes = xmlDoc.getElementsByTagName("comptes")[0].getElementsByTagName("compte");
    for(i=0; i<comptes.length; i++){
        var lib_compte = "";
        lib_compte += comptes[i].nodeValue;
        lib_compte += ": "+comptes[i].attributes.getNamedItem("iban").value;
        var opt = new Option(lib_compte, comptes[i].attributes.getNamedItem("id").value);
        $("id_compte_src").appendChild(opt);
    }

    var pieces = xmlDoc.getElementsByTagName("pieces")[0].getElementsByTagName("piece");
    for(i=0; i<pieces.length; i++){
        var opt2 = new Option(pieces[i].attributes.getNamedItem("nom").value, pieces[i].attributes.getNamedItem("id").value);
        $("id_pj_prelev").appendChild(opt2);
    }
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

function close_mini_moteur_documents_new() {
    $('pop_up_newmini_moteur_doc').hide();
    $('pop_up_newmini_moteur_doc_iframe').hide();
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
    if (    $('resume_stock').style.display == 'block'  ) {
        $('resume_stock').style.display='none';
        $('resume_stock_iframe').style.display='none';
    } else
{
        $('resume_stock').style.display='none';
        $('resume_stock_iframe').style.display='none';
       
        var AppelAjax = new Ajax.Updater(
            "resume_stock",
            "catalogue_articles_resume_stock.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    ref_article: ref_article
                },
                evalScripts:true,
                onLoading:S_loading,
                onComplete:function ()
                {
                    $("resume_stock_iframe").style.height = return_height_element("resume_stock") +"px";
                    $("resume_stock_iframe").style.width = return_width_element("resume_stock") +"px";
                    $("resume_stock").style.position = 'absolute';
                    $('resume_stock_iframe').style.position = 'absolute';
                    $('resume_stock_iframe').style.display='block';
                    //Enlever la scrollbar horizontale ou ajouter la scroll b ar correspondante aux calculs
                    if($("pop_up_view_categ_carac"))
                    {
                        $("pop_up_view_categ_carac").style.overflowX='hidden';
                        //deplacement popup selon souris et scrollbar
                        $("resume_stock").style.top = ($("pop_up_view_categ_carac").scrollTop + evt.clientY - 120)+"px";
                        $("resume_stock").style.left = (evt.clientX-800)+"px";
                        //deplacement iframe
                        $('resume_stock_iframe').style.top = ($("pop_up_view_categ_carac").scrollTop + evt.clientY - 120)+"px";
                        $('resume_stock_iframe').style.left = (evt.clientX-800)+"px";
                    //alert("carac_view");
                    }
                    //page catalogue recherche sans detail
                    else if ($("sub_content").scrollTop)
                    {
                        //deplacement popup selon souris et scrollbar
                        $("resume_stock").style.top = ( evt.clientY -45)+"px";
                        $("resume_stock").style.left = (evt.clientX -450)+"px";
                        //deplacement iframe
                        $('resume_stock_iframe').style.top = ( evt.clientY -45)+"px";
                        $('resume_stock_iframe').style.left = (evt.clientX -450)+"px";
                    //alert("sub_content");
                    }
                    else
                    {
                        $("resume_stock").style.top = ( evt.clientY - 45)+"px";
                        $("resume_stock").style.left = (evt.clientX - 450)+"px";
                        //deplacement iframe
                        $('resume_stock_iframe').style.top = ( evt.clientY -45)+"px";
                        $('resume_stock_iframe').style.left = (evt.clientX -450)+"px";
                    //alert("else");
                    }
                                   
                    $('resume_stock').style.display='block';
               

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
                parameters: {
                    ref_article: ref_article
                },
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
                parameters: {
                    ref_article: ref_article
                },
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
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
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
    var liste_doc_simple = "";
    for (i = 0; i < length_list; i++) {
        if ($("check"+second_id+"_"+i)) {
            if ($("check"+second_id+"_"+i).checked) {
                liste_doc += "&ref_doc"+i+"="+$("check"+second_id+"_"+i).value;
                liste_doc_simple += $("check"+second_id+"_"+i).value+";";
            }
        }
    }
   $("bouton_alert").style.display = "block";
    if(liste_doc != ""){
        if (action_selection == "print") {
            window.open("documents_recherche_result_action.php?fonction_generer="+action_selection+liste_doc,"_blank");
            $("coche_action_s").selectedIndex = 0;
        }else{
            $("titre_alert").innerHTML = "Confirmer l'action";
            switch (action_selection) {
                case "annuler_docs":{
                    $("texte_alert").innerHTML = "Confirmer l'annulation des documents sélectionnés.<br/>";
                    $("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
                    break;
                }
                case "export_ods":{
                    $("texte_alert").innerHTML = "Chargement en cours..";
                    $("titre_alert").innerHTML = "Choisir le modèle d'exportation.<br/>";
                    $("bouton_alert").style.display = "none";
                    var query = new Ajax.Updater('texte_alert', 'list_docs_export.php', {method: 'post',parameters: 'docs='+liste_doc_simple });
                    break;
                }
                case "DEV_enAttente_to_refuse":{
                    $("texte_alert").innerHTML = "Refuser tous ces Devis?<br/>";
                    $("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Oui" /><input type="submit" id="bouton0" name="bouton0" value="Non" />';
                    break;
                }
                case "DEV_aRealiser_to_attenteReponseClient":{
                    $("texte_alert").innerHTML = "Mettre tous ces Devis en attente de réponse client?<br/>";
                    $("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Oui" /><input type="submit" id="bouton0" name="bouton0" value="Non" />';
                    break;
                }
                case "CDC_enCours_generate_BLC_enSaisie":{
                    $("texte_alert").innerHTML = "Générer un bon de livraison client?<br/>";
                    $("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Oui" /><input type="submit" id="bouton0" name="bouton0" value="Non" />';
                    break;
                }
                case "BLC_pretAuDepart_to_livrer":{
                    $("texte_alert").innerHTML = "Mettre tous ces bons de livraison client à l'état livré?<br/>";
                    $("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Oui" /><input type="submit" id="bouton0" name="bouton0" value="Non" />';
                    break;
                }
                case "BLC_enSaisie_to_pretAuDepart":{
                    $("texte_alert").innerHTML = "Mettre tous ces bons de livraison client à l'état prêt au départ?<br/>";
                    $("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Oui" /><input type="submit" id="bouton0" name="bouton0" value="Non" />';
                    break;
                }
                case "FAC_enSaisie_to_aRegler":{
                    $("texte_alert").innerHTML = "Mettre tous ces bons de livraison client à l'état à régler?<br/>";
                    $("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Oui" /><input type="submit" id="bouton0" name="bouton0" value="Non" />';
                    break;
                }
            }
				
            $("alert_pop_up_tab").style.display = "block";
            $("framealert").style.display = "block";
            $("alert_pop_up").style.display = "block";
				
            Event.observe("bouton0", "click", function(){hide_popup();}, false);
				
            Event.observe("bouton1", "click", function () {
                var AppelAjax = new Ajax.Request(
                    "documents_recherche_result_action.php?fonction_generer="+action_selection+liste_doc,
                    {
                        evalScripts	:true,
                        onLoading	:S_loading,
                        onSuccess	:function (requester){
                            requester.responseText.evalScripts();
                        },
                        onComplete	:function () {
                            H_loading();
                        }
                    }
                    );
                hide_popup();
            }, false);
        }
    }else{
        $("coche_action_s").selectedIndex = 0;
    }
}

function hide_popup() {
      $("coche_action_s").selectedIndex = 0;
      $("framealert").style.display = "none";
      $("alert_pop_up").style.display = "none";
      $("alert_pop_up_tab").style.display = "none";
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

//fonction ouvre moteur choix compte plan comptable
function ouvre_compta_plan_add_mini_moteur() {
    $('pop_up_compta_plan_add_frame').style.display='block';
    $("aff_add_plan_mini").innerHTML = "";
    $('pop_up_compta_plan_add_mini_moteur').style.display='block';
}
// fonction ferme moteur choix compte plan comptable
function close_compta_plan_add_mini_moteur() {
    $('pop_up_compta_plan_add_frame').style.display='none';
    $('pop_up_compta_plan_add_mini_moteur').style.display='none';
}
//chargement des caracteristiques avancee pour moteur de recherche article avancé
function charger_compta_plan_add_mini_moteur (cible_id_num, cible_id_lib) {
    //en chargement
    num_compte = '';
    lib_compte = '';
    favori = '';
    //Ajax
    var AppelAjax = new Ajax.Updater(
        "aff_add_plan_mini",
        "compte_plan_comptable_add.php", {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                numero_compte: num_compte,
                lib_compte: lib_compte,
                favori: favori,
                check: false,
                valid: false,
                cible_id_num: cible_id_num,
                cible_id_lib: cible_id_lib
            },
            evalScripts:true,
            onLoading:S_loading,
            onComplete:H_loading
        }
        );

}
//chargement des caracteristiques avancee pour moteur de recherche article avancé
function valider_compta_plan_add_mini_moteur (valid) {
			
    var AppelAjax = new Ajax.Updater(
        "aff_add_plan_mini",
        "compte_plan_comptable_add.php", {
            method: 'post',
            asynchronous: true,
            contentType:  'application/x-www-form-urlencoded',
            encoding:     'UTF-8',
            parameters: {
                numero_compte: $('numero_compte').value,
                lib_compte: $('lib_compte').value,
                favori: $('favori').value,
                cible_id_num: $('cible_id_num').value,
                cible_id_lib: $('cible_id_lib').value,
                check: true,
                valid: valid
            },
            evalScripts:true,
            onLoading:S_loading,
            onComplete:H_loading
        }
        );
	
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
            onComplete:H_loading
        }
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
            parameters: {
                search_type: search_type,
                search_value: search_value
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function (){
                S_failure();
            },
            onComplete:H_loading
        }
        );
}