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

<script type="text/javascript" language="javascript">
array_menu_r_article	=	new Array();
array_menu_r_article[0] 	=	new Array('recherche_simple', 'menu_1');
array_menu_r_article[1] 	=	new Array('recherche_avancee', 'menu_2');
</script>
<script type="text/javascript">
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>
<div class="emarge">
<div style=" float:right; text-align:right">
<span id="retour_compta_auto" style="cursor:pointer; text-decoration:underline">Retour à la comptabilité automatique</span>
<script type="text/javascript">
Event.observe('retour_compta_auto', 'click',  function(evt){
Event.stop(evt); 
page.verify('compta_automatique','compta_automatique.php','true','sub_content');
}, false);
</script>
</div>
<p class="titre">Numéros de compte associés aux articles (HT Achat)</p>
<ul id="menu_recherche" class="menu">
<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
<li><a href="#" id="menu_2" class="menu_unselect">Recherche avanc&eacute;e</a></li>
</ul>
</div>
<div id="recherche" class="corps_moteur">
<div id="recherche_simple" class="menu_link_affichage">
<form action="#" method="GET" id="form_recherche_s" name="form_recherche_s">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:10%">&nbsp;</td>
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%">&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td><span class="labelled_text">R&eacute;f&eacute;rence, libell&eacute; ou code barre:</span></td>
		<td>
		<input type="text" name="lib_article_s" id="lib_article_s" value="<?php if (isset($_REQUEST["acc_ref_article"])) { echo htmlentities($_REQUEST["acc_ref_article"]);}
	?>"   class="classinput_xsize"/>
		</td>
		<td style="padding-left:35px">
		<div <?php if (!$GESTION_STOCK) {?> style="display:none"<?php } ?>>
				<input type="checkbox" name="in_stock_s" id="in_stock_s" value="1" />
				<span class="labelled_text">En Stock </span>
		</div>		
		</td>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Cat&eacute;gorie:</span>
			<input type="hidden"value="" />
			<input type="hidden" name="id_tarif_s" id="id_tarif_s" value="<?php echo $_SESSION['magasin']->getId_tarif()?>" />
			<input type="hidden" name="id_stock_s" id="id_stock_s" value="<?php echo $_SESSION['magasin']->getId_stock()?>" />
			<input type="hidden" name="orderby_s" id="orderby_s" value="lib_article" />
			<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
			<input type="hidden" name="app_tarifs_s" id="app_tarifs_s" value="<?php echo $DEFAUT_APP_TARIFS_CLIENT;?>" />
			<input type="hidden" name="type_s" id="type_s" value="achat" />
			<input type=hidden name="recherche" value="1" />
			</td>
			<td>
			<select  name="ref_art_categ_s" id="ref_art_categ_s" class="classinput_xsize">
			<option value="">Toutes</option>
			<?php
				$select_art_categ =	get_articles_categories();
				foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>">
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>
			</td>
			<td style="padding-left:35px">
				
				<input type="checkbox" name="is_nouveau_s" id="is_nouveau_s" value="1" />
				<span class="labelled_text">Nouveaut&eacute;</span>
				</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="labelled_text" <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>Constructeur:</span></td>
			<td>
				<select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style="width:100%; <?php if(!$GESTION_CONSTRUCTEUR){?> display:none;<?php } ?>"><option value=''>Tous</option></select>
			</td>
			<td style="padding-left:35px">
				<input type="checkbox" name="in_promotion_s" id="in_promotion_s" value="1" />
			<span class="labelled_text">Promotions</span>
				</td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><span style="text-align:right">
			<input name="submit2" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche_s" id="annuler_recherche_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
		</span></td>
		<td style="padding-left:35px">&nbsp;</td>
		<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_new_article.gif" id="create_new_article" style="cursor:pointer" />
		</td>
		<td style="text-align:right">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5"></td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</form>
</div>



<div id="recherche_avancee" style="display:none;" class="menu_link_affichage">
<form action="#" method="GET" id="form_recherche_a" name="form_recherche_a">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:10%">&nbsp;</td>
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="labelled_text">R&eacute;f&eacute;rence, libell&eacute; ou code barre:</span></td>
			<td><input type="text" name="lib_article" id="lib_article" value=""   class="classinput_xsize"/></td>
			<td style="padding-left:35px">
			<div <?php if (!$GESTION_STOCK) {?> style="display:none"<?php } ?>>
				<input type="checkbox" name="in_stock" id="in_stock" value="1" />
				<span class="labelled_text">En Stock </span>
			</div>
			</td>
			<td></td>
			<td style="text-align:right"></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Cat&eacute;gorie:</span>
			<input type="hidden" name="id_tarif" id="id_tarif" value="<?php echo $_SESSION['magasin']->getId_tarif()?>" />
			<input type="hidden" name="id_stock" id="id_stock" value="<?php echo $_SESSION['magasin']->getId_stock()?>" />
			<input type="hidden" name="orderby" id="orderby" value="lib_article" />
			<input type="hidden" name="orderorder" id="orderorder" value="ASC" />
			<input type="hidden" name="app_tarifs" id="app_tarifs" value="<?php echo $DEFAUT_APP_TARIFS_CLIENT;?>" />
			<input type=hidden name="recherche" value="1" />			</td>
			<td>
			<select  name="ref_art_categ" id="ref_art_categ" class="classinput_xsize">
			<option value="">Toutes</option>
			<?php
				foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>">
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>
			</td>
			<td style="padding-left:35px">
				<input type="checkbox" name="is_nouveau" id="is_nouveau" value="1" />
				<span class="labelled_text">Nouveaut&eacute;</span>			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="labelled_text" <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>Constructeur:</span></td>
			<td>
				<select name="ref_constructeur" id="ref_constructeur" class="classinput_xsize" style="width:100%;  <?php if(!$GESTION_CONSTRUCTEUR){?> display:none;<?php } ?>"><option value=''>Tous</option></select>			</td>
			<td style="padding-left:35px">
				<input type="checkbox" name="in_promotion" id="in_promotion" value="1" />
				<span class="labelled_text">Promotions</span></td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><span style="text-align:right">
			<input name="submit" type="image" onclick="$('page_to_show').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche" id="annuler_recherche" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
		</span></td>
		<td style="padding-left:35px"><input type="checkbox" name="in_archive" id="in_archive" value="1" />
			<span class="labelled_text">Archives</span></td>
		<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_new_article.gif" id="create_new_article_a" style="cursor:pointer" /></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5" style=""><div id="caract_simple" class="caract_recherche" style="display:none"></div>		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<input type="hidden" name="page_to_show" id="page_to_show" value="1"/></form>
</div>
</div>

<div id="resultat"></div>

</div>
<script type="text/javascript">
Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_simple', 'menu_1', array_menu_r_article);}, false);
Event.observe("menu_2", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_avancee', 'menu_2', array_menu_r_article);}, false);


//focus sur champ code barre
$('lib_article_s').focus();

//creation d'un nouvel article 
Event.observe("create_new_article", "click",  function(evt){
	Event.stop(evt); 
	page.verify('catalogue_articles','catalogue_articles.php','true','sub_content');
}, false);

Event.observe("create_new_article_a", "click",  function(evt){
	Event.stop(evt); 
	page.verify('catalogue_articles','catalogue_articles.php','true','sub_content');
}, false);

//remise à zero du formulaire
Event.observe('annuler_recherche_s', "click", function(evt){Event.stop(evt); reset_moteur_s ('form_recherche_s', 'ref_art_categ_s');	});
Event.observe('annuler_recherche', "click", function(evt){Event.stop(evt); reset_moteur_a ('form_recherche_a', 'ref_art_categ');	});

//lance la recherche
Event.observe('form_recherche_s', "submit", function(evt){page.compta_automatique_art_recherche_simple();  
	Event.stop(evt);});
Event.observe('form_recherche_a', "submit", function(evt){page.compta_automatique_art_recherche_avancee();  
	Event.stop(evt);});
	
	
//
Event.observe('ref_constructeur_s', "click", function(evt){
	if ($("ref_constructeur_s").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
		constructeurUpdater.run("");
	}
});
Event.observe('ref_constructeur', "click", function(evt){
	if ($("ref_constructeur").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ").value);
		constructeurUpdater.run("");
	}
});

Event.observe('ref_art_categ', "change", function(evt){
		Element.show("caract_simple"); 
	charger_carac_simple($("ref_art_categ").options[$("ref_art_categ").selectedIndex].value, "caract_simple");
});

//blocage du retour chariot automatique à la saisie du code barre
function stopifcode_barre (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	Event.stop(event);
	break;   
	}
}
//observer le retour chariot lors de la saisie du code barre pour lancer la recherche
function submit_simple_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
		page.compta_automatique_art_recherche_simple();   
	Event.stop(event);
	break;   
	}
}
function submit_avancee_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	page.compta_automatique_art_recherche_avancee();   
	Event.stop(event);
	break;   
	}
}
Event.observe('lib_article_s', "keypress", function(evt){submit_simple_if_Key_RETURN (evt);});
Event.observe('lib_article', "keypress", function(evt){submit_avancee_if_Key_RETURN (evt);});

<?php 
if (isset($_REQUEST["acc_ref_article"])) {
	?>
	//recherche automatique d'un article depuis la page d'acceuil
	page.compta_automatique_art_recherche_simple();
	<?php
}
?>

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
	page.compta_automatique_art_recherche_simple();
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
	page.compta_automatique_art_recherche_avancee();
	
	}
}
//on masque le chargement
H_loading();
</SCRIPT>