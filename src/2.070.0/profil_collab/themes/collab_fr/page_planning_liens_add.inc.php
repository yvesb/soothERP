
<?php

// *************************************************************************************************************
// AJOUT D'UNE NOUVELLE TACHE
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
<p>nouveau lien favoris</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_lib_web_link=false;
var texte_erreur = "";
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_lib_web_link") {
		echo "bad_lib_web_link=true;";
		echo "erreur=true;\n";
	}
	
}


?>
if (erreur) {

if (bad_lib_web_link) {
	window.parent.document.getElementById("lib_web_link").className="alerteform_xsize";
	window.parent.document.getElementById("lib_web_link").focus();
texte_erreur += "Indiquez un titre au lien.<br/>";
} else {
	window.parent.document.getElementById("lib_web_link").className="classinput_xsize";
}


window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{
window.parent.changed = false;
window.parent.page.verify("mes_liens","planning_liens.php","true","sub_content");
}
</script>