<?php

// *************************************************************************************************************
// CONFIRMATION D'AJOUT D'UN SERVEUR D'EXPORT
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
<p>Confirmation d'Ajout d'un serveur d'EXPORT</p>
<p>&nbsp; </p>

<script type="text/javascript">
var erreur=<?php if ($_REQUEST["erreur"] == "1") { echo "true;";} else { echo "false;";}?>
var serveur_existants = <?php if (isset($_REQUEST["serveur_existants"]) && $_REQUEST["serveur_existants"] == "1") { echo "true;";} else { echo "false;";}?>
var texte_erreur = "";

if (erreur) {
	
	if (serveur_existants) {
		texte_erreur += "Vous êtes déjà abonné à ce serveur de mise à jour.<br/>";
	} 
	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
	texte_erreur += "Votre demande a bien été prise en compte par le serveur.<br/>";
	window.parent.alerte.alerte_erreur ('Confirmation', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	window.parent.page.verify('liste_serveur_import','<?php echo $DIR."profil_admin/";?>serveur_import_liste.php','true','sub_content');
}
</script>
