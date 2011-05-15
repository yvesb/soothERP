<?php

// *************************************************************************************************************
// VISUALISATION D'UN ARTICLE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript" language="javascript">
array_menu_v_article	=	new Array();
array_menu_v_article[0] 	=	new Array('info_gene', 'menu_1');
<?php if($_SESSION['user']->check_permission ("6")){ ?>
array_menu_v_article[1] 	=	new Array('gest_tarifs', 'menu_2');
<?php }?>
array_menu_v_article[2] 	=	new Array('option_avancees', 'menu_4');
array_menu_v_article[6] 	=	new Array('stats', 'menu_7');
array_menu_v_article[4] 	=	new Array('info_images', 'menu_6');
array_menu_v_article[7] 	=	new Array('info_liaisons', 'menu_8');
array_menu_v_article[8] 	= 	new Array('pieces_content', 'menu_9');
<?php if ($art_categs->getModele() == "materiel" && $article->getVariante() != 2 && $GESTION_STOCK) {?>
array_menu_v_article[3] 	=	new Array('gest_stock', 'menu_3');
<?php } ?>
<?php if ($art_categs->getModele() == "service_abo") {?>
array_menu_v_article[3] 	=	new Array('service_abo', 'menu_3');
<?php } ?>
<?php if ($art_categs->getModele() == "service_conso") {?>
array_menu_v_article[3] 	=	new Array('service_conso', 'menu_3');
<?php } ?>
<?php if ($article->getLot()) { ?>
array_menu_v_article[5] 	=	new Array('gest_composition', 'menu_5');
<?php } ?>
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_recherche_mini.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_edition_tarifs_assistant.inc.php" ?>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_view_categ_carac_iframe" class="edition_art_iframe"></iframe>
<div id="pop_up_view_categ_carac" class="edition_art_table" style="OVERFLOW-Y: auto; OVERFLOW-X: auto;">
<a href="#" id="link_close_pop_up_categ_carac" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("link_close_pop_up_categ_carac", "click",  function(evt){Event.stop(evt); stop_view_categ_carac();}, false);
</script>
<div id="caract_info_under" style="padding-left:2%; padding-right:3%">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_categ_caract.inc.php" ?>
</div>
</div>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_art_categ.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_ref_externes_content.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div class="emarge">
<?php // echo (time()." ". strtotime($article->getDate_fin_dispo()));?>
<span id="art_in_arch" style="float:right; font-weight:bolder; color:#FF0000;<?php if ($article->getDispo ()) {?> display:none;<?php } ?>" >Article en archive.</span>
<span id="art_in_arch_0" style="float:right; font-weight:bolder; color:#FF0000;<?php if (($article->getDispo () && $article->getDate_fin_dispo() >= date("Y-m-d H:i:s")) || !$article->getDispo ()) {?> display:none;<?php } ?>" >Article en fin de vie.</span>

<?php
if ($article->getVariante() == 1 && is_object($article_master)) {
	?>
	<div style="position:relative; ">
	<div class="titre_variante_from">Variante de <?php echo  nl2br(($article_master->getLib_article ()));?></div>
	</div>
	<?php
}
?>
<p class="titre" id="titre_view_art">
<?php echo  nl2br(($article->getLib_article ()));?>
</p>



<div style="height:50px; width:99.8%">
<div>
<ul id="menu_view_art" class="menu">
<div style="float:right; width:160px">
<span id="last_item_menu"><a href="#" id="menu_4" class="menu_<?php if (!isset($_REQUEST["go"]) || $_REQUEST["go"] != "o_a") { ?>un<?php } ?>select" style="float:right">Options avanc&eacute;es</a>
<script type="text/javascript">
</script>
</span>
</div>
<div id="tool_item_menu" style="float:right; width:60px; position:relative; cursor:pointer;">
<span class="hymenu_unselect" style="float:right;">
Outils
</span>
<span id="tool_uitem_menu" style="position:absolute; top:18px; left:5px; width:160px; text-align:right; display:none" >
<a href="#" id="menu_8" class="menu_unselect" style="text-align: left">Liaisons</a>
<a href="#" id="menu_7" class="menu_unselect" style="text-align: left">Statistiques</a>
<a href="#" id="menu_9" class="menu_unselect" style="text-align: left">Pi&egrave;ces jointes</a>
</span>
</div>
<script type="text/javascript">
Event.observe("tool_item_menu", "click",  function(evt){
	Event.stop(evt);
	$("tool_uitem_menu").toggle();
}, false);
</script>
<li><a href="#" id="menu_1" class="menu_<?php if (isset($_REQUEST["go"])) { ?>un<?php } ?>select">Information g&eacute;n&eacute;rales</a></li>
<?php if($_SESSION['user']->check_permission ("6")){ ?>
<li><a href="#" id="menu_2" class="menu_unselect">Gestion des tarifs</a></li>
<?php }
 if ($art_categs->getModele() == "materiel" && $article->getVariante() != 2 && $GESTION_STOCK) {?>
<li><a href="#" id="menu_3" class="menu_unselect">Gestion des stocks</a></li>
<?php } ?>
<?php if ($art_categs->getModele() == "service_abo") {?>
<li><a href="#" id="menu_3" class="menu_unselect">Gestion de l'abonnement</a></li>
<?php } ?>
<?php if ($art_categs->getModele() == "service_conso") {?>
<li><a href="#" id="menu_3" class="menu_unselect">Gestion des consommations</a></li>
<?php } ?>
<?php if ($article->getLot()) { ?>
<li><a href="#" id="menu_5" class="menu_unselect">Composition</a></li>
<?php } ?>
<li><a href="#" id="menu_6" class="menu_unselect">Images</a></li>
</ul>
</div>


<div id="pieces_content" class="articletview_corps" style="display:none; OVERFLOW-Y: auto; OVERFLOW-X: auto; " >
</div>

<div class="articletview_corps" id="gest_tarifs"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
<?php if($_SESSION['user']->check_permission ("6")){ ?>
	<div id="tarifs_info_under">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_edition_tarifs.inc.php" ?>
	</div>
<?php }?>
	<div id="ref_externes_info_under">
<?php 
	if ($_SESSION['user']->check_permission ("22",$FOURNISSEUR_ID_PROFIL)) {
	include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_ref_externes.inc.php"; 
	}
?>
	</div>
</div>
<?php if ($art_categs->getModele() == "materiel" && $article->getVariante() != 2 && $GESTION_STOCK) {?>
<div class="articletview_corps" id="gest_stock"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_gestion_stock.inc.php" ?>
</div>
<?php } ?>
<?php if ($art_categs->getModele() == "service_abo") {?>
<div class="articletview_corps" id="service_abo"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_gestion_service_abo.inc.php" ?>
</div>
<?php } ?>
<?php if ($art_categs->getModele() == "service_conso") {?>
<div class="articletview_corps" id="service_conso"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_gestion_service_conso.inc.php" ?>
</div>
<?php } ?>

<div class="articletview_corps" id="stats"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_stats.inc.php" ?>
</div>
<div class="articletview_corps" id="info_gene"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; <?php if (isset($_REQUEST["go"])) { ?>display:none<?php } ?>">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_info_generales.inc.php" ?>
</div>
<div class="articletview_corps" id="info_images"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_info_images.inc.php" ?>
</div>
<div class="articletview_corps" id="option_avancees"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; <?php if (!isset($_REQUEST["go"]) || $_REQUEST["go"] != "o_a") { ?>display:none<?php } ?>">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_option_avancees.inc.php" ?>
</div>
<?php if ($article->getLot()) { ?>
<div class="articletview_corps" id="gest_composition"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_composant_liste.inc.php" ?>
</div>
<?php } ?>

<?php
//************************************************************************************************************************
// LIAISONS ENTRE 2 ARTICLES
//************************************************************************************************************************

//<div class="articletview_corps" id="info_liaisons"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none"> 
?>
<div class="articletview_corps" id="info_liaisons"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
	<div id="liaison_info_under" style="margin-left:5%; margin-right:5%;">
		<input type="hidden" name="serialisation_liaison" id="serialisation_liaison" value="0" />
		<?php
			foreach ($liaisons_type_liste as $liaison_type) {
				$liaisons_vers_autres_articles 		= $liaison_type->getArticle_liaisons_vers_autres_articles  ($article->getRef_article());
				$liaisons_depuis_autres_articles 	= $liaison_type->getArticle_liaisons_depuis_autres_articles($article->getRef_article());
			?>
			<div id="ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_vers" style="width:100%; display:none;">
				<div class="liaison_type_title">
					<?php echo htmlentities(str_replace("%LIB_ARTICLE%", $article->getLib_article(), $liaison_type->getLib_liaison_type_vers())); ?>
				</div>
				<div style="width:100%;">
					<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_vers" class="liste_liaison"></ul>
				</div>
			</div>
			<script type="text/javascript">
			<?php foreach ($liaisons_vers_autres_articles as $article_liaison){ ?>
				//$liaisons_vers_autres_articles[n]["article"];
				//$liaisons_vers_autres_articles[n]["article_lie"];
				//$liaisons_vers_autres_articles[n]["id_liaison_type"];
				//$liaisons_vers_autres_articles[n]["ratio"];
				
				
				
				construire_ligne_liaison_article_view(parseInt($("serialisation_liaison").value), "vers", "<?php echo $article->getRef_article();?>", "<?php echo $article_liaison["article_lie"]->getRef_article();?>", <?php echo $liaison_type->getId_liaison_type(); ?>, "<?php echo filtre_js($article_liaison["article_lie"]->getLib_article());?>", <?php echo $article_liaison["ratio"]; ?>);
			<?php } ?>
			</script>
			<div id="ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" style="width:100%; display:none;">
				<div class="liaison_type_title">
					<?php echo htmlentities(str_replace("%LIB_ARTICLE%", $article->getLib_article(), $liaison_type->getLib_liaison_type_depuis())); ?>
				</div>
				<div style="width:100%;">
					<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" class="liste_liaison"></ul>
				</div>
			</div>
			<script type="text/javascript">
			<?php foreach ($liaisons_depuis_autres_articles as $article_liaison){ ?>
				//$liaisons_depuis_autres_articles[n]["article"];
				//$liaisons_depuis_autres_articles[n]["article_lie"];
				//$liaisons_depuis_autres_articles[n]["id_liaison_type"];
				//$liaisons_depuis_autres_articles[n]["ratio"];
				construire_ligne_liaison_article_view(parseInt($("serialisation_liaison").value), "depuis", "<?php echo $article->getRef_article();?>", "<?php echo $article_liaison["article_lie"]->getRef_article();?>", <?php echo $liaison_type->getId_liaison_type(); ?>, "<?php echo filtre_js($article_liaison["article_lie"]->getLib_article());?>", <?php echo $article_liaison["ratio"]; ?>);
			<?php } ?>
			</script>
		<?php 
			} ?>

		<br/>
		
		<div style="background-color:white;" align="right">
			<table >
				<tr>
					<td align="right">Ajouter une liaison de type&nbsp;</td>
					<td width="200px">
						<select id="nouvelle_liaison_type_vers_selected" name="nouvelle_liaison_type_vers_selected" class="classinput_lsize" style="width:100%;">
						<?php foreach ($liaisons_type_liste as $liaison_type){?>
							<option value="<?php echo $liaison_type->getId_liaison_type(); ?>">
								<?php echo $liaison_type->getLib_liaison_type(); ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td width="50px;" style="font-weight:bolder; text-align:center;">&nbsp;vers&nbsp;</td>
					<td>
						<input id="nouvelle_liaison_lib_article_lie" name="nouvelle_liaison_lib_article_lie" type="text" value="" class="classinput_lsize" style="width:200px;" disabled="disabled"/>
						<input id="nouvelle_liaison_ref_article_lie" name="nouvelle_liaison_ref_article_lie" type="hidden" value="" class=""/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_set_contact.gif" id="nouvelle_liaison_vers_show_mini_moteur_articles" alt="Choisir l&acute;article" title="Choisir l&acute;article" style="cursor:pointer"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_vers_reset" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td>
						<input id="nouvelle_liaison_ratio_vers" name="nouvelle_liaison_ratio_vers" type="text" value="1" class="classinput_lsize" style="width:40px;"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_vers_reset_ratio" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td width="100px" align="right">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" id="nouvelle_liaison_vers_valider" alt="Ajouter" title="Ajouter" style="cursor:pointer"/>
	
						<script type="text/javascript">
	
							Event.observe("nouvelle_liaison_vers_reset", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_lib_article_lie").value = "";
								$("nouvelle_liaison_ref_article_lie").value = "";
								$("nouvelle_liaison_type_vers_selected").selectedIndex = 0;
							}, false);
	
							Event.observe("nouvelle_liaison_vers_reset_ratio", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_ratio_vers").value = "1";
							}, false);
						
							Event.observe("nouvelle_liaison_vers_show_mini_moteur_articles", "click",  function(evt){
								Event.stop(evt);
								show_mini_moteur_articles('recherche_article_set_article', "\'nouvelle_liaison_ref_article_lie\', \'nouvelle_liaison_lib_article_lie\'");
							}, false);
						
							Event.observe("nouvelle_liaison_vers_valider", "click",  function(evt){
								Event.stop(evt);
								if($("nouvelle_liaison_ref_article_lie").value != "" && $("nouvelle_liaison_lib_article_lie").value != ""){
									var ratio = parseFloat($("nouvelle_liaison_ratio_vers").value);
									link_article_to_article_view_vers(parseInt($("serialisation_liaison").value), $("nouvelle_liaison_type_vers_selected").options[$("nouvelle_liaison_type_vers_selected").selectedIndex].value, "<?php echo $article->getRef_article();?>", $("nouvelle_liaison_ref_article_lie").value, $("nouvelle_liaison_lib_article_lie").value, ratio);
									$("nouvelle_liaison_lib_article_lie").value = "";
									$("nouvelle_liaison_ref_article_lie").value = "";
									$("nouvelle_liaison_ratio_vers").value = "1";
									$("nouvelle_liaison_type_vers_selected").selectedIndex = 0;
								}
							}, false);
						</script>
					</td>
				</tr>
			</table>
		</div>
		
		<br />
		
		<div style="background-color:white;" align="right">
			<table >
				<tr>
					<td align="right">Ajouter une liaison de type&nbsp;</td>
					<td width="200px">
						<select id="nouvelle_liaison_type_depuis_selected" name="nouvelle_liaison_type_depuis_selected" class="classinput_lsize" style="width:100%;">
						<?php foreach ($liaisons_type_liste as $liaison_type){?>
							<option value="<?php echo $liaison_type->getId_liaison_type(); ?>">
								<?php echo $liaison_type->getLib_liaison_type(); ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td width="50px;" style="font-weight:bolder; text-align:center;">&nbsp;depuis&nbsp;</td>
					<td>
						<input id="nouvelle_liaison_lib_article" name="nouvelle_liaison_lib_article" type="text" value="" class="classinput_lsize" style="width:200px;" disabled="disabled"/>
						<input id="nouvelle_liaison_ref_article" name="nouvelle_liaison_ref_article" type="hidden" value="" class=""/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_set_contact.gif" id="nouvelle_liaison_depuis_show_mini_moteur_articles" alt="Choisir l&acute;article" title="Choisir l&acute;article" style="cursor:pointer"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_depuis_reset" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td>
						<input id="nouvelle_liaison_ratio_depuis" name="nouvelle_liaison_ratio_depuis" type="text" value="1" class="classinput_lsize" style="width:40px;"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_depuis_reset_ratio" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td width="100px" align="right">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" id="nouvelle_liaison_depuis_valider" alt="Ajouter" title="Ajouter" style="cursor:pointer"/>
	
						<script type="text/javascript">
	
							Event.observe("nouvelle_liaison_depuis_reset", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_lib_article").value = "";
								$("nouvelle_liaison_ref_article").value = "";
								$("nouvelle_liaison_type_depuis_selected").selectedIndex = 0;
							}, false);
	
							Event.observe("nouvelle_liaison_depuis_reset_ratio", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_ratio_depuis").value = "1";
							}, false);
						
							Event.observe("nouvelle_liaison_depuis_show_mini_moteur_articles", "click",  function(evt){
								Event.stop(evt);
								show_mini_moteur_articles('recherche_article_set_article', "\'nouvelle_liaison_ref_article\', \'nouvelle_liaison_lib_article\'");
							}, false);
						
							Event.observe("nouvelle_liaison_depuis_valider", "click",  function(evt){
								Event.stop(evt);
								if($("nouvelle_liaison_ref_article").value != "" && $("nouvelle_liaison_lib_article").value != ""){
									var ratio = parseFloat($("nouvelle_liaison_ratio_depuis").value);
									link_article_to_article_view_depuis(parseInt($("serialisation_liaison").value), $("nouvelle_liaison_type_depuis_selected").options[$("nouvelle_liaison_type_depuis_selected").selectedIndex].value, "<?php echo $article->getRef_article();?>", $("nouvelle_liaison_ref_article").value, $("nouvelle_liaison_lib_article").value, ratio);
									$("nouvelle_liaison_lib_article").value = "";
									$("nouvelle_liaison_ref_article").value = "";
									$("nouvelle_liaison_ratio_depuis").value = "1";
									$("nouvelle_liaison_type_depuis_selected").selectedIndex = 0;
								}
							}, false);
						</script>
					</td>
				</tr>
			</table>
		</div>

		<br/>
		
		<div>
			<p class="liaison_texte_info"> Vous avez la possibilit&eacute; d'associer diff&eacute;rents articles &aacute; celui-ci, ceux-ci seront alors automatiquement li&eacute;s &aacute; la fiche produit.</p>
		</div>
	</div>
</div>
</div>
</div>




<div id="pop_up_invetory_article" class="edition_inventory">
</div>
<SCRIPT type="text/javascript">
//actions du menu
Event.observe('menu_1', "click", function(evt){
	page.verify("articles_view_info_gene","catalogue_articles_view_info_generales.php?ref_article=<?php echo $article->getRef_article ();?>", "true", "info_gene");
	view_menu_1('info_gene', 'menu_1', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('info_gene' , -32);
	Event.stop(evt);
});
<?php if($_SESSION['user']->check_permission ("6")){ ?>
Event.observe('menu_2', "click", function(evt){
	view_menu_1('gest_tarifs', 'menu_2', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('gest_tarifs' , -32);
	Event.stop(evt);
});
<?php
}
if ($art_categs->getModele() == "materiel" && $article->getVariante() != 2 && $GESTION_STOCK) {?>
Event.observe('menu_3', "click", function(evt){
	view_menu_1('gest_stock', 'menu_3', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('gest_stock' , -32);
	Event.stop(evt);
});
<?php } ?>
<?php if ($art_categs->getModele() == "service_abo") {?>
Event.observe('menu_3', "click", function(evt){
	view_menu_1('service_abo', 'menu_3', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('service_abo' , -32);
	Event.stop(evt);
});

	<?php
	if (isset($_REQUEST["service_abo"])) {
		?>
		view_menu_1('service_abo', 'menu_3', array_menu_v_article);
		set_tomax_height('service_abo' , -32);
		<?php
	}
	?>
	<?php
}
?>
<?php if ($art_categs->getModele() == "service_conso") {?>
Event.observe('menu_3', "click", function(evt){
	view_menu_1('service_conso', 'menu_3', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('service_conso' , -32);
	Event.stop(evt);
});

	<?php
	if (isset($_REQUEST["service_conso"])) {
		?>
		view_menu_1('service_conso', 'menu_3', array_menu_v_article);
		set_tomax_height('service_conso' , -32);
		<?php
	}
	?>
	<?php
}
?>

Event.observe("menu_4", "click",  function(evt){
	Event.stop(evt);
	view_menu_1('option_avancees', 'menu_4', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('option_avancees' , -32);
}, false);

<?php if ($article->getLot()) { ?>
Event.observe('menu_5', "click", function(evt){
	view_menu_1('gest_composition', 'menu_5', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('gest_composition' , -32);
	Event.stop(evt);
});
<?php } ?>
Event.observe('menu_6', "click", function(evt){
	view_menu_1('info_images', 'menu_6', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('info_images' , -32);
	Event.stop(evt);
});
Event.observe('menu_7', "click", function(evt){
	view_menu_1('stats', 'menu_7', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('stats' , -32);
	Event.stop(evt);
});
Event.observe('menu_8', "click", function(evt){
	view_menu_1('info_liaisons', 'menu_8', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('info_liaisoss' , -32);
	Event.stop(evt);
});
Event.observe('menu_9', "click", function(evt){
	view_menu_1('pieces_content', 'menu_9', array_menu_v_article);
	$("tool_uitem_menu").hide();
	set_tomax_height('pieces_content' , -32);
	page.traitecontent('pieces_ged','pieces_ged.php?ref_objet=<?php echo $article->getRef_article (); ?>&type_objet=article','true','pieces_content');
	Event.stop(evt);
});

function setheight_article_view(){
	set_tomax_height("info_gene" , -32);
	set_tomax_height('gest_stock' , -32);
	set_tomax_height('gest_tarifs' , -32);
	set_tomax_height('option_avancees' , -32);
}
Event.observe(window, "resize", setheight_article_view, false);
setheight_article_view();


//centrage de l'assistant tarif
//centrage du mini_moteur
//centrage edition de l'art_categ
//centrage edition des categ-carac
//centrage inventaire article

centrage_element("pop_up_assistant_tarif");
centrage_element("pop_up_assistant_tarif_iframe");
centrage_element("pop_up_view_categ_carac");
centrage_element("pop_up_view_categ_carac_iframe");
centrage_element("pop_up_invetory_article");
centrage_element("pop_up_edition_art_categ");
centrage_element("pop_up_edition_art_categ_iframe");
centrage_element("pop_up_mini_moteur_cata");
centrage_element("pop_up_mini_moteur_cata_iframe");
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_tarif_iframe");
centrage_element("pop_up_assistant_tarif");
centrage_element("pop_up_mini_moteur_cata_iframe");
centrage_element("pop_up_mini_moteur_cata");
centrage_element("pop_up_view_categ_carac_iframe");
centrage_element("pop_up_view_categ_carac");
centrage_element("pop_up_invetory_article");
centrage_element("pop_up_edition_art_categ_iframe");
centrage_element("pop_up_edition_art_categ");
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});

//on masque le chargement
H_loading();
</SCRIPT>