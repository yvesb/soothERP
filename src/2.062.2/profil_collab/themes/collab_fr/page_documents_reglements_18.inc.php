<?php

// *************************************************************************************************************
//  REGLEMENT ENTRANT TRAITE
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
R&eacute;ception d'un r&egrave;glement par traite<br />
<br />

<?php
if (count($comptes_bancaires) && count($comptes_bancaires_societe)) {
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
			<td>Compte source: </td>
			<td>
			<select id="id_compte_bancaire_source" name="id_compte_bancaire_source"  class="classinput_xsize">
			<?php 
			foreach ($comptes_bancaires as $compte_bancaire) {
				?>
				<option value="<?php echo htmlentities($compte_bancaire->id_compte_bancaire); ?>" ><?php echo htmlentities($compte_bancaire->lib_compte); ?></option>
				<?php
			}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td>Compte destinataire: </td>
			<td>
			<select id="id_compte_bancaire_dest" name="id_compte_bancaire_dest"  class="classinput_xsize">
			<?php 
			foreach ($comptes_bancaires_societe as $compte_bancaire_societe) {
				?>
				<option value="<?php echo htmlentities($compte_bancaire_societe->id_compte_bancaire); ?>" ><?php echo htmlentities($compte_bancaire_societe->lib_compte); ?></option>
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
	Mode de r&egrave;glement indisponible.<br /> 
	<?php
	if (!count($comptes_bancaires_societe)) {
	?>
	Auncun Compte bancaire pour la soci&eacute;t&eacute; n'est d&eacute;fini pour ce mode de r&egrave;glement.<br />
	<?php
	}
	if (!count($comptes_bancaires)) {
	?>
	Auncun Compte bancaire pour le client n'est d&eacute;fini pour ce mode de r&egrave;glement.<br />
	<?php
	}
	?>
	Cr&eacute;ez un compte bancaire ou contacter votre administrateur. <br />
	<?php
}
?>
</div>