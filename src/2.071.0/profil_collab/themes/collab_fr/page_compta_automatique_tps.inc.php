<?php

// *************************************************************************************************************
// Numéros de compte associés aux TPE et TPV
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
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>
<div class="emarge">
<div style=" float:right; text-align:right">
<span id="retour_compta_auto" style="cursor:pointer; text-decoration:underline">Retour à la comptabilité automatique</span>
<script type="text/javascript">
Event.observe('retour_compta_auto', 'click',  function(evt){
Event.stop(evt); 
page.verify('compta_automatique','compta_automatique.php','true','sub_content');
}, false);
</script>
</div>
<p class="titre">Numéros de compte associés aux TPE et TPV</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div style="padding-left:10px; padding-right:10px">
<br />

	<table>
		<tr style="">
			<td>&nbsp;
			</td>
			<td style="text-align:center; font-weight:bolder;  width:15%">
				<span>Numéro de compte:</span>
			</td>
			<td style="width:10%">&nbsp;
			</td>
			<td style="text-align: left; font-weight:bolder;  width:50%">
				<span>Libellé:</span>
			</td>
		</tr>
<?php
foreach ($comptes_tpes as $fiche){
	?>
		<tr id="line_compte_comptable" style="">
			<td>
				<span><?php echo $fiche->lib_tpe;?></span>
			</td>
			<td style="text-align:center">
			<span style="text-decoration:underline; cursor:pointer" id="numero_compte_tpe_<?php echo $fiche->id_compte_tpe;?>"><?php if ($fiche->defaut_numero_compte) { echo $fiche->defaut_numero_compte;} else { echo $DEFAUT_COMPTE_CAISSES;}?></span>
			</td>
			<td>&nbsp;
			</td>
			<td>
			<span id="aff_numero_compte_tpe_<?php echo $fiche->id_compte_tpe;?>">
			<?php if ($fiche->defaut_numero_compte) { echo $fiche->lib_compte;} else {  $lcpt = new compta_plan_general($DEFAUT_COMPTE_CAISSES); echo $lcpt->getLib_compte();}?>
			</span>
			<script type="text/javascript">
			
			Event.observe('numero_compte_tpe_<?php echo $fiche->id_compte_tpe;?>', 'click',  function(evt){
				ouvre_compta_plan_mini_moteur(); 
				charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=compte_tpe&cible_id=<?php echo $fiche->id_compte_tpe;?>&retour_value_id=numero_compte_tpe_<?php echo $fiche->id_compte_tpe;?>&retour_lib_id=aff_numero_compte_tpe_<?php echo $fiche->id_compte_tpe;?>&indent=numero_compte_tpe_<?php echo $fiche->id_compte_tpe;?>&num_compte=<?php echo $DEFAUT_COMPTE_CAISSES;?>");
				Event.stop(evt);
			},false); 
			
			</script>
			</td>
		</tr>
		<tr >
			<td colspan="4">
	<hr />
			</td>
		</tr>
	<?php
}
?>
<?php
foreach ($comptes_tpv as $fiche){
	?>
		<tr id="line_compte_comptable" style="">
			<td>
				<span><?php echo $fiche->lib_tpv;?></span>
			</td>
			<td style="text-align:center">
			<span style="text-decoration:underline; cursor:pointer" id="numero_compte_tpv_<?php echo $fiche->id_compte_tpv;?>"><?php if ($fiche->defaut_numero_compte) { echo $fiche->defaut_numero_compte;} else { echo $DEFAUT_COMPTE_CAISSES;}?></span>
			</td>
			<td>&nbsp;
			</td>
			<td>
			<span id="aff_numero_compte_tpv_<?php echo $fiche->id_compte_tpv;?>">
			<?php if ($fiche->defaut_numero_compte) { echo $fiche->lib_compte;} else {  $lcpt = new compta_plan_general($DEFAUT_COMPTE_CAISSES); echo $lcpt->getLib_compte();}?>
			</span>
			<script type="text/javascript">
			<?php //@FIXME ?>
			Event.observe('numero_compte_tpv_<?php echo $fiche->id_compte_tpv;?>', 'click',  function(evt){
				ouvre_compta_plan_mini_moteur(); 
				charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=compte_tpv&cible_id=<?php echo $fiche->id_compte_tpv;?>&retour_value_id=numero_compte_tpv_<?php echo $fiche->id_compte_tpv;?>&retour_lib_id=aff_numero_compte_tpv_<?php echo $fiche->id_compte_tpv;?>&indent=numero_compte_tpv_<?php echo $fiche->id_compte_tpv;?>&num_compte=<?php echo $DEFAUT_COMPTE_CAISSES;?>");
				Event.stop(evt);
			},false); 
			
			</script>
			</td>
		</tr>
		<tr >
			<td colspan="4">
	<hr />
			</td>
		</tr>
	<?php
}
?>
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