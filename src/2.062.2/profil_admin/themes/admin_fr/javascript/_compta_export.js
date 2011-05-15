
	// verif values, bckg rouge si non choisi
	function compta_export_form_verif(element_name){
		if($(element_name).value == ""){
			$(element_name).focus;
			return false;
		}
		var element_span_name = "span_"+element_name;
		$(element_span_name).setStyle ({backgroundColor: ''});
		return true;
	}
	//	appel ajax step classiques
	function compta_export_next_step(step)  {
		var AppelAjax = new Ajax.Updater(
			"div_ajax_step_"+step, 
			"compta_journal_veac_export_steps.php", {
			method: 'post',
			asynchronous: true,
			contentType:  'application/x-www-form-urlencoded',
			encoding:     'UTF-8',
			parameters: $('form_exportation').serialize(false)+"&step="+step,
			evalScripts:true, 
			onLoading:S_loading, onException: function (){S_failure();}, 
			onComplete:H_loading}
			);
	}
	
	//	appel ajax step in 4 ( export )
	function compta_export_valid(step,substep)  { 
		step = step+substep;
		var AppelAjax = new Ajax.Updater(
			"div_ajax_step_4", 
			"compta_journal_veac_export_steps.php", {
			method: 'post',
			asynchronous: true,
			contentType:  'application/x-www-form-urlencoded',
			encoding:     'UTF-8',
			parameters: $('form_exportation').serialize(false)+"&step="+step,
			evalScripts:true, 
			onLoading:S_loading, onException: function (){S_failure();}, 
			onComplete:H_loading}
			);
	}
	
	//	appel ajax steps creation personnalisés
	function compta_export_modele_perso(step,substep)  { 
		step = step+substep;
		var AppelAjax = new Ajax.Updater(
			"div_ajax_step_3", 
			"compta_journal_veac_export_steps.php", {
			method: 'post',
			asynchronous: true,
			contentType:  'application/x-www-form-urlencoded',
			encoding:     'UTF-8',
			parameters: $('form_exportation').serialize(false)+"&step="+step,
			evalScripts:true, 
			onLoading:S_loading, onException: function (){S_failure();}, 
			onComplete:H_loading}
			);
	}
	
	//feed select
	function compta_export_add_option(id,value,selected,id_select){
		$(id_select).disabled = '';
		var opt = document.createElement('option');
		opt.value = id;
		opt.text = value;
		opt.selected = selected;
		$(id_select).options.add(opt);
		return true;
	}
	
	//no models
	function compta_export_no_options(id_select){
		$(id_select).disabled = 'disabled';
		var opt = document.createElement('option');
		opt.value = false;
		opt.text = 'Aucune informations disponible';
		$(id_select).options.add(opt);
		return false;
	}
	
	//reset select
	function compta_export_reset_select(id_select){
		$(id_select).disabled = '';
		while($(id_select).length > 0){
			$(id_select).remove(0);
		}
		return false;
	}
	
	// div hidder from step
	function compta_export_div_hidder(step){
		for(i=step;i<=4;i++){
			$("div_export_choix_step_"+i).hide();
		}
	}
	// reset
	function compta_export_reset(){
		var step = 2;
		for(i=step;i<=4;i++){
			$("div_export_choix_step_"+i).hide();
		}
		var AppelAjax = new Ajax.Request('compta_journal_veac_export_steps.php?step=cancel', {
			onLoading:S_loading, onException: function (){S_failure();}, 
			onComplete:H_loading
		});
	}
	// end
	function compta_export_end(){
		var step = 1;
		for(i=step;i<=3;i++){
			$("div_export_choix_step_"+i).hide();
		}
		var AppelAjax = new Ajax.Request('compta_journal_veac_export_steps.php?step=cancel', {
			onLoading:S_loading, onException: function (){S_failure();}, 
			onComplete:H_loading
		});
	}
	// on valid lock all
	function compta_export_valid_lock(formulaire_id){
		formulaire	= document.getElementById(formulaire_id);
		//	pour chaque elements du formulaire = disabled
		for (element_index in formulaire.elements ){
			formulaire.elements[element_index].disabled = 'disabled';
		}
		return true;
	}
	// on valid lock all
	function compta_export_valid_unlock(formulaire_id){
		formulaire	= document.getElementById(formulaire_id);
		//	pour chaque elements du formulaire = disabled
		for (element_index in formulaire.elements ){
			formulaire.elements[element_index].disabled = '';
		}
		return true;
	}
	
	
	
	// continue
	function compta_export_continue(){
		$("div_export_choix_step_1").show();
		var step = 2;
		for(i=step;i<=4;i++){
			$("div_export_choix_step_"+i).hide();
		}
		var AppelAjax = new Ajax.Request('compta_journal_veac_export_steps.php?step=cancel', {
			onLoading:S_loading, onException: function (){S_failure();}, 
			onComplete:H_loading
		});
	}
	
	function copySelected(from, to) { 
		from	= document.getElementById(from);
		to		= document.getElementById(to);
		var opt = document.createElement('option');
		opt.value = from.options[from.options.selectedIndex].value;
		opt.text = from.options[from.options.selectedIndex].text;
		to.options.add(opt);
		return true;
	}
	function deleteSelected(from) { 
		from	= document.getElementById(from);
		from.options[from.options.selectedIndex] = null;
		return true;
	}
	
	function validNewModele() { 
		var params = $('form_exportation').serialize(false);
		var modele = new Array();
		var nbOptions = $('modele_champs').length;
		modele[0] = nbOptions;
		for (i=0;i<nbOptions;i++){
			modele[i+1] = $('modele_champs').options[i].value;
		}
		
		var AppelAjax = new Ajax.Request('compta_journal_veac_export_valid_new_modele.php?'+$H(modele).toQueryString()+params, {
			onLoading:S_loading, onException: function (){S_failure();}, 
			onComplete:H_loading
		});

	}