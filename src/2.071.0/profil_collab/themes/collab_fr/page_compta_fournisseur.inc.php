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
</script>
<div class="emarge">


<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>
<p class="titre">Comptabilité fournisseur</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div style="padding-left:10px; padding-right:10px">
<div id="compte_fournisseurs_liste">
</div>

</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">

page.verify('compta_fournisseur_comptes_plan','compta_fournisseur_comptes_plan.php','true','compte_fournisseurs_liste');
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>