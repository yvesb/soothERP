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
<p class="titre">Comptabilité Automatique</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td style="background-color:#FFFFFF">
<div style="padding-left:10px; padding-right:10px"><br />

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bolder" style="text-align:center; width:42%">Journal des ventes automatique</td>
		<td style="width:15%">&nbsp;</td>
		<td class="bolder" style="text-align:center">Journal des achats automatique</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">

		<span  class="grey_caisse" id="compta_automatique_art_categ_vente"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux catégories d'articles</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_art_categ_vente", "click", function(evt){
			page.verify('compta_automatique_art_categ_vente','compta_automatique_art_categ_vente.php','true','sub_content');  
		}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td style="text-align:left">
		
		<span  class="grey_caisse" id="compta_automatique_art_categ_achat"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux catégories d'articles</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_art_categ_achat", "click", function(evt){
			page.verify('compta_automatique_art_categ_achat','compta_automatique_art_categ_achat.php','true','sub_content');  
		}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">

		<span  class="grey_caisse" id="compta_automatique_art_vente"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux articles</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_art_vente", "click", function(evt){
			page.verify('compta_automatique_art_vente','compta_automatique_art_vente.php','true','sub_content');  
		}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td style="text-align:left">
		
		<span  class="grey_caisse" id="compta_automatique_art_achat"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux articles</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_art_achat", "click", function(evt){
			page.verify('compta_automatique_art_achat','compta_automatique_art_achat.php','true','sub_content');  
		}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">
		<span  class="grey_caisse" id="compta_automatique_tva_vente"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />Numéros de compte associés aux taux de TVA collectés</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_tva_vente", "click", function(evt){
			page.verify('compta_automatique_tva_vente','compta_automatique_tva_vente.php','true','sub_content');  
		}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td style="text-align:left">
		
		<span  class="grey_caisse" id="compta_automatique_tva_achat"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux taux de TVA décaissés</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_tva_achat", "click", function(evt){
			page.verify('compta_automatique_tva_achat','compta_automatique_tva_achat.php','true','sub_content');  
		}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">
		
		<span  class="grey_caisse" id="compta_automatique_tiers_vente"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux catégories de clients</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_tiers_vente", "click", function(evt){
			page.verify('compta_automatique_tiers_vente','compta_automatique_tiers_vente.php','true','sub_content');  
		}, false);
		</script>
		
		</td>
		<td>&nbsp;</td>
		<td style="text-align:left">
		
		<span  class="grey_caisse" id="compta_automatique_tiers_achat"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux catégories de fournisseurs</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_tiers_achat", "click", function(evt){
			page.verify('compta_automatique_tiers_achat','compta_automatique_tiers_achat.php','true','sub_content');  
		}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">
		<span  class="grey_caisse" id="compta_client_comptes_plan"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux contacts de clients
		</span>
		<script type="text/javascript">
		
		new Event.observe("compta_client_comptes_plan", "click", function(evt){
			page.verify('compta_client_comptes_plan','compta_client_comptes_plan.php','true','sub_content');  
		}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td style="text-align: left">
		<span  class="grey_caisse" id="compta_fournisseur_comptes_plan"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux contacts de fournisseurs
		</span>
		<script type="text/javascript">
		
		new Event.observe("compta_fournisseur_comptes_plan", "click", function(evt){
			page.verify('compta_fournisseur_comptes_plan','compta_fournisseur_comptes_plan.php','true','sub_content');  
		}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>



</div>
</td>
</tr>
<tr>
<td >
</td>
</tr>
<tr>
<td style="background-color:#FFFFFF">
<div style="padding-left:10px; padding-right:10px"><br />

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bolder" style="text-align:center; width:42%"></td>
		<td style="width:15%">&nbsp;</td>
		<td class="bolder" style="text-align:center"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">

		<span  class="grey_caisse" id="compta_automatique_caisses"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux caisses</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_caisses", "click", function(evt){
			page.verify('compta_automatique_caisses','compta_automatique_caisses.php','true','sub_content');  
		}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td style="text-align:left">
		
		<span  class="grey_caisse" id="compta_automatique_comptes_bancaires"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux comptes bancaires</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_comptes_bancaires", "click", function(evt){
			page.verify('compta_automatique_comptes_bancaires','compta_automatique_comptes_bancaires.php','true','sub_content');  
		}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">

		<span  class="grey_caisse" id="compta_automatique_tps"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />
		Numéros de compte associés aux TPE et TPV</span>
		<script type="text/javascript">
		
		new Event.observe("compta_automatique_tps", "click", function(evt){
			page.verify('compta_automatique_tps','compta_automatique_tps.php','true','sub_content');  
		}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td style="text-align:left">
		</td>
	</tr>
</table>
</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>