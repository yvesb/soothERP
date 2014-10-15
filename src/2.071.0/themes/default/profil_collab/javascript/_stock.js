// gestion des stocks

function stock_etat_imprimer () {			
		var f_aff_pa_s= "0";
		var f_aff_info_tracab_s= "0";
		var id_stock_s = "";
		
		if ($F("aff_pa_s")=="1") { f_aff_pa_s="1";}
		if ($("aff_info_tracab_s")){
			if ($F("aff_info_tracab_s")=="1") { f_aff_info_tracab_s="1";}
		}
		
		id_stock_s = "";
				
		if ($F('id_stock_l').length >0) {
			id_stock_s = $F('id_stock_l');
			window.open('stocks_editing.php?ref_art_categ='+$F('ref_art_categ_s')+'&ref_constructeur='+$F('ref_constructeur_s')+'&aff_pa='+f_aff_pa_s+'&aff_info_tracab='+f_aff_info_tracab_s+'&orderby='+$F('orderby_s')+'&orderorder='+$F('orderorder_s')+'&id_stocks='+id_stock_s+'&in_stock='+$F("in_stock_s")+'', '_blank');
		}
	
}




//r�sum� des num�ros de serie dans les mouvements de stock

function show_resume_stock_sn (ref_article, evt) {
	if (	$('resume_stock_move_sn').style.display == 'block'  ) {
		$('resume_stock_move_sn').style.display='none'; 
		$('resume_stock_move_sn_iframe').style.display='none';
	} else {
		$('resume_stock_move_sn').style.display='none'; 
		$('resume_stock_move_sn_iframe').style.display='none'; 
		
		var AppelAjax = new Ajax.Updater(
								"resume_stock", 
								"stocks_resume_sn.php", {
								method: 'post',
								asynchronous: true,
								contentType:  'application/x-www-form-urlencoded',
								encoding:     'UTF-8',
								parameters: { ref_article: ref_article},
								evalScripts:true, 
								onLoading:S_loading, onException: function () {S_failure();}, 
								onComplete:function () {
										$("resume_stock_move_sn_iframe").style.height = return_height_element("resume_stock_move_sn") +"px";
										$("resume_stock_move_sn_iframe").style.width = return_width_element("resume_stock_move_sn") +"px"; 
										centrage_element('resume_stock_move_sn');
										centrage_element('resume_stock_move_sn_iframe');
										$('resume_stock_move_sn').style.display='block'; 
										$('resume_stock_move_sn_iframe').style.display='block'; 
										H_loading(); 
										}
								}
								);
	}
}

function stock_a_renouveller() {
		var id_stock = "";
		if ($('id_stock')) {
			id_stock = $('id_stock').value;
		}
		
		var AppelAjax = new Ajax.Updater(
									"a_renouveller_resultat", 
									"stocks_a_renouveller_result.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { recherche: '1', page_to_show: $F('page_to_show_s'), orderby: $F('orderby_s'), orderorder: $F('orderorder_s'), id_stock: $F('id_stock'), ref_art_categ: $F('ref_art_categ_s'), ref_constructeur: $F('ref_constructeur_s')},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading}
									);
	}



function stock_a_transferer() {

		
		var AppelAjax = new Ajax.Updater(
									"a_transferer_resultat", 
									"stocks_a_transferer_result.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { recherche: '1', page_to_show: $F('page_to_show_s'), stock_depart: $F("stock_depart"), stock_arrivee: $F("stock_arrivee"), ref_art_categ: $F('ref_art_categ_s'), ref_constructeur: $F('ref_constructeur_s')},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();}, 
									onComplete:H_loading}
									);
	}
