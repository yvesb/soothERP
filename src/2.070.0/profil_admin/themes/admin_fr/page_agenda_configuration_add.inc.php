
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
<?php /*>
<p>&nbsp;</p>
<p>Agenda ADD </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_agenda_vide=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="lib_agenda_vide") {
		echo "lib_agenda_vide=true;\n";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {
	if (lib_agenda_vide) {
		window.parent.document.getElementById("lib_agenda").className="alerteform_lsize";
		window.parent.document.getElementById("lib_agenda").focus();
	} else {
		window.parent.document.getElementById("lib_agenda").className="classinput_lsize";
	}
}
else
{
window.parent.changed = false;

window.parent.page.verify('agenda_configuration','agenda_configuration.php','true','sub_content');

}
</script>
*/?>
<script type="text/javascript">
	window.parent.page.verify('agenda_configuration','agenda_configuration.php','true','sub_content');
</script>