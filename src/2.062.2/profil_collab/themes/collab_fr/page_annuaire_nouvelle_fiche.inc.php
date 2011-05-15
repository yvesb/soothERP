<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "ANNUAIRE_CATEGORIES", "DEFAUT_ID_PAYS", "listepays", "civilites");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************	



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript" language="javascript">
id_index_contentcoord=0;
</script>
<div class="emarge">
<div style="display:none">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_nouvelle_fiche_caiu_vide.inc.php" ?>
</div>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>

<p class="titre">Cr&eacute;ation d'un nouveau contact </p>

<div  class="contactview_corps">
<div id="contact_ajout_content"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; padding:10px ">
<form id="annu_nvlfiche_nouvelle_fiche_form" name="annu_nvlfiche_nouvelle_fiche_form" method="post" action="annuaire_nouvelle_fiche_create.php" target="formFrame">
<table class="max96pc">
	<tr>
		<td class="ctpc">
			<table class="minimizetable">
				<tr class="smallheight">
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td  class="size_strict">
							<span class="labelled_ralonger">Cat&eacute;gorie:</span>
					</td>
					<td>
						<select id="id_categorie" name="id_categorie" class="classinput_xsize">";
							<?php 
							foreach ($ANNUAIRE_CATEGORIES as $categorie) {
								?>
								<option value="<?php echo $categorie->id_categorie?>"><?php echo htmlentities($categorie->lib_categorie)?></option>
								<?php
							}
							?>
							</select>
							<input name="compte_info"  id="compte_info" type="hidden" value="0" />
							<input name="create_contact"  id="create_contact" type="hidden" value="" />
							<input name="return_to_page"  id="return_to_page" type="hidden" value="" />
						</td>
					</tr>
					<tr>
						<td>
							<span class="labelled_ralonger">Civilit&eacute;:</span>
						</td>
						<td>
							<select name="civilite" id="civilite" class="classinput_xsize">
							<?php 
							foreach ($civilites as $civ) {
								?>
								<option value="<?php echo $civ->id_civilite ?>"><?php echo htmlentities($civ->lib_civ_court)?></option>
								<?php 
							}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<span class="labelled_ralonger">Nom:</span>
						</td>
						<td>
						<textarea id="nom" name="nom" rows="2"  class="classinput_xsize"></textarea>
						</td>
					</tr>
					<tr id="line_siret" style="display:none">
						<td>
							<span class="labelled_ralonger" title="Numéro de Siret">Siret:</span>
						</td>
						<td>
						<input type="text" id="siret" name="siret" rows="2"  class="classinput_xsize"/>
						</td>
					</tr>
					<tr id="line_tva_intra" style="display:none">
						<td>
							<span class="labelled_ralonger" title="Numéro de TVA intracommunautaire">TVA intra.:</span>
						</td>
						<td>
						<input type="text" id="tva_intra" name="tva_intra" rows="2"  class="classinput_xsize"/>
						</td>
					</tr>
					<tr>
						<td>
							<span class="labelled_ralonger">Profil de la fiche:</span>
						</td>
						<td><div id="divprofil">
							<table width="100%">
								<tr>
									<td>
										<?php
										foreach ($_SESSION['profils'] as $profil) {
											if (!$profil->getId_profil()) { continue; }
											if ($profil->getActif() != 1) { continue; }
											
											?>
											<span><input onclick="affiche_annu_nvlf_profil('<?php echo $profil->getId_profil();?>');" type=checkbox value="<?php echo $profil->getId_profil();?>" id="profils<?php echo $profil->getId_profil();?>" <?php 
									
									//permission (7) Gestion des collaborateurs
									if (!$_SESSION['user']->check_permission ("7") && $profil->getId_profil() == $COLLAB_ID_PROFIL) { echo 'disabled="disabled"'; }
									//permission (8) Gestion des Administrateurs
									if (!$_SESSION['user']->check_permission ("8") && $profil->getId_profil() == $ADMIN_ID_PROFIL) { echo 'disabled="disabled"'; }
									
									
									?> name="profils[<?php echo $profil->getId_profil();?>]"><?php echo htmlentities($profil->getLib_profil());?></span><br />

								
											<?php
										}
										?>		
										<div id="divprofil_sec">
										<?php
										foreach ($_SESSION['profils'] as $profil) {
											if (!$profil->getId_profil()) { continue; }
											if ($profil->getActif() != 2) { continue; }
											?>
											<span><input onclick="affiche_annu_nvlf_profil('<?php echo $profil->getId_profil();?>');" type=checkbox value="<?php echo $profil->getId_profil();?>" id="profils<?php echo $profil->getId_profil();?>"<?php 
									
									//permission (7) Gestion des collaborateurs
									if (!$_SESSION['user']->check_permission ("7") && $profil->getId_profil() == $COLLAB_ID_PROFIL) { echo 'disabled="disabled"'; }
									//permission (8) Gestion des Administrateurs
									if (!$_SESSION['user']->check_permission ("8") && $profil->getId_profil() == $ADMIN_ID_PROFIL) { echo 'disabled="disabled"'; }
									
									
									?> name="profils[<?php echo $profil->getId_profil();?>]"><?php echo htmlentities($profil->getLib_profil());?></span><br />
											<?php
										}
										?>	
										<div id="moins_profil"><a href="#" id="moins_profil_link"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/moins.gif" />Moins de profils</a></div>
										</div>
											<script type="text/javascript">
											Event.observe("moins_profil_link", "click",  function(evt){Event.stop(evt); showform ('plus_profil', 'divprofil_sec');}, false);
											</script>
										<div id="plus_profil"><a href="#" id="plus_profil_link"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />Plus de profils</a></div>
											<script type="text/javascript">
											Event.observe("plus_profil_link", "click",  function(evt){Event.stop(evt); showform ('divprofil_sec', 'plus_profil');}, false);
											</script>
									</td>
								</tr>
							</table>
		</div>
						</td>
					</tr>
				</table>
				<div id="zoneprofils"></div>
				<hr class="bleu_liner" />
				<table class="minimizetable">
					<tr class="smallheight">
						<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td class="size_strict">
							<span class="labelled_ralonger">Note:</span>
						</td>
						<td>
							<textarea id="note" name="note" rows="4"  class="classinput_xsize"></textarea>
						</td>
					</tr>
				</table>
				<p style="text-align:right">
					<input type="image" name="Submit" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"/>&nbsp;&nbsp;
				</p>
			</td>
			<td style="width:3%">&nbsp;
			</td>
			<td class="ctpc">
				<div id="annu_nvlfiche_ajout_mob" >
				
				
				<div id="annu_nvlfiche_coord">
				<span class="sous_titre1">Coordonn&eacute;es</span>
				<ul  id="coordlist" style="padding: 2px; margin:0px;">
				</ul><br />
				<a href="#" class="ajout" id="link_add_new_coord">Ajouter une nouvelle coordonn&eacute;e</a></div>
				<br />
				<br />
				
				<div id="annu_nvlfiche_adresse">
				<span class="sous_titre1">Adresses</span>
				<ul id="adresslist" style="padding: 2px; margin:0px;">
				</ul><br />
				<a href="#" class="ajout" id="link_add_new_adresse">Ajouter une nouvelle adresse</a></div>
				<br />
				<br />
				
				<div id="annu_nvlfiche_internet">
				<span class="sous_titre1">Sites-Web</span>
				<ul  id="sitelist" style="padding: 2px; margin:0px;">
				</ul><br />
				<a href="#" class="ajout" id="link_add_new_site">Ajouter un nouveau site</a></div>
				</div>
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
if (return_to_page != "") {
	$("return_to_page").value = return_to_page;
}
Event.observe("link_add_new_adresse", "click",  function(evt){Event.stop(evt);createnewtagmobil('adresslist','li','adressecontent', 'annu_nvlfiche_ajout_mob');}, false);
Event.observe("link_add_new_coord", "click",  function(evt){Event.stop(evt);createnewtagmobil('coordlist','li','coordcontent', 'annu_nvlfiche_ajout_mob');}, false);
Event.observe("link_add_new_site", "click",  function(evt){Event.stop(evt); createnewtagmobil('sitelist','li','sitecontent', 'annu_nvlfiche_ajout_mob');}, false);

Position.includeScrollOffsets = true;
createnewtagmobil('adresslist','li','adressecontent', 'annu_nvlfiche_ajout_mob');
createnewtagmobil('coordlist','li','coordcontent', 'annu_nvlfiche_ajout_mob');
createnewtagmobil('sitelist','li','sitecontent', 'annu_nvlfiche_ajout_mob');


start_civilite("id_categorie", "civilite", "civilite.php?cat=");


Event.observe("id_categorie", "change",  function(evt){if ($("id_categorie").value != "1") {$("line_siret").show(); $("line_tva_intra").show();} else {$("line_siret").hide(); $("line_tva_intra").hide();}}, false);

new Form.EventObserver('annu_nvlfiche_nouvelle_fiche_form', formChanged);

function setheight_annuaire_add_fiche(){
set_tomax_height("contact_ajout_content" , -52);
}

Event.observe(window, "resize", setheight_annuaire_add_fiche, false);
setheight_annuaire_add_fiche();

//centrage du mini_moteur de recherche d'un contact

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});
//on masque le chargement
H_loading();

// ]]>
</script>