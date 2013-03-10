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
<p>liste_tarif ADD </p>
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
var lib_tarif_vide=false;
var bad_marge_moyenne=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="lib_tarif_vide") {
		echo "lib_tarif_vide=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_marge_moyenne") {
		echo "bad_marge_moyenne=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	if (lib_tarif_vide) {
		window.parent.document.getElementById("lib_tarif").className="alerteform_lsize";
		window.parent.document.getElementById("lib_tarif").focus();
		} else {
		window.parent.document.getElementById("lib_tarif").className="classinput_lsize";
	}
			
	if (bad_marge_moyenne) {
		window.parent.document.getElementById("aff_formule_tarif").className="alerteform_lsize";
		} else {
		window.parent.document.getElementById("aff_formule_tarif").className="classinput_lsize";
	}

}
else
{

window.parent.changed = false;

window.parent.page.verify('configuration_tarifs','configuration_tarifs.php','true','sub_content');

}
</script>