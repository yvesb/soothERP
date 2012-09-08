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
<div style="width:100%;">
<div style="padding:5px;">



<table style="width:100%">
	<tr>
		<td>
		<table style="width:100%" id="reglements_types">
		<tr>
		<td style="text-align:center">
		<div id="montant_due2" style="display:none">0</div>
		<form action="annuaire_compta_reglements_mode_valid.php" method="post" id="new_reglement" name="new_reglement" target="formFrame" >
		<div style="display:none" id="docs_liste"></div>
		<div style="display:block; text-align:center;" id="reglement_choix_type">
			<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_compta_reglements_choix.inc.php" ?>
		</div>
		</form>
		
		</td>
		</tr>
		</table>
		</td>		
	</tr>
</table>		
<script type="text/javascript">
//on masque le chargement
H_loading();
</script>
</div>
</div>