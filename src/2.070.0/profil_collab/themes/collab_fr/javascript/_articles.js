//********************************************************************
// LIAISON ENTRE ARTICLES										DEBUT*
//********************************************************************


//Fonction à ne pas utilser directement, mais par :
// - construire_ligne_liaison_article_creation
// - construire_ligne_liaison_article_edition
// - construire_ligne_liaison_article_duplication
//private construire_ligne_liaison_article(int	   , string	  	 	 , string	  	 , string	  	, int			 , string	  , int)
function  construire_ligne_liaison_article(num_serie, direction_liaison, ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio){
	var zone= $("liaison_ul_"+id_liaison_type+"_"+direction_liaison);
	var addli= document.createElement("li");
		addli.setAttribute ("id", "liaison_li_"+num_serie);
	zone.appendChild(addli);
	
	var divli= document.createElement("div");
	divli.setAttribute ("id", "liaison_div_"+num_serie);

	$("liaison_li_"+num_serie).appendChild(divli);
	
	var html_content="" +
		"<table width='100%'>"+
			"<tr>"+
				"<td width='40%'>"+
					"<a href='#' id='link_to_article_"+ num_serie +"' style='text-decoration:none'>"+ ref_article_B +"</a>" +
				"</td>"+
				"<td width='40%'>"+
					lib_article +
				"</td>"+
				"<td width='15%'>";
	if(direction_liaison == "vers"){
		html_content += "1 pour&nbsp;"+
						"<input type='text' id='ratio_"+ num_serie +"' name='ratio_"+ num_serie +"' value='"+ ratio +"'  class='classinput' size='5' />" +
						"<input type='hidden' id='ref_article_A_"+num_serie+"' name='ref_article_A_"+num_serie+"' value='"+ ref_article_B +"' />" +
						"<input type='hidden' id='ref_article_B_"+num_serie+"' name='ref_article_B_"+num_serie+"' value='"+ ref_article_A +"' />" +
						"<input type='hidden' id='id_liaison_type_"+num_serie+"' name='id_liaison_type_"+num_serie+"' value='"+ id_liaison_type +"' />" +
						"<input type='hidden' id='old_ratio_"+num_serie+"' name='old_ratio_"+num_serie+"' value='"+ ratio +"' />";
	
	}else{
		html_content += "<input type='text' id='ratio_"+ num_serie +"' name='ratio_"+ num_serie +"' value='"+ ratio +"'  class='classinput' size='5' />" +
						"&nbsp;pour 1"+
						"<input type='hidden' id='ref_article_A_"+num_serie+"' name='ref_article_A_"+num_serie+"' value='"+ ref_article_A +"' />" +
						"<input type='hidden' id='ref_article_B_"+num_serie+"' name='ref_article_B_"+num_serie+"' value='"+ ref_article_B +"' />" +
						"<input type='hidden' id='id_liaison_type_"+num_serie+"' name='id_liaison_type_"+num_serie+"' value='"+ id_liaison_type +"' />" +
						"<input type='hidden' id='old_ratio_"+num_serie+"' name='old_ratio_"+num_serie+"' value='"+ ratio +"' />";
	}
	html_content+=""+	
				"</td>"+
				"<td width='5%'>"+
					"<img id='liaison_img_del_"+num_serie+"' src='"+dirtheme+"images/supprime.gif' />"+
				"</td>"+
			"</tr>"+
		"</table>";
	
	$("liaison_div_"+num_serie).innerHTML=html_content;
	$('serialisation_liaison').value = parseInt(num_serie)+1;
	
	$("ligne_"+id_liaison_type+"_"+direction_liaison).show();
}


//public construire_ligne_liaison_article_creation(int	   , string	  	 	 , string	  	 , string	  	, int			 , string	  , int)
function construire_ligne_liaison_article_creation(num_serie, direction_liaison, ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio){
	construire_ligne_liaison_article(num_serie, direction_liaison, ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);
	
	Event.observe("link_to_article_"+num_serie, "click",  function(evt){
		Event.stop(evt);
		page.verify("catalogue_articles_view","index.php#"+escape("catalogue_articles_view.php?ref_article="+ref_article_B),"true","_blank");
	}, false);
	
	Event.observe($("liaison_img_del_"+num_serie) , "click", function(){
		alerte.confirm_supprimer_tag ( "liaison_art_del", "liaison_li_"+num_serie);
	}, false);
}

//public construire_ligne_liaison_article_edition(int	   , string	  	 	 , string	  	 , string	  	, int			 , string	  , int)
function construire_ligne_liaison_article_view(num_serie, direction_liaison, ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio){
	construire_ligne_liaison_article(num_serie, direction_liaison, ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);

	Event.observe("ratio_"+ num_serie, "blur",  function(evt){
		Event.stop(evt);
		if(direction_liaison == "vers"){
			var AppelAjax = new Ajax.Request(
					"catalogue_articles_edition_liaison_maj.php", {
					parameters	: {ref_article_A: ref_article_A, ref_article_B: ref_article_B, id_liaison_type: id_liaison_type, ratio: $("ratio_"+ num_serie).value},
					evalScripts	: true, 
					onLoading	: S_loading, 
					onException	: function () {S_failure();},
					onSuccess	: function (requester){
									requester.responseText.evalScripts();
									H_loading();}
					});
		}else{// direction_liaison == "depuis"
			var AppelAjax = new Ajax.Request(
					"catalogue_articles_edition_liaison_maj.php", {
					parameters	: {ref_article_A: ref_article_B, ref_article_B: ref_article_A, id_liaison_type: id_liaison_type, ratio: $("ratio_"+ num_serie).value},
					evalScripts	: true, 
					onLoading	: S_loading, 
					onException	: function () {S_failure();},
					onSuccess	: function (requester){
									requester.responseText.evalScripts();
									H_loading();}
					});
		}
	}, false);
	
	Event.observe("link_to_article_"+num_serie, "click",  function(evt){
		Event.stop(evt);
		page.verify("catalogue_articles_view","index.php#"+escape("catalogue_articles_view.php?ref_article="+ref_article_B),"true","_blank");
	}, false);
	
	Event.observe($("liaison_img_del_"+num_serie) , "click", function(){
		alerte.confirm_supprimer_tag_and_callpage ( "liaison_art_del", "liaison_li_"+num_serie,
				"catalogue_articles_edition_liaison_supp.php?ref_article_A="+ref_article_A+
				"&ref_article_B="+ref_article_B+
				"&id_liaison_type="+id_liaison_type);
	}, false);
}


//public construire_ligne_liaison_article_duplication(int	   , string	  	 	 , string	  	 , string	  	, int			 , string	  , int)
function construire_ligne_liaison_article_duplication(num_serie, direction_liaison, ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio){
	construire_ligne_liaison_article(num_serie, direction_liaison, ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);
	
	Event.observe("link_to_article_"+num_serie, "click",  function(evt){
		Event.stop(evt);
		page.verify("catalogue_articles_view","index.php#"+escape("catalogue_articles_view.php?ref_article="+ref_article_B),"true","_blank");
	}, false);
	
	Event.observe($("liaison_img_del_"+num_serie) , "click", function(){
		alerte.confirm_supprimer_tag ( "liaison_art_del", "liaison_li_"+num_serie);
	}, false);
}


//public link_article_to_article_creation_vers(int		, int			 , string		, string	   , string		, int)
function link_article_to_article_creation_vers(num_serie, id_liaison_type, ref_article_A, ref_article_B, lib_article, ratio) {
	construire_ligne_liaison_article_creation(num_serie, "vers", ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);
}

//public link_article_to_article_creation_depuis(int	  , int			   , string		 , string	  	, string	 , int)
function link_article_to_article_creation_depuis(num_serie, id_liaison_type, ref_article_A, ref_article_B, lib_article, ratio) {
	construire_ligne_liaison_article_creation(num_serie, "depuis", ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);
}

//public link_article_to_article_duplication_vers(int	   , int			, string	   , string	 	  , string	   , int)
function link_article_to_article_duplication_vers(num_serie, id_liaison_type, ref_article_A, ref_article_B, lib_article, ratio) {
	construire_ligne_liaison_article_duplication(num_serie, "vers", ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);			
}

//public link_article_to_article_duplication_depuis(int		 , int			  , string		 , string		, string	 , int)
function link_article_to_article_duplication_depuis(num_serie, id_liaison_type, ref_article_A, ref_article_B, lib_article, ratio) {
	construire_ligne_liaison_article_duplication(num_serie, "depuis", ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);
}

//public link_article_to_article_edition_vers(int	   , int			, string	   , string	 	  , string	   , int)
function link_article_to_article_view_vers(num_serie, id_liaison_type, ref_article_A, ref_article_B, lib_article, ratio) {
	var AppelAjax = new Ajax.Request(
			"catalogue_articles_edition_liaison_add.php", {
			parameters	: {ref_article_A: ref_article_A, ref_article_B: ref_article_B, id_liaison_type: id_liaison_type, ratio: ratio},
			evalScripts	: true, 
			onLoading	: S_loading, 
			onException	: function () {S_failure();},
			onSuccess	: function (requester){
							requester.responseText.evalScripts();
							construire_ligne_liaison_article_view(num_serie, "vers", ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);			
							H_loading();}
			});
}

//public link_article_to_article_edition_depuis(int		 , int			  , string		 , string		, string	 , int)
function link_article_to_article_view_depuis(num_serie, id_liaison_type, ref_article_A, ref_article_B, lib_article, ratio) {
	var AppelAjax = new Ajax.Request(
			"catalogue_articles_edition_liaison_add.php", {
			parameters	: {ref_article_A: ref_article_B, ref_article_B: ref_article_A, id_liaison_type: id_liaison_type, ratio: ratio},
			evalScripts	: true, 
			onLoading	: S_loading, 
			onException	: function () {S_failure();},
			onSuccess	: function (requester){
							requester.responseText.evalScripts();
							construire_ligne_liaison_article_view(num_serie, "depuis", ref_article_A, ref_article_B, id_liaison_type, lib_article, ratio);			
							H_loading();}
			});
}

//public recherche_article_set_article(string		 , string		 , string	  , string)
function recherche_article_set_article(id_ref_article, id_lib_article, ref_article, lib_article) {
	$(id_ref_article).value = ref_article;
	$(id_lib_article).value = lib_article;
	close_mini_moteur_cata();
}

//********************************************************************
//LIAISON ENTRE ARTICLES										  FIN*
//********************************************************************


//**********************************************************************
//ajout de composants pour les articles en création

function art_add_composant(niveau, serie_comp, id_article, lib_article, valo_indice) {


	$('serialisation_composant').value= parseInt($('serialisation_composant').value)+1;
	appel_li_composant( niveau, serie_comp, id_article, lib_article, valo_indice);
	close_mini_moteur_cata();


	if (niveau==$("serialisation_niveau_composant").value) {
	$("serialisation_niveau_composant").value=parseInt($("serialisation_niveau_composant").value)+1;
	$('serialisation_composant').value= parseInt($('serialisation_composant').value)+1;
	appel_table_composant();
	}


}

//insertion du niveau
function appel_table_composant() {
		var AppelAjax = new Ajax.Updater(
																	'composant_ul',
																	'catalogue_articles_composant.php?niveau='+$("serialisation_niveau_composant").value+"&serie_composant="+$('serialisation_composant').value,
																	{
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete:function() {
																							H_loading();
																							},
																	insertion: Insertion.Bottom
																	}
																	);
}

//insertion du composant dans la liste
function appel_li_composant(niveau, serie_comp, id_article, lib_article, valo_indice) {
	var typeInsertion	=	 Insertion.After;
	cibleInsertion	=	'composant_li_'+serie_comp;
	if (niveau=="1") {
	typeInsertion	=	 Insertion.Top;
	cibleInsertion	=	'composant_ul';
	}
		var AppelAjax = new Ajax.Updater(
																	cibleInsertion,
																	'catalogue_articles_composant_li.php?niveau='+niveau+"&serie_composant="+$('serialisation_composant').value,
																	{
																	parameters: {ref_article: id_article, lib_article: lib_article, valo_indice: valo_indice },
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function() {
																							H_loading();
																							Sortable.create('composant_ul',{dropOnEmpty:true, ghosting:true,scroll:'lot_info', handle: 'composant_li_lib_handle'});
																							},
																	insertion: typeInsertion
																	}
																	);
}


//******************************************************
//ajout de composants pour les articles en édition

function art_edition_add_composant(niveau, serie_comp, id_article, lib_article, valo_indice) {

	$('serialisation_composant').value= parseInt($('serialisation_composant').value)+1;
	appel_edition_li_composant( niveau, serie_comp, id_article, lib_article, valo_indice);
	close_mini_moteur_cata();


	if (niveau==$("serialisation_niveau_composant").value) {
	$("serialisation_niveau_composant").value=parseInt($("serialisation_niveau_composant").value)+1;
	$('serialisation_composant').value= parseInt($('serialisation_composant').value)+1;
	appel_edition_table_composant();
	}


}

//insertion du niveau
function appel_edition_table_composant() {
		var AppelAjax = new Ajax.Updater(
																	'composant_ul',
																	'catalogue_articles_edition_composant.php?niveau='+$("serialisation_niveau_composant").value+"&serie_composant="+$('serialisation_composant').value,
																	{
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete:function() {
																							H_loading();
																							},
																	insertion: Insertion.Bottom
																	}
																	);
}

//insertion du composant dans la liste
function appel_edition_li_composant(niveau, serie_comp, id_article, lib_article, valo_indice) {
	var typeInsertion	=	 Insertion.After;
	cibleInsertion	=	'composant_li_'+serie_comp;
	if (niveau=="1") {
	typeInsertion	=	 Insertion.Top;
	cibleInsertion	=	'composant_ul';
	}
		var AppelAjax = new Ajax.Updater(
																	cibleInsertion,
																	'catalogue_articles_edition_composant_li.php?niveau='+niveau+"&serie_composant="+$('serialisation_composant').value,
																	{
																	parameters: {ref_article: id_article, lib_article: lib_article, valo_indice: valo_indice, ref_article_parent: $("ref_article").value },
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function() {
																							H_loading();
																							Sortable.create('composant_ul',{dropOnEmpty:true, ghosting:true,scroll:'lot_info', handle: 'composant_li_lib_handle'});
																							},
																	insertion: typeInsertion
																	}
																	);
}




function verif_composant_valo (evt, valo_id) {
var array_num=new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var temp_result	= "";
	var firstdot= false;
	for( i=0; i < u_field_num.length; i++ ) {
		if ((!isNaN(u_field_num[i]) || u_field_num[i]=="," || u_field_num[i]==".") && u_field_num[i]!=" "){
			if ((u_field_num[i]=="," || u_field_num[i]==".") && firstdot==false) {
			array_num.push(".");
			firstdot=true;
			} else {
  	 	array_num.push(u_field_num[i]);
		 }
		}
	}
temp_result = array_num.toString().replace(/,/g,"");
	if (temp_result/$(valo_id).value==(temp_result/$(valo_id).value)) {
 	$(id_field.id).value=temp_result;
	} else  {
 	$(id_field.id).value=$(valo_id).value;
	}
	if ($(id_field.id).value=="") {
 	$(id_field.id).value=$(valo_id).value;
	}
}

//***********************************************************************
//fonctions de gestion de l'affichage des fenetre de contenu de la création/modification d'un article
//**************************************************************************

//fonction de mise à hauteur des contenu pour la création d'un article

function setheight_article_create(){
	for (key in chemin) {
		if (chemin[key][6] && $(chemin[key][4])) {
			set_tomax_height(chemin[key][4]+"_under", -52);
			set_tomax_height(chemin[key][4], -46);
			//on remet à la bonne largeur en même temps à y etre
			$(chemin[key][4]).style.width =	(return_width_element("titre_crea_art")-3)+"px";
		}
	}
	// mise à la même largeur pour la liste que le select
	if ($("liste_de_categorie_selectable")) {
	//$("liste_de_categorie_selectable").style.width=	return_width_element("lib_art_categ_link_select")+"px";
	//$("iframe_liste_de_categorie_selectable").style.width=	return_width_element("lib_art_categ_link_select")+"px";
	}
}



//fonction de mise à hauteur des contenu pourla modification d'un article

function setheight_article_edit(){
	for (key in chemin) {
		if (chemin[key][6] && $(chemin[key][4])) {
			set_tomax_height(chemin[key][4]+"_under", -52);
			set_tomax_height(chemin[key][4], -46);
			//on remet à la bonne largeur en même temps à y etre
			$(chemin[key][4]).style.width =	(return_width_element("titre_crea_art")-3)+"px";
		}
	}
}



//fonction d'évolution de l'avancée étape par étape
function allow_chemin_etape (id_etape) {
	if (chemin[id_etape][6]) {
		$("chemin_etape_"+chemin[id_etape][0]).className="chemin_fleche_gris";
		$("chemin_etape_"+chemin[id_etape][1]).className="chemin_fleche_gris";
		$("chemin_etape_"+chemin[id_etape][2]).className="chemin_numero_gris";
		$("chemin_etape_"+chemin[id_etape][3]).className="chemin_texte_gris";
		chemin[id_etape][5]="allowed";
	}
}
function allow_chemin_etape_passed (id_etape) {
	if (chemin[id_etape][6]) {
		$("chemin_etape_"+chemin[id_etape][0]).className="chemin_fleche_choisi";
		$("chemin_etape_"+chemin[id_etape][1]).className="chemin_fleche_choisi";
		$("chemin_etape_"+chemin[id_etape][2]).className="chemin_numero_gris";
		$("chemin_etape_"+chemin[id_etape][3]).className="chemin_texte_gris";
		chemin[id_etape][5]="allowed";
	}
}
function notallow_chemin_etape (id_etape) {
		$("chemin_etape_"+chemin[id_etape][0]).className="chemin_fleche_grisse";
		$("chemin_etape_"+chemin[id_etape][1]).className="chemin_fleche_grisse";
		$("chemin_etape_"+chemin[id_etape][2]).className="chemin_numero_grisse";
		$("chemin_etape_"+chemin[id_etape][3]).className="chemin_texte_grisse";
		chemin[id_etape][5]="notallowed";
}
function choix_chemin_etape (id_etape) {
	if (chemin[id_etape][6]) {
		$("chemin_etape_"+chemin[id_etape][0]).className="chemin_fleche_choisi";
		$("chemin_etape_"+chemin[id_etape][1]).className="chemin_fleche_choisi_arrow";
		$("chemin_etape_"+chemin[id_etape][2]).className="chemin_numero_choisi";
		$("chemin_etape_"+chemin[id_etape][3]).className="chemin_texte_choisi";
		chemin[id_etape][5]="allowed";
	}
}

function goto_etape (id_etape) {
if (parseInt(id_etape)<=parseInt(chemin.length-1)) {
	if (chemin[id_etape][5]=="allowed") {
		for (key in chemin) {
			if (chemin[key][6]) {
				if (key<id_etape) {
					allow_chemin_etape_passed(key);
					$(chemin[key][4]).style.display="none";
				} else if (key>id_etape) {
					allow_chemin_etape(key);
					$(chemin[key][4]).style.display="none";
				}
			}
		}
		choix_chemin_etape (id_etape);
		$(chemin[id_etape][4]).style.display="block";
		if ($("create_article")=="1") {
		setheight_article_create();
		} else {
		setheight_article_edit();
		}
	} else {
	goto_etape (id_etape+1);
	}
}
}

// fin de gestion pour la création d'un article

//modification de la catégorie d'un article
// fonction ferme moteur
function close_edition_art_categ() {
	$('pop_up_edition_art_categ_iframe').hide();
	$('pop_up_edition_art_categ').hide();
}

//fonction de retour du choix
function show_edition_art_categ () {
	$('pop_up_edition_art_categ_iframe').style.display='block';
	$('pop_up_edition_art_categ').style.display='block';

}

//modification des caracs
//fonction de retour du choix
function stop_view_categ_carac () {
	$('pop_up_view_categ_carac_iframe').hide();
	$('pop_up_view_categ_carac').hide();

}
//fonction de retour du choix
function show_view_categ_carac () {
	$('pop_up_view_categ_carac_iframe').style.display='block';
	$('pop_up_view_categ_carac').style.display='block';

}

//
//fonction de mise à jour da l'alerte stock d'un article

function maj_stock_alerte (ref_article, id_stock, new_stock) {
	var AppelAjax = new Ajax.Request(
								"catalogue_edition_maj_alerte_stock.php",
								{
								parameters: {ref_article: ref_article, id_stock: id_stock, new_stock : new_stock },
								evalScripts:true,
								onLoading:S_loading, onException: function () {S_failure();},
								onComplete: function() {
														H_loading();
														}
								}
								);
}

function maj_emplacement_stock (ref_article, id_stock, new_emplacement) {
	var AppelAjax = new Ajax.Request(
								"catalogue_edition_maj_emplacement_stock.php",
								{
								parameters: {ref_article: ref_article, id_stock: id_stock, new_emplacement : new_emplacement },
								evalScripts:true,
								onLoading:S_loading, onException: function () {S_failure();},
								onComplete: function() {
														H_loading();
														}
								}
								);
}

//met un article en fin de sipo ou archive si plus en stock
function fin_dispo (ref_article, id_ligne) {
	var AppelAjax = new Ajax.Request(
									"catalogue_articles_stop_article.php",
									{
									parameters: {ref_article: ref_article, id_ligne:id_ligne},
									evalScripts:true,
									onLoading:S_loading,
									onSuccess: function (requester){
															H_loading();
									requester.responseText.evalScripts();
									}
									}
									);
}
//met un article en fin de sipo ou archive si plus en stock depuis la visualisation d'un article
function fin_dispo_va (ref_article, id_tag) {
	var AppelAjax = new Ajax.Request(
									"catalogue_articles_stop_article.php",
									{
									parameters: {ref_article: ref_article, id_tag:id_tag},
									evalScripts:true,
									onLoading:S_loading,
									onSuccess: function (requester){
															H_loading();
									requester.responseText.evalScripts();
									}
									}
									);
}


//fonction de calcul de marge d'une cellule de grille tarifaire

function calcul_tarif_cell_marge(num_ligne_tarif, num_ligne_qte){

	var prix_public_ht	=	 $("prix_public_ht").value.replace("," , ".");
	var taxation_pp	=	$("taxation_pp_ht").checked;
	var pp=0;

	var prix_achat_ht	=	$("prix_achat_ht").value.replace("," , ".");
	var taxation_pa	=	$("taxation_pa_ht").checked;
	var pa=0;

	var tarif_tva	=	$("tarif_tva").value;

	if (isNaN(prix_public_ht)) {
	}	else {
		if (taxation_pp) {
			pp = prix_public_ht;
		} else {
			pp =	prix_public_ht / (1+tarif_tva/100);
		}
	}

	if (isNaN(prix_achat_ht) || prix_achat_ht == "0" || prix_achat_ht == "0.00" || $("prix_achat_ht").up('span').style.display == "none") {
		prix_achat_ht	=	$("paa_ht").value.replace("," , ".");
		taxation_pa	=	$("taxation_paa_ht").checked;
		if (taxation_pa) {
			pa = prix_achat_ht;
		} else {
			pa =	prix_achat_ht / (1+tarif_tva/100);
		}
	}	else {
		if (taxation_pa) {
			pa = prix_achat_ht;
		} else {
			pa =	prix_achat_ht / (1+tarif_tva/100);
		}
	}



						var AppelAjax = new Ajax.Request(
																			"catalogue_articles_tarifs_marges.php",
																			{
																			parameters: {formule:escape($("formule_tarif_"+num_ligne_tarif+"_"+num_ligne_qte).value), qte:escape($("qte_tarif_"+num_ligne_qte).value), div_cible :"show_info_marge_"+num_ligne_tarif+"_"+num_ligne_qte , prix_a: pa, prix_p: pp, tva:tarif_tva },
																			evalScripts:true,
																			onLoading:S_loading,
																			onSuccess: function (requester){
																			requester.responseText.evalScripts();
																			//	alert (requester.responseText.truncate(1500));
																			}
																			}
																			);
}



//fusion d'articles

function art_edition_fusion_choix(second_ref_article, ref_article ) {


		$("titre_alert").innerHTML = "Confirmer la fusion des articles";
		$("texte_alert").innerHTML = "Confirmer la fusion des deux articles<br /> Les documents et quantités en stock de l'article en cours seront ré-attribués à l'article choisi";
		$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';

		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";

		$("bouton0").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		}
		$("bouton1").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		art_edition_fusion (second_ref_article, ref_article );
		}
}

function art_edition_fusion (second_ref_article, ref_article ) {
			var AppelAjax = new Ajax.Request(
																	'catalogue_articles_fusion.php',
																	{
																	parameters: {ref_article: ref_article, second_ref_article: second_ref_article},
																	evalScripts:true,
																	onLoading:S_loading,
																	onSuccess: function (requester){
																			H_loading();
																			requester.responseText.evalScripts();
																			}
																	}
																	);
}




//maj prix_achat_ht
function maj_pa_ht (ref_article, pa_ht, id_line) {
	var AppelAjax = new Ajax.Request(
									"catalogue_articles_maj_pa.php",
									{
									parameters: {ref_article: ref_article, pa_ht: pa_ht, id_line: id_line },
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
									}
									}
									);
}


//insertion d'une ligne d'ajout d'image à la création d'un article
function insert_new_line_image(id_zone) {

	var num_serie	=	$('increment_images').value;
	var zone= $(id_zone);
	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "span_img_file_"+num_serie);
	var addspansep= document.createElement("span");
		addspansep.setAttribute ("id", "span_img_sep_"+num_serie);
	var addspan2= document.createElement("span");
		addspan2.setAttribute ("id", "span_img_url_"+num_serie);
	var inputfile= document.createElement("input");
		inputfile.setAttribute ("id", "image_"+num_serie);
		inputfile.setAttribute ("name", "image_"+num_serie);
		inputfile.setAttribute ("type", "file");
		inputfile.setAttribute ("size", "35");
	var inputurl= document.createElement("input");
		inputurl.setAttribute ("id", "url_img_"+num_serie);
		inputurl.setAttribute ("name", "url_img_"+num_serie);
		inputurl.setAttribute ("type", "text");
		inputurl.setAttribute ("value", "");
		inputurl.setAttribute ("size", "35");
	var div= document.createElement("div");
		div.setAttribute ("id", "div_img_"+num_serie);


	zone.appendChild(addspan);
	$("span_img_file_"+num_serie).setStyle({   width: '50%' });
	$("span_img_file_"+num_serie).appendChild(inputfile);
	zone.appendChild(addspansep);
	$("span_img_sep_"+num_serie).setStyle({   width: '5%' });
	$("span_img_sep_"+num_serie).innerHTML = "&nbsp;";
	zone.appendChild(addspan2);
	$("span_img_url_"+num_serie).setStyle({   width: '45%' });
	$("span_img_url_"+num_serie).appendChild(inputurl);
	zone.appendChild(div);
	$("div_img_"+num_serie).innerHTML = "&nbsp;";

}


//mise à jour de la description d'article seule.

function maj_article_description  (id_info_content, ref_article) {
	var AppelAjax = new Ajax.Request(
									"catalogue_articles_view_description_edit_valid.php",
									{
									parameters: {ref_article: ref_article, info_content : escape($(id_info_content).value) },
									evalScripts:true,
									onLoading:S_loading,
									onComplete: function(requester){
															requester.responseText.evalScripts();
															},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															}
									}
									);
}




//gestion d'un inventaire pour un article seul

//fonction d'insertion de ligne de sn par javascript
function insert_art_inventory_line_sn (indentation_sn) {
	var zone= $("art_gest_sn");
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "num_sn_"+indentation_sn);
	zone.appendChild(adddiv);

	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "more_sn_"+indentation_sn);
		addspan.setAttribute ("class", "more_sn_class");
		addspan.setAttribute ("className", "more_sn_class");
	$("num_sn_"+indentation_sn).appendChild(addspan);
	$("more_sn_"+indentation_sn).innerHTML = "N° de série: ";

	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "art_sn_"+indentation_sn);
		inputtext.setAttribute ("name", "art_sn_"+indentation_sn);
		inputtext.setAttribute ("type", "text");
		inputtext.setAttribute ("value", "");
	$("num_sn_"+indentation_sn).appendChild(inputtext);

	var inputhidden= document.createElement("input");
		inputhidden.setAttribute ("id", "old_art_sn_"+indentation_sn);
		inputhidden.setAttribute ("name", "old_art_sn_"+indentation_sn);
		inputhidden.setAttribute ("type", "hidden");
		inputhidden.setAttribute ("value", "");
	$("num_sn_"+indentation_sn).appendChild(inputhidden);

	var addsup= document.createElement("a");
		addsup.setAttribute ("id", "sup_sn_"+indentation_sn);
		addsup.setAttribute ("href", "#");
		addsup.setAttribute ("class", "sn_a_none");
		addsup.setAttribute ("className", "sn_a_none");
	$("num_sn_"+indentation_sn).appendChild(addsup);
	$("sup_sn_"+indentation_sn).innerHTML = "&nbsp;";

	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
	$("sup_sn_"+indentation_sn).appendChild(addimgsup);

	var adddiv_block_sn= document.createElement("div");
		adddiv_block_sn.setAttribute ("id", "block_choix_sn_"+indentation_sn);
		adddiv_block_sn.setAttribute ("class", "sn_block_choix");
		adddiv_block_sn.setAttribute ("className", "sn_block_choix");
	$("num_sn_"+indentation_sn).appendChild(adddiv_block_sn);

	var addiframe_choix_sn= document.createElement("div");
		addiframe_choix_sn.setAttribute ("id", "iframe_liste_choix_sn_"+indentation_sn);
		addiframe_choix_sn.setAttribute ("frameborder", "0");
		addiframe_choix_sn.setAttribute ("scrolling", "no");
		addiframe_choix_sn.setAttribute ("src", "about:_blank");
		addiframe_choix_sn.setAttribute ("class", "choix_liste_choix_sn");
		addiframe_choix_sn.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_sn_"+indentation_sn).appendChild(addiframe_choix_sn);
		$("iframe_liste_choix_sn_"+indentation_sn).setStyle({   display: 'none' });

	var adddiv_choix_sn= document.createElement("div");
		adddiv_choix_sn.setAttribute ("id", "choix_liste_choix_sn_"+indentation_sn);
		adddiv_choix_sn.setAttribute ("class", "choix_liste_choix_sn");
		adddiv_choix_sn.setAttribute ("className", "choix_liste_choix_sn");
		$("block_choix_sn_"+indentation_sn).appendChild(adddiv_choix_sn);
		$("choix_liste_choix_sn_"+indentation_sn).setStyle({   display: 'none' });

pre_start_observer_inventory_sn (indentation_sn,  "art_sn_"+indentation_sn ,"old_art_sn_"+indentation_sn, "sup_sn_"+indentation_sn, "more_sn_"+indentation_sn, $("ref_article_inventory").value, "choix_liste_choix_sn_"+indentation_sn, "iframe_liste_choix_sn_"+indentation_sn );
}

//fonction d'insertion de ligne de sn par javascript
function insert_art_inventory_line_nl (indentation_nl) {
	var zone= $("art_gest_nl");
	var adddiv= document.createElement("div");
		adddiv.setAttribute ("id", "num_nl_"+indentation_nl);
	zone.appendChild(adddiv);

	var addspan= document.createElement("span");
		addspan.setAttribute ("id", "more_nl_"+indentation_nl);
		addspan.setAttribute ("class", "more_sn_class");
		addspan.setAttribute ("className", "more_sn_class");
	$("num_nl_"+indentation_nl).appendChild(addspan);
	$("more_nl_"+indentation_nl).innerHTML = "N° de lot:";
	new Insertion.Bottom ($("num_nl_"+indentation_nl), " ");

	var inputtext= document.createElement("input");
		inputtext.setAttribute ("id", "art_nl_"+indentation_nl);
		inputtext.setAttribute ("name", "art_nl_"+indentation_nl);
		inputtext.setAttribute ("type", "text");
		inputtext.setAttribute ("value", "");
		inputtext.setAttribute ("size", "10");
	$("num_nl_"+indentation_nl).appendChild(inputtext);

	var inputhidden= document.createElement("input");
		inputhidden.setAttribute ("id", "old_art_nl_"+indentation_nl);
		inputhidden.setAttribute ("name", "old_art_nl_"+indentation_nl);
		inputhidden.setAttribute ("type", "hidden");
		inputhidden.setAttribute ("value", "");
	$("num_nl_"+indentation_nl).appendChild(inputhidden);
	new Insertion.Bottom ($("num_nl_"+indentation_nl), " ");


	var inputtext2= document.createElement("input");
		inputtext2.setAttribute ("id", "qte_nl_"+indentation_nl);
		inputtext2.setAttribute ("name", "qte_nl_"+indentation_nl);
		inputtext2.setAttribute ("type", "text");
		inputtext2.setAttribute ("value", "");
		inputtext2.setAttribute ("size", "3");
	$("num_nl_"+indentation_nl).appendChild(inputtext2);

	var inputhidden2= document.createElement("input");
		inputhidden2.setAttribute ("id", "old_qte_nl_"+indentation_nl);
		inputhidden2.setAttribute ("name", "old_qte_nl_"+indentation_nl);
		inputhidden2.setAttribute ("type", "hidden");
		inputhidden2.setAttribute ("value", "");
	$("num_nl_"+indentation_nl).appendChild(inputhidden2);

	var addsup= document.createElement("a");
		addsup.setAttribute ("id", "sup_nl_"+indentation_nl);
		addsup.setAttribute ("href", "#");
		addsup.setAttribute ("class", "sn_a_none");
		addsup.setAttribute ("className", "sn_a_none");
	$("num_nl_"+indentation_nl).appendChild(addsup);
	$("sup_nl_"+indentation_nl).innerHTML = "&nbsp;";

	var addimgsup= document.createElement("img");
		addimgsup.setAttribute("src",dirtheme+"images/supprime.gif") ;
	$("sup_nl_"+indentation_nl).appendChild(addimgsup);

	var adddiv_block_nl= document.createElement("div");
		adddiv_block_nl.setAttribute ("id", "block_choix_nl_"+indentation_nl);
		adddiv_block_nl.setAttribute ("class", "sn_block_choix");
		adddiv_block_nl.setAttribute ("className", "sn_block_choix");
	$("num_nl_"+indentation_nl).appendChild(adddiv_block_nl);

	var addiframe_choix_nl= document.createElement("div");
		addiframe_choix_nl.setAttribute ("id", "iframe_liste_choix_nl_"+indentation_nl);
		addiframe_choix_nl.setAttribute ("frameborder", "0");
		addiframe_choix_nl.setAttribute ("scrolling", "no");
		addiframe_choix_nl.setAttribute ("src", "about:_blank");
		addiframe_choix_nl.setAttribute ("class", "choix_liste_choix_nl");
		addiframe_choix_nl.setAttribute ("className", "choix_liste_choix_nl");
		$("block_choix_nl_"+indentation_nl).appendChild(addiframe_choix_nl);
		$("iframe_liste_choix_nl_"+indentation_nl).setStyle({   display: 'none' });

	var adddiv_choix_nl= document.createElement("div");
		adddiv_choix_nl.setAttribute ("id", "choix_liste_choix_nl_"+indentation_nl);
		adddiv_choix_nl.setAttribute ("class", "choix_liste_choix_nl");
		adddiv_choix_nl.setAttribute ("className", "choix_liste_choix_nl");
		$("block_choix_nl_"+indentation_nl).appendChild(adddiv_choix_nl);
		$("choix_liste_choix_nl_"+indentation_nl).setStyle({   display: 'none' });

pre_start_observer_inventory_nl (indentation_nl,  "art_nl_"+indentation_nl ,"old_art_nl_"+indentation_nl, "sup_nl_"+indentation_nl, "more_nl_"+indentation_nl, $("ref_article_inventory").value, "choix_liste_choix_nl_"+indentation_nl, "iframe_liste_choix_nl_"+indentation_nl,  "qte_nl_"+indentation_nl ,"old_qte_nl_"+indentation_nl );
}





//fonction de lancement des observateur d'event pour ligne de sn insérées par javascript
function pre_start_observer_inventory_sn (indentation_sn,  art_sn, old_art_sn, sup_sn, more_sn, ref_article, choix_div, choix_iframe) {

	Event.observe("art_sn_"+indentation_sn, "dblclick", function(evt){
								incremente_sn_inventory(indentation_sn);
								}, false);

	Event.observe("art_sn_"+indentation_sn, "blur", function(evt){
								is_inventory_sn_filled ();
								}, false);

	Event.observe(sup_sn, "click", function(evt){Event.stop(evt);
			$(old_art_sn).value = $(art_sn).value = "";
			}, false);

	Event.observe(more_sn, "click", function(evt){
		start_choix_sn_inventory (ref_article, art_sn, choix_div, choix_iframe, "catalogue_articles_liste_choix_sn.php");
	}, false);


}


//fonction de lancement des observateur d'event pour ligne de NL insérées par javascript
function pre_start_observer_inventory_nl (indentation_nl,  art_nl, old_art_nl, sup_nl, more_nl, ref_article, choix_div, choix_iframe,  qte_nl, old_qte_nl) {

	Event.observe(sup_nl, "click", function(evt){Event.stop(evt);
			$(old_art_nl).value = $(art_nl).value = "";
			$(old_qte_nl).value = $(qte_nl).value = "";
			}, false);

	Event.observe(more_nl, "click", function(evt){
		start_choix_nl_inventory (ref_article, art_nl, qte_nl, choix_div, choix_iframe, "catalogue_articles_liste_choix_nl.php");
	}, false);


}


//fonction d'affichage des listes de sn pour un article
function start_choix_sn_inventory (ref_article, idinput, cible, iframecible, targeturl) {
	if ($(cible).style.display=="none") {
		var id_stock = "";
		if ($("id_stock_inventory")) {id_stock = $("id_stock_inventory").value; }

		var AppelAjax = new Ajax.Updater(
																	cible,
																	targeturl,
																	{parameters: {ref_article: ref_article, choix_sn: cible, iframe_choix_sn: iframecible, input: idinput, id_stock: id_stock},
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function(requester) {
																						H_loading();
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}



//fonction d'affichage des listes de sn pour un article
function start_choix_nl_inventory (ref_article, idinput, idinput2, cible, iframecible, targeturl) {
	if ($(cible).style.display=="none") {
		var id_stock = "";
		if ($("id_stock_inventory")) {id_stock = $("id_stock_inventory").value; }

		var AppelAjax = new Ajax.Updater(
																	cible,
																	targeturl,
																	{parameters: {ref_article: ref_article, choix_sn: cible, iframe_choix_sn: iframecible, input: idinput, input2: idinput2, id_stock: id_stock},
																	evalScripts:true,
																	onLoading:S_loading, onException: function () {S_failure();},
																	onComplete: function(requester) {
																						H_loading();
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}



//double click sur champ sn incrémente les sn suivant si non déjà remplis
function incremente_sn_inventory(indentation_sn) {
	var nombre_ligne_sn =  Math.abs($("qte_inventory").value);

	//if (nombre_ligne_sn >=  doc_aff_qte_sn) { nombre_ligne_sn = doc_aff_qte_sn;}
	var sn_de_depart = $("art_sn_"+indentation_sn).value;
	var u_field_num = Array.from(sn_de_depart);
	var defaut_num_serie = 0;
	var last_car_index = -1;
	var sn_indent = parseFloat (indentation_sn);
	for( i=0; i < u_field_num.length; i++ ) {
		if (isNaN(u_field_num[i])){
  	 last_car_index = i;
		}
	}

	first_sn_part = sn_de_depart.substring (0, last_car_index+1);
	num_sn_part = sn_de_depart.substring (last_car_index+1);

	if (num_sn_part !="") {
		zero_in_num_sn =  Array.from(num_sn_part);
		zero_before_increment = "";
		nomore_zero = false;
		count_zero = 0;
		for( j=0; j < zero_in_num_sn.length; j++ ) {
			if ((zero_in_num_sn[j] == "0") && (!nomore_zero )){
			 count_zero ++;
			} else {
				nomore_zero = true;
			}
		}

		new_increment_sn = parseFloat(num_sn_part.substring (count_zero));
		longeur_incre_onstart = (new_increment_sn.toString()) ;

		for(i = 0; i< nombre_ligne_sn; i++) {
			zero_before_increment = "";
			if ($("art_sn_"+i) && (i > indentation_sn) ) {
				new_increment_sn++;
				reste_zero = count_zero - ((new_increment_sn.toString()).length - longeur_incre_onstart.length);
				if (reste_zero >0) {
					for( k=0; k < reste_zero; k++ ) {
						zero_before_increment += "0";
					}
				}

				if ($("art_sn_"+i).value == "") {
					$("old_art_sn_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;
					$("art_sn_"+i).value = first_sn_part + "" + zero_before_increment + new_increment_sn;

				}
			}
		}
	}
}

//modifier le nombre de ligne de numéro de série en cas e changement de quantité
function affichage_inventory_sn_update ( new_qte, old_qte) {
	var maj_qte = parseInt(Math.abs(new_qte));
	var prev_qte = parseInt(Math.abs(old_qte));
	if (($("art_gest_sn")) && (maj_qte != prev_qte)) {
		if (maj_qte > prev_qte) {
			diff = maj_qte-prev_qte;
			for (k=prev_qte ; k <maj_qte; k++) {
				if (diff != 0) {
					insert_art_inventory_line_sn ( maj_qte-diff );
					diff = diff-1;
				}
			}

		} else {
			diff= prev_qte-maj_qte ;
			for (j=0 ; j <prev_qte; j++) {
				if (j < maj_qte) {
				} else {
					if (diff != 0) {
						if ($("num_sn_"+j)) {
							remove_tag("num_sn_"+j);
						}
						diff = diff-1;
					}
				}
			}
		}
	}
}

function affichage_inventory_nl_update ( new_qte, old_qte) {
	var maj_qte = parseInt(Math.abs(new_qte));
	var prev_qte = parseInt(Math.abs(old_qte));
	if (($("art_gest_nl")) && (maj_qte != prev_qte)) {
		if (maj_qte > prev_qte) {
			diff = maj_qte-prev_qte;
			for (k=prev_qte ; k <maj_qte; k++) {
				if (diff != 0) {
					insert_art_inventory_line_nl ( maj_qte-diff );
					diff = diff-1;
				}
			}

		} else {
			diff= prev_qte-maj_qte ;
			for (j=0 ; j <prev_qte; j++) {
				if (j < maj_qte) {
				} else {
					if (diff != 0) {
						if ($("num_nl_"+j)) {
							remove_tag("num_nln_"+j);
						}
						diff = diff-1;
					}
				}
			}
		}
	}
}

// sn remplis
function is_inventory_sn_filled () {
	var nombre_ligne_sn =  Math.abs($("qte_inventory").value);
	for(i = 0; i< nombre_ligne_sn; i++) {
		if ($("art_sn_"+i) && $("art_sn_"+i).value == "" && $("info_fill_sn")) {
			$("info_fill_sn").innerHTML = "Les num&eacute;ros de s&eacute;rie doivent &ecirc;tre renseign&eacute;s.";
		}
	}
}

//gestion des variantes

function combine_all(tab_values, result) {
	var result2 = result;
	// On extrait le premier tableau, en le retirant de la table
	// de tables.
	var tab0 = tab_values[0];
	var res2 = "";
	var tab_values2 = tab_values;
	tab_values2.shift();

	//alert(tab_values2.inspect());
	// Boucle sur toutes les valeurs de ce tableau
	for (value in tab0) {
			// On concat?ne la nouvelle valeur avec les pr?c?dentes
			if (result2 != "") {	res2+=", ";	}
			res2 += tab0[value];
			if (tab_values2.length == 0) {
			 // C'?tait le dernier tableau, on affiche le r?sultat
			 $("liste_variantes_article").innerHTML += res2;
			} else {
			 // On continue avec le tableau suivant
			 combine_all(tab_values2, res2);
			}
	}
}

function generer_variantes_article() {
	var variation_car = new Array;
	var indent_var = 0;
	var tresult = "";
	var variation_compte = 0;
	for( i=0; i< parseFloat($("serialisation_carac").value); i++) {
		if ($("variante_"+i).value == "1") {
			tmp = $("caract_value_"+i).value.split(";");
			variation_car[i] = new Array;
			for (j=0; j<tmp.length; j++) {
				variation_car[i][j] = tmp[j];
			}
		}
	}
	//combine_all(variation_car, tresult);
}


function charger_variations_possibles (ref_art_categ) {

	var variation_car = new Array;
	var indent_var = 0;
	var tquerystring = "ref_art_categ="+ref_art_categ;
	var variation_compte = 0;
	for( i=0; i< parseFloat($("serialisation_carac").value); i++) {
		if ($("variante_"+i).value == "1" && $("caract_value_"+i).value!= "") {
			tquerystring += "&"+$("ref_carac_"+i).value+"="+($("caract_value_"+i).value);
		}
	}

	var AppelAjax = new Ajax.Updater(
									"variantes_info_under",
									"catalogue_articles_variantes.php",
									{
									method: 'post',
									contentType:  'application/x-www-form-urlencoded',
									asynchronous: true,
									parameters: (tquerystring).toQueryParams(),
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete:H_loading
									}
									);
}

function charger_edition_variations_possibles (ref_art_categ, ref_article) {
	var variation_car = new Array;
	var indent_var = 0;
	var tquerystring = "ref_art_categ="+ref_art_categ;
		  tquerystring += "&ref_article="+ref_article;
	var variation_compte = 0;
	
	for( i=0; i< parseFloat($("serialisation_carac").value); i++) {
		if ($("variante_"+i).value == "1" && $("caract_value_"+i).value!= "") {
			tquerystring += "&"+$("ref_carac_"+i).value+"="+($("caract_value_"+i).value);
		}
	}
	var AppelAjax = new Ajax.Updater(
									"variantes_info_under",
									"catalogue_articles_edition_variantes.php",
									{
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									parameters: tquerystring.toQueryParams(),
									evalScripts:true,
									onLoading:S_loading, onException: function () {S_failure();},
									onComplete:H_loading
									}
									);
}

//cochage des lignes de de variantes

function coche_line_variantes (type_action, second_id , length_list) {

		for (i = 0; i <= length_list; i++) {
			if ($(""+second_id+"_"+i) && !$(""+second_id+"_"+i).disabled) {
				switch (type_action) {
					case "inv_coche" :
						if ($(""+second_id+"_"+i).checked == false) {
							$(""+second_id+"_"+i).checked = true;
						}
						else {
							$(""+second_id+"_"+i).checked = false;
						}
						break;
					case 'coche' :
							$(""+second_id+"_"+i).checked = true;
						break;
					case 'decoche'  :
							$(""+second_id+"_"+i).checked = false;
						break;
					default :
					break;
				}
			}
		}

}