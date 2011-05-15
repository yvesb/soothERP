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
<script type="text/javascript" language="javascript">
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('annuaire_config_nouvelle_fiche','annuaire_config_nouvelle_fiche.php',"true" ,"sub_content", "Configuration des donn&eacute;es li&eacute;es  &agrave; la cr&eacute;ation d'un nouveau contact");
update_menu_arbo();

id_index_contentcoord=0;
</script>
<div class="emarge">
    <p class="titre">Configuration des fiches contact </p>
    <div  class="contactview_corps">
        <form action="annuaire_config_nouvelle_fiche_valid.php" method="post" target="formFrame">
            <p>&nbsp;Activer les types d'adresses et de coordonn&eacute;es<input type="checkbox" value="1" id="gest_type" name="gest_type" <?php if($GEST_TYPE_COORD) echo "checked=\"checked\""; ?> /></p>
            <br />
            <p style="text-align:center">
                <input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
            </p>
        </form>
    </div>
</div>
<?php
?>
