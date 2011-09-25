<?php

// *************************************************************************************************************
// RECHERCHE D'UN ARTICLE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>

<!-- En prévsion d'un onglet recherche avancée -->
<script type="text/javascript" language="javascript">
	array_menu_r_article	=	new Array();
	array_menu_r_article[0] 	=	new Array('recherche_simple', 'menu_1');
</script>

<div class="emarge">
	<p class="titre">Articles disponibles auprès d'un fournisseur</p>
	
	<div>
		<ul id="menu_recherche" class="menu">
			<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
		</ul>
	</div>
	<div id="recherche" class="corps_moteur">
	
		<div id="recherche_simple" class="menu_link_affichage">
			<form action="#" method="GET" id="form_recherche_s" name="form_recherche_s">
				<input type="hidden" name="orderby_s" 				id="orderby_s" 					value="a.lib_article" />
				<input type="hidden" name="orderorder_s" 			id="orderorder_s" 			value="ASC" />
				<input type="hidden" name="ref_constructeur_s"id="ref_constructeur_s" value="" />
				<input type="hidden" name="ref_fournisseur_s"	id="ref_fournisseur_s" 	value="<?php if($fournisseur != null){echo $fournisseur->getRef_contact();}?>" />
				<input type="hidden" name="ref_art_categ_s" 	id="ref_art_categ_s" 		value="" />
				<input type="hidden" name="lib_article_s" 		id="lib_article_s" 			value="" />
				<input type="hidden" name="recherche" 				id="recherche" 					value="1" />
				<input type="hidden" name="page_to_show_s" 		id="page_to_show_s" 		value="1" />
				
				<table style="width:97%">
					<tr class="smallheight">
						<td style="width:2%">&nbsp;</td>
						<td style="width:25%">&nbsp;</td>
						<td style="width:25%">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<td style="width:20%">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<td style="width:10%">&nbsp;</td>
						<td style="width:15%">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<td style="width:3%">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<span class="labelled_text">Fournisseur:</span>
						</td>
						<td>
							
							<input type="text" name="nom_contact"  id="nom_contact" value="<?php if($fournisseur != null){echo $fournisseur->getNom();}?>"/>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif" style="cursor:pointer" 	id="recherche_ref_contact_img" alt="Choisir un contact" 		title="Choisir un contact"/>&nbsp;&nbsp;
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" style="cursor:pointer" 				id="recherche_sup_contact_img" alt="Supprimer le  contact" 	title="Supprimer le  contact"/>
							<script type="text/javascript">


							//effet de survol sur le faux select
								Event.observe('recherche_ref_contact_img', 'mouseover', function(){
									$("recherche_ref_contact_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";
								}, false);
								Event.observe('recherche_ref_contact_img', 'mousedown', function(){
									$("recherche_ref_contact_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";
								}, false);
								Event.observe('recherche_ref_contact_img', 'mouseup',  	function(){
									$("recherche_ref_contact_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";
								}, false);
								Event.observe('recherche_ref_contact_img', 'mouseout',  function(){
									$("recherche_ref_contact_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";
								}, false);
								Event.observe('recherche_ref_contact_img', 'click',  		function(evt){
									Event.stop(evt);
									show_mini_moteur_contacts ("recherche_client_set_contact", "\'ref_fournisseur_s\', \'nom_contact\' ");
									//show_mini_moteur_contacts ("catalogue_recherche_articles_proposes_fournisseur", "");
									preselect ('<?php echo $FOURNISSEUR_ID_PROFIL; ?>', 'id_profil_m');
									page.annuaire_recherche_mini();
								}, false);
						
								Event.observe("recherche_sup_contact_img", "click",  function(){
									$("nom_contact").value = "";
									$("ref_fournisseur_s").value = "";
								}, false);
							</script>
							
				
						</td>
						<td style="padding-left:35px">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="text-align:right">
								<input name="submit2" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
								<input type="image" name="annuler_recherche_s" id="annuler_recherche_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
						</td>
						<td style="padding-left:35px">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="5"></td>
						<td>&nbsp;</td>
					</tr>
				</table>
		</form>
	</div>
</div>

<div id="resultat" ></div>

<script type="text/javascript">

page.traitecontent("cat_art_by_fournisseur_result","catalogue_articles_proposes_fournisseur_result.php?<?php if($fournisseur != null){echo "ref_fournisseur=".$fournisseur->getRef_contact();}?>&recherche=1","true","resultat"); 

</script>


</div>
<script type="text/javascript">
Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_simple', 'menu_1', array_menu_r_article);}, false);

//remise à zero du formulaire
Event.observe('annuler_recherche_s', "click", function(evt){
	Event.stop(evt);
	reset_moteur_s ('form_recherche_s', 'ref_art_categ_s');
});

//lance la recherche
Event.observe('form_recherche_s', "submit", function(evt){
	page.catalogue_recherche_articles_proposes_fournisseur();  
	Event.stop(evt);
});
	
function submit_avancee_if_Key_RETURN (event) {
	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	page.catalogue_recherche_avancee();   
	Event.stop(event);
	break;   
	}
}
<?php /*
//remplissage si on fait un retour dans l'historique
if (historique_request[1][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
	//history sur recherche simple
	if (historique_request[1][1] == "simple") {
	//$("lib_art_categ_s").innerHTML = historique_request[1]["lib_art_categ_s"];
	//$('ref_art_categ_s').value = 		historique_request[1]["ref_art_categ_s"];
	$('lib_article_s').value = 		historique_request[1]["lib_article_s"];
	
	preselect ((historique_request[1]["ref_art_categ_s"]), 'ref_art_categ_s') ;
	
	preselect ((historique_request[1]["ref_constructeur_s"]), 'ref_constructeur_s') ;
	
	if (historique_request[1]["in_stock_s"] == "1") {	$('page_to_show_s').checked = true;	}
	if (historique_request[1]["is_nouveau_s"] == "1") {	$('is_nouveau_s').checked = true;	}
	if (historique_request[1]["in_promotion_s"] == "1") {	$('in_promotion_s').checked = true;	}
	
	$('page_to_show_s').value = 	historique_request[1]["page_to_show_s"];  
	$('orderby_s').value = 	historique_request[1]["orderby_s"]; 
	$('orderorder_s').value = 	historique_request[1]["orderorder_s"];
	
	$('id_tarif_s').value = 	historique_request[1]["id_tarif_s"];
	$('id_stock_s').value = 	historique_request[1]["id_stock_s"];
	
	view_menu_1('recherche_simple', 'menu_1', array_menu_r_article);
	page.catalogue_recherche_simple();
	}
	//history sur recherche avancee
	if (historique_request[1][1] == "avancee") {
	if (historique_request[1]["ref_art_categ"] != "") {
	//$("lib_art_categ_a").innerHTML = historique_request[1]["lib_art_categ_a"];
	//$('ref_art_categ').value = historique_request[1]["ref_art_categ"];  
	preselect ((historique_request[1]["ref_art_categ"]), 'ref_art_categ') ;
	Element.show("caract_simple");
	charger_carac_simple(historique_request[1]["ref_art_categ"], "caract_simple");
	}
	$('lib_article').value = 		historique_request[1]["lib_article"];
	
	preselect (parseInt(historique_request[1]["ref_constructeur"]), 'ref_constructeur') ;
	
	if (historique_request[1]["in_stock"] == "1") 		{	$('in_stock').checked = true;	}
	if (historique_request[1]["is_nouveau"] == "1")		{	$('is_nouveau').checked = true;	}
	if (historique_request[1]["in_promotion"] == "1") {	$('in_promotion').checked = true;	}
	if (historique_request[1]["in_archive"] == "1") 	{	$('in_archive').checked = true;	}
	
	$('page_to_show').value = 	historique_request[1]["page_to_show"];  
	$('orderby').value = 	historique_request[1]["orderby"]; 
	$('orderorder').value = 	historique_request[1]["orderorder"];
	
	$('id_tarif').value = 	historique_request[1]["id_tarif"];
	$('id_stock').value = 	historique_request[1]["id_stock"];
	
	view_menu_1('recherche_avancee', 'menu_2', array_menu_r_article);
	page.catalogue_recherche_avancee();
	
	}
}
*/ ?>
//on masque le chargement

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
	centrage_element("pop_up_mini_moteur_iframe");
	centrage_element("pop_up_mini_moteur");
});

H_loading();
</SCRIPT>