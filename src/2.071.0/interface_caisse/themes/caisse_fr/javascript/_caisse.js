
function price_format(p) {
	if(typeof p == "string")
	{
		prix = parseFloat(p.replace(" ",""));
	}
	else{
		prix = parseFloat(p);
	}

	prix = prix.toFixed(TARIFS_NB_DECIMALES);

	var sPrix = prix.toString();
	var tPrix = sPrix.split('.');
	var dec;
	var unit;
	unit = tPrix[0];
	if(tPrix.length > 1)
	{
		dec  = tPrix[1];
	}
	else{
		dec  = "";
	}
	var res = "";

	var step = 0;
	for (var i = unit.length-1; i >= 0; i--) {
		if (step == 2)
		{
			res = unit[i]+res;
			step = 0;
		}
		else{
			res = unit[i]+res;
			step++;
		}
	}
	return res+PRICES_DECIMAL_SEPARATOR+dec;
}


function caisse_heure(target) {
	var dt=new Date();
	$(target).innerHTML = "";
	if (dt.getHours()>=0 && dt.getHours()<10){
		$(target).innerHTML += "0";
	}
	$(target).innerHTML += dt.getHours()+":";
	if (dt.getMinutes()>=0 && dt.getMinutes()<10){
		$(target).innerHTML += "0";
	}
	$(target).innerHTML += dt.getMinutes()+":";
	if (dt.getSeconds()>=0 && dt.getSeconds()<10){
		$(target).innerHTML += "0";
	}
	$(target).innerHTML += dt.getSeconds();

	window.setTimeout("caisse_heure('"+target+"')",1000);
}

//appel les réponses pour le moteur de recherche articles pour un document
function document_recherche_article() {
	var AppelAjax = new Ajax.Updater(
		"resultat_article",
		"caisse_panneau_recherche_articles_result.php", {
			method: 'post',
			asynchronous: true,
			contentType:  'application/x-www-form-urlencoded',
			encoding:     'UTF-8',
			parameters: {
				recherche: '1',
				ref_art_categ : $F('ref_art_categ_s'),
				lib_article: escape($F('lib_article_s')),
				page_to_show: $F('article_page_to_show_s'),
				ref_constructeur: $F('ref_constructeur_s'),
				orderby: $F('article_orderby_s'),
				orderorder: $F('article_orderorder_s'),
				ref_doc: $F('ref_doc'),
				recherche_auto: $F('article_recherche_auto'),
				from_rapide_search: from_rapide_search
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

//appel les réponses pour le moteur simple recherche contact
function caisse_recherche_client_simple() {
	var AppelAjax = new Ajax.Updater(
		"resultat",
		"caisse_panneau_recherche_client_result.php", {
			method: 'post',
			asynchronous: true,
			contentType:  'application/x-www-form-urlencoded',
			encoding:     'UTF-8',
			parameters: {
				recherche: '1',
				nom : escape($F('nom_s')),
				page_to_show: $F('page_to_show_s'),
				orderby: $F('orderby_s'),
				orderorder: $F('orderorder_s')
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

function caisse_maj_client(ref_doc, ref_contact) {
	var AppelAjax = new Ajax.Request(
		"caisse_maj_client.php",
		{
			parameters: {
				ref_doc: ref_doc,
				ref_contact: ref_contact
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
			}
		}
		);
}

//fonction pour ajouter un article(et donc une ligne) à un document de type ticket dans la caisse
//si ref_ticket existe
//alors on charge le ticket
//sinon, on créé un nouveau ticket
function caisse_ajouter_article(ref_ticket, ref_contact, ref_article) {

	var AppelAjax = new Ajax.Request(
		"caisse_ajouter_article.php",
		{
			parameters: {
				ref_ticket: ref_ticket,
				ref_contact: ref_contact,
				ref_article : ref_article
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
			}
		}
		);
}

//fonction pour supprimer un article(et donc une ligne) à un document de type ticket dans la caisse
function caisse_suppr_article(ref_ticket, ref_ligne) {
	var AppelAjax = new Ajax.Request(
		"caisse_suppr_article.php",
		{
			parameters: {
				ref_ticket: ref_ticket,
				ref_ligne: ref_ligne
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
			}
		}
		);
}

//fonction pour mettre à jour une ligne d'un document d'un document de type ticket dans la caisse
function caisse_maj_ligne_ticket(ref_ticket, ref_ligne, remise, puttc, qte ) {
	var AppelAjax = new Ajax.Request(
		"caisse_maj_ligne.php",
		{
			parameters: {
				ref_ticket: ref_ticket,
				ref_ligne: ref_ligne,
				remise : remise,
				puttc : puttc,
				qte : qte
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
			}
		}
		);
}

//
function caisse_charger_ticket (ref_ticket) {
	var AppelAjax = new Ajax.Request(
		"caisse_charger_ticket.php",
		{
			parameters: {
				ref_ticket: ref_ticket
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
			}
		}
		);
}

function caisse_encaisser_ticket (ref_ticket, moyens_de_paiememnt, montants,  type_print) {
	var AppelAjax = new Ajax.Updater(
		"block_head",
		"caisse_encaisser_ticket.php",
		{
			parameters: {
				ref_ticket: ref_ticket,
				moyens_de_paiememnt : moyens_de_paiememnt,
				montants: montants,
				type_print : type_print
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
			}
		}
		);
}

function caisse_ajouter_moyen_de_paiement (ref_ticket, moyen_de_paiement) {
	var AppelAjax = new Ajax.Updater(
		"block_head",
		"caisse_ajouter_moyen_de_paiement.php",
		{
			parameters: {
				ref_ticket: ref_ticket,
				moyen_de_paiement : moyen_de_paiement
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
			}
		}
		);
}

function change_panneau_bas (panneau, bt_from){
	switch(panneau){
		case "historique_tickets" :{
			page.traitecontent("panneau_bas","caisse_panneau_afficher_tickets.php?lib_panneau=Historique%20des%20tickets", true ,"panneau_bas");
			if(!ticket_is_unlock){
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
			$("art_lib_s").focus();

			panneau_courant = "historique_tickets";
			break;
		}
		case "tickets_en_attente" :{
			if(panneau_courant == "tickets_en_attente"){
				change_panneau_bas("recherche_article");
			}else{
				page.traitecontent("panneau_bas","caisse_panneau_afficher_tickets.php?lib_panneau=Tickets%20en%20attente&etats_tickets=61;59", true ,"panneau_bas");
				if(!ticket_is_unlock){
					$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
					ticket_is_unlock = true;
				}
				$("tickets_en_attente").innerHTML = lib_out_afficher_tickets_en_attente;
				$("art_lib_s").focus();

				panneau_courant = "tickets_en_attente";
			}
			break;
		}
		case "recherche_client" :{
			page.traitecontent("panneau_bas","caisse_panneau_recherche_client.php", true ,"panneau_bas");
			if(!ticket_is_unlock){
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;

			panneau_courant = "recherche_client";
			break;
		}
		case "recherche_article" :{
			var art_lib_s = $F("art_lib_s");
			var select_racine_art_categs = 0;

			var AppelAjax = new Ajax.Updater(
				"panneau_bas",
				"caisse_panneau_recherche_article.php",
				{
					method		:	'post',
					asynchronous:	false,
					contentType	:	'application/x-www-form-urlencoded',
					encoding	:	'UTF-8',
					parameters	:	{
						select_racine_art_categs: select_racine_art_categs
					},
					evalScripts	:	true,
					onLoading	:	S_loading,
					onException	:	function () {
						S_failure();
					},
					onSuccess	:	function (requester){},
					onComplete	:	H_loading
				}
				);

			if(art_lib_s != ""){
				var params = "?art_lib_s="				+art_lib_s;
				params+= "&art_page_to_show_s="			+$F("art_page_to_show_s");
				params+= "&categ_racine_page_to_show_s="+$F("categ_racine_page_to_show_s");
				params+= "&categ_sous_page_to_show_s="	+$F("categ_sous_page_to_show_s");
				params+= "&ref_contact="				+$F("ref_contact");
				params+= "&ref_ticket="					+$F("ref_ticket");
				if(bt_from =! undefined && bt_from == "bt_ajouter")
					params+= "&ajout_si_article_unique=1";
				page.traitecontent("resultat_article","caisse_panneau_recherche_articles_result.php"+params, true ,"resultat_article");
			}

			if(!ticket_is_unlock){
				calculette_caisse.setCible_type_action("TICKET");
				var table = $("TICKET");
				if(table.rows.length > 1){
					calculette_caisse.setCible_id(table.rows[table.rows.length-1].id);
					caisse_select_line(table.rows[table.rows.length-1].id);
				}else{
					caisse_unselect_line();
				}
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
			$("art_lib_s").focus();

			panneau_courant = "recherche_article";
			break;
		}
		case "encaissement" :{
			var params = "?ref_contact="+$F("ref_contact");
			params+= "&ref_ticket="+$F("ref_ticket");
			page.traitecontent("panneau_bas","caisse_panneau_encaissement.php"+params, true ,"panneau_bas");
			caisse_unselect_line();
			if(ticket_is_unlock){
				calculette_caisse.setCible_type_action("ENCAISSEMENT");
				$("bt_encaisser_lib").innerHTML = lib_out_encaisser;
				ticket_is_unlock = false;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
			$("art_lib_s").focus();

			panneau_courant = "encaissement";
			break;
		}
		case "encaissement_rapide" :
			caisse_unselect_line();
			var AppelAjax = new Ajax.Updater(
				"block_head",
				"caisse_encaisser_ticket.php",
				{
					parameters: {
						ref_ticket: $F("ref_ticket"),
						moyens_de_paiememnt : "mdp_especes",
						montants: $F('caisse_total_s'),
						type_print : "print_ticket"
					},
					evalScripts:true,
					onLoading:S_loading,
					onSuccess: function (requester){
						requester.responseText.evalScripts();
						change_panneau_bas("recherche_article");
					}
				}
				);
			break;
		case "choix_point_vente" :{
			page.traitecontent("panneau_bas","caisse_panneau_choix_point_de_vente.php", true ,"panneau_bas");
			if(!ticket_is_unlock){
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
			$("art_lib_s").focus();

			panneau_courant = "choix_point_vente";
			break;
		}
		case "choix_caisse" :{
			page.traitecontent("panneau_bas","caisse_panneau_choix_caisse.php", true ,"panneau_bas");
			if(!ticket_is_unlock){
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
			$("art_lib_s").focus();

			panneau_courant = "choix_caisse";
			break;
		}
		case "ajout_caisse" :{
			page.traitecontent("panneau_bas","caisse_panneau_mouvement_caisse.php?sens_mouvement=ajout", true ,"panneau_bas");
			if(!ticket_is_unlock){
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
			$("art_lib_s").focus();

			panneau_courant = "ajout_caisse";
			break;
		}
		case "retrait_caisse" :{
			page.traitecontent("panneau_bas","caisse_panneau_mouvement_caisse.php?sens_mouvement=retrait", true ,"panneau_bas");
			if(!ticket_is_unlock){
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
			$("art_lib_s").focus();

			panneau_courant = "retrait_caisse";
			break;
		}
		default :{
			if(!ticket_is_unlock){
				$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
				ticket_is_unlock = true;
			}
			$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;

			panneau_courant = "";
			break;
		}
	}
}

function caisse_select_line(ref_line){
	caisse_unselect_line();
	calculette_caisse.setCible_id(ref_line);
	selected_line_name = ref_line;
	$(selected_line_name).className = "ticket_ligne_selected";
	$("art_lib_s").focus();
}

function caisse_unselect_line(){
	if (selected_line_name != ""){
		calculette_caisse.setCible_id("");
		caisse_unselect_col();
		$(selected_line_name).className = "ticket_ligne_unselected";
	}
	selected_line_name = "";
}

function caisse_select_col(col_name){
	caisse_unselect_col();
	selected_col_name = col_name;
	$(selected_col_name+"_"+selected_line_name).className = "ticket_cell_selected";
}

function caisse_unselect_col(){
	if (selected_line_name != "" && selected_col_name != ""){
		$(selected_col_name+"_"+selected_line_name).className = "ticket_cell_unselected";
	}
	selected_col_name = "";
}

//maj de l'etat du doc ne demandant qu'un rechargement de l'entete
function maj_etat_ticket (ref_doc, new_etat_doc, fonction_called_after_maj_etat_ticket) {
	var AppelAjax = new Ajax.Updater(
		"block_head",
		"caisse_maj_etat_ticket.php",
		{
			parameters: {
				ref_doc: ref_doc,
				new_etat_doc: new_etat_doc
			},
			evalScripts:true,
			onLoading:S_loading,
			onSuccess: function (requester){
				requester.responseText.evalScripts();
				if(fonction_called_after_maj_etat_ticket != undefined && fonction_called_after_maj_etat_ticket!= "")
					eval(fonction_called_after_maj_etat_ticket);
			}
		}
		);
}


function caisse_maj_total(new_total){
	total = new_total.replace(".",",");
	$("caisse_total").innerHTML = total;
	$("caisse_total_s").value = new_total;
}

function caisse_calculer_a_rendre(){
	var table = $("reglements_effectues");
	var motants = 0;
	for(var i = 1; i < table.rows.length; i++)
	{
		motants += Math.round(parseFloat($("MONTANT_"+i).value)*100)/100;
	}

	return Math.round((motants - Math.round(parseFloat($("caisse_total_s").value)*100)/100)*100)/100;
}

function caisse_afficher_a_rendre(){
	var reglement_a_rendre = caisse_calculer_a_rendre();
	if(reglement_a_rendre < 0){
		$("print_valider").style.opacity = (70/100);
		$("lib__reste_a_payer_OU_a_rendre").innerHTML = "RESTE A PAYER";
		$("reglement_a_rendre").innerHTML = price_format((-1)*reglement_a_rendre)+" &euro;";

	}else{
		$("print_valider").style.opacity = 1;
		$("lib__reste_a_payer_OU_a_rendre").innerHTML = "A RENDRE";
		$("reglement_a_rendre").innerHTML = price_format(reglement_a_rendre)+" &euro;";
	}
}

function caisse_reset(id_panneau_called){
	calculette_caisse.setCible_type_action("TICKET");
	caisse_unselect_line();

	$("calculette_RESULTAT").value = "0.00";

	$("ref_ticket").value = "";
	$("ref_contact").value = "";

	$("art_page_to_show_s").value = "1";
	$("categ_racine_page_to_show_s").value = "1";
	$("categ_sous_page_to_show_s").value = "1";

	$("print_s").value = "print_ticket";

	$("client_ligne1").innerHTML = 'Client non identifié';
	$("client_ligne2").innerHTML = "";
	$("client_ligne3").innerHTML = "";
	$("client_grille_tarifaire").innerHTML = lib_grille_tarifaire;

	caisse_maj_total("0.00");

	var table = $("TICKET");
	while(table.rows.length>1){
		table.removeChild(table.rows[1]);
	}
	$("tickets_en_attente").innerHTML = lib_in_afficher_tickets_en_attente;
	$("bt_encaisser_lib").innerHTML = lib_in_encaisser;
	ticket_is_unlock = true;

	if(id_panneau_called == undefined)
	{
		id_panneau_called = "recherche_article";
	}

	change_panneau_bas(id_panneau_called);
}

function caisse_suppr_ticket(ref_ticket, fonction_called_after_maj_etat_ticket){
	$("titre_alert_custom").innerHTML = "Suppression";
	$("texte_alert_custom").innerHTML = "Confirmer-vous la suppression de ce ticket ?<br/>";
	$("bouton_alert_custom").innerHTML=	'<table cellpadding="0" cellspacing="0" border="0" width="100%">'+
	'<tr>'+
	'<td width="40%" align="right">'+
	'<img id="bouton_pop_up_0" name="bouton_pop_up_0" alt="Valier"  title="Valier"  src="../interface_caisse/themes/caisse_fr/images/bt-valider.png" />'+
	'</td>'+
	'<td width="10%" >&nbsp;</td>'+
	'<td width="40%" align="left">'+
	'<img id="bouton_pop_up_1" name="bouton_pop_up_1" alt="Annuler" title="Annuler" src="../interface_caisse/themes/caisse_fr/images/bt-annuler.png" />'+
	'</td>'+
	'</tr>'+
	'</table>';

	$("framealert").style.display = "block";
	$("alert_pop_up").style.display = "block";
	$("alert_pop_up_tab_custom").style.display = "block";

	Event.observe("bouton_pop_up_0", "click", function() {
		maj_etat_ticket(ref_ticket, "60", fonction_called_after_maj_etat_ticket); // ID_ETAT_ANNULE = 60
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab_custom").style.display = "none";
	}, false);

	Event.observe("bouton_pop_up_1", "click", function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab_custom").style.display = "none";
	}, false);
}

function addLineInfo(ref_ticket, options){
	var options = Object.extend({
		urlTo		: "caisse_ajouter_infos.php",
		onValid		: Prototype.emptyFunction,
		afterFinish	: Prototype.emptyFunction,
		onCancel	: Prototype.emptyFunction,
		onClose		: Prototype.emptyFunction
	}, options || {});
	$("titre_alert_custom").innerHTML = "Ajouter une ligne d'information";
	$("texte_alert_custom").innerHTML = "";
	var input = new Element('input', {name:'infosTitre', id:'infosAddLinePopup'});
	input.setStyle({width:'390px'}) ;
//	var textarea = new Element('textarea', {name:'infosText', id:'infosTextAddLinePopup', rows:4, cols:47});
	$("texte_alert_custom").insert(input);

	$("bouton_alert_custom").innerHTML=	'<table cellpadding="0" cellspacing="0" border="0" width="100%">'+
	'<tr>'+
	'<td width="40%" align="right">'+
	'<img id="bouton_pop_up_0" name="bouton_pop_up_0" alt="Valier"  title="Valier"  src="../interface_caisse/themes/caisse_fr/images/bt-valider.png" />'+
	'</td>'+
	'<td width="10%" >&nbsp;</td>'+
	'<td width="40%" align="left">'+
	'<img id="bouton_pop_up_1" name="bouton_pop_up_1" alt="Annuler" title="Annuler" src="../interface_caisse/themes/caisse_fr/images/bt-annuler.png" />'+
	'</td>'+
	'</tr>'+
	'</table>';

	$("framealert").style.display = "block";
	$("alert_pop_up").style.display = "block";
	$("alert_pop_up_tab_custom").style.display = "block";
	input.focus();
	var submit_formInfos = function(evt) {
		evt.stop();
		if($F('infosAddLinePopup').length < 1)
			return ;
		if(options.onValid(ref_ticket, $F('infosAddLinePopup')) === false)
			return ;
		new Ajax.Request(options.urlTo, {
			method: 'post',
			evalScripts:true,
			onLoading:S_loading,
			parameters : {ref_ticket : ref_ticket, infos : escape($F('infosAddLinePopup'))},
			onComplete : function(xhr){
				xhr.responseText.evalScripts();
				if(options.afterFinish(xhr.responseText) === false)
					return ;
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab_custom").style.display = "none";
				H_loading();
			}
		});
	}
	input.observe('keyup', function(evt){
		if(evt.keyCode == 13)
			submit_formInfos(evt);
	});
	Event.observe("bouton_pop_up_0", "click", submit_formInfos, false);

	Event.observe("bouton_pop_up_1", "click", function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab_custom").style.display = "none";
		$("texte_alert_custom").innerHTML = "";
		$("bouton_alert_custom").innerHTML = "";
	}, false);
}


function script_called_after_maj_etat_ticket_from_acceuil(){
	caisse_reset("recherche_article");
	H_loading();
}

function script_called_after_maj_etat_60_from_afficher_ticket(rafraichir_accueil){
	if(rafraichir_accueil)
	{
		caisse_reset("tickets_en_attente");
	}
	else{
		change_panneau_bas("tickets_en_attente");
	}
	H_loading();
}

function script_called_after_maj_etat_61_from_afficher_ticket(ref_doc){
	caisse_reset("recherche_article");
	caisse_charger_ticket(ref_doc);
	H_loading();
}

function ajouterArticleTicket(suffixe, monaie, cell_LIB, cell_QTE, cell_PUTTC, cell_REMISE, cell_PRIXTTC){
	var tr = document.createElement("tr");
	tr.setAttribute ("id", suffixe);
	$("TICKET").appendChild(tr);

	tr.appendChild(document.createElement("td"));

	var td = document.createElement("td");
	td.setAttribute ("id", "LIB_"+suffixe);
	td.style.textAlign = "left";
	tr.appendChild(td);

	td = document.createElement("td");
	td.setAttribute ("id", "QTE_"+suffixe);
	td.style.textAlign = "right";
	tr.appendChild(td);

	td = document.createElement("td");
	td.setAttribute ("id", "PUTTC_"+suffixe);
	td.style.textAlign = "right";
	tr.appendChild(td);

	td = document.createElement("td");
	td.setAttribute ("id", "REMISE_"+suffixe);
	td.style.textAlign = "right";
	tr.appendChild(td);

	td = document.createElement("td");
	td.setAttribute ("id", "PRIXTTC_"+suffixe);
	td.style.textAlign = "right";
	tr.appendChild(td);

	tr.appendChild(document.createElement("td"));

	$("LIB_"+suffixe).innerHTML = cell_LIB;
	$("QTE_"+suffixe).innerHTML = cell_QTE;
	$("PUTTC_"+suffixe).innerHTML = cell_PUTTC + "&nbsp;"+monaie;
	$("REMISE_"+suffixe).innerHTML = cell_REMISE;
	$("PRIXTTC_"+suffixe).innerHTML = cell_PRIXTTC + "&nbsp;"+monaie;

	caisse_select_line(suffixe);

	$("conteneur_TICKET").scrollTop = $("conteneur_TICKET").offsetHeight;

	Event.observe(suffixe, "click", function(evt){
		Event.stop(evt);
		if(ticket_is_unlock){
			caisse_select_line(suffixe);
		}
	}, false);
}

function ajouterInfosTicket(ref_doc_line, titre, text){
	var tr = new Element("tr", {id:ref_doc_line});
	$("TICKET").insert(tr);
	tr.insert(new Element("td"));

	var td = new Element("td", {id:"LIB_"+ref_doc_line});
	td.setStyle({textAlign:"left"});
	td.writeAttribute({colspan:5});

	tr.insert(td);
	tr.insert(new Element("td"));

	$("LIB_"+ref_doc_line).innerHTML = titre;

	caisse_select_line(ref_doc_line);

	$("conteneur_TICKET").scrollTop = $("conteneur_TICKET").offsetHeight;

	Event.observe(ref_doc_line, "click", function(evt){
		Event.stop(evt);
		if(ticket_is_unlock){
			caisse_select_line(ref_doc_line);
		}
	}, false);
}

function ajouterReglement(suffixe, monaie, mdp_lib, mdp, motant){
	var table = $("reglements_effectues");
	//var trl = table.rows.length + 0;

	var cell_LIB_MOYEN = mdp_lib + "<input type='hidden' id='MDP_"+suffixe+"' name='MDP_"+suffixe+"' value='"+mdp+"'/>";
	var cell_MONTANT =  "<input type='texte' id='MONTANT_"+suffixe+"' name='MONTANT_"+suffixe+"' value='"+motant+"' style='width:98px;' />";
	var cell_MONAIE = "&nbsp;"+monaie;

	var tr = document.createElement("tr");
	tr.setAttribute ("id", "TR_REG_"+suffixe);

	table.appendChild(tr);

	var td = document.createElement("td");
	tr.appendChild(td);

	var TD_REG1 = document.createElement("td");
	TD_REG1.setAttribute ("id", "TD_REG1_"+suffixe);
	TD_REG1.className = "panneau_encaissement_ligne_reglement_effectue_LIB";
	tr.appendChild(TD_REG1);

	var TD_REG2 = document.createElement("td");
	TD_REG2.setAttribute ("id", "TD_REG2_"+suffixe);
	TD_REG2.className = "panneau_encaissement_ligne_reglement_effectue_MONTANT";
	tr.appendChild(TD_REG2);

	var TD_REG3 = document.createElement("td");
	TD_REG2.setAttribute ("id", "TD_REG3_"+suffixe);
	TD_REG3.className = "panneau_encaissement_ligne_reglement_effectue_MONAIE";
	tr.appendChild(TD_REG3);

	$(TD_REG1).innerHTML = cell_LIB_MOYEN;
	$(TD_REG2).innerHTML = cell_MONTANT;
	$(TD_REG3).innerHTML = cell_MONAIE;

	if(cible_id_MONTANT != ""){
		$(cible_id_MONTANT).className = "panneau_encaissement_ligne_reglement_effectue_MONTANT";
	}

	caisse_afficher_a_rendre();

	Event.observe("MONTANT_"+suffixe, "click", function(evt){
		Event.stop(evt);
		calculette_caisse.setCible_action("MOYENS_DE_PAIEMENT");
		calculette_caisse.setCible_id("MONTANT_"+suffixe);

		if(cible_id_MONTANT != "")
		{
			$(cible_id_MONTANT).className = "panneau_encaissement_ligne_reglement_effectue_MONTANT";
			$(cible_id_MONTANT).value = price_format(parseFloat($(cible_id_MONTANT).value));
			cible_id_MONTANT = "";
			caisse_afficher_a_rendre();
		}
		cible_id_MONTANT = "MONTANT_"+suffixe;
		$(cible_id_MONTANT).className = "panneau_encaissement_ligne_reglement_effectue_MONTANT_selected";
	}, false);

	Event.observe("MONTANT_"+suffixe, "keypress", function(evt){
		var key = evt.which || evt.keyCode;
		if(key == Event.KEY_RETURN){
			$("MONTANT_"+suffixe).className = "panneau_encaissement_ligne_reglement_effectue_MONTANT";
			cible_id_MONTANT = "";
			$("MONTANT_"+suffixe).value = price_format(parseFloat($("MONTANT_"+suffixe).value));
			caisse_afficher_a_rendre();
			Event.stop(evt);
		}
	}, false);
}


function setTicket_cell_LIB(suffixe, lib){
	$("LIB_"+suffixe).innerHTML = lib;
}

function setTicket_cell_QTE(suffixe, qte){
	$("QTE_"+suffixe).innerHTML = parseFloat(qte);
}

function setTicket_cell_PUTTC(suffixe, monaie, pu_ttc){
	$("PUTTC_"+suffixe).innerHTML = price_format(pu_ttc) + "&nbsp;" + monaie;
}

function setTicket_cell_REMISE(suffixe, remise){
	$("REMISE_"+suffixe).innerHTML = price_format(remise);
}

function setTicket_cell_PRIXTTC(suffixe,  monaie, prix_ttc){
	$("PRIXTTC_"+suffixe).innerHTML = price_format(prix_ttc) + "&nbsp;" + monaie;
}

function majClient(ref_contact, client_ligne1, client_ligne2){

	$("ref_contact").value = "<?php echo $document->getRef_contact();?>";
	$("client_ligne1").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne1));?>";
	$("client_ligne2").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne2));?>";
	$("client_ligne3").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne3));?>";
	$("client_grille_tarifaire").innerHTML = "<?php echo $lib_grille_tarrifaire;?>";
}


