
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
<p>article ajout </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var ref_interne_exist=false;
var lib_article_vide=false;
var ref_art_categ_vide=false;
var bad_poids=false;
var bad_dure_garantie=false;
var bad_modele=false;
var bad_indice_qte=false;
var bad_qte=false;
var code_barre_exist=false;
var bad_seuil_alerte=false;
var no_variantes_selected=false;
var bad_duree=false;
var bad_engagement=false;
var bad_reconduction=false;
var bad_preavis=false;
var erreur=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	
	if ($alerte=="ref_interne_exist") {
		echo "ref_interne_exist=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="lib_article_vide") {
		echo "lib_article_vide=true;\n";
		echo "erreur=true;\n";
	}	
	if ($alerte=="ref_art_categ_vide") {
		echo "ref_art_categ_vide=true;\n";
		echo "erreur=true;\n";
	}	
	if ($alerte=="bad_poids") {
		echo "bad_poids=true;\n";
		echo "erreur=true;\n";
	}	
	if ($alerte=="bad_dure_garantie") {
		echo "bad_dure_garantie=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="code_barre_exist") {
		echo "code_barre_exist=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_indice_qte") {
		echo "bad_indice_qte=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_qte") {
		echo "bad_qte=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_seuil_alerte") {
		echo "bad_seuil_alerte=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="no_variantes_selected") {
		echo "no_variantes_selected=true;";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="bad_duree") {
		echo "bad_duree=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_engagement") {
		echo "bad_engagement=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_reconduction") {
		echo "bad_reconduction=true;";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="bad_preavis") {
		echo "bad_preavis=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	//modele dure service abo faux
	if (bad_duree) {
		window.parent.document.getElementById("duree_abo_mois").className="alerteform_nsize";
		window.parent.goto_etape(2);
		window.parent.document.getElementById("duree_abo_mois").focus();
		texte_erreur += "La durée d'abonnement est d\'une valeur incorrecte.<br/>";
	}else {
		//window.parent.document.getElementById("duree_abo_mois").className="classinput_nsize";
	}
	//modele engagement service abo faux
	if (bad_engagement) {
		window.parent.document.getElementById("engagement").className="alerteform_nsize";
		window.parent.goto_etape(2);
		window.parent.document.getElementById("engagement").focus();
		texte_erreur += "La durée d'engagement est d\'une valeur incorrecte.<br/>";
	}else {
		//window.parent.document.getElementById("engagement").className="classinput_nsize";
	}
	//modele reconduction service abo faux
	if (bad_reconduction) {
		window.parent.document.getElementById("reconduction").className="alerteform_nsize";
		window.parent.goto_etape(2);
		window.parent.document.getElementById("reconduction").focus();
		texte_erreur += "Le nombre de reconduction est d\'une valeur incorrecte.<br/>";
	}else {
		//window.parent.document.getElementById("reconduction").className="classinput_nsize";
	}
	//modele preavis service abo faux
	if (bad_preavis) {
		window.parent.document.getElementById("preavis_abo_mois").className="alerteform_nsize";
		window.parent.goto_etape(2);
		window.parent.document.getElementById("preavis_abo_mois").focus();
		texte_erreur += "La durée de préavis est d\'une valeur incorrecte.<br/>";
	}else {
		//window.parent.document.getElementById("preavis_abo_mois").className="classinput_nsize";
	}
	
	
	
	//qte de composant fausse
	if (bad_qte) {
		window.parent.goto_etape(4);
		texte_erreur += "il y a une erreur dans la quantité d'un des composants.<br/>";
	}
	
	//qte de tarif fausse
	if (bad_indice_qte) {
		window.parent.goto_etape(4);
		texte_erreur += "il y a une erreur dans la quantité d'un des tarifs.<br/>";
	}
	
	//modele garantie fause
	if (code_barre_exist) {
		window.parent.document.getElementById("a_code_barre").className="alerteform_xsize";
		window.parent.goto_etape(2);
		window.parent.document.getElementById("a_code_barre").focus();
		texte_erreur += "Un des codes barres existe déjà.<br />";
	}else {
		//window.parent.document.getElementById("a_code_barre").className="classinput_xsize";
	}
	
	//limite basse des stock fauses
	if (bad_seuil_alerte) {
		window.parent.goto_etape(2);
		texte_erreur += "il y a une erreur dans les quantités des seuils d'alerte de stock bas.<br/>";
	}
	
	//modele garantie fause
	if (bad_dure_garantie) {
		window.parent.document.getElementById("dure_garantie").className="alerteform_xsize";
		window.parent.goto_etape(2);
		window.parent.document.getElementById("dure_garantie").focus();
		texte_erreur += "La durée de garantie dois être une valeur numérique.<br/>";
	}else {
		//window.parent.document.getElementById("dure_garantie").className="classinput_xsize";
	}

	
	//modele poids faux
	if (bad_poids) {
		window.parent.document.getElementById("poids").className="alerteform_xsize";
		window.parent.goto_etape(2);
		window.parent.document.getElementById("poids").focus();
		texte_erreur += "Le poids est d`\'une valeur incorrecte.<br/>";
	}else {
		//window.parent.document.getElementById("poids").className="classinput_xsize";
	}
	
	
	//ref_interne_exist
	if (ref_interne_exist) {
		window.parent.document.getElementById("ref_interne").className="alerteform_xsize";
		window.parent.goto_etape(0);
		window.parent.document.getElementById("ref_interne").focus();
		texte_erreur += "La référence interne existe déjà.<br/>";
	}else {
		//window.parent.document.getElementById("ref_interne").className="classinput_xsize";
	}

	//lib de l'article vide
	if (lib_article_vide) {
		window.parent.document.getElementById("lib_article").className="alerteform_xsize";
		window.parent.goto_etape(0);
		window.parent.document.getElementById("lib_article").focus();
		texte_erreur += "Le libellé de l\'article est vide.<br/>";
	}else {
		window.parent.document.getElementById("lib_article").className="classinput_xsize";
	}
	//categ vide
	if (ref_art_categ_vide) {
		window.parent.document.getElementById("liste_de_categorie_pour_article").className="simule_champs_alerte";
		window.parent.goto_etape(0);
	texte_erreur += "Choisissez une catégorie d\'article.<br/>";
	}else {
		window.parent.document.getElementById("liste_de_categorie_pour_article").className="simule_champs";
	}
	//pas de variante sélectionnée
	if (no_variantes_selected) {
		window.parent.goto_etape(1);
		texte_erreur += "Sélectionnez une ou plusieurs variantes de l\'article.<br/>";
	}
	
	
	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

	window.parent.submit_in_way = false;
}
else
{
	window.parent.submit_in_way = false;
<?php 
if (isset ($_INFOS['Création_article']) ) {
	?>
	window.parent.changed = false;
	window.parent.page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo $article->getRef_article();?>','true','sub_content');
	<?php 
}
?>
}
</script>