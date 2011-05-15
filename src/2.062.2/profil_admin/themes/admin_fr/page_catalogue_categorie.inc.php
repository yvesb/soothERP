<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('catalogue_categorie','catalogue_categorie.php' ,"true" ,"sub_content", "Gestion des cat&eacute;gories d'articles ");
update_menu_arbo();
</script>
<div class="emarge">

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_tarifs_assistant.inc.php" ?>
<p class="titre">Gestion des cat&eacute;gories d'articles </p>
	<table class="minimizetable"><tr><td style="width:300px">
<div id="list_art_categs">
	<?php include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_inc_list_cat.inc.php"); ?>
</div>
</td><td>
<div id="content_art_categs">



</div>
</td></tr></table>
<SCRIPT type="text/javascript">

//centrage de l'assistant tarif

centrage_element("pop_up_assistant_tarif");
centrage_element("pop_up_assistant_tarif_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_tarif_iframe");
centrage_element("pop_up_assistant_tarif");
});

//on masque le chargement
H_loading();
</SCRIPT>
</div>