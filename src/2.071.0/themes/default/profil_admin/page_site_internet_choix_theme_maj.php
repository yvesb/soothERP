<?php
// *********************************************
// CONFIG DES INTERFACES - THEMES
// *********************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

if ((!isset($_REQUEST["choix_theme_val"]))) {
	echo '<p>Impossible d\'operer un changement de theme</p>';
}
if (isset($_REQUEST["choix_theme_val"],$_REQUEST["valider_x"])) {
	maj_configuration_file("config_generale.inc.php", "maj_line", "\$CHOIX_THEME =", '$CHOIX_THEME = "'.$_REQUEST["choix_theme_val"].'"; ', $CONFIG_DIR);
	echo 'oki '.$_REQUEST["choix_theme_val"];
}
if (isset($_REQUEST["choix_theme_val"],$_REQUEST["modifier_x"])) {
	//Fonction de modification du theme
}
if (isset($_REQUEST["choix_theme_val"],$_REQUEST["supp_x"])) {
	//Fonction de suppression du theme
}

// AFFICHAGE
?>
<script type="text/javascript">

window.parent.page.traitecontent('site_internet_choix_theme','site_internet_choix_theme.php','true','sub_content');

</script>