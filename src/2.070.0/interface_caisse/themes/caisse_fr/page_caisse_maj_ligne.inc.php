<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("ref_ligne", "cell_QTE", "cell_PUTTC", "cell_REMISE", "cell_PRIXTTC");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<script type="text/javascript">
	//caisse_maj_total("<?php echo price_format($montant_to_pay); ?>");

	var montant =  "<?php echo $montant_to_pay; ?>";
	caisse_maj_total(price_format(montant));

	setTicket_cell_QTE("<?php echo $ref_ligne; ?>", "<?php echo $cell_QTE; ?>");
	setTicket_cell_PUTTC("<?php echo $ref_ligne; ?>", "&euro;", "<?php echo $cell_PUTTC; ?>");
	setTicket_cell_REMISE("<?php echo $ref_ligne; ?>", "<?php echo $cell_REMISE; ?>");
	setTicket_cell_PRIXTTC("<?php echo $ref_ligne; ?>", "&euro;", "<?php echo $cell_PRIXTTC;?>");

	H_loading();
</script>
