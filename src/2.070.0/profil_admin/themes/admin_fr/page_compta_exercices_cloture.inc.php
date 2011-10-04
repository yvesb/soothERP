<?php

// *************************************************************************************************************
// CLOTURE D'UN EXERCICE
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
<p>compta exercice (CLOTURE) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_date_fin = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
		echo "erreur=true;\n";
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_date_fin") {
		echo "bad_date_fin=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	
	if (bad_date_fin) {
		window.parent.document.getElementById("date_fin_<?php echo $_REQUEST["id_exercice"]?>").className="alerteform_lsize";
		texte_erreur += "La date de fin d'exercice ne peut être inférieur à sa date de début.<br/>";
	} else {
		window.parent.document.getElementById("date_fin_<?php echo $_REQUEST["id_exercice"]?>").className="classinput_lsize";
	}

	window.parent.alerte.alerte_erreur ('Erreur de traitement', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('compta_exercices','compta_exercices.php','true','sub_content');

}
</script>