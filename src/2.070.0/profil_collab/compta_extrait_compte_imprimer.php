<?php
// *************************************************************************************************************
// IMPRESSION D'UN EXTRAIT DE COMPTE CONTACT (PAR EXERCICE)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

function cmp($ar1, $ar2, $key)
{
  return ( ($ar1->$key > $ar2->$key) ? 1 : ( ($ar1->$key == $ar2->$key) ? 0 : -1));
}
function tri($array, $critere)
{
  $cmp = create_function('$a, $b', 'return cmp($a, $b, "'.$critere.'");');
  uasort($array, $cmp);
  return $array;
}

//fonction de génération des lettrages (double numérotation alphabétique)
function cre_lettrage ($old_lettrage){
	$a="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 	$part_a = substr($old_lettrage ,0,1);
 	$part_b = substr($old_lettrage ,1,1);
	if (strpos($a, $part_b) == strlen($a)-1) { 
		$part_b = "A";
		$part_a = substr($a ,strpos($a, $part_a)+1,1);
	} else {
		$part_b = substr($a ,strpos($a, $part_b)+1,1);
	}
	return $part_a.$part_b;
 
}
//**************************************
// Controle
$infos = array();

$infos["ref_contact"] = $_REQUEST["ref_contact"];
$infos["exercice"] = $_REQUEST["exercice"];

$compta_e = new compta_exercices ($_REQUEST['exercice']);
// Ouverture du fichier pdf de extrait de compte CONTACT
$compta_e->imprimer_extrait_compte ($_REQUEST["ref_contact"]);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>