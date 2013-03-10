<?php

// *************************************************************************************************************
// REGLEMENT SORTANT CB
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
<div style="width:100%;" class="main_reglement_pay_mode">
Emission d'un r&egrave;glement par carte bancaire<br />
<br />
<?php
if (count($comptes_cbs)) {
	?>
	<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
		<tr>
			<td style="width:55%">
			<input id="id_reglement_mode" name="id_reglement_mode" value="<?php echo $_REQUEST["id_reglement_mode"]; ?>" type="hidden" /> <input id="ref_contact" name="ref_contact" value="<?php echo $ref_contact; ?>" type="hidden" /> 
			<input id="direction_reglement" name="direction_reglement" value="entrant" type="hidden" /> 
			
			Montant:
			</td>
			<td><input id="montant_reglement" name="montant_reglement" value="" type="text" class="classinput_xsize" /></td>
		</tr>
		<tr>
			<td>Carte Bancaire: </td>
			<td>
			
			<select id="id_compte_cb_source" name="id_compte_cb_source"  class="classinput_xsize">
			<?php 
			foreach ($comptes_cbs as $compte_cb) {
				?>
				<option value="<?php echo htmlentities($compte_cb->id_compte_cb); ?>" <?php if (isset($_COOKIE["last_id_compte_cb_source"]) && ($compte_cb->id_compte_cb == $_COOKIE["last_id_compte_cb_source"])) {echo 'selected="selected"';}?>><?php echo htmlentities(substr($compte_cb->numero_carte, 0, strlen($compte_cb->numero_carte)-4)). "XXXX - ".htmlentities($compte_cb->nom_porteur); ?></option>
				<?php
			}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td>Date de r&egrave;glement: </td>
			<td><input id="date_reglement" name="date_reglement" value="<?php echo date("d/m/Y");?>" type="text" class="classinput_xsize" /> </td>
		</tr>
		<tr style=" display:<?php if ($reglements_modes->allow_date_echeance ) {echo "";} else { echo "none";}?>;">
			<td>Date d'&eacute;cheance: </td>
			<td><input id="date_echeance" name="date_echeance" value="<?php echo date("d/m/Y");?>" type="text" class="classinput_xsize" /> </td>
		</tr>
		<tr>
			<td></td>
			<td><input id="ajouter_reglement" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"  /> </td>
		</tr>
	</table>
	
		<script type="text/javascript">
		
	Event.observe("montant_reglement", "blur", function(evt){ nummask(evt, Math.abs($("montant_due2").innerHTML), "X.X");}, false);		
	
	new Event.observe("date_reglement", "blur", datemask, false);
	new Event.observe("date_echeance", "blur", datemask, false);
	$("montant_reglement").value = Math.abs($("montant_due2").innerHTML) ;
	//on masque le chargement
	H_loading();
	
	</script>
		<?php
} else {
	?>
	Mode de r&egrave;glement indisponible<br /> 
	Auncune Carte bancaire n'est d&eacute;finie pour ce mode de r&egrave;glement.<br />
	Cr&eacute;ez une carte bancaire ou contacter votre administrateur <br />
	<?php
}
?>
</div>
