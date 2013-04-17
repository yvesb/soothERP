<?php
// *************************************************************************************************************
// CONTROLE DU THEME
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
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('catalogue_articles_favoris','catalogue_articles_favoris.php',"true" ,"sub_content", "Ajout/Suppression des articles favoris");
update_menu_arbo();

id_index_contentcoord=0;
</script>
<div class="emarge">
    <p class="titre">Gestion des articles favoris </p>
    <div  class="contactview_corps">
        <form action="catalogue_articles_favoris_add.php" method="post" target="formFrame">
            <p>&nbsp; Indiquez la r&eacute;f&eacute;rence de l'article &agrave; ajouter aux favoris : <input type="text" value="" id="ref_art_fav" name="ref_art_fav"/></p>
            <br />
            <p style="text-align:center">
                <input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
            </p>
        </form>
    </div>
    <br />
    <br />
   Liste des articles favoris :
   <br />
   <br />
   <?php if (count($liste_articles_fav) >= 1)
   { ?>   <table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:20%">
			<a href="#"  id="order_simple_ref">R&eacute;f&eacute;rence
			</a>
		</td>
		<td style="width:30%" >
			<a href="#"  id="order_simple_lib">Libell&eacute;
			</a>
		</td>
		<td style="width:10%; text-align:center">&nbsp;</td>
		<td style="width:5%; text-align:center">&nbsp;</td>

		<td style="width:10%; text-align:center">
			<a href="#"  id="order_simple_tarif">&nbsp;
			</a>
		</td>
		<td style="width:15%">&nbsp;</td>
	</tr>
<?php
$colorise=0;
foreach ($liste_articles_fav as $ref_art_fav) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
$article = new article($ref_art_fav);
$ref_interne = $article->getRef_interne();
$ref_oem = $article->getRef_eom();
$lib_art_categ = $article->getLib_art_categ();
$nom_constructeur = $article->getNom_constructeur();
$lib_article = $article->getLib_article();
?>
<tr class="<?php  echo  $class_colorise?>" id="line_art_<?php echo ($ref_art_fav)?>">
	<td class="reference" style="width:20%">
		<a  href="#" id="link_art_ref_<?php echo ($ref_art_fav)?>" style="display:block; width:100%">
		<?php	if ($ref_interne!="") { echo ($ref_interne)."&nbsp;";}else{ echo ($ref_art_fav)."&nbsp;";}?><br />
		<?php	if ($ref_oem) { echo ($ref_oem)."&nbsp;";}?>
		</a>
	</td>
	<td style="width:30%">
		<a  href="#" id="link_art_lib_<?php echo ($ref_art_fav)?>" style="display:block; width:100%">
		<span class="lib_categorie"><?php	if ($lib_art_categ) 				{ echo ($lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($nom_constructeur && $_SESSION['user']-> check_permission("22",$CONSTRUCTEUR_ID_PROFIL)) { echo ($nom_constructeur)."&nbsp;";}?></span><br />
		<span class="r_art_lib"><?php echo nl2br(($lib_article))?></span>
		</a>
		<div style="position:relative">
		<div id="line_aff_img_<?php echo ($ref_art_fav)?>" style="display:none; position:absolute">
		<img src="" id="id_img_line_<?php echo ($ref_art_fav)?>" />
		</div>
		</div>
	</td>
	<td style="text-align:center; width:10%; ">
	</td>
	<td style="width:5%; text-align:center">
	</td>
	<td style="text-align:right; width:10%;">
	</td>
	<td style="vertical-align:middle; text-align:center; width:15%">
        <a  href="#" id="link_art_del_<?php echo ($ref_art_fav)?>" style="text-decoration:underline">Supprimer</a>
		<script type="text/javascript">
                Event.observe("link_art_del_<?php echo ($ref_art_fav)?>", "click",  function(evt){Event.stop(evt); del_art_fav('<?php echo $ref_art_fav ?>');}, false);
		</script>
	</td>
	</tr>

<?php
}
?> </table>
<?php } ?>
</div>
<?php



?>
