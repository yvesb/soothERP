<div style="height:50px;">
<table class="minimizetable" cellspacing="0">
	<tr>
		<td class="contactview_corps">
		<br/>
		<p>
		<b><font color="#AA0000">Cette fonctionnalité est dépréciée car elle sera remplacée par l'agenda intégré de Lundi Matin Business qui est en cours de finalisation (Beta).</font></b>
		</p>
		<p class="sous_titre1">Liste des événements</p>
		<br />
		<div style="border-bottom:1px solid #999999">
		<table class="main_table">
			<tr>
				<td style="width:140px; text-align:center; font-weight:bolder;">Date</td>
				<td style="width:140px; text-align:center; font-weight:bolder;">Heure</td>
				<td style="width:140px; text-align:center; font-weight:bolder;">Durée</td>
				<td style=" font-weight:bolder;">Utilisateur</td>
				<td style="width:200px; font-weight:bolder;">Type</td>
				<td style="width:140px; text-align:center; font-weight:bolder;">Rappel</td>
				<td style="width:10px">&nbsp;</td>
			</tr>
		</table>
		</div>
		<div id="contactview_event_liste"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; height:50px ">
		<?php 
		if (!count($evenements)) {
			?> Aucun événement enregistré.
			<?php
		} else {
			$colorise=0;
			foreach ($evenements as $evenement) {
			
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
				?>
				<div style="border-bottom:1px solid #999999;"  class="<?php  echo  $class_colorise?>">
				<table style="width:100%">
				<tr>
				<td>
				<div id="open_event_<?php echo $evenement->id_comm_event;?>"  style="cursor:pointer">
				<table class="main_table" style="width:100%">
					<tr>
						<td style="width:140px; text-align:center;"><?php echo date_Us_to_Fr($evenement->date_event);?></td>
						<td style="width:140px; text-align:center;"><?php echo getTime_from_date($evenement->date_event);?></td>
						<td style="width:140px; text-align:center;"><?php echo substr($evenement->duree_event,0,5);?></td>
						<td><?php echo ($evenement->pseudo);?></td>
						<td style="width:200px;"><?php echo ($evenement->lib_comm_event_type);?></td>
					
					</tr>
					<tr>
						<td colspan="5">
						<?php echo nl2br($evenement->texte);?>
						</td>
					</tr>
				</table>
				</div>
				</td>
				<td style="width:140px; text-align:center;">
				<?php if ($evenement->date_rappel != "0000-00-00 00:00:00" && (strtotime(date("Y-m-d H:i:s")) > strtotime($evenement->date_rappel)) ) {?>
				
				<span class="common_link" id="id_comm_event_contact_fin_<?php echo $evenement->id_comm_event; ?>">[fin de rappel]</span>
				<script type="text/javascript">
				Event.observe("id_comm_event_contact_fin_<?php echo $evenement->id_comm_event; ?>", "click",  function(evt){
					Event.stop(evt); 
					
					var AppelAjax = new Ajax.Request(
													"annuaire_view_evenements_fin.php", 
													{
													parameters: {ref_contact: "<?php echo $contact->getRef_contact();?>", id_comm_event: "<?php echo $evenement->id_comm_event;?>"}
													}
													);
													
					$("id_comm_event_contact_fin_<?php echo $evenement->id_comm_event; ?>").style.display = "none";
				}, false);
				</script>
				<?php }?>
				</td>
				<td style="width:10px; text-align:center;">
				
				<a href="#" id="id_comm_event_contact_sup_<?php echo $evenement->id_comm_event; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("id_comm_event_contact_sup_<?php echo $evenement->id_comm_event; ?>", "click",  function(evt){
					Event.stop(evt); 
					
					$("titre_alert").innerHTML = 'Confirmer';
					$("texte_alert").innerHTML = 'Confirmer la supression de cet événement';
					$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
					
					$("alert_pop_up_tab").style.display = "block";
					$("framealert").style.display = "block";
					$("alert_pop_up").style.display = "block";
					
					$("bouton0").onclick= function () {
					$("framealert").style.display = "none";
					$("alert_pop_up").style.display = "none";
					$("alert_pop_up_tab").style.display = "none";
					page.verify("annuaire_view_evenements_sup","annuaire_view_evenements_sup.php?ref_contact=<?php echo $contact->getRef_contact();?>&id_comm_event=<?php echo $evenement->id_comm_event;?>", "true", "formFrame");
					}
					
					$("bouton1").onclick= function () {
					$("framealert").style.display = "none";
					$("alert_pop_up").style.display = "none";
					$("alert_pop_up_tab").style.display = "none";
					} 
				}, false);
				</script>
				</td>
				</tr>
				</table>
				<script type="text/javascript">
				
				Event.observe("open_event_<?php echo $evenement->id_comm_event;?>", "click", function(evt) {
					Event.stop(evt);
	page.verify("annuaire_view_evenements_mod","annuaire_view_evenements_mod.php?ref_contact=<?php echo $contact->getRef_contact();?>&id_comm_event=<?php echo $evenement->id_comm_event;?>", "true", "edition_event");
					$("edition_event").show();
				 }, false);
				</script>
				</div>
				<?php 
			}
		}
		?>
		</div>

		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_new_event.gif" style="cursor:pointer; float:right" id="new_event" />
		</td>
	</tr>
</table>
<script type="text/javascript" language="javascript">

Event.observe("new_event", "click", function(evt) {
	Event.stop(evt);
	page.verify("annuaire_view_evenements_add","annuaire_view_evenements_add.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "edition_event");
	$("edition_event").show();
 }, false);


Event.observe(window, "resize", function() {
	set_tomax_height('contactview_event_liste' , -86);
set_tomax_height('contactview_evenements' , -46); 
	centrage_element("edition_event");
 }, false);

set_tomax_height('contactview_evenements' , -46); 
set_tomax_height('contactview_event_liste' , -86);
centrage_element("edition_event");



<?php
if (isset($_REQUEST["id_comm_event"])) {
	?>
	page.verify("annuaire_view_evenements_mod","annuaire_view_evenements_mod.php?ref_contact=<?php echo $contact->getRef_contact();?>&id_comm_event=<?php echo $_REQUEST["id_comm_event"];?>", "true", "edition_event");
	$("edition_event").show();
	<?php
}
?>

//on masque le chargement
H_loading();

</script>
</div>