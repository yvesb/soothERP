<?php
// *************************************************************************************************************
// RAPPROCHEMENT D'UNE OPERATION BANCAIRE
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
$("edition_rapprochement").hide();
}, false);
</script>

<p  style="font-weight:bolder">Opération à Rapprocher</p>
<div style="padding:3px">
	<table class="minimizetable">
		<tr>
			<td>
			
				<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
					<tr>
						<td style="width:20%">
						Date:<br />
						<?php echo date_Us_to_Fr ($infos_operation->date_move);?>
						</td>
						<td>Libellé: <br />
						<?php echo $infos_operation->lib_move;?>
						</td>
						<td style="text-align:right; width:25%">
						Montant:<br />
						<?php echo number_format($infos_operation->montant_move, $TARIFS_NB_DECIMALES, $PRICES_DECIMAL_SEPARATOR, "")." ".$MONNAIE[1];?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="text-align:right">
						</td>
					</tr>
				</table>
				
			<form action="#" >
				<div style="border:1px solid #959595; -moz-border-radius:5px ; border-radius:5px ; background-color:#dbe8f0; padding:3px">
				<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
					<tr>
						<td style="width:20%; font-weight:bolder;" colspan="2">
						<?php echo $journal->getLib_journal();?> 
						<?php echo $journal->getContrepartie();?>
						</td>
						<td style="width:20%" colspan="2">
						<?php echo $compte_bancaire->getLib_compte();?> 
						n° <?php echo $compte_bancaire->getNumero_compte();?>
						</td>
						<td style="width:20%">
						</td>
					</tr>
					<tr> 
						<td colspan="5">&nbsp;
						</td>
					</tr>
					<tr>
						<td>
						<span class="labelled">Montant:</span>
						</td>
						<td>
						<input type="text" name="rap_montant" id="rap_montant" value="<?php echo number_format(abs($infos_operation->montant_move), $TARIFS_NB_DECIMALES, $PRICES_DECIMAL_SEPARATOR, "");?>" class="classinput_nsize"/>
						</td>
						<td>&agrave; +/-
						</td>
						<td>
						<input type="text" name="rap_delta_montant" id="rap_delta_montant" value="0.01" class="classinput_nsize" size="5"/> <?php	 echo $MONNAIE[1]; ?> 
						</td>
						<td>
						</td>
					</tr>
					<tr> 
						<td colspan="5">&nbsp;
						</td>
					</tr>
					<tr> 
						<td style="text-align: right"><span class="labelled">du:</span> 
						</td>
						<td><input type="text" id="rap_date_debut" name="rap_date_debut" value="<?php echo date("d-m-Y",mktime(0, 0, 0, date("m",strtotime($infos_operation->date_move)), date("d",strtotime($infos_operation->date_move))-($E_RAPPROCHEMENT), date("Y",strtotime($infos_operation->date_move))));?>" class="classinput_nsize" />
						</td>
						<td style="text-align: right"><span class="labelled"> au: </span>
						</td>
						<td><input type="text" id="rap_date_fin" name="rap_date_fin" value="<?php echo date("d-m-Y",mktime(0, 0, 0, date("m",strtotime($infos_operation->date_move)), date("d",strtotime($infos_operation->date_move))+($E_RAPPROCHEMENT), date("Y",strtotime($infos_operation->date_move))));?>" class="classinput_nsize" />
						</td>
						<td>
						</td>
					</tr>
					<tr> 
						<td colspan="5">&nbsp;
						</td>
					</tr>
					<tr> 
						<td style="text-align: right"><span class="labelled">Type:</span>
						</td>
						<td>
						<select name="rap_id_operation_type" id="rap_id_operation_type">
							<?php if ($infos_operation->montant_move >= 0) { ?>
							<option value="2,7,5">Tout</option>
							<option value="2">Remises en banque</option>
							<option value="7">Télécollectes</option>
							<option value="5">Règlements entrants</option>
							<?php } else { ?>
							<option value="3,6">Tout</option>
							<option value="3">Retraits bancaires</option>
							<option value="6">Règlements sortants</option>
							<?php } ?>
						</select>
						</td>
						<td>  
						</td>
						<td>
			<input id="rap_valide" name="rap_valide" type="image"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
						</td>
						<td>
						</td>
					</tr>
				</table></div>
				<input type="hidden" name="rap_date_move" id="rap_date_move" value="<?php echo $infos_operation->date_move;?>"/>
				
				<input type="hidden" name="rap_id_compte_bancaire" id="rap_id_compte_bancaire" value="<?php echo $compte_bancaire->getId_compte_bancaire();?>"/>
				<input type="hidden" name="rap_id_compte_bancaire_move" id="rap_id_compte_bancaire_move" value="<?php echo $infos_operation->id_compte_bancaire_move;?>"/>
				<input type="hidden" name="rap_id_compte_journal" id="rap_id_compte_journal" value="<?php echo $journal->getId_journal();?>"/>
				<input type="hidden" name="page_to_show_rap" id="page_to_show_rap" value="1"/>
			</form>
			</td>
		</tr>
	</table>
	
		<div id="compta_compte_bancaire_rapprochement_journal_result_content" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; height:270px">
		</div>
</div>
<SCRIPT type="text/javascript">

	Event.observe("rap_date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("rap_date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("rap_valide", "click", function(evt){
		Event.stop(evt);
		$("page_to_show_rap").value = "1";
		page.compta_compte_bancaire_rapprochement_journal_result ();
	}, false);


		page.compta_compte_bancaire_rapprochement_journal_result ();
//on masque le chargement
H_loading();
</SCRIPT>