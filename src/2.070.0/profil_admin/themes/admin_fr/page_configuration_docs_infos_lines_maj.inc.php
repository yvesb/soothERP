<?php
// *************************************************************************************************************
// MAJ D'UN MODELE DE LIGNE D'INFORMATION DE DOCUMENTS
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
<p>modèle de ligne d'info(maj) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
var bad_id_type_doc = false;
var bad_lib_line = false;

<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_id_type_doc") {
		echo "bad_id_type_doc=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_lib_line") {
		echo "bad_lib_line=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
	if (bad_id_type_doc) {
		texte_erreur += "Sélectionnez au moins un type de document.<br/>";
	}
	
	if (bad_lib_line) {
		window.parent.document.getElementById("lib_line").className="alerteform_xsize";
		texte_erreur += "Indiquez le libellé de la ligne.<br/>";
	} else {
		window.parent.document.getElementById("lib_line").className="classinput_xsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('configuration_docs_infos_lines','configuration_docs_infos_lines.php','true','sub_content');

}
</script>