
<?php

// *************************************************************************************************************
// MAJ D'UNE NOUVELLE TACHE
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
<p>maj tache</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_lib_tache=false;
var texte_erreur = "";
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_lib_tache") {
		echo "bad_lib_tache=true;";
		echo "erreur=true;\n";
	}
	
}


?>
if (erreur) {

if (bad_lib_tache) {
	window.parent.document.getElementById("lib_tache").className="alerteform_xsize";
	window.parent.document.getElementById("lib_tache").focus();
texte_erreur += "Indiquez un titre à la tâche.<br/>";
} else {
	window.parent.document.getElementById("lib_tache").className="classinput_xsize";
}


window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{
window.parent.changed = false;
window.parent.view_menu_1('taches_crees_content', 'menu_3', window.parent.array_menu_taches);  
window.parent.set_tomax_height('taches_crees_content' , -32);
window.parent.page.verify("planning_taches_crees_liste","planning_taches_crees_liste.php","true","taches_crees_content");
}
</script>