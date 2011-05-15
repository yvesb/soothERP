<?php

// *************************************************************************************************************
// AJOUT D'UNE OPERATION
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


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

<p  style="font-weight:bolder">Ajout des opérations</p>
<div class="emarge">
	<table class="minimizetable">
		<tr>
			<td>
			<form action="compta_compte_bancaire_operations_add_valid.php" method="post" id="operations_add_valid" name="operations_add_valid" target="formFrame" >
			<?php $indentation_add_ope = 0;?>
				<div id="liste_add_ope">
				<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
					<tr>
						<td style="width:20%">
						Date:<br />
						<input type="text" name="date_move_<?php echo $indentation_add_ope;?>" id="date_move_<?php echo $indentation_add_ope;?>" value="" class="classinput_nsize" size="12"/>						</td>
						<td>Libellé: <br />
						<input type="text" name="lib_move_<?php echo $indentation_add_ope;?>" id="lib_move_<?php echo $indentation_add_ope;?>" value="" class="classinput_xsize"/>						</td>
						<td style="text-align:right; width:25%">
						Montant:<br />
						<input type="text" name="montant_move_<?php echo $indentation_add_ope;?>" id="montant_move_<?php echo $indentation_add_ope;?>" value="0.00" class="classinput_nsize" style="text-align:right" size="10"/>
						<script type="text/javascript">
						Event.observe($("montant_move_<?php echo $indentation_add_ope;?>"), "blur", function(evt){
							Event.stop(evt);
							nummask(evt, 0, "X.XY");
						});
						Event.observe("date_move_<?php echo $indentation_add_ope;?>", "blur", function(evt){
							datemask(evt);
						}, false);
						Event.observe("date_move_<?php echo $indentation_add_ope;?>", "focus", function(evt){
							if (parseInt($("indentation_add_ope").value) == <?php echo $indentation_add_ope;?>) {
								insert_new_line_ope_cpt_bancaire ();
							}
						}, false);
						</script>
						</td>
					</tr>
				</table>
				<div>&nbsp;</div>
				</div>
		<input name="indentation_add_ope" type="hidden" id="indentation_add_ope" value="<?php echo $indentation_add_ope;?>"/>
				<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="text-align:right">
						<input type="hidden" name="id_compte_bancaire_ope" id="id_compte_bancaire_ope" value="<?php echo $compte_bancaire->getId_compte_bancaire();?>"/>
						<?php if (isset($_REQUEST["from_tb"])) { ?>
						<input type="hidden" name="from_tb" id="from_tb" value="1"/>
						<?php }?>
						<input name="add_operations_add_valid" id="add_operations_add_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-enregistrer.gif" />
						</td>
					</tr>
				</table>
			
			
			</form>
			
			</td>
		</tr>
	</table>
</div>
<SCRIPT type="text/javascript">


//on masque le chargement
H_loading();
</SCRIPT>