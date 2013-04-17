<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ("_session.inc.php");

//ref_user : ref_user, ref_agenda: ref_agenda, affichage: affichage

if(isset($_REQUEST["ref_user"]))
{			$ref_user = $_REQUEST["ref_user"];}
else{	$ref_user = $_SESSION['user']->getRef_user();}

if(!isset($_REQUEST["ref_agenda"])){
	echo "la référence de l'agenda n'est pas spécifiée";
	exit;
}
$ref_agenda = $_REQUEST["ref_agenda"];

$affichage = null;
if(isset($_REQUEST["affichage"]) && $_REQUEST["affichage"]!= ""){
	$affichage = $_REQUEST["affichage"];
}else{
	$affichage = null;
}



$maj = $_SESSION["agenda"]["GestionnaireAgendas"]->majAgendasUsersAgendasAffichage($ref_agenda, $affichage);

// *************************************************************************************************************
// FONCTION DE RETOUR
// *************************************************************************************************************

if(isset($_REQUEST["fonctionRetour"])){ ?>
<script type="text/javascript">
<?php if($maj) echo "var maj = true;";
			else		echo "var maj = false;";?>
	
parent.<?php echo $_REQUEST["fonctionRetour"]; ?>

</script>
<?php } ?>
