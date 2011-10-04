
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
<p>art_categ caract ADD </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_carac_vide=false;
var bad_moteur_recherche=false;
var bad_affichage=false;
var bad_variante=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="lib_carac_vide") {
		echo "lib_carac_vide=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_moteur_recherche") {
		echo "bad_moteur_recherche=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_affichage") {
		echo "bad_affichage=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_variante") {
		echo "bad_variante=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

if (lib_carac_vide) {
	window.parent.document.getElementById("lib_carac").className="alerteform_xsize";
	window.parent.document.getElementById("lib_carac").focus();
	} else {
	window.parent.document.getElementById("lib_carac").className="classinput_xsize";
		}

}
else
{
<?php 
if (isset ($_REQUEST['ref_art_categ']) ) {?>
window.parent.changed = false;

window.parent.page.verify('caract_art_categ', 'catalogue_categorie_caract.php?ref_art_categs=<?php echo $_REQUEST['ref_art_categ']?>', 'true', 'caract_art_categ');
<?php }?>
}
</script>