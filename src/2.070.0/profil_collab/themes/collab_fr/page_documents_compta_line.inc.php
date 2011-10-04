<?php

// *************************************************************************************************************
// ligne de compte COMPTABILITE 
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

$defaut_num_compte = array();
$defaut_num_compte[3] = $DEFAUT_COMPTE_HT_VENTE;
$defaut_num_compte[4] = $DEFAUT_COMPTE_TVA_VENTE;
$defaut_num_compte[5] = $DEFAUT_COMPTE_TIERS_VENTE;
$defaut_num_compte[6] = $DEFAUT_COMPTE_HT_ACHAT;
$defaut_num_compte[7] = $DEFAUT_COMPTE_TVA_ACHAT;
$defaut_num_compte[8] = $DEFAUT_COMPTE_TIERS_ACHAT;

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:33%">&nbsp;</td>
		<td style="width:24%">&nbsp;</td>
		<td style="width:38%">&nbsp;</td>
		<td style="width:5%">&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:right; padding-right:15px">
		<input type="text" value="<?php echo number_format($line_ventil->montant, $TARIFS_NB_DECIMALES, ".", ""	);?>" id="montant_<?php echo $i ;?>" name="montant_<?php echo $i ;?>" class="classinput_nsize" style="text-align:right"/>
		</td>
		<td style="text-align:center">
		<input type="hidden" value="<?php if($line_ventil->numero_compte) { echo $line_ventil->numero_compte;} else {echo $defaut_num_compte[$line_ventil->id_journal];}?>" id="numero_compte_<?php echo $i ;?>" name="numero_compte_<?php echo $i ;?>"/>
		<input type="hidden" value="<?php echo $line_ventil->id_journal;?>" id="id_journal_<?php echo $i ;?>" name="id_journal_<?php echo $i ;?>"/>
		
		<span style=" text-decoration:underline; cursor:pointer" id="numero_compte_compta_<?php echo $i ;?>" >
		<?php if ($line_ventil->numero_compte) { echo $line_ventil->numero_compte;} else { echo $defaut_num_compte[$line_ventil->id_journal];}?>
		</span>
		</td>
		<td>
		<span id="lib_compte_<?php echo $i ;?>"><?php
		if ($line_ventil->numero_compte) {
		  $lcpt = new compta_plan_general($line_ventil->numero_compte);
			echo $lcpt->getLib_compte();
		} else { 
			$lcpt = new compta_plan_general($defaut_num_compte[$line_ventil->id_journal]); 
			echo $lcpt->getLib_compte(); 
		}
		 ?></span>
		</td>
		<td>
<?php if ($line_ventil->id_journal != 5 && $line_ventil->id_journal != 8) {?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" id="sup_line_compta_<?php echo $i ;?>">
<?php } ?>
		</td>
	</tr>
</table>
<script type="text/javascript">
<?php if ($line_ventil->id_journal != 5 && $line_ventil->id_journal != 8) {?>
Event.observe('sup_line_compta_<?php echo $i ;?>', 'click',  function(evt){
	$("montant_<?php echo $i ;?>").disabled = "disabled";
	$("montant_<?php echo $i ;?>").style.borderColor = "#CCCCCC";
	
	$("lib_compte_<?php echo $i ;?>").style.color = "#CCCCCC";
	
	$("numero_compte_<?php echo $i ;?>").disabled = "disabled";
	$("numero_compte_compta_<?php echo $i ;?>").style.color = "#CCCCCC";
	
	$("sup_line_compta_<?php echo $i ;?>").style.display = "none";
	check_document_compta_lignes ();
	Event.stop(evt);
},false); 
<?php } ?>
Event.observe("montant_<?php echo $i ;?>" , "blur", function(evt){
		if (nummask(evt, $("montant_<?php echo $i ;?>" ).value, "X.XY")) {
			check_document_compta_lignes();
		}
	}, false);
	
	
Event.observe('numero_compte_compta_<?php echo $i ;?>', 'click',  function(evt){
	ouvre_compta_plan_mini_moteur(); 
	charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=line&cible_id=<?php echo $defaut_num_compte[$line_ventil->id_journal];?>&retour_value_id=numero_compte_compta_<?php echo $i ;?>&retour_lib_id=lib_compte_<?php echo $i ;?>&indent=numero_compte_<?php echo $i;?>&num_compte=<?php echo $defaut_num_compte[$line_ventil->id_journal];?>");
	Event.stop(evt);
},false); 
</script>
