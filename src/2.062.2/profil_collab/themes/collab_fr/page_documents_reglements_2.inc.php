<?php

// *************************************************************************************************************
// REGLEMENT ENTRANT CHEQUES
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
R&eacute;ception d'un r&egrave;glement par ch&egrave;que<br />
<br />

<?php
if (count($comptes_caisses)) {
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
			<td>Caisse destinataire: </td>
			<td>
			<select id="id_compte_caisse_dest2" name="id_compte_caisse_dest2" class="classinput_xsize" >
			<?php 
			foreach ($comptes_caisses as $compte_caisse) {
				?>
				<option value="<?php echo htmlentities($compte_caisse->id_compte_caisse); ?>"  <?php if (isset($_COOKIE["last_id_compte_caisse_dest"]) && ($compte_caisse->id_compte_caisse == $_COOKIE["last_id_compte_caisse_dest"])) {echo 'selected="selected"';}?>><?php echo htmlentities($compte_caisse->lib_caisse); ?></option>
				<?php
			}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td>Num&eacute;ro de ch&egrave;que: </td>
			<td><input id="numero_cheque" name="numero_cheque" value="" type="text" class="classinput_xsize" /> </td>
		</tr>
		<tr>
			<td>Banque: </td>
			<td><input id="info_banque" name="info_banque" value="" type="text" class="classinput_xsize" /> </td>
		</tr>
		<tr>
			<td>Porteur: </td>
			<td><input id="info_compte" name="info_compte" value="" type="text" class="classinput_xsize" /> </td>
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
	Mode de r&egrave;glement indisponible.<br /> 
	Auncune Caisse n'est d&eacute;finie pour ce mode de r&egrave;glement.<br />
	Cr&eacute;ez une caisse ou contacter votre administrateur. <br />
	<?php
}
?>
</div>