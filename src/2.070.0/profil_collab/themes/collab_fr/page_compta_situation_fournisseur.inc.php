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

<p class="titre">Situation Fournisseurs</p>
<div style="height:50px">
<table class="minimizetable" style="background-color:#FFFFFF">
<tr>
<td>
<div style="padding-left:10px; padding-right:10px">
	<span id="compte_fournisseur_extrait" class="grey_caisse" style="float:right" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Grand livre Fournisseurs</span>
	
	
	<span id="compta_livraisons_fournisseur_nonfacturees" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Livraisons non facturées</span><br /><br />
	
	<span id="compta_factures_fournisseur_nonreglees" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Factures non réglées</span><br /><br />

</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">

	Event.observe('compta_livraisons_fournisseur_nonfacturees', "click", function(evt){
		page.verify('compta_livraisons_fournisseur_nonfacturees','compta_livraisons_fournisseur_nonfacturees.php','true','sub_content');
		Event.stop(evt);
}); 
	Event.observe('compta_factures_fournisseur_nonreglees', "click", function(evt){
		page.verify('compta_factures_fournisseur_nonreglees','compta_factures_fournisseur_nonreglees.php','true','sub_content');
		Event.stop(evt);
});
	Event.observe('compte_fournisseur_extrait', "click", function(evt){
		page.verify('compte_fournisseur_extrait','compte_fournisseur_journal.php','true','sub_content');
		Event.stop(evt);
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>