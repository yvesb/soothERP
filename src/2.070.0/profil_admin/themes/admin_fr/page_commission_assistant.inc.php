
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_assistant_comm_commission_iframe" class="assistant_comm_commission_iframe"></iframe>
<div id="pop_up_assistant_comm_commission" class="assistant_comm_commission_table">
<a href="#" id="link_close_pop_up_assistant_comm_commission" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("link_close_pop_up_assistant_comm_commission", "click",  function(evt){Event.stop(evt); reset_assistant_comm_commission('pop_up_assistant_comm_commission', 'pop_up_assistant_comm_commission_iframe', 'form_assistant_comm_commission', 'assistant_comm_form_step2');}, false);
</script>
<p class="assist_titre">GENERATEUR DE COMMISSIONS</p>


	<form id="form_assistant_comm_commission" name="form_assistant_comm_commission" method="post" action="commission_formule.php" target="formFrame">
	
	<input name="assistant_comm_indice_qte"  id="assistant_comm_indice_qte" type="hidden" value="">
	<input name="assistant_comm_id_commission_regle"  id="assistant_comm_id_commission_regle" type="hidden" value="">
	<input name="assistant_comm_art_categ"  id="assistant_comm_art_categ" type="hidden" value="">
	<input name="assistant_comm_article"  id="assistant_comm_article" type="hidden" value="">
	<input name="assistant_comm_cellule"  id="assistant_comm_cellule" type="hidden" value="">
	<input name="new_formule_comm"  id="new_formule_comm" type="hidden" value="">
	<input name="old_formule_comm"  id="old_formule_comm" type="hidden" value="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="assist_labelled_bold" colspan="3">D&eacute;finir la base de Calcul du commissionnement : </td>
			<td style="width:55px;"></td>
		</tr>
		<tr>
			<td class="assist_labelled_bold" style="width:220px;"></td>
			<td class="assist_labelled_bold" style="width:150px;"></td>
			<td class="assist_labelled_bold" ></td>
			<td style="width:55px;">&nbsp;</td>
		</tr>
		<tr>
			<td class="assist_labelled_bold" style="">Base: </td>
			<td class="labelled_text" style="width:150px;">		 
				<span id="assistant_comm_tex_step1_CA"  style="cursor:pointer">&nbsp;&nbsp;&nbsp;Chiffre d'affaire	</span>			</td>
			<td><input type="text" name="assistant_comm_val_step1_CA" id="assistant_comm_val_step1_CA" class="assistant_comm_input" value="0"/></td>
			<td style="width:55px;">%</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">
				<span id="assistant_comm_tex_step1_Mg" style="cursor:pointer">+ Marge</span> </td>
			<td><input type="text" name="assistant_comm_val_step1_Mg" id="assistant_comm_val_step1_Mg" class="assistant_comm_input" value="0"/></td>
			<td style="width:55px;">%</td>
		</tr>
	</table>
<br/>

<div id="assistant_comm_form_step2" style="display:">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="assist_labelled_bold" style="width:220px;">Acquisition: </td>
			<td class="labelled_text"  colspan="2"><input type="radio" name="assistant_comm_rep_step2" id="assistant_comm_rep_step2_CDC" value="CDC" checked="checked">				 
				<span id="assistant_comm_tex_step2_CDC" style="cursor:pointer" >à la commande</span>					</td>
			<td></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text" colspan="2">
			<input type="radio" name="assistant_comm_rep_step2" id="assistant_comm_rep_step2_FAC" value="FAC">
				<span id="assistant_comm_tex_step2_FAC" style="cursor:pointer">à la facturation</span>			</td>
			<td></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text" colspan="2">
			<input type="radio" name="assistant_comm_rep_step2" id="assistant_comm_rep_step2_RGM" value="RGM">
				<span id="assistant_comm_tex_step2_RGM" style="cursor:pointer">au règlement</span>			</td>
			<td></td>
		</tr>
	</table>
	
	<br>
	<p style="text-align:right">
		<input name="valider_assistant" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />	
	</p>
	
<SCRIPT type="text/javascript">

Event.observe($('assistant_comm_val_step1_CA'), "focus", function(evt){$('assistant_comm_form_step2').show(); });
Event.observe($('assistant_comm_val_step1_Mg'), "focus", function(evt){$('assistant_comm_form_step2').show(); });
Event.observe($('assistant_comm_val_step1_CA'), "blur", function(evt){nummask(evt, 0, "X.X"); });
Event.observe($('assistant_comm_val_step1_Mg'), "blur", function(evt){nummask(evt, 0, "X.X"); });


Event.observe($('assistant_comm_tex_step1_CA'), "click", function(evt){ $('assistant_comm_form_step2').show();$('assistant_comm_val_step1_CA').focus();});
Event.observe($('assistant_comm_tex_step1_Mg'), "click", function(evt){ $('assistant_comm_form_step2').show();$('assistant_comm_val_step1_Mg').focus();});



Event.observe($('assistant_comm_tex_step2_CDC'), "click", function(evt){$('assistant_comm_rep_step2_CDC').checked = true; });
Event.observe($('assistant_comm_tex_step2_FAC'), "click", function(evt){$('assistant_comm_rep_step2_FAC').checked = true; });
Event.observe($('assistant_comm_tex_step2_RGM'), "click", function(evt){$('assistant_comm_rep_step2_RGM').checked = true; });





function stopif_assistant_comm_uncomplete (event) {

if ( $("assistant_comm_rep_step2_CDC").checked || $("assistant_comm_rep_step2_FAC").checked || $("assistant_comm_rep_step2_RGM").checked ) {

}
else {
	Event.stop(event);
	}
}

Event.observe('form_assistant_comm_commission', "submit", function(evt){stopif_assistant_comm_uncomplete(evt);});


</SCRIPT>
	</div>
	
	</form>
	
</div>