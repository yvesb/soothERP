
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
<p>stockage ADD </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_stock_vide=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="lib_stock_vide") {
		echo "lib_stock_vide=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

if (lib_tarif_vide) {
	window.parent.document.getElementById("lib_stock").className="alerteform_lsize";
	window.parent.document.getElementById("lib_stock").focus();
	} else {
	window.parent.document.getElementById("lib_stock").className="classinput_lsize";
		}
		
}
else
{

window.parent.changed = false;

window.parent.page.verify('catalogue_stockage','catalogue_stockage.php','true','sub_content');

}
</script>