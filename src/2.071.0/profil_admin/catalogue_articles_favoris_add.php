<?php
// *************************************************************************************************************
// AJOUTER ARTICLES FAVORIS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

global $bdd;

if (empty($_REQUEST['ref_art_fav']))
{
    ?> <script type="text/javascript">
            window.parent.alerte.alerte_erreur ('Erreur', "Veuillez indiquer une référence valide",'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
    </script>
<?php
}

else
{
        if (article::_add_article_fav($_REQUEST['ref_art_fav']) == false)
            {
                 ?> <script type="text/javascript">
            window.parent.alerte.alerte_erreur ('Erreur', "Veuillez indiquer une référence valide",'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
    </script>
<?php
            }
        else
            {
                ?> <script type="text/javascript">
            window.parent.alerte.alerte_erreur ('Ajout effectué', "L'article a été ajouté avec succès.",'<input type="submit" id="bouton0" name="bouton0" onClick="window.parent.location.reload()" value="Ok" />', parent.window.location.reload());
                </script>
<?php
            }
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>