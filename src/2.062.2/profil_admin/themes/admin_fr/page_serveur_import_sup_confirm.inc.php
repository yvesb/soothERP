<?php

// *************************************************************************************************************
// CONFIRMATION DE SUPPRESSION D'UN SERVEUR D'IMPORT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?><p>&nbsp;</p>
<p>Confirmation supression d'un serveur d'import</p>
<p>&nbsp; </p>

<script type="text/javascript">
var erreur=false;
var texte_erreur = "";

if (erreur) {

}
else
{
	texte_erreur += "Votre demande a bien été prise en compte par le serveur.<br/>";
	window.parent.alerte.alerte_erreur ('Confirmation', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	window.parent.page.verify('liste_serveur_import','<?php echo $DIR."profil_admin/";?>serveur_import_liste.php','true','sub_content');
}
</script>
