<table class="minimizetable">
	<tr>
		<td>
		<form method="post" action="annuaire_edition_site_suppression.php" id="annu_edition_site_suppression<?php echo $caiu?>" name="annu_edition_site_suppression<?php echo $caiu?>" target="formFrame">
		<input type="hidden" name="ref_idform" value="<?php echo $caiu?>">
		<input type="hidden" name="<?php echo $site_web->getRef_site()?>" id="<?php echo $site_web->getRef_site()?>" value="<?php echo $caiu?>"/>
		<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
		<input id="site_ref<?php echo $caiu?>" name="site_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $site_web->getRef_site ()?>" />
		</form>
		</td>
	</tr><tr>
		<td>
			<form method="post" action="annuaire_edition_site.php" id="annu_editon_site<?php echo $caiu?>" name="annu_editon_site<?php echo $caiu?>" target="formFrame" style="display:none;">
			<input type="hidden" name="ref_idform" value="<?php echo $caiu?>">
			<input type="hidden" name="ref_contact<?php echo $caiu?>" value="<?php echo $contact->getRef_contact()?>">
			<input id="site_ref<?php echo $caiu?>" name="site_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $site_web->getRef_site ()?>" />
			<table class="infotable">
				<tr>
					<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td class="size_strict">
					<span class="labelled">Titre:</span></td><td>
					<input id="site_lib<?php echo $caiu?>" name="site_lib<?php echo $caiu?>" type="text" class="classinput_xsize" value="<?php echo htmlentities($site_web->getLib_site_web())?>" />
					</td>
				</tr>
				<?php if(!empty($GEST_TYPE_COORD)){ ?><tr>
					<td>
						<span class="labelled">Type :</span>
					</td><td>
						<select id="type_site<?php echo $caiu?>" name="type_site<?php echo $caiu?>" class="classinput_xsize" >
						<?php 
						global $bdd;
						$query = "SELECT id_web_type, web_type, defaut  FROM sites_web_types";
						$retour = $bdd->query($query);
						while($res= $retour->fetchObject()){
							if($res->id_web_type == $site_web->getType()){
								echo "<option value='".$res->id_web_type."' selected='selected'>".$res->web_type."</option>";
							}else{
								echo "<option value='".$res->id_web_type."' >".$res->web_type."</option>";
							}
						}					
						?>
						</select>
					</td>
				</tr><?php } ?>
				<tr>
					<td>
					<span class="labelled">Adresse URL:</span></td><td>
					<input id="site_url<?php echo $caiu?>" name="site_url<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($site_web->getUrl())?>" />
					</td>
				</tr>
				<tr>
					<td>
					<span class="labelled">Login:</span></td><td>
					<input name="site_login<?php echo $caiu?>" id="site_login<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($site_web->getLogin())?>" />
					</td>
				</tr>
				<tr>
					<td>
					<span class="labelled">Mot de passe:</span></td><td>
					<input id="site_pass<?php echo $caiu?>" name="site_pass<?php echo $caiu?>" type="text" class="classinput_xsize" value="<?php echo htmlentities($site_web->getPass())?>" />
					</td>
				</tr>
				<tr>
					<td>
					<span class="labelled">Note:</span></td><td>
					<textarea id="site_note<?php echo $caiu?>" name="site_note<?php echo $caiu?>" rows="2"  class="classinput_xsize"/><?php echo htmlentities($site_web->getNote())?></textarea>
					</td>
				</tr>
				<tr>
					<td style="text-align:left;">
					<div><a href="#" id="link_annu_edition_site_suppression<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
					</a>
						<script type="text/javascript">
						Event.observe("link_annu_edition_site_suppression<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);alerte.confirm_supprimer('contact_site_supprime', 'annu_edition_site_suppression<?php echo $caiu?>');}, false);
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
								if ($site_web->getOrdre()!=1) {
									?>
	
									<a href="annuaire_edition_site_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($site_web->getOrdre())-1 ?>&ordre_other=<?php echo ($site_web->getOrdre()) ?>" target="formFrame" name="modifier_site_ordre_up_<?php echo $site_web->getOrdre()?>" id="modifier_site_ordre_up_<?php echo $site_web->getOrdre()?>"  ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif"/></a>
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
								if ( getMax_ordre("sites_web", $contact->getRef_contact())!=$site_web->getOrdre()) {
									?>
									<a href="annuaire_edition_site_ordre.php?ref_contact=<?php echo $contact->getRef_contact()?>&ordre=<?php echo ($site_web->getOrdre())+1 ?>&ordre_other=<?php echo ($site_web->getOrdre()) ?>" target="formFrame" name="modifier_site_ordre_down_<?php echo $site_web->getOrdre()?>" id="modifier_site_ordre_down_<?php echo $site_web->getOrdre()?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif"/></a>
								
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
					<?php if ($site_web->getLib_site_web()!="" || $site_web->getTypeLib()!="") {?>
					<a href="#" id="link_show_site_lib<?php echo $caiu?>" class="modif_input2"><strong><?php echo  htmlentities($site_web->getLib_site_web())?></strong><?php if($site_web->getTypeLib() != ""){ ?>&nbsp;(<?php echo  htmlentities($site_web->getTypeLib())?>)<?php }?></a>
					<script type="text/javascript">
					Event.observe("link_show_site_lib<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_site<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','site_lib<?php echo $caiu?>');}, false);
					</script>
					<?php } ?>
					</td>
				</tr>
				<?php if ($site_web->getUrl()!="") {?>
				<tr>
					<td>
					<span class="labelled">Adresse URL:</span></td>
					<td>
					<a href="<?php if (!preg_match("#^((http|https|ftp)://)#", $site_web->getUrl())) {echo "http://";} ?><?php echo  $site_web->getUrl()?>" target="_blank" ><?php echo  htmlentities(substr(preg_replace("#(http://|https://|ftp://)(([[:punct:]]|[[:alnum:]])*)#",	"\\2", $site_web->getUrl()),0,20))?>...</a>
					</td>
				</tr>
				<?php } ?>
				<?php if ($site_web->getLogin()!="") {?>
				<tr>
					<td>
					<span class="labelled">Login:</span></td><td>
					<a href="#" id="link_show_site_login<?php echo $caiu?>" class="modif_input1"><?php echo  htmlentities($site_web->getLogin())?></a>
					<script type="text/javascript">
					Event.observe("link_show_site_login<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_site<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','site_login<?php echo $caiu?>');}, false);
					</script>
					</td>
				</tr>
				<?php } ?>
				<?php if ($site_web->getPass()!="") {?>
				<tr>
					<td>
					<span class="labelled">Mot de passe:</span></td><td>
					<a href="#" id="link_show_site_pass<?php echo $caiu?>" class="modif_input1"><?php echo  htmlentities($site_web->getPass())?></a>
					<script type="text/javascript">
					Event.observe("link_show_site_pass<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_site<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','site_pass<?php echo $caiu?>');}, false);
					</script>
					</td>
				</tr>
				<?php } ?>
				<?php if ($site_web->getNote()!="") {?>
				<tr>
					<td>
					<span class="labelled">Note:</span></td><td>
					<a href="#" id="link_show_site_note<?php echo $caiu?>" class="modif_textarea3"><?php echo  nl2br(htmlentities($site_web->getNote()))?></a>
					<script type="text/javascript">
					Event.observe("link_show_site_note<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_site<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','site_note<?php echo $caiu?>');}, false);
					</script>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td style="text-align:left;">
					<div> <a href="#" id="link_confirm_annu_edition_site_suppression<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<script type="text/javascript">
					Event.observe("link_confirm_annu_edition_site_suppression<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);alerte.confirm_supprimer('contact_site_supprime', 'annu_edition_site_suppression<?php echo $caiu?>');}, false);
					</script>
					</div>
					</td>
					<td style="text-align:right;">
					<a href="#" id="link_show_edition_site<?php echo $caiu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" /></a>
					<script type="text/javascript">
					Event.observe("link_show_edition_site<?php echo $caiu?>", "click",  function(evt){Event.stop(evt);show_edit_form('annu_editon_site<?php echo $caiu?>', 'start_visible_<?php echo $caiu?>','site_lib<?php echo $caiu?>');}, false);
					</script>
					</td>
				</tr>
			</table>

		<script type="text/javascript" language="javascript">
		new Form.EventObserver('annu_editon_site<?php echo $caiu?>', function(element, value){formChanged();});
		
		//on masque le chargement
		H_loading();
		
		</script>
		</td>
	</tr>
</table>