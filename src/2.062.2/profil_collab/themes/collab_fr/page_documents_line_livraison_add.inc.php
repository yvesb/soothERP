<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
<script type="text/javascript">

<?php
if ( isset($GLOBALS['_INFOS']['calcul_livraison_mode_ND'])) {
	?>	
	texte_erreur = "Un ou plusieurs articles, non disponibles pour ce mode de livraison, ne permettent pas de calculer les frais de transports.";
	alerte.alerte_erreur ('Frais de transport non déterminés', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	<?php
}
?>
<?php
if ( isset($GLOBALS['_INFOS']['calcul_livraison_mode_nozone'] )) {
	?>	
	texte_erreur = "Aucune zone de livraison n'est indiquée pour ce document.";
	alerte.alerte_erreur ('Zone de livraison non déterminée', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	<?php
}
?>

<?php
if ( isset($GLOBALS['_INFOS']['calcul_livraison_mode_impzone'] )) {
	?>	
	texte_erreur = "Cette zone de livraison n'est pas disponible pour ce mode de transport.";
	alerte.alerte_erreur ('Zone de livraison non désservie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	<?php
}
?>


page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo $document->getRef_doc();?>','true','sub_content');
//on masque le chargement
H_loading();

</script>