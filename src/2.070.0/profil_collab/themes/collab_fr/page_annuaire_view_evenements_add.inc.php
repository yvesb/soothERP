<?php

// *************************************************************************************************************
// AJOUT D'UN RELEVE
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

<p  style="font-weight:bolder">Ajouter un événement pour <?php echo $contact->getNom();?></p>
<div class="emarge">
	<table class="minimizetable" style="width:100%">
		<tr>
			<td>
			<form action="annuaire_view_evenements_add_valid.php" method="post" id="annuaire_view_evenements_add_valid" name="annuaire_view_evenements_add_valid" target="formFrame" >
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
							<option value="<?php echo $type_event->id_comm_event_type;?>"><?php echo $type_event->lib_comm_event_type;?></option>
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
						<input type="text" id="date_event" name="date_event" value="<?php echo date("d-m-Y");?>" class="classinput_nsize" /> jj-mm-aaaa
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Heure:
					</td>
					<td>
					<input type="text" id="heure_event" name="heure_event" value="" class="classinput_nsize" />
					 hh:mn
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Durée:
					</td>
					<td>
					<input type="text" id="duree_event" name="duree_event" value="" class="classinput_nsize" />
					 hh:mn
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Utilisateur:
					</td>
					<td>
					<input type="hidden" id="ref_user" name="ref_user" value="<?php echo $_SESSION['user']->getRef_user();?>" class="classinput_xsize" /><?php echo $_SESSION['user']->getPseudo();?>
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					Texte:
					</td>
					<td colspan="2">
					<textarea  id="texte" name="texte" class="classinput_xsize" rows="4" ></textarea>
					</td>
				</tr>
				<tr>
					<td>
					Rappel:
					</td>
					<td>
					<input type="text" id="date_rappel" name="date_rappel" value="" class="classinput_nsize" />
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
						<input name="add_evenements_add_valid" id="add_evenements_add_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-enregistrer.gif" />
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
</div>
<SCRIPT type="text/javascript">


//on masque le chargement
H_loading();
</SCRIPT>