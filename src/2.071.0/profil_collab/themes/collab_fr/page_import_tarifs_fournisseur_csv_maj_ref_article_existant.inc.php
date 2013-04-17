<?php
// *************************************************************************************************************
// IMPORT FICHIER TARIFS FOURNISSEUR CSV
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
<p>&nbsp;</p>
<p>Import tarifs fournisseur CSV</p>
<p>&nbsp;</p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br />";
}
?>

<script type="text/javascript">
	page.verify('import_tarifs_fournisseur_csv_step2', 'import_tarifs_fournisseur_csv_step2.php', 'true', 'sub_content');
</script>