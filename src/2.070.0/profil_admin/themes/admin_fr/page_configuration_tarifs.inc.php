<?php

// *************************************************************************************************************
// CONFIG DES DONNEES tarifs
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);
global $TAXE_IN_PU;

//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('configuration_tarifs','configuration_tarifs.php' ,"true" ,"sub_content", "Paramètres tarifaires");
update_menu_arbo();
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liste_tarifs_assistant.inc.php" ?>
<div class="emarge">
<p class="titre">Paramètres tarifaires </p>

<div class="contactview_corps">
<form action="configuration_tarifs_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_tarifs_maj" name="configuration_tarifs_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Gestion des prix :		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Quel prix d'achat doit être pris en compte pour le calcul de la Valeur d'Achat Actuelle ?</td>
		<td>
		<select id="CALCUL_VAA" name="CALCUL_VAA" class="classinput_xsize">
		<?php 
		foreach ($CHOIX_CALCUL_VAA as $key=>$val) {
			?>
			<option value="<?php echo $key?>" <?php if ($CALCUL_VAA == $key) { echo 'selected="selected"';} ?>><?php echo $val?></option>
			<?php
		}
		?>
		</select>

		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Quelle est la durée maximale de validité d'un prix d'achat fournisseur ?</td>
		<td>

				<select name="DUREE_VALIDITE_PAF_an" id="DUREE_VALIDITE_PAF_an"  class="classinput_nsize">
					<?php
					for ($i = 0; $i<=27; $i++){
						?>
						<option value="<?php echo $i;?>" <?php
								if (floor($DUREE_VALIDITE_PAF/ (365)) == $i) {echo ' selected="selected"';}
						?>><?php echo  $i;?></option>
						<?php 
					}
					$reste = $DUREE_VALIDITE_PAF - (floor($DUREE_VALIDITE_PAF/ (365))*(365));
					?>
				</select> an(s)
				<select name="DUREE_VALIDITE_PAF_mois" id="DUREE_VALIDITE_PAF_mois"  class="classinput_nsize" >
					<?php
					for ($i = 0; $i<=12; $i++){
						?>
						<option value="<?php echo $i;?>" <?php
								if (floor($reste/ (30)) == $i) {echo ' selected="selected"';}
						?>><?php echo $i;?></option>
						<?php 
					}
					$reste = $reste - (floor($reste/ (30))*(30));
					?>
				</select> mois
				<select name="DUREE_VALIDITE_PAF_jour" id="DUREE_VALIDITE_PAF_jour"  class="classinput_nsize" >
					<?php
					for ($i = 0; $i<=30; $i++){
						?>
						<option value="<?php echo $i;?>" <?php
								if (floor($reste) == $i) {echo ' selected="selected"';}
						?>><?php echo $i;?></option>
						<?php 
					}
					?>
				</select> jour(s)


		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Quel prix d'achat doit être pris en compte pour le calcul de la Valeur d'Achat Stockée ?</td>
		<td>

		<select id="CALCUL_VAS" name="CALCUL_VAS" class="classinput_xsize">
		<?php 
		foreach ($CHOIX_CALCUL_VAS as $key=>$val) {
			?>
			<option value="<?php echo $key?>" <?php if ($CALCUL_VAS == $key) { echo 'selected="selected"';} ?>><?php echo $val?></option>
			<?php
		}
		?>
		</select>
		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Quand mettre à jour les prix de vente ?</td>
		<td>

		<select id="MAJ_PV" name="MAJ_PV" class="classinput_xsize">
		<?php 
		foreach ($CHOIX_MAJ_PV as $key=>$val) {
			?>
			<option value="<?php echo $key?>" <?php if ($MAJ_PV == $key) { echo 'selected="selected"';} ?>><?php echo $val?></option>
			<?php
		}
		?>
		</select>

		</td>
		<td class="infos_config"> </td>
	</tr>
		<tr>
		<td colspan="3"> </td>
	</tr>
        <tr>
		<td class="lib_config">Inclusion des taxes dans le prix de vente </td>
		<td>
		<input id="taxe_in_pu" name="taxe_in_pu" type="checkbox" <?php if ($TAXE_IN_PU) { ?>checked="checked"<?php } ?> value="1"/>		</td>
		<td class="infos_config">permet d'inclure ou non les taxes dans le prix de vente </td>
	</tr>
        <tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Devise :		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Indiquez la devise utilisée </td>
		<td>
		<select id="devise" name="devise">
		<?php 
		foreach ($TYPES_DEVISES as $dev=>$liste_val) {
			?>
			<option value="<?php echo $dev?>" <?php if ($MONNAIE[0] == $liste_val[0]) { echo 'selected="selected"';} ?>><?php echo $dev?></option>
			<?php
		}
		?>
		</select>
		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	</table>
	<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
		<tr>
		<td class="titre_config" colspan="3">Cotations client :		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Utilisation des cotations client </td>
		<td>
		<input id="use_cotations" name="use_cotations" value="1" type="checkbox" <?php if ($USE_COTATIONS) { ?>checked="checked"<?php } ?> />		</td>
		<td class="infos_config">permet d'utiliser les cotations pour calculer le prix des articles pour un client donné </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Formules tarifaires:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Utilisation des formules tarifaires </td>
		<td>
		<input id="use_formules" name="use_formules" value="1" type="checkbox" <?php if ($USE_FORMULES) { ?>checked="checked"<?php } ?> />		</td>
		<td class="infos_config">permet de d&eacute;finir les prix des articles en fonction de leur prix d'achat, prix public ou un prix fixe </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Arrondir le r&eacute;sultat </td>
		<td><select name="defaut_arrondi" id="defaut_arrondi" class="classinput_hsize">
			<option value="PAS" <?php if($DEFAUT_ARRONDI=="PAS") {?>selected="selected"<?php }?>>Pas d'arrondi</option>
			<option value="PRO" <?php if($DEFAUT_ARRONDI=="PRO") {?>selected="selected"<?php }?>>Au plus proche</option>
			<option value="INF" <?php if($DEFAUT_ARRONDI=="INF") {?>selected="selected"<?php }?>>A l'inf&eacute;rieur</option>
			<option value="SUP" <?php if($DEFAUT_ARRONDI=="SUP") {?>selected="selected"<?php }?>>Au sup&eacute;rieur</option>
		</select></td>
		<td class="infos_config">D&eacute;finir de quelle fa&ccedil;on on arrondit le prix calcul&eacute; par une formule tarifaire </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Arrondir &agrave; </td>
		<td>
		<input id="defaut_arrondi_pas" name="defaut_arrondi_pas" value="<?php echo  $DEFAUT_ARRONDI_PAS; ?>" type="text" class="classinput_hsize" maxlength="70" />		</td>
		<td class="infos_config">permet de d&eacute;finir &agrave; combien on arrondit le prix calcul&eacute; (&agrave; 5 centimes pr&eacute;s (0.05), &agrave; 10 centimes (0.1) etc..) </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Nombre de décimales affichées</td>
		<td>
		<input id="tarifs_nb_decimales" name="tarifs_nb_decimales" value="<?php echo  $TARIFS_NB_DECIMALES; ?>" type="text" class="classinput_hsize" maxlength="70" />		</td>
		<td class="infos_config">D&eacute;finit le nombre de décimales affichées pour les tarifs </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Affichage des tarifs par d&eacute;faut pour les clients</td>
		<td>
		<select name="defaut_app_tarifs_client" id="defaut_app_tarifs_client" class="classinput_hsize">
		<option value="HT" <?php if($DEFAUT_APP_TARIFS_CLIENT=="HT") {?>selected="selected"<?php }?>>HT</option>
		<option value="TTC" <?php if($DEFAUT_APP_TARIFS_CLIENT=="TTC") {?>selected="selected"<?php }?>>TTC</option>
		</select>		</td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Affichage des tarifs par d&eacute;faut pour les fournisseurs</td>
		<td>
		<select name="defaut_app_tarifs_fournisseur" id="defaut_app_tarifs_fournisseur" class="classinput_hsize">
		<option value="HT" <?php if($DEFAUT_APP_TARIFS_FOURNISSEUR=="HT") {?>selected="selected"<?php }?>>HT</option>
		<option value="TTC" <?php if($DEFAUT_APP_TARIFS_FOURNISSEUR=="TTC") {?>selected="selected"<?php }?>>TTC</option>
		</select>		</td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
<p style="text-align:center">
	<input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
</p>
</form>

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:64%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:1%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Grilles Tarifaires :		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
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

</div>
</div>
<SCRIPT type="text/javascript">


new Event.observe("defaut_arrondi_pas", "blur", function(evt){nummask(evt, "<?php echo  $DEFAUT_ARRONDI_PAS; ?>", "X.X"); }, false);
new Event.observe("tarifs_nb_decimales", "blur", function(evt){nummask(evt, "<?php echo  $TARIFS_NB_DECIMALES; ?>", "X"); }, false);

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