<?php

// *************************************************************************************************************
// MODIFICATION D'UNE FONCTION
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
<p>users_fonctions  mod </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_fonction_vide=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="lib_fonction_vide") {
		echo "lib_fonction_vide=true;";
		echo "erreur=true;\n";
	}
	
	
}

?>
if (erreur) {
	
	if (lib_fonction_vide) {
		window.parent.document.getElementById("lib_fonction_<?php echo $_REQUEST["id_fonction"];?>").className="alerteform_xsize";
		texte_erreur += "Vous devez indiquer un libellé à la fonction.<br/>";
	} else {
		window.parent.document.getElementById("lib_fonction_<?php echo $_REQUEST["id_fonction"];?>").className="classinput_xsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{

window.parent.changed = false;

window.parent.page.verify('annuaire_gestion_users_fonctions','annuaire_gestion_users_fonctions.php','true','sub_content');

}
</script>