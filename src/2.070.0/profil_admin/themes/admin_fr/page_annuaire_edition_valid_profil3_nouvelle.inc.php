
<?php

// *************************************************************************************************************
// NOUVEAU PROFIL COLLAB
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
<p>nouveau profil collab</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var nbre_enfants=false;
var erreur=false;
var texte_erreur = "";
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_nbre_enfants") {
		echo "nbre_enfants=true;\n";
	}
	
}


?>
if (erreur) {
	if (nbre_enfants) {
	window.parent.document.getElementById("collab_nbre_enfants").className="alerteform_xsize";
	window.parent.document.getElementById("collab_nbre_enfants").focus();
	texte_erreur += "La valeur saisie pour le nombre d'enfant du profil collaborateur est invalide.<br/>";
	}else {
	window.parent.document.getElementById("collab_nbre_enfants").className="classinput_xsize";
	}
	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
window.parent.switchprofil_new_edit("<?php echo $id_profil?>", "typeprofil<?php echo $id_profil?>", "annuaire_edition_valid_view_profil_nouvelle");
window.parent.switchprofil_new_edit("<?php echo $id_profil?>", "type_fiche", "annuaire_edition_check_profil");
}
</script>