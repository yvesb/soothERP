<table style="width:100%">
<tr>
<td>
<div class="profil_reduce">
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil6_suppression" name="annu_edition_profil6_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations constructeur </p>
<div class="reduce_in_edit_mode">
<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil6" name="annu_edition_profil6" target="formFrame" style="display:none;">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">R&eacute;f&eacute;rence revendeur:</span>
			</td>
			<td>
				<input name="identifiant_revendeur" id="identifiant_revendeur" type="text" class="classinput_xsize" value="<?php echo 		htmlentities($profils[$id_profil]->getIdentifiant_revendeur ()) ?>" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions de garantie:</span>
			</td>
			<td>
				<textarea name="conditions_garantie" id="conditions_garantie" class="classinput_xsize"><?php echo htmlentities($profils[$id_profil]->getConditions_garantie ()) ?></textarea>
			</td>
		</tr>
	</table>
	<p style="text-align:center">
<input type="image" name="profsubmit<?php echo $id_profil?>" id="profsubmit<?php echo $id_profil?>"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
</p>
	</form>
	
	<table class="minimizetable"  id="start_visible_profil<?php echo $id_profil?>">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">R&eacute;f&eacute;rence revendeur:</span>
			</td>
			<td>
			<a href="#" id="show6_identifiant_revendeur" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getIdentifiant_revendeur ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions de garantie:</span>
			</td>
			<td>
			<a href="#" id="show6_conditions_garantie" class="modif_input1"><?php echo  nl2br(htmlentities($profils[$id_profil]->getConditions_garantie ()))?></a>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
			 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" id="modifier_profil<?php echo $id_profil?>" />
			</td>
		</tr>
	</table>
	
	
<script type="text/javascript" language="javascript">
Event.observe("modifier_profil<?php echo $id_profil?>", "click",  function(evt){
	Event.stop(evt); 
	$('annu_edition_profil<?php echo $id_profil?>').toggle();
	$('start_visible_profil<?php echo $id_profil?>').toggle();
}, false);

Event.observe("show6_conditions_garantie", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','conditions_garantie');}, false);

Event.observe("show6_identifiant_revendeur", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','identifiant_revendeur');}, false);
new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});

//on masque le chargement
H_loading();

</script>
</div>
</div>


<br />
<br />

<?php 
if (count($last_constructeur_articles)) {
?>
<p class="sous_titre1">Derniers articles ajoutés</p>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:20%">
			<a href="#"  id="order_simple_ref">R&eacute;f&eacute;rence
			</a>
		</td>
		<td >
			<a href="#"  id="order_simple_lib">Libell&eacute;
			</a>
		</td>
		<td style="width:15%; text-align:center">Stock</td>
		<td style="width:5%"></td>
	</tr>
<?php 
$colorise=0;
foreach ($last_constructeur_articles as $last_article) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>" id="line_art_<?php echo ($last_article->ref_article)?>">
	<td class="reference">
		<a  href="#" id="link_art_ref_<?php echo htmlentities($last_article->ref_article)?>" style="display:block; width:100%">
		<?php	if ($last_article->ref_interne!="") { echo htmlentities($last_article->ref_interne)."&nbsp;";}else{ echo htmlentities($last_article->ref_article)."&nbsp;";}?><br />
		<?php	if ($last_article->ref_oem) { echo htmlentities($last_article->ref_oem)."&nbsp;";}?>		
		</a>
		<script type="text/javascript">
		Event.observe("link_art_ref_<?php echo htmlentities($last_article->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo htmlentities($last_article->ref_article)?>','true','sub_content');}, false);
		</script>
	</td>
	<td>
		<a  href="#" id="link_art_lib_<?php echo htmlentities($last_article->ref_article)?>" style="display:block; width:100%">
		<span class="lib_categorie"><?php	if ($last_article->lib_art_categ) 				{ echo htmlentities($last_article->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($last_article->nom_constructeur) { echo htmlentities($last_article->nom_constructeur)."&nbsp;";}?></span><br />
		<span class="r_art_lib"><?php echo nl2br(htmlentities($last_article->lib_article))?></span>
		</a>
		<script type="text/javascript">
		Event.observe("link_art_lib_<?php echo htmlentities($last_article->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo htmlentities($last_article->ref_article)?>','true','sub_content');}, false);
		</script>
		<div style="position:relative">
		<div id="line_aff_img_<?php echo ($last_article->ref_article)?>" style="display:none; position:absolute">
		<img src="" id="id_img_line_<?php echo ($last_article->ref_article)?>" />
		</div>
		</div>
	</td>
	<td style="text-align:center">
		<a href="#" id="aff_resume_stock_<?php echo ($last_article->ref_article);?>">
		<?php	if (isset($last_article->stock)) { echo htmlentities($last_article->stock); } else { echo "0";}?>
		</a>
		<script type="text/javascript">
		Event.observe("aff_resume_stock_<?php echo ($last_article->ref_article);?>", "click", function(evt){show_resume_stock("<?php echo $last_article->ref_article;?>", evt); Event.stop(evt);}, false);
		</script>
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a  href="#" id="link_art_voir_<?php echo htmlentities($last_article->ref_article)?>" style="display:block; width:100%; text-decoration:underline">Voir</a>
		<script type="text/javascript">
		Event.observe("link_art_voir_<?php echo htmlentities($last_article->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($last_article->ref_article)?>'),'true','_blank');}, false);
		
		<?php 
		if (isset($last_article->lib_file) && $last_article->lib_file != "") {
			?>
			Event.observe("line_art_<?php echo ($last_article->ref_article)?>", "mouseover",  function(evt){
				Event.stop(evt);
				$("line_aff_img_<?php echo ($last_article->ref_article)?>").style.display="";
				$("id_img_line_<?php echo ($last_article->ref_article)?>").src="<?php echo $ARTICLES_MINI_IMAGES_DIR.$last_article->lib_file;?>";
				//positionne_element(evt, "line_aff_img");
			}, false);
			Event.observe("line_art_<?php echo ($last_article->ref_article)?>", "mouseout",  function(evt){
				Event.stop(evt);
				$("line_aff_img_<?php echo ($last_article->ref_article)?>").style.display="none";
			}, false);
			<?php
		}
		?>
		</script>
	
	</td>
	</tr>
	
<?php
}
?></table>

<?php
}
?>


</td>
<td style="width:35%">
<table border="0" cellspacing="0" cellpadding="0" style="width:100%; border:1px solid #93bad7">
	<tr style="background-color:#93bad7;">
		<td>&nbsp;</td>
		<td style="text-align:right;font-weight:bolder; width:20%">N</td>
		<td style="text-align:right;font-weight:bolder; width:20%">N-1</td>
		<td style="text-align:right;font-weight:bolder; width:20%">N-2</td>
	</tr>
	<tr>
		<td style=" font-weight:bolder;background-color:#93bad7; width:20%">C.A. ventes </td>
		<td style="text-align:right">
		<?php if (isset($constructeur_vente_CA[0])) {?>
		<?php echo price_format($constructeur_vente_CA[0])." ".$MONNAIE[1];?>
		<?php } ?>
		</td>
		<td style="text-align:right">
		<?php if (isset($constructeur_vente_CA[1])) {?>
		<?php echo price_format($constructeur_vente_CA[1])." ".$MONNAIE[1];?>
		<?php } ?>
		</td>
		<td style="text-align:right">
		<?php if (isset($constructeur_vente_CA[2])) {?>
		<?php echo price_format($constructeur_vente_CA[2])." ".$MONNAIE[1];?>
		<?php } ?>
		</td>
	</tr>
</table>

<br />

<table border="0" cellspacing="0" cellpadding="0" style="width:100%; border:1px solid #93bad7">
	<tr style="background-color:#93bad7;">
		<td>&nbsp;</td>
		<td style="text-align:right;font-weight:bolder; width:20%">N</td>
		<td style="text-align:right;font-weight:bolder; width:20%">N-1</td>
		<td style="text-align:right;font-weight:bolder; width:20%">N-2</td>
	</tr>
	<tr>
		<td style=" font-weight:bolder;background-color:#93bad7; width:20%">C.A. achats </td>
		<td style="text-align:right">
		<?php if (isset($constructeur_achat_CA[0])) {?>
		<?php echo price_format($constructeur_achat_CA[0])." ".$MONNAIE[1];?>
		<?php } ?>
		</td>
		<td style="text-align:right">
		<?php if (isset($constructeur_achat_CA[1])) {?>
		<?php echo price_format($constructeur_achat_CA[1])." ".$MONNAIE[1];?>
		<?php } ?>
		</td>
		<td style="text-align:right">
		<?php if (isset($constructeur_achat_CA[2])) {?>
		<?php echo price_format($constructeur_achat_CA[2])." ".$MONNAIE[1];?>
		<?php } ?>
		</td>
	</tr>
</table>
<br />
 <br />

<span style="font-weight:bolder">Nombre d'articles en catalogue : <?php echo $constructeur_nb_articles;?></span>
<br />
<span style="font-weight:bolder">Nombre de catégories pour ces articles : <?php echo $constructeur_nb_art_categ;?></span><br />
<?php 
if (count($constructeur_fournisseurs_liste)) {
	?>
	<p class="sous_titre2">Liste des fournisseurs:</p>
	<?php
	foreach ($constructeur_fournisseurs_liste as $fournisseur) {
		?>
		<a href="index.php#annuaire_view_fiche.php?ref_contact=<?php echo $fournisseur->ref_fournisseur;?>" target="_blank" style=" color:#000000; text-decoration:underline"><?php echo nl2br($fournisseur->nom);?></span><br />
		<?php 
	}
}
?>

</td>
</tr>
</table>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock" class="resume_stock">
</div>