//mettre le compte bancaire à actif
function set_active_compte (id_compte_bancaire) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_bancaire_active_compte.php", 
									{
									parameters: {id_compte_bancaire: id_compte_bancaire},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}

//mettre le compte bancaire à inactif
function set_desactive_compte (id_compte_bancaire) {
	var AppelAjax = new Ajax.Request(
									"compta_compte_bancaire_desactive_compte.php", 
									{
									parameters: {id_compte_bancaire: id_compte_bancaire},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
															requester.responseText.evalScripts();
															H_loading(); 
															}
									}
									);
}


//insertion d'une nouvelle ligne d'opération 
function insert_new_line_ope_cpt_bancaire () {
	indentation_add_ope = parseInt($("indentation_add_ope").value);
	new_indentation_add_ope = indentation_add_ope+1;
      new Insertion.Bottom($("liste_add_ope"), 
      '<table border="0" cellspacing="0" cellpadding="0" style="width:100%"><tr><td style="width:20%">'+
			'<input type="text" name="date_move_'+new_indentation_add_ope+'" id="date_move_'+new_indentation_add_ope+'" value="" class="classinput_nsize" size="12"/></td>'+
			'<td>'+
			'<input type="text" name="lib_move_'+new_indentation_add_ope+'" id="lib_move_'+new_indentation_add_ope+'" value="" class="classinput_xsize"/></td>'+
			'<td style="text-align:right; width:25%">'+
			''+
			'<input type="text" name="montant_move_'+new_indentation_add_ope+'" id="montant_move_'+new_indentation_add_ope+'" value="0.00" class="classinput_nsize" style="text-align:right" size="10"/>'+
			'<script type="text/javascript">'+
			'Event.observe($("montant_move_'+new_indentation_add_ope+'"), "blur", function(evt){'+
			'Event.stop(evt);	nummask(evt, 0, "X.XY"); '+
			'if (parseInt($("indentation_add_ope").value) == '+new_indentation_add_ope+') {'+
			'insert_new_line_ope_cpt_bancaire ();'+
			'}'+
			'});'+
			'Event.observe("date_move_'+new_indentation_add_ope+'", "blur", datemask, false);'+
			'</script></td></tr></table><div>&nbsp;</div>');
			$("indentation_add_ope").value = new_indentation_add_ope;
			$("date_move_"+new_indentation_add_ope).focus();
}

