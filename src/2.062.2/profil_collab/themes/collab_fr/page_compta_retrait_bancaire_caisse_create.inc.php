<?php

// *************************************************************************************************************
// retrait en la banque vers caisse 
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
<p>Création retrait en la banque vers caisse  </p>
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

window.parent.page.traitecontent('compta_retrait_bancaire_caisse_done','compta_retrait_bancaire_caisse_done.php?id_caisse=<?php echo $_REQUEST["id_compte_caisse"]; ?>&id_compte_caisse_retrait=<?php echo $id_compte_caisse_retrait; ?>','true','sub_content');
}
</script>