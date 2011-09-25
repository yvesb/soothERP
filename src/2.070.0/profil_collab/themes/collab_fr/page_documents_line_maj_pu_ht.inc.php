<?php 


?>

<script type="text/javascript">
if (window.parent.montant_total_neg) {
	window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $_REQUEST["ref_doc"]; ?>&montant_neg=1','true','reglements_content');
} else {
	window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $_REQUEST["ref_doc"]; ?>','true','reglements_content');
}
<?php
if ($document->getACCEPT_REGMT() != 0) {
?>
page.traitecontent('documents_entete','documents_entete_maj_reglements.php?ref_doc=<?php echo $_REQUEST['ref_doc']?>','true','block_reglement');
<?php }?>
</script>