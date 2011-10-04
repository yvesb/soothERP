
<?php

// *************************************************************************************************************
// MODIFICATION DU PROFIL CLIENT
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
<p>modifier profil client (modification du compte comptable </p>
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
window.parent.changed = false;
<?php if (isset($_REQUEST['retour_value'])) { ?>
window.parent.document.getElementById("numero_compte_compta_client<?php if (isset($_REQUEST["ref_contact"])) { ?>_<?php echo $_REQUEST["ref_contact"];?><?php } ?>").innerHTML = "<?php if ($_REQUEST['retour_value'] == "") {echo "...";} else { echo $_REQUEST['retour_value'];}?>";
window.parent.close_compta_plan_mini_moteur();
<?php } ?>
}
</script>