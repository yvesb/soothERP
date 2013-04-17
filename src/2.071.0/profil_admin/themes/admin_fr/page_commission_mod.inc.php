<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
<p>liste_comm MOD</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

foreach ($_INFOS as $info => $value) {
	echo $info." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_comm_vide=false;
var bad_formule_comm=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="lib_comm_vide") {
		echo "lib_comm_vide=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_formule_comm") {
		echo "bad_formule_comm=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	if (lib_tarif_vide) {
	window.parent.document.getElementById("lib_comm_<?php echo $_REQUEST['id_commission_regle'];?>").className="alerteform_lsize";
	window.parent.document.getElementById("lib_comm_<?php echo $_REQUEST['id_commission_regle'];?>").focus();
	} else {
	window.parent.document.getElementById("lib_comm_<?php echo $_REQUEST['id_commission_regle'];?>").className="classinput_lsize";
	}
		
	if (bad_formule_comm) {
	window.parent.document.getElementById("aff_formule_comm_<?php echo $_REQUEST['id_commission_regle'];?>").className="alerteform_lsize";
	} else {
	window.parent.document.getElementById("aff_formule_comm_<?php echo $_REQUEST['id_commission_regle'];?>").className="classinput_lsize";
		}

}
else
{
<?php
if (isset($_REQUEST['id_commission_regle'])) {?>
window.parent.changed = false;

window.parent.page.verify('configuration_commission','configuration_commission.php','true','sub_content');
<?php
}
?>
}
</script>