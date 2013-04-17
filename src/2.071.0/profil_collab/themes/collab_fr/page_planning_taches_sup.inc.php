
<?php

// *************************************************************************************************************
// SUPPRESSION D'UNE TACHE
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
<p>tache supprime</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	
}


?>
if (erreur) {
}
else
{
window.parent.remove_tag("tache_cree_<?php echo $_REQUEST["id_tache"];?>");
}
</script>