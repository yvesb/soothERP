<?php

// *************************************************************************************************************
// MODIFICATION D'UN EVENEMENT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_edit_evt" style="cursor:pointer; float:right"/>
<script type="text/javascript">
Event.observe('close_edit_evt', 'click',  function(evt){
Event.stop(evt); 
$("edition_event").hide();
}, false);
</script>

<p  style="font-weight:bolder">Modifier un événement pour <?php echo $contact->getNom();?></p>
<div class="emarge">
<?php if (!$evenement) {?>
Aucun événement correspondant.
<?php } else {?>
	<table class="minimizetable" style="width:100%">
		<tr>
			<td>
			<form action="annuaire_view_evenements_mod_valid.php" method="post" id="annuaire_view_evenements_mod_valid" name="annuaire_view_evenements_mod_valid" target="formFrame" >
			<table style="width:100%">
				<tr>
					<td style="width:20%">
					Type:
					</td>
					<td>
					<select id="id_comm_event_type" name="id_comm_event_type" class="classinput_xsize">
						<?php 
						foreach ($liste_types_evenements as $type_event) {
							?>
							<option value="<?php echo $type_event->id_comm_event_type;?>" <?php if ($type_event->id_comm_event_type == $evenement->id_comm_event_type) { echo 'selected="selected"';}?>><?php echo $type_event->lib_comm_event_type;?></option>
							<?php 
						}
						?>
					</select>
					</td>
					<td>&nbsp;
					</td>
				</tr>
				<tr>
					<td>
					Date:
					</td>
					<td>
						<input type="text" id="date_event" name="date_event" value="<?php echo Date_Us_to_Fr($evenement->date_event);?>" class="classinput_nsize" /> jj-mm-aaaa
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Heure:
					</td>
					<td>
					<input type="text" id="heure_event" name="heure_event" value="<?php echo getTime_from_date($evenement->date_event);?>" class="classinput_nsize" /> hh:mn
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Durée:
					</td>
					<td>
					<input type="text" id="duree_event" name="duree_event" value="<?php echo substr($evenement->duree_event,0,5);?>" class="classinput_nsize" /> hh:mn
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Utilisateur:
					</td>
					<td>
					<input type="hidden" id="ref_user" name="ref_user" value="<?php echo ($evenement->ref_user);?>" class="classinput_xsize" /><?php echo ($evenement->pseudo);?>
					<input type="hidden" id="id_comm_event" name="id_comm_event" value="<?php echo ($evenement->id_comm_event);?>" class="classinput_xsize" />
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Texte:
					</td>
					<td colspan="2">
					<textarea  id="texte" name="texte" class="classinput_xsize" rows="4" ><?php echo ($evenement->texte);?></textarea>
					</td>
				</tr>
				<tr>
					<td>
					Rappel:
					</td>
					<td>
					<input type="text" id="date_rappel" name="date_rappel" value="<?php if ($evenement->date_rappel != "0000-00-00 00:00:00") { echo Date_Us_to_Fr($evenement->date_rappel);?> <?php echo getTime_from_date($evenement->date_rappel);}?>" class="classinput_nsize" />
					 jj-mm-aaaa hh:mn
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
					</td>
					<td>
						<div style="text-align:right">
						<input name="mod_evenements_mod_valid" id="mod_evenements_mod_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
						</div>
					</td>
				</tr>
			</table>
			<input type="hidden" id="ref_contact_event" name="ref_contact_event" value="<?php echo $contact->getRef_contact();?>" />
			</form>
			<SCRIPT type="text/javascript">
			Event.observe("date_event", "blur", datemask, false);
			Event.observe("heure_event", "blur", timemask, false);
			Event.observe("duree_event", "blur", timemask, false);
			Event.observe("date_rappel", "blur", datetimemask, false);
			</SCRIPT>
			
			</td>
		</tr>
	</table>
<?php } ?>
</div>
<SCRIPT type="text/javascript">


//on masque le chargement
H_loading();
</SCRIPT>