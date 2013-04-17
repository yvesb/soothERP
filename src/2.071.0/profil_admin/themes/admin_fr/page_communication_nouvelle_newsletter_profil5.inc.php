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
</script>
<div class=""> 
	<p class="titre_config" >Critères Fournisseurs</p>
	<div class="reduce_in_edit_mode">
		<table class="minimizetable">
			<tr>
				<td style="width:180px"></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
			<?php
			if(empty($liste_categories_fournisseur))  {
				?>
				<td class="size_strict">
				</td>
				<td>
				<input type="checkbox" value="0" id="tous_fourn" name="tous_fourn" checked="yes" disabled> Tous les fournisseurs.
				</td>
				<?php
			}else {
				?>
				<td>
				<span>Catégories:</span>
				</td>
				<td>
				<input type="checkbox" value="0" id="tous_fourn" name="tous_fourn" checked="checked" >Toutes 
				<script type="text/javascript">
				new Event.observe("tous_fourn", "click", function(){
					if ($("tous_fourn").checked) {
						
					<?php
					foreach ($liste_categories_fournisseur as $cat_fourn) {
						?>
						$("fourn_cat_<?php echo $cat_fourn->id_fournisseur_categ;?>").checked = "";
						<?php
					}
					?>
					}
				}, false);
				</script>
				</td>
		</tr>
		<tr>
				<td>
				</td><td>
				<?php
				foreach ($liste_categories_fournisseur as $cat_fourn) {
				?>
				<input type="checkbox" name="fourn_cat_<?php echo $cat_fourn->id_fournisseur_categ;?>" id="fourn_cat_<?php echo $cat_fourn->id_fournisseur_categ;?>" value="<?php echo $cat_fourn->id_fournisseur_categ;?>" /><?php echo ($cat_fourn->lib_fournisseur_categ);?>
						
					<script type="text/javascript">
					new Event.observe("fourn_cat_<?php echo $cat_fourn->id_fournisseur_categ;?>", "click", function(){
						if ($("fourn_cat_<?php echo $cat_fourn->id_fournisseur_categ;?>").checked) {
							$("tous_fourn").checked = "";
						}
					}, false);
					</script><br />
				<?php
				}
				?>
				</td>
				<?php 
			} 
			?>
			</tr>
		</table>
	</div>
</div>

<script type="text/javascript">
//on masque le chargement
H_loading();
</script>