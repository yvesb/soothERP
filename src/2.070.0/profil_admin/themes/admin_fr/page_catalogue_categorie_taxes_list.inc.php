

<br/>
	<?php
	$tvacheck	= false;
	$checked_taxes= $art_categ-> getTaxes ();
	
// liste des taxes par pays
		foreach ($taxes  as $taxe){
	?>
	<input name="taxe_<?php echo $taxe['id_taxe'];?>" id="taxe_<?php echo $taxe['id_taxe'];?>" type="checkbox" value="<?php echo $taxe['id_taxe'];?>" <?php
		foreach ($checked_taxes as $checked_taxe) {
	 	if ($checked_taxe->id_taxe==$taxe['id_taxe']) {echo ' checked="checked"'; };
	 	} ?>/>
	 		<?php echo htmlentities($taxe['lib_taxe']);?> (<?php echo htmlentities($taxe['info_calcul']);?>)<br />
<?php 

	}
?>

<p style="text-align:center">
	<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" name="bt_valide_tvalist" id="bt_valide_tvalist"/>
</p>

