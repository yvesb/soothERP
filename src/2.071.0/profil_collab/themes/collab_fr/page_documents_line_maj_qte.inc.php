<?php

// *************************************************************************************************************
// AFFICHAGE D'ALERTE QTE STOCK
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
if (isset($new_pu_ht)) {
	?>
			$("pu_ht_old_<?php echo $_REQUEST['indentation'];?>").value = "<?php echo number_format($new_pu_ht, $TARIFS_NB_DECIMALES, ".", ""	);?>";
			$("pu_ht_<?php echo $_REQUEST['indentation'];?>").value = "<?php echo number_format($new_pu_ht, $TARIFS_NB_DECIMALES, ".", ""	);?>";
	<?php
}
?>
<?php

if( isset($_REQUEST["ref_doc"]) && $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC && $CDC_ALERTES_STOCK_DISPO){
	if($_REQUEST['qte_article'] > ($stocks_qte - $stocks_res)){
			?>
			$("qte_<?php echo $_REQUEST['indentation'];?>").style.color = "#FF0000";
			$("qte_<?php echo $_REQUEST['indentation'];?>").title = "Stock disponible : <?php echo $stocks_qte - $stocks_res;?>";
			<?php
		} else {
			?>
			$("qte_<?php echo $_REQUEST['indentation'];?>").style.color = "#000000";
			$("qte_<?php echo $_REQUEST['indentation'];?>").title = "Stock disponible : <?php echo $stocks_qte - $stocks_res;?>";
			<?php
	}
}

if (isset($_REQUEST['ref_doc']) && isset($line_infos->modele) && $line_infos->modele == "materiel" && $line_infos->lot != 2 && $GESTION_STOCK ) {
	if ($id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $TRANSFERT_ID_TYPE_DOC) {
		if ($_REQUEST['qte_article'] > $stocks_qte) {
			?>
			$("qte_<?php echo $_REQUEST['indentation'];?>").style.color = "#FF0000";
			$("qte_<?php echo $_REQUEST['indentation'];?>").title = "En stock <?php echo $stocks_qte;?>";
			depasse_stock ();
			<?php
		} else {
			?>
			$("qte_<?php echo $_REQUEST['indentation'];?>").style.color = "#000000";
			$("qte_<?php echo $_REQUEST['indentation'];?>").title = "En stock <?php echo $stocks_qte;?>";
			depasse_stock ();
			<?php
		} 
	}
	
	//cas des inventaires
	if ($id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		if ($_REQUEST['qte_article'] > $stocks_qte || $_REQUEST['qte_article'] < $stocks_qte || isset($GLOBALS['_ALERTES']['bad_qte'])) {
			?>
			$("qte_<?php echo $_REQUEST['indentation'];?>").style.color = "#FF0000";
			$("qte_<?php echo $_REQUEST['indentation'];?>").title = "Stock attendu <?php echo $stocks_qte;?>";
		
			<?php
			if (isset($GLOBALS['_ALERTES']['bad_qte'])) {
				?>
				$("qte_<?php echo $_REQUEST['indentation'];?>").focus();
				$("qte_<?php echo $_REQUEST['indentation'];?>").value = "<?php echo $GLOBALS['_ALERTES']['bad_qte'];?>";
				$("pu_ht_<?php echo $_REQUEST['indentation'];?>").focus();
				document_calcul_tarif ();
				<?php
			}
			
		} else {
			?>
			$("qte_<?php echo $_REQUEST['indentation'];?>").style.color = "#000000";
			$("qte_<?php echo $_REQUEST['indentation'];?>").title = "Stock attendu <?php echo $stocks_qte;?>";
	
			<?php
		} 
	}
}
?>
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