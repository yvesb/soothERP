<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ("_session.inc.php");

//ref_user : ref_user, id_type_event: id_type_event, affichage: affichage, fonctionRetour: fonctionRetour

if(isset($_REQUEST["ref_user"]))
{			$ref_user = $_REQUEST["ref_user"];}
else{	$ref_user = $_SESSION['user']->getRef_user();}

if(!isset($_REQUEST["id_type_event"])){
	echo "l'identifiant du type d'évenement n'est pas spécifiée";
	exit;
}
$id_type_event = $_REQUEST["id_type_event"];

$affichage = null;
if(isset($_REQUEST["affichage"]) && $_REQUEST["affichage"]!= ""){
	$affichage = $_REQUEST["affichage"]+0;
}else{
	$affichage = null;
}


$maj = $_SESSION["agenda"]["GestionnaireAgendas"]->majAgendasUsersEventsTypesAffichage($id_type_event, $affichage);

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


<?php /*
<script type="text/javascript">
var maj = false;	
parent.page_agenda_selectionner_types_events_result_fct_retour_afficher_events_types('checkbox2',false && maj,2);
</script>
*/ ?>
