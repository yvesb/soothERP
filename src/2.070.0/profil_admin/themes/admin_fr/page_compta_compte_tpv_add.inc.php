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
<p>comptes tpv (ajouter) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var no_module=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
	if ($alerte=="no_module") {
		echo "no_module=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
	if (no_module) {
		window.parent.document.getElementById("module_name").className="alerteform_xsize";
		texte_erreur += "Vous devez installer et selectionner un module de paiement virtuel.<br/>";
	} else {
		window.parent.document.getElementById("module_name").className="classinput_xsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('compta_compte_tpv','compta_compte_tpv.php','true','sub_content');

}
</script>