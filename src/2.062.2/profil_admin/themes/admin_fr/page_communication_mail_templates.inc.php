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
tableau_smenu[0] = Array('smenu_communication', 'smenu_communication.php' ,'true' , 'sub_content', 'Communication');
tableau_smenu[1] = Array('communication_mail_templates','communication_mail_templates.php','true','sub_content', 'Mod&egrave;les d&apos;email');
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des mod&egrave;les d&apos;email</p>
<div style="height:50px">
<div class="contactview_corps">
	<table style="width:100%">
		<tr>
			<td>
				<form action="communication_mail_template_add.php" method="post" id="communication_mail_template_add" name="communication_mail_template_add" target="formFrame" enctype="multipart/form-data" >
				<table style="width:100%">
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td class="titre_config" colspan="4">Ajouter un mod&egrave;le d&apos;email	</td>
					</tr>
					<tr>
						<td>
							Nom du modèle:<br />
							<input name="lib_mail_template" id="lib_mail_template" type="text" value=""  class="classinput_lsize"  />
						</td>
						<td>
							Feuille de style: <br />
							<input name="mail_css_template" id="mail_css_template" type="file"  size="35" class="classinput_nsize"  />
							
						</td>
						<td style="text-align:right">
							Jeu de caractères:<br />
							<select name="mail_html_charset" id="mail_html_charset"  class="classinput_lsize" >
								<option value="iso-8859-1">Europe</option>
							</select>
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td class="undered_titre_config" colspan="4">Entête de l'email  :		</td>
					</tr>
					<tr>
						<td>
							Emplacement de l'image d'entête: <br />
							<input name="header_img_template" id="header_img_template" type="file"  size="35" class="classinput_nsize"  />
						</td>
						<td>
							Texte d'entête:<br />
              <textarea id="header_mail_template" name="header_mail_template" rows="3"  class="classinput_xsize"></textarea>
						</td>
						<td>
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td class="undered_titre_config" colspan="4">Pied de l'email  :		</td>
					</tr>
					<tr>
						<td>
							Emplacement de l'image de pied de page :<br />
							<input name="footer_img_template" id="footer_img_template" type="file"  size="35" class="classinput_nsize"  />
						</td>
						<td>
							Texte de pied de page:<br />
              <textarea id="footer_mail_template" name="footer_mail_template" rows="3"  class="classinput_xsize"></textarea>
						</td>
						<td style="text-align:right">
							<br /><br /><br />
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
						</td>
						<td>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	<br/>
	<?php 
	if ($mail_templates) {
		?>
		
		<div>
		<table style="width:100%">
			<tr class="smallheight">
				<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>	
			<tr>
				<td class="titre_config" colspan="4">Modèles d'email	</td>
			</tr>
		</table>
		</div>
		<?php
		$fleches_ascenseur=0;
		foreach ($mail_templates as $mail_template) {
			?>
			<table style="width:100%">
				<tr>
					<td style="width:100%">
						<form action="communication_mail_template_mod.php" method="post" id="communication_mail_template_mod_<?php echo $mail_template->id_mail_template;?>" name="communication_mail_template_mod_<?php echo $mail_template->id_mail_template;?>" target="formFrame" enctype="multipart/form-data" >
						<input name="id_mail_template" id="id_mail_template" type="hidden" value="<?php echo $mail_template->id_mail_template; ?>" />
           
				<table style="width:100%">
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td class="titre_config" colspan="4"><?php echo $mail_template->lib_mail_template;?></td>
					</tr>
					<tr>
						<td>
							Nom du modèle:<br />
							<input name="lib_mail_template_<?php echo $mail_template->id_mail_template;?>" id="lib_mail_template_<?php echo $mail_template->id_mail_template;?>" type="text" value="<?php echo $mail_template->lib_mail_template;?>"  class="classinput_lsize"  />
						</td>
						<td>
							Feuille de style: <br />
							<input name="mail_css_template_<?php echo $mail_template->id_mail_template;?>" id="mail_css_template_<?php echo $mail_template->id_mail_template;?>" type="file"  size="35" class="classinput_nsize"  />
							<?php if ($mail_template->mail_css_template) {?>
							<br />
							<a href="<?php echo $MAIL_TEMPLATES_CSS_DIR.$mail_template->mail_css_template;?>" target="_blank" style="font-weight:bolder; color: #996600">voir le fichier css</a> 
							<?php } ?>
							
						</td>
						<td style="text-align:right">
							Jeu de caractères:<br />
							<select name="mail_html_charset_<?php echo $mail_template->id_mail_template;?>" id="mail_html_charset_<?php echo $mail_template->id_mail_template;?>"  class="classinput_lsize" >
								<option value="iso-8859-1">Europe</option>
							</select>
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td class="undered_titre_config" colspan="4">Entête de l'email:		</td>
					</tr>
					<tr>
						<td>
							Emplacement de l'image d'entête: 
							<br />
							<input name="header_img_template_<?php echo $mail_template->id_mail_template;?>" id="header_img_template_<?php echo $mail_template->id_mail_template;?>" type="file"  size="35" class="classinput_nsize"  />
							<?php if ($mail_template->header_img_template) {?>
							<br />
							<a href="<?php echo $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->header_img_template;?>" target="_blank" style="font-weight:bolder; color: #996600">voir l'image actuelle</a> 
							<?php } ?>
						</td>
						<td>
							Texte d'entête:<br />
              <textarea id="header_mail_template_<?php echo $mail_template->id_mail_template;?>" name="header_mail_template_<?php echo $mail_template->id_mail_template;?>" rows="3"  class="classinput_xsize"><?php echo $mail_template->header_mail_template;?></textarea>
						</td>
						<td>
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td class="undered_titre_config" colspan="4">Pied de l'email  :		</td>
					</tr>
					<tr>
						<td>
							Emplacement de l'image de pied de page :
							<br />
							<input name="footer_img_template_<?php echo $mail_template->id_mail_template;?>" id="footer_img_template_<?php echo $mail_template->id_mail_template;?>" type="file"  size="35" class="classinput_nsize"  />
							<?php if ($mail_template->footer_img_template) {?>
							<br />
							<a href="<?php echo $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->footer_img_template;?>" target="_blank" style="font-weight:bolder; color: #996600">voir l'image actuelle</a> 
							<?php } ?>
							
						</td>
						<td>
							Texte de pied de page:<br />
              <textarea id="footer_mail_template_<?php echo $mail_template->id_mail_template;?>" name="footer_mail_template_<?php echo $mail_template->id_mail_template;?>" rows="3"  class="classinput_xsize"><?php echo $mail_template->footer_mail_template;?></textarea>
						</td>
						<td style="text-align:right">
						
							<img name="preview_<?php echo $mail_template->id_mail_template;?>" id="preview_<?php echo $mail_template->id_mail_template;?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/preview.gif" />
							
							<script type="text/javascript">
							Event.observe("preview_<?php echo $mail_template->id_mail_template; ?>", "click",  function(evt){
								Event.stop(evt); 
								page.traitecontent("communication_mail_template_preview","communication_mail_template_preview.php?id_mail_template=<?php echo $mail_template->id_mail_template; ?>", "true", "_blank");	
							}, false);
							</script>
							<br />
<br />

							<input name="modifier_<?php echo $mail_template->id_mail_template;?>" id="modifier_<?php echo $mail_template->id_mail_template;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
						</td>
						<td style="text-align:right"><br />
<br />

						<input name="link_communication_mail_template_sup_<?php echo $mail_template->id_mail_template;?>" id="link_communication_mail_template_sup_<?php echo $mail_template->id_mail_template;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-supprimer.gif" />
						</td>
					</tr>
				</table>
				</form>
				</td>
			</tr>
		</table>
				<form method="post" action="communication_mail_template_sup.php" id="communication_mail_template_sup<?php echo $mail_template->id_mail_template; ?>" name="communication_mail_template_sup<?php echo $mail_template->id_mail_template; ?>" target="formFrame">
					<input name="id_mail_template" id="id_mail_template" type="hidden" value="<?php echo $mail_template->id_mail_template; ?>" />
				</form>

				<script type="text/javascript">
				Event.observe("link_communication_mail_template_sup_<?php echo $mail_template->id_mail_template; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('communication_mail_template_sup', 'communication_mail_template_sup<?php echo $mail_template->id_mail_template; ?>');}, false);
				</script>

		<?php 
		$fleches_ascenseur++;
		}
	?>
	<?php 
	}
?>

	</div>
</div>
<script type="text/javascript">
new Form.EventObserver('communication_mail_template_add', function(){formChanged();});

<?php
foreach ($mail_templates as $mail_template) {
	?>
	new Form.EventObserver('communication_mail_template_mod_<?php echo $mail_template->id_mail_template;?>', function(){formChanged();});
	<?php
}
?>
//on masque le chargement
H_loading();
</SCRIPT>
</div>