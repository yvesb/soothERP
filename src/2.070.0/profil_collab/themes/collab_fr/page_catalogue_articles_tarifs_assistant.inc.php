
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_assistant_tarif_iframe" class="assistant_tarif_iframe"></iframe>
<div id="pop_up_assistant_tarif" class="assistant_tarif_table">
<a href="#" id="lin_close_pop_up_assistant_tarif" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("lin_close_pop_up_assistant_tarif", "click",  function(evt){Event.stop(evt); reset_assistant_tarif('pop_up_assistant_tarif', 'pop_up_assistant_tarif_iframe', 'form_assistant_tarif', 'assistant_form_step2', 'assistant_form_step3', 'assistant_form_step4');}, false);
</script>
<?php if ($USE_FORMULES) {?>
	<p class="assist_titre">GENERATEUR DE TARIFS</p>
<?php } ?>


<form id="form_assistant_tarif" name="form_assistant_tarif" method="post" action="catalogue_articles_tarifs_formule.php" target="formFrame">
<input name="assistant_cellule"  id="assistant_cellule" type="hidden" value="">
<?php 
if ($USE_FORMULES) {
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="assist_labelled_bold" style="width:220px;">D&eacute;finir la base de Calcul du tarif : </td>
			<td class="labelled_text" style="width:150px;"><input type="radio" name="assistant_rep_step1" id="assistant_rep_step1_AR" value="AR" >				 
				<span id="assistant_tex_step1_AR"  style="cursor:pointer">Arbitraire	</span>				</td>
			<td><input type="text" name="assistant_val_step1_arb" id="assistant_val_step1_arb" class="assistant_input"></td>
			<td style="width:55px;">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2" class="labelled_text"><input type="radio" name="assistant_rep_step1" id="assistant_rep_step1_PP" value="PP">
				<span id="assistant_tex_step1_PP" style="cursor:pointer">Prix Public Conseill&eacute; ou PP</span> </td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2" class="labelled_text"><input type="radio" name="assistant_rep_step1" id="assistant_rep_step1_PA" value="PA">
				<span id="assistant_tex_step1_PA" style="cursor:pointer">Prix d'Achat ou PA</span> </td>
			<td>&nbsp;</td>
		</tr>
	</table>

	<br>
<div id="assistant_form_step2" style="display:none">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="assist_labelled_bold" style="width:220px;">D&eacute;finir la formule appliqu&eacute;e: </td>
			<td class="labelled_text" style="width:150px;"><input type="radio" name="assistant_rep_step2" id="assistant_rep_step2_marge" value="MARGE">				 
				<span id="assistant_tex_step2_marge" style="cursor:pointer" >Marge</span>					</td>
			<td><input type="text" name="assistant_val_step2_marge" id="assistant_val_step2_marge" class="assistant_input"></td>
			<td class="labelled_text" style="width:55px;">%</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text"><input type="radio" name="assistant_rep_step2" id="assistant_rep_step2_multi" value="MULTI">
				<span id="assistant_tex_step2_multi" style="cursor:pointer">Multiplicateur	</span>				</td>
			<td><input type="text" name="assistant_val_step2_multi" id="assistant_val_step2_multi" class="assistant_input"></td>
			<td class="labelled_text">(ex: 1.5) </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text"><input type="radio" name="assistant_rep_step2" id="assistant_rep_step2_add" value="ADD">
				<span id="assistant_tex_step2_add" style="cursor:pointer">Addition</span>				</td>
			<td ><input type="text" name="assistant_val_step2_addition" id="assistant_val_step2_addition"  class="assistant_input"></td>
			<td class="labelled_text">(ex: +20) </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text"><input type="radio" name="assistant_rep_step2" id="assistant_rep_step2_0" value="0">
				<span id="assistant_tex_step2_0" style="cursor:pointer">Aucun</span></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	
	<br>
</div>
<div id="assistant_form_step4" style="display:none">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="assist_labelled_bold" style="width:220px;">R&eacute;sultat exprim&eacute; : </td>
			<td class="labelled_text" ><input name="assistant_rep_step4" id="assistant_rep_step4_ht" type="radio" value="PU_HT" <?php if ($DEFAUT_APP_TARIFS_CLIENT == "HT") {?> checked="checked" <?php } ?>>				 
				<span id="assistant_tex_step4_ht" style="cursor:pointer">Prix	Unitaire	Hors	Taxe</span>	</td>
			<td style="width:55px;">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text"><input type="radio" name="assistant_rep_step4" id="assistant_rep_step4_ttc" value="PU_TTC" <?php if ($DEFAUT_APP_TARIFS_CLIENT == "TTC") {?> checked="checked" <?php } ?>>
				<span id="assistant_tex_step4_ttc" style="cursor:pointer">Prix	Unitaire	Toutes Taxes	Comprises</span></td>
			<td> </td>
		</tr>
	</table>
</div>
	<br />
<div id="assistant_form_step3" style="display:none">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="assist_labelled_bold" style="width:220px;">D&eacute;finir l'arrondi: </td>
			<td colspan="2" class="labelled_text" ><select name="assistant_rep_step3_arrondi" id="assistant_rep_step3_arrondi" class="assistant_input">
				<option value="PAS" <?php if($DEFAUT_ARRONDI=="PAS") {?>selected="selected"<?php }?>>Pas d'arrondi</option>
				<option value="PRO" <?php if($DEFAUT_ARRONDI=="PRO") {?>selected="selected"<?php }?>>Au plus proche</option>
				<option value="INF" <?php if($DEFAUT_ARRONDI=="INF") {?>selected="selected"<?php }?>>A l'inf&eacute;rieur</option>
				<option value="SUP" <?php if($DEFAUT_ARRONDI=="SUP") {?>selected="selected"<?php }?>>Au sup&eacute;rieur</option>
			</select> &nbsp;&nbsp;
			&agrave; &nbsp;&nbsp;
			<input type="text" name="assistant_rep_step3_pas" id="assistant_rep_step3_pas" value="<?php echo $DEFAUT_ARRONDI_PAS;?>" class="assistant_input" size="10"/>
&nbsp;&nbsp;pr&eacute;s</td>
			<td style="width:55px;">&nbsp;</td>
		</tr>
	</table>
</div>
	<p style="text-align:right">
		<input name="valider_assistant" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />	
	</p>
	
	<SCRIPT type="text/javascript">
	
Event.observe($('assistant_val_step1_arb'), "focus", function(evt){$('assistant_rep_step1_AR').checked = true;$('assistant_form_step2').hide(); $('assistant_form_step3').show(); $('assistant_form_step4').show();});

Event.observe($('assistant_tex_step1_AR'), "click", function(evt){$('assistant_rep_step1_AR').checked = true; $('assistant_form_step2').hide(); $('assistant_form_step3').show(); $('assistant_form_step4').show();$('assistant_val_step1_arb').focus();});
Event.observe($('assistant_tex_step1_PP'), "click", function(evt){$('assistant_rep_step1_PP').checked = true; $('assistant_form_step4').hide(); $('assistant_form_step3').hide();  $('assistant_form_step2').show();});
Event.observe($('assistant_tex_step1_PA'), "click", function(evt){$('assistant_rep_step1_PA').checked = true; $('assistant_form_step4').hide(); $('assistant_form_step3').hide();  $('assistant_form_step2').show();});

	Event.observe($('assistant_rep_step1_AR'), "click", function(evt){$('assistant_form_step2').hide(); $('assistant_form_step3').show(); $('assistant_form_step4').show();$('assistant_val_step1_arb').focus();});
	Event.observe($('assistant_rep_step1_PP'), "click", function(evt){$('assistant_form_step4').hide(); $('assistant_form_step3').hide();  $('assistant_form_step2').show();});
	Event.observe($('assistant_rep_step1_PA'), "click", function(evt){$('assistant_form_step4').hide(); $('assistant_form_step3').hide();  $('assistant_form_step2').show();});
	
Event.observe($('assistant_tex_step2_marge'), "click", function(evt){$('assistant_rep_step2_marge').checked = true; $('assistant_form_step3').show();$('assistant_form_step4').show(); $('assistant_val_step2_marge').focus();});
Event.observe($('assistant_tex_step2_multi'), "click", function(evt){$('assistant_rep_step2_multi').checked = true; $('assistant_form_step3').show();$('assistant_form_step4').show(); $('assistant_val_step2_multi').focus();});
Event.observe($('assistant_tex_step2_add'), "click", function(evt){$('assistant_rep_step2_add').checked = true; $('assistant_form_step3').show();$('assistant_form_step4').show(); $('assistant_val_step2_addition').focus();});
Event.observe($('assistant_tex_step2_0'), "click", function(evt){$('assistant_rep_step2_0').checked = true; $('assistant_form_step3').show();$('assistant_form_step4').show();});
	
Event.observe($('assistant_val_step2_marge'), "focus", function(evt){$('assistant_rep_step2_marge').checked = true; $('assistant_form_step3').show();$('assistant_form_step4').show();});
Event.observe($('assistant_val_step2_multi'), "focus", function(evt){$('assistant_rep_step2_multi').checked = true; $('assistant_form_step3').show();$('assistant_form_step4').show();});
Event.observe($('assistant_val_step2_addition'), "focus", function(evt){$('assistant_rep_step2_add').checked = true; $('assistant_form_step3').show();$('assistant_form_step4').show();});

	Event.observe($('assistant_rep_step2_marge'), "click", function(evt){$('assistant_form_step3').show();$('assistant_form_step4').show();$('assistant_val_step2_marge').focus();});
	Event.observe($('assistant_rep_step2_multi'), "click", function(evt){$('assistant_form_step3').show();$('assistant_form_step4').show();$('assistant_val_step2_multi').focus();});
	Event.observe($('assistant_rep_step2_add'), "click", function(evt){$('assistant_form_step3').show();$('assistant_form_step4').show();$('assistant_val_step2_addition').focus();});
	Event.observe($('assistant_rep_step2_0'), "click", function(evt){$('assistant_form_step3').show();$('assistant_form_step4').show();});
	
Event.observe($('assistant_tex_step4_ht'), "click", function(evt){$('assistant_rep_step4_ht').checked = true;});
Event.observe($('assistant_tex_step4_ttc'), "click", function(evt){$('assistant_rep_step4_ttc').checked = true;});
	
	
	function stopif_assistant_uncomplete (event) {
	
	if (($("assistant_rep_step1_AR").checked) || ((($("assistant_rep_step1_PP").checked) || ($("assistant_rep_step1_PA").checked)) && (($("assistant_rep_step2_marge").checked) || ($("assistant_rep_step2_multi").checked) || ($("assistant_rep_step2_add").checked) || ($("assistant_rep_step2_0").checked) ))) {
	
	}
	else {
		Event.stop(event);
		}
	}
	
	Event.observe('form_assistant_tarif', "submit", function(evt){stopif_assistant_uncomplete(evt);});
	
	
	</SCRIPT>
	<?php 
} else {
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="assist_labelled_bold" style="width:220px;">Indiquez le tarif  : </td>
				<td class="labelled_text" ><input type="text" name="assistant_val_step1_arb" id="assistant_val_step1_arb" class="assistant_input"><input name="assistant_rep_step4" id="assistant_rep_step4_ht" type="radio" value="PU_HT" <?php if ($DEFAUT_APP_TARIFS_CLIENT == "HT") {?> checked="checked" <?php } ?>>				 
					PU	HT	<input type="radio" name="assistant_rep_step4" id="assistant_rep_step4_ttc" value="PU_TTC" <?php if ($DEFAUT_APP_TARIFS_CLIENT == "TTC") {?> checked="checked" <?php } ?>>
					PU TTC</td>
				<td style="width:55px;">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="labelled_text"></td>
				<td> </td>
			</tr>
		</table>
		<p style="text-align:right">
			<input name="valider_assistant" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />	
		</p>
		
	<div id="assistant_form_step4" style="display:none">
	</div>
	<div id="assistant_form_step3" style="display:none">
	</div>
	<div id="assistant_form_step2" style="display:none">
	</div>
	<?php 
} 
?>
</form>
</div>