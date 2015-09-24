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


if (!isset($_REQUEST["nb_taches_showed"]) || !is_numeric($_REQUEST["nb_taches_showed"])) {
    $GLOBALS['_ALERTES']['choisir_nb_taches_showed'] = 1;
}
if (!isset($_REQUEST["nb_taches_showed_acc"]) || !is_numeric($_REQUEST["nb_taches_showed_acc"])) {
    $GLOBALS['_ALERTES']['choisir_nb_taches_showed_acc'] = 1;
}


if (!count($GLOBALS['_ALERTES'])) {
	$string_file = file_get_contents($_REQUEST['file_path']);
    $string_file2 = file_get_contents($_REQUEST['file_path2']);
	
    $string_file2 = preg_replace('/\$NB_TACHES_SHOWED = ".*?";/s', '\$NB_TACHES_SHOWED = "' . addslashes($_REQUEST['nb_taches_showed']) . '";', $string_file2);
	$string_file2 = preg_replace('/\$NB_TACHES_SHOWED_ACCUEIL = ".*?";/s', '\$NB_TACHES_SHOWED_ACCUEIL = "' . addslashes($_REQUEST['nb_taches_showed_acc']) . '";', $string_file2);
    //echo $string_file;
    file_put_contents($_REQUEST['file_path'], $string_file);
	file_put_contents($_REQUEST['file_path2'], $string_file2);
}

//  ******************************************************
// AFFICHAGE
//  ******************************************************
//include ($DIR.$_SESSION['theme']->getDir_theme()."page_site_interfaces_config.generate.inc.php");
?>

<p>&nbsp;</p>
<p>Configuration de l'interfaces COLLAB</p>
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

        if (choisir_nb_taches_showed) {
            window.parent.document.getElementById("nb_taches_showed").className = "alerteform_xsize";
            texte_erreur += "Vous devez choisir le nombre de taches affichées.<br/>";
        } else {
            window.parent.document.getElementById("nb_taches_showed").className = "classinput_xsize";
        }
	    if (choisir_nb_taches_showed_acc) {
            window.parent.document.getElementById("nb_taches_showed_acc").className = "alerteform_xsize";
            texte_erreur += "Vous devez choisir le nombre de taches affichées sur la page d'accueil.<br/>";
        } else {
            window.parent.document.getElementById("nb_taches_showed_acc").className = "classinput_xsize";
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