<?php

// *************************************************************************************************************
// RENVOIS DES ID_IMPEX_TYPE AUTORISES AU PARTAGE
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

?><p>&nbsp;</p>
<p>RETOUR DES IMPEX TYPE PARTAGES</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">


window.parent.page.traitecontent('serveur_import_impex_dispo','serveur_import_impex_dispo.php?impex=<?php echo $_REQUEST["impex"]?>','true','show_impex');

</script>
