
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
<p>art_categ Modif </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_vide=false;
var cant_change_modele=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="cant_change_modele") {
		echo "erreur=true;";
		echo "cant_change_modele=true;\n";
	}
	if ($alerte=="lib_vide") {
		echo "erreur=true;";
		echo "lib_vide=true;\n";
	}
}

?>
if (erreur) {
	if (cant_change_modele) {
		window.parent.document.getElementById("modele").className="alerteform_xsize";
		window.parent.document.getElementById("modele").focus();
		texte_erreur += "Cette catégorie comporte déjà des articles.<br />Vous ne pouvez pas changer le modéle de cette catégorie.<br />";
	}else {
		window.parent.document.getElementById("modele").className="classinput_xsize";
	}
	if (lib_vide) {
		window.parent.document.getElementById("lib_art_categ").className="alerteform_xsize";
		window.parent.document.getElementById("lib_art_categ").focus();
		texte_erreur += "Veuillez indiquer un libellé à la catégorie.<br />";
	}else {
		window.parent.document.getElementById("lib_art_categ").className="classinput_xsize";
	}


window.parent.alerte.alerte_erreur ('Changement impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{
<?php 
if (isset ($_REQUEST['ref_art_categ']) ) {?>
window.parent.changed = false;
<?php if (isset($_INFOS['reload_liste_categ']) ) {?>
window.parent.page.verify('art_categs_list', 'catalogue_categorie_inc_list_cat.php', 'true', 'list_art_categs');
<?php }?>
window.parent.page.verify('art_categs_mod', 'catalogue_categorie_inc_mod.php?ref_art_categs=<?php echo $_REQUEST['ref_art_categ']?>', 'true', 'content_art_categs');
<?php }?>
}
</script>