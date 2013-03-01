<?php

// *************************************************************************************************************
// Suppression D'UN LIEN
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
<p>suppression lien favoris</p>
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

}


?>
if (erreur) {



}
else
{
window.parent.changed = false;
window.parent.page.verify("mes_liens","planning_liens.php","true","sub_content");
}
</script>