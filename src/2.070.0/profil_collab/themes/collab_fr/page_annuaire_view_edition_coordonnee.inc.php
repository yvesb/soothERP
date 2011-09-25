<table class="minimizetable">
	<tr>
		<td>
		<form method="post" action="annuaire_edition_coordonnee_suppression.php" id="annu_edition_coordonnee_suppression<?php echo $caiu?>" name="annu_edition_coordonnee_suppression<?php echo $caiu?>" target="formFrame">
			<input type="hidden" name="ref_idform" value="<?php echo $caiu?>"/>
			<input type="hidden" name="<?php echo $coordonnee->getRef_coord()?>" id="<?php echo $coordonnee->getRef_coord()?>" value="<?php echo $caiu?>"/>
			<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
			<input id="coordonnee_ref<?php echo $caiu?>" name="coordonnee_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $coordonnee->getRef_coord ()?>" />
		</form>
		</td>
	</tr><tr>
		<td>	
			
			
		<form method="post" action="annuaire_edition_coordonnee.php" id="annu_editon_coordonnee<?php echo $caiu?>" name="annu_editon_coordonnee<?php echo $caiu?>" target="formFrame" style="display:none;">
			<input type="hidden" name="ref_idform" value="<?php echo $caiu?>"/>
			<input type="hidden" name="ref_contact<?php echo $caiu?>" value="<?php echo $contact->getRef_contact()?>"/>
			<input id="coordonnee_ref<?php echo $caiu?>" name="coordonnee_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $coordonnee->getRef_coord ()?>" />
		<table class="infotable">
			<tr>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td class="size_strict">
				<span class="labelled">Titre:</span></td><td>
				<input id="coordonnee_lib<?php echo $caiu?>" name="coordonnee_lib<?php echo $caiu?>" type="text" class="classinput_xsize" value="<?php echo htmlentities($coordonnee->getLib_coord())?>" />
				</td>
			</tr>
			<?php if(!empty($GEST_TYPE_COORD)){ ?><tr>
				<td>
					<span class="labelled">Type :</span>
				</td><td>
					<select id="type_coord<?php echo $caiu?>" name="type_coord<?php echo $caiu?>" class="classinput_xsize" >
					<?php 
					global $bdd;
					$query = "SELECT id_coord_type, coord_type, defaut  FROM coordonnees_types";
					$retour = $bdd->query($query);
					while($res= $retour->fetchObject()){
						if($res->id_coord_type == $coordonnee->getType()){
							echo "<option value='".$res->id_coord_type."' selected='selected'>".$res->coord_type."</option>";
						}else{
							echo "<option value='".$res->id_coord_type."' >".$res->coord_type."</option>";
						}
					}					
					?>
					</select>
				</td>
			</tr><?php } ?>
			<tr>
				<td>
				<span class="labelled">T&eacute;l&eacute;phone&nbsp;1:</span></td>
				<td>
				<input id="coordonnee_tel1<?php echo $caiu?>" name="coordonnee_tel1<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($coordonnee->getTel1())?>" />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">T&eacute;l&eacute;phone&nbsp;2:</span></td><td>
				<input id="coordonnee_tel2<?php echo $caiu?>" name="coordonnee_tel2<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($coordonnee->getTel2())?>" />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Email:</span></td><td><a href="mailto:<?php echo $coordonnee->getEmail();?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/mail.gif" width="15" border="0" style="float:right" vspace="5"/></a>
				<input id="coordonnee_email<?php echo $caiu?>" name="coordonnee_email<?php echo $caiu?>" class="classinput_lsize" value="<?php echo htmlentities($coordonnee->getEmail())?>" />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Fax:</span></td><td>
				<input id="coordonnee_fax<?php echo $caiu?>" name="coordonnee_fax<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($coordonnee->getFax())?>" />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Note:</span></td><td>
				<textarea id="coordonnee_note<?php echo $caiu?>" name="coordonnee_note<?php echo $caiu?>" rows="2"  class="classinput_xsize"/><?php echo  htmlentities($coordonnee->getNote())?></textarea>
				</td>
			</tr>
			<tr>
				<td>
				<div style="text-align:left"> <a href="#" id="link_coord_confirm_supp_<?php echo $caiu?>">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_coord_confirm_supp_<?php echo $caiu?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('contact_coordonnee_supprime', 'annu_edition_coordonnee_suppression<?php echo $caiu?>');}, false);
				</script>
				</div>
				</td>
				<td style="text-align:right;">
				<input type="image" name="modifier<?php echo $caiu?>" id="modifier<?php echo $caiu?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
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
							if ($coordonnee->getOrdre()!=1) {
								?>
								<a href="annuaire_edition_coordonnee_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($coordonnee->getOrdre())-1 ?>&ordre_other=<?php echo ($coordonnee->getOrdre()) ?>" target="formFrame" name="modifier_coord_ordre_up_<?php echo $coordonnee->getOrdre()?>" id="modifier_coord_ordre_up_<?php echo $coordonnee->getOrdre()?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif"/></a>
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
							if ( getMax_ordre("coordonnees", $contact->getRef_contact())!=$coordonnee->getOrdre()) {
								?>
								<a href="annuaire_edition_coordonnee_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($coordonnee->getOrdre())+1 ?>&ordre_other=<?php echo ($coordonnee->getOrdre()) ?>" target="formFrame" name="modifier_coord_ordre_down_<?php echo $coordonnee->getOrdre()?>" id="modifier_coord_ordre_down_<?php echo $coordonnee->getOrdre()?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif"/></a>
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
				<?php 
				if ($coordonnee->getLib_coord()!="" || $coordonnee->getTypeLib()!="") {
				?>
				<a href="#" id="link_show_coordonnee_lib<?php echo $caiu?>" class="modif_input2"><strong><?php echo  htmlentities($coordonnee->getLib_coord())?></strong><?php if($coordonnee->getTypeLib()!= ""){?>&nbsp;(<?php echo  htmlentities($coordonnee->getTypeLib())?>)<?php }?></a>
				<script type="text/javascript">
				Event.observe("link_show_coordonnee_lib<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_coordonnee<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','coordonnee_lib<?php echo $caiu?>');}, false);
				</script>
				<?php 
				}
				?>
				</td>
			</tr>
			<?php if ($coordonnee->getTel1()!="") {?>
			<tr>
				<td>
				<span class="labelled">T&eacute;l&eacute;phone&nbsp;1:</span></td>
				<td>
				<a href="#" id="link_show_coordonnee_tel1<?php echo $caiu?>" class="modif_input1"><?php echo  htmlentities($coordonnee->getTel1())?></a>
				<script type="text/javascript">
				Event.observe("link_show_coordonnee_tel1<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_coordonnee<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','coordonnee_tel1<?php echo $caiu?>');}, false);
				</script>
				</td>
			</tr>
			<?php }?>
			<?php if ($coordonnee->getTel2()!="") {?>
			<tr>
				<td>
				<span class="labelled">T&eacute;l&eacute;phone&nbsp;2:</span></td><td>
				<a href="#" id="link_show_coordonnee_tel2<?php echo $caiu?>" class="modif_input1"><?php echo  htmlentities($coordonnee->getTel2())?></a>
				<script type="text/javascript">
				Event.observe("link_show_coordonnee_tel2<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_coordonnee<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','coordonnee_tel2<?php echo $caiu?>');}, false);
				</script>
				</td>
			</tr>
			<?php }?>
			<?php if ($coordonnee->getEmail()!="") {?>
			<tr>
				<td>
				<span class="labelled">Email:</span></td><td><a href="mailto:<?php echo $coordonnee->getEmail();?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/mail.gif" width="15" border="0" style="float:right" vspace="5"/></a>
				<a href="#" id="link_show_coordonnee_email<?php echo $caiu?>" class="modif_input2"><?php echo  htmlentities(substr($coordonnee->getEmail(),0,20))?></a>
				<script type="text/javascript">
				Event.observe("link_show_coordonnee_email<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_coordonnee<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','coordonnee_email<?php echo $caiu?>');}, false);
				</script>
				</td>
			</tr>
			<?php }?>
			<?php if ($coordonnee->getFax()!="") {?>
			<tr>
				<td>
				<span class="labelled">Fax:</span></td><td>
				<a href="#" id="link_show_coordonnee_fax<?php echo $caiu?>" class="modif_input1"><?php echo  htmlentities($coordonnee->getFax())?></a>
				<script type="text/javascript">
				Event.observe("link_show_coordonnee_fax<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_coordonnee<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','coordonnee_fax<?php echo $caiu?>');}, false);
				</script>
				</td>
			</tr>
			<?php }?>
			<?php if ($coordonnee->getNote()!="") {?>
			<tr>
				<td>
				<span class="labelled">Note:</span></td><td>
				<a href="#" id="link_show_coordonnee_note<?php echo $caiu?>" class="modif_input1"><?php echo  nl2br(htmlentities($coordonnee->getNote()))?></a>
				<script type="text/javascript">
				Event.observe("link_show_coordonnee_note<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_coordonnee<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>', 'coordonnee_note<?php echo $caiu?>');}, false);
				</script>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td style="text-align:left;">
				<div><a href="#" id="link_annu_edition_coordonnee_suppression<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_annu_edition_coordonnee_suppression<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);alerte.confirm_supprimer('contact_coordonnee_supprime', 'annu_edition_coordonnee_suppression<?php echo $caiu?>');}, false);
				</script>
				</div>
				</td>
				<td style="text-align:right;">
				<a href="#" id="link_show_annu_edition_coordonnee<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" /></a>
				<script type="text/javascript">
				Event.observe("link_show_annu_edition_coordonnee<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_coordonnee<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','coordonnee_lib<?php echo $caiu?>');}, false);
				</script>
				</td>
			</tr>
		</table>
<script type="text/javascript" language="javascript">
new Form.EventObserver('annu_editon_coordonnee<?php echo $caiu?>', function(element, value){formChanged();});

//on masque le chargement
H_loading();

</script>
</td></tr></table>