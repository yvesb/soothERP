<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>enregistrement du courrier</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
	var erreur=false;
	var texte_erreur = "";
	<?php 
	if (count($_ALERTES)>0) {}
	?>
	if (erreur) {}
	else{
		window.parent.alerte.alerte_erreur ('Enregistrement du courrier', 'Le courrier a été bien été enregistré','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		//window.parent.changed = false;
		window.parent.page.traitecontent('communication_courrier','annuaire_view_courriers.php?ref_contact=<?php echo $ref_destinataire; ?>','true','contactview_courrier');
		//window.parent.document.getElementById("edition_courrier").style.display = "none";
	}
</script>