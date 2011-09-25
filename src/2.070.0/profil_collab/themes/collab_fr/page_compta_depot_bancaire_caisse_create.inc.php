<?php

// *************************************************************************************************************
// Remise en banque depuis la caisse (ou dépot bancaire depuis la caisse)
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
<p>Création Remise en banque depuis la caisse (ou dépot bancaire depuis la caisse)  </p>
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

window.parent.page.traitecontent('compta_depot_bancaire_caisse_done','compta_depot_bancaire_caisse_done.php?id_caisse=<?php echo $_REQUEST["id_compte_caisse"]; ?>&id_compte_caisse_depot=<?php echo $id_compte_caisse_depot; ?>','true','sub_content');
}
</script>