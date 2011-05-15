<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("listepays");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript" language="javascript">
</script>

<hr class="bleu_liner" />
<div class="">
	<p class="sous_titre1">Informations collaborateur </p>
	<div class="reduce_in_edit_mode">
	<table class="minimizetable">
		<tr>
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Fonctions :</span>	
			</td>
			<td>
			<div style="position:relative;top:0px; left:0px; width:100%;" class="simule_champs" id="liste_de_categorie_pour_article_s">
				<a href="#" id="lib_art_categ_link_select_s" style="display:block; width:100%; cursor: default;">
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
				<tr>
				<td>
				<span id="lib_art_categ_s" style=" float:left; height:18px; margin-left:3px; line-height:18px;">Définir la ou les fonctions</span>				</td>
				<td>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="lib_art_categ_bt_select_s">				</td>
				</tr>
				</table>
				</a>
				<iframe id="iframe_liste_de_categorie_selectable_s" frameborder="0" scrolling="no" src="about:_blank" style="display: none; z-index:249; position:absolute;  top: 1.65em; left: -1px; width:350px; height:300px;  filter:alpha(opacity=0); -moz-opacity:.0; opacity:.0;"></iframe>
				<div id="liste_de_categorie_selectable_s" style="display:none; z-index:250; position:absolute;  top: 1.65em; left: -1px; background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90); -moz-opacity:.90; opacity:.90; width:312px; height:300px; overflow:auto;">
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
						</td><td>
						<div id="sub_mod_<?php echo ($liste_fonction->id_fonction)?>">
						<span id="mod_<?php echo ($liste_fonction->id_fonction)?>">
						<?php echo htmlentities($liste_fonction->lib_fonction)?></span>
						</div>
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
					
					Event.observe('mod_<?php echo ($liste_fonction->id_fonction)?>', 'click',  function(evt){Event.stop(evt);
						if($("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked) {
							$("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked = false;
						} else {
							$("id_fonction_<?php echo $liste_fonction->id_fonction; ?>").checked = true;
						}
					}, false);
		
					Event.observe('sub_mod_<?php echo ($liste_fonction->id_fonction)?>', 'click',  function(evt){Event.stop(evt);
						Element.hide('liste_de_categorie_selectable_s'); 
						Element.hide('iframe_liste_de_categorie_selectable_s');
					}, false);
				
				
				<?php 
					}
				?>
				
			//effet de survol sur le faux select
				Event.observe('lib_art_categ_link_select_s', 'mouseover',  function(){$("lib_art_categ_bt_select_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_hover.gif";}, false);
				Event.observe('lib_art_categ_link_select_s', 'mousedown',  function(){$("lib_art_categ_bt_select_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_down.gif";}, false);
				Event.observe('lib_art_categ_link_select_s', 'mouseup',  function(){$("lib_art_categ_bt_select_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
				
				Event.observe('lib_art_categ_link_select_s', 'mouseout',  function(){$("lib_art_categ_bt_select_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
				Event.observe('lib_art_categ_link_select_s', 'click',  function(evt){Event.stop(evt);
					Element.toggle('liste_de_categorie_selectable_s'); 
					Element.toggle('iframe_liste_de_categorie_selectable_s');
				 }, false);

				</script>	
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">N&deg; de s&eacute;curit&eacute; sociale:</span>	
			</td><td>
				<input name="collab_numero_secu" id="collab_numero_secu" type="text" class="classinput_xsize" value="" /></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Date de naissance:</span>
			</td><td>
			<span class="infobulle" id="collab_date_naissance_info"><span><p class="infotext">Entrez une date au format jj/mm/aaaa</p></span></span>
			<input name="collab_date_naissance" id="collab_date_naissance" type="text" class="classinput_xsize" value="" />		
			
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Lieu de naissance:</span>
			</td><td>
			<input name="collab_lieu_naissance" id="collab_lieu_naissance" type="text" class="classinput_xsize" value="" /></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Nationalit&eacute;:</span>
			</td><td>
			<select  id="collab_id_pays"  name="collab_id_pays" class="classinput_xsize">
						<option value="" >non défini</option>
			<?php
				$separe_listepays = 0;
				foreach ($listepays as $payslist){
					if ((!$separe_listepays) && (!$payslist->affichage)) { 
						$separe_listepays = 1; ?>
						<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
						<?php 		 
				 	}
					?>
					<option value="<?php echo $payslist->id_pays?>" <?php if ($DEFAUT_ID_PAYS == $payslist->id_pays) {echo 'selected="selected"';}?>>
					<?php echo htmlentities($payslist->pays)?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Situation de famille:</span>
			</td><td>
			<input name="collab_situation_famille" id="collab_situation_famille" type="text" class="classinput_xsize" value="" />
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Nombre d'enfants:</span>
			</td><td>
			<span class="infobulle" id="collab_nbre_enfants_info">
			<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
			<span>
			<p class="infotext">Indiquez une valeur num&eacute;rique</p>
			</span></span>
			<input name="collab_nbre_enfants" id="collab_nbre_enfants" type="text" class="classinput_xsize" value="0" />
			</td>
		</tr>
		<tr>
			<td><div style="height:10px"></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;
			</td>
			<td><input type="checkbox" id="chk_agenda_collab" name="chk_agenda_collab"/><label for="chk_agenda_collab">Cr&eacute;er Agenda</label>
			</td>
		</tr>
		<tr>
			<td>&nbsp;
			</td>
			<td><input type="checkbox" id="chk_messagerie_collab" name="chk_messagerie_collab"/><label for="chk_messagerie_collab">Cr&eacute;er compte de Messagerie Interne</label>
			</td>
		</tr>
	</table>
</div>
</div>


<script type="text/javascript">

new Event.observe("collab_date_naissance", "blur", datemask, false);
new Event.observe("collab_nbre_enfants", "blur", function(evt){nummask(evt,"0", "X");}, false);

new Event.observe("collab_date_naissance", "mouseover", function(){$("collab_date_naissance_info").style.display = "block";}, false);
new Event.observe("collab_date_naissance", "mouseout", function(){$("collab_date_naissance_info").style.display = "none";}, false);
new Event.observe("collab_nbre_enfants", "mouseover", function(){$("collab_nbre_enfants_info").style.display = "block";}, false);
new Event.observe("collab_nbre_enfants", "mouseout", function(){$("collab_nbre_enfants_info").style.display = "none";}, false);
//on masque le chargement
H_loading();
</script>
