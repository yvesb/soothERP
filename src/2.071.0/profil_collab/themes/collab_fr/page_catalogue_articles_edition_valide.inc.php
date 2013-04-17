
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
//echo $_REQUEST['desc_courte'];
?>
<p>&nbsp;</p>
<p>article edition </p>
<p>&nbsp; </p>
<?php 
foreach ($_INFOS as $alerte => $value) {
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
	
	
}

?>
if (erreur) {


		window.parent.changed	=	false;

<?php

switch ($_REQUEST['step']) {


	case "4": ?>
		//qte de composant fausse
		if (bad_qte) {
		window.parent.goto_etape(4);
		texte_erreur += "il y a une erreur dans la quantité d'un des composants.<br/>";
		}
		<?php
	break;
	case "3": ?>
		//qte de tarif fausse
		if (bad_indice_qte) {
		window.parent.goto_etape(3);
		texte_erreur += "il y a une erreur dans la quantité d'un des tarifs.<br/>";
		}
		<?php
	break;
	case "2":
		if ($_REQUEST['modele']== "materiel") {
			?>
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
			window.parent.document.getElementById("dure_garantie").className="classinput_xsize";
			}
			
			
			//modele poids faux
			if (bad_poids) {
			window.parent.document.getElementById("poids").className="alerteform_xsize";
			window.parent.goto_etape(2);
			window.parent.document.getElementById("poids").focus();
			texte_erreur += "Le poids est d`\'une valeur incorecte.<br/>";
			}else {
			window.parent.document.getElementById("poids").className="classinput_xsize";
			}
			<?php
		}
	break;
	
	case "0": ?>

		//ref_interne_exist
		if (ref_interne_exist) {
		window.parent.document.getElementById("ref_interne").className="alerteform_xsize";
		window.parent.goto_etape(0);
		window.parent.document.getElementById("ref_interne").focus();
		texte_erreur += "La référence interne existe déjà.<br/>";
		}else {
		window.parent.document.getElementById("ref_interne").className="classinput_xsize";
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
		<?php 
	break;

}
?>


window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{
<?php

switch ($_REQUEST['step']) {

	case "2":
		if ($_REQUEST['modele']== "materiel") {
			?>
			window.parent.document.getElementById("dure_garantie").className="classinput_xsize";
			window.parent.document.getElementById("poids").className="classinput_xsize";
			<?php
		}
	break;
	
	case "0": ?>
		<?php 
		if($GESTION_REF_INTERNE){
			?>
			window.parent.document.getElementById("ref_interne").className="classinput_xsize";
			<?php
			}
		?>
		window.parent.document.getElementById("lib_article").className="classinput_xsize";
		<?php 
	break;

}
?>
<?php 
if (isset ($_REQUEST['ref_article']) ) {
	
	switch ($_REQUEST['step']) {
		
		//recharge la grille tarifaire
		case "3": case 8 :?>
			window.parent.changed = false;
			window.parent.page.verify('catalogue_articles_edition_gt',  'catalogue_articles_edition_tarifs.php?ref_article=<?php echo $_REQUEST['ref_article']?>', 'true', 'tarifs_info_under');
			<?php
		break;
		
		
		//recharge la liste des composants
		case "4":?>
			window.parent.changed = false;
			window.parent.page.verify('catalogue_articles_edition_lot','catalogue_articles_edition_composant_liste.php?ref_article=<?php echo $_REQUEST['ref_article']?>','true','lot_info_under');
			<?php
		break;
	}
}
?>

	window.parent.changed = false;
}
</script>