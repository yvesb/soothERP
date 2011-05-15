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
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('annuaire_gestion_categ_fournisseur','annuaire_gestion_categories_fournisseur.php',"true" ,"sub_content", "Gestion des catégories de Fournisseurs");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des catégories de Fournisseurs</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_fournisseur" style="padding-left:10px; padding-right:10px">

	
	<p>Ajouter une cat&eacute;gorie </p>
	
		<table>
		<tr>
			<td style="width:90%">
					<table>
					<tr class="smallheight">
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Note:</span>
						</td>
						<td>&nbsp;
						</td>

					</tr>
				</table>
				</td>
				<td>
				</td>
			</tr>
		</table>
	<div class="caract_table">

		<table>
		<tr>
			<td style="width:90%">
				<form action="annuaire_gestion_categories_fournisseur_add.php" method="post" id="annuaire_gestion_categories_fournisseur_add" name="annuaire_gestion_categories_fournisseur_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_fournisseur_categ" id="lib_fournisseur_categ" type="text" value=""  class="classinput_lsize"/>
						</td>
						<td>
							<textarea name="note" id="note" class="classinput_xsize"></textarea>
						</td>
						<td>
							<p style="text-align:center">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php 
	if ($liste_categories) {
	?>
	<p>Liste des cat&eacute;gories </p>

		<table>
		<tr>
			<td style="width:90%">
					<table>
					<tr class="smallheight">
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Note:</span>
						</td>
						<td>&nbsp;
						</td>
					</tr>
				</table>
			</td>
			<td>
			</td>
			</tr>
		</table>
	<?php 
	}
	foreach ($liste_categories as $liste_categorie) {
	?>
	<div class="caract_table" id="categories_fournisseur_table_<?php echo $liste_categorie->id_fournisseur_categ; ?>">

		<table>
		<tr>
			<td style="width:90%">
				<form action="annuaire_gestion_categories_fournisseur_mod.php" method="post" id="annuaire_gestion_categories_fournisseur_mod_<?php echo $liste_categorie->id_fournisseur_categ; ?>" name="annuaire_gestion_categories_fournisseur_mod_<?php echo $liste_categorie->id_fournisseur_categ; ?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="0"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td style="text-align:center">
						<input name="defaut_fournisseur_categ_<?php echo $liste_categorie->id_fournisseur_categ; ?>"  type="checkbox" id="defaut_fournisseur_categ_<?php echo $liste_categorie->id_fournisseur_categ; ?>" value="1" <?php if ( $DEFAUT_ID_FOURNISSEUR_CATEG == $liste_categorie->id_fournisseur_categ) { echo 'checked="checked"';} ?> alt="Catégorie par défaut" title="Catégorie par défaut" />
							
						</td>
						<td>
						<input id="lib_fournisseur_categ_<?php echo $liste_categorie->id_fournisseur_categ; ?>" name="lib_fournisseur_categ_<?php echo $liste_categorie->id_fournisseur_categ; ?>" type="text" value="<?php echo htmlentities($liste_categorie->lib_fournisseur_categ); ?>"  class="classinput_lsize"/>
			<input name="id_fournisseur_categ" id="id_fournisseur_categ" type="hidden" value="<?php echo $liste_categorie->id_fournisseur_categ; ?>" />
						</td>
						<td>
						<textarea id="note_<?php echo $liste_categorie->id_fournisseur_categ; ?>" name="note_<?php echo $liste_categorie->id_fournisseur_categ; ?>" class="classinput_xsize"><?php echo htmlentities($liste_categorie->note); ?></textarea>
						</td>
						<td>
							<p style="text-align:center">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
			<form method="post" action="annuaire_gestion_categories_fournisseur_sup.php" id="annuaire_gestion_categories_fournisseur_sup_<?php echo $liste_categorie->id_fournisseur_categ; ?>" name="annuaire_gestion_categories_fournisseur_sup_<?php echo $liste_categorie->id_fournisseur_categ; ?>" target="formFrame">
			<input name="id_fournisseur_categ" id="id_fournisseur_categ" type="hidden" value="<?php echo $liste_categorie->id_fournisseur_categ; ?>" />
		</form>
		<a href="#" id="link_annuaire_gestion_categories_fournisseur_sup_<?php echo $liste_categorie->id_fournisseur_categ; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
		<script type="text/javascript">
		Event.observe("link_annuaire_gestion_categories_fournisseur_sup_<?php echo $liste_categorie->id_fournisseur_categ; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('categories_fournisseur_sup', 'annuaire_gestion_categories_fournisseur_sup_<?php echo $liste_categorie->id_fournisseur_categ; ?>');}, false);
		</script>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php
	}
	?>
</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
new Form.EventObserver('annuaire_gestion_categories_fournisseur_add', function(element, value){formChanged();});

<?php 
foreach ($liste_categories as $liste_categorie) {
	?>
		new Form.EventObserver('annuaire_gestion_categories_fournisseur_mod_<?php echo $liste_categorie->id_fournisseur_categ; ?>', function(element, value){formChanged();});
	<?php
}
?>

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>