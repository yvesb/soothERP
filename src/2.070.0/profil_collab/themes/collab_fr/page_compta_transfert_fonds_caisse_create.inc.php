<?php

// *************************************************************************************************************
// Création d'un transfert entre caisses
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
<p>Création d'un transfert entre caisses</p>
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

window.parent.page.traitecontent('compta_transfert_fonds_caisse_done','compta_transfert_fonds_caisse_done.php?id_caisse=<?php echo $_REQUEST["id_compte_caisse"]; ?>&id_compte_caisse_transfert=<?php echo $id_compte_caisse_transfert; ?>','true','sub_content');
}
</script>