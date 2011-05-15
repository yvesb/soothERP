<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("event", "jour_semaine", "sheure_deb", "sheure_fin", "sdate_deb", "sdate_fin");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<script type="text/javascript">

	var id_graphic_event = "<?php echo $id_graphic_event; ?>";
	var UdateEvent = <?php echo $event->getUdate_event(); ?>;
	if(Udate_deb_semaine < UdateEvent && UdateEvent < Udate_fin_semaine){
	//l'événement est dans la semaine affiché, il faut donc l'afficher

		<?php $titre = $sheure_deb;
		if($sdate_deb == $sdate_fin){//même jour
			$titre.= " - ".$sheure_fin;
		} ?>
		
		if(evenements[id_graphic_event] == undefined){
		//l'événement N'est PAS connu de l'interface graphique 
			
			id_graphic_event = genIdGraphicEvent();
			$("id_graphic_event").value = id_graphic_event;
			var event_x =  largeurColoneSemaine() * <?php echo $jour_semaine; ?>;
			var event_y =  Math.floor(<?php echo strftime("(%H*2+%M/60)", $event->getUdate_event()); ?> * HAUTEUR_DEMIE_HEURE);
			var duree = Math.floor(<?php echo $event->getDuree_event(); ?> * HAUTEUR_DEMIE_HEURE / 30);//durée en px
			var eventNode = CreateDivEvenement("eventId_"+id_graphic_event, event_y, event_x, evenementMaxWidth(), duree, "");
			
			$("ZERO").appendChild(eventNode);
			var event = new evenement(eventNode);

			//evenements[id_graphic_event] = event;
			event.addIntoMatrice();

			event.setRef_Event("<?php echo $event->getRef_event(); ?>");

			<?php $agenda = $event->getAgenda(); ?>
			event.setColors("<?php echo $agenda->getCouleur_1(); ?>", "<?php echo $agenda->getCouleur_2(); ?>", "<?php echo $agenda->getCouleur_3(); ?>");

			event.setTitre("<?php echo $titre; ?>");
			event.setDescription("<?php echo $event->getLib_event(); ?>");

			evenements[id_graphic_event] = event;
			
			ecarterEvenements(<?php echo $jour_semaine; ?>);
		}else{
		//l'événement EST connu de l'interface graphique 
			var event = evenements[id_graphic_event];
			var oldCellJour 			= event.cellJour;

			<?php
			$j = strftime("%w", $event->getUdate_event());
			if($j == "0"){ ?>
				var futurX = 6 * largeurColoneSemaine() // en px
			<?php }else{ ?>
				var futurX = <?php echo $j-1; ?> * largeurColoneSemaine(); // en px
			<?php } ?>
			var futurY 			= Math.floor(<?php echo strftime("(%H+%M/60)", $event->getUdate_event()); ?> * 2 * HAUTEUR_DEMIE_HEURE); //en px
			var futurDuree  = Math.floor(<?php echo $event->getDuree_event(); ?> * HAUTEUR_DEMIE_HEURE / 30); //durée en px
			
			event.setPosition(futurX, futurY, futurDuree);
			event.setColors("<?php echo $agenda->getCouleur_1(); ?>", "<?php echo $agenda->getCouleur_2(); ?>", "<?php echo $agenda->getCouleur_3(); ?>");
			event.setTitre("<?php echo $titre; ?>");
			event.setDescription("<?php echo $event->getLib_event(); ?>");

			ecarterEvenements(oldCellJour);
			if(oldCellJour != event.cellJour)
			{		ecarterEvenements(event.cellJour);}
		}
	}else{
		if(evenements[id_graphic_event] != undefined){
		//l'événement N'est PAS connu de l'interface graphique
			evenements[id_graphic_event].deleteThis();
		}
	}
</script>
