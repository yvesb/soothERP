<?php

// *************************************************************************************************************
// RAZ de TP
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
<p>RAZ de tp</p>
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

window.parent.page.traitecontent('compta_gestion2_terminaux','compta_gestion2_terminaux.php?<?php if ($_REQUEST["tp_type"] == "TPE") { echo "id_tpe=".$_REQUEST["id_compte_tp"]; } else { echo "id_tpv=".$_REQUEST["id_compte_tp"]; }?>','true','sub_content');
}
</script>