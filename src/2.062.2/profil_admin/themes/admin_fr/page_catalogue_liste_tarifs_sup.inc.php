
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
<p>liste_tarif SUP </p>
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
var magasin_using_tarif=false;
var last_liste_tarif=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="magasin_using_tarif") {
		echo "magasin_using_tarif=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="last_liste_tarif") {
		echo "last_liste_tarif=true;\n";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {

if (magasin_using_tarif) {
window.parent.alerte.confirm_supprimer('catalogue_liste_tarifs_sup_impossible', '');
		}
if (last_liste_tarif) {
window.parent.alerte.confirm_supprimer('catalogue_liste_tarifs_last_liste_tarif', '');
		}

}
else
{
<?php
if (isset($_REQUEST['id_tarif'])) {?>
window.parent.changed = false;

window.parent.page.verify('configuration_tarifs','configuration_tarifs.php','true','sub_content');
<?php
}
?>
}
</script>