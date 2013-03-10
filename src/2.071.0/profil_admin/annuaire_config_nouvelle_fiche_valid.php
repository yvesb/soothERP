<?php
// *************************************************************************************************************
// Gestion type coordonnées / types adresses
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!empty($_REQUEST['gest_type']))
    $valeur = 1;
else
    $valeur = 0;
maj_configuration_file("config_generale.inc.php", "maj_line", "\$GEST_TYPE_COORD =", "\$GEST_TYPE_COORD = $valeur;", $CONFIG_DIR);
?>
<script type="text/javascript">
    	window.parent.alerte.alerte_erreur ('Modification effectué', 'Les modifications ont bien été prises en compte','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
</script>
