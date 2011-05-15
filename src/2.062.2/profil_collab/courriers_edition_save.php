<?php
// *************************************************************************************************************
// SAUVEGARDE DU COURRIER
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$ref_destinataire = $_REQUEST["ref_destinataire"];



if(!isset($_REQUEST["cmd"])){
	echo "le nom de la commande n'est pas spécifié";
	exit;
}
$cmd = $_REQUEST["cmd"];

//SAUVEGARDE DU COURRIER
$courrier = new CourrierEtendu($_REQUEST["id_courrier"]);
$courrier->setContenu($_REQUEST["contenu_courrier"]);
$courrier->setObjet($_REQUEST["objet_courrier"]);
//$courrier->setId_type_courrier($_REQUEST["id_type_courrier"]);

$d = new DateTime();
$ref_user = $_SESSION['user']->getRef_user ();
$event = $d->format("d-m-Y H:i:s")." - Modification du courrier n°".$courrier->getId_courrier()."<br/>";
$event.= "Destinataire : ".$ref_destinataire."<br/>";
$event.= "Expéditeur : ".$ref_user."<br/>"; 
$courrier->addEvent($d->format("Y-m-d H:i:s"),2 /*=>Changement d'état*/, $event, $ref_user);

//Excution de la commande
switch ($cmd) {
	case "apercu":{;break;}
	case "print":{;break;}
	case "fax"	:{ //@TODO COURRIER : Gestion du FAX : Traitement du FAX si besoin
								;break;}
	case "email":{;break;}
	case "valider":{ //@TODO COURRIER : Gestion de la VALIDATION : Traitement de la VALIDATION si besoin
								$event = $d->format("d-m-Y H:i:s")." - Validation du courrier n°".$courrier->getId_courrier()."<br/>";
								$event.= "Destinataire : ".$ref_destinataire."<br/>";
								$event.= "Expéditeur : ".$ref_user."<br/>"; 
								$courrier->addEvent($d->format("Y-m-d H:i:s"),3 /*=>Changement d'état*/, $event, $ref_user);
								$courrier->setId_etat_courrier(Courrier::ETAT_REDIGE());
								break;}
	default:{;break;}
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_edition_save.inc.php");

?>