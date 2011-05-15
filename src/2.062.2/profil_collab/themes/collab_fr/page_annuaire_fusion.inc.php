
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
<p>contact ajout </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var bad_ref_contact=false;
var erreur=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_ref_contact") {
		echo "bad_ref_contact=true;\n";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {

if (bad_ref_contact) {
		texte_erreur += "La référence du contact est invalide.<br/>";
}

window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{
<?php 
if (isset ($_INFOS['fusion_ok']) &&  $_INFOS['fusion_ok']) {
	?>
	window.parent.changed = false;
	window.parent.page.verify('annuaire_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo $_REQUEST['new_ref_contact']?>','true','sub_content');
	<?php 
}
?>
}
</script>