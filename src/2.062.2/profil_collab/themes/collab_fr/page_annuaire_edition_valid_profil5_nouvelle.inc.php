
<?php

// *************************************************************************************************************
// NOUVEAU PROFIL FOURNISSEUR
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
<p>nouveau profil fournisseur</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {

	
}


?>
if (erreur) {

}
else
{
window.parent.changed = false;
window.parent.switchprofil_new_edit("<?php echo $id_profil?>", "typeprofil<?php echo $id_profil?>", "annuaire_edition_valid_view_profil_nouvelle");
window.parent.switchprofil_new_edit("<?php echo $id_profil?>", "type_fiche", "annuaire_edition_check_profil");
}
</script>