<?php

// *************************************************************************************************************
// SUPPRESSION D'UNE FONCTION
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
<p>users_fonctions  sup </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	
}

?>
if (erreur) {
	


}
else
{

window.parent.changed = false;

window.parent.page.verify('annuaire_gestion_users_fonctions','annuaire_gestion_users_fonctions.php','true','sub_content');

}
</script>