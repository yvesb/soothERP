<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables ncessaires  l'affichage
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
tableau_smenu[1] = Array('communication_edition_newsletter','communication_edition_newsletter.php','true','sub_content', 'Edition d\'une newsletter');
update_menu_arbo();
</script>
<p class="titre">Edition d&apos;une newsletter</p>

<div  class="contactview_corps">
<div id="contact_ajout_content"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; padding:10px ">
<form id="communication_edition_newsletter_form" name="communication_edition_newsletter_form" method="post" action="communication_edition_newsletter_mod.php" target="formFrame">
<input type="hidden" name="id_newsletter" id="id_newsletter" value="<?php echo $id_newsletter ?>" />
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
					<td >
							<span >Libell&eacute; de la newsletter:</span>
					</td>
					<td>
						<input type="text" id="nom_newsletter" name="nom_newsletter" class="classinput_xsize" value="<?php echo $newsletter->getNom_newsletter() ?>" />
					</td>
					<td></td>
					<td >
						<span >P&eacute;riodicit&eacute;:</span>
					</td>
					<td>
						<span class="infobulle" id="periodicite_newsletter_info">
						<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
						<span>
						<p class="infotext">Indiquez une valeur num&eacute;rique</p>
						</span>
						</span>
						<input name="periodicite_newsletter" id="periodicite_newsletter" type="text"  class="classinput_lsize" size="4" value="<?php echo $newsletter->getPeriodicite() ?>"/> jour(s)
					</td>
				</tr>
				<tr>
					<td>
							<span >Description interne:</span>
					</td>
					<td>
						<textarea id="description_interne_newsletter" name="description_interne_newsletter" rows="2"  class="classinput_xsize"><?php echo $newsletter->getDescription_interne() ?></textarea>
					</td>
					<td></td>
					<td  >
							<span >Description publique:</span>
					</td>
					<td>
						<textarea id="description_publique_newsletter" name="description_publique_newsletter" rows="2"  class="classinput_xsize"><?php echo $newsletter->getDescription_publique() ?></textarea>
					</td>
				</tr>
				<tr>
					<td  >
							<span >Nom du mod&egrave;le d&apos;email:</span>
					</td>
					<td>
						<select id="id_mail_template_newsletter" name="id_mail_template_newsletter" class="classinput_xsize">
						<?php
						if(empty($mail_templates)) {
							?>
							<option value="0">Aucun template d&apos;email n&apos;a t dfini</option>
							<?php
						}
						else {
							?>
							<?php
							foreach ($mail_templates as $mail_template) {
								?>
								<option value="<?php echo $mail_template->id_mail_template?>" <?php if($mail_template->id_mail_template == $newsletter->getId_mail_Template()) { ?> selected="selected" <?php } ?>><?php echo $mail_template->lib_mail_template?></option>
								<?php
							}
						
						}
						?>
						</select>

					</td>
					<td></td>
					<td >
							<span >D&eacute;tail du mod&egrave;le:</span>
					</td>
					<td>
					<img name="preview" id="preview" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/preview.gif" style="cursor:pointer" />
					
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
							<span >Archives publiques:</span>
					</td>
					<td>
						<input type="radio" name="archives_publiques_newsletter" id="archives_publiques_newsletter" value="1" <?php if($newsletter->getArchives_publiques()) { ?> checked <?php } ?> />Oui
                                                <input type="radio" name="archives_publiques_newsletter" id="archives_publiques_newsletter" value="0" <?php if(!$newsletter->getArchives_publiques()) { ?> checked <?php } ?> />Non
					</td>
					<td> 
					</td>
					<td>
							<span >Inscription libre:</span>
					</td>
					<td>
						<input type="radio" name="inscription_libre_newsletter" id="inscription_libre_newsletter" value="1" <?php if($newsletter->getInscription_libre()) { ?> checked <?php } ?> />Oui
						<input type="radio" name="inscription_libre_newsletter" id="inscription_libre_newsletter" value="0" <?php if(!$newsletter->getInscription_libre()) { ?> checked <?php } ?> />Non
					</td>
				</tr>
				<tr>
					<td  >
							<span >Nom de l&apos;exp&eacute;diteur:</span>
					</td>
					<td>
						<input type="text" id="nom_expediteur_newsletter" name="nom_expediteur_newsletter" class="classinput_xsize" value="<?php echo $newsletter->getNom_expediteur() ?>"/>
					</td>
					<td  >
					</td>
					<td  >
					</td>
					<td  >
					</td>
				</tr>
				<tr>
					<td  >
							<span >Email de l&apos;exp&eacute;diteur:</span>
					</td>
					<td>
						<input type="text" id="mail_expediteur_newsletter" name="mail_expediteur_newsletter" class="classinput_xsize" value="<?php echo $newsletter->getMail_expediteur() ?>"/>
					</td>
					<td></td>
					<td  >
							<span >Email de retour:</span>
					</td>
					<td>
						<input type="text" id="mail_retour_newsletter" name="mail_retour_newsletter" class="classinput_xsize"  value="<?php echo $newsletter->getMail_retour() ?>"/>
					</td>
				</tr>
				<tr>
					<td  >
							<span >Titre de l&apos;email d&apos;inscription:</span>
					</td>
					<td>
						<input type="text" id="mail_inscription_titre_newsletter" name="mail_inscription_titre_newsletter" class="classinput_xsize" value="<?php echo $newsletter->getMail_inscription_titre() ?>"/>
					</td>
					<td></td>
					<td>
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td >
							<span >Corps de l&apos;email d&apos;inscription:</span>
					</td>
					<td colspan="4">
						<textarea id="mail_inscription_corps_newsletter" name="mail_inscription_corps_newsletter" rows="6"  class="classinput_xsize"><?php echo $newsletter->getMail_inscription_corps() ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<p class="titre_config">Critères par profils</p>
					</td>
				</tr>
				<tr>
					<td>
						<span >Profils destinataires:</span>
					</td>
					<td colspan="4">
						<div id="divprofil">
						<table width="100%">
							<tr>
								<td>
									<?php
									foreach ($_SESSION['profils'] as $profil) {
										if (!$profil->getId_profil()) { continue; }
										?>
										<span>
										<input type="checkbox" value="<?php echo $profil->getId_profil();?>" id="profils<?php echo $profil->getId_profil();?>" name="profils<?php echo $profil->getId_profil();?>"  <?php if(array_search($profil->getId_profil(),$newsletter_profils)!== false) {?> checked="checked" <?php } ?> />
										<?php echo htmlentities($profil->getLib_profil());?>
										</span>
										<script type="text/javascript">
											Event.observe('profils<?php echo $profil->getId_profil();?>', "click" , function(evt){ 
												
												affiche_newsletter_profil_edition('<?php echo $profil->getId_profil();?>','<?php echo $id_newsletter;?>');
											} , false);
											
											<?php if(array_search($profil->getId_profil(),$newsletter_profils)!== false) {?> 
											affiche_newsletter_profil_edition('<?php echo $profil->getId_profil();?>','<?php echo $id_newsletter;?>'); 
											<?php } ?>
										</script>
										<br />
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
					<div id="zoneprofils">
					</div>
					</td>
				</tr>
				<tr>
					<td colspan="5" >
					<br />
						
					<table style="width:100%">
						<tr>
							<td style="width:48%; text-align:left">
								<p class="titre_config">Envoyer à:</p>
								<table>
									<tr>
										<td>Nom:<br />
										<input type="text" name="envoyer_a_nom" id="envoyer_a_nom" value="" class="classinput_xsize" />
										</td>
										<td>Email:<br />
										<input type="text" name="envoyer_a_email" id="envoyer_a_email" value="" class="classinput_xsize" />
										</td>
										<td><br />
										<img id="ajouter_inscrit" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" border="0" style="cursor:pointer">
										</td>
									</tr>
								</table>
								
								<br /><br />

								<div id="liste_envoyer_a_email">
									<?php 
									$serialisation_envoyer_a	=	0;
									foreach ($envoyer_a as $e_a) {
										?>
										<li id="envoyer_a_<?php echo $serialisation_envoyer_a?>">
										<table style="width:100%;">
										<tr>
										<td style="width:95%; text-align:left;">
											<?php echo $e_a->nom;?> - <?php echo $e_a->email;?>
										</td>
										<td style="width:5%; text-align:right;">
											<a href="#" id="envoyer_a_del_<?php echo $serialisation_envoyer_a; ?>">
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
											</a>
										</td>
										</tr>
										</table>
										<script type="text/javascript">
										Event.observe("envoyer_a_del_<?php echo $serialisation_envoyer_a?>", "click", function(evt){ alerte.confirm_supprimer_tag_and_callpage("envoyer_a_del", "envoyer_a_<?php echo $serialisation_envoyer_a?>",																			"communication_edition_newsletter_del_inscrit.php?email=<?php echo urlencode($e_a->email);?>&id_newsletter=<?php echo $id_newsletter; ?>");	Event.stop(evt);});
										</script>
										</li>
										<?php
									$serialisation_envoyer_a++;
									}
									?>
								</div>	
								
								<br />
								
								<a class="common_link" href="communication_edition_newsletter_cvs.php?id_newsletter=<?php echo $id_newsletter; ?>" target="_blank">Liste des inscrits au format csv</a>
								<input type="hidden" id="serialisation_envoyer_a" name="serialisation_envoyer_a" value="<?php echo $serialisation_envoyer_a;?>"/>
								<script type="text/javascript">
																	
								//observer le focus pour vider le champs
								Event.observe('envoyer_a_email', "focus", function(evt){$("envoyer_a_email").value="";}, false);
								Event.observe('envoyer_a_nom', "focus", function(evt){$("envoyer_a_nom").value="";}, false);					
								
								
								function envoyer_a_if_Key_RETURN (evt) {
								
									var id_field = Event.element(evt);
									var field_value = id_field.value;
									var key = evt.which || evt.keyCode; 
									switch (key) {   
									case Event.KEY_RETURN:     
									
									Event.stop(evt);
									break;   
									}
								}
								
								Event.observe('envoyer_a_email', "keypress", function(evt){envoyer_a_if_Key_RETURN (evt);});
								Event.observe('envoyer_a_nom', "keypress", function(evt){envoyer_a_if_Key_RETURN (evt);});
								
								Event.observe('ajouter_inscrit', "click", function(evt){
										Event.stop(evt); 
										if (checkmail ($("envoyer_a_email").value) && $("envoyer_a_nom").value != "") {
											var AppelAjax = new Ajax.Updater(
																			"liste_envoyer_a_email", 
																			"communication_edition_newsletter_add_inscrit.php", {
																			method: 'post',
																			asynchronous: true,
																			contentType:  'application/x-www-form-urlencoded',
																			encoding:     'UTF-8',
																			parameters: { email: $("envoyer_a_email").value, nom: $("envoyer_a_nom").value, id_newsletter: "<?php echo $id_newsletter;?>", inscrit: "1", serialisation: $("serialisation_envoyer_a").value },
																			evalScripts:true, 
																			insertion: Insertion.Top,
																			onLoading:S_loading, onException: function () {S_failure();}, 
																			onComplete: function () {H_loading(); $("serialisation_envoyer_a").value = parseInt($("serialisation_envoyer_a").value)+1;}
																			}
																			);
										} else {
										alerte.alerte_erreur ('Erreur de saisie', 'Veuillez indiquer un nom et un Email valide.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
										
										}
										}, false);
								
								</script>
							</td>
							<td style="width:4%;">&nbsp;
							</td>
							<td style="width:48%; text-align:left">
								<p class="titre_config">Ne pas envoyer à:</p>
								<table>
									<tr>
										<td>Nom:<br />
										<input type="text" name="refuser_a_nom" id="refuser_a_nom" value="" class="classinput_xsize" />
										</td>
										<td>Email:<br />
										<input type="text" name="refuser_a_email" id="refuser_a_email" value="" class="classinput_xsize" />
										</td>
										<td><br />
										<img id="ajouter_inscrit_r" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" border="0" style="cursor:pointer">
										</td>
									</tr>
								</table>
								<br /><br />

								<div id="liste_refuser_a_email">
									<?php 
									$serialisation_refuser_a	=	0;
									foreach ($refuser_a as $r_a) {
										?>
										<li id="refuser_a_<?php echo $serialisation_refuser_a?>">
										<table style="width:100%;">
										<tr>
										<td style="width:95%; text-align:left;">
											<?php echo $r_a->nom;?> - <?php echo $r_a->email;?>
										</td>
										<td style="width:5%; text-align:right;">
											<a href="#" id="refuser_a_del_<?php echo $serialisation_refuser_a?>">
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
											</a>
										</td>
										</tr>
										</table>
										<script type="text/javascript">
										Event.observe("refuser_a_del_<?php echo $serialisation_refuser_a?>", "click", function(evt){ alerte.confirm_supprimer_tag_and_callpage("envoyer_a_del", "refuser_a_<?php echo $serialisation_refuser_a?>",																			"communication_edition_newsletter_del_inscrit.php?email=<?php echo urlencode($r_a->email);?>&id_newsletter=<?php echo $id_newsletter; ?>");	Event.stop(evt);});
										</script>
										</li>
										<?php
									$serialisation_refuser_a++;
									}
									?>
								</div>	
								<input type="hidden" id="serialisation_refuser_a" name="serialisation_refuser_a" value="<?php echo $serialisation_refuser_a;?>"/>
								<script type="text/javascript">
								//observer le focus pour vider le champs
								Event.observe('refuser_a_email', "focus", function(evt){$("refuser_a_email").value="";});
								Event.observe('refuser_a_nom', "focus", function(evt){$("refuser_a_nom").value="";});
								
							
								
								Event.observe('refuser_a_email', "keypress", function(evt){envoyer_a_if_Key_RETURN (evt);});
								Event.observe('refuser_a_nom', "keypress", function(evt){envoyer_a_if_Key_RETURN (evt);});
								
								
								Event.observe('ajouter_inscrit_r', "click", function(evt){
										Event.stop(evt); 
										if (checkmail ($("refuser_a_email").value) && $("refuser_a_nom").value != "") {
											var AppelAjax = new Ajax.Updater(
																			"liste_refuser_a_email", 
																			"communication_edition_newsletter_add_inscrit.php", {
																			method: 'post',
																			asynchronous: true,
																			contentType:  'application/x-www-form-urlencoded',
																			encoding:     'UTF-8',
																			parameters: { email: $("refuser_a_email").value, nom: $("refuser_a_nom").value, id_newsletter: "<?php echo $id_newsletter;?>", inscrit: "0", serialisation: $("serialisation_refuser_a").value },
																			evalScripts:true, 
																			insertion: Insertion.Top,
																			onLoading:S_loading, onException: function () {S_failure();}, 
																			onComplete: function () {H_loading(); $("serialisation_refuser_a").value = parseInt($("serialisation_refuser_a").value)+1;}
																			}
																			);
										} else {
										alerte.alerte_erreur ('Erreur de saisie', 'Veuillez indiquer un nom et un Email valide.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
										}
								});
								
								</script>
							</td>
						</tr>
					</table>

					
					</td>
				</tr>
			</table>
			<p style="text-align:right">
			<table align="right">
				 <tr>
						<td><input type="image" name="Submit" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/></td>
						<td><a href="#communication_newsletters.php"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/></a></td>
				 </tr>
			</table>
			</p>
		</td>
	</tr>
</table>
</form>
    <a href="javascript:void()" style="text-decoration:none;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" border="0" alt="ajouter" id ="importnews_csv"/></a><a class="common_link" href="javascript:void()" id="import_news_csv">Importer liste d'inscrits au format csv</a>
								<div id="upld_news_csv" style="display:none">
								<form method="POST" action="communication_newsletter_import_inscrit_csv.php" name="form_import_news" enctype="multipart/form-data" target="formFrame">
								   <table>
								   <br />
								   <tr>
								   		Type de formatage des données : 
								    	<td>
								    		<select name="format_csv">
								    			<option name="format_1">email;nom</option>
								    			<option name="format_2">nom;email</option>
								    		</select>
								    	</td>	
								    	<br />
								    	<br />
								  </tr>
								  <tr>
								  	Indiquez l'emplacement de votre fichier :
								    <td>
								    	<input type="file" name="liste_csv" accept="text/csv" class="classinput_xsize"/>
                                		<input type="hidden" name="id_news" value="<?php echo $id_newsletter; ?>"/>
								    </td>
								    <td>
								        <input type="submit" value="Valider" name="import_news_sub"/>
								    </td>
								 </tr>
								</table>
							</form>
							<br />
							</div>
<br />


</div>
</div>

<script type="text/javascript" language="javascript">
// Afficher import fichier csv

Event.observe('importnews_csv', "click", function(){$("upld_news_csv").show();});
Event.observe('import_news_csv', "click", function() {$("upld_news_csv").show();});
 
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
//new Form.EventObserver('communication_nouvelle_newsletter_form', formChanged);


//on masque le chargement
H_loading();

// ]]>
</script>
