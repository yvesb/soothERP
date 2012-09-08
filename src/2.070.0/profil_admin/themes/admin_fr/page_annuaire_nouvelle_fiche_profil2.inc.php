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
<hr class="bleu_liner" />
<div class=""> 
	<p class="sous_titre1">Informations administrateur</p>
	<div class="reduce_in_edit_mode">
		<table class="minimizetable">
			<tr>
				<td class="size_strict"></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td class="size_strict">
				<span class="labelled_ralonger">Type:</span>
				</td><td>
				<select name="type_admin" id="type_admin" class="classinput_xsize">
					<?php foreach ($BDD_TYPE_ADMIN as $type_adm) {
						?>
						<option value="<?php echo $type_adm?>"><?php echo htmlentities($type_adm)?></option>
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