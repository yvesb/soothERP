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
var texte_erreur="";
var erreur=false;
var lib_livraison_mode_vide=false;
var ref_transporteur_vide=false;
<?php 
if (count($_ALERTES)>0) {
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="lib_livraison_mode_vide") {
		echo "lib_livraison_mode_vide=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="ref_transporteur_vide") {
		echo "ref_transporteur_vide=true;";
		echo "erreur=true;\n";
	}
	
}
}
?>
if (erreur) {
	
	if (lib_livraison_mode_vide) {
		window.parent.document.getElementById("lib_livraison_mode").className="alerteform_xsize";
		texte_erreur += "Vous devez indiquer un libellé au mode de transport.<br/>";
	} else {
		window.parent.document.getElementById("lib_livraison_mode").className="classinput_xsize";
	}
	
	if (ref_transporteur_vide) {
		window.parent.document.getElementById("nom_transporteur").className="alerteform_xsize";
		texte_erreur += "Vous devez sélectionner un transporteur.<br/>";
	} else {
		window.parent.document.getElementById("nom_transporteur").className="classinput_xsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
window.parent.changed = false;
window.parent.page.verify('livraison_modes','livraison_modes.php' ,"true" ,"sub_content");
}
</script>