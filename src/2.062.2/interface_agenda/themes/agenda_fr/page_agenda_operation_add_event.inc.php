<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<!-- L'événement vient d'être créer côté serveur, nous devons mettre à jour l'interface graphique -->
<script type="text/javascript">
//debugger;
//***************************************************************************
// FONCTIONS APPELEES SUIVANT LES CAS : VOIR SWITCH CASE plus bas
//***************************************************************************
//l'événement à été créé à la souris
function maj_event_graphic_jour(){
	<?php if($id_graphic_event != ""){ ?>
		alert("maj_event_graphic_jour() n'est pas encore implémentée");
	<?php } ?>
}

//l'événement à été créé à la souris
function maj_event_graphic_semaine(){
	<?php if($id_graphic_event != ""){ ?>
		if(Udate_deb_semaine < <?php echo $event->getUdate_event()." && ".$event->getUdate_event(); ?> < Udate_fin_semaine){
			evenements[<?php echo $id_graphic_event; ?>].setRef_Event("<?php echo $event->getRef_event(); ?>");
			evenements[<?php echo $id_graphic_event; ?>].setColors("<?php echo $agenda->getCouleur_1(); ?>", "<?php echo $agenda->getCouleur_2(); ?>", "<?php echo $agenda->getCouleur_3(); ?>");
			evenements[<?php echo $id_graphic_event; ?>].setTitre("<?php echo strftime("%H:%M", $event->getUdate_event())." - ".strftime("%H:%M", $event->getUdate_event()+($event->getDuree_event()*60)); ?>");
			evenements[<?php echo $id_graphic_event; ?>].setDescription("<?php echo $event->getLib_event(); ?>");
				
			panneau_eition_reset_formulaire();
			
			ecarterEvenements(evenements[<?php echo $id_graphic_event; ?>].cellJour);
			gride_is_locked = false;
		}else{
			evenements[id_graphic_event].deleteThis();
		}
	<?php } ?>
}

//l'événement à été créé à la souris
function maj_event_graphic_mois(){
<?php if($id_graphic_event != ""){ ?>
	alert("maj_event_graphic_mois() n'est pas encore implémentée");
<?php } ?>
}

//l'événement à été grace au panneau d'édition
function new_event_graphic_jour(){
	alert("new_event_graphic_jour() n'est pas encore implémentée");
}

//l'événement à été grace au panneau d'édition
function new_event_graphic_semaine(){
	if(Udate_deb_semaine < <?php echo $event->getUdate_event()." && ".$event->getUdate_event(); ?> < Udate_fin_semaine){
	//l'événement est dans la fenetre affichée, on affiche donc l'évélement
		var id = genIdGraphicEvent();
		$("id_graphic_event").value = id;
		
		<?php $j = strftime("%w", $event->getUdate_event());
		if($j == "0"){ ?>
			var event_x = 6 * largeurColoneSemaine();
		<?php }else{ ?>
			var event_x = <?php echo $j-1; ?> * largeurColoneSemaine();
		<?php } ?>
		var event_y = Math.floor(<?php echo strftime("(%H+%M/60)", $event->getUdate_event()); ?> * 2 * HAUTEUR_DEMIE_HEURE);
		var duree = Math.floor(<?php echo $event->getDuree_event(); ?> * HAUTEUR_DEMIE_HEURE / 30);//durée en px

		var eventNode = CreateDivEvenement("eventId_"+id, event_y, event_x, evenementMaxWidth(), duree, "");
		$("ZERO").appendChild(eventNode);
		var event = new evenement(eventNode);
		event.setRef_Event("<?php echo $event->getRef_event(); ?>");
		event.setColors("<?php echo $agenda->getCouleur_1(); ?>", "<?php echo $agenda->getCouleur_2(); ?>", "<?php echo $agenda->getCouleur_3(); ?>");
		event.setTitre("<?php echo strftime("%H:%M", $event->getUdate_event())." - ".strftime("%H:%M", $event->getUdate_event()+($event->getDuree_event()*60)); ?>");
		event.setDescription("<?php echo $event->getLib_event(); ?>");

		evenements[id] = event;
		event.addIntoMatrice();
		
		ecarterEvenements(event.cellJour);
	}
}

//l'événement à été grace au panneau d'édition, il faut créer un 
function new_event_graphic_mois(){
	alert("new_event_graphic_mois() n'est pas encore implémentée");
}
//***************************************************************************


switch ("<?php if($id_graphic_event == ''){echo 'new';}else{echo 'maj';}?>_event_graphic_"+scale_used) {
	case "maj_event_graphic_jour":{
		maj_event_graphic_jour();
	break;}
	case "maj_event_graphic_semaine":{
		maj_event_graphic_semaine();
	break;}
	case "maj_event_graphic_mois":{
		maj_event_graphic_mois();
	break;}
	case "new_event_graphic_jour":{
		new_event_graphic_jour();
	break;}
	case "new_event_graphic_semaine":{
		new_event_graphic_semaine();
	break;}
	case "new_event_graphic_mois":{
		new_event_graphic_mois();
	break;}
}

</script>
