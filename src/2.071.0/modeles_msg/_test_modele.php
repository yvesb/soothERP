<?php

require ("_dir.inc.php");
require ($DIR."_session.inc.php");

$filename = $TPL_MODELES_DIR."modele_relance_client.tpl";

//$mon_modele = new template($filename);

//echo $mon_modele->generate_html();

$mon_modele = new msg_modele_relance_client(3);
$mon_modele->initvars("C-000000-00003", 2);
_vardump($mon_modele);
echo $mon_modele->get_html();

?>
