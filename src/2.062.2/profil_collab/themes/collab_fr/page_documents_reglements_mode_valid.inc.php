
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

if (window.parent.montant_total_neg) {
	window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $ref_doc; ?>&montant_neg=1','true','reglements_content');
} else {
	window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $ref_doc; ?>','true','reglements_content');
}
window.parent.page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc=<?php echo $ref_doc; ?>','true','block_head');

if (window.parent.reglement_rapide) {
	window.parent.view_menu_1('document_content', 'menu_1', window.parent.array_menu_e_document);  
	window.parent.set_tomax_height('document_content' , -32); 
	window.parent.reglement_rapide = false;
}

}
</script>