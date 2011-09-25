<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("id_graphic_event", "event");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<!-- L'événement vient d'être créer côté serveur, nous devons mettre à jour l'interface graphique -->
<script type="text/javascript">
//l'événement à été créé à la souris
function maj_event_graphic_semaine(){
	<?php if($id_graphic_event != ""){ ?>
		if(Udate_deb_semaine < <?php echo $event->getUdate_event()."000 && ".$event->getUdate_event(); ?>000 < Udate_fin_semaine){
			
			<?php
			$j = strftime("%w", $event->getUdate_event());
			if($j == "0"){ ?>
				var futurX = 6 * largeurColonneSemaine() // en px
			<?php }else{ ?>
				var futurX = <?php echo $j-1; ?> * largeurColonneSemaine(); // en px
			<?php } ?>
			var futurY 			= Math.floor(<?php echo strftime("(%H+%M/60)", $event->getUdate_event()); ?> * 2 * HAUTEUR_DEMIE_HEURE); //en px
			var futurDuree  = Math.floor(<?php echo $event->getDuree_event(); ?> * HAUTEUR_DEMIE_HEURE / 30); //durée en px
			
			evenements[<?php echo $id_graphic_event; ?>].setPosition(futurX, futurY, futurDuree);
			evenements[<?php echo $id_graphic_event; ?>].setRef_Event("<?php echo $event->getRef_event(); ?>");
			evenements[<?php echo $id_graphic_event; ?>].setColors("<?php echo $event->getCouleur_1(); ?>", "<?php echo $event->getCouleur_2(); ?>", "<?php echo $event->getCouleur_3(); ?>");
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

//l'événement à été grace au panneau d'édition
function new_event_graphic_semaine(){
	if(Udate_deb_semaine < <?php echo $event->getUdate_event()."000 && ".$event->getUdate_event(); ?>000 < Udate_fin_semaine){
	//l'événement est dans la fenetre affichée, on affiche donc l'évélement
		var id = genIdGraphicEvent();
		$("id_graphic_event").value = id;
		
		<?php $j = strftime("%w", $event->getUdate_event());
		if($j == "0"){ ?>
			var event_x = 6 * largeurColonneSemaine();
		<?php }else{ ?>
			var event_x = <?php echo $j-1; ?> * largeurColonneSemaine();
		<?php } ?>
		var event_y = Math.floor(<?php echo strftime("(%H+%M/60)", $event->getUdate_event()); ?> * 2 * HAUTEUR_DEMIE_HEURE);
		var duree = Math.floor(<?php echo $event->getDuree_event(); ?> * HAUTEUR_DEMIE_HEURE / 30);//durée en px

		var eventNode = CreateDivEvenement("eventId_"+id, event_y, event_x, evenementMaxWidth(), duree, "");
		$("ZEROsemaine").appendChild(eventNode);
		var event = new_Evenement(eventNode);
		event.setRef_Event("<?php echo $event->getRef_event(); ?>");
		event.setColors("<?php echo $event->getCouleur_1(); ?>", "<?php echo $event->getCouleur_2(); ?>", "<?php echo $event->getCouleur_3(); ?>");
		event.setTitre("<?php echo strftime("%H:%M", $event->getUdate_event())." - ".strftime("%H:%M", $event->getUdate_event()+($event->getDuree_event()*60)); ?>");
		event.setDescription("<?php echo $event->getLib_event(); ?>");

		evenements[id] = event;
		event.addIntoMatrice();
		ecarterEvenements(event.cellJour);
	}
}


<?php if($id_graphic_event == ""){//NEW ?>
	new_event_graphic_semaine();
<?php }else{//MAJ ?>
	maj_event_graphic_semaine();
<?php } ?>

</script>
