
<?php

// *************************************************************************************************************
// ARCHIVAGE DU CONTACT
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
<p>contact archivage </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var contact_entreprise=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="contact_entreprise") {
		echo "contact_entreprise=true;";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {

	if (contact_entreprise) {
		texte_erreur += "Le contact principal de l'application ne peut être archivé.";
	}
	window.parent.alerte.alerte_erreur ('Archivage impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{

	window.parent.changed = false;
	window.parent.page.verify('default_content','accueil.php','false','sub_content');

}
</script>