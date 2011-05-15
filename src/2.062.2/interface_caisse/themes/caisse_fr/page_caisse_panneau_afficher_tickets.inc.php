<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("lib_panneau", "ticket_editable");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<div class="panneau_bas">
	<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="panneau_bas_barre_titre">
			<td class="panneau_bas_barre_titre_left"	></td>
			<td class="panneau_bas_barre_titre_coprs"	><?php echo $lib_panneau;?></td>
			<td class="panneau_bas_barre_titre_right"	></td>
		</tr>
	</table>
	
		<table border="0" cellspacing="10px" width="1244px">
			<tr>
				<?php
				$nb_tickets = count($tickets);
				$i = 0;
				foreach ($tickets as $ticket){
					if(false){$ticket = new doc_tic();}
					$events = $ticket->getEvents();
					$ev = $events[count($events)-1];
					?>
					<td id="ticket_a_charger_<?php echo $ticket->getRef_doc();?>" class="liste_ticket_cell_ticket">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="19%"></td>
								<td width="26%"></td>
								<td width="25%"></td>
								<td width="30%"></td>
							</tr>
							<tr>
								<td colspan="3" class="liste_ticket_date_last_edit"><?php echo date_format(new DateTime($ev->date_event), "d/m/Y");?></td>
								<td align="right" rowspan="2">
									<img alt="Supprimer" title="Supprimer" id="ticket_a_charger_suppr_<?php echo $ticket->getRef_doc();?>" name="ticket_a_charger_suppr_<?php echo $ticket->getRef_doc();?>"
									src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fermer_geant.png">
								</td>
							</tr>
							<tr>
								<td colspan="3" class="liste_ticket_date_last_edit"><?php echo date_format(new DateTime($ev->date_event), "H:i:s");?></td>
							</tr>
							<tr>
								<td colspan="4" align="left" class="liste_ticket_pseudo" ><?php echo $ev->pseudo; ?></td>
							</tr>
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="liste_ticket_montant" style="text-align:left;">MONTANT:</td>
								<td colspan="2" class="liste_ticket_montant" style="text-align:right;"><?php echo str_replace(' ', '', price_format($ticket->getMontant_to_pay()));?>&nbsp;&euro;</td>
							</tr>
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" class="liste_ticket_date_etat">Création :</td>
								<td colspan="3" align="right" class="liste_ticket_date_etat"><?php echo date_format(new DateTime($ticket->getDate_creation()), "d/m/Y H:i:s");?></td>
							</tr>
							<tr>
								<td align="left" class="liste_ticket_date_etat" >Etat : </td>
								<td colspan="3" align="right"  class="liste_ticket_date_etat" style="<?php if($ticket->getId_etat_doc() == 59) echo " color:red;"; ?>">
									<?php echo $ticket->getLib_etat_doc();?>
								</td>
							</tr>
						</table>
						<?php if($ticket_editable && ($ticket->getId_etat_doc() == 59 || $ticket->getId_etat_doc() == 61)) {?>
						<script type="text/javascript">
							Event.observe("ticket_a_charger_<?php echo $ticket->getRef_doc();?>", "click", function(evt){
								Event.stop(evt);
								if($("ref_ticket").value!=""){ //si un ticket est en "saisie", on le mets en "attente" avant de charger le suivant 
									var fonction_called_after_maj_etat_ticket = "script_called_after_maj_etat_61_from_afficher_ticket('<?php echo $ticket->getRef_doc();?>')";
									maj_etat_ticket($("ref_ticket").value, "61", fonction_called_after_maj_etat_ticket); // ID_ETAT_EN_ATTENTE = 61
								}else{
									caisse_reset("recherche_article");
									caisse_charger_ticket("<?php echo $ticket->getRef_doc();?>");
								}
							}, false);
		
							Event.observe("ticket_a_charger_suppr_<?php echo $ticket->getRef_doc();?>", "click", function(evt){
								Event.stop(evt);
								var fonction_called_after_maj_etat_ticket = "";
								if("<?php echo $ticket->getRef_doc();?>" == $("ref_ticket").value)
								{			fonction_called_after_maj_etat_ticket =  "script_called_after_maj_etat_60_from_afficher_ticket(true)";}
								else{	fonction_called_after_maj_etat_ticket =  "script_called_after_maj_etat_60_from_afficher_ticket(false)";}
								caisse_suppr_ticket("<?php echo $ticket->getRef_doc();?>", fonction_called_after_maj_etat_ticket);
							}, false);
						</script>
						<?php } ?>
					</td>
				<?php
					if($i > 0 && ($i % 6) == 5){echo "</tr><tr>";}
					$i++;
				}
				if($nb_tickets % 6 !=0){
					for($j=0; $j<(6-($nb_tickets % 6)); $j++){?>
						<td class="liste_ticket_cell_vide">&nbsp;</td>
					<?php 
					}
				}
				?>
			</tr>
			<?php if($nb_tickets <= 12){?>
			<tr>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
			</tr>
			<?php }
			if($nb_tickets <= 18){?>
			<tr>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
				<td class="liste_ticket_cell_vide">&nbsp;</td>
			</tr>
			<?php }?>
		</table>

</div>

<?php 
/*

<?php if($ticket->getNom_contact()!=""){echo $ticket->getNom_contact();}else{echo "&nbsp;";} ?>
<?php echo $ticket->getCode_postal_contact()."&nbsp;".$ticket->getVille_contact();?>


*/
?>
