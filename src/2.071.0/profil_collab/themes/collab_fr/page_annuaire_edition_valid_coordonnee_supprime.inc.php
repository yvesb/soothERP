
<?php

// *************************************************************************************************************
// SUPPRESSION DE LA COORDONNEE D'UN CONTACT
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
<p>coordonnées: suppression dans un contact existant </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
if (count($_ALERTES)>0) {
echo "erreur";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
var coord_used=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	
	if ($alerte=="coord_used") {
		echo "coord_used=true;";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {



	if (coord_used) {
		texte_erreur += "Cette coordonnée est utilisée par un compte utilisateur.<br /> sa suppression est impossible.";
	}

	window.parent.alerte.alerte_erreur ('Suppression impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
<?php
foreach ($coords as $coord) {
	?>
	window.parent.refreshtagmobil('coordlist2','li','coordcontent', 'annuaire_edition_valid_view_coordonnee_nouvelle', '<?php echo $coord->ref_coord?>', '');	
	<?php
}
?>

window.parent.remove_tag ('coordcontent_li_<?php echo $_REQUEST['ref_idform']?>');
}
</script>