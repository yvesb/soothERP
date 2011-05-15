<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
   

// Variables nécessaires à l'affichage
$page_variables = array ("echelle", "event", "id_graphic_event", "bt_maj_visible");
check_page_variables ($page_variables);

$agendasAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getAgendasAvecDroits();
$droitsUserAgendas=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),42);
$selectOptionsAgenda =  Lib_interface_agenda::buildSelectOptionsAgenda($agendasAvecDroits,$droitsUserAgendas);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>


<script type="text/javascript">


var id_graphic_event = <?php echo $id_graphic_event; ?>;

if($("ref_event").value == "")
{		$("ref_event").value = "<?php echo $event->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]); ?>";}

if($("id_graphic_event").value == "" && id_graphic_event != 0)
{		$("id_graphic_event").value = id_graphic_event;}

<?php 
$lib_event = $event->getLib_event($_SESSION["agenda"]["GestionnaireEvenements"]);
$ref_agenda 			= $event->getRef_agenda	($_SESSION["agenda"]["GestionnaireEvenements"]);
if($lib_event === false){ ?>
	$("panneau_event_edit_part_evenement").hide();<?php
}else{
	global $bdd;
	$ref_agenda_event = $event->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]);
	$query = "SELECT `quantite` FROM `agendas_events_location` WHERE `ref_agenda_event` = '".$ref_agenda_event."' ";
	$res = $bdd->query($query);
	if(!$retour = $res->fetchObject()){
		$location = false;
	}else
	{
		$location = true;
		$quantite = $retour->quantite;}
	if(!$_SESSION["agenda"]["GestionnaireEvenements"]->setLib_event($event))
	{			echo '$("evt_edition_lib").disabled = "disabled";';}
	else{	echo '$("evt_edition_lib").disabled = "";';} ?>
	
	majSelect_type_formulaire("<?php echo $ref_agenda; ?>", $("panneau_event_formulaire_type"));
	if($("evt_edition_lib").value == "")
	{		$("evt_edition_lib2").value = "<?php echo htmlspecialchars_decode($lib_event); ?>";}
	$("panneau_event_edit_part_evenement").show();
	<?php if($location){ ?>
	if($("evt_edition_qte"))
	{				
		$("evt_edition_qte").value = <?php echo $quantite;?>;
	}
	<?php 
	}
} ?>


// *******************************************************************

<?php
//$ref_agenda 			= $event->getRef_agenda	($_SESSION["agenda"]["GestionnaireEvenements"]);
$id_type_agenda 	= $event->getId_type_agenda	($_SESSION["agenda"]["GestionnaireEvenements"]);
$id_type_event		= $event->getId_type_event	($_SESSION["agenda"]["GestionnaireEvenements"]);

global $bdd;
$query = "SELECT lib_agenda FROM agendas WHERE ref_agenda = '".$ref_agenda."' ";
$ret= $bdd->query($query);
if($retour = $ret->fetchObject()){
	$lib_agenda = $retour->lib_agenda;
}


if($ref_agenda === false || $id_type_agenda === false || $id_type_event === false){ ?>
	$("panneau_event_edit_part_agenda").hide();
	$("panneau_event_edit_part_type_event").hide(); <?php 
}else{ ?>
	var select_agenda = 		$("evt_edition_agenda_selected");
	var select_type_event = $("evt_edition_type_event_selected");<?php
	if($readonly=='false'){
		echo 'select_agenda.disabled = "";';
		echo 'enableContenu("panneau_event_edition");';
	}
	
	if(!$_SESSION["agenda"]["GestionnaireEvenements"]->setRef_agenda($event) || $readonly == 'true')
	{			echo 'select_agenda.disabled = "disabled";';
				echo 'disableContenu("panneau_event_edition");';
	}
	else{	echo 'select_agenda.disabled = "";';}
	
	if(!$_SESSION["agenda"]["GestionnaireEvenements"]->setId_type_event($event))
	{			echo 'select_type_event.disabled = "disabled";';}
	else{	echo 'select_type_event.disabled = "";';} ?>
	
	if($("evt_edition_agenda_old").value == ""){
		$("evt_edition_agenda_old").value = "<?php echo $ref_agenda;?>";
		
		<?php if($readonly == 'false'){ ?>
		
		$("evt_edition_agenda_selected").innerHTML = '<?php echo $selectOptionsAgenda ?>';
		for(var i=0; i< select_agenda.options.length; i++){
			if(select_agenda.options[i].value == "<?php echo $ref_agenda; ?>"){
				select_agenda.selectedIndex = i;
				break;
			}			
		}
		<?php }else{ ?>
			$("evt_edition_agenda_selected").innerHTML = "<option value = 0><?php echo $lib_agenda?></option>";
		<?php } ?>		
		if($("evt_edition_type_event_old").value == ""){
			$("evt_edition_type_event_old").value = "<?php echo $id_type_event;?>";

			<?php
			$eventsTypesAvecDroitOfAg = $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsTypesAvecDroits($ref_agenda);
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT] = array();
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["libEvent"] = string;
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["affiche"] = bool;
			//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["droits"] = int[];
			
			reset($eventsTypesAvecDroitOfAg);
			for ($i = 0; $i< count($eventsTypesAvecDroitOfAg); $i++){
				$index = key($eventsTypesAvecDroitOfAg); ?>
				select_type_event.options[select_type_event.options.length] = new Option(<?php echo "'".$eventsTypesAvecDroitOfAg[$index]["libEvent"]."', '".$index."'";if($i==0){ echo ",false,true"; } ?>); 
				<?php
			next($eventsTypesAvecDroitOfAg);} ?>
		}
	}
	$("panneau_event_edit_part_agenda").show();
	$("panneau_event_edit_part_type_event").show();<?php
} ?>


// ****************************************************************************
		
<?php 
$id_type_event = $event->getId_type_event($_SESSION["agenda"]["GestionnaireEvenements"]);
if($id_type_event === false){ ?>
	$("panneau_event_edit_part_type_event").hide();<?php 
}else{ ?>
	var select_type_event = $("evt_edition_type_event_selected");<?php
	if(!$_SESSION["agenda"]["GestionnaireEvenements"]->setId_type_event($event))
	{			echo 'select_type_event.disabled = "disabled";';}
	else{	echo 'select_type_event.disabled = "";';} ?>
	if($("evt_edition_type_event_old").value == ""){
		$("evt_edition_type_event_old").value = "<?php echo $id_type_event; ?>";
	
		for(var i=0; i < select_type_event.options.length; i++){
			if(select_type_event.options[i].value == "<?php echo $event->getId_type_event($_SESSION["agenda"]["GestionnaireEvenements"]); ?>"){
				select_type_event.selectedIndex = i;
				break;
			}
		}
	}
	$("panneau_event_edit_part_type_event").show();<?php 
} ?>

// *******************************************************************

<?php 
$Udate_event_deb 	= $event->getUdate_event($_SESSION["agenda"]["GestionnaireEvenements"]);
$Udate_event_fin 	= $event->getUdate_event($_SESSION["agenda"]["GestionnaireEvenements"])+($event->getDuree_event()*60);
if($Udate_event_deb === false){?>
	$("panneau_event_edit_part_dates").hide();
<?php }else{ ?>
	<?php if(!$_SESSION["agenda"]["GestionnaireEvenements"]->setUdate_event($event)){ ?>
		$("evt_edition_toute_la_journee").disabled = "disabled";
		$("evt_edition_date_deb").disabled = "disabled";
		$("evt_edition_heure_deb").disabled = "disabled";
		$("evt_edition_date_fin").disabled = "disabled";
		$("evt_edition_heure_fin").disabled = "disabled";
	<?php }else{ ?>
		$("evt_edition_toute_la_journee").disabled = "";
		$("evt_edition_date_deb").disabled = "";
		$("evt_edition_heure_deb").disabled = "";
		$("evt_edition_date_fin").disabled = "";
		$("evt_edition_heure_fin").disabled = "";
	<?php } ?>
	$("evt_edition_date_deb"	).value	= "<?php echo strftime("%d/%m/%Y", 	$Udate_event_deb); ?>";
	$("evt_edition_heure_deb"	).value	= "<?php echo strftime("%H:%M", 		$Udate_event_deb); ?>";
		evt_edition_heure_deb = (<?php echo strftime("new Date(1970, 0, 1, %H, %M, 0, 0)", $Udate_event_deb); ?>).getTime();
	$("evt_edition_date_fin"	).value	= "<?php echo strftime("%d/%m/%Y", 	$Udate_event_fin); ?>";
		evt_edition_heure_fin = (<?php echo strftime("new Date(1970, 0, 1, %H, %M, 0, 0)", $Udate_event_fin); ?>).getTime();
		$("evt_edition_heure_fin"	).value	= "<?php echo strftime("%H:%M", 		$Udate_event_fin); ?>";
	$("panneau_event_edit_part_dates").show();
<?php } ?>

// *******************************************************************

<?php 
$note_event = $event->getNote_event($_SESSION["agenda"]["GestionnaireEvenements"]);
if($note_event === false){?>
	$("panneau_event_edit_part_notes").hide();
<?php }else{
	if(!$_SESSION["agenda"]["GestionnaireEvenements"]->setNote_event($event))
	{			echo '$("evt_edition_note").disabled = "disabled";';}
	else{	echo '$("evt_edition_note").disabled = "";';} ?>
	if($("evt_edition_note").value == ""){
		$("evt_edition_note").value = unescape("<?php echo rawurlencode(htmlspecialchars_decode($note_event)); ?>".replace(/\+/g, '%20'));
	}
	$("panneau_event_edit_part_notes").show();
<?php } ?>
// *******************************************************************

<?php switch ($echelle) {
	case "JOUR":{ ?> //JOUR
	
	<?php break;}
	case "SEMAINE":{ ?> //SEMAINE
		evenements[id_graphic_event].setTitre("<?php echo strftime("%H:%M", $Udate_event_deb); ?> - <?php echo strftime("%H:%M", $Udate_event_fin); ?>");
		evenements[id_graphic_event].resizeTitre();	
	<?php break;}
	case "MOIS":{ ?> //MOIS
		
	<?php break;}
}?>

//GESTION DES 5 BOUTONS : AnnulerEvent ValiderEvent SupprimerEvent MajEvent NouveauEvent
<?php switch ($bt_maj_visible) {
	case EDITION:{ ?> //EDITION
		$("panneau_deition_curent_mode").value = panneau_deition_modes.edition;
		$("AnnulerEvent"	).hide();
		$("ValiderEvent"	).hide();
		$("SupprimerEvent").show(); //SHOW !
		$("MajEvent"			).show(); //SHOW !
		autoUpdate = true;
	<?php break;}
	case PAS_DROIT:{ ?> //AUCUN_DROIT
		$("panneau_deition_curent_mode").value = panneau_deition_modes.none;
		$("AnnulerEvent"	).hide();
		$("ValiderEvent"	).hide();
		$("SupprimerEvent").hide();
		$("MajEvent"			).hide();
		autoUpdate = false;
	<?php break;}
} ?>
$("panneau_event_edition").show();
$("evt_edition_lib").focus();
</script>
