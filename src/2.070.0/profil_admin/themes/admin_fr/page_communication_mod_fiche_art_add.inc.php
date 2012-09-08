<?php

// *************************************************************************************************************
// ajout de modèle d'article pdf
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>modèle de documents pdf (ajouter un nouveau) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var choisir_id_type_article = false;
var choisir_source = false;
var indiquer_lib_modele = false;
var choisir_id_pdf_modele = false;
var indiquer_fichiers_source = false;
var exist_pdf_modele = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="choisir_id_type_article") {
		echo "choisir_id_type_article=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="choisir_source") {
		echo "choisir_source=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="indiquer_lib_modele") {
		echo "indiquer_lib_modele=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="choisir_id_pdf_modele") {
		echo "choisir_id_pdf_modele=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="indiquer_fichiers_source") {
		echo "indiquer_fichiers_source=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="exist_pdf_modele") {
		echo "exist_pdf_modele=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
	if (choisir_id_type_article) {
		window.parent.document.getElementById("choix_type_article").className="alerteform_xsize";
		texte_erreur += "Vous devez sélectionner un type de document.<br/>";
	} else {
		window.parent.document.getElementById("choix_type_article").className="classinput_xsize";
	}
	if (choisir_source) {
		texte_erreur += "Vous devez indiquez la source utilisée.<br/>";
	}
	if (indiquer_lib_modele) {
		window.parent.document.getElementById("lib_modele").className="alerteform_xsize";
		texte_erreur += "Vous devez indiquer un libellé au nouveau modèle.<br/>";
	} else {
		window.parent.document.getElementById("lib_modele").className="classinput_xsize";
	}
	if (choisir_id_pdf_modele) {
		window.parent.document.getElementById("choix_id_pdf_article").className="alerteform_xsize";
		texte_erreur += "Vous devez sélectionner un modèle de document source.<br/>";
	} else {
		window.parent.document.getElementById("choix_id_pdf_article").className="classinput_xsize";
	}
	if (indiquer_fichiers_source) {
		window.parent.document.getElementById("file_1").className="alerteform_nsize";
		window.parent.document.getElementById("file_2").className="alerteform_nsize";
		texte_erreur += "Vous devez indiquer les emplacements du fichier configuration et du fichier de classe du nouveau modèle.<br/>";
	} else {
		window.parent.document.getElementById("file_1").className="classinput_nsize";
		window.parent.document.getElementById("file_2").className="classinput_nsize";
	}

	if (exist_pdf_modele) {
		texte_erreur += "Ce modèle PDF est déjà installé dans LMB.<br/>";
	}
	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;
window.parent.page.traitecontent('Communication_mod_fiche_art','communication_mod_fiche_art.php','true','sub_content');
window.parent.alerte.alerte_erreur ('Nouveau modèle ajouté', 'Ce nouveau modèle d\'impression est désormais disponible, cliquez sur « Utiliser un nouveau modèle d\'impression. » et activez le.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}

</script>