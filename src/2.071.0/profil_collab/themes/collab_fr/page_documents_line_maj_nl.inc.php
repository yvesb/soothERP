<?php

// *************************************************************************************************************
// AFFICHAGE D'ALERTE SN EXISTANT OU NON
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
if ($id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $TRANSFERT_ID_TYPE_DOC) {
	if ($_REQUEST['new_qte_nl'] > $sn_qte_en_stock) {
		?>
		$("qte_nl_<?php echo $_REQUEST['indentation_art'];?>_<?php echo $_REQUEST['indentation_nl'];?>").style.color = "#FF0000";
		$("qte_nl_<?php echo $_REQUEST['indentation_art'];?>_<?php echo $_REQUEST['indentation_nl'];?>").title = "En stock <?php echo $sn_qte_en_stock;?>";
		$("doc_alerte_stock").innerHTML = "Stock insuffisant";
		<?php
	} else {
		?>
		$("qte_nl_<?php echo $_REQUEST['indentation_art'];?>_<?php echo $_REQUEST['indentation_nl'];?>").style.color = "#000000";
		$("qte_nl_<?php echo $_REQUEST['indentation_art'];?>_<?php echo $_REQUEST['indentation_nl'];?>").title = "En stock <?php echo $sn_qte_en_stock;?>";
		$("doc_alerte_stock").innerHTML = "";
		depasse_stock ();
		<?php
	} 
}
?>
</script>