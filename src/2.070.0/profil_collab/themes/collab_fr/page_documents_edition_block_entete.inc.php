<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<div style="width:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="document_box">
		<td valign="top" style="width:48%">
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
				<tr style=" line-height:24px; height:24px;">
					<td style="width:150px; padding-left:3px;">
						<input type="hidden" value="<?php echo $document->getRef_doc();?>" id="ref_doc" name="ref_doc"/>
						<input type="hidden" value="<?php echo $document->getID_TYPE_DOC();?>" id="id_type_doc" name="id_type_doc"/>
						<input type="hidden" value="<?php echo $document->getApp_tarifs();?>" id="app_tarifs" name="app_tarifs"/>			
						Date de cr&eacute;ation:					</td>
					<td style="width:250px;">
						<?php 
						if ($document->getDate_creation ()!= 0000-00-00) {
							echo htmlentities ( date_Us_to_Fr ($document->getDate_creation()));
							echo htmlentities ( getTime_from_date($document->getDate_creation()));
						}
						?>					</td>
					<td>					</td>
				</tr>
				<tr style=" line-height:24px; height:24px;">
					<td style="width:150px; padding-left:3px;">
						&Eacute;tat:					</td>
					<td style="width:250px;">
						<?php echo htmlentities($document->getLib_etat_doc());?>					</td>
					<td>					</td>
				</tr>
			</table>
		</td>
		<td style="width:4%">&nbsp;
			
		</td>
		<td valign="top" style="width:48%">
		<!--block specifique à l'entete-->
		<!--Pour le document devis client -->
			<?php
			if ($document->getID_TYPE_DOC() == $DEVIS_CLIENT_ID_TYPE_DOC) {
			 ?>
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
				<tr>
				<td style="width:50%;">
				<table cellpadding="0" cellspacing="0" border="0" style="width:400px;">
					<tr style=" line-height:24px; height:24px;">
						<td style="width:150px;">
							Date livraison: 
						</td>
						<td style="width:250px;">
							<input type="text" value="<?php 
								if ($document->getDate_livraison ()!=0000-00-00) {
									echo date_Us_to_Fr ($document->getDate_livraison ());
								}?>" id="date_livraison" name="date_livraison"/> 
								
							<input type="hidden" value="<?php 
								if ($document->getDate_livraison ()!=0000-00-00) {
									echo date_Us_to_Fr ($document->getDate_livraison ());
								}?>" id="date_livraison_old" name="date_livraison_old"/>
						</td>
					</tr>
					<tr style=" line-height:24px; height:24px;">
						<td>
							Date &eacute;ch&eacute;ance: 
						</td>
						<td>
							<input type="text" value="<?php 
								if ($document->getDate_echeance ()!=0000-00-00) {
									echo date_Us_to_Fr ($document->getDate_echeance ());
								}?>" id="date_echeance" name="date_echeance"/> 
								
							<input type="hidden" value="<?php 
								if ($document->getDate_echeance ()!=0000-00-00) {
									echo date_Us_to_Fr ($document->getDate_echeance ());
								}?>" id="date_echeance_old" name="date_echeance_old"/>
						</td>
					</tr>
				</table>
				</td>
				<td>
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
					<tr>
						<td style="text-align:right; padding-right:3px;">
						<?php 
						if ($document->getId_etat_doc () != 2) {
							?><a href="#" id="annuler_devis" class="doc_link_standard"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" alt="Annuler Le Devis" title="Annuler Le Devis" style="float:right"/>Annuler 
							</a>
						<?php 
						} else {
							?><a href="#" id="reactiver_devis" class="doc_link_standard"> R&eacute;activer
							&nbsp;&nbsp;</a>
						<?php 
						}
						?>
						<div style="height:3px; line-height:3px;"></div>
						<?php 
						if ($document->getId_etat_doc () == 1) {
							?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_pret.gif" id="devis_pret" style="cursor:pointer"/>
						<div style="height:3px; line-height:3px;"></div>
						<?php 
						}
						?>
						<?php 
						if ($document->getId_etat_doc () == 1 || $document->getId_etat_doc () == 3) {
							?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_accepte.gif" id="devis_accepte" style="cursor:pointer"/>
						<div style="height:3px; line-height:3px;"></div>
						<?php 
						}
						?>
						<?php 
						if ($document->getId_etat_doc () == 1 || $document->getId_etat_doc () == 3) {
							?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_refuse.gif" id="devis_refuse" style="cursor:pointer"/>
						<div style="height:3px; line-height:3px;"></div>
						<?php 
						}
						?>
						</td>
					</tr>
				</table>
				</td>
				</tr>
				</table>
				<?php 
			}
			?>
			<!-- pour le document Commande Client CDC-->
			<?php
			if ($document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC) {
			 ?>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
				<tr>
				<td style="width:50%;">
				<table cellpadding="0" cellspacing="0" border="0" style="width:400px;">
					<tr style=" line-height:24px; height:24px;">
						<td style="width:150px;">
							Date livraison: 
						</td>
						<td style="width:250px;">
							<input type="text" value="<?php 
								if ($document->getDate_livraison ()!=0000-00-00) {
									echo date_Us_to_Fr ($document->getDate_livraison ());
								}?>" id="date_livraison" name="date_livraison"/> 								
							<input type="hidden" value="<?php 
								if ($document->getDate_livraison ()!=0000-00-00) {
									echo date_Us_to_Fr ($document->getDate_livraison ());
								}?>" id="date_livraison_old" name="date_livraison_old"/>
						</td>
					</tr>
					<tr style=" line-height:24px; height:24px;">
						<td>
						R&eacute;f&eacute;rence externe : 
						</td>
						<td>
							<input type="text" value="<?php echo htmlentities($document->getRef_doc_externe ());?>" id="ref_doc_externe" name="ref_doc_externe"/>
								
							<input type="hidden" value="<?php echo htmlentities($document->getRef_doc_externe ());?>" id="ref_doc_externe_old" name="ref_doc_externe_old"/>
						</td>
					</tr>
				</table>
				</td>
				<td>
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
					<tr>
						<td style="text-align:right; padding-right:3px">
						<?php 
						if ($document->getId_etat_doc () != 7) {
							?><a href="#" id="annuler_commande" class="doc_link_standard"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" alt="Annuler la commande" title="Annuler la commande" style="float:right"/> Annuler</a>
						<?php 
						} else {
							?><a href="#" id="reactiver_commande" class="doc_link_standard"> R&eacute;activer&nbsp;&nbsp;</a>
						<?php 
						}
						?>
						<div style="height:3px;line-height:3px;" ></div>
						<?php 
						if ($document->getId_etat_doc () == 6) {
							?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_pret.gif" id="commande_pret" style="cursor:pointer"/>
						<div style="height:3px;line-height:3px;" ></div>
						<?php 
						}
						?>
						<?php 
						if ($document->getId_etat_doc () == 6 || $document->getId_etat_doc () == 9) {
							?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_traite.gif" id="commande_traite" style="cursor:pointer"/>
						<div style="height:3px; line-height:3px;"></div>
						<?php 
						}
						?>
						</td>
					</tr>
				</table>
				</td>
				</tr>
				</table>
				<?php 
			}
			?>
		</td>
	</tr>
</table>


<script type="text/javascript">
		

<?php
// gestion des évenements pour un document type devis client

if ($document->getID_TYPE_DOC() == $DEVIS_CLIENT_ID_TYPE_DOC) {
 ?>
	// observateurde changement de texte dans l'entete du doc pour mise à jour des infos
	Event.observe("date_echeance", "blur", function(evt){
		if ($("date_echeance").value != $("date_echeance_old").value) { datemask (evt); $("date_echeance_old").value = $("date_echeance").value; maj_date_echeance ("date_echeance");  } }, false);
		
	Event.observe("date_livraison", "blur", function(evt){ if ($("date_livraison").value != $("date_livraison_old").value) { datemask (evt); $("date_livraison_old").value = $("date_livraison").value; maj_date_livraison ("date_livraison");  } }, false);
	
	<?php 
	if ($document->getId_etat_doc () != 2) {
		?>
		//devis annul
		Event.observe("annuler_devis", "click", function(evt){Event.stop(evt); maj_etat_doc (2); }, false);
	<?php 
	} else {
		?>
		//devis reactiv
		Event.observe("reactiver_devis", "click", function(evt){Event.stop(evt); maj_etat_doc (1); }, false);
	<?php 
	}
	?>
	<?php 
	if ($document->getId_etat_doc () == 1) {
		?>
		//devis pret
		Event.observe("devis_pret", "click", function(evt){Event.stop(evt); maj_etat_doc (3); }, false);
	<?php 
	}
	?>
	<?php 
	if ($document->getId_etat_doc () == 1 || $document->getId_etat_doc () == 3) {
		?>
		//devis accept
		Event.observe("devis_accepte", "click", function(evt){maj_etat_open_doc (4)}, false);
	<?php 
	}
	?>
	<?php 
	if ($document->getId_etat_doc () == 1 || $document->getId_etat_doc () == 3) {
		?>
		//devis refuse
		Event.observe("devis_refuse", "click", function(evt){Event.stop(evt); maj_etat_doc (5); }, false);
	<?php 
	}
	?>
	<?php 
}
?>

<?php
// gestion des évenements pour un document type commande client

if ($document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC) {
 ?>
	// observateurde changement de texte dans l'entete du doc pour mise à jour des infos
	Event.observe("ref_doc_externe", "blur", function(evt){
		if ($("ref_doc_externe").value != $("ref_doc_externe_old").value) { $("ref_doc_externe_old").value = $("ref_doc_externe").value; maj_ref_doc_externe ("ref_doc_externe");  } }, false);
		
	Event.observe("date_livraison", "blur", function(evt){ if ($("date_livraison").value != $("date_livraison_old").value) { datemask (evt); $("date_livraison_old").value = $("date_livraison").value; maj_date_livraison ("date_livraison");  } }, false);
	
	<?php 
	if ($document->getId_etat_doc () != 7) {
		?>
		//devis annul
		Event.observe("annuler_commande", "click", function(evt){Event.stop(evt); maj_etat_doc (7); }, false);
	<?php 
	} else {
		?>
		//devis reactiv
		Event.observe("reactiver_commande", "click", function(evt){Event.stop(evt); maj_etat_doc (6); }, false);
	<?php 
	}
	?>
	<?php 
	if ($document->getId_etat_doc () == 6) {
		?>
		//devis pret
		Event.observe("commande_pret", "click", function(evt){Event.stop(evt); maj_etat_doc (9); }, false);
	<?php 
	}
	?>
	<?php 
	if ($document->getId_etat_doc () == 6 || $document->getId_etat_doc () == 9) {
		?>
		//devis refuse
		Event.observe("commande_traite", "click", function(evt){Event.stop(evt); maj_etat_doc (10); }, false);
	<?php 
	}
	?>
	<?php 
}
?>


//on masque le chargement
H_loading();

</script>
</div>