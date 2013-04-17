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



?>

<script type="text/javascript">
	try{
	$("art_lib_s").value = "";

	$("ref_ticket").value = "<?php echo $document->getRef_doc(); ?>";

	ajouterInfosTicket("<?php echo $ligne->ref_doc_line; ?>", "<?php echo $ligne->lib_article; ?>", "<?php echo $ligne->desc_article; ?>");
	H_loading();
}catch(z){console.log(z)}
</script>
