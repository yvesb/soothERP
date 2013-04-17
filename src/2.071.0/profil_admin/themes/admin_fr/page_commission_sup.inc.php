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
<p>liste_comm SUP </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

foreach ($_INFOS as $info => $value) {
	echo $info." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_id_commission_regle_remplacement=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="bad_id_commission_regle_remplacement") {
		echo "bad_id_commission_regle_remplacement=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	window.parent.alerte.alerte_erreur ('Veuillez sélectionner une grille de remplacement', '','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
<?php
if (isset($_REQUEST['id_commission_regle'])) {?>
window.parent.changed = false;

window.parent.page.verify('configuration_commission','configuration_commission.php','true','sub_content');
<?php
}
?>
}
</script>