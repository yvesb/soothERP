<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("document", "lignes", "ligne1", "ligne2", "ligne3", "lib_grille_tarrifaire");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">

	$("ref_ticket").value = "<?php echo $document->getRef_doc(); ?>";

	$("ref_contact").value = "<?php echo $document->getRef_contact();?>";
	$("client_ligne1").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne1));?>";
	$("client_ligne2").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne2));?>";
	$("client_ligne3").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne3));?>";
	$("client_grille_tarifaire").innerHTML = "<?php echo $lib_grille_tarrifaire;?>";

	var montant =  "<?php echo $montant_to_pay; ?>";
	caisse_maj_total(price_format(montant));
	//caisse_maj_total("<?php echo price_format($montant_to_pay); ?>");

</script>

<?php foreach ($lignes as $ligne) {
if($ligne->type_of_line == "information"){
	?>
	<script type="text/javascript">
	ajouterInfosTicket("<?php echo $ligne->ref_doc_line; ?>", "<?php echo $ligne->lib_article; ?>", "<?php echo $ligne->desc_article; ?>");
	</script>
	<?php
} else {
	echo $ligne->ref_doc_line."\n";

	$cell_LIB			= Icaisse::getTicket_cell_LIB($ligne->lib_article);
	$cell_QTE			= Icaisse::getTicket_cell_QTE($ligne->qte);
	$cell_PUTTC		= Icaisse::getTicket_cell_PUTTC($ligne->pu_ht, $ligne->tva);
	$cell_REMISE	= Icaisse::getTicket_cell_REMISE($ligne->remise);
	$cell_PRIXTTC	= Icaisse::getTicket_cell_PRIXTTC($ligne->qte, $ligne->pu_ht, $ligne->remise/100, $ligne->tva);
	?>
	<script type="text/javascript">
	ajouterArticleTicket("<?php echo $ligne->ref_doc_line; ?>", "&euro;", "<?php echo $cell_LIB; ?>", "<?php echo $cell_QTE; ?>", "<?php echo $cell_PUTTC; ?>", "<?php echo $cell_REMISE; ?>", "<?php echo $cell_PRIXTTC; ?>");
	</script>
<?php }
}
unset($cell_LIB, $cell_QTE, $cell_PUTTC, $cell_REMISE, $cell_PRIXTTC);
?>

<script type="text/javascript">
	<?php if(count($lignes)>0){
		$ligne = $lignes[count($lignes)-1];?>
		calculette_caisse.setCible_type_action("TICKET");
		calculette_caisse.setCible_id("<?php echo $ligne->ref_doc_line;?>");
		caisse_select_line("<?php echo $ligne->ref_doc_line;?>");
	<?php } ?>
	H_loading();
</script>