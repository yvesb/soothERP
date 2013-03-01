
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
<p>gestion categories_client  sup </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var last_id_client_categ = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
	foreach ($_ALERTES as $alerte => $value) {
		if ($alerte == "last_id_client_categ") {
			echo "last_id_client_categ=true;";
			echo "erreur=true;\n";
		}
	}
}

?>
if (erreur) {
	
	if (last_id_client_categ) {
		texte_erreur += "Cette catégorie de client est votre catégorie par defaut.<br/> Vous ne pouvez la supprimer.";
	}

	window.parent.alerte.alerte_erreur ('Suppression impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{

window.parent.changed = false;

window.parent.page.verify('annuaire_gestion_categ_client','annuaire_gestion_categories_client.php','true','sub_content');

}
</script>