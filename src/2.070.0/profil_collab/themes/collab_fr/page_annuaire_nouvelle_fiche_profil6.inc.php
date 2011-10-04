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
	<p class="sous_titre1">Informations constructeur </p>
	<div class="reduce_in_edit_mode">
	<table class="minimizetable">
		<tr>
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">R&eacute;f&eacute;rence revendeur:</span>			
			</td>
			<td>
				<input name="identifiant_revendeur" id="identifiant_revendeur" type="text" class="classinput_xsize" value="" />
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Conditions de garantie:</span>
			</td><td>
			<textarea name="conditions_garantie" id="conditions_garantie" class="classinput_xsize"></textarea>
			</td>
		</tr>
	</table>
</div>
</div>


<script type="text/javascript">
//on masque le chargement
H_loading();
</script>
