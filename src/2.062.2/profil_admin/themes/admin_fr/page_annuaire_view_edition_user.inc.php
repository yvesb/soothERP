<table class="minimizetable">
	<tr>
		<td>
		<form method="post" action="annuaire_edition_user_suppression.php" id="annu_edition_user_suppression<?php echo $caiu?>" name="annu_edition_user_suppression<?php echo $caiu?>" target="formFrame">
		<input type="hidden" name="ref_idform" value="<?php echo $caiu?>"/>
		<input type="hidden" name="<?php echo $user->getRef_user()?>" id="<?php echo $user->getRef_user()?>" value="<?php echo $caiu?>"/>
		<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
		<input id="user_ref<?php echo $caiu?>" name="user_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $user->getRef_user ()?>" /></form>
		</td>
	</tr><tr>
		<td>
		<form method="post" action="annuaire_edition_user.php" id="annu_editon_user<?php echo $caiu?>" name="annu_editon_user<?php echo $caiu?>" target="formFrame" style="display:none;">
		<input type="hidden" name="ref_idform" value="<?php echo $caiu?>"/>
		<input type="hidden" name="ref_contact<?php echo $caiu?>" value="<?php echo $contact->getRef_contact()?>"/>
		<input id="user_ref<?php echo $caiu?>" name="user_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $user->getRef_user ()?>" />
		<table class="infotable">
			<tr>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td class="size_strict">
				<span class="labelled">Pseudo:</span></td><td>
				<input id="user_pseudo<?php echo $caiu?>" name="user_pseudo<?php echo $caiu?>" type="text" class="classinput_xsize" value="<?php echo htmlentities($user->getPseudo())?>" />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Mot de passe:</span></td>
				<td>
				<input id="user_code<?php echo $caiu?>" name="user_code<?php echo $caiu?>" class="classinput_xsize" value=""   type="password"/>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Confimer Mdp:</span></td>
				<td>
				<input id="user_2code<?php echo $caiu?>" name="user_2code<?php echo $caiu?>" class="classinput_xsize" value=""  type="password"/>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Coordonn&eacute;es:</span></td>
				<td>
				<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
				<iframe id="iframe_liste_choix_coordonnee<?php echo $caiu?>" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_coordonnee" style="display:none"></iframe>
				<div id="choix_liste_choix_coordonnee<?php echo $caiu?>"  class="choix_liste_choix_coordonnee" style="display:none"></div></div>
				<div id="coordonnee_choisie<?php echo $caiu?>" class="simule_champs" style="width:99%;cursor: default;">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="bt_coordonnee_choisie<?php echo $caiu?>">
					<span id="lib_coordonnee_choisie<?php echo $caiu?>"><?php echo getLib_coordonnee($user->getRef_coord_user())?></span>
				</div>
				<input id="user_coord<?php echo $caiu?>" name="user_coord<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($user->getRef_coord_user());?>" type="hidden"/>
				</td>
			</tr>
			<tr>
				<td>
					<span class="labelled">Langage:</span>
				</td><td>
				<select id="user_id_langage<?php echo $caiu?>"  name="user_id_langage<?php echo $caiu?>" class="classinput_xsize" >
					<?php
					foreach ($langages as $langage){
						?>
						<option value="<?php echo $langage['id_langage']?>" <?php if ($user->getId_langage () == $langage['id_langage']) {echo 'selected="selected"';}?>>
						<?php echo htmlentities($langage['lib_langage'])?></option>
						<?php 
					}
					?>
				</select>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Actif:</span></td><td>
				<input id="user_actif<?php echo $caiu?>" name="user_actif<?php echo $caiu?>" <?php if ($user->getActif()) {echo 'checked="checked"';}?> value="1"   type="checkbox"  />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Utilisateur principal:</span></td><td>
				<input id="user_master<?php echo $caiu?>" name="user_master<?php echo $caiu?>" <?php if ($user->getMaster()) {echo 'checked="checked" value="1"';} else { echo 'value="0"';}?>   type="radio" />
				</td>
			</tr>
			<tr>
				<td>
				<div style="text-align:left"> <a href="#" id="link_annu_edition_user_suppression<?php echo $caiu?>">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_annu_edition_user_suppression<?php echo $caiu?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('contact_user_supprime', 'annu_edition_user_suppression<?php echo $caiu?>');}, false);
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
							if ($user->getOrdre()!=1) {
								?>
	
								<a href="annuaire_edition_user_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($user->getOrdre())-1 ?>&ordre_other=<?php echo ($user->getOrdre()) ?>" target="formFrame" name="modifier_user_ordre_up_<?php echo $user->getOrdre()?>" id="modifier_user_ordre_up_<?php echo $user->getOrdre()?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif"/></a>
								<?php
							} else {
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
								<?php
							}
							?>
							</div>						</td>
					</tr>
					<tr>
						<td>
						<div id="down_arrow_<?php echo $caiu?>">
							<?php
							if ( getMax_ordre("users", $contact->getRef_contact())!=$user->getOrdre()) {
								?>
								<a href="annuaire_edition_user_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($user->getOrdre())+1 ?>&ordre_other=<?php echo ($user->getOrdre()) ?>" target="formFrame" name="modifier_user_ordre_down_<?php echo $user->getOrdre()?>" id="modifier_user_ordre_down_<?php echo $user->getOrdre()?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif"/></a>
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
				<?php if ($user->getPseudo()!="") {?>
				<a href="#" id="link_user_pseudo<?php echo $caiu?>" class="modif_input2"><strong><?php echo  htmlentities($user->getPseudo())?></strong></a>
				<script type="text/javascript">
				Event.observe("link_user_pseudo<?php echo $caiu?>", "click",  function(evt){Event.stop(evt); show_edit_form('annu_editon_user<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','user_pseudo<?php echo $caiu?>');}, false);
				</script>
				<?php }?>
				</td>
			</tr>
			<?php if (!$user->getActif()) {?>
			<tr>
				<td>
				<span class="labelled">Non Actif</span></td><td>
				</td>
			</tr>
			<?php }?>
			<?php if ($user->getMaster()) {?>
			<tr>
				<td>
				<span class="labelled">Utilisateur principal</span></td><td>&nbsp;
				</td>
			</tr>
			<?php }?>
			<tr>
				<td style="text-align:left;">
				<span style=" float:right"><a href="#" id="more_det<?php echo $caiu?>" style="color:#000000">+ de détails</a>
				</span>
				<div><a href="#" id="link2_annu_edition_user_suppression<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link2_annu_edition_user_suppression<?php echo $caiu?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('contact_user_supprime', 'annu_edition_user_suppression<?php echo $caiu?>');}, false);
				Event.observe("more_det<?php echo $caiu?>", "click",  function(evt){Event.stop(evt); page.verify('utilisateur_detail','index.php#'+escape('utilisateur_details.php?ref_user=<?php echo htmlentities($user->getRef_user())?>'),'true','_blank')}, false);
				</script>
				</div>
				</td>
				<td style="text-align:right;">
				<a href="#" id="link_show_annu_edition_user<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" /></a>
				<script type="text/javascript">
				Event.observe("link_show_annu_edition_user<?php echo $caiu?>", "click",  function(evt){Event.stop(evt); show_edit_form('annu_editon_user<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','user_pseudo<?php echo $caiu?>');}, false);
				</script>
				</td>
			</tr>
		</table>
		
		
		<script type="text/javascript" language="javascript">
		new Form.EventObserver('annu_editon_user<?php echo $caiu?>', function(element, value){formChanged();});
		
		//fonction de choix de coordonnees
		
		//effet de survol sur le faux select
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mouseover',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_hover.gif";}, false);
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mousedown',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_down.gif";}, false);
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mouseup',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mouseout',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
							
		//affichage des choix
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'click',  function(evt){Event.stop(evt); start_coordonnee ("<?php echo $contact->getRef_contact()?>", "lib_coordonnee_choisie<?php echo $caiu?>", "user_coord<?php echo $caiu?>", "choix_liste_choix_coordonnee<?php echo $caiu?>", "iframe_liste_choix_coordonnee<?php echo $caiu?>", "annuaire_liste_choix_coordonnee.php");}, false);
							
		<?php if (!$user->getMaster()) { ?>
			Event.observe('user_master<?php echo $caiu?>', 'click',  function(evt){Event.stop(evt); submitform("annu_editon_user<?php echo $caiu?>");}, false);
		<?php } ?>
		
		//on masque le chargement
		H_loading();
		
		</script>
		</td>
	</tr>
</table>