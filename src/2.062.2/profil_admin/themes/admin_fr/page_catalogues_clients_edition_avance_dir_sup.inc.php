
<?php

// *************************************************************************************************************
// SUPPRESSION D'UNE CATEGORIE D'UN CATALOGUE CLIENT
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
<p>categorie d'un catalogue client Suppression</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_lib_catalogue_client_dir=false;
var bad_new_id_catalogue_dir_parent=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="bad_lib_catalogue_client_dir") {
		echo "erreur=true;";
		echo "bad_lib_catalogue_client_dir=true;\n";
	}
	if ($alerte=="bad_new_id_catalogue_dir_parent") {
		echo "erreur=true;";
		echo "bad_new_id_catalogue_dir_parent=true;\n";
	}
}

?>
if (erreur) {
	if (bad_new_id_catalogue_dir_parent) {
		texte_erreur += "La catégorie de remplacement ne conviend pas.<br />";
	}

window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{
<?php 
if (isset ($_REQUEST['id_catalogue_client']) ) {?>
window.parent.changed = false;
window.parent.page.verify('catalogues_clients_edition_avance_content','catalogues_clients_edition_avance_content.php?id_catalogue_client=<?php echo $_REQUEST['id_catalogue_client']?>','true','edition_catalogue_client_avance_content');
<?php }?>
}
</script>