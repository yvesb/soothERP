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
<p>ccontact ajout d'événement </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
var bad_date_event= false;
var exist_fitid = false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_date_event") {
		echo "bad_date_event=true;";
		echo "erreur=true;\n";
	}

}

?>
if (erreur) {

	if (bad_date_event) {
			window.parent.document.getElementById("date_event").className="alerteform_nsize";
		texte_erreur += "Vérifier la date de l'événement.<br />";
	} else {
		window.parent.document.getElementById("date_event").className="classinput_nsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.document.getElementById("edition_event").style.display = "none";
window.parent.changed = false;
window.parent.page.verify('annuaire_view_evenements','annuaire_view_evenements.php?ref_contact=<?php echo $contact->getRef_contact();?>','true','contactview_evenements');
}
</script>