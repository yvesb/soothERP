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

<script type="text/javascript" language="javascript">
tableau_smenu[0] = Array('smenu_communication', 'smenu_communication.php' ,'true' , 'sub_content', 'Communication');
tableau_smenu[1] = Array('communication_nouvelle_newsletter','communication_nouvelle_newsletter.php','true','sub_content', 'Création d\'une nouvelle newsletter');
update_menu_arbo();
</script>
<p class="titre">Cr&eacute;ation d&apos;une nouvelle newsletter</p>

<div  class="contactview_corps">
<div id="contact_ajout_content"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; padding:10px ">
<form id="communication_nouvelle_newsletter_form" name="communication_nouvelle_newsletter_form" method="post" action="communication_nouvelle_newsletter_create.php" target="formFrame">
<table class="max96pc">
	<tr>
		<td>
			<table class="minimizetable">
				<tr class="smallheight">
					<td style=" width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style=" width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style=" width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style=" width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style=" width:28%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td  >
							<span class="labelled_ralonger">Libell&eacute; de la newsletter:</span>
					</td>
					<td>
						<input type="text" id="nom_newsletter" name="nom_newsletter" class="classinput_xsize"/>
					</td>
					<td>
					</td>
					<td >
						<span class="labelled_ralonger">P&eacute;riodicit&eacute;:</span>
					</td>
					<td>
						<span class="infobulle" id="periodicite_newsletter_info">
						<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
						<span>
						<p class="infotext">Indiquez une valeur num&eacute;rique</p>
						</span>
						</span>
						<input name="periodicite_newsletter" id="periodicite_newsletter" type="text"  class="classinput_lsize" size="4" value="30"/> jour(s)
					</td>
				</tr>
				<tr>
					<td  >
							<span class="labelled_ralonger">Description interne:</span>
					</td>
					<td>
						<textarea id="description_interne_newsletter" name="description_interne_newsletter" rows="2"  class="classinput_xsize"></textarea>
					</td>
					<td>
					</td>
					<td  >
							<span class="labelled_ralonger">Description publique:</span>
					</td>
					<td>
						<textarea id="description_publique_newsletter" name="description_publique_newsletter" rows="2"  class="classinput_xsize"></textarea>
					</td>
				</tr>
				<tr>
					<td  >
						<span class="labelled_ralonger">Nom du mod&egrave;le d&apos;email:</span>
					</td>
					<td>
						<select id="id_mail_template_newsletter" name="id_mail_template_newsletter" class="classinput_xsize">
						<?php
						if(empty($mail_templates)) {
							?>
							<option value="0">Aucun template d&apos;email n&apos;a été défini</option>
						<?php
						}else {
						?>
							<option value="0">- Choisir le nom du mod&egrave;le d&apos;email -</option>
							<?php
							foreach ($mail_templates as $mail_template) {
								?>
								<option value="<?php echo $mail_template->id_mail_template?>"><?php echo $mail_template->lib_mail_template?></option>
								<?php
							}
							?>
							
							<?php
						}
						?>
						</select>

					</td>
					<td></td>
					<td  >
							<span class="labelled_ralonger">D&eacute;tail du mod&egrave;le:</span>
					</td>
					<td>
						
					<img name="preview" id="preview" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/preview.gif" style="display:none; cursor:pointer" />
					
					<script type="text/javascript">
					Event.observe("preview", "click",  function(evt){
						Event.stop(evt); 
						page.traitecontent("communication_mail_template_preview","communication_mail_template_preview.php?id_mail_template="+$("id_mail_template_newsletter").options[$("id_mail_template_newsletter").selectedIndex].value, "true", "_blank");	
					}, false);
					</script>
					</td>
				</tr>
				<tr>
					<td  >
							<span class="labelled_ralonger">Archives publiques:</span>
					</td>
					<td>
						<input type="radio" name="archives_publiques_newsletter" id="archives_publiques_newsletter" value="1" checked="checked"> Oui
						<input type="radio" name="archives_publiques_newsletter" id="archives_publiques_newsletter" value="0" /> Non
					</td>
					<td></td>
					<td  >
							<span class="labelled_ralonger">Inscription libre:</span>
					</td>
					<td>
						<input type="radio" name="inscription_libre_newsletter" id="inscription_libre_newsletter" value="1" checked="checked" /> Oui
						<input type="radio" name="inscription_libre_newsletter" id="inscription_libre_newsletter" value="0" /> Non
					</td>
				</tr>
				<tr>
					<td  >
							<span class="labelled_ralonger">Nom de l&apos;exp&eacute;diteur:</span>
					</td>
					<td>
						<input type="text" id="nom_expediteur_newsletter" name="nom_expediteur_newsletter" class="classinput_xsize" value="<?php echo str_replace("\n", " ", $contact->getNom());?>" />
					</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td  >
							<span class="labelled_ralonger">Email de l&apos;exp&eacute;diteur:</span>
					</td>
					<td>
						<input type="text" id="mail_expediteur_newsletter" name="mail_expediteur_newsletter" class="classinput_xsize" value="<?php echo $email_entreprise ?>" />
					</td>
					<td></td>
					<td  >
							<span class="labelled_ralonger">Email de retour:</span>
					</td>
					<td>
						<input type="text" id="mail_retour_newsletter" name="mail_retour_newsletter" class="classinput_xsize" value="<?php echo $email_entreprise ?>">
					</td>
				</tr>
				<tr>
					<td  >
							<span class="labelled_ralonger">Titre de l&apos;email d&apos;inscription:</span>
					</td>
					<td>
						<input type="text" id="mail_inscription_titre_newsletter" name="mail_inscription_titre_newsletter" class="classinput_xsize" />
					</td>
					<td></td>
					<td  >
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td  >
							<span class="labelled_ralonger">Corps de l&apos;email d&apos;inscription:</span>
					</td>
					<td colspan="4">
						<textarea id="mail_inscription_corps_newsletter" name="mail_inscription_corps_newsletter" rows="6"  class="classinput_xsize"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<p class="titre_config">Critères par profils</p>
					</td>
				</tr>
				<tr>
					<td>
						<span class="labelled_ralonger">Profils destinataires:</span>
					</td>
					<td colspan="4" >
						<div id="divprofil">
						<table width="100%">
							<tr>
								<td>
									<?php
									foreach ($_SESSION['profils'] as $profil) {
										if (!$profil->getId_profil()) { continue; }
										?>
										<span><input onclick="affiche_newsletter_profil_nvl('<?php echo $profil->getId_profil();?>');" type="checkbox" value="<?php echo $profil->getId_profil();?>" id="profils<?php echo $profil->getId_profil();?>" name="profils<?php echo $profil->getId_profil();?>" /><?php echo htmlentities($profil->getLib_profil());?></span><br />
										<?php
									}
									?>
								</td>
							</tr>
						</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="5">
					<div id="zoneprofils"></div>
					</td>
					
				</tr>
			</table>
			<p style="text-align:right">
				<input type="image" name="Submit" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"/>&nbsp;&nbsp;
			</p>
		</td>
	</tr>
</table>
<p>&nbsp;</p>
<br />

</form>
<br />


</div>
</div>

<script type="text/javascript" language="javascript">
// <![CDATA[

Position.includeScrollOffsets = true;

Event.observe('id_mail_template_newsletter', "change" , function(evt){
	Event.stop(evt);
	if ($("id_mail_template_newsletter").options[$("id_mail_template_newsletter").selectedIndex].value == "0") {
		$("preview").hide();
	} else {$("preview").show();}
} , false);

Event.observe('periodicite_newsletter', "blur" , function(evt){ Event.stop(evt); nummask(evt, "0", "X");} , false);

new Event.observe("periodicite_newsletter", "mouseover", function(){$("periodicite_newsletter_info").style.display = "block";}, false);

new Event.observe("periodicite_newsletter", "mouseout", function(){$("periodicite_newsletter_info").style.display = "none";}, false);


new Form.EventObserver('communication_nouvelle_newsletter_form', formChanged);

Event.observe('communication_nouvelle_newsletter_form', "submit" , function(evt){
	if($("id_mail_template_newsletter").selectedIndex=="0") {
		Event.stop(evt);
		alerte.alerte_erreur('Ajout impossible','Vous devez sélectionner au moins un modèle d\'email','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	}
	$("id_mail_template_newsletter").focus();
} , false);



//on masque le chargement
H_loading();

// ]]>
</script>