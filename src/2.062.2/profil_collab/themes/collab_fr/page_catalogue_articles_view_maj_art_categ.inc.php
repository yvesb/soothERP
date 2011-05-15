
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
<p>article modif de l'art_categ </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var bad_modele=false;
var bad_poids=false;
var bad_modele=false;
var bad_seuil_alerte=false;
var erreur=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	
	if ($alerte=="bad_modele") {
		echo "bad_modele=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_poids") {
		echo "bad_poids=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_dure_garantie") {
		echo "bad_dure_garantie=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_seuil_alerte") {
		echo "bad_seuil_alerte=true;\n";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {

//limite basse des stock fauses
	if (bad_seuil_alerte) {
		texte_erreur += "il y a une erreur dans les quantités des seuils d'alerte de stock bas.<br/>";
	}
	
	//modele garantie fause
	if (bad_dure_garantie) {
		window.parent.document.getElementById("m_dure_garantie").className="alerteform_xsize";
		window.parent.document.getElementById("m_dure_garantie").focus();
		texte_erreur += "La durée de garantie dois être une valeur numérique.<br/>";
	}else {
		window.parent.document.getElementById("m_dure_garantie").className="classinput_xsize";
	}

	
	//modele poids faux
	if (bad_poids) {
		window.parent.document.getElementById("m_poids").className="alerteform_xsize";
		window.parent.document.getElementById("m_poids").focus();
		texte_erreur += "Le poids est d`\'une valeur incorecte.<br/>";
	}else {
		window.parent.document.getElementById("m_poids").className="classinput_xsize";
	}
	
	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

	window.parent.submit_in_way = false;
}
else
{
	window.parent.submit_in_way = false;

	window.parent.changed = false;
	window.parent.page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo $_REQUEST['mod_ref_article']?>&go=o_a','true','sub_content');

}
</script>