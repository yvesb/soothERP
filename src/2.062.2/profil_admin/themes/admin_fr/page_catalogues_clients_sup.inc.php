<?php

// *************************************************************************************************************
// SUPPRESSION D'UN CATALOGUE CLIENT
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

?><p>&nbsp;</p>
<p>Suppression d'un catalogue client</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var used_catalogue_client = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte =="used_catalogue_client") {
		echo "used_catalogue_client = true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
 if (used_catalogue_client) {
	texte_erreur += "Ce catalogue est utilisé par un magasin, veuillez modifier ce choix dans le menu Point de vente.<br/>";
 }
	window.parent.alerte.alerte_erreur ('Suppression impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
window.parent.changed = false;
window.parent.page.verify('catalogues_clients_liste','catalogues_clients_liste.php','true','content_catalogues_clients');

}
</script>
