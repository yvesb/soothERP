<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
   

// Variables nécessaires à l'affichage
$page_variables = array ("id_graphic_event", "ref_event", "lib_event", "Udate_event_deb", "Udate_event_fin", "note_event", "bt_maj_visible");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

$("panneau_event_edition").show();

var id_graphic_event = <?php echo $id_graphic_event; ?>;
	if($("ref_event").value == "")
	{		$("ref_event").value = "<?php echo $ref_event; ?>";}
	
	if($("id_graphic_event").value == "")
	{		$("id_graphic_event").value = id_graphic_event;}
	
	if($("evt_edition_lib2").value == "")
	{		$("evt_edition_lib2").value = "<?php echo htmlspecialchars_decode($lib_event); ?>";}
	
	if($("evt_edition_lib2").value == "")
	{		$("evt_edition_lib2").value = "<?php echo htmlspecialchars_decode($lib_event); ?>";}
	
	if($("evt_edition_agenda_old").value == ""){
			$("evt_edition_agenda_old").value = "<?php echo $ref_agenda; ?>";
			var select_agenda = $("evt_edition_agenda_selected");
			for(var i=0; i< select_agenda.options.length; i++){
				if(select_agenda.options[i].value == "<?php echo $ref_agenda; ?>"){
					select_agenda.selectedIndex = i;
					break;
				}
			}
	}
	
	$("evt_edition_date_deb"	).value	= "<?php echo strftime("%d/%m/%Y", 	$Udate_event_deb); ?>";
	$("evt_edition_heure_deb"	).value	= "<?php echo strftime("%H:%M", 		$Udate_event_deb); ?>";
	$("evt_edition_date_fin"	).value	= "<?php echo strftime("%d/%m/%Y", 	$Udate_event_fin); ?>";
	$("evt_edition_heure_fin"	).value	= "<?php echo strftime("%H:%M", 		$Udate_event_fin); ?>";
	
	if($("evt_edition_note").value == "")
	{		$("evt_edition_note").value = "<?php echo $note_event; ?>";}


	evenements[id_graphic_event].setTitre("<?php echo strftime("%H:%M", $Udate_event_deb); ?> - <?php echo strftime("%H:%M", $Udate_event_fin); ?>");
	evenements[id_graphic_event].resizeTitre();
	//GESTION DES 5 BOUTONS : AnnulerEvent ValiderEvent SupprimerEvent MajEvent NouveauEvent
	<?php switch ($bt_maj_visible) {
		case "vierge":{ ?> //VIERGE
			$("panneau_deition_curent_mode").value = panneau_deition_modes.none;
			$("AnnulerEvent"	).hide();
			$("ValiderEvent"	).hide();
			$("SupprimerEvent").hide();
			$("MajEvent"			).hide();
			//$("NouveauEvent"	).show(); //SHOW !

			autoUpdate = false;
		<?php break;}
		case "edition":{ ?> //EDITION
			$("panneau_deition_curent_mode").value = panneau_deition_modes.edition;
			$("AnnulerEvent"	).hide();
			$("ValiderEvent"	).hide();
			$("SupprimerEvent").show(); //SHOW !
			$("MajEvent"			).show(); //SHOW !
			//$("NouveauEvent"	).show();

			autoUpdate = true;
		<?php break;}
		case "validation":{ ?> //VALIDATION OU CREATION
			$("panneau_deition_curent_mode").value = panneau_deition_modes.creation;
			$("AnnulerEvent"	).show(); //SHOW !
			$("ValiderEvent"	).show(); //SHOW !
			$("SupprimerEvent").hide();
			$("MajEvent"			).hide();
			//$("NouveauEvent"	).hide();

			autoUpdate = false;
		<?php break;}
	} ?>
	$("evt_edition_lib").focus();
</script>
