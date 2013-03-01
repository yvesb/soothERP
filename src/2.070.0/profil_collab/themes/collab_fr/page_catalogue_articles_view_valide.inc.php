
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
<p>article edition depuis visualisation </p>
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


		window.parent.changed	=	false;

<?php

switch ($_REQUEST['step']) {


	case "4": ?>
		//qte de composant fausse
		//if (bad_qte) {
		//window.parent.goto_etape(4);
		//texte_erreur += "il y a une erreur dans la quantité d'un des composants.<br/>";
		//}
		<?php
	break;
	case "3": ?>
	//modele dure service abo faux
	if (bad_duree) {
		window.parent.document.getElementById("duree_abo_mois").className="alerteform_nsize";
		window.parent.document.getElementById("duree_abo_mois").focus();
		texte_erreur += "La durée d'abonnement est d\'une valeur incorrecte.<br/>";
	}
	//modele engagement service abo faux
	if (bad_engagement) {
		window.parent.document.getElementById("engagement").className="alerteform_nsize";
		window.parent.document.getElementById("engagement").focus();
		texte_erreur += "La durée d'engagement est d\'une valeur incorrecte.<br/>";
	}
	//modele reconduction service abo faux
	if (bad_reconduction) {
		window.parent.document.getElementById("reconduction").className="alerteform_nsize";
		window.parent.document.getElementById("reconduction").focus();
		texte_erreur += "Le nombre de reconduction est d\'une valeur incorrecte.<br/>";
	}
	//modele preavis service abo faux
	if (bad_preavis) {
		window.parent.document.getElementById("preavis_abo_mois").className="alerteform_nsize";
		window.parent.document.getElementById("preavis_abo_mois").focus();
		texte_erreur += "La durée de préavis est d\'une valeur incorrecte.<br/>";
	}
	
		<?php
	break;
	case "2":
			?>
			//ref_interne_exist
			if (ref_interne_exist) {
			window.parent.document.getElementById("ref_interne").className="alerteform_xsize";
			window.parent.goto_etape(0);
			window.parent.document.getElementById("ref_interne").focus();
			texte_erreur += "La référence interne existe déjà.<br/>";
			}else {
			window.parent.document.getElementById("ref_interne").className="classinput_xsize";
			}
			<?php
	break;
	
	case "0": ?>

		
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

	case "3":
	
			switch ($_REQUEST['modele']) {
			case "materiel":
				?>
				window.parent.page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo $_REQUEST['ref_article']?>','true','sub_content');
				<?php
		
				break;
			case "service_abo":
				?>
				window.parent.page.verify('catalogue_articles_view_gestion_service_abo','catalogue_articles_view_gestion_service_abo.php?ref_article=<?php echo $_REQUEST['ref_article']?>','true','service_abo');
				<?php
		
				break;
			}
	break;
	case "2":
		?>
		window.parent.page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo $_REQUEST['ref_article']?>','true','sub_content');
		<?php
	break;
	case "1":
		?>
		window.parent.page.verify('catalogue_articles_view_categ_caract','catalogue_articles_view_categ_caract.php?ref_article=<?php if (isset($_REQUEST['ref_article_origine'])) {echo $_REQUEST['ref_article_origine'];} else { echo $_REQUEST['ref_article'];}?>','true','caract_info_under');
		<?php
	break;	
	case "0": ?>
		window.parent.page.verify('catalogue_articles_view','catalogue_articles_view.php?ref_article=<?php echo $_REQUEST['ref_article']?>&go=o_a','true','sub_content');
		<?php 
	break;

}
?>


	window.parent.changed = false;
}
</script>