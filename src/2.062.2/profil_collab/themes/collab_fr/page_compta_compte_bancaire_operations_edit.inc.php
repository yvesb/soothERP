<?php

// *************************************************************************************************************
// MODIFICATION D'UNE OPERATION BANCAIRE
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

<p  style="font-weight:bolder">Edition de l'opération</p>
<div class="emarge">
	<table class="minimizetable">
		<tr>
			<td>
			<form action="compta_compte_bancaire_operations_edit_valid.php" method="post" id="operations_edit_valid" name="operations_edit_valid" target="formFrame" >
			
				<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
					<tr>
						<td style="width:20%">
						Date:<br />
						<input type="text" name="date_move" id="date_move" value="<?php echo date_Us_to_Fr ($infos_operation->date_move);?>" class="classinput_nsize" size="12"/>						</td>
						<td>Libellé: <br />
						<input type="text" name="lib_move" id="lib_move" value="<?php echo $infos_operation->lib_move;?>" class="classinput_xsize"/>						</td>
						<td style="text-align:right; width:25%">
						Montant:<br />
						<input type="text" name="montant_move" id="montant_move" value="<?php echo number_format($infos_operation->montant_move, $TARIFS_NB_DECIMALES, $PRICES_DECIMAL_SEPARATOR, "");?>" class="classinput_nsize" style="text-align:right" size="10"/>						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><br />
							Commentaire:<br />
								<textarea name="commentaire_move" rows="4" class="classinput_xsize" id="commentaire_move" ><?php echo ($infos_operation->commentaire_move);?></textarea>
							</td>
						<td style="text-align:right">
						<input type="hidden" name="fitid" id="fitid" value="<?php echo ($infos_operation->fitid);?>" class="classinput_nsize" style="text-align:right" size="15"/>		</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="text-align:right">
						<input name="modifier_operations_edit_valid" id="modifier_operations_edit_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-enregistrer.gif" />
						</td>
					</tr>
				</table>
				<input type="hidden" name="id_compte_bancaire_ope" id="id_compte_bancaire_ope" value="<?php echo $compte_bancaire->getId_compte_bancaire();?>"/>
				<?php if (isset($_REQUEST["from_recherche"])) { ?>
				<input type="hidden" name="from_recherche" id="from_recherche" value="1"/>
				<?php } ?>
			
			<input type="hidden" name="id_compte_bancaire_move" id="id_compte_bancaire_move" value="<?php echo $infos_operation->id_compte_bancaire_move;?>"/>
			</form>
			
			</td>
		</tr>
	</table>
</div>
<SCRIPT type="text/javascript">

new Event.observe("date_move", "blur", datemask, false);

//on masque le chargement
H_loading();
</SCRIPT>