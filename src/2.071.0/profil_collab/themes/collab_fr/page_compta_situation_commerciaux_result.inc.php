<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES CAISSES
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

</script>
<div class="emarge">
<table width="100%" border="0" cellspacing="4" cellpadding="2">
	<tr>
		<td style="width:25%; font-weight:bolder; text-align:left"></td>
		<td style="width:20%; font-weight:bolder; text-align:center;"></td>
		<td style="width:20%; font-weight:bolder; text-align:center"></td>
		<td style="width:20%; font-weight:bolder; text-align:center"></td>
		<td style="font-weight:bolder; text-align:center"></td>
	</tr>
	<?php 
	foreach ($liste_commerciaux as $commercial) {
		?>
		<tr>
			<td colspan="5" style=" border-bottom:1px solid #999999">&nbsp;</td>
		</tr>
		<tr id="comm_commercial_<?php echo $commercial->ref_contact; ?>">
			<td style="font-weight:bolder; text-align:left">
				<a href="index.php#annuaire_view_fiche.php?ref_contact=<?php echo $commercial->ref_contact;?>" target="_blank" class="common_link" ><?php echo ($commercial->nom); ?></a><br />
				<span style="color:#999999"><?php echo ($commercial->formule_comm); ?></span>
				
			</td>
			<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px">
				<?php echo number_format($commercial->ca, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
			</td>
			<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px">
				<?php echo number_format($commercial->mg, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
			</td>
			<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px">
				<?php echo number_format($commercial->comm, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
			</td>
			<td style="width:15%; text-align:center">
				<span class="green_underlined" id="drc_<?php echo $commercial->ref_contact; ?>">Détails</span>
				<script type="text/javascript">
					Event.observe('drc_<?php echo $commercial->ref_contact; ?>', "click", function(evt){
						$("pop_up_commerciaux_det").style.display = "block";
						page.traitecontent('pop_up_commerciaux_det','compta_situation_commerciaux_details.php?ref_contact=<?php echo $commercial->ref_contact; ?>&date_debut=<?php echo $form['date_debut'];?>&date_fin=<?php echo $form['date_fin'];?>','true','pop_up_commerciaux_det');
						Event.stop(evt);
					});
				</script>
			</td>
		</tr>
		<?php
	}
	?>
</table>
</div>


<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>