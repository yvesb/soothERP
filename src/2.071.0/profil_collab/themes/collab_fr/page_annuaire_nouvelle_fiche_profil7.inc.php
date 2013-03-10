<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("liste_categories_commercial");
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
	<p class="sous_titre1">Informations commercial </p>
	<div class="reduce_in_edit_mode">
	<table class="minimizetable">
		<tr>
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie :</span>
			</td>
			<td>
			<select  id="id_commercial_categ"  name="id_commercial_categ" class="classinput_xsize">
				<?php
				foreach ($liste_categories_commercial as $liste_categorie_commercial){
					?>
					<option value="<?php echo $liste_categorie_commercial->id_commercial_categ;?>" <?php if ($liste_categorie_commercial->id_commercial_categ == $DEFAUT_ID_COMMERCIAL_CATEG) { echo 'selected="selected"';}?>>
					<?php echo htmlentities($liste_categorie_commercial->lib_commercial_categ); ?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
	</table>
</div>
</div>


<script type="text/javascript">

//on masque le chargement
H_loading();
</script>
