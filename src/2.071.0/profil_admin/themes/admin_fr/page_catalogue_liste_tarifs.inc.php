<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("tarifs_liste");
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
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liste_tarifs_assistant.inc.php" ?>
<div class="emarge">

<p class="titre">Grille Tarifaire. </p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td>
<div id="liste_tarifs" style=" padding-left:10px; padding-right:10px">

	
	<p>Ajouter un tarif</p>
	<table>
		<tr class="smallheight">
			<td>
				<table>
					<tr class="smallheight">
						<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Description Tarif:</span>
						</td>
						<td ><span class="labelled">Marge moyenne:</span>
						</td>
						<td>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:55px">
			</td>
			<td style="width:12px">
			</td>
		</tr>
	</table>
	<div class="caract_table">
	<table>
		<tr class="smallheight">
			<td>
				<form action="catalogue_liste_tarifs_add.php" method="post" id="catalogue_liste_tarifs_add" name="catalogue_liste_tarifs_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_tarif" id="lib_tarif" type="text" value=""  class="classinput_lsize"/>
						<input name="ajout_tarif" id="ajout_tarif" type="hidden" value="1"/>
						</td>
						<td>
							<textarea name="desc_tarif" rows="2" class="classinput_lsize" id="desc_tarif"></textarea>
						</td>
						<td>
						<input name="marge_moyenne" id="marge_moyenne" value="" type="hidden"  class="classinput_hsize"/>
						<div id="aff_formule_tarif" style="cursor:pointer" class="classinput_lsize">Cr&eacute;er une formule de base</div>
						</td>
						<td>
							<p style="text-align:right">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</p>
						</td>

					</tr>
				</table>
				</form>
			</td>
			<td style="width:55px">
			</td>
			<td style="width:12px">
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php 
	if ($tarifs_liste) {
	?>
	<p>Liste des tarifs </p>
	<table>
		<tr class="smallheight">
			<td>
				<table>
					<tr class="smallheight">
						<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:32%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Description Tarif:</span>
						</td>
						<td ><span class="labelled">Marge moyenne:</span>
						</td>
						<td></td>
					</tr>
				</table>
			</td>
			<td style="width:55px">
			</td>
			<td style="width:12px">
			</td>
		</tr>
	</table>
	<?php 
	}
	$fleches_ascenseur=0;
	foreach ($tarifs_liste as $tarif_liste) {
	?>
	<div class="caract_table" id="tarif_table_<?php echo $tarif_liste->id_tarif; ?>">
		<table>
		<tr>
			<td>
				<form action="catalogue_liste_tarifs_mod.php" method="post" id="catalogue_liste_tarifs_mod_<?php echo $tarif_liste->id_tarif; ?>" name="catalogue_liste_tarifs_mod_<?php echo $tarif_liste->id_tarif; ?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input id="lib_tarif_<?php echo $tarif_liste->id_tarif; ?>" name="lib_tarif_<?php echo $tarif_liste->id_tarif; ?>" type="text" value="<?php echo htmlentities($tarif_liste->lib_tarif); ?>"  class="classinput_lsize"/>
			<input name="id_tarif" id="id_tarif" type="hidden" value="<?php echo $tarif_liste->id_tarif; ?>" />
							
						</td>
						<td>
							<textarea id="desc_tarif_<?php echo $tarif_liste->id_tarif; ?>" name="desc_tarif_<?php echo $tarif_liste->id_tarif; ?>" rows="2" class="classinput_lsize" ><?php echo htmlentities($tarif_liste->desc_tarif); ?></textarea>
						</td>
						<td>
						<input id="marge_moyenne_<?php echo $tarif_liste->id_tarif; ?>" name="marge_moyenne_<?php echo $tarif_liste->id_tarif; ?>" value="<?php echo htmlentities($tarif_liste->marge_moyenne); ?>" type="hidden"  class="classinput_hsize"/>
						<div id="aff_formule_tarif_<?php echo $tarif_liste->id_tarif; ?>" style="cursor:pointer"><?php echo htmlentities($tarif_liste->marge_moyenne); ?></div>
						</td>
						<td>
							<p style="text-align:right">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td style="width:55px; text-align:center">
		<form method="post" action="catalogue_liste_tarifs_sup.php" id="catalogue_liste_tarifs_sup_<?php echo $tarif_liste->id_tarif; ?>" name="catalogue_liste_tarifs_sup_<?php echo $tarif_liste->id_tarif; ?>" target="formFrame">
			<input name="id_tarif" id="id_tarif" type="hidden" value="<?php echo $tarif_liste->id_tarif; ?>" />
			<input name="id_tarif_remplacement_<?php echo $tarif_liste->id_tarif; ?>" id="id_tarif_remplacement_<?php echo $tarif_liste->id_tarif; ?>" type="hidden" value="" />
			
		</form>
		<a href="#" id="liste_tarif_sup_<?php echo $tarif_liste->id_tarif; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
		<script type="text/javascript">
		Event.observe('liste_tarif_sup_<?php echo $tarif_liste->id_tarif; ?>', 'click',  function(evt){Event.stop(evt); alerte_sup_grille_tarif ('Suppression d\'un tarif', 'Confirmez la suppression d\'un tarif<br/>S&eacute;lectionnez une grille tarifaire de remplacement s.v.p.<br /><select id="id_tarif_sup" name="id_tarif_sup" class="classinput_lsize"><option value=""></option><?php 
							foreach ($tarifs_liste as $tarif_liste_b) {
								if ($tarif_liste->id_tarif != $tarif_liste_b->id_tarif) {
								?><option value="<?php echo $tarif_liste_b->id_tarif; ?>"><?php echo addslashes(htmlentities($tarif_liste_b->lib_tarif)); ?></option><?php 
								}
							}
							?></select>', '<input type="submit" name="bouton1" id="bouton1" value="Confirmez la suppression" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />', 'catalogue_liste_tarifs_sup_<?php echo $tarif_liste->id_tarif; ?>', 'id_tarif_sup', 'id_tarif_remplacement_<?php echo $tarif_liste->id_tarif; ?>');		},false); 
							
		</script>
			</td>
			<td style="width:12px">
				<table cellspacing="0">
					<tr>
						<td>
							<div id="up_arrow_<?php echo $tarif_liste->id_tarif; ?>">
							<?php
							if ($fleches_ascenseur!=0) {
							?>
							<form action="catalogue_liste_tarifs_ordre.php" method="post" id="catalogue_liste_tarifs_ordre_<?php echo $tarif_liste->id_tarif; ?>" name="catalogue_liste_tarifs_ordre_<?php echo $tarif_liste->id_tarif; ?>" target="formFrame">
								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($tarifs_liste[$fleches_ascenseur-1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($tarif_liste->ordre)?>" />								
								<input name="modifier_ordre_<?php echo $tarif_liste->id_tarif; ?>" id="modifier_ordre_<?php echo $tarif_liste->id_tarif; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
							</form>
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
						<div id="down_arrow_<?php echo $tarif_liste->id_tarif; ?>">
							<?php
							if ($fleches_ascenseur!=count($tarifs_liste)-1) {
							?>
							<form action="catalogue_liste_tarifs_ordre.php" method="post" id="catalogue_liste_tarifs_ordre_<?php echo $tarif_liste->id_tarif; ?>" name="catalogue_liste_tarifs_ordre_<?php echo $tarif_liste->id_tarif; ?>" target="formFrame">

								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($tarifs_liste[$fleches_ascenseur+1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($tarif_liste->ordre)?>" />								
								<input name="modifier_ordre_<?php echo $tarif_liste->id_tarif; ?>" id="modifier_ordre_<?php echo $tarif_liste->id_tarif; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
							</form>
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
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php
	
	$fleches_ascenseur++;
	}
	?>
</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">

new Form.EventObserver('catalogue_liste_tarifs_add', function(element, value){formChanged();});

Event.observe('aff_formule_tarif', "click", function(evt){Event.stop(evt);  $('pop_up_assistant_tarif').style.display='block'; $('pop_up_assistant_tarif_iframe').style.display='block'; $('assistant_cellule').value='';
 if ($("marge_moyenne").value != "") {edition_formule_tarifaire ("marge_moyenne");} });

<?php 
	foreach ($tarifs_liste as $tarif_liste) {
?>
Event.observe('aff_formule_tarif_<?php echo $tarif_liste->id_tarif; ?>', "click", function(evt){Event.stop(evt);  $('pop_up_assistant_tarif').style.display='block'; $('pop_up_assistant_tarif_iframe').style.display='block'; $('assistant_cellule').value='_<?php echo $tarif_liste->id_tarif; ?>'; edition_formule_tarifaire ("marge_moyenne_<?php echo $tarif_liste->id_tarif; ?>"); });

new Form.EventObserver('catalogue_liste_tarifs_mod_<?php echo $tarif_liste->id_tarif; ?>', function(element, value){formChanged();});

<?php
	}
?>
//centrage de l'assistant tarif

centrage_element("pop_up_assistant_tarif");
centrage_element("pop_up_assistant_tarif_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_tarif_iframe");
centrage_element("pop_up_assistant_tarif");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>