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
<p>modification d'un type d'événement </p>
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
	<?php if (isset($_REQUEST["id_comm_event_type"])) { ?>
		window.parent.document.getElementById("lib_comm_event_type_<?php echo $_REQUEST["id_comm_event_type"];?>").className="alerteform_lsize";
	<?php } ?>
		texte_erreur += "Vous devez indiquer un libellé au type d'événement.<br/>";
	} else {
	<?php if (isset($_REQUEST["id_comm_event_type"])) { ?>
		window.parent.document.getElementById("lib_comm_event_type_vide_<?php echo $_REQUEST["id_comm_event_type"];?>").className="classinput_lsize";
	<?php } ?>
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{

window.parent.changed = false;

window.parent.page.verify('annuaire_gestion_evenements_contact','annuaire_gestion_evenements_contact.php','true','sub_content');

}
</script>