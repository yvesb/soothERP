<?php
// *************************************************************************************************************
// 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!isset($_REQUEST['id_contact_tmp'])){
	echo "l'identifiant du contact n'est pas spécifié";
	exit;
}
$id_contact_tmp = $_REQUEST['id_contact_tmp'];

if(isset($_REQUEST['action'])){
	echo "l'action n'est pas spécifiée";
	exit;
}
$action = $_REQUEST['action'];

$query ="	SELECT	a.id_contact_tmp, a.id_interface, i.dossier, i.id_profil	  									
    			FROM			annuaire_tmp a
    			LEFT JOIN interfaces i ON a.id_interface = i.id_interface
    			WHERE		a.id_contact_tmp = ".$id_contact_tmp."
  				&&			a.mode = 'inscription'";
$resultat = $bdd->query($query);
if(!$res = $resultat->fetchObject()){
	echo "l'objet est mal enregistré dans la base de données";
	exit;
}

if(file_exists($DIR.$res->i.dossier."inscription_".substr($res->i.dossier, 0, -1).".class.php")){
	require_once($DIR.$res->i.dossier."inscription_".substr($res->i.dossier, 0, -1).".class.php");
	$classe_inscription = "inscription_".substr($res->i.dossier, 0, -1).".class.php";
	$inscription = new $classe_inscription($res->id_interface);
}
else{
	$inscription = new Inscription_profil_client($res->id_interface);
}


if($_REQUEST['action'] == "valider")
{		$new_user =  $inscription->validation_inscription_contact_par_collaborateur($res->id_contact_tmp);}
elseif($_REQUEST['action'] == "refuser")
{		$res_refus = $inscription->refus_inscription_contact_par_collaborateur($res->id_contact_tmp);}
else{
	echo "l'action n'est pas valide";
	exit; 
}

unset($inscription);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_val_ins_infos.inc.php");

?>