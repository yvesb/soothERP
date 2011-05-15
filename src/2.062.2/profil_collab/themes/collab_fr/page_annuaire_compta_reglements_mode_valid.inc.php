<?php

// *************************************************************************************************************
// REGLEMENT ENTRANT ESPECES
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
<p>ajout d'un règlement</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_montant_reglement = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_montant_reglement") {
		echo "bad_montant_reglement=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
	if (bad_montant_reglement) {
		window.parent.document.getElementById("montant_reglement").className="alerteform_xsize";
		texte_erreur += "Le montant indiqué n'est pas valide.<br/>";
	} else {
		window.parent.document.getElementById("montant_reglement").className="classinput_xsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;
	window.parent.document.getElementById("contact_add_reglement").innerHTML = "Règlement effectué";
}
</script>