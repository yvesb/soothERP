<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES CAISSES
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<div class="emarge"><br />
    <p class="titre">Gestion des autorisations de traites du contact</p>
    <!-- Popups -->
    <!-- Créer x balises div cachés pour x popups, puis apeller la page de contenu via AJAX ? -->
    <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" //mini_moteur contact?>
    <?php echo Helper::createPopup("pop_up_traites",array("style_popup"=>"width: 600px; min-height: 250px;")); ?>
    <?php echo Helper::createPopup("pop_up_piecej_add",array("style_popup"=>"width: 50%; height: 350px;")); ?>
    <!-- fin popups -->

    <input type="hidden" id="search_client" value="<?php echo $_REQUEST['ref_contact']; ?>" />
    <div id="resultats">

    </div>
</div>


<script type="text/javascript">
    compta_traites_result();


    //centrage de la pop up comm
    centrage_element("pop_up_traites");
    centrage_element("pop_up_mini_moteur");
    centrage_element("pop_up_mini_moteur_iframe");
    centrage_element("pop_up_piecej_add");

    Event.observe(window, "resize", function(evt){
        centrage_element("pop_up_prelev");
        centrage_element("pop_up_mini_moteur_iframe");
        centrage_element("pop_up_mini_moteur");
        centrage_element("pop_up_piecej_add");
    });

    //on masque le chargement
    H_loading();
</script>