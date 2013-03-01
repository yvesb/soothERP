//------------------------------------------------
//------------------------------------------------
// FONTIONS GENERALES
//------------------------------------------------
//------------------------------------------------

// observateur de changement d'un formulaire
function formChanged() {
    changed= true;
}

//envois de formulaire
function submitform (nom_form) {
    document.forms[nom_form].submit();
}


//suppression d'une balise
function remove_tag(id_balise) {
    Element.remove($(id_balise));
}
function white () {
	
}
//affiche la pop_up d'alerte
function show_pop_alerte () {
    $("alert_pop_up_tab").style.display = "block";
    $("framealert").style.display = "block";
    $("alert_pop_up").style.display = "block";
}
//masque la pop up d'alerte
function hide_pop_alerte () {
    $("alert_pop_up_tab").style.display = "none";
    $("framealert").style.display = "none";
    $("alert_pop_up").style.display = "none";
}

//arret observer
function stop_observe(elt, evenement) {
//$(elt).removeEventListener(evenement,white, false);
//Event.stopObserving(elt, evenement, function(evt){}, false); 
}
//fonction de remplacement de string
function Remplace(expr,a,b) {
    var i=0
    while (i!=-1) {
        i=expr.indexOf(a,i);
        if (i>=0) {
            expr=expr.substring(0,i)+b+expr.substring(i+a.length);
            i+=b.length;
        }
    }
    return expr
}

//switch deux elements

function switch_element(ref1,ref2) {
    var copie_ref1= $(ref1).cloneNode(true);
    var copie_ref2= $(ref2).cloneNode(true);
    var old_ref1= $(ref1);
    var old_ref2= $(ref2);
	
    old_ref2.parentNode.replaceChild(copie_ref1,old_ref2);
    old_ref1.parentNode.replaceChild(copie_ref2,old_ref1);
	
}

//switch deux contenus d'elements
function switch_inner_element(ref1,ref2) {
    var copie_ref1= $(ref1).innerHTML;
    var copie_ref2= $(ref2).innerHTML;
    $(ref1).innerHTML=	copie_ref2;
    $(ref1).innerHTML.evalScripts();
    $(ref2).innerHTML=	copie_ref1;
    $(ref2).innerHTML.evalScripts();
	
}



// protype de message d'alerte
function alerte_message(){

}
alerte_message.prototype = {
    //initialisation du système d'affichage des alertes
    initialize : function() {
        $("framealert").style.display = "block";
        $("alert_pop_up").style.display = "none";
        $("alert_pop_up_tab").style.display = "none";
    },
    //alerte de changement sur un formulaire
    changedform : function() {
	
        $("titre_alert").innerHTML = tab_alerte["form_change"][0];
        $("texte_alert").innerHTML = tab_alerte["form_change"][1];
        $("bouton_alert").innerHTML = tab_alerte["form_change"][2];
	
        show_pop_alerte ();
		
        $("bouton0").onclick= function () {
            hide_pop_alerte ();
        }
        $("bouton1").onclick= function () {
            hide_pop_alerte ();
            page.showcontent();
        }
	
    },
    //confirmation de base
    confirm_supprimer : function(donnee_aff, formtosend) {
	
        $("titre_alert").innerHTML = tab_alerte[donnee_aff][0];
        $("texte_alert").innerHTML = tab_alerte[donnee_aff][1];
        $("bouton_alert").innerHTML = tab_alerte[donnee_aff][2];
	
        show_pop_alerte ();
		
        $("bouton0").onclick= function () {
            hide_pop_alerte ();
        }
        if ($("bouton1")) {
            $("bouton1").onclick= function () {
                hide_pop_alerte ();
                submitform (formtosend);
            }
        }
		
	
    },
    //confirmation de modif_ carac
    confirm_mod_carc_var : function(donnee_aff, formtosend, recheck) {
	
        $("titre_alert").innerHTML = tab_alerte[donnee_aff][0];
        $("texte_alert").innerHTML = tab_alerte[donnee_aff][1];
        $("bouton_alert").innerHTML = tab_alerte[donnee_aff][2];
	
        show_pop_alerte ();
		
        $("bouton0").onclick= function () {
            $(recheck).checked = "true";
            hide_pop_alerte ();
        }
        if ($("bouton1")) {
            $("bouton1").onclick= function () {
                hide_pop_alerte ();
                submitform (formtosend);
            }
        }
		
	
    },
    //confirm supression d'un profil dans un contact
    confirm_supprimer_profil : function(donnee_aff, formtosend, profil_check) {
	
        $("titre_alert").innerHTML = tab_alerte[donnee_aff][0];
        $("texte_alert").innerHTML = tab_alerte[donnee_aff][1];
        $("bouton_alert").innerHTML = tab_alerte[donnee_aff][2];
	
        show_pop_alerte ();
		
        $("bouton0").onclick= function () {
            hide_pop_alerte ();
            check_profil (profil_check);
        }
		
        $("bouton1").onclick= function () {
            hide_pop_alerte ();
            submitform (formtosend);
        }
		
	
    },
		
    //confirm supression d'une ligne de code barre par exemple
    confirm_supprimer_tag_and_callpage: function(donnee_aff, id_tag_del, page2call) {
	
        $("titre_alert").innerHTML = tab_alerte[donnee_aff][0];
        $("texte_alert").innerHTML = tab_alerte[donnee_aff][1];
        $("bouton_alert").innerHTML = tab_alerte[donnee_aff][2];
	
        show_pop_alerte ();
		
        $("bouton0").onclick= function () {
            hide_pop_alerte ();
        }
		
        $("bouton1").onclick= function () {
            hide_pop_alerte ();
            remove_tag (id_tag_del);
            new Ajax.Request(
                page2call,
                {
                    evalScripts:true,
                    onLoading:S_loading,
                    onException: function () {
                        S_failure();
                    },
                    onSuccess: function (requester){
                        requester.responseText.evalScripts();
                        H_loading();
                    }
                }
                );
        }
		
    },
    //confirm supression d'une ligne de quantité d'un tarif
    confirm_supprimer_tag: function(donnee_aff, id_tag_del) {
	
        $("titre_alert").innerHTML = tab_alerte[donnee_aff][0];
        $("texte_alert").innerHTML = tab_alerte[donnee_aff][1];
        $("bouton_alert").innerHTML = tab_alerte[donnee_aff][2];
	
        show_pop_alerte ();
		
        $("bouton0").onclick= function () {
            hide_pop_alerte ();
        }
		
        $("bouton1").onclick= function () {
            hide_pop_alerte ();
            remove_tag (id_tag_del);
        }
		
	
    },
		
    //alerte d'erreur de saisie avec texte d'erreur envoyé par la fonction (un seul bouton)
    alerte_erreur: function(alerte_titre, alerte_texte, alerte_bouton, callBack) {
	
        $("titre_alert").innerHTML = alerte_titre;
        $("texte_alert").innerHTML = alerte_texte;
        $("bouton_alert").innerHTML = alerte_bouton;
	
        show_pop_alerte ();
		
        $("bouton0").onclick= function () {
            if(Object.isFunction(callBack))
                callBack() ;
            hide_pop_alerte ();
        }
    }
	


}

//
//observateur de l'historique
//
var hashListener = {
    ie:		/MSIE/.test(navigator.userAgent),
    ieSupportBack:	true,
    hash:	document.location.hash.substr(1, document.location.hash.length),
    check:	function () {
        var h = document.location.hash.substr(1, document.location.hash.length);
        if (h != this.hash && h !="") {
            this.hash = h;
            this.onHashChanged();
        }
    },
    init:	function () {
        var self = this;

        // IE
        if ("onpropertychange" in document && "attachEvent" in document) {
            document.attachEvent("onpropertychange", function () {
                if (event.propertyName == "location") {
                    self.check();
                }
            });
        }
        // poll for changes of the hash
        window.setInterval(function () {
            self.check()
        }, 1000);
    },
    setHash: function (s) {
        // Mozilla always adds an entry to the history
        if (this.ie && this.ieSupportBack &&  (default_show_id != "from_histo" && default_show_id != "to_histo")) {
            this.writeFrame(s);
        }
        document.location.hash = s;
    },
    getHash: function () {
        return document.location.hash.substr(1, document.location.hash.length);;
    },
    writeFrame:	function (s) {
        var f = document.getElementById("historiqueFrame");
        var d = f.contentDocument || f.contentWindow.document;
        d.open();
        d.write("<script>window._hash = '" + s + "'; show = '" +default_show_url+ "'; window.onload = parent.hashListener.syncHash;<\/script>");
        d.close();
    //$("historiqueFrame").src = "history.php?identifiant="+default_show_id+"&targeturl=" + (s) + "&div_refresh=" + default_show_refresh + "&div_target=" + default_show_target;
    },
    syncHash:	function () {
        var s = this._hash;
        if (s != document.location.hash) {
            document.location.hash = s;
        }
    },
    onHashChanged:	function () {
        if (historique[1] == (document.location.hash.substr(1, document.location.hash.length))) {
            historique.shift();
            page.traitecontent ("from_histo",(document.location.hash.substr(1, document.location.hash.length)), true , "sub_content")
        } else {
            if (default_show_url != (document.location.hash.substr(1, document.location.hash.length))) {
                page.traitecontent ("to_histo",(document.location.hash.substr(1, document.location.hash.length)), true , "sub_content");
            }
            historique.unshift((document.location.hash.substr(1, document.location.hash.length)));
        }
    }
};


//rafraichir le cache
function refresh_cache () {
    if (uncache) {
        uncache = false;
        window.name="main";
        var win=window.open('','main');
        win.location.reload(true);
    }
}
//
// fonction d'appel et d'affichage des contenu chargés par ajax
//
function appelpage(div_cible) {
    this.div_cible_proto = div_cible;
}

appelpage.prototype = {
    initialize : function() {
    },
    //verification qu'un message d'alerte ne dois pas être déclenché
    verify : function(identifiant,targeturl,div_refresh,div_target) {
        this.identifiant_proto = identifiant;
        this.targeturl_proto = targeturl;
        this.div_refresh_proto = div_refresh;
        this.div_target_proto = div_target;
	
        if ((changed)&&((this.div_target_proto==this.div_cible_proto ))) {
            alerte.changedform();
        }
        else {
            this.showcontent();
        }
    },
	
    showcontent : function() {
        this.traitecontent(this.identifiant_proto,this.targeturl_proto,this.div_refresh_proto,this.div_target_proto);
    },
    //traitement de l'appel de page et gestion connexe
    traitecontent : function(identifiant,targeturl,div_refresh,div_target) {
        targeturl = targeturl;
        //si le div_target est _blank ou _self ou _parent on ouvre la page
        if (div_target=="_blank" || div_target=="_self" || div_target=="_parent") {
            window.open(targeturl,div_target);
        }
        //on réinitialise les formulaires comme étants vierges
        changed	=	false;
		
        //ouverture de page depuis un hash
        if (div_target=="sub_content") {
            lehash = document.location.hash.substr(1, document.location.hash.length);
            if (lehash != "") {
                if (historique.length == 0) {
                    targeturl = encodeURI(lehash);
                    historique.unshift(targeturl);
                    document.location.hash = decodeURI(targeturl);
                }
            }
        }
		
        default_show_id = identifiant;
        default_show_url = targeturl;
        default_show_refresh = div_refresh;
        default_show_target = div_target;
        if (targeturl != "") {
            //on vérifi si le contenu dois être rechargé ou non
            if (div_refresh=="false") {
                //si on ne l'a pas en mémoire
                if (global_tab[identifiant] == undefined || global_tab[identifiant] == "") {
                    default_show_id = identifiant;
                    //on le charge
                    var AppelAjax = new Ajax.Updater(
                        div_target,
                        targeturl,
                        {
                            evalScripts:true,
                            onLoading:S_loading,
                            onException: function (){
                                S_failure();
                            },
                            on404: function () {
                                page.traitecontent("_404","__404.php",true,div_target);
                            },
                            onComplete:function (originalRequest) {
                                if (div_target=="sub_content") {
                                    hashListener.setHash (encodeURI(targeturl));
                                }
                                global_tab[default_show_id]= originalRequest.responseText;
                                H_loading();
                            }
                        }
                        );
                }
                else {
                    //sinon on le récupére et on eval les sripts contenus
                    if (div_target=="sub_content") {
                        hashListener.setHash (encodeURI(targeturl));
                    }
                    $(div_target).innerHTML=global_tab[identifiant];
                    global_tab[identifiant].evalScripts();
                }
            }
            else {
                //sinon on le recharge
                var AppelAjax = new Ajax.Updater(
                    div_target,
                    targeturl,
                    {
                        evalScripts:true,
                        onLoading:S_loading,
                        onException: function (){
                            S_failure();
                        },
                        on404: function () {
                            page.traitecontent("_404","__404.php",true,div_target);
                        },
                        onComplete:function () {
                            H_loading();
                            if (div_target=="sub_content") {
                                hashListener.setHash (encodeURI(targeturl));
                            }
                        }
                    }
                    );
            }
        }
    },
    //appel les réponses pour le moteur simple recherche contact
    annuaire_recherche_simple : function() {
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "annuaire_recherche_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    nom : escape($F('nom_s')),
                    id_profil: $F('id_profil_s'),
                    page_to_show: $F('page_to_show_s'),
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur avancé recherche contact
    annuaire_recherche_avancee : function() {
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "annuaire_recherche_avancee_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    nom : escape($F('nom')),
                    id_categorie: $F('id_categorie'),
                    id_profil: $F('id_profil'),
                    page_to_show: $F('page_to_show'),
                    tel: escape($F('tel')),
                    email: escape($F('email')),
                    url: escape($F('url')),
                    code_postal: escape($F('code_postal')),
                    ville: escape($F('ville')),
                    orderby: $F('orderby'),
                    orderorder: $F('orderorder')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
									
    },
    //appel les réponses pour le mini moteur recherche contact
    annuaire_recherche_mini : function() {
        var AppelAjax = new Ajax.Updater(
            "resultat_contact_mini",
            "annuaire_recherche_mini_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    nom : escape($F('nom_m')),
                    id_profil: $F('id_profil_m'),
                    page_to_show: $F('page_to_show_m'),
                    orderby: $F('orderby_m'),
                    orderorder: $F('orderorder_m'),
                    fonction_retour: $F('fonction_retour_m'),
                    param_retour: $F('param_retour_m')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur recherche collaborateurs
    annuaire_recherche_collabs : function() {
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "annuaire_gestion_collabs_liste_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    nom : escape($F('nom_s')),
                    id_profil: $F('id_profil_s'),
                    id_fonction: $F('id_fonction_s'),
                    page_to_show: $F('page_to_show_s'),
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur recherche administrateurs
    annuaire_recherche_admin : function() {
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "annuaire_gestion_admin_liste_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    nom : escape($F('nom_s')),
                    id_profil: $F('id_profil_s'),
                    page_to_show: $F('page_to_show_s'),
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur simple recherche articles
    catalogue_recherche_simple : function() {
        var f_stock= "0";
        var f_nouv= "0";
        var f_promo= "0";
        if ($F("in_stock_s")=="1") {
            f_stock="1";
        }
        if ($F("is_nouveau_s")=="1") {
            f_nouv="1";
        }
        if ($F("in_promotion_s")=="1") {
            f_promo="1";
        }
		
		
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "catalogue_recherche_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    ref_art_categ : $F('ref_art_categ_s'),
                    lib_article: escape($F('lib_article_s')),
                    page_to_show: $F('page_to_show_s'),
                    ref_constructeur: $F('ref_constructeur_s'),
                    in_stock: f_stock ,
                    is_nouveau: f_nouv ,
                    in_promotion: f_promo,
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s'),
                    id_tarif: $F('id_tarif_s'),
                    id_stock: $F('id_stock_s')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur avancé recherche articles
    catalogue_recherche_avancee : function() {
        serie_recherche=  ($('form_recherche_a').serialize(true));
        for (key in serie_recherche) {
            serie_recherche[key] = escape(serie_recherche[key]);
        }
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "catalogue_recherche_avancee_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: serie_recherche,
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le mini moteur recherche articles
    catalogue_recherche_mini_simple : function() {
        var f_stock= "0";
        var f_nouv= "0";
        var f_promo= "0";
        var AppelAjax = new Ajax.Updater(
            "resultat",
            " catalogue_recherche_mini_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    ref_art_categ : $F('ref_art_categ_s'),
                    lib_article: escape($F('lib_article_s')),
                    page_to_show: $F('page_to_show_s'),
                    ref_constructeur: $F('ref_constructeur_s'),
                    in_stock: f_stock ,
                    is_nouveau: f_nouv ,
                    in_promotion: f_promo,
                    id_tarif: "",
                    id_stock: "",
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s'),
                    fonction_retour: $F('fonction_retour_s'),
                    param_retour: $F('param_retour_s')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur simple recherche utilisateur
    utilisateur_recherche_simple : function() {
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "utilisateur_recherche_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    nom : escape($F('nom_s')),
                    id_profil: $F('id_profil_s'),
                    page_to_show: $F('page_to_show_s'),
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s')
                },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur simple recherche utilisateur
    utilisateur_recherche_histo : function() {
        var AppelAjax = new Ajax.Updater(
            "resultat",
            "utilisateur_histo_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    nom : escape($F('nom_s')),
                    id_profil: $F('id_profil_s'),
                    page_to_show: $F('page_to_show_s'),
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s') ,
                    ip: $F('ip') ,
                    date_debut: $("date_debut").value,
                    date_fin: $("date_fin").value
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses les opérations d'un compte bancaire
    compte_bancaire_moves : function() {
        var AppelAjax = new Ajax.Updater(
            "liste_operations",
            "compta_compte_bancaire_operations_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    id_compte_bancaire: $F('id_compte_bancaire'),
                    page_to_show: $F('page_to_show'),
                    date_fin: $("date_fin").value
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses sur la recherche d'un compte bancaire
    compte_bancaire_recherche : function() {
        var AppelAjax = new Ajax.Updater(
            "liste_operations",
            "compta_compte_bancaire_recherche_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    id_compte_bancaire: $F('id_compte_bancaire'),
                    page_to_show: $F('page_to_show'),
                    date_fin: $("date_fin").value,
                    date_debut: $("date_debut").value,
                    libelle: escape($("libelle").value),
                    montant: $("montant").value,
                    orderby: $F('orderby'),
                    orderorder: $F('orderorder')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur simple recherche commissionnement par article
    article_commission_recherche : function() {
        var f_stock= "0";
        var f_nouv= "0";
        var f_promo= "0";
        if ($F("in_stock_s")=="1") {
            f_stock="1";
        }
        if ($F("is_nouveau_s")=="1") {
            f_nouv="1";
        }
        if ($F("in_promotion_s")=="1") {
            f_promo="1";
        }
		
		
        var AppelAjax = new Ajax.Updater(
            "resultat_comm_art",
            "commission_article_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    ref_art_categ : $F('ref_art_categ_s'),
                    lib_article: escape($F('lib_article_s')),
                    page_to_show: $F('page_to_show_s'),
                    ref_constructeur: $F('ref_constructeur_s'),
                    in_stock: f_stock ,
                    is_nouveau: f_nouv ,
                    in_promotion: f_promo,
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s'),
                    id_tarif: $F('id_tarif_s'),
                    id_stock: $F('id_stock_s')
                    },
                evalScripts:true,
                onLoading:S_loading,
                onException: function (){
                    S_failure();
                },
                onComplete:H_loading
            }
            );
    },
    //appel les réponses pour le moteur simple recherche frais de transport par article
    article_livraison_modes_cost_recherche : function() {
        var f_stock= "0";
        var f_nouv= "0";
        var f_promo= "0";
        if ($F("in_stock_s")=="1") {
            f_stock="1";
        }
        if ($F("is_nouveau_s")=="1") {
            f_nouv="1";
        }
        if ($F("in_promotion_s")=="1") {
            f_promo="1";
        }
		
		
        var AppelAjax = new Ajax.Updater(
            "resultat_comm_art",
            "livraison_modes_cost_article_result.php", {
                method: 'post',
                asynchronous: true,
                contentType:  'application/x-www-form-urlencoded',
                encoding:     'UTF-8',
                parameters: {
                    recherche: '1',
                    ref_art_categ : $F('ref_art_categ_s'),
                    lib_article: escape($F('lib_article_s')),
                    page_to_show: $F('page_to_show_s'),
                    ref_constructeur: $F('ref_constructeur_s'),
                    in_stock: f_stock ,
                    is_nouveau: f_nouv ,
                    in_promotion: f_promo,
                    orderby: $F('orderby_s'),
                    orderorder: $F('orderorder_s'),
                    id_tarif: $F('id_tarif_s'),
                    id_stock: $F('id_stock_s'),
                    id_livraison_mode: $F("id_livraison_mode")
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

}


//Enregistrement des données non rafraichies dans un tableau
function showResponse(originalRequest) {
    global_tab[default_show_id]= originalRequest.responseText;
    H_loading();
}

//Chargement en cours...
function S_loading () {
    if ($("load_show").style.visibility == "hidden") {
        $("load_show").style.visibility = "visible";
    }
}

//Chargement terminé...
function H_loading () {
    if ($("load_show").style.visibility == "visible") {
        $("load_show").style.visibility = "hidden";
    }
}

//erreur de connexion
function S_failure() {
    $("alert_pop_up").style.display = "block";
    $("framealert").style.display = "block";
    $("alert_onException").style.display = "block";
    H_loading();
}

//retour de variable pour l'historique
function history_reload() {
    return default_show_url;
}


//chargement d'appel de feuilles de styles supplémentaires
function ajoutcss (fichierCSS) {
    if (!fichierCSS) {
        return;
    }
    var feuillesStyles = document.styleSheets;
    for (var i = 0; i < feuillesStyles.length; i++) {
        if (fichierCSS == feuillesStyles[i].href.toString()) {
            return;
        }
    }
    var link = document.createElement("link");
    link.setAttribute ("type", "text/css");
    link.setAttribute ("rel", "stylesheet");
    link.setAttribute ("href", "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>"+fichierCSS);
    var head = $$("head")[0];
    head.appendChild(link);
}


function changeclassname (idcible, newclass) {
    $(idcible).className=newclass;
}


// ELEMENT de MISE A dimension
//renvois de la hauteur de la fenetre
function getWindowHeight() {
    var windowHeight=0;
    if (typeof(window.innerHeight)=='number') {
        windowHeight=window.innerHeight;
    }
    else {
        if (document.documentElement&&
            document.documentElement.clientHeight) {
            windowHeight = document.documentElement.clientHeight;
        }
        else {
            if (document.body&&document.body.clientHeight) {
                windowHeight=document.body.clientHeight;
            }
        }
    }
    return windowHeight;
}
//renvois de la largeur de la fenetre

function getWindowWidth() {
    var windowWidth=0;
    if (typeof(window.innerWidth)=='number') {
        windowWidth=window.innerWidth;
    }
    else {
        if (document.documentElement&&
            document.documentElement.clientWidth) {
            windowWidth = document.documentElement.clientWidth;
        }
        else {
            if (document.body&&document.body.clientWidth) {
                windowWidth=document.body.clientWidth;
            }
        }
    }
    return windowWidth;
}


// met les éléments à la hauteur
function setsize_to_element () {
    set_tomax_height("sub_content",0);
    set_tomax_height("right_content",0);

    if (navigator.appName=='Microsoft Internet Explorer') {
        $("framealert").style.width="100%";
        $("framealert").style.height=getWindowHeight();
    }

}

function set_tomax_height(id_element, majo) {
    if ($(id_element)) {
        var position_element=Position.positionedOffset($(id_element));
        var pos_y=position_element.last();
        $(id_element).style.height = (getWindowHeight()-pos_y+majo)+"px";
    }
}

function return_width_element(id_element) {
    if($(id_element)) {
        var dimensions = $(id_element).getDimensions();
        return dimensions.width;
    }
}

function return_height_element(id_element) {
    if($(id_element)) {
        var dimensions = $(id_element).getDimensions();
        return dimensions.height;
    }
}


function centrage_element(id_element){
    if($(id_element)) {
        $(id_element).style.top = ( getWindowHeight()-return_height_element(id_element))/2+"px";
        $(id_element).style.left = (getWindowWidth()-return_width_element(id_element))/2+"px";
    }
}

function centrage_h_element(id_element){
    if($(id_element)) {
        $(id_element).style.left = (getWindowWidth()-return_width_element(id_element))/2+"px";
    }
}

//blocage du retour chariot automatique à la saisie du code barre
function stopifcode_barre (event) {

    var key = event.which || event.keyCode;
    switch (key) {
        case Event.KEY_RETURN:
            Event.stop(event);
            break;
    }
}

//******************************************************
// fonction diverses
//******************************************************

//mise à la bonne largueur poursub_content
function set_size_to_sub_content () {
    if (getWindowWidth()>=1024) {
        $("sub_content").style.width= "1024px";
    } else {
        $("sub_content").style.width= getWindowWidth()+"px";
    }
	
}

//force la sélection dans un champ select
function preselect (value_index, id_select) {
    var selectBox = $(id_select);
    for (var i=0; i<selectBox.options.length; i++) {
        if (selectBox.options[i].value == value_index) {
            selectBox.options[i].selected = "selected";
        }
    }
}



//ouverture d'un document

function open_doc (ref_doc) {
    page.verify("document_edition","documents_edition.php?ref_doc="+ref_doc, "true", "sub_content");
}

//rafraichir le contenu en cours (bouton dans barre de menu)
function refresh_sub_content () {
    page.verify("content_frame", unescape(document.location.hash.substr(1, document.location.hash.length)), "true", "sub_content");
}

//fonctions liés au maj du soft

var stp_prog_file = false;
//barre de progression des fichiers
function size_file_progress (responseText) {
    if (responseText != "") {
        tableau = responseText.split("\n");
        $("files_progress").style.width = tableau[0]+"%";
        if (tableau[1] && tableau[1] != "" ) {
            $("maj_etat").innerHTML = unescape(tableau[1]);
        }
        if (tableau[2] && tableau[1] != "" ) {
            $("info_progress").innerHTML = unescape(tableau[2]);
        }
        if (tableau[3] && tableau[1] != "" ) {
            $("info_progress_more").innerHTML = unescape(tableau[3]);
        }
    }
}
//test du fichier de progression de fichiers
function view_progress( new_version) {
    if (!stp_prog_file) {
        setTimeout ("view_progress('"+new_version+"')", 2000);
        var AppelAjax = new Ajax.Request(
            "../echange_lmb/maj_lmb_"+new_version+"/lmb_download_state.tmp",
            {
                parameters: {
                    lmb: "1"
                },
                evalScripts:false,
                on404: function () {
                },
                onException: function () {
                },
                onComplete: function(requester) {
                    size_file_progress (requester.responseText);
                }
            }
            );
    }
	
}

//ajout ou suppression d'une permission pour un user

function set_maj_or_del_permission (ref_user, id_permission, id_profil, add_or_del) {
    var AppelAjax = new Ajax.Request(
        "utilisateur_permissions_maj.php",
        {
            parameters: {
                ref_user: ref_user,
                id_permission: id_permission,
                id_profil: id_profil,
                add_or_del: add_or_del
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function set_maj_or_del_permission_fonction (id_fonction, id_permission, id_profil, add_or_del) {
    var AppelAjax = new Ajax.Request(
        "fonction_permissions_maj.php",
        {
            parameters: {
                id_fonction: id_fonction,
                id_permission: id_permission,
                id_profil: id_profil,
                add_or_del: add_or_del
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function maj_permissions_multiple (ref_user, id_permission, param_permissions, id_profil) {
    var param;
	
    param=param_permissions.join(",");
    var AppelAjax = new Ajax.Request(
        "utilisateur_permissions_maj.php",
        {
            parameters: {
                ref_user: ref_user,
                id_permission: id_permission,
                param_permissions: param,
                id_profil: id_profil
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function maj_permissions_multiple_fonction (id_fonction, id_permission, param_permissions, id_profil) {
    var param;
	
    param=param_permissions.join(",");
    var AppelAjax = new Ajax.Request(
        "fonction_permissions_maj.php",
        {
            parameters: {
                id_fonction: id_fonction,
                id_permission: id_permission,
                param_permissions: param,
                id_profil: id_profil
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function maj_droits_membre_fonction (id_fonction,ref_contact,ref_user) {

    var AppelAjax = new Ajax.Request(
        "fonction_permissions_maj_contact.php",
        {
            parameters: {
                ref_contact:ref_contact,
                ref_user:ref_user,
                id_fonction:id_fonction
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function maj_droits_all_membres_fonction (id_fonction) {

    var AppelAjax = new Ajax.Request(
        "fonction_permissions_maj_fonction_membres.php",
        {
            parameters: {
                id_fonction:id_fonction
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function initialize_fonctions () {

    var AppelAjax = new Ajax.Request(
        "initialize_fonctions.php",
        {
            parameters: {},
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

function maj_permissions_tableau (ref_user, id_permission, param_permissions, id_profil) {
    var AppelAjax = new Ajax.Request(
        "utilisateur_permissions_maj_table.php",
        {
            parameters: {
                ref_user: ref_user,
                id_permission: id_permission,
                param_permissions: param_permissions,
                id_profil: id_profil
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}


//*****************************************************************
// DEB FONCTION AGENDA
//*****************************************************************

function agenda_create_AgendaReservationRessource(lib_agenda, ref_ressource, couleur_1, couleur_2, couleur_3){
    var AppelAjax = new Ajax.Request(
        "agenda_configuration_add.php",
        {
            parameters: {
                type_agenda : "AgendaReservationRessource",
                lib_agenda: lib_agenda,
                ref_ressource : ref_ressource,
                couleur_1 : couleur_1,
                couleur_2 : couleur_2,
                couleur_3 : couleur_3
            },
            evalScripts	:true,
            onLoading	:S_loading,
            onException	:function () {
                S_failure();
            },
            onSuccess	:function (requester){
                requester.responseText.evalScripts();
            },
            onComplete	:H_loading
        }
        );
}

function agenda_create_AgendaContact(lib_agenda, ref_contact, couleur_1, couleur_2, couleur_3){
    var AppelAjax = new Ajax.Request(
        "agenda_configuration_add.php",
        {
            parameters: {
                type_agenda : "AgendaContact",
                lib_agenda: lib_agenda,
                ref_contact : ref_contact,
                couleur_1 : couleur_1,
                couleur_2 : couleur_2,
                couleur_3 : couleur_3
            },
            evalScripts	:true,
            onLoading	:S_loading,
            onException	:function () {
                S_failure();
            },
            onSuccess	:function (requester){
                requester.responseText.evalScripts();
            },
            onComplete	:H_loading
        }
        );
}

function agenda_create_AgendaLoacationMateriel(lib_agenda, ref_article, couleur_1, couleur_2, couleur_3){
    var AppelAjax = new Ajax.Request(
        "agenda_configuration_add.php",
        {
            parameters: {
                type_agenda : "AgendaLoacationMateriel",
                lib_agenda: lib_agenda,
                ref_article : ref_article,
                couleur_1 : couleur_1,
                couleur_2 : couleur_2,
                couleur_3 : couleur_3
            },
            evalScripts	:true,
            onLoading	:S_loading,
            onException	:function () {
                S_failure();
            },
            onSuccess	:function (requester){
                requester.responseText.evalScripts();
            },
            onComplete	:H_loading
        }
        );
}

function agenda_modif_AgendaReservationRessource(ref_agenda, lib_agenda, ref_ressource, couleur_1, couleur_2, couleur_3){
    var AppelAjax = new Ajax.Request(
        "agenda_configuration_mod.php",
        {
            parameters: {
                ref_agenda : ref_agenda,
                lib_agenda: lib_agenda,
                ref_ressource : ref_ressource,
                couleur_1 : couleur_1,
                couleur_2 : couleur_2,
                couleur_3 : couleur_3
            },
            evalScripts	:true,
            onLoading	:S_loading,
            onException	:function () {
                S_failure();
            },
            onSuccess	:function (requester){
                requester.responseText.evalScripts();
            },
            onComplete	:H_loading
        }
        );
}

function agenda_modif_AgendaContact(ref_agenda, lib_agenda, ref_contact, couleur_1, couleur_2, couleur_3){
    var AppelAjax = new Ajax.Request(
        "agenda_configuration_mod.php",
        {
            parameters: {
                ref_agenda : ref_agenda,
                lib_agenda: lib_agenda,
                ref_contact : ref_contact,
                couleur_1 : couleur_1,
                couleur_2 : couleur_2,
                couleur_3 : couleur_3
            },
            evalScripts	:true,
            onLoading	:S_loading,
            onException	:function () {
                S_failure();
            },
            onSuccess	:function (requester){
                requester.responseText.evalScripts();
            },
            onComplete	:H_loading
        }
        );
}

function agenda_modif_AgendaLoacationMateriel(ref_agenda, lib_agenda, ref_article, couleur_1, couleur_2, couleur_3){
    var AppelAjax = new Ajax.Request(
        "agenda_configuration_mod.php",
        {
            parameters: {
                ref_agenda : ref_agenda,
                lib_agenda: lib_agenda,
                ref_article : ref_article,
                couleur_1 : couleur_1,
                couleur_2 : couleur_2,
                couleur_3 : couleur_3
            },
            evalScripts	:true,
            onLoading	:S_loading,
            onException	:function () {
                S_failure();
            },
            onSuccess	:function (requester){
                requester.responseText.evalScripts();
            },
            onComplete	:H_loading
        }
        );
}

function agenda_setCouleur(couleur, afficheur, contenant){
    $(afficheur).style.backgroundColor = couleur;
    $(contenant).value =  couleur;
}

//*****************************************************************
//FIN FONCTION AGENDA
//*****************************************************************
function maj_mnt_solde(divid, totlignes){
    inputs = $(divid).getElementsByTagName("input");
    mnt_solde = 100;
    for(i=1;i<inputs.length;i++){
        if (inputs[i].id.substr(0,12) == "inp_montant_"){
            if (inputs[i].id != "inp_montant_"+totlignes)
                mnt_solde -= inputs[i].value;
        }
        if (inputs[i].id == "inp_montant_"+totlignes)
            inputs[i].value = mnt_solde;
    }
	
}

function toggleDisplay(id1,id2){
    inputsVisibles = document.getElementsByName(id1);
    inputsHidden = document.getElementsByName(id2);
    for(i=0;i<inputsHidden.length;i++){
        inputsHidden[i].style.display = "none";
    }
    for(i=0;i<inputsVisibles.length;i++){
        inputsVisibles[i].style.display = "";
    }
}


function del_art_fav(ref_article)
{
    var AppelAjax = new Ajax.Request(
        "catalogue_articles_favoris_del.php",
        {
            parameters: {
                ref_article: ref_article
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess	:function (requester){
                requester.responseText.evalScripts();
            },
            onComplete: function() {
                H_loading();
            }
        }
        );
}