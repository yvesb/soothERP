
<?php

// *************************************************************************************************************
//  DEPLACEMENT DES ARTICLES D'UN STOCK ET SUPPRESSION DU STOCK
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
var last_active_stock=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="magasin_using_stock") {
		echo "magasin_using_stock=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="last_active_stock") {
		echo "last_active_stock=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {


}
else
{
changed = false;

page.verify('catalogue_stockage','catalogue_stockage.php','true','sub_content');

}
</script>