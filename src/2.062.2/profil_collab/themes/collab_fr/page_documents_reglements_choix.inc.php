<?php

// *************************************************************************************************************
// CHOIX DU MODE DE REGLEMENT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


if (!isset($reglements_modes)) {$reglements_modes = array();}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:center; width:50%" colspan="2">
		<?php 
		foreach ($reglements_modes as $reglement_mode) {
                    if($reglement_mode->id_reglement_mode != 6 || $COMPTA_GEST_PRELEVEMENTS){
			?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_mod_paiement_<?php echo htmlentities($reglement_mode->id_reglement_mode); ?>.gif" id="bt_mod_paiement_<?php echo htmlentities($reglement_mode->id_reglement_mode); ?>" style="cursor:pointer; padding:5px;"/>
			<?php
                    }
		}
		?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:40%">
				</td>
				<td style="text-align:right; width:450px">
				<div style="text-align:right; width:450px" id="reglement_add_block"></div>
				</td>
				<td style="width:40%">
				</td>
			</tr>
		</table>
				
		</td>
	</tr>
</table>
					

<script type="text/javascript">
<?php 
foreach ($reglements_modes as $reglement_mode) {
    if($reglement_mode->id_reglement_mode != 6 || $COMPTA_GEST_PRELEVEMENTS){
	?>
	Event.observe("bt_mod_paiement_<?php echo htmlentities($reglement_mode->id_reglement_mode); ?>", "click", function(evt){
		insert_form_new_reglement ("reglement_add_block", "<?php echo htmlentities($reglement_mode->id_reglement_mode); ?>");
		}, false);		
	<?php
    }
}
?>


//on masque le chargement
H_loading();

</script>