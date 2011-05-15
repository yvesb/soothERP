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
<div class="emarge">

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_recherche_mini.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_tarifs_assistant.inc.php" ?>
<p class="titre" id="titre_crea_art">Cr&eacute;ation d'un nouvel article </p>
<div>
<table class="chemin_table" border="0"  cellspacing="0">
	<tr>
		<td style="width:6%" id="chemin_etape_0_1" class="chemin_fleche_choisi_arrow">&nbsp;</td>
		<td class="chemin_numero_choisi" style="width:2%" id="chemin_etape_0_2">1</td>
		<td style="width:6%" id="chemin_etape_1_0" class="chemin_fleche_grisse">&nbsp;</td>
		<td style="width:6%" id="chemin_etape_1_1" class="chemin_fleche_grisse">&nbsp;</td>
		<td class="chemin_numero_grisse" style="width:2%" id="chemin_etape_1_2">2</td>
		<td style="width:6%" id="chemin_etape_2_0" class="chemin_fleche_grisse">&nbsp;</td>
		<td style="width:6%" id="chemin_etape_2_1" class="chemin_fleche_grisse">&nbsp;</td>
		<td class="chemin_numero_grisse" style="width:2%" id="chemin_etape_2_2">3</td>
		<td style="width:6%" id="chemin_etape_3_0" class="chemin_fleche_grisse">&nbsp;</td>
		<td style="width:6%" id="chemin_etape_3_1" class="chemin_fleche_grisse">&nbsp;</td>
		<td class="chemin_numero_grisse" style="width:2%" id="chemin_etape_3_2">4</td>
		<td style="width:6%" id="chemin_etape_4_0" class="chemin_fleche_grisse">&nbsp;</td>
		<td style="width:6%" id="chemin_etape_4_1" class="chemin_fleche_grisse">&nbsp;</td>
		<td class="chemin_numero_grisse" style="width:2%" id="chemin_etape_4_2">5</td>
		<td style="width:6%" id="chemin_etape_5_0" class="chemin_fleche_grisse">&nbsp;</td>
		<td style="width:6%" id="chemin_etape_5_1" class="chemin_fleche_grisse">&nbsp;</td>
		<td class="chemin_numero_grisse" style="width:2%" id="chemin_etape_5_2">6</td>
		<td style="width:6%" id="chemin_etape_6_0" class="chemin_fleche_grisse">&nbsp;</td>
		<td style="width:6%" id="chemin_etape_6_1" class="chemin_fleche_grisse">&nbsp;</td>
		<td class="chemin_numero_grisse" style="width:2%" id="chemin_etape_6_2">7</td>
		<td style="width:6%">&nbsp;</td>
		<td style="width:2%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="chemin_texte_choisi" style="width:14%" id="chemin_etape_0_3">Description</td>
		<td colspan="3" class="chemin_texte_grisse" style="width:14%" id="chemin_etape_1_3">Caract&eacute;ristiques</td>
		<td colspan="3" class="chemin_texte_grisse" style="width:14%" id="chemin_etape_2_3">Gestion</td>
		<td colspan="3" class="chemin_texte_grisse" style="width:14%" id="chemin_etape_3_3">Prix</td>
		<td colspan="3" class="chemin_texte_grisse" style="width:14%" id="chemin_etape_4_3">Composition</td>
		<td colspan="3" class="chemin_texte_grisse" style="width:14%" id="chemin_etape_5_3">Images</td>
		<td colspan="3" class="chemin_texte_grisse" style="width:14%" id="chemin_etape_6_3">Liaison</td>
		<td style="width:2%"></td>
		</tr>
</table><br />
<br />


<form action="catalogue_articles_create.php" target="formFrame" method="post" name="article_add" id="article_add"  enctype="multipart/form-data">
<div class="articletview_corps" id="description_info"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%;">
<div id="description_info_under">
	<table style="width:100%">
		<tr >
			<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Cat&eacute;gorie:</td>
			<td>
			<span style="position: static">
			<span style="position:relative; width:100%;" class="simule_champs"  id="liste_de_categorie_pour_article">
				<a href="#" id="lib_art_categ_link_select" style="display:block; width:100%; cursor: default;">
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
				<tr>
				<td>
				<div id="lib_art_categ" style=" float:left; height:18px; margin-left:3px; line-height:18px; display:block ">Cliquez pour choisir la cat&eacute;gorie</div>
				</td>
				<td>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="lib_art_categ_bt_select">
				</td>
				</tr>
				</table>
				</a>
				<iframe id="iframe_liste_de_categorie_selectable" frameborder="0" scrolling="no" src="about:_blank" style="display: none; z-index:249; position:absolute;  top: 1.65em; left: -1px; width:300px; height:300px;  filter:alpha(opacity=0); -moz-opacity:.0; opacity:.0; "></iframe>
				<div id="liste_de_categorie_selectable" style="display:none; z-index:250; position:absolute;  top: 1.65em; left: -1px; background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90); -moz-opacity:.90; opacity:.90; width:270px; height:300px; overflow:auto;">

				<?php
					$list_art_categ =	get_articles_categories("", array($LIVRAISON_MODE_ART_CATEG));
					while ($art_categ = current($list_art_categ) ){
						next($list_art_categ);
						?>
					
					<table cellspacing="0"  id="<?php echo ($art_categ->ref_art_categ)?>" style="width:100%"  class="simule_champ_content">
					<tr id="tr_<?php echo ($art_categ->ref_art_categ)?>" class="list_art_categs"><td width="5px">
						<table cellspacing="0" cellpadding="0" width="5px">
							<tr>
								<td>
								<?php 
								for ($i=0; $i<=$art_categ->indentation; $i++) {
									if ($i==$art_categ->indentation) {
										if (key($list_art_categ)!="") {
											if ($art_categ->indentation < current($list_art_categ)->indentation) {
												?><span class="clic" id="link_extend_<?php echo $art_categ->ref_art_categ?>">
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/<?php if ($DEFAUT_LEVEL_CATEG_AFFICHED > $i) {echo "collapse";} else {echo "extend";}?>.gif" width="14px" id="extend_<?php echo $art_categ->ref_art_categ?>"/>
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/<?php if ($DEFAUT_LEVEL_CATEG_AFFICHED > $i) {echo "extend";} else {echo "collapse";}?>.gif" width="14px" id="collapse_<?php echo $art_categ->ref_art_categ?>" style="display:none"/>
                                                                                                </span>
												<script type="text/javascript">
												Event.observe("link_extend_<?php echo $art_categ->ref_art_categ?>", "click",  function(evt){
                                                                                                    Event.stop(evt);
                                                                                                    $('div_<?php echo $art_categ->ref_art_categ?>').toggle() ;
                                                                                                    $('extend_<?php echo $art_categ->ref_art_categ?>').toggle();
                                                                                                    $('collapse_<?php echo $art_categ->ref_art_categ?>').toggle();
                                                                                                }, false);
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
								</td><td>
								</td><td>
								</td><td>
								</td><td>
							</tr>
						</table>
						</td><td>
						<a href="#" id="mod_<?php echo ($art_categ->ref_art_categ)?>" style="display:block; width:100%">
						<?php echo htmlentities($art_categ->lib_art_categ)?>
						</a>
						</td>
					</tr>
					</table>
					<?php 
					if (key($list_art_categ)!="") {
						if ($art_categ->indentation < current($list_art_categ)->indentation) {
							?>
							<div id="div_<?php echo $art_categ->ref_art_categ;?>" style=" <?php if ($DEFAUT_LEVEL_CATEG_AFFICHED <= $art_categ->indentation) {echo "display: none";} else {echo "";}?>">
							<?php 
						}
						if ($art_categ->indentation > current($list_art_categ)->indentation) {
										for ($a=$art_categ->indentation; $a>current($list_art_categ)->indentation ; $a--) {
											echo '</div>';
										}
						}
					}
				
				}
				?>
			</div>
			</span>	
			</span>	
			</td>
			<td>&nbsp;</td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%; text-align:right">
				<a href="#" id="bt_etape_b_0"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" /></a></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="width:20%" class="labelled_text">Libell&eacute;: 
			<input type="hidden" name="create_article" id="create_article" value="1" />
			<input type="hidden" name="ref_art_categ" id="ref_art_categ"  value="" />
			<input type="hidden" name="modele" id="modele" value="" /></td>
			<td rowspan="2" style="width:25%"><textarea name="lib_article" class="classinput_xsize" id="lib_article"></textarea></td>
			<td>&nbsp;</td>
			<?php 
			if($GESTION_CONSTRUCTEUR){
				?>
				<td class="labelled_text">Constructeur:</td>
				<td>
				<select name="ref_constructeur" id="ref_constructeur" class="classinput_xsize">
				<option value=""></option>
				<?php 
				foreach ($constructeurs_liste as $constructeur_liste) {
					?>
					<option value="<?php echo $constructeur_liste->ref_contact;?>"><?php echo $constructeur_liste->nom;?></option>
					<?php 
				}
				?>
				</select>
				</td>
				<?php 
			}else{
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php
			}
			?>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php 
			if($GESTION_CONSTRUCTEUR){
				?>
				<td class="labelled_text">R&eacute;f&eacute;rence constructeur:</td>
				<td><span style="width:25%">
						<input type="text" name="ref_oem" id="ref_oem" value=""  class="classinput_xsize"/>
				</span></td>
				<?php 
			}else{
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php 
			}
			?>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<?php 
			if($GESTION_LIB_TICKET){
				?>
				<td class="labelled_text">
				Libell&eacute; court:			</td>
				<td>
					<input type="text" name="lib_ticket" id="lib_ticket" value=""  class="classinput_xsize"/>			</td>
				<?php 
			}else{ 
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php 
			}
			?>
				<td>&nbsp;</td>
			<?php 
			if($GESTION_REF_INTERNE){
				?>
				<td class="labelled_text">R&eacute;f&eacute;rence Interne: </td>
				<td><span style="width:25%">
					<input type="text" name="ref_interne" id="ref_interne" value=""  class="classinput_xsize"/>
				</span></td>
				<?php 
			}else{ 
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php 
			}
			?>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Description courte:</td>
			<td colspan="4">
				<textarea name="desc_courte" rows="4" class="classinput_xsize" style="width:100%" id="desc_courte"></textarea>			
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Description Longue:</td>
			<td colspan="4">
			<div id="editeur_descript_long">
			<div id="editeur_bt_barre" class="barre_editeur">
			<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center">
			<select name="editeur_fontname" id="editeur_fontname" class="" >
				<option value="">Police</option>
				<option value="Arial, Helvetica, sans-serif">Arial</option>
				<option value="Times New Roman, Times, serif">Times New Roman</option>
				<option value="Courier New, Courier, mono">Courrier New</option>
				<option value="Verdana, sans-serif">Verdana</option>
			</select>		</td>
		<td align="center">
			<select name="editeur_size" id="editeur_size" class="" >
				<option value="">Taille</option>
				<option value="1">1 (8 pt)</option>
				<option value="2">2 (10 pt)</option>
				<option value="3">3 (12 pt)</option>
				<option value="4">4 (14 pt)</option>
				<option value="5">5 (18 pt)</option>
				<option value="6">6 (24 pt)</option>
				<option value="7">7 (36 pt)</option>
			</select>		</td>
		<td align="center">
			<a href="#" id="editeur_bold" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/bold.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_italic" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/italic.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_souligner" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/underline.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_align_left" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyleft.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_align_center" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifycenter.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_align_right" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyright.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_align_justify" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyfull.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_outdent" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/outdent.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_indent" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/indent.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_insertorderedlist" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertorderedlist.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_insertunorderedlist" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertunorderedlist.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_forecolor" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/forecolor.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_hilitecolor" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/hilitecolor.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_link" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/createlink.gif" />			</a>		</td>
		<td align="center">
			<a href="#" id="editeur_unlink" class="bt_wysiwyg">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/unlink.gif" />			</a>		</td>
	</tr>
</table>
</div>
	<iframe name="desc_longue_html" id="desc_longue_html" class="classinput_xsize" style="height:220px; display:block; width:100%" frameborder="0"></iframe><br />
	<iframe width="161" height="113" id="colorpalette" src="colors.php?proto=editeur&ifr=desc_longue_html" style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden;" frameborder="0" scrolling="no"></iframe><br />
	<textarea name="desc_longue" rows="6" style="display:none;" id="desc_longue"></textarea>
	</div>
			</td>
			<td>&nbsp;</td>
		</tr>
      <tr>
        <td>&nbsp;</td>
        <td class="labelled_text">Mots clés : <br /><span style="color:gray;">(séparez les mots par des points-virgules)</span></td>
        <td colspan="4">
          <textarea name="tags" rows="4" class="classinput_xsize" style="width:100%" id="tags"></textarea>      
        </td>
        <td>&nbsp;</td>
      </tr>
	</table>
	
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="6" style="text-align:right">
				<a href="#" id="bt_etape_0"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>
		</div>
</div>

<div class="articletview_corps" id="tarifs_info"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
	<div id="tarifs_info_under">
	</div>
</div>
	
<div class="articletview_corps"  id="gestion_info"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
	<div id="gestion_info_under">
		<table style="width:100%">
		<tr>
			<td style="width:2%">&nbsp;</td>
			<td style="width:20%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			<td style="width:5%">&nbsp;</td>
			<td style="width:20%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Date de d&eacute;but de disponibilit&eacute;: </td>
			<td><input type="text" name="date_debut_dispo" id="date_debut_dispo" value="<?php  echo date("d-m-Y");?>"  class="classinput_nsize" style="width:33%"/></td>
			<td>&nbsp;</td>
			<td class="labelled_text">Valorisation:</td>
			<td>
			<select name="id_valo" id="id_valo" class="classinput_xsize">
				<?php 
				$prev_grp = "";
				foreach (get_valorisations() as $valorisation) {
					if ($valorisation->groupe != $prev_grp) {
						?>
						<optgroup disabled="disabled" label="<?php echo $valorisation->groupe;?>"></optgroup>
						<?php 
						$prev_grp = $valorisation->groupe;
					}
					?>
					<option value="<?php echo $valorisation->id_valo;?>" <?php 
				if ($DEFAUT_ID_VALO == $valorisation->id_valo) {echo 'selected="selected"';} ?>><?php echo $valorisation->lib_valo;?></option>
					<?php 
				}
				?>
			</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Date de fin de disponibilit&eacute;: </td>
			<td>
			<input type="text" name="date_fin_dispo" id="date_fin_dispo" value="<?php  echo date("d-m-Y", mktime (date("m"),date("i"),date("s")+$DEFAUT_ARTICLE_LT, date("m"), date("d"), date("Y")))  ;?>"  class="classinput_nsize" style="width:33%"/> <span id="infinite_choix" style="display:none; width:33%">Durée infinie &nbsp;</span>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/infinite.gif" style="cursor:pointer" id="infinite"/>
			<script type="text/javascript">
			Event.observe('infinite', 'click',  function(evt){
			Event.stop(evt); 
			if ($('date_fin_dispo').style.display == "") {
				$('date_fin_dispo').value = "<?php echo date("d-m-2200", mktime (0 ,0 ,0 , date("m"), date("d"), date("Y"))) ;?>" ;
			}
			Element.toggle('infinite_choix'); 
			Element.toggle('date_fin_dispo');
			}, false);
			</script>
			</td>
			<td>&nbsp;</td>
			<td class="labelled_text">Indice de valorisation: </td>
			<td><input type="text" name="valo_indice" id="valo_indice" value="<?php echo $DEFAUT_INDICE_VALORISATION?>"  class="classinput_nsize"/></td>
			<td>&nbsp;</td>
		</tr>
		<tr id="tr_is_achetable">
			<td>&nbsp;
		
			<td  class="labelled_text" onclick="test();">L'article peut &ecirc;tre achet&eacute;:</td>
			<td>
				<select   name="is_achetable" id="is_achetable" class="classinput_nsize">
					<option value="1"  >Oui</option>
					<option value="0"  >Non</option>
				</select>
			</td>
		</tr>
		<tr id="tr_is_vendable">
			<td>&nbsp;</td>
			<td class="labelled_text">L'article peut &ecirc;tre commercialis&eacute;:</td>
			<td>
				<select name="is_vendable" id="is_vendable" class="classinput_nsize">
					<option value="1" >Oui</option>
					<option value="0" >Non</option>
					</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
				<td class="labelled_text">Article compos&eacute; :</td>
				<td>
		<select name="lot" id="lot" class="classinput_nsize">
			<option value="0" <?php if ($DEFAUT_LOT == 0) { ?> selected="selected"<?php } ?>>Article simple</option>
			<option value="1" <?php if ($DEFAUT_LOT == 1) { ?> selected="selected"<?php } ?>>Article à fabriquer</option>
			<option value="2" <?php if ($DEFAUT_LOT == 2) { ?> selected="selected"<?php } ?>>Composition Interne</option>
			<option value="3" <?php if ($DEFAUT_LOT == 3) { ?> selected="selected"<?php } ?>>Composition Fabriquant</option>
		</select>
				</td>
				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				
			<td>&nbsp;</td>
			<td class="labelled_text">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<?php 
			if ($GESTION_SN) {
				?>
				<td class="labelled_text">Identifiant de traçabilité:</td>
				<td>
				
		<select name="gestion_sn" id="gestion_sn" class="classinput_hsize">
					<option value="0" <?php if ($DEFAUT_GESTION_SN == 0) {echo 'selected="selected"';} ?>>Aucun</option>
					<option value="1" <?php if ($DEFAUT_GESTION_SN == 1) {echo 'selected="selected"';} ?>>Numéro de s&eacute;rie</option>
					<option value="2" <?php if ($DEFAUT_GESTION_SN == 2) {echo 'selected="selected"';} ?>>Numéro de lot</option>
			</select>
				</td>
				<?php 
				}else{
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php 
			} 
			?>
			<td>&nbsp;</td>
			<td class="labelled_text"><span id="art_lib_code_barre">Code barre: </span></td>
			<td>
			<input type="text" name="a_code_barre" id="a_code_barre" value="" onfocus="return false"  class="classinput_xsize"/>
			<input type="hidden" name="serialisation_code_barre" id="serialisation_code_barre" value="0" />
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">
				<div id="modele_info">
				</div>
			</td>
			<td colspan="2">
			<div id="liste_codes_barres">
			</div>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	
		
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="6" style="text-align:right">
				<a href="#" id="bt_etape_2"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>

	</div>
</div>

<div class="articletview_corps" id="caract_info"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
	<div id="caract_info_under">
	</div>
</div>
	
<div class="articletview_corps" id="images_info"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
	<div id="images_info_under">
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="4" style="text-align:left">
			<table id="intitule_img_liste" >
				<tr>
					<td style="width:50%">Indiquez l'emplacement de l'image.
					</td>
					<td style="width:50%">ou indiquez l'url de l'image (http://www.lesite.com/image.jpg)
					</td>
				</tr>
			</table>
			<div id="liste_images_article"><span style="width:50%" id="span_img_file_1"><input type="file" size="35" name="image_1" /></span><span style="width:5%" id="span_img_sep_1">&nbsp;</span><span style="width:45%" id="span_img_url_1"><input type="text" name="url_img_1" value=""  size="35"/></span><div>&nbsp;</div>
			</div>
			<br /><br />
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_add_image.gif" id="add_img_form_bt" style="cursor:pointer"/>
				<script type="text/javascript">
					Event.observe("add_img_form_bt", "click", function(evt){
						Event.stop(evt);
						insert_new_line_image("liste_images_article");
						$("increment_images").value = parseInt(Math.abs($("increment_images").value))+1;
					});
				</script>
			</td>
			<td style="text-align:right">
			</td>
			<td style="text-align:right">
				<input type="hidden" name="increment_images" id="increment_images" value="2" />
				
			</td>
		</tr>
		<tr>
			<td colspan="4">
			</td><td style="text-align:right">
				<a href="#" id="bt_etape_5"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>
	</div>
</div>

<div class="articletview_corps" id="liaison_info"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
	<div id="liaison_info_under" style="margin-left:5%; margin-right:5%;">
		<input type="hidden" name="serialisation_liaison" id="serialisation_liaison" value="0" />
		<?php foreach ($liaisons_type_liste as $liaison_type) { ?>
			<div id="ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_vers" style="width:100%; display:none;">
				<div class="liaison_type_title">
					<?php echo htmlentities(str_replace("%LIB_ARTICLE%", "Ce nouvel article", $liaison_type->getLib_liaison_type_vers())); ?>
				</div>
				<div style="width:100%;">
					<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_vers" class="liste_liaison"></ul>
				</div>
			</div>
			<div id="ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" style="width:100%; display:none;">
				<div class="liaison_type_title">
					<?php echo htmlentities(str_replace("%LIB_ARTICLE%", "Ce nouvel article", $liaison_type->getLib_liaison_type_depuis())); ?>
				</div>
				<div style="width:100%;">
					<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" class="liste_liaison"></ul>
				</div>
			</div>
		<?php } ?>

		<br/>
		<div style="background-color:white;" align="right">
			<table >
				<tr>
					<td align="right">Ajouter une liaison de type&nbsp;</td>
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
						<input id="nouvelle_liaison_lib_article_lie" name="nouvelle_liaison_lib_article_lie" type="text" value="" class="classinput_lsize" style="width:200px;" disabled="disabled"/>
						<input id="nouvelle_liaison_ref_article_lie" name="nouvelle_liaison_ref_article_lie" type="hidden" value="" class=""/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_set_contact.gif" id="nouvelle_liaison_vers_show_mini_moteur_articles" alt="Choisir l&acute;article" title="Choisir l&acute;article" style="cursor:pointer"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_vers_reset" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td>
						<input id="nouvelle_liaison_ratio_vers" name="nouvelle_liaison_ratio_vers" type="text" value="1" class="classinput_lsize" style="width:40px;"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_vers_reset_ratio" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td width="100px" align="right">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" id="nouvelle_liaison_vers_valider" alt="Ajouter" title="Ajouter" style="cursor:pointer"/>

						<script type="text/javascript">
	
							Event.observe("nouvelle_liaison_vers_reset", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_lib_article_lie").value = "";
								$("nouvelle_liaison_ref_article_lie").value = "";
								$("nouvelle_liaison_type_vers_selected").selectedIndex = 0;
							}, false);
	
							Event.observe("nouvelle_liaison_vers_reset_ratio", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_ratio_vers").value = "1";
							}, false);
						
							Event.observe("nouvelle_liaison_vers_show_mini_moteur_articles", "click",  function(evt){
								Event.stop(evt);
								show_mini_moteur_articles('recherche_article_set_article', "\'nouvelle_liaison_ref_article_lie\', \'nouvelle_liaison_lib_article_lie\'");
							}, false);
						
							Event.observe("nouvelle_liaison_vers_valider", "click",  function(evt){
								Event.stop(evt);
								if($("nouvelle_liaison_ref_article_lie").value != "" && $("nouvelle_liaison_lib_article_lie").value != ""){
									var ratio = parseFloat($("nouvelle_liaison_ratio_vers").value);
									link_article_to_article_creation_vers(parseInt($("serialisation_liaison").value), $("nouvelle_liaison_type_vers_selected").options[$("nouvelle_liaison_type_vers_selected").selectedIndex].value, "REF_NOUVEL_ARTICLE", $("nouvelle_liaison_ref_article_lie").value, $("nouvelle_liaison_lib_article_lie").value, ratio);
									$("nouvelle_liaison_lib_article_lie").value = "";
									$("nouvelle_liaison_ref_article_lie").value = "";
									$("nouvelle_liaison_ratio_vers").value = "1";
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
			<table >
				<tr>
					<td align="right">Ajouter une liaison de type&nbsp;</td>
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
						<input id="nouvelle_liaison_lib_article" name="nouvelle_liaison_lib_article" type="text" value="" class="classinput_lsize" style="width:200px;" disabled="disabled"/>
						<input id="nouvelle_liaison_ref_article" name="nouvelle_liaison_ref_article" type="hidden" value="" class=""/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_set_contact.gif" id="nouvelle_liaison_depuis_show_mini_moteur_articles" alt="Choisir l&acute;article" title="Choisir l&acute;article" style="cursor:pointer"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_depuis_reset" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td>
						<input id="nouvelle_liaison_ratio_depuis" name="nouvelle_liaison_ratio_depuis" type="text" value="1" class="classinput_lsize" style="width:40px;"/>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="nouvelle_liaison_depuis_reset_ratio" alt="Effacer" title="Effacer" style="cursor:pointer"/>
					</td>
					<td width="100px" align="right">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" id="nouvelle_liaison_depuis_valider" alt="Ajouter" title="Ajouter" style="cursor:pointer"/>
	
						<script type="text/javascript">
	
							Event.observe("nouvelle_liaison_depuis_reset", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_lib_article").value = "";
								$("nouvelle_liaison_ref_article").value = "";
								$("nouvelle_liaison_type_depuis_selected").selectedIndex = 0;
							}, false);
	
							Event.observe("nouvelle_liaison_depuis_reset_ratio", "click",  function(evt){
								Event.stop(evt);
								$("nouvelle_liaison_ratio_depuis").value = "1";
							}, false);
						
							Event.observe("nouvelle_liaison_depuis_show_mini_moteur_articles", "click",  function(evt){
								Event.stop(evt);
								show_mini_moteur_articles('recherche_article_set_article', "\'nouvelle_liaison_ref_article\', \'nouvelle_liaison_lib_article\'");
							}, false);
						
							Event.observe("nouvelle_liaison_depuis_valider", "click",  function(evt){
								Event.stop(evt);
								if($("nouvelle_liaison_ref_article").value != "" && $("nouvelle_liaison_lib_article").value != ""){
									var ratio = parseFloat($("nouvelle_liaison_ratio_depuis").value);
									link_article_to_article_creation_depuis(parseInt($("serialisation_liaison").value), $("nouvelle_liaison_type_depuis_selected").options[$("nouvelle_liaison_type_depuis_selected").selectedIndex].value, "REF_NOUVEL_ARTICLE", $("nouvelle_liaison_ref_article").value, $("nouvelle_liaison_lib_article").value, ratio);
									$("nouvelle_liaison_lib_article").value = "";
									$("nouvelle_liaison_ref_article").value = "";
									$("nouvelle_liaison_ratio_depuis").value = "1";
									$("nouvelle_liaison_type_depuis_selected").selectedIndex = 0;
								}
							}, false);
						</script>
					</td>
				</tr>
			</table>
		</div>
		
		<br />
		
		<div align="right">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"  id="bt_etape_6" style="cursor:pointer; margin-right:3px" />
		</div>
		
		<br />
		
		<div>
			<p class="liaison_texte_info"> Vous avez la possibilit&eacute; d'associer diff&eacute;rents articles &aacute; celui-ci, ceux-ci seront alors automatiquement li&eacute;s &aacute; la fiche produit.</p>
		</div>
	</div>
</div>
	
<div class="articletview_corps" id="lot_info"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none">
	<div id="lot_info_under">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:5%">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
				<td style="width:5%">&nbsp;</td>
			</tr>
			<tr>
				<td style="width:5%">&nbsp;</td>
				<td style="width:15%" class="composant_titre_qte">Quantit&eacute;</td>
				<td style="width:75%" class="composant_titre_lib">Libell&eacute; du composant</td>
				<td style="width:5%">&nbsp;</td>
			</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:5%">&nbsp;</td>
				<td colspan="2" style="width:90%"><div class="composant_type_title">Niveau 1</div>
					<input id="composant_niveau_1" name="composant_niveau_1" value="1" type="hidden"/>
				</td>
				<td style="width:5%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width:70%">				
				</td>
				<td style="width:20%" class="composant_add_art" ><a href="#" id="link_art_add_composant">Ajouter un composant</a>
				<script type="text/javascript">
				Event.observe("link_art_add_composant", "click",  function(evt){Event.stop(evt); show_mini_moteur_articles ('art_add_composant', '1, 0');}, false);
				</script>
				</td>
				<td>&nbsp;</td>
			</tr>			
		</table>
	<ul id="composant_ul" class="liste_composant">
	</ul>
	<input type="hidden" name="serialisation_composant" id="serialisation_composant" value="1" />
	<input type="hidden" name="serialisation_niveau_composant" id="serialisation_niveau_composant" value="1" />
	<input type="hidden" name="liste_composant" id="liste_composant" value="" />
	<br />
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="5" style="text-align:right">
				<a href="#" id="bt_etape_4"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>
	</div>
	</div>
</form>
</div>
</div>

<SCRIPT type="text/javascript">
//initialisation de l'éditeur de texte
editeur.HTML_editor("desc_longue", "desc_longue_html", "editeur");
Event.observe('editeur_bold', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("bold", null);});
Event.observe('editeur_italic', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("italic", null);});
Event.observe('editeur_souligner', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("underline", null);});
Event.observe('editeur_align_left', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifyleft", null);});
Event.observe('editeur_align_center', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifycenter", null);});
Event.observe('editeur_align_right', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifyright", null);});
Event.observe('editeur_align_justify', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("JustifyFull", null);});
Event.observe('editeur_outdent', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("outdent", null);});
Event.observe('editeur_indent', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("indent", null);});
Event.observe('editeur_insertorderedlist', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("insertorderedlist", null);});
Event.observe('editeur_insertunorderedlist', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("insertunorderedlist", null);});
Event.observe('editeur_fontname', "change", function(evt){ if ($("editeur_fontname").value!="") { editeur.HTML_exeCmd("FontName", $("editeur_fontname").value); $("editeur_fontname").selectedIndex=0; };});
Event.observe('editeur_size', "change", function(evt){ if ($("editeur_size").value!="") { editeur.HTML_exeCmd("FontSize", $("editeur_size").value); $("editeur_size").selectedIndex=0;};});

Event.observe('editeur_forecolor', "click", function(evt){Event.stop(evt); editeur.recordRange(2); parent.command = "forecolor"; $("colorpalette").style.left = getOffsetLeft($("editeur_forecolor"))+"px"; $("colorpalette").style.top = (getOffsetTop($("editeur_forecolor")))+"px"; $("colorpalette").style.display=""; });

Event.observe('editeur_hilitecolor', "click", function(evt){Event.stop(evt); editeur.recordRange(2); editeur.HTML_surlignage(); $("colorpalette").style.left = getOffsetLeft($("editeur_hilitecolor"))+"px"; $("colorpalette").style.top = (getOffsetTop($("editeur_hilitecolor")))+"px"; $("colorpalette").style.display=""; });

Event.observe('editeur_link', "click", function(evt){Event.stop(evt); var szURL = prompt("Entrez l'adresse url:", "http://");   if ((szURL != null) && (szURL != "")) { editeur.HTML_exeCmd("CreateLink", szURL)};});
Event.observe('editeur_unlink', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("unlink", null);});


//Event.observe(document, "mousedown", function(evt){editeur.dismisscolorpalette();});
Event.observe($("desc_longue_html").contentWindow.document, "mousedown", function(evt){editeur.dismisscolorpalette();});
//Event.observe(document, "keypress", function(evt){editeur.dismisscolorpalette();});
Event.observe($("desc_longue_html").contentWindow.document, "keypress", function(evt){editeur.dismisscolorpalette();});


Event.observe($("desc_longue_html").contentWindow.document, "mouseup", function(evt){editeur.HTML_getstyle_delay(200);});
Event.observe($("desc_longue_html").contentWindow.document, "dblclick", function(evt){editeur.HTML_getstyle();});
Event.observe($("desc_longue_html").contentWindow.document, "keyup", function(evt){editeur.HTML_getstyle_delay(400);});
Event.observe($("desc_longue_html").contentWindow.document, "blur", function(evt){editeur.HTML_save();});
Event.observe($("desc_longue_html"), "blur", function(evt){editeur.HTML_save();});
//---------------------------------------------------------------
//fin d'intialisation de l'éditeur
//---------------------------------------------------------------	

//centrage de l'assistant tarif

centrage_element("pop_up_assistant_tarif");
centrage_element("pop_up_assistant_tarif_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_tarif_iframe");
centrage_element("pop_up_assistant_tarif");
});

//centrage du mini_moteur

centrage_element("pop_up_mini_moteur_cata");
centrage_element("pop_up_mini_moteur_cata_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_cata_iframe");
centrage_element("pop_up_mini_moteur_cata");
});

//------------------------------------------------------------------------
// gestionnaire de progression des étapes de saisie
//------------------------------------------------------------------------
chemin= new Array();
chemin[0]=Array("0_1", "0_1", "0_2", "0_3", "description_info", "allowed", true);
chemin[1]=Array("1_0", "1_1", "1_2", "1_3", "caract_info", "notallowed", true);
chemin[2]=Array("2_0", "2_1", "2_2", "2_3", "gestion_info", "notallowed", true);
chemin[3]=Array("3_0", "3_1", "3_2", "3_3", "tarifs_info", "notallowed", true);
chemin[4]=Array("4_0", "4_1", "4_2", "4_3", "lot_info", "notallowed", <?php if ($DEFAUT_LOT) {?>true<?php }else{ ?>false<?php }?>);
chemin[5]=Array("5_0", "5_1", "5_2", "5_3", "images_info", "notallowed", true);
chemin[6]=Array("6_0", "6_1", "6_2", "6_3", "liaison_info", "notallowed", true);






Event.observe($("chemin_etape_0_2"), "click", function(evt){Event.stop(evt); goto_etape (0)});
Event.observe($("chemin_etape_0_3"), "click", function(evt){Event.stop(evt); goto_etape (0)});
Event.observe($("chemin_etape_1_2"), "click", function(evt){Event.stop(evt); goto_etape (1)});
Event.observe($("chemin_etape_1_3"), "click", function(evt){Event.stop(evt); goto_etape (1)});
Event.observe($("chemin_etape_2_2"), "click", function(evt){Event.stop(evt); goto_etape (2)});
Event.observe($("chemin_etape_2_3"), "click", function(evt){Event.stop(evt); goto_etape (2)});
Event.observe($("chemin_etape_3_2"), "click", function(evt){Event.stop(evt); goto_etape (3)});
Event.observe($("chemin_etape_3_3"), "click", function(evt){Event.stop(evt); goto_etape (3)});
Event.observe($("chemin_etape_4_2"), "click", function(evt){Event.stop(evt); goto_etape (4)});
Event.observe($("chemin_etape_4_3"), "click", function(evt){Event.stop(evt); goto_etape (4)});
Event.observe($("chemin_etape_5_2"), "click", function(evt){Event.stop(evt); goto_etape (5)});
Event.observe($("chemin_etape_5_3"), "click", function(evt){Event.stop(evt); goto_etape (5)});
Event.observe($("chemin_etape_6_2"), "click", function(evt){Event.stop(evt); goto_etape (6)});
Event.observe($("chemin_etape_6_3"), "click", function(evt){Event.stop(evt); goto_etape (6)});
//fin gestionnaire d'étapes

submit_in_way = false;
//fonction de validation du formulaire
function valide_create_article() {
	if (!$("composant_ul").empty()) {
	var liste = Sortable.serialize('composant_ul').replace(/composant_ul\[\]=/g,"");
			t_liste = liste.split("&");
			$("liste_composant").value=t_liste;
	}
	if (!submit_in_way) {
		submitform ("article_add");
		submit_in_way = true;
	}
}

//fonction de validation de l'étape 1
function valide_etape_1() {
	if (($("ref_art_categ").value!="") && ($("lib_article").value!="")) {
		for (key in chemin) {
			if (chemin[key][6] && key!=0) { allow_chemin_etape(key);}
		} 
		
	//	Event.observe($("bt_etape_1"), "click", function(){goto_etape (2);});
		Event.observe($("bt_etape_2"), "click", function(evt){Event.stop(evt); goto_etape (3);});
	//	Event.observe($("bt_etape_3"), "click", function(){goto_etape (4);});
		Event.observe($("bt_etape_4"), "click", function(evt){Event.stop(evt); goto_etape (5);});
		Event.observe($("bt_etape_5"), "click", function(evt){Event.stop(evt); goto_etape (6);});
		Event.observe($("bt_etape_6"), "click", function(evt){
			Event.stop(evt);
			valide_create_article();
		}, false);
	}else {
		for (key in chemin) {
			if (chemin[key][6] && key!=0) { notallow_chemin_etape(key);}
		} 
	}
}

//observateur du bon remplissage des étapes
Event.observe($("lib_article"), "blur", function(){valide_etape_1()});


	Event.observe($("lot"), "click", function(){
	if ($("lot").value != "0") {
		chemin[4][6]= true; allow_chemin_etape(4);
	} else {
		chemin[4][6]= false; notallow_chemin_etape(4);
	}
	});
	



// observateur des boutons continuer des étapes
Event.observe($("bt_etape_0"), "click", function(evt){Event.stop(evt); goto_etape (1);});
Event.observe($("bt_etape_b_0"), "click", function(evt){Event.stop(evt); goto_etape (1);});

//------------------------------------------------------------------------------------
// select de la catégorie
//
//------------------------------------------------------------------------------------
				function changeref_art_categ() { 
				page.traitecontent('catalogue_articles_modele_info','catalogue_articles_modele_info.php?ref_art_categ='+$("ref_art_categ").value,'true','modele_info'); 
				page.traitecontent('catalogue_articles_categ_caract','catalogue_articles_categ_caract.php?ref_art_categ='+$("ref_art_categ").value,'true','caract_info');
				page.traitecontent('catalogue_articles_tarifs','catalogue_articles_tarifs.php?ref_art_categ='+$("ref_art_categ").value,'true','tarifs_info');
				 valide_etape_1();
				}
				
				function show_info(){
				//$("info_gene_art").style.display="block";
				}
				<?php
				foreach ($list_art_categ  as $art_categ){
					?>
					Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseover',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs_hover');}, false);
					
					Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseout',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs');}, false);
					
					Event.observe('mod_<?php echo ($art_categ->ref_art_categ)?>', 'click',  function(evt){Event.stop(evt);  $("ref_art_categ").value="<?php echo ($art_categ->ref_art_categ)?>"; changeref_art_categ(); Element.toggle('liste_de_categorie_selectable'); Element.toggle('iframe_liste_de_categorie_selectable'); $("lib_art_categ").innerHTML="<?php echo htmlentities($art_categ->lib_art_categ)?>"; 
					$("date_fin_dispo").value = <?php
					if ($art_categ->duree_dispo) {
						echo '"'.date("d-m-Y", mktime (date("m"),date("i"),date("s")+$art_categ->duree_dispo, date("m"), date("d"), date("Y"))).'";'  ;
					} else {
						echo '"'.date("d-m-2200", mktime (0 ,0 ,0 , date("m"), date("d"), date("Y"))) .'";' ;
						echo '$("date_fin_dispo").style.display = "none";';
						echo '$("infinite_choix").style.display = "";';
					}
					?>
					}, false);
					<?php 
				}
				?>


				
				//effet de survol sur le faux select
					Event.observe('lib_art_categ_link_select', 'mouseover',  function(){$("lib_art_categ_bt_select").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_hover.gif";}, false);
					Event.observe('lib_art_categ_link_select', 'mousedown',  function(){$("lib_art_categ_bt_select").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_down.gif";}, false);
					Event.observe('lib_art_categ_link_select', 'mouseup',  function(){$("lib_art_categ_bt_select").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
					
					Event.observe('lib_art_categ_link_select', 'mouseout',  function(){$("lib_art_categ_bt_select").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
					Event.observe('lib_art_categ_link_select', 'click',  function(evt){Event.stop(evt); Element.toggle('liste_de_categorie_selectable'); Element.toggle('iframe_liste_de_categorie_selectable');}, false);
					
//
//fin de la gestion du select de catégorie
//

//verif des valeurs par masque
new Event.observe("date_fin_dispo", "blur", datemask, false);
new Event.observe("date_debut_dispo", "blur", datemask, false);
new Event.observe("valo_indice", "blur", function(evt){nummask(evt,"1", "X.X");}, false);

// observateur de rezise pour mise à hauteur
Event.observe(window, "resize", setheight_article_create, false);
setheight_article_create();

//observateur de modification du formulaire
new Form.EventObserver('article_add',  function(){formChanged();});


//observer le focus sur le codebarrepour le vider
Event.observe('a_code_barre', "focus", function(evt){$("a_code_barre").value="";;});


//observer le retour chariot lors de la saisie du code barre pour lancer la recherche
function add_code_barre_if_Key_RETURN (evt) {

	var id_field = Event.element(evt);
	var field_value = id_field.value;
	var key = evt.which || evt.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	
		Event.stop(evt);
		
		var num_serie	=	$("serialisation_code_barre").value;
		var zone= $("liste_codes_barres");
		var addli= document.createElement("div");
			addli.setAttribute ("id", "div_code_barre_"+num_serie);
		var input1= document.createElement("input");
			input1.setAttribute ("id", "code_barre_"+num_serie);
			input1.setAttribute ("name", "code_barre_"+num_serie);
			input1.setAttribute ("type", "hidden");
			input1.setAttribute ("value", $("a_code_barre").value);
		var image= document.createElement("img");
			image.setAttribute ("id", "img_code_barre_del_"+num_serie);
			image.setAttribute ("src", dirtheme+"images/supprime.gif");
			image.setAttribute("class","img_float_r") ;
			image.setAttribute ("className", "img_float_r");
			
		var divli= document.createElement("div");
			divli.setAttribute ("id", "div_inner_code_barre_"+num_serie);
			divli.setAttribute("class","code_barre_div") ;
			divli.setAttribute ("className", "code_barre_div");
			
		zone.appendChild(addli);
		$("div_code_barre_"+num_serie).appendChild(image);
		$("div_code_barre_"+num_serie).appendChild(divli);
		$("div_inner_code_barre_"+num_serie).innerHTML = $("a_code_barre").value;
		$("div_code_barre_"+num_serie).appendChild(input1);
		$("serialisation_code_barre").value= parseInt(num_serie)+1;
		Event.observe( $("img_code_barre_del_"+num_serie) , "click", function(){remove_tag ("div_code_barre_"+num_serie);});
		$("a_code_barre").value="";
		$("a_code_barre").focus();
	break;   
	}
}
Event.observe('a_code_barre', "keypress", function(evt){add_code_barre_if_Key_RETURN (evt);});


//on masque le chargement
H_loading();
</SCRIPT>
