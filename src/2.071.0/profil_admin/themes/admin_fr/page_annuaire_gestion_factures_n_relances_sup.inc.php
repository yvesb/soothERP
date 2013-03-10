
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
<p>gestion niveaux factures relances (suppression)</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_delai_before_next = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_delai_before_next") {
		echo "bad_delai_before_next=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
	if (bad_delai_before_next) {
		window.parent.document.getElementById("delai_before_next").className="alerteform_lsize";
		texte_erreur += "Le délai avant la prochaine relance dois être une valeur numérique.<br/>";
	} else {
		window.parent.document.getElementById("delai_before_next").className="classinput_lsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('annuaire_gestion_factures','annuaire_gestion_factures.php?id_client_categ=<?php echo $_REQUEST["id_client_categ_".$_REQUEST["id_niveau_relance"]];?>','true','sub_content');

}
</script>