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
<p>comptes tpv (supprimer) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var exist_reglements=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
	if ($alerte=="exist_reglements") {
		echo "exist_reglements=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

	if (exist_reglements) {
		texte_erreur += "La suppression de ce TPV est impossible car des règlements ont été effectués via ce TPV.<br/>Vous pouvez néamoins désactiver un TPV";
	}

	window.parent.alerte.alerte_erreur ('Suppression Impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');



}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('compta_compte_tpv','compta_compte_tpv.php','true','sub_content');

}
</script>