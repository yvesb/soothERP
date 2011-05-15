<?php

// *************************************************************************************************************
// ARCHIVAGE D'ARTICLE PERIMES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);




	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Affichage des résultats
?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('archiver_perimer','stocks_archiver_perime.php','true','sub_content', "Archiver les articles périmés");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Liste des articles mis en archive</p>
<div   class="mt_size_optimise">

<?php echo count($fiches);?> articles archivés
<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:20%">R&eacute;f&eacute;rence
		</td>
		<td >Libell&eacute;
		</td>
		<td style="width:15%; text-align:center">
		</td>
		<td style="width:5%"></td>
		<td style="width:5%"></td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>">
	<td class="reference">
		<a  href="#" id="link_art_ref_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%">
		<?php	if ($fiche->ref_interne!="") { echo htmlentities($fiche->ref_interne)."&nbsp;";}else{ echo htmlentities($fiche->ref_article)."&nbsp;";}?><br />
		<?php	if ($fiche->ref_oem) { echo htmlentities($fiche->ref_oem)."&nbsp;";}?>		
		</a>
		<script type="text/javascript">
		Event.observe("link_art_ref_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo $fiche->ref_article;?>'),'true','_blank');}, false);
		</script>
	</td>
	<td>
		<a  href="#" id="link_art_lib_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%">
		<span class="lib_categorie"><?php	if ($fiche->lib_art_categ) 				{ echo htmlentities($fiche->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($fiche->nom_constructeur) { echo htmlentities($fiche->nom_constructeur)."&nbsp;";}?></span><br />
		<span class="r_art_lib"><?php echo nl2br(htmlentities($fiche->lib_article))?></span>
		</a>
		<script type="text/javascript">
		Event.observe("link_art_lib_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo $fiche->ref_article;?>'),'true','_blank');}, false);
		</script>
	</td>
	<td style="text-align:right">
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a  href="#" id="link_art_voir_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%; text-decoration:underline">Voir</a>
		<script type="text/javascript">
		Event.observe("link_art_voir_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');}, false);
		</script>
	
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a  href="#" id="link_art_edit_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%; text-decoration:underline">Editer</a>
		<script type="text/javascript">
		Event.observe("link_art_edit_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_edition','index.php#'+escape('catalogue_articles_edition.php?ref_article=<?php echo $fiche->ref_article;?>'),'true','_blank');}, false);
		</script>
	
	</td>
	</tr>
	
<?php
}
?></table>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
</div>


<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>