<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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

<table width="100%" border="0">
<tr>
<td>
<form action="planning_taches_add.php" method="post" id="planning_taches_add" name="planning_taches_add" target="formFrame" >
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
						<input name="lib_tache" id="lib_tache" type="text" value=""  class="classinput_xsize"  />		</td>
					</tr>
				<tr>
					<td>Description: </td>
					<td>
						<textarea name="text_tache" id="text_tache" class="classinput_xsize" ></textarea>		</td>
					</tr>
				<tr>
					<td>Date d'&eacute;ch&eacute;ance: </td>
					<td>
						<input type="text" value="" id="date_echeance" name="date_echeance" class="classinput_xsize" />		</td>
					</tr>
				<tr>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_important.gif" width="25px" height="20px" /> Important: </td>
					<td>
						<input type="radio" value="1" id="important_oui" name="importance"/>Oui&nbsp;&nbsp;&nbsp;<input type="radio" value="0" id="important_non" name="importance" checked="checked"/>Non
						</td>
					</tr>
				<tr>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_urgente.gif" width="25px" height="20px" /> Urgent: </td>
					<td>
						<input type="radio" value="1" id="urgence_oui" name="urgence" />Oui&nbsp;&nbsp;&nbsp;<input type="radio" value="0" id="urgence_non" name="urgence" checked="checked" />Non
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
							Event.observe('ref_contact_select_img', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("tache_set_contact",  "\'increment_nouvelle_tache\', \'liste_contact\' "); preselect ('<?php echo $COLLAB_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
						</script>Collaborateurs concern&eacute;s: 
					</td>
					<td>
						
						<div  style="width:100%; display:block; background-color:#FFFFFF; border:1px solid #CCCCCC;  ">
						<div style="padding:8px" id="liste_contact">
						</div>
						</div>
						<input type="hidden" value="0" id="increment_nouvelle_tache" name="increment_nouvelle_tache" />	
					</td>
				</tr>
				<tr>
					<td colspan="2" style=" height:25px; line-height:25px" valign="middle"><br />

						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform" style="border-bottom:1px solid #000000"/><br />

					</td>
				</tr>	
				<tr>
					<td>Fonctions concern&eacute;es: </td>
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
									<input type="checkbox" name="id_fonction_<?php echo $liste_fonction->id_fonction; ?>" id="id_fonction_<?php echo $liste_fonction->id_fonction; ?>" value="<?php echo $liste_fonction->id_fonction; ?>">
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
										$("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked = false;
									} else {
										$("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked = true;
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
			<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
			</td>
		</tr>
	</table>
	
</form>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
new Form.EventObserver('planning_taches_add', function(){formChanged();});


Event.observe("date_echeance", "blur", function(evt){
	datemask (evt); 
}, false);

//on masque le chargement
H_loading();
</SCRIPT>