<table class="minimizetable">
  <tr>
		<td>
			<form method="post" action="annuaire_edition_adresse_suppression.php" id="annu_edition_adresse_suppression<?php echo $caiu?>" name="annu_edition_adresse_suppression<?php echo $caiu?>" target="formFrame">
				<input type="hidden" name="ref_idform" value="<?php echo $caiu?>">
				<input type="hidden" name="<?php echo $adresse->getRef_adresse()?>" id="<?php echo $adresse->getRef_adresse()?>" value="<?php echo $caiu?>"/>
				<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
				<input id="adresse_ref<?php echo $caiu?>" name="adresse_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $adresse->getRef_adresse ()?>" />
			</form>
		</td>
	</tr><tr>
		<td>
		<form method="post" action="annuaire_edition_adresse.php" id="annu_editon_adresse<?php echo $caiu?>" name="annu_editon_adresse<?php echo $caiu?>" target="formFrame" style="display:none;">
			<input type="hidden" name="ref_idform" value="<?php echo $caiu?>">
			<input type="hidden" name="ref_contact<?php echo $caiu?>" value="<?php echo $contact->getRef_contact()?>">
			<input id="adresse_ref<?php echo $caiu?>" name="adresse_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $adresse->getRef_adresse ()?>" />
		<table class="infotable">
			<tr>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td class="size_strict">
				<span class="labelled">Titre:</span>
				</td>
				<td>
				<input id="adresse_lib<?php echo $caiu?>" name="adresse_lib<?php echo $caiu?>" type="text" class="classinput_xsize" value="<?php echo  htmlentities($adresse->getLib_adresse())?>" />
				</td>
			</tr>
			<?php if(!empty($GEST_TYPE_COORD)){ ?><tr>
				<td>
					<span class="labelled">Type :</span>
				</td><td>
					<select id="type_adresse<?php echo $caiu?>" name="type_adresse<?php echo $caiu?>" class="classinput_xsize" >
					<?php 
					global $bdd;
					$query = "SELECT id_adresse_type, adresse_type, defaut  FROM adresses_types";
					$retour = $bdd->query($query);
					while($res= $retour->fetchObject()){
						if($res->id_adresse_type == $adresse->getType()){
							echo "<option value='".$res->id_adresse_type."' selected='selected'>".$res->adresse_type."</option>";
						}else{
							echo "<option value='".$res->id_adresse_type."' >".$res->adresse_type."</option>";
						}
					}					
					?>
					</select>
				</td>
			</tr><?php } ?>
			<tr>
				<td>
				<span class="labelled">Adresse:</span></td><td>
				<textarea id="adresse_adresse<?php echo $caiu?>" name="adresse_adresse<?php echo $caiu?>" rows="2" class="classinput_xsize"/><?php echo htmlentities($adresse->getText_adresse())?></textarea>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Code Postal:</span></td><td>
				<input id="adresse_code<?php echo $caiu?>" name="adresse_code<?php echo $caiu?>" class="classinput_xsize" value="<?php echo  htmlentities($adresse->getCode_postal ())?>"/>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Ville:</span>
				</td>
				<td>
				<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
				<iframe id="iframe_choix_adresse_ville<?php echo $caiu?>" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville"></iframe>
				<div id="choix_adresse_ville<?php echo $caiu?>"  class="choix_complete_ville"></div></div>
				<input name="adresse_ville<?php echo $caiu?>" id="adresse_ville<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($adresse->getVille())?>"/>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Pays:</span></td><td>
				<select id="adresse_id_pays<?php echo $caiu?>"  name="adresse_id_pays<?php echo $caiu?>" class="classinput_xsize">
					<?php 
					$lepays="";
					$separe_listepays = 0;
					foreach ($listepays as $payslist){
						if ((!$separe_listepays) && (!$payslist->affichage)) { 
							$separe_listepays = 1; ?>
							<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
							<?php 		 
						}
						?>
						<option value="<?php echo $payslist->id_pays?>" <?php if ($adresse ->getId_pays() == $payslist->id_pays) {echo 'selected="selected"'; $lepays = htmlentities($payslist->pays);}?>>
						<?php echo htmlentities($payslist->pays)?></option>
						<?php 
					}
					?>
				</select>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Note:</span></td><td>
				<textarea id="adresse_note<?php echo $caiu?>" name="adresse_note<?php echo $caiu?>" rows="2"  class="classinput_xsize"/><?php echo htmlentities($adresse->getNote())?></textarea>
				</td>
			</tr>
			<tr>
				<td style="text-align:left;">
				<div> <a href="#" id="link_adresse_confirm_supp_<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_adresse_confirm_supp_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);alerte.confirm_supprimer('contact_adresse_supprime', 'annu_edition_adresse_suppression<?php echo $caiu?>');}, false);
				</script>
				</div>
				</td>
				<td style="text-align:right;">
				<input type="image" name="modifier<?php echo $caiu?>" id="modifier<?php echo $caiu?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
				</td>
			</tr>
		</table>
		</form> 



<table class="infotable" id="start_visible_<?php echo $caiu?>">
	<tr>
		<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td colspan="2">
		<div style="float:right; width:12px">
		<table cellspacing="0">
			<tr>
				<td>
					<div id="up_arrow_<?php echo $caiu?>">
					<?php
					if ($adresse->getOrdre()!=1) {
						?>
						<a href="annuaire_edition_adresse_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($adresse->getOrdre())-1 ?>&ordre_other=<?php echo ($adresse->getOrdre()) ?>" target="formFrame" name="modifier_adresse_ordre_up_<?php echo $adresse->getOrdre()?>" id="modifier_adresse_ordre_up_<?php echo $adresse->getOrdre()?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif"/></a>
						<?php
					} else {
						?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
						<?php
					}
					?>
					</div>
				</td>
			</tr>
			<tr>
				<td>
				<div id="down_arrow_<?php echo $caiu?>">
					<?php
					if ( getMax_ordre("adresses", $contact->getRef_contact())!=$adresse->getOrdre()) {
						?>
						<a href="annuaire_edition_adresse_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($adresse->getOrdre())+1 ?>&ordre_other=<?php echo ($adresse->getOrdre()) ?>" target="formFrame" name="modifier_adresse_ordre_down_<?php echo $adresse->getOrdre()?>" id="modifier_adresse_ordre_down_<?php echo $adresse->getOrdre()?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif"/></a>
					
						<?php
					} else {
						?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>							
						<?php
					}
					?>
				</div>
				</td>
			</tr>
		</table>
		</div>
		<?php if ($adresse->getLib_adresse()!="" || $adresse->getTypeLib()!="") {?><a href="#" id="link_show_lib_adresse_<?php echo $caiu?>" class="modif_input2"><strong><?php echo  htmlentities($adresse->getLib_adresse())?></strong><?php if($adresse->getTypeLib() != ""){ ?>&nbsp;(<?php echo  htmlentities($adresse->getTypeLib())?>)<?php }?></a>
		<script type="text/javascript">
		Event.observe("link_show_lib_adresse_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_adresse<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','adresse_lib<?php echo $caiu?>');}, false);
		</script>
		<?php }?>
		</td>
	</tr>
	<?php if ($adresse->getText_adresse()!="") {?>
	<tr>
		<td>
		<span class="labelled">Adresse:</span></td><td>
		<a href="#" id="link_show_adr_adresse_<?php echo $caiu?>" class="modif_input1"><?php echo  nl2br(htmlentities($adresse->getText_adresse()))?></a>
		<script type="text/javascript">
		Event.observe("link_show_adr_adresse_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_adresse<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','adresse_adresse<?php echo $caiu?>');}, false);
		</script>
		</td>
	</tr>
	<?php }?>
	<?php if ($adresse->getCode_postal()!="") {?>
	<tr>
		<td>
		<span class="labelled">Code Postal:</span></td><td>
		<a href="#" id="link_show_code_adresse_<?php echo $caiu?>" class="modif_input1"><?php echo  htmlentities($adresse->getCode_postal())?></a>
		<script type="text/javascript">
		Event.observe("link_show_code_adresse_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_adresse<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','adresse_code<?php echo $caiu?>');}, false);
		</script>
		</td>
	</tr>
	<?php }?>
	<?php if ($adresse->getVille()!="") {?>
	<tr>
		<td>
		<span class="labelled">Ville:</span></td><td>
		<a href="#" id="link_show_ville_adresse_<?php echo $caiu?>" class="modif_select1"><?php echo  htmlentities($adresse->getVille())?></a>
		<script type="text/javascript">
		Event.observe("link_show_ville_adresse_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_adresse<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','adresse_ville<?php echo $caiu?>');}, false);
		</script>
		</td>
	</tr>
	<?php }?>
	<?php if ($lepays!="") {?>
	<tr>
		<td>
		<span class="labelled">Pays:</span></td><td>
		<a href="#" id="link_show_pays_adresse_<?php echo $caiu?>" class="modif_select1"><?php echo $lepays;?></a>
		<script type="text/javascript">
		Event.observe("link_show_pays_adresse_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_adresse<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','adresse_id_pays<?php echo $caiu?>');}, false);
		</script>
		</td>
		</tr>
	<?php }?>
	<?php if ($adresse->getNote()!="") {?>
	<tr>
		<td>
		<span class="labelled">Note:</span>
		</td>
		<td>
		<a href="#" id="link_show_note_adresse_<?php echo $caiu?>" class="modif_textarea3"><?php echo  nl2br(htmlentities($adresse->getNote()))?></a>
		<script type="text/javascript">
		Event.observe("link_show_note_adresse_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_adresse<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','adresse_note<?php echo $caiu?>');}, false);
		</script>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td  colspan="2" style="text-align:right;">
		<span style="float:left"> <a href="#" id="link_contact_adresse_supprime_<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
		<script type="text/javascript">
		Event.observe("link_contact_adresse_supprime_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);alerte.confirm_supprimer('contact_adresse_supprime', 'annu_edition_adresse_suppression<?php echo $caiu?>');}, false);
		</script>
		</span>

				<?php
				// Flag permettant de vérifier si les données sont renseignées ( vérification simple )
                $isAdresseValide = $adresse->getVille()!= "" && $lepays!="" && $adresse->getCode_postal() && $adresse->getText_adresse()!="";
                
                if ($VIEW_BT_ITI && $isAdresseValide) { ?>
				<img id="itineraire_<?php echo $caiu?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-itineraire.gif" style="cursor:pointer"/>
						
				<script type="text/javascript">
				Event.observe("itineraire_<?php echo $caiu?>", "click",  function(evt){
					Event.stop(evt);
					window.open("annuaire_itineraire.php?ref_adresse=<?php echo $adresse->getRef_adresse ();?>","_blank" );
					}, false);
				</script>
				<?php } ?>
				
				<?php if ($VIEW_BT_MAP && $isAdresseValide) { ?>
				<img id="plan_<?php echo $caiu?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-plan.gif" style="cursor:pointer" />
				
				<script type="text/javascript">
				Event.observe("plan_<?php echo $caiu?>", "click",  function(evt){
					Event.stop(evt);
					window.open("annuaire_carte.php?ref_adresse=<?php echo $adresse->getRef_adresse ();?>","_blank" );
					}, false);
				</script>
				<?php } ?>
		
		<a href="#" id="link_show_annu_editon_adresse_<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" /></a>
		<script type="text/javascript">
		Event.observe("link_show_annu_editon_adresse_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_adresse<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','adresse_lib<?php echo $caiu?>');}, false);
		</script>
		</td>
	</tr>
</table>



<script type="text/javascript" language="javascript">

new Form.EventObserver('annu_editon_adresse<?php echo $caiu?>', function(element, value){formChanged();});

Event.observe('adresse_ville<?php echo $caiu?>', 'focus',  function(evt){start_commune("adresse_code<?php echo $caiu?>", "adresse_ville<?php echo $caiu?>", "choix_adresse_ville<?php echo $caiu?>", "iframe_choix_adresse_ville<?php echo $caiu?>", "liste_ville.php?cp=");}, false);
	
Event.observe('adresse_id_pays<?php echo $caiu?>', 'focus',  function(){delay_close("choix_adresse_ville<?php echo $caiu?>", "iframe_choix_adresse_ville<?php echo $caiu?>");}, false);	

//on masque le chargement
H_loading();

</script>
</td></tr></table>
