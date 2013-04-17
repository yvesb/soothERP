<?php

// *************************************************************************************************************
// EDITION D'UNE TACHE
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
<script type="text/javascript">
</script>

<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_tache_edit" style="cursor:pointer; float:right" alt="Fermer" title="Fermer" />
<table width="100%" border="0">
<tr>
<td>
<form action="planning_taches_maj.php" method="post" id="planning_taches_maj" name="planning_taches_maj" target="formFrame" >
						<input type="hidden" value="<?php echo $tache_cree->getId_tache();?>" id="id_tache" name="id_tache" />	
	<table width="100%" border="0">
		<tr class="smallheight">
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="2">
			<table width="100%" border="0">
				<tr class="smallheight">
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
				<tr>
					<td>Libell&eacute;: </td>
					<td>
						<input name="lib_tache" id="lib_tache" type="text" value="<?php echo htmlentities($tache_cree->getLib_tache());?>"  class="classinput_xsize"  />		</td>
					</tr>
				<tr>
					<td>Description: </td>
					<td>
						<textarea name="text_tache" id="text_tache" class="classinput_xsize" ><?php echo htmlentities($tache_cree->getText_tache());?></textarea>		</td>
					</tr>
				<tr>
					<td>Date d'&eacute;cheance: </td>
					<td>
						<input type="text" value="<?php echo date_Us_to_Fr($tache_cree->getDate_echeance ());?>" id="date_echeance" name="date_echeance" class="classinput_xsize" />		</td>
					</tr>
				<tr>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_important.gif" width="25px" height="20px" /> Important: </td>
					<td>
						<input type="radio" value="1" id="important_oui" name="importance" <?php if($tache_cree->getImportance ()) { ?>checked="checked"<?php } ?>/>Oui&nbsp;&nbsp;&nbsp;<input type="radio" value="0" id="important_non" name="importance" <?php if(!$tache_cree->getImportance ()) { ?>checked="checked"<?php } ?>/>Non
						</td>
					</tr>
				<tr>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_urgente.gif" width="25px" height="20px" /> Urgent: </td>
					<td>
						<input type="radio" value="1" id="urgence_oui" name="urgence"  <?php if($tache_cree->getUrgence ()) { ?>checked="checked"<?php } ?>/>Oui&nbsp;&nbsp;&nbsp;<input type="radio" value="0" id="urgence_non" name="urgence"  <?php if(!$tache_cree->getUrgence ()) { ?>checked="checked"<?php } ?> />Non
						</td>
					</tr>
			</table>
			</td>
			<td>&nbsp;</td>
			<td colspan="2">
			<table width="100%" border="0">
				<tr>
					<td style="width:50%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:50%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="ref_contact_select_img">
						<script type="text/javascript">
						//effet de survol sur le faux select
							Event.observe('ref_contact_select_img', 'mouseover',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
							Event.observe('ref_contact_select_img', 'mousedown',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
							Event.observe('ref_contact_select_img', 'mouseup',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
							
							Event.observe('ref_contact_select_img', 'mouseout',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
							Event.observe('ref_contact_select_img', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("add_collab_tache",  "\'<?php echo $tache_cree->getId_tache();?>\', \'increment_edition_tache\', \'liste_contact_edition\' "); preselect ('<?php echo $COLLAB_ID_PROFIL; ?>', 'id_profil_m');}, false);
						</script>Collaborateurs concern&eacute;s: 
					</td>
					<td>
						
						<div  style="width:100%; display:block; background-color:#FFFFFF; border:1px solid #CCCCCC;  ">
						<div style="padding:8px" id="liste_contact_edition">
						<?php
						$increment_collab = 0;
						foreach ($liste_collabs as $collab) {
							?>
							<div class="height_div" id="contact_collab_<?php echo $increment_collab;?>" >
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="sup_collab_<?php echo $increment_collab;?>" class="img_float_r"/>
								<span id="nom_collab_<?php echo $increment_collab;?>">
								<?php echo nl2br(htmlentities(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $collab->nom))),0, 26))))?>...
								</span>
								<input name="ref_contact_collab_<?php echo $increment_collab;?>" id="ref_contact_collab_<?php echo $increment_collab;?>" value="<?php echo htmlentities($collab->ref_contact);?>" type="hidden" />
							</div>
							<script type="text/javascript">
							pre_start_sup_collab_tache_edition ("<?php echo $tache_cree->getId_tache();?>", "sup_collab_<?php echo $increment_collab;?>", "contact_collab_<?php echo $increment_collab;?>", "<?php echo $collab->ref_contact;?>");
							</script>
							<?php
						$increment_collab++;
						}
						?>
						</div>
						</div>
						<input type="hidden" value="<?php echo $increment_collab;?>" id="increment_edition_tache" name="increment_edition_tache" />	
					</td>
				</tr>
				<tr>
					<td colspan="2" style=" height:25px; line-height:25px" valign="middle"><br />

						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform" style="border-bottom:1px solid #000000"/><br />

					</td>
				</tr>	
				<tr>
					<td>Fonctions concern&eacute;s: </td>
					<td>
						<div  style="width:100%; display:block; background-color:#FFFFFF; border:1px solid #CCCCCC;  ">
						<div style="padding:8px; display:block; z-index:250; width:95%; " id="liste_de_categorie_selectable_s">
							<?php
							reset($liste_fonctions_collab);
							while ($liste_fonction = current($liste_fonctions_collab) ){
							next($liste_fonctions_collab);
								?>
								
								<table cellpadding="0" cellspacing="0"  id="<?php echo ($liste_fonction->id_fonction)?>" style="width:100%">
								<tr id="tr_<?php echo ($liste_fonction->id_fonction)?>" class="list_art_categs">
									<td width="5px">
									<table cellpadding="0" cellspacing="0" width="5px">
									<tr>
									<td>
									
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
									?>
									</td>
									</tr>
									</table>
									</td>
									<td>
									<span id="mod_<?php echo ($liste_fonction->id_fonction)?>">
									<?php echo htmlentities($liste_fonction->lib_fonction)?></span>
									</td>
									<td width="5px">
									<input type="checkbox" name="id_fonction_<?php echo $liste_fonction->id_fonction; ?>" id="id_fonction_<?php echo $liste_fonction->id_fonction; ?>" value="<?php echo $liste_fonction->id_fonction; ?>" <?php 
						foreach ($liste_collabs_fonctions as $collabs_fonction) {
							if ($liste_fonction->id_fonction == $collabs_fonction->id_fonction) {
								echo 'checked="checked"';
							}
						}
?>>
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
								
								Event.observe('mod_<?php echo ($liste_fonction->id_fonction)?>', 'click',  function(evt){Event.stop(evt);
									if($("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked) {
										del_fonction_tache ("<?php echo $tache_cree->getId_tache();?>", "<?php echo $liste_fonction->id_fonction; ?>")
										$("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked = false;
									} else {
										add_fonction_tache ("<?php echo $tache_cree->getId_tache();?>", "<?php echo $liste_fonction->id_fonction; ?>")
										$("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked = true;
									}
								}, false);
								
								Event.observe('id_fonction_<?php echo ($liste_fonction->id_fonction)?>', 'click',  function(evt){
									if($("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked) {
										add_fonction_tache ("<?php echo $tache_cree->getId_tache();?>", "<?php echo $liste_fonction->id_fonction; ?>")
									} else {
										del_fonction_tache ("<?php echo $tache_cree->getId_tache();?>", "<?php echo $liste_fonction->id_fonction; ?>")
									}
								}, false);
							
							
								<?php 
								}
							?>
					
							</script>
						</div>
						</div>
					</td>
				</tr>
				</table>
			<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
			</td>
		</tr>
	</table>
	
</form>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
new Form.EventObserver('planning_taches_maj', function(){formChanged();});


Event.observe("date_echeance", "blur", function(evt){
	datemask (evt); 
}, false);

Event.observe("close_tache_edit", "click", function(evt){
$("edition_tache").innerHTML="";
$("edition_tache").hide();
$("edition_tache_iframe").hide();
}, false);


$("edition_tache").show();
$("edition_tache_iframe").show();
//on masque le chargement
H_loading();
</SCRIPT>