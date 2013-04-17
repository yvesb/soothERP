
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
<p>gestion categories_client  mod </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">

var erreur=false;
var bad_delai_reglement = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_delai_reglement") {
		echo "bad_delai_reglement=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
	if (bad_delai_reglement) {
		window.parent.document.getElementById("delai_reglement_<?php echo $_REQUEST["id_client_categ"];?>").className="alerteform_lsize";
		texte_erreur += "Le délai de règlement dois être une valeur comprise entre 0 et 255.<br/>";
	} else {
		window.parent.document.getElementById("delai_reglement_<?php echo $_REQUEST["id_client_categ"];?>").className="classinput_lsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;

window.parent.page.verify('annuaire_gestion_categ_client','annuaire_gestion_categories_client.php','true','sub_content');

}
</script>