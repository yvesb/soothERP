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
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
tableau_smenu[1] = Array('compta_plan_compte_defaut','compta_plan_compte_defaut.php','true','sub_content', "Numéros de compte par défaut");
update_menu_arbo();
</script>
<div class="emarge">

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>
<p class="titre">Numéros de compte par défaut</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:20%">&nbsp;</td>
		<td class="bolder" style="text-align:center;width:25%">Journal des ventes</td>
		<td style="width:15%">&nbsp;</td>
		<td style="width:20%">&nbsp;</td>
		<td class="bolder" style="text-align:center">Journal des achats</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			Compte de vente HT:
			
		</td>
		<td style="text-align:center">
		
		<span id="aff_DEFAUT_COMPTE_HT_VENTE" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_HT_VENTE); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_HT_VENTE) { echo ($DEFAUT_COMPTE_HT_VENTE);} else { echo "...";}?></span>

		<script type="text/javascript">
		Event.observe("aff_DEFAUT_COMPTE_HT_VENTE", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_HT_VENTE&num_search=<?php echo $DEFAUT_COMPTE_HT_VENTE;?>");}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td>
			Compte d'Achat HT:
		</td>
		<td style="text-align:center">
		
		<span id="aff_DEFAUT_COMPTE_HT_ACHAT" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_HT_ACHAT); echo $lcpt->getLib_compte();?>"><?php if ($DEFAUT_COMPTE_HT_ACHAT) { echo ($DEFAUT_COMPTE_HT_ACHAT);} else { echo "...";}?></span>

		<script type="text/javascript">
		Event.observe("aff_DEFAUT_COMPTE_HT_ACHAT", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_HT_ACHAT&num_search=<?php echo $DEFAUT_COMPTE_HT_ACHAT;?>");}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Compte de TVA collectée:</td>
		<td style="text-align:center">
		
		<span id="aff_DEFAUT_COMPTE_TVA_VENTE" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_TVA_VENTE); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_TVA_VENTE) { echo ($DEFAUT_COMPTE_TVA_VENTE);} else { echo "...";}?></span>

		<script type="text/javascript">
		Event.observe("aff_DEFAUT_COMPTE_TVA_VENTE", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_TVA_VENTE&num_search=<?php echo $DEFAUT_COMPTE_TVA_VENTE;?>");}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td>Compte de TVA décaissée:</td>
		<td style="text-align:center">
		
		<span id="aff_DEFAUT_COMPTE_TVA_ACHAT" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_TVA_ACHAT); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_TVA_ACHAT) { echo ($DEFAUT_COMPTE_TVA_ACHAT);} else { echo "...";}?></span>

		<script type="text/javascript">
		Event.observe("aff_DEFAUT_COMPTE_TVA_ACHAT", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_TVA_ACHAT&num_search=<?php echo $DEFAUT_COMPTE_TVA_ACHAT;?>");}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Compte Tiers Client:</td>
		<td style="text-align:center">
		
		<span id="aff_DEFAUT_COMPTE_TIERS_VENTE" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_TIERS_VENTE); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_TIERS_VENTE) { echo ($DEFAUT_COMPTE_TIERS_VENTE);} else { echo "...";}?></span>

		<script type="text/javascript">
		Event.observe("aff_DEFAUT_COMPTE_TIERS_VENTE", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_TIERS_VENTE&num_search=<?php echo $DEFAUT_COMPTE_TIERS_VENTE;?>");}, false);
		</script>
		</td>
		<td>&nbsp;</td>
		<td>Compte Tiers Fournisseur:</td>
		<td style="text-align:center">
		
		<span id="aff_DEFAUT_COMPTE_TIERS_ACHAT" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_TIERS_ACHAT); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_TIERS_ACHAT) { echo ($DEFAUT_COMPTE_TIERS_ACHAT);} else { echo "...";}?></span>

		<script type="text/javascript">
		Event.observe("aff_DEFAUT_COMPTE_TIERS_ACHAT", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_TIERS_ACHAT&num_search=<?php echo $DEFAUT_COMPTE_TIERS_ACHAT;?>");}, false);
		</script>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>

</td>
</tr>
</table>

<table class="minimizetable">
	<tr>
		<td class="contactview_corps">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:20%" >&nbsp;</td>
				<td class="bolder" style="text-align:center; width:25%">&nbsp;</td>
				<td style="width:15%">&nbsp;</td>
				<td style="width:20%">&nbsp;</td>
				<td class="bolder" style="text-align:center">&nbsp;</td>
			</tr>
			<tr>
				<td>Compte de caisses:</td>
				<td style="text-align:center">
		
				<span id="aff_DEFAUT_COMPTE_CAISSES" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_CAISSES); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_CAISSES) { echo ($DEFAUT_COMPTE_CAISSES);} else { echo "...";}?></span>
		
				<script type="text/javascript">
				Event.observe("aff_DEFAUT_COMPTE_CAISSES", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_CAISSES&num_search=<?php echo $DEFAUT_COMPTE_CAISSES;?>");}, false);
				</script>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Compte de comptes bancaires:</td>
				<td style="text-align:center">
				<span id="aff_DEFAUT_COMPTE_BANQUES" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_BANQUES); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_BANQUES) { echo ($DEFAUT_COMPTE_BANQUES);} else { echo "...";}?></span>
		
				<script type="text/javascript">
				Event.observe("aff_DEFAUT_COMPTE_BANQUES", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_BANQUES&num_search=<?php echo $DEFAUT_COMPTE_BANQUES;?>");}, false);
				</script>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Compte de comptes virements internes:</td>
				<td style="text-align:center">
				<span id="aff_DEFAUT_COMPTE_VIREMENTS_INTERNES" style="cursor:pointer; text-decoration:underline; padding-right:15px;" title="<?php $lcpt = new compta_plan_general($DEFAUT_COMPTE_VIREMENTS_INTERNES); echo $lcpt->getLib_compte();;?>"><?php if ($DEFAUT_COMPTE_VIREMENTS_INTERNES) { echo ($DEFAUT_COMPTE_VIREMENTS_INTERNES);} else { echo "...";}?></span>
		
				<script type="text/javascript">
				Event.observe("aff_DEFAUT_COMPTE_VIREMENTS_INTERNES", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compte_defaut_search.php?indent=DEFAUT_COMPTE_VIREMENTS_INTERNES&num_search=<?php echo $DEFAUT_COMPTE_VIREMENTS_INTERNES;?>");}, false);
				</script>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<SCRIPT type="text/javascript">	
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>