<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("event", "canBeShown", "jour_semaine", "sheure_deb", "sheure_fin", "sdate_deb", "sdate_fin");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<script type="text/javascript">
	var id_graphic_event = "<?php echo $id_graphic_event; ?>";
	var UdateEvent = <?php echo $event->getUdate_event(); ?>000;

	// *************************************************************************************************************
	if( <?php if($canBeShown){echo "true";}else{echo "false";}; ?> 	// l'événement peut être affiché
			&& Udate_deb_semaine < UdateEvent 			// 
			&& UdateEvent < Udate_fin_semaine){ // && l'événement est dans la semaine affiché
			// => il faut donc l'afficher 
	
		<?php $titre = $sheure_deb;
		if($sdate_deb == $sdate_fin){//même jour
			$titre.= " - ".$sheure_fin;
		} ?>
			
		if(evenements[id_graphic_event] == undefined){ //l'événement N'est PAS connu de l'interface graphique 
			
			id_graphic_event = genIdGraphicEvent();
			$("id_graphic_event").value = id_graphic_event;
			var event_x =  largeurColonneSemaine() * <?php echo $jour_semaine; ?>;
			var event_y =  Math.floor(<?php echo strftime("(%H*2+%M/60)", $event->getUdate_event()); ?> * HAUTEUR_DEMIE_HEURE);
			var duree = Math.floor(<?php echo $event->getDuree_event(); ?> * HAUTEUR_DEMIE_HEURE / 30);//durée en px
			var eventNode = CreateDivEvenement("eventId_"+id_graphic_event, event_y, event_x, evenementMaxWidth(), duree, "");
			
			$("ZEROsemaine").appendChild(eventNode);
			var event = new_Evenement(eventNode);
	
			evenements[id_graphic_event] = event;
			event.addIntoMatrice();
	
			event.setRef_Event("<?php echo $event->getRef_event(); ?>");
	
			event.setColors("<?php echo $event->getCouleur_1(); ?>", "<?php echo $event->getCouleur_2(); ?>", "<?php echo $event->getCouleur_3(); ?>");
	
			event.setTitre("<?php echo $titre; ?>");
			event.setDescription("<?php echo $event->getLib_event(); ?>");
	
			ecarterEvenements(<?php echo $jour_semaine; ?>);
			
		}else{ //l'événement EST connu de l'interface graphique 
				var event = evenements[id_graphic_event];
				var oldCellJour 			= event.cellJour;
	
				<?php
				$j = strftime("%w", $event->getUdate_event());
				if($j == "0"){ ?>
					var futurX = 6 * largeurColonneSemaine() // en px
				<?php }else{ ?>
					var futurX = <?php echo $j-1; ?> * largeurColonneSemaine(); // en px
				<?php } ?>
				var futurY 			= Math.floor(<?php echo strftime("(%H+%M/60)", $event->getUdate_event()); ?> * 2 * HAUTEUR_DEMIE_HEURE); //en px
				var futurDuree  = Math.floor(<?php echo $event->getDuree_event(); ?> * HAUTEUR_DEMIE_HEURE / 30); //durée en px
				
				event.setPosition(futurX, futurY, futurDuree);
				event.setColors("<?php echo $event->getCouleur_1(); ?>", "<?php echo $event->getCouleur_2(); ?>", "<?php echo $event->getCouleur_3(); ?>");
				event.setTitre("<?php echo $titre; ?>");
				event.setDescription("<?php echo $event->getLib_event(); ?>");
	
				ecarterEvenements(oldCellJour);
				if(oldCellJour != event.cellJour)
				{		ecarterEvenements(event.cellJour);}
			}
	}else{// *************************************************************************************************************
		if(evenements[id_graphic_event] != undefined){
		//l'événement N'est PAS connu de l'interface graphique
			evenements[id_graphic_event].deleteThis();
		}
	}
</script>
