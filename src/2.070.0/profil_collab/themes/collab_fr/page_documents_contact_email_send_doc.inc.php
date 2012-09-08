
<?php

// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR EMAIL envois rapide vers 1 destinataire
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
<p>envois du document par email à un destinataire</p>
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
if ($erreur_email) {
		echo "erreur=true;\n";	
}

?>
if (erreur) {
	texte_erreur += "<?php echo $msg;?>";
	alerte.alerte_erreur ('Erreur lors de l\'envoi', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{
	texte_erreur = "Le document a bien été envoyé";
	alerte.alerte_erreur ('Confirmation de l\'envoi', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
</script>