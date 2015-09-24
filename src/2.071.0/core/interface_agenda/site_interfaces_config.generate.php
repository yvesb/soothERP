<?php
//  ******************************************************
// CREATION DU FICHIER DE CONFIG - INTERFACE CLIENT
//  ******************************************************
GLOBAL $CORE_REP,$DIR;
require("_dir.inc.php");
require ("_profil.inc.php");
require_once ($DIR."_session.inc.php");
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


if (!isset($_REQUEST["evt_duree_def"]) || !is_numeric($_REQUEST["evt_duree_def"])) {
    $GLOBALS['_ALERTES']['choisir_evt_duree_def'] = 1;
}


if (!count($GLOBALS['_ALERTES'])) {
    $string_file = file_get_contents('../' . $_REQUEST['file_path']);


    $string_file = preg_replace('/\$event_DUREE_DEFAUT = ".*?";/s', '\$event_DUREE_DEFAUT = "' . addslashes($_REQUEST['evt_duree_def']) . '";', $string_file);
    //echo $string_file;
    file_put_contents('../' . $_REQUEST['file_path'], $string_file);
}

//  ******************************************************
// AFFICHAGE
//  ******************************************************
//include ($DIR.$_SESSION['theme']->getDir_theme()."page_site_interfaces_config.generate.inc.php");
?>

<p>&nbsp;</p>
<p>Configuration des interfaces</p>
<p>&nbsp; </p>
<?php
foreach ($_ALERTES as $alerte => $value) {
    echo $alerte . " => " . $value . "<br>";
}
?>
<script type="text/javascript">
    var erreur = false;
    var texte_erreur = "";
<?php
if (count($_ALERTES) > 0) {
    
}
foreach ($_ALERTES as $alerte => $value) {
    if ($alerte == "choisir_evt_duree_def") {
        echo "choisir_evt_duree_def=true;";
        echo "erreur=true;\n";
    }
    if ($alerte == "transfert_error") {
        echo "transfert_error=true;";
        echo "erreur=true;\n";
    }
}
?>
    if (erreur) {

        if (choisir_evt_duree_def) {
            window.parent.document.getElementById("evt_duree_def").className = "alerteform_xsize";
            texte_erreur += "Vous devez choisir une durée standart pour les évenements.<br/>";
        } else {
            window.parent.document.getElementById("evt_duree_def").className = "classinput_xsize";
        }
        window.parent.alerte.alerte_erreur('Erreur de saisie', texte_erreur, '<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

    }
    else
    {

        window.parent.changed = false;
        window.parent.page.traitecontent('Site_interfaces_config', 'site_interfaces_config.php', 'true', 'sub_content');
        window.parent.alerte.alerte_erreur('Configuration effectuée', 'La configuration de l\'interface à été effectuée avec succès.', '<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

    }

</script>