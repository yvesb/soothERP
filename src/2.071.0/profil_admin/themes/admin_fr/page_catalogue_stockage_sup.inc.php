
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


?>
<script type="text/javascript">
var erreur=false;
var magasin_using_stock=false;
var documents_using_stock = false;
var last_active_stock=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="magasin_using_stock") {
		echo "magasin_using_stock=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="documents_using_stock") {
		echo "documents_using_stock=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="last_active_stock") {
		echo "last_active_stock=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	if (magasin_using_stock) {
		$("actif_<?php echo $_REQUEST['id_stock']?>").checked="checked";
		alerte.confirm_supprimer('catalogue_stockage_magasin_using_stock', '');
	}
	if (documents_using_stock) {
		$("actif_<?php echo $_REQUEST['id_stock']?>").checked="checked";
	//alerte.confirm_supprimer('catalogue_stockage_documents_using_stock', '');
	
		texte_erreur += "";
		alerte.alerte_erreur ('Lieu de stockage utilisé', 'Ce lieu de stockage est utilisé par un ou des documents en attente de validation, vous ne pouvez pas le désactiver<br/><span style="cursor:pointer; text-decoration:underline; " id="view_doc_block_stock">Voir les documents</span>'+texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		
	Event.observe("view_doc_block_stock", "click",  function(evt){Event.stop(evt); page.verify('catalogue_stockage_documents_result','index.php#'+escape('catalogue_stockage_documents_result.php?id_stock=<?php echo $_REQUEST['id_stock']?>'),'true','_blank');}, false);
	}
	if (last_active_stock) {	
		$("actif_<?php echo $_REQUEST['id_stock']?>").checked="checked";
		alerte.confirm_supprimer('catalogue_stockage_last_active_stock', '');
	}


}
else
{
	changed = false;
	
	choix_stock_do_article ("<?php echo $_REQUEST['id_stock']?>");

}
</script>