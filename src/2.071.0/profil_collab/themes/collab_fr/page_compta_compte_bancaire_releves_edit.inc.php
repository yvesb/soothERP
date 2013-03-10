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
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_edit_ope" style="cursor:pointer; float:right"/>
<script type="text/javascript">
Event.observe('close_edit_ope', 'click',  function(evt){
Event.stop(evt); 
$("edition_operation").hide();
}, false);
</script>

<p  style="font-weight:bolder">Edition du relevé</p>
<div class="emarge">
	<table class="minimizetable">
		<tr>
			<td>
			<form action="compta_compte_bancaire_releves_edit_valid.php" method="post" id="releves_edit_valid" name="releves_edit_valid" target="formFrame" >
			
				<table width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
						<td>
						Date de relevé:
						</td>
						<td style=" text-align:right">
						Solde réél:
						</td>
						<td style=" text-align:right">
						Solde précédent:
						</td>
						<td style=" text-align:right">
						Crédit:
						</td>
						<td style=" text-align:right">
						Débit:
						</td>
						<td style=" text-align:right">
						Solde calculé:
						</td>
						<td style=" text-align:right">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<input type="text" name="date_releve" id="date_releve" value="<?php echo date_Us_to_Fr ($infos_releve->date_releve);?>" class="classinput_nsize" size="12"/>
						</td>
						<td style=" text-align:right">
						<input type="text" name="solde_reel" id="solde_reel" value="<?php echo number_format($infos_releve->solde_reel, $TARIFS_NB_DECIMALES, $PRICES_DECIMAL_SEPARATOR, "");?>" class="classinput_nsize" style="text-align:right" size="12"/>
						</td>
						<td style="text-align:right;">
						<?php if (isset($ancien_solde_reel)) {echo  price_format($ancien_solde_reel)." ".$MONNAIE[1];}?>
						</td>
						<td style="text-align:right;">
						<?php if (isset($totaux["credit"])) {echo  price_format($totaux["credit"])." ".$MONNAIE[1];}?>
						</td>
						<td style="text-align:right;">
						<?php if (isset($totaux["debit"])) {echo  price_format(abs($totaux["debit"]))." ".$MONNAIE[1];}?>
						</td>
						<td style="text-align:right;">
						<?php echo price_format($infos_releve->solde_calcule)." ".$MONNAIE[1];?>
						</td>
						<td>&nbsp;
						</td>
					</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style=" text-align:right">
							<input name="modifier_releves_edit_valid" id="modifier_releves_edit_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-enregistrer.gif" /></td>
		<td>&nbsp;</td>
	</tr>
</table>
						<input type="hidden" name="id_compte_bancaire_ope" id="id_compte_bancaire_ope" value="<?php echo $compte_bancaire->getId_compte_bancaire();?>"/>
					
					<input type="hidden" name="id_compte_bancaire_releve" id="id_compte_bancaire_releve" value="<?php echo $infos_releve->id_compte_bancaire_releve;?>"/>
					</form>
					
					<br />

					
			<div style="text-align:right">
			<form action="compta_compte_bancaire_releves_del.php" method="post" id="releves_del" name="releves_del" target="formFrame" >
				<input type="hidden" name="id_compte_bancaire_rel" id="id_compte_bancaire_rel" value="<?php echo $compte_bancaire->getId_compte_bancaire();?>"/>
			
			<input type="hidden" name="id_compte_bancaire_releve" id="id_compte_bancaire_releve" value="<?php echo $infos_releve->id_compte_bancaire_releve;?>"/>
			
			<input name="supprimer_releves_edit_valid" id="supprimer_releves_edit_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-supprimer.gif" style="padding-right:11px" />
			</form>
			</div>
			<SCRIPT type="text/javascript">
			Event.observe("supprimer_releves_edit_valid", "click",  function(evt){
				Event.stop(evt); 
				alerte.confirm_supprimer("compta_releve_compte", "releves_del")
			}, false);
			</SCRIPT>
			</td>
		</tr>
	</table>
</div>
<SCRIPT type="text/javascript">

new Event.observe("date_releve", "blur", datemask, false);

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>