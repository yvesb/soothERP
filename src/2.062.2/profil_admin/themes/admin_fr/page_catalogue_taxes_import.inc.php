
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
<p>taxes import </p>
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

//	if ($alerte=="lib_stock_vide") {
//		echo "lib_stock_vide=true;\n";
//		echo "erreur=true;\n";
//	}
	
}

?>
if (erreur) {


		
}
else
{

window.parent.page.traitecontent('categ_taxes_list_content','catalogue_taxes_client.php?id_pays=<?php echo $id_pays?>',true,'taxes_client');

}
</script>