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
<p>ajout d'un type d'événement </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_comm_event_type_vide=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="lib_comm_event_type_vide") {
		echo "lib_comm_event_type_vide=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	

	if (lib_comm_event_type_vide) {
		window.parent.document.getElementById("lib_comm_event_type").className="alerteform_lsize";
		texte_erreur += "Vous devez indiquer un libellé au type d'événement.<br/>";
	} else {
		window.parent.document.getElementById("lib_comm_event_type_vide").className="classinput_lsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{

window.parent.changed = false;

window.parent.page.verify('annuaire_gestion_evenements_contact','annuaire_gestion_evenements_contact.php','true','sub_content');

}
</script>