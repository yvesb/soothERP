<?php

// *************************************************************************************************************
// REGLEMENT ENTRANT CB
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
R&eacute;ception d'un r&egrave;glement par carte bancaire<br />
<br />

<?php
if (count($comptes_tpes) || count($comptes_tpv)) {
	$no_display_tpv_yet = 0;
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
			<td>Caisse, TPE ou TPV: </td>
			<td>
			<select id="id_compte_dest" name="id_compte_dest" class="classinput_xsize" >
			<?php 
			foreach ($comptes_caisses as $compte_caisse) {
				if (!$compte_caisse->id_compte_tpe) {continue;}
				?>
				<OPTGROUP disabled="disabled" label="CAISSES" ></OPTGROUP>
				<?php
				break;
			}
			?>
			<?php 
			$id_caisse = 0;
			$id_tpe = 0;
			foreach ($comptes_caisses as $compte_caisse) {
				if (!$compte_caisse->id_compte_tpe) {continue;}
				?>
				<option value="<?php echo htmlentities($compte_caisse->id_compte_caisse); ?>,<?php echo htmlentities($compte_caisse->id_compte_tpe); ?>"   <?php 
				if (isset($_COOKIE["last_id_compte_caisse_cb_dest"]) && ($compte_caisse->id_compte_caisse == $_COOKIE["last_id_compte_caisse_cb_dest"])) {
				$no_display_tpv_yet = 1;
				echo 'selected="selected"'; 
				$id_caisse = $compte_caisse->id_compte_caisse;
				$id_tpe = $compte_caisse->id_compte_tpe;
				
				}?>><?php echo htmlentities($compte_caisse->lib_caisse); ?> (<?php echo htmlentities($compte_caisse->lib_tpe); ?>)</option>
				<?php
			}
			
			
			foreach ($comptes_tpes as $compte_tpe) {
				$valid_tpe = true;
				foreach ($comptes_caisses as $compte_caisse) {
					if ($compte_caisse->id_compte_tpe ==  $compte_tpe->id_compte_tpe) {$valid_tpe = false; continue;}
				}
				if ($valid_tpe) {
					?>
					<OPTGROUP disabled="disabled" label="TPE" ></OPTGROUP>
				<?php 
				continue;
				}
			}
			foreach ($comptes_tpes as $compte_tpe) {
				$valid_tpe = true;
				foreach ($comptes_caisses as $compte_caisse) {
					if ($compte_caisse->id_compte_tpe ==  $compte_tpe->id_compte_tpe) {$valid_tpe = false; continue;}
				}
				if ($valid_tpe) {
				?>
				<option value=",<?php echo htmlentities($compte_tpe->id_compte_tpe); ?>" <?php 
				if (!$id_caisse && isset($_COOKIE["last_id_compte_tpe_dest"]) && ($compte_tpe->id_compte_tpe == $_COOKIE["last_id_compte_tpe_dest"])) {
				$no_display_tpv_yet = 1;
				echo 'selected="selected"'; 
				$id_caisse = 0;
				$id_tpe = $compte_tpe->id_compte_tpe;
				
				}?>><?php echo htmlentities($compte_tpe->lib_tpe); ?></option>
				<?php
				}
			}
			?>
			<?php 
			if (count($comptes_tpv)) {
				?>
				<OPTGROUP disabled="disabled" label="TPV" ></OPTGROUP>
				<?php
				foreach ($comptes_tpv as $tpv)  {
					?>
					<option value="tpv_<?php echo $tpv->id_compte_tpv;?>"><?php echo $tpv->lib_tpv;?></option>
					<?php 
				}
			}
			?>
			</select>
			<input type="checkbox" id="done_reg_tpv" name="done_reg_tpv" value="1" style=" <?php if ($no_display_tpv_yet) {?>display:none<?php } ?>" title="Cocher pour valider automatiquement ce règlement sans passer par l'interface de paiement virtuel" />
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
	
	Event.observe("id_compte_dest", "change", function(evt){
		if ($("id_compte_dest").options[$("id_compte_dest").selectedIndex].value.substr(0,4) == "tpv_") {
			$("done_reg_tpv").style.display = "";
		
		} else { 
			$("done_reg_tpv").style.display = "none";
		}
	}, false);		
	
	
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
	Auncun Terminal de paiement &eacute;lectronique n'est d&eacute;finie pour ce mode de r&egrave;glement.<br />
	Cr&eacute;ez un TPE ou contacter votre administrateur. <br />
	<?php
}
?>
</div>