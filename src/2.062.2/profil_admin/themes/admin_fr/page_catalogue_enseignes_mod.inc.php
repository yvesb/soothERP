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
<p>lib_enseigne MOD </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_enseigne_vide=false;

<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="lib_enseigne_vide") {
		echo "lib_enseigne_vide=true;\n";
		echo "erreur=true;\n";
	}
}
?>
if (erreur) {

if (lib_enseigne_vide) {
	window.parent.document.getElementById("lib_enseigne_<?php echo $_REQUEST['id_mag_enseigne']?>").className="alerteform_lsize";
	window.parent.document.getElementById("lib_enseigne_<?php echo $_REQUEST['id_mag_enseigne']?>").focus();
	} else {
	window.parent.document.getElementById("lib_enseigne_<?php echo $_REQUEST['id_mag_enseigne']?>").className="classinput_lsize";
		}

}
else
{

window.parent.changed = false;

window.parent.page.verify('catalogue_enseignes','catalogue_enseignes.php','true','sub_content');
}
</script>