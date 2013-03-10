<?php

// *************************************************************************************************************
// Création d'une télécollecte
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
<p>Création d'une télécollecte</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	
}

?>
if (erreur) {

}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('compta_tp_telecollecte_done','compta_tp_telecollecte_done.php?id_compte_tp=<?php echo $_REQUEST["id_compte_tp"]; ?>&tp_type=<?php echo $_REQUEST["tp_type"];?>&id_compte_tp_telecollecte=<?php echo $id_compte_tp_telecollecte; ?>','true','sub_content');
}
</script>