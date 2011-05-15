<?php
// *************************************************************************************************************
// CHARGEMENTS DES PIECES JOINTES D'UN OBJET
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ("contact", "liaisons_type_liste");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">


</script>
<p class="sous_titre1">Relations entre contacts </p>
<div style=" text-align:left; padding:0 20px">
	<div id="liaison_info_under" style="margin-left:5%; margin-right:5%;">
		<input type="hidden" name="serialisation_liaison" id="serialisation_liaison" value="0" />
		<?php foreach ($liaisons_type_liste as $liaison_type) {
				$liaisons_vers_autres_contacts 		= $liaison_type->getContact_liaisons_vers_autres_contacts	 ($contact->getRef_contact());
				$liaisons_depuis_autres_contacts 	= $liaison_type->getContact_liaisons_depuis_autres_contacts($contact->getRef_contact()); ?>
		<div id="ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_vers" style="width:100%; display:none;">
			<div class="liaison_type_title">
				<?php echo htmlentities(str_replace("%LIB_CONTACT%", $contact->getNom(), $liaison_type->getLib_liaison_type_vers())); ?>
			</div>
			<div style="width:100%;">
				<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_vers" class="liste_liaison"></ul>
			</div>
		</div>
		<script type="text/javascript">
		<?php foreach($liaisons_vers_autres_contacts as $contact_liaisons) {
					//$contact_liaisons[n]['contact'];
					//$contact_liaisons[n]['contact_lie'];
					//$contact_liaisons[n]['id_liaison_type']; ?>
					construire_ligne_liaison_contact_view(parseInt($("serialisation_liaison").value), "vers", "<?php echo $contact_liaisons["contact"]->getRef_contact();?>", "<?php echo $contact_liaisons["contact_lie"]->getRef_contact();?>", <?php echo $liaison_type->getId_liaison_type(); ?>, "<?php echo $contact_liaisons["contact_lie"]->getNom();?>");
		<?php }?>
		</script>
		<br/>
		<div id="ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" style="width:100%; display:none;">
			<div class="liaison_type_title">
				<?php echo htmlentities(str_replace("%LIB_CONTACT%", $contact->getNom(), $liaison_type->getLib_liaison_type_depuis())); ?>
			</div>
			<div style="width:100%;">
				<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" class="liste_liaison"></ul>
			</div>
		</div>
		<script type="text/javascript">
			<?php foreach($liaisons_depuis_autres_contacts as $contact_liaisons) {
				//$contact_liaisons[n]['contact'];
				//$contact_liaisons[n]['contact_lie'];
				//$contact_liaisons[n]['id_liaison_type']; ?>
				construire_ligne_liaison_contact_view(parseInt($("serialisation_liaison").value), "depuis", "<?php echo $contact_liaisons["contact_lie"]->getRef_contact();?>", "<?php echo $contact_liaisons["contact"]->getRef_contact();?>", <?php echo $liaison_type->getId_liaison_type(); ?>, "<?php echo $contact_liaisons["contact"]->getNom();?>");
				<?php }?>
		</script>
		<br/>
	<?php } ?>
	
		<br />
	
		<div style="background-color:white;" align="right">
			<table>
				<tr>
					<td align="right">Ajouter une relation de type&nbsp;</td>
					<td width="200px">
						<select id="nouvelle_liaison_type_vers_selected" name="nouvelle_liaison_type_vers_selected" class="classinput_lsize" style="width:100%;">
						<?php foreach ($liaisons_type_liste as $liaison_type){?>
							<option value="<?php echo $liaison_type->getId_liaison_type(); ?>">
								<?php echo $liaison_type->getLib_liaison_type(); ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td width="50px;" style="font-weight:bolder; text-align:center;">&nbsp;vers&nbsp;</td>
					<td>
						<input id="nouvelle_liaison_nom_contact_lie" name="nouvelle_liaison_nom_contact_lie" type="text" value="" class="classinput_lsize" style="width:200px;" disabled="disabled"/>
						<input id="nouvelle_liaison_ref_contact_lie" name="nouvelle_liaison_ref_contact_lie" type="hidden" value="" class=""/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_set_contact.gif" id="nouvelle_liaison_vers_show_mini_moteur_contacts" alt="Choisir le contact" title="Choisir le contact" style="cursor:pointer"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_vers_reset" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td width="100px" align="right">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" id="nouvelle_liaison_vers_valider" alt="Ajouter" title="Ajouter" style="cursor:pointer"/>
						<script type="text/javascript">
							Event.observe("nouvelle_liaison_vers_reset", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_nom_contact_lie").value = "";
								$("nouvelle_liaison_ref_contact_lie").value = "";
								$("nouvelle_liaison_type_vers_selected").selectedIndex = 0;
							}, false);
						
							Event.observe("nouvelle_liaison_vers_show_mini_moteur_contacts", "click",  function(evt){
								Event.stop(evt);
								show_mini_moteur_contacts ("recherche_client_set_contact", "\'nouvelle_liaison_ref_contact_lie\', \'nouvelle_liaison_nom_contact_lie\' ");
								page.annuaire_recherche_mini();
							}, false);
							
							Event.observe("nouvelle_liaison_vers_valider", "click",  function(evt){
								Event.stop(evt);
								if($("nouvelle_liaison_ref_contact_lie").value != "" && $("nouvelle_liaison_nom_contact_lie").value != ""){
									link_contact_to_contact_view_vers(parseInt($("serialisation_liaison").value), $("nouvelle_liaison_type_vers_selected").options[$("nouvelle_liaison_type_vers_selected").selectedIndex].value,
																				 "<?php echo $contact->getRef_contact();?>", $("nouvelle_liaison_ref_contact_lie").value, $("nouvelle_liaison_nom_contact_lie").value);
									$("nouvelle_liaison_nom_contact_lie").value = "";
									$("nouvelle_liaison_ref_contact_lie").value = "";
									$("nouvelle_liaison_type_vers_selected").selectedIndex = 0;
								}
							}, false);
						</script>
					</td>
				</tr>
			</table>
		</div>
	
		<br />
	
		<div style="background-color:white;" align="right">
			<table>
				<tr>
					<td align="right">Ajouter une relation de type&nbsp;</td>
					<td width="200px">
						<select id="nouvelle_liaison_type_depuis_selected" name="nouvelle_liaison_type_depuis_selected" class="classinput_lsize" style="width:100%;">
						<?php foreach ($liaisons_type_liste as $liaison_type){?>
							<option value="<?php echo $liaison_type->getId_liaison_type(); ?>">
								<?php echo $liaison_type->getLib_liaison_type(); ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td width="50px;" style="font-weight:bolder; text-align:center;">&nbsp;depuis&nbsp;</td>
					<td>
						<input id="nouvelle_liaison_nom_contact" name="nouvelle_liaison_nom_contact" type="text" value="" class="classinput_lsize" style="width:200px;" disabled="disabled"/>
						<input id="nouvelle_liaison_ref_contact" name="nouvelle_liaison_ref_contact" type="hidden" value="" class=""/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_set_contact.gif" id="nouvelle_liaison_depuis_show_mini_moteur_contacts" alt="Choisir le contact" title="Choisir le contact" style="cursor:pointer"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_depuis_reset" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td width="100px" align="right">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" id="nouvelle_liaison_depuis_valider" alt="Ajouter" title="Ajouter" style="cursor:pointer"/>
						<script type="text/javascript">
							Event.observe("nouvelle_liaison_depuis_reset", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_nom_contact").value = "";
								$("nouvelle_liaison_ref_contact").value = "";
								$("nouvelle_liaison_type_depuis_selected").selectedIndex = 0;
							}, false);
						
							Event.observe("nouvelle_liaison_depuis_show_mini_moteur_contacts", "click",  function(evt){
								Event.stop(evt);
								show_mini_moteur_contacts ("recherche_client_set_contact", "\'nouvelle_liaison_ref_contact\', \'nouvelle_liaison_nom_contact\' ");
								page.annuaire_recherche_mini();
							}, false);
							
							Event.observe("nouvelle_liaison_depuis_valider", "click",  function(evt){
								Event.stop(evt);
								if($("nouvelle_liaison_ref_contact").value != "" && $("nouvelle_liaison_nom_contact").value != ""){
									link_contact_to_contact_view_depuis(parseInt($("serialisation_liaison").value), $("nouvelle_liaison_type_depuis_selected").options[$("nouvelle_liaison_type_depuis_selected").selectedIndex].value,
																				 "<?php echo $contact->getRef_contact();?>", $("nouvelle_liaison_ref_contact").value, $("nouvelle_liaison_nom_contact").value);
									$("nouvelle_liaison_nom_contact").value = "";
									$("nouvelle_liaison_ref_contact").value = "";
									$("nouvelle_liaison_type_depuis_selected").selectedIndex = 0;
								}
							}, false);
						</script>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>