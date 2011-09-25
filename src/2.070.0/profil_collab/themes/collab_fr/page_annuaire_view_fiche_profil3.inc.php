
<div class="profil_reduce">
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil3_suppression" name="annu_edition_profil3_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations collaborateur </p>
<div class="">
<table style="width:100%">
	<tr>
	<td>
	<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil3" name="annu_edition_profil3" target="formFrame" style="display:none;">
	<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
	<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">N&deg; de s&eacute;curit&eacute; sociale:</span>
			</td>
			<td>
				<input name="collab_numero_secu" id="collab_numero_secu" type="text" class="classinput_xsize" value="<?php echo 		htmlentities($profils[$id_profil]->getNumero_secu ()) ?>" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Date de naissance:</span>
			</td>
			<td>
			<span class="infobulle" id="collab_date_naissance_info"><span><p class="infotext">Entrez une date au format jj/mm/aaaa</p></span></span>
				<input name="collab_date_naissance" id="collab_date_naissance" type="text" class="classinput_xsize" value="<?php 
				if ($profils[$id_profil]->getDate_naissance ()!=0000-00-00) {
					$a = substr($profils[$id_profil]->getDate_naissance (), 0, 4);     // conversion
					$m = substr($profils[$id_profil]->getDate_naissance (), 5, 2);     // de la date
					$j = substr($profils[$id_profil]->getDate_naissance (), 8, 2);     // au format FR
					$date = $j.'/'.$m.'/'.$a;
				
					echo  htmlentities($date);
				}?>" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Lieu de naissance:</span>
			</td>
			<td>
				<input name="collab_lieu_naissance" id="collab_lieu_naissance" type="text" class="classinput_xsize" value="<?php echo 		htmlentities($profils[$id_profil]->getLieu_naissance ()) ?>" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Nationalit&eacute;:</span>
			</td>
			<td>
				<select  id="collab_id_pays"  name="collab_id_pays" class="classinput_xsize">
						<option value="" >non défini</option>
					<?php
					$pays_collab = "non défini";
					$separe_listepays = 0;
					foreach ($listepays as $payslist){
						if ((!$separe_listepays) && (!$payslist->affichage)) { 
						$separe_listepays = 1; ?>
						<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
						<?php 		 
						}
						?>
						<option value="<?php echo $payslist->id_pays?>" <?php if ($profils[$id_profil]->getId_pays_nationalite () == $payslist->id_pays) {echo 'selected="selected"'; $pays_collab =  htmlentities($payslist->pays);}?>>
						<?php echo htmlentities($payslist->pays)?></option>
						<?php 
					}
					?>
				</select>
				</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Situation de famille:</span>
			</td>
			<td>
				<input name="collab_situation_famille" id="collab_situation_famille" type="text" class="classinput_xsize" value="<?php echo 		htmlentities($profils[$id_profil]->getSituation_famille ()) ?>" />
				</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Nombre d'enfants:</span>
			</td>
			<td>
			<span class="infobulle" id="collab_nbre_enfants_info">
			<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
			<span>
			<p class="infotext">Indiquez une valeur num&eacute;rique</p>
			</span></span>
				<input name="collab_nbre_enfants" id="collab_nbre_enfants" type="text" class="classinput_xsize" value="<?php echo 		htmlentities($profils[$id_profil]->getNbre_enfants ()) ?>" />
				
			</td>
		</tr>
		<?php if(!$profils[$id_profil]->verif_agenda() ) {?>
		<tr>
			<td><div style="height:10px"></div>
			</td>
		</tr>
		<?php } if(!$profils[$id_profil]->verif_agenda()){?>
		<tr>
			<td>&nbsp;
			</td>
			<td><input type="checkbox" id="chk_creer_agenda" name="chk_creer_agenda"/><label for="chk_creer_agenda">Cr&eacute;er Agenda</label>
			</td>
		</tr>
		<?php } if(!$profils[$id_profil]->verif_agenda() ) {?>
		<tr>
			<td><div style="height:10px"></div>
			</td>
		</tr>
		<?php }?>
	</table>
<p style="text-align:center">
<input type="image" name="profsubmit<?php echo $id_profil?>" id="profsubmit<?php echo $id_profil?>"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
</p>
</form>
	
	<table class="minimizetable"  id="start_visible_profil<?php echo $id_profil?>" cellspacing="0" border="0">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">N&deg; de s&eacute;curit&eacute; sociale:</span>
			</td>
			<td>
			<a href="#" id="show_collab_numero_secu" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getNumero_secu ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Date de naissance:</span>
			</td>
			<td>
			<a href="#" id="show_collab_date_naissance" class="modif_input1"><?php if ($profils[$id_profil]->getDate_naissance ()!=0000-00-00) {echo  htmlentities($date);}?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Lieu de naissance:</span>
			</td>
			<td>
			<a href="#" id="show_collab_lieu_naissance" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getLieu_naissance ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Nationalit&eacute;:</span>
			</td>
			<td>
			<a href="#" id="show_collab_id_pays" class="modif_select1"><?php echo  htmlentities($pays_collab)?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Situation de famille:</span>
			</td>
			<td>
			<a href="#" id="show_collab_situation_famille" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getSituation_famille ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Nombre d'enfants:</span>
			</td>
			<td>
			<a href="#" id="show_collab_nbre_enfants" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getNbre_enfants ())?></a>
			</td>
		</tr>
		<tr>
			<td><div style="height:10px"></div>
			</td>
		</tr>
		<?php if($profils[$id_profil]->verif_agenda()){?>
		<tr>
			<td>&nbsp;
			</td>
			<td>Agenda cr&eacute;&eacute;
			</td>
		</tr>
		<tr>
			<td>&nbsp;
			</td>
		</tr>
		<?php } if(!$profils[$id_profil]->verif_agenda()){?>
		<tr>
			<td style="text-align:center" colspan=2 >Pour cr&eacute;er un Agenda cliquez sur modifier
			</td>
		</tr>		
		<?php } ?>
		<tr>
			<td><div style="height:10px"></div>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
			 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" id="modifier_profil<?php echo $id_profil?>" />
			</td>
		</tr>
	</table>
		</td>
		<td style=" width:50%">
		<table style="width:100%">
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Fonctions :</span>	
			</td>
		</tr>
		<tr>
			<td>
			<div style=" width:100%;">
				<div id="liste_de_categorie_selectable_s" style=" background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90); -moz-opacity:.90; opacity:.90; width:312px; ">
				<?php
				reset($liste_fonctions_collab);
					while ($liste_fonction = current($liste_fonctions_collab) ){
					next($liste_fonctions_collab);
					?>
					
					<table cellpadding="0" cellspacing="0"  id="<?php echo ($liste_fonction->id_fonction)?>" style="width:96%">
					<tr id="tr_<?php echo ($liste_fonction->id_fonction)?>" class="list_art_categs"><td width="5px">
						<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
						<?php 
						for ($i=0; $i<=$liste_fonction->indentation; $i++) {
							if ($i==$liste_fonction->indentation) {
							 
								if (key($liste_fonctions_collab)!="") {
									if ($liste_fonction->indentation < current($liste_fonctions_collab)->indentation) {
										
									?><a href="#" id="link_div_art_categ_<?php echo $liste_fonction->id_fonction?>">
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="extend_<?php echo $liste_fonction->id_fonction?>"/>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="collapse_<?php echo $liste_fonction->id_fonction?>" style="display:none"/></a>
									<script type="text/javascript">
									Event.observe("link_div_art_categ_<?php echo $liste_fonction->id_fonction?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $liste_fonction->id_fonction?>') ; Element.toggle('extend_<?php echo $liste_fonction->id_fonction?>'); Element.toggle('collapse_<?php echo $liste_fonction->id_fonction?>');}, false);
									</script>
									<?php
									}
									else 
									{
									?>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
									<?php
									}
								}
								else 
								{
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
								<?php
								}
							}
							else
							{
						?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/></td><td>
						<?php 
							}
						}
						?></td>
						</tr></table>
						</td>
						<td>
						<div id="sub_mod_<?php echo ($liste_fonction->id_fonction)?>">
						<span id="mod_<?php echo ($liste_fonction->id_fonction)?>">
						<?php echo htmlentities($liste_fonction->lib_fonction)?></span>
						</div>
						</td>
						<td width="5px">
						<input type="checkbox" name="id_fonction_<?php echo $liste_fonction->id_fonction; ?>" id="id_fonction_<?php echo $liste_fonction->id_fonction; ?>" value="<?php echo $liste_fonction->id_fonction; ?>" <?php
									foreach ($fonctions_collab as $fonction_collab) {
										if ($liste_fonction->id_fonction == $fonction_collab) {echo 'checked="checked"';}
									}?>>
						</td>
					</tr>
				</table>
				<?php 
				if (key($liste_fonctions_collab)!="") {
					if ($liste_fonction->indentation < current($liste_fonctions_collab)->indentation) {
						echo '<div id="div_'.$liste_fonction->id_fonction.'" style="">';
					}
					
					
					if ($liste_fonction->indentation > current($liste_fonctions_collab)->indentation) {
									for ($a=$liste_fonction->indentation; $a> current($liste_fonctions_collab)->indentation ; $a--) {
									echo '</div>';
								}
					}
				}
				
				}
				?>
					</div>
					<div id="avertissement_droits" style="display:none; width:312px;">
					<center><b><font color="#FF0000">Attention ! Réinitialisez les droits des utilisateurs si necessaire</font></b></center>
				</div>
				<div id="maj_droits" style="display:block; width:312px;">
				<br>
				<?php 	
				$mes_utilisateurs = $contact->getUtilisateurs();
				foreach ($mes_utilisateurs as $mon_utilisateur){
					$user_fonctions = $mon_utilisateur->get_user_fonctions();
					if (is_array($user_fonctions)){
						if (count($user_fonctions) > 0){					
							echo '<a href="#" id="maj_droits_user_'.$mon_utilisateur->getRef_user().'" class="common_link">'."Réinitialiser les droits de l'utilisateur ".$mon_utilisateur->getPseudo()."</a><br>";
							?>
							<script type="text/javascript">
							Event.observe($("maj_droits_user_<?php echo $mon_utilisateur->getRef_user() ?>"), "click", function(evt){
								Event.stop(evt);
								maj_droits_membre_fonction(<?php echo $user_fonctions[0]->id_fonction ?>,'<?php echo $mon_utilisateur->getRef_contact() ?>','<?php echo $mon_utilisateur->getRef_user() ?>');
								});
							</script>
							<?php
						}
					}
				}				
				?>					
				</div>
				</div>
				<script type="text/javascript">
				
				
					
				<?php
					foreach ($liste_fonctions_collab as $liste_fonction) {
				?>
					Event.observe('tr_<?php echo ($liste_fonction->id_fonction)?>', 'mouseover',  function(){
						changeclassname ('tr_<?php echo ($liste_fonction->id_fonction)?>', 'list_art_categs_hover');
					}, false);
					
					Event.observe('tr_<?php echo ($liste_fonction->id_fonction)?>', 'mouseout',  function(){
						changeclassname ('tr_<?php echo ($liste_fonction->id_fonction)?>', 'list_art_categs');
					}, false);
					
				Event.observe('sub_mod_<?php echo ($liste_fonction->id_fonction)?>', 'click',  function(evt){Event.stop(evt);
				}, false);
				
				<?php 
					}
				?>
				</script>
			</td>
		</tr>
		</table>
		</td>
	</tr>
</table>
<script type="text/javascript" language="javascript">
new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});
new Event.observe("collab_date_naissance", "blur", datemask, false);
new Event.observe("collab_nbre_enfants", "blur", function(evt){nummask(evt,"0", "X");}, false);

Event.observe("modifier_profil<?php echo $id_profil?>", "click",  function(evt){
	Event.stop(evt); 
	$('annu_edition_profil<?php echo $id_profil?>').toggle();
	$('start_visible_profil<?php echo $id_profil?>').toggle();
}, false);

new Event.observe("collab_date_naissance", "mouseover", function(){$("collab_date_naissance_info").style.display = "block";}, false);
new Event.observe("collab_date_naissance", "mouseout", function(){$("collab_date_naissance_info").style.display = "none";}, false);
new Event.observe("collab_nbre_enfants", "mouseover", function(){$("collab_nbre_enfants_info").style.display = "block";}, false);
new Event.observe("collab_nbre_enfants", "mouseout", function(){$("collab_nbre_enfants_info").style.display = "none";}, false);


Event.observe("show_collab_numero_secu", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','collab_numero_secu');}, false);

Event.observe("show_collab_date_naissance", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','collab_date_naissance');}, false);

Event.observe("show_collab_lieu_naissance", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','collab_lieu_naissance');}, false);

Event.observe("show_collab_id_pays", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','collab_id_pays');}, false);

Event.observe("show_collab_situation_famille", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','collab_situation_famille');}, false);

Event.observe("show_collab_nbre_enfants", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','collab_nbre_enfants');}, false);


<?php 
reset($liste_fonctions_collab);
foreach ($liste_fonctions_collab as $liste_fonction) {
	?>
Event.observe("id_fonction_<?php echo $liste_fonction->id_fonction; ?>", "click",  function(evt){


	$("avertissement_droits").show();
	if($("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked) {
		add_fonction_collab ("<?php echo $liste_fonction->id_fonction; ?>", "<?php echo $contact->getRef_contact()?>", 0);
	} else {
		del_fonction_collab ("<?php echo $liste_fonction->id_fonction; ?>", "<?php echo $contact->getRef_contact()?>", 0);
	}
		
}, false);
	<?php
}
?>

//on masque le chargement
H_loading();

</script>
</div>
</div>
