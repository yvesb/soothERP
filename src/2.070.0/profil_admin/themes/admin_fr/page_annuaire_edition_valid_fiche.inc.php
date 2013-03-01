
<?php

// *************************************************************************************************************
//  MODIFICATION DES INFORMATIONS GENERALES D'UN CONTACT
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
<p>contact info générales</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var nom_vide=false;
var bad_categorie=false;
var erreur=false;
var texte_erreur = "";
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="nom_vide") {
		echo "nom_vide=true;";
		echo "erreur=true;";
	}
	if ($alerte=="bad_categorie") {
		echo "bad_categorie=true;\n";
		echo "erreur=true;\n";
	}	
}

?>
if (erreur) {

	if (nom_vide) {
		window.parent.document.getElementById("nom").className="alerteform_xsize";
		window.parent.document.getElementById("nom").focus();
	texte_erreur += "Indiquez un nom pour votre contact.<br/>";
	} else {
				window.parent.document.getElementById("nom").className!="classinput_xsize";
	}
	if (bad_categorie) {
		window.parent.document.getElementById("id_categorie").className="alerteform_xsize";
		window.parent.document.getElementById("id_categorie").focus();
	texte_erreur += "Le type de contact semble incorrecte.<br/>";
	} else {
				window.parent.document.getElementById("id_categorie").className="classinput_xsize";
	}


window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');



}
else
{
window.parent.changed = false;
window.parent.document.getElementById("submit").style.visibility="hidden";
	if  (window.parent.document.getElementById("nom").className!="classinput_xsize_m"){
		window.parent.document.getElementById("nom").className="classinput_xsize";
	}
	if (window.parent.document.getElementById("id_categorie").className!="classinput_xsize_m"){
		window.parent.document.getElementById("id_categorie").className="classinput_xsize";
	}

}
</script>