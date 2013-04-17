
<?php

// *************************************************************************************************************
// SUPPRESSION PROFIL CLIENT
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
<p>supprime profil client</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;

window.parent.document.getElementById("liste_document_client").style.display = "none";
window.parent.remove_provil_visu("<?php echo $id_profil?>");
window.parent.switchprofil_new_edit("<?php echo $id_profil?>", "type_fiche", "annuaire_edition_check_profil");


</script>