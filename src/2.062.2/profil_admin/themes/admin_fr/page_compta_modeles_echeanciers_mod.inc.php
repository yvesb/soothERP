
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
<p>modèles échéanciers (Modification) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_id_modele_echeancier = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_id_modele_echeancier") {
		echo "bad_id_modele_echeancier=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('compta_modeles_echeanciers','compta_modeles_echeanciers.php','true','sub_content');

}
</script>