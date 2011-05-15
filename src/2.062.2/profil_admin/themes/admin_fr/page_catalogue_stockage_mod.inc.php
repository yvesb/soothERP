
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
<p>&nbsp;</p>
<p>stockage MOD </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_stock_vide=false;
var magasin_using_stock=false;
var documents_using_stock = true;
var last_active_stock=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="lib_stock_vide") {
		echo "lib_stock_vide=true;\n";
		echo "erreur=true;\n";
	}
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

if (lib_stock_vide) {
	window.parent.document.getElementById("lib_stock_<?php echo $_REQUEST['id_stock']?>").className="alerteform_lsize";
	window.parent.document.getElementById("lib_stock_<?php echo $_REQUEST['id_stock']?>").focus();
	} else {
	window.parent.document.getElementById("lib_stock_<?php echo $_REQUEST['id_stock']?>").className="classinput_lsize";
		}
		
if (magasin_using_stock) {
window.parent.document.getElementById("actif_<?php echo $_REQUEST['id_stock']?>").checked="checked";
window.parent.alerte.confirm_supprimer('catalogue_stockage_magasin_using_stock', '');
		}
if (documents_using_stock) {
window.parent.document.getElementById("actif_<?php echo $_REQUEST['id_stock']?>").checked="checked";
window.parent.alerte.confirm_supprimer('catalogue_stockage_documents_using_stock', '');
		}
if (last_active_stock) {	
window.parent.document.getElementById("actif_<?php echo $_REQUEST['id_stock']?>").checked="checked";
window.parent.alerte.confirm_supprimer('catalogue_stockage_last_active_stock', '');
		}


}
else
{

window.parent.changed = false;

window.parent.page.verify('catalogue_stockage','catalogue_stockage.php','true','sub_content');

}
</script>