

<br/>
	<?php
	$tvacheck	= false;
	$art_categ->charger_tvas ();
	$checked_tvas= $art_categ-> getTvas_art_categ ();
	
	//liste des TVA par pays
	foreach ($tvas  as $tva){
	?>
	<input name="tva_<?php echo $tva["id_pays"];?>"  type="radio" value="<?php echo $tva['id_tva'];?>" <?php
		foreach ($checked_tvas as $checked_tva) {
	 	if ($checked_tva->id_tva==$tva['id_tva']) {echo ' checked="checked"'; $tvacheck	= true;};
	 	} ?>/>
	<?php echo htmlentities($tva['tva']);?>%<br />
	<?php 
	}
?>
	<input name="tva_<?php echo $tvas['0']["id_pays"];?>" type="radio" value="tva_non_applicable" <?php if (!$tvacheck) {echo 'checked="checked"'; }?>/>
	TVA Non applicable.<br />
<p style="text-align:center">
	<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" name="bt_valide_tvalist" id="bt_valide_tvalist"/>
</p>