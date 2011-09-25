<?php


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (array_key_exists("cat", $_REQUEST)) {
  $tomorrow = 0;//60*60*24; // en nb de secondes
  header("Cache-Control: max-age=$tomorrow");
  print_plain();
}
else {
  print "Usage : $_SERVER[PHP_SELF]?cat=un-nom";
}

function print_plain() {
  header("Content-type: text/html; charset=windows-1252");
  get_civil(urldecode ($_REQUEST["cat"]));
  
}

function get_civil($cat) {
	global $bdd;
	$row = get_civilites ($cat);
		// on boucle sur tous les éléments
		foreach ($row as $civ) {
    	$result[] = $civ->id_civilite."=".$civ->lib_civ_court;
  		}
  print implode(";", $result);
}

?>