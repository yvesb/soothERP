<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


//$nouvelle_ligne = '<td id="LIB_'.$ligne->ref_doc_line.'"></td><td id="QTE_'.$ligne->ref_doc_line.'"></td><td id="PUTTC_'.$ligne->ref_doc_line.'"></td><td id="REMISE_'.$ligne->ref_doc_line.'"></td><td id="PRIXTTC_'.$ligne->ref_doc_line.'"></td>';


$cell_LIB			= Icaisse::getTicket_cell_LIB($ligne->lib_article);
$cell_QTE			= Icaisse::getTicket_cell_QTE($ligne->qte);
$cell_PUTTC		= Icaisse::getTicket_cell_PUTTC($ligne->pu_ht, $ligne->tva);
$cell_REMISE	= Icaisse::getTicket_cell_REMISE($ligne->remise);
$cell_PRIXTTC	= Icaisse::getTicket_cell_PRIXTTC($ligne->qte, $ligne->pu_ht, $ligne->remise/100, $ligne->tva);
?>

<script type="text/javascript">
	$("art_lib_s").value = "";
	var montant =  "<?php echo $montant_to_pay; ?>";
	caisse_maj_total(price_format(montant));

	//caisse_maj_total("<?php echo price_format($montant_to_pay); ?>");

	$("ref_ticket").value = "<?php echo $document->getRef_doc(); ?>";

	ajouterArticleTicket("<?php echo $ligne->ref_doc_line; ?>", "&euro;", "<?php echo $cell_LIB; ?>", "<?php echo $cell_QTE; ?>", "<?php echo $cell_PUTTC; ?>", "<?php echo $cell_REMISE; ?>", "<?php echo $cell_PRIXTTC; ?>");
	H_loading();

</script>
