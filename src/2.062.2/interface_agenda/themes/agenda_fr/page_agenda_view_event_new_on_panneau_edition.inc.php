<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
   
// Variables nécessaires à l'affichage
$page_variables = array ("id_graphic_event", "Udate_event_deb", "Udate_event_fin", "duree_event");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
$agendasAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getAgendasAvecDroits();
$droitsUserAgendas=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),42);
$selectOptionsAgenda =  Lib_interface_agenda::buildSelectOptionsAgenda($agendasAvecDroits,$droitsUserAgendas);

?>

<script type="text/javascript">
$("evt_edition_agenda_selected").innerHTML = '<?php echo $selectOptionsAgenda ?>';
$("panneau_event_edition").show();

var id_graphic_event = <?php echo $id_graphic_event; ?>;

if($("id_graphic_event").value == "")
{		$("id_graphic_event").value = id_graphic_event;}

$("panneau_event_edit_part_agenda").show();

//majSelect_Options_events_types($("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value, $("evt_edition_type_event_selected"));
<?php if(isset($_REQUEST["cook_agenda_selected"])){ ?>
	if($("evt_edition_agenda_selected").length > <?php echo $_REQUEST["cook_agenda_selected"] ?>){		
		majSelect_Options_events_types(<?php  echo $_REQUEST["cook_agenda_selected"];?>, $("evt_edition_agenda_selected").options[<?php echo $_REQUEST["cook_agenda_selected"] ?>].value, $("evt_edition_type_event_selected"));		
		majSelect_type_formulaire($("evt_edition_agenda_selected").options[<?php echo $_REQUEST["cook_agenda_selected"] ?>].value, $("panneau_event_formulaire_type"));
	}else{
		majSelect_Options_events_types($("evt_edition_agenda_selected").selectedIndex, $("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value, $("evt_edition_type_event_selected"));
		majSelect_type_formulaire($("evt_edition_agenda_selected").options[<?php echo $_REQUEST["cook_agenda_selected"] ?>].value, $("panneau_event_formulaire_type"));
	}
<?php }
else{ ?>
	majSelect_Options_events_types($("evt_edition_agenda_selected").selectedIndex, $("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value, $("evt_edition_type_event_selected"));
	majSelect_type_formulaire($("evt_edition_agenda_selected").options[<?php echo $_REQUEST["cook_agenda_selected"] ?>].value, $("panneau_event_formulaire_type"));
<?php } ?>

$("panneau_event_edit_part_evenement").show();


$("evt_edition_toute_la_journee").disabled = "";
$("evt_edition_date_deb"	).disabled = "";
$("evt_edition_heure_deb"	).disabled = "";
$("evt_edition_date_fin"	).disabled = "";
$("evt_edition_heure_fin"	).disabled = "";
$("evt_edition_date_deb"	).value	= "<?php echo strftime("%d/%m/%Y", 	$Udate_event_deb); ?>";
$("evt_edition_heure_deb"	).value	= "<?php echo strftime("%H:%M", 		$Udate_event_deb); ?>";
	 evt_edition_heure_deb = (<?php echo strftime("new Date(1970, 0, 1, %H, %M, 0, 0)", $Udate_event_deb); ?>).getTime();
$("evt_edition_date_fin"	).value	= "<?php echo strftime("%d/%m/%Y", 	$Udate_event_fin); ?>";
$("evt_edition_heure_fin"	).value	= "<?php echo strftime("%H:%M", 		$Udate_event_fin); ?>";
	 evt_edition_heure_fin = (<?php echo strftime("new Date(1970, 0, 1, %H, %M, 0, 0)", $Udate_event_fin); ?>).getTime();
$("panneau_event_edit_part_dates").show();

$("panneau_event_edit_part_notes").show();

if($("evt_edition_agenda_selected").length > <?php echo $_REQUEST["cook_agenda_selected"] ?>){
	$("evt_edition_agenda_selected").selectedIndex = <?php echo $_REQUEST["cook_agenda_selected"] ?>;
}
// *******************************************************************
	
evenements[id_graphic_event].setTitre("<?php echo strftime("%H:%M", $Udate_event_deb); ?> - <?php echo strftime("%H:%M", $Udate_event_fin); ?>");
//evenements[id_graphic_event].resizeTitre(); ???

//*******************************************************************

$("panneau_deition_curent_mode").value = panneau_deition_modes.creation;
$("AnnulerEvent"	).show();
if($("evt_edition_agenda_selected").innerHTML.indexOf("Aucun agenda disponible") > 0 ){
	$("ValiderEvent"	).hide();
}else{
	$("ValiderEvent"	).show();
}
$("SupprimerEvent").hide();
$("MajEvent"			).hide();

//*******************************************************************


$("evt_edition_lib").focus();

//*******************************************************************

autoUpdate = false;
</script>
