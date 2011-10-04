<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("liste_categories_fournisseur");
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
	<p class="sous_titre1">Informations fournisseur </p>
	<div class="reduce_in_edit_mode">
	<table class="minimizetable">
		<tr>
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de fournisseur:</span>
			</td>
			<td>
			<select  id="id_fournisseur_categ"  name="id_fournisseur_categ" class="classinput_xsize">
				<?php
				foreach ($liste_categories_fournisseur as $liste_categorie_fournisseur){
					?>
					<option value="<?php echo $liste_categorie_fournisseur->id_fournisseur_categ;?>" <?php if ($liste_categorie_fournisseur->id_fournisseur_categ == $DEFAUT_ID_FOURNISSEUR_CATEG) { echo 'selected="selected"';}?>>
					<?php echo htmlentities($liste_categorie_fournisseur->lib_fournisseur_categ); ?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Identifiant client:</span>
			</td><td>
			<input name="code_client" id="code_client" type="text" class="classinput_xsize" value="" />
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Conditions commerciales:</span>
			</td><td>
			<textarea name="conditions_commerciales" id="conditions_commerciales" class="classinput_xsize"></textarea>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse d'exp&eacute;dition des marchandises:</span>
			</td>
			<td>
			<select  id="id_stock_livraison"  name="id_stock_livraison" class="classinput_xsize">
				<?php
				foreach ($stocks_liste as $stock_liste){
					?>
					<option value="<?php echo $stock_liste->getId_stock();?>" <?php if ($stock_liste->getId_stock() == $DEFAUT_ID_STOCK_LIVRAISON) { echo 'selected="selected"';}?>>
					<?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Afficher Tarifs:</span>
			</td>
			<td>
			<select id="app_tarifs" name="app_tarifs" class="classinput_xsize">
				<option value="">Automatique</option>
				<option value="HT" <?php if ( $DEFAUT_APP_TARIFS_FOURNISSEUR == "HT") {echo 'selected="selected"';}?>>HT</option>
				<option value="TTC" <?php if ( $DEFAUT_APP_TARIFS_FOURNISSEUR == "TTC") {echo 'selected="selected"';}?>>TTC</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">D&eacute;lai de livraison:</span>
			</td><td>
			<input name="delai_livraison" id="delai_livraison" type="text" class="classinput_xsize" value="" />
			</td>
		</tr>
	</table>
</div>
</div>


<script type="text/javascript">

//on masque le chargement
H_loading();
</script>
