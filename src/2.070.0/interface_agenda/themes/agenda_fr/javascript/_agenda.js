function panneauGaucheAddListener(check){
	check.each(function(el) {
		Event.observe(el, 'keydown', function(evt) {
			if(evt.keyCode == 13){//ENTRER
				switch($("panneau_deition_curent_mode").value){
					case panneau_deition_modes.creation : { ValiderEvent(scale_used); break; }
					case panneau_deition_modes.edition  : { MajEvent(scale_used); break; }
					default: {break;}
				}
				return;
			}
			if(evt.keyCode == 27){//Echap
				switch($("panneau_deition_curent_mode").value){
					case panneau_deition_modes.creation : { AnnulerEvent(scale_used); break; }
					case panneau_deition_modes.edition  : { panneau_eition_reset_formulaire(); break; }
					default: {break;}
				}
				return;
			}
		}, false);
	});
}


function refresh_grille_agenda(Udate){
	if(Udate != undefined)
	Udate_used = Udate;
	switch (scale_used){
		case "jour":{
			page.traitecontent("agenda_jour","agenda_view_jour.php?Udate_used="+Udate_used+"&HEURE_DE_DEPART=" + $("grille_jour").scrollTop, true ,"grille_agenda");
		break;}
		case "mois":{
			page.traitecontent("agenda_mois","agenda_view_mois.php?Udate_used="+Udate_used, true ,"grille_agenda");
		break;}
		case "semaine":{
			page.traitecontent("agenda_semaine","agenda_view_semaine.php?Udate_used="+Udate_used+"&HEURE_DE_DEPART=" + $("grille_semaine").scrollTop, true ,"grille_agenda");
		break;}
	}
}




function resizeMaxHeight(){
	var windowHeight = getWindowHeight();
	$("panneau_gauche").style.maxHeight = (windowHeight-365)+"px";
	$("panneau_event_edition").style.maxHeight = (windowHeight-200)+"px";
	
	switch (scale_used) {
	case "jour":{
		$("grille_jour").style.maxHeight = (windowHeight-185)+"px";
		ecarterEvenements(0);
		break;}
	case "semaine":{
		$("grille_semaine").style.maxHeight = (windowHeight-185)+"px";
		ecarterEvenements(0);
		ecarterEvenements(1);
		ecarterEvenements(2);
		ecarterEvenements(3);
		ecarterEvenements(4);
		ecarterEvenements(5);
		ecarterEvenements(6);
		break;}
	case "mois":{
		$("grille_mois").style.maxHeight = (windowHeight-185)+"px";
		break; }
	}
}
//###########################################################################
//VERIFICATION DE FORMULAIRE
//###########################################################################
function genLibEvent(){
	return "LIB";
}

function getHeure(str_heure){// en milliseconds
	//  ************************************************
	var s_regex_heure =  "(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])";
		s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3])h([0-5][0-9])";
		s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3])H([0-5][0-9])";
		s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3])-([0-5][0-9])";
		s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3]) ([0-5][0-9])";
	var regex_heure = new RegExp(s_regex_heure,"i");

	var regex_heure_separateur = new RegExp("[\-hH\:]","g");
	
	//  ************************************************
	if(str_heure == "")
	{		return Number.NaN;}
	else{if(!regex_heure.test(str_heure))
	{		return Number.NaN;}}
	
	var date_fin;
	
	//  ************************************************
	var heure;
	var t_heureD = str_heure.split(regex_heure_separateur);
	heure = new Date(0);
	heure.setHours(parseInt(t_heureD[0], 10));
	heure.setMinutes(parseInt(t_heureD[1], 10));

	//  ************************************************
	if(heure == null)
	{			return Number.NaN;}
	else{	return heure.getTime();}
	//  ************************************************
}

function buildStrTime(h, separateur, m){
	var time = "";
	if(h<10){time += "0"+h+separateur;}
	else{time += h+separateur;}

	if(m<10){time += "0"+m;}
	else{time += m;}
	
	return time;
}

function panneau_edition_verifier_formulaire(){
	text_alertes = {
		lib: "Le titre de l'événement n'est pas spécifié.",
		date_de_deb: "La date de début de l'événement est incorrecte",
		date_de_fin: "La date de fin de l'événement est incorrecte",
		heure_de_deb: "L'heure de début de l'événement est incorrecte",
		heure_de_fin: "L'heure de fin de l'événement est incorrecte",
		qte : "La quantité saisie est nulle"
	};
	
	alertes = new Array();
		
	//  evt_edition_lib  *****************************************************
	var alert_lib = false;
	if($("evt_edition_lib2").value == ""){
		alertes.push(text_alertes.lib);
	}
	
	//  evt_edition_date & evt_edition_heure  ******************************
	var alert_date_deb = false;
	var alert_date_fin = false;
	var alert_heure_deb = false;
	var alert_heure_fin = false;
	var alert_qte = false;
	
	var s_regex_date = 	 "(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/(19[7-9][0-9]|20[0-3][0-9])";
	s_regex_date += 	"|(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(19[7-9][0-9]|20[0-3][0-9])";
	s_regex_date += 	"|(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[0-2])\.(19[7-9][0-9]|20[0-3][0-9])";
	s_regex_date += 	"|(0[1-9]|[12][0-9]|3[01]) (0[1-9]|1[0-2]) (19[7-9][0-9]|20[0-3][0-9])";
	var regex_date = new RegExp(s_regex_date,"i");
	
	var s_regex_heure =  "(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])";
	s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3])h([0-5][0-9])";
	s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3])H([0-5][0-9])";
	s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3])-([0-5][0-9])";
	s_regex_heure += 	"|(0[0-9]|1[0-9]|2[0-3]) ([0-5][0-9])";
	var regex_heure = new RegExp(s_regex_heure,"i");
	
	var regex_date_separateur  = new RegExp("[\-\.\s/]","g");
	var regex_heure_separateur = new RegExp("[\-hH\:]","g");
	
	//  evt_edition_date_deb  ************************************************
	if($("evt_edition_date_deb").value == ""){
		alertes.push(text_alertes.date_de_deb);
		alert_date_deb = true;
	}else{if(!regex_date.test($("evt_edition_date_deb").value)){
		alertes.push(text_alertes.date_de_deb);
		alert_date_deb = true;
	}}
	
	//  evt_edition_heure_deb  ************************************************
	if($("evt_edition_heure_deb").value == ""){
		alertes.push(text_alertes.heure_de_deb);
		alert_heure_deb = true;
	}else{if(!regex_heure.test($("evt_edition_heure_deb").value)){
		alertes.push(text_alertes.heure_de_deb);
		alert_heure_deb = true;
	}}
	
	//  evt_edition_date_fin  ************************************************
	if($("evt_edition_date_fin").value == ""){
		alertes.push(text_alertes.date_de_fin);
		alert_date_fin = true;
	}else{if(!regex_date.test($("evt_edition_date_fin").value)){
		alertes.push(text_alertes.date_de_fin);
		alert_date_fin = true;
	}}
	
	//  evt_edition_heure_fin  ************************************************
	if($("evt_edition_heure_fin").value == ""){
		alertes.push(text_alertes.heure_de_fin);
		alert_heure_fin = true;
	}else{if(!regex_heure.test($("evt_edition_heure_fin").value)){
		alertes.push(text_alertes.heure_de_fin);
		alert_heure_fin = true;
	}}
	
	//  evt_edition_qte        ************************************************
	if($("evt_edition_qte"))
	{
		if($("evt_edition_qte").value == ""){
			alertes.push(text_alertes.qte);
			alert_qte = true;
		}
	}
	var date_fin;
	
	//  evt_edition_date_deb && evt_edition_heure_deb  **********************
	if(!alert_date_deb && !alert_heure_deb){
		var t_dateD  = $("evt_edition_date_deb").value.split(regex_date_separateur);
		var t_heureD = $("evt_edition_heure_deb").value.split(regex_heure_separateur);
		date_deb = new Date(parseInt(t_dateD[2], 10), parseInt(t_dateD[1], 10)-1, parseInt(t_dateD[0], 10), parseInt(t_heureD[0], 10), parseInt(t_heureD[1], 10), 0, 0);
		
		delete(t_dateD);delete(t_heureD);
		
		if(date_deb == null){
			alertes.push(text_alertes.date_de_deb);
			alertes.push(text_alertes.date_de_deb);
			alert_date_deb = true;
			alert_heure_deb = true;
		}
	}
	
	//  evt_edition_date_fin && evt_edition_heure_fin  **********************
	if(!alert_date_fin && !alert_heure_fin){
		var t_dateF  = $("evt_edition_date_fin").value.split(regex_date_separateur);
		var t_heureF = $("evt_edition_heure_fin").value.split(regex_heure_separateur);
		date_fin = new Date(parseInt(t_dateF[2], 10), parseInt(t_dateF[1], 10)-1, parseInt(t_dateF[0], 10), parseInt(t_heureF[0], 10), parseInt(t_heureF[1], 10), 0, 0);
		delete(t_dateF);delete(t_heureF);
		//date_deb.getTime()1264744800000date_fin.getTime()1264719600000
		if(date_fin == null){
			alertes.push(text_alertes.date_de_fin);
			alertes.push(text_alertes.heure_de_fin);
			alert_date_fin = true;
			alert_heure_fin = true;
		}
	}
	
	//  evt_edition_date_ET_heure_deb && evt_edition_date_ET_heure_fin ******
	if(!alert_date_deb && !alert_heure_deb && !alert_date_fin && !alert_heure_fin && date_deb.getTime() >= date_fin.getTime()){
		alert("["+$("evt_edition_date_deb").value+" "+$("evt_edition_heure_deb").value+"] ["+$("evt_edition_date_fin").value+" "+$("evt_edition_heure_fin").value+"]");
		alert(" date_deb.getTime()"+date_deb.getTime()+"date_fin.getTime()"+date_fin.getTime());
		//1264744800000date_fin.getTime()1264719600000
		alertes.push(text_alertes.date_de_deb);
		alertes.push(text_alertes.heure_de_deb);
		alertes.push(text_alertes.date_de_fin);
		alertes.push(text_alertes.heure_de_fin);
		
		alert_date_deb = true;
		alert_heure_deb = true;
		alert_date_fin = true;
		alert_heure_fin = true;
	}
	
	if(alertes.length > 0){
		alert(("" + alertes.valueOf()).replace(/,/g,"\n"));
	}
	if($("evt_edition_qte"))
		return !(alert_date_deb || alert_heure_deb || alert_date_fin || alert_heure_fin || alert_qte);
	else
		return !(alert_date_deb || alert_heure_deb || alert_date_fin || alert_heure_fin);
}

function panneau_eition_reset_formulaire(){
	$("ref_event").value 				= "";
	$("id_graphic_event").value 		= "";
	$("evt_edition_lib").value 			= "";
	$("evt_edition_agenda_old").value 	= "";
	$("evt_edition_type_event_old").value 	= "";
	$("evt_edition_agenda_selected").selectedIndex = 0;
	$("evt_edition_type_event_selected").innerHTML = "";
	$("evt_edition_date_deb").value 	= "";
	$("evt_edition_heure_deb").value 	= "";
	$("evt_edition_date_fin").value 	= "";
	$("evt_edition_heure_fin").value 	= "";
	$("evt_edition_note").value 		= "";
	
	$("AnnulerEvent"	).hide();
	$("ValiderEvent"	).hide();
	$("SupprimerEvent"	).hide();
	$("MajEvent"		).hide();
	$("SaveNewEvent"	).hide();
	
	evt_edition_heure_deb = Number.NaN;
	evt_edition_heure_fin = Number.NaN;
	
	$("panneau_event_edition").hide();
	$("panneau_event_edit_part_evenement").hide();
	$("panneau_event_edit_part_agenda").hide();
	//$("panneau_event_edit_part_agenda_new_event").hide();
	$("panneau_event_edit_part_type_event").hide();
	//$("panneau_event_edit_part_type_event_new_event").hide();
	$("panneau_event_edit_part_dates").hide();
	$("panneau_event_edit_part_notes").hide();
	
	$("panneau_deition_curent_mode").value = 0;
}

//###########################################################################
//DIVERS
//###########################################################################
function genIdGraphicEvent(){
	return (new Date()).getTime() + "" + Math.floor(Math.random());
}


function horloge_dynamique(target) {
	if($("target")){
		var dt=new Date();
		$(target).innerHTML = "";
		if (dt.getHours()>=0 && dt.getHours()<10){$(target).innerHTML += "0"; }
		$(target).innerHTML += dt.getHours()+":";
		if (dt.getMinutes()>=0 && dt.getMinutes()<10){$(target).innerHTML += "0"; }
		$(target).innerHTML += dt.getMinutes()+":";
		if (dt.getSeconds()>=0 && dt.getSeconds()<10){$(target).innerHTML += "0"; }
		$(target).innerHTML += dt.getSeconds();
		
		window.setTimeout("horloge_dynamique('"+target+"')",1000);
	}
}

function genHexColor(){
	var colors = new Array(14);
	colors[0]="0"; colors[1] ="1"; colors[2] ="2"; colors[3] ="3"; colors[4] ="4";
	colors[5]="5"; colors[5] ="6"; colors[6] ="7"; colors[7] ="8"; colors[8] ="9";
	colors[9]="a"; colors[10]="b"; colors[11]="c"; colors[12]="d"; colors[13]="e"; colors[14]="f";

	var color= "";
	for (i=0;i<6;i++)
	{	color += colors[Math.round(Math.random()*14)];}
	return color;
}

function CreateDivEvenement(id, top, left, width, height, cssClassName){
	
	var newDiv = document.createElement("div");
	newDiv.id = id; //"DIV_DE_TEST";
	newDiv.className="event_div_principale";
	newDiv.style.top=top+"px";
	newDiv.style.left=left+"px";
	newDiv.style.width=width+"px";
	newDiv.style.height=(height-7)+"px"; //7 = la taille de la dernière div nommée : "event_edit_"+id avec la css : event_div_edition_zone
	newDiv.style.borderColor = "#e0aeaf"; //COULEUR 3
	newDiv.style.backgroundColor = "#995650";//COULEUR 2
	agendaCouleur1 = read_cook("cook_agenda_selectedC1");
	agendaCouleur2 = read_cook("cook_agenda_selectedC2");
	
	if (agendaCouleur1 != "" && agendaCouleur2 != "")
	{
		newDiv.style.backgroundColor = "#"+agendaCouleur2;//COULEUR 2
		var html_content = '<div id="event_CONETNU_'+id+'" style="height:100%;" >'+
							'<div id="event_moveG'+id+'" class="event_div_titre_G" style="background-color:#'+agendaCouleur1+';">'+//#7f2d22 = COULEUR 1
							'</div>'+
							'<div id="event_moveD'+id+'" class="event_div_titre_D" style="background-color:#'+agendaCouleur1+';">'+//#7f2d22 = COULEUR 1
							'&nbsp;'+
							'</div>'+
							'<div id="event_DESCRIP_'+id+'" class="event_div_description" style="border-color:#FEFEFE;">'+//e0aeaf = COULEUR 3
							'</div>'+
							'</div>'+
							'<div id="event_edit_'+id+'" class="event_div_edition_zone">'+
							'</div>';
	}
	else
	{
		var html_content = '<div id="event_CONETNU_'+id+'" style="height:100%;" >'+
								'<div id="event_moveG'+id+'" class="event_div_titre_G" style="background-color:#7f2d22;">'+//#7f2d22 = COULEUR 1//FKV
								'</div>'+
								'<div id="event_moveD'+id+'" class="event_div_titre_D" style="background-color:#7f2d22;">'+//#7f2d22 = COULEUR 1
								'='+
								'</div>'+
								'<div id="event_DESCRIP_'+id+'" class="event_div_description" style="border-color:#e0aeaf;">'+//e0aeaf = COULEUR 3
								'</div>'+
							'</div>'+
							'<div id="event_edit_'+id+'" class="event_div_edition_zone">'+
							'</div>';
	}
	newDiv.innerHTML = html_content;
	
	return newDiv;
}


//###########################################################################
//REQUETES AJAX
//###########################################################################

function showOnPanel(echelle, id_graphic_event, ref_event, Udate_event, duree_event, readOnly) {
	if(ref_event != undefined){
		var AppelAjax = new Ajax.Request(
				"agenda_view_event_on_panneau_edition.php", {
				method: 'post',
				asynchronous: true,
				contentType:  'application/x-www-form-urlencoded',
				encoding:     'UTF-8',
				parameters: { echelle : echelle, id_graphic_event: id_graphic_event, ref_event : ref_event, Udate_event: Udate_event, duree_event: duree_event, readonly : readOnly },
				evalScripts	:true, 
				onLoading	:S_loading,
				onException	:function () {S_failure();},
				onSuccess	:function (requester){requester.responseText.evalScripts();},
				onComplete	:H_loading
				}
			);
	}else{
		var AppelAjax = new Ajax.Request(
				"agenda_view_event_new_on_panneau_edition.php", {
				method: 'post',
				asynchronous: true,
				contentType:  'application/x-www-form-urlencoded',
				encoding:     'UTF-8',
				parameters: { echelle : echelle, id_graphic_event: id_graphic_event, ref_event : ref_event, Udate_event: Udate_event, duree_event: duree_event },
				evalScripts	:true, 
				onLoading	:S_loading,
				onException	:function () {S_failure();},
				onSuccess	:function (requester){requester.responseText.evalScripts();},
				onComplete	:H_loading
				}
			);
	}
}

function agenda_operation_maj_event(scale_used, id_graphic_event, ref_agenda, id_type_event, ref_event, event_lib, sdate_deb, sheure_deb, sdate_fin, sheure_fin, note){
	var AppelAjax = new Ajax.Request(
		"agenda_operation_maj_event.php",
		{	method: 'post',
			asynchronous: true,
			contentType:  'application/x-www-form-urlencoded',
			encoding:     'UTF-8',
			parameters	:{scale_used : scale_used, id_graphic_event: id_graphic_event, ref_agenda: ref_agenda, id_type_event: id_type_event, ref_event: ref_event, 
						  event_lib: event_lib, sdate_deb: sdate_deb, sheure_deb: sheure_deb, sdate_fin: sdate_fin, sheure_fin: sheure_fin, note: note},
			evalScripts	:true, 
			onLoading	:S_loading,
			onException	:function () {S_failure();},
			onSuccess	:function (requester){
				requester.responseText.evalScripts();
				panneau_eition_reset_formulaire();
			},
			onComplete	:H_loading
		}
		);
}

function agenda_operation_maj_event_location(scale_used, id_graphic_event, ref_agenda, id_type_event, ref_event, event_lib, sdate_deb, sheure_deb, sdate_fin, sheure_fin, note, id_stock, qte){
	var AppelAjax = new Ajax.Request(
		"agenda_operation_maj_event_location.php",
		{	method: 'post',
			asynchronous: true,
			contentType:  'application/x-www-form-urlencoded',
			encoding:     'UTF-8',
			parameters	:{scale_used : scale_used, id_graphic_event: id_graphic_event, ref_agenda: ref_agenda, id_type_event: id_type_event, ref_event: ref_event, 
						  event_lib: event_lib, sdate_deb: sdate_deb, sheure_deb: sheure_deb, sdate_fin: sdate_fin, sheure_fin: sheure_fin, note: note, id_stock:id_stock, qte:qte},
			evalScripts	:true, 
			onLoading	:S_loading,
			onException	:function () {S_failure();},
			onSuccess	:function (requester){
				requester.responseText.evalScripts();
				panneau_eition_reset_formulaire();
			},
			onComplete	:H_loading
		}
		);
}
function agenda_operation_add_event(scale_used, id_graphic_event, ref_agenda, id_type_event, event_lib, sdate_deb, sheure_deb, sdate_fin, sheure_fin, note){
	var AppelAjax = new Ajax.Request(
		"agenda_operation_add_event.php",
		{
			parameters: {scale_used : scale_used, id_graphic_event : id_graphic_event, id_type_event: id_type_event, event_lib: event_lib, ref_agenda: ref_agenda,
			 			sdate_deb: sdate_deb, sheure_deb: sheure_deb, sdate_fin: sdate_fin, sheure_fin: sheure_fin, note: note},
			evalScripts	:true,
			onLoading	:S_loading,
			onException	:function () {S_failure();},
			onSuccess	:function (requester){requester.responseText.evalScripts();},
			onComplete	:H_loading
			}
		);
}

function agenda_operation_add_event_location(scale_used, id_graphic_event, ref_agenda, id_type_event, event_lib, sdate_deb, sheure_deb, sdate_fin, sheure_fin, note, id_stock, qte){
	var AppelAjax = new Ajax.Request(
		"agenda_operation_add_event_location.php",
		{
			parameters: {scale_used : scale_used, id_graphic_event : id_graphic_event, id_type_event: id_type_event, event_lib: event_lib, ref_agenda: ref_agenda,
			 			sdate_deb: sdate_deb, sheure_deb: sheure_deb, sdate_fin: sdate_fin, sheure_fin: sheure_fin, note: note, id_stock:id_stock, qte:qte},
			evalScripts	:true,
			onLoading	:S_loading,
			onException	:function () {S_failure();},
			onSuccess	:function (requester){requester.responseText.evalScripts();},
			onComplete	:H_loading
			}
		);
}
function agenda_operation_delete_event(scale_used, id_graphic_event, ref_event){
	var AppelAjax = new Ajax.Request(
		"agenda_operation_delete_event.php",
		{
			parameters: {scale_used : scale_used, id_graphic_event : id_graphic_event, ref_event: ref_event},
			evalScripts	:true, 
			onLoading	:S_loading,
			onException	:function () {S_failure();},
			onSuccess	:function (requester){requester.responseText.evalScripts();},
			onComplete	:H_loading
			}
		);
}

function majSelect_Options_events_types(id_agenda, ref_agenda, target, droitsCibles){
	sDroitsCibles = "";
	if(droitsCibles != undefined)
	{	sDroitsCibles =  droitsCibles.valueOf();}
	var AppelAjax = new Ajax.Updater(
		target.id,
		"agenda_maj_select_options_events_types.php", {
			method			:'post',
			contentType		:'application/x-www-form-urlencoded',
			encoding		:'UTF-8',
			parameters		:{ id_agenda:id_agenda, ref_agenda: ref_agenda, droitsCibles : sDroitsCibles},
			evalScripts		:false,
			asynchronous	:false,
			onCreate		:function () {target.disabled = "disabled";},
			onException		:function () {S_failure();},
			onSuccess		:function (requester){},
			onComplete		:function () {target.disabled = "";showResponse}
		}
		);
}
function majSelect_type_formulaire(ref_agenda, target){
	//alert(ref_agenda);
	var AppelAjax = new Ajax.Updater(
		target.id,
		"agenda_maj_select_type_formulaire.php", {
			method			:'post',
			contentType		:'application/x-www-form-urlencoded',
			encoding		:'UTF-8',
			parameters		:{ref_agenda: ref_agenda},
			evalScripts		:true,
			asynchronous	:false,
			onCreate		:function () {target.disabled = "disabled";},
			onException		:function () {S_failure();},
			onSuccess		:function (requester){},
			onComplete		:function () {target.disabled = "";showResponse}
		}
		);
}
function majQte_stock(target, id_stock, ref_article, ref_agenda, date_deb, heure_deb, heure_fin){
	var AppelAjax = new Ajax.Updater(
		target,
		"agenda_maj_qte_stock.php",
		{
			method			:'post',
			contentType		:'application/x-www-form-urlencoded',
			encoding		:'UTF-8',
			parameters		:{ id_stock: id_stock, ref_article : ref_article, ref_agenda:ref_agenda, date_deb:date_deb, heure_deb:heure_deb, heure_fin:heure_fin},
			evalScripts		:false,
			asynchronous	:false,
			onCreate		:function () {target.disabled = "disabled";},
			onException		:function () {S_failure();},
			onSuccess		:function (requester){},
			onComplete		:function () {target.disabled = "";showResponse}
		}
	);
}

//###########################################################################
//FONCTION DE TRI
//###########################################################################
function sort(a, b){
	return parseInt(a.id) - parseInt(b.id);
}

function reverse(a, b){
	return parseInt(b.id) - parseInt(a.id);
}

function sortByHeight(a, b){
	return parseInt(a.height) - parseInt(b.height);
}

function reverseByHeight(a, b){
	return parseInt(b.height) - parseInt(a.height);
}



//###########################################################################
//affichage des agendas
//###########################################################################
//public majAgendasUsersAgendasAffichage(string,   string,     0/1/null,  string)
function majAgendasUsersAgendasAffichage(ref_user, ref_agenda, affichage, fonctionRetour){
	var res = false;
	var AppelAjax = new Ajax.Request(
			"agenda_operation_afficher_agenda.php",
			{
				parameters: {ref_user : ref_user, ref_agenda: ref_agenda, affichage: affichage, fonctionRetour : fonctionRetour},
				evalScripts	:true, 
				onLoading	:S_loading,
				onException	:function () { S_failure(); },
				onSuccess	:function (requester){ requester.responseText.evalScripts(); },
				onComplete	:H_loading
			}
		);
}

//public page_agenda_selectionner_agendas_result_fct_retour(string,   bool, 	string)
function page_agenda_selectionner_agendas_result_fct_retour(checkbox, checked,  ref_argenda){
	if(checked){
		$(checkbox).checked = "checked";
		$("panneau_agendas_agenda_cell_text_"+ref_argenda).className = "panneau_agendas_enable_text";
		$("panneau_agendas_agenda_ligne_"+ref_argenda).show();
	}else{
		$(checkbox).checked = "";
		$("panneau_agendas_agenda_ligne_"+ref_argenda).hide();
	}
}

//public page_accueil_fct_retour_afficher_agenda(string, 	 bool, 	string)
function page_accueil_fct_retour_afficher_agenda(span_agenda, enable, ref_argenda){
	if(enable){
		$(span_agenda).className 	= "panneau_agendas_enable_text";
	}else{
		$(span_agenda).className 	= "panneau_agendas_disable_text";
	}
	refresh_grille_agenda();
}

//###########################################################################
//affichage des types d'events
//###########################################################################
//public majAgendasUsersEventsTypesAffichage(string,   string,     	  0/1/null,  string)
function majAgendasUsersEventsTypesAffichage(ref_user, id_type_event, affichage, fonctionRetour){
	var res = false;
	var AppelAjax = new Ajax.Request(
			"agenda_operation_afficher_events_types.php",
			{
				parameters: {ref_user : ref_user, id_type_event: id_type_event, affichage: affichage, fonctionRetour: fonctionRetour},
				evalScripts	:true, 
				onLoading	:S_loading,
				onException	:function () { S_failure(); },
				onSuccess	:function (requester){ requester.responseText.evalScripts(); },
				onComplete	:H_loading
			}
		);
}

//public page_agenda_selectionner_types_events_result_fct_retour_afficher_events_types(string, 	 bool, 	int)
function page_agenda_selectionner_types_events_result_fct_retour_afficher_events_types(checkbox, enable, id_type_event){
	if(enable){
		$(checkbox).checked = "checked";
		$("panneau_agendas_event_type_cell_text_"+id_type_event).className = "panneau_agendas_enable_text";
		$("panneau_agendas_types_events_ligne_"+id_type_event).show();
	}else{
		$(checkbox).checked = "";
		$("panneau_agendas_types_events_ligne_"+id_type_event).hide();
	}
}

//public page_accueil_fct_retour_afficher_events_types(string, 			bool, 	int)
function page_accueil_fct_retour_afficher_events_types(span_event_type, enable, id_type_event){
	if(enable){
		$(span_event_type).className 	= "panneau_agendas_enable_text";
	}else{
		$(span_event_type).className 	= "panneau_agendas_disable_text";
	}
	refresh_grille_agenda();
}







//###########################################################################
//BOUTON PANNEAU EDITION EVENT
//###########################################################################
//public AnnulerEvent(string)
function AnnulerEvent(scale_used){
	var $j = evenements[$("id_graphic_event").value].cellJour;
	evenements[$("id_graphic_event").value].deleteThis();
	panneau_eition_reset_formulaire();
	ecarterEvenements($j);
	gride_is_locked = false;
}

//pulic ValiderEvent(string)
function ValiderEvent(scale_used){
	if(panneau_edition_verifier_formulaire()){
		agenda_operation_add_event(scale_used,
			$("id_graphic_event").value,
			$("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value,
			$("evt_edition_type_event_selected").options[$("evt_edition_type_event_selected").selectedIndex].value,
			$("evt_edition_lib2").value, 
			$("evt_edition_date_deb").value,
			$("evt_edition_heure_deb").value,
			$("evt_edition_date_fin").value,
			$("evt_edition_heure_fin").value,
			$("evt_edition_note").value
		);
	}
}

function ValiderEventLocation(scale_used){
	if(panneau_edition_verifier_formulaire()){
		agenda_operation_add_event_location(scale_used,
			$("id_graphic_event").value,
			$("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value,
			$("evt_edition_type_event_selected").options[$("evt_edition_type_event_selected").selectedIndex].value,
			$("evt_edition_lib2").value, 
			$("evt_edition_date_deb").value,
			$("evt_edition_heure_deb").value,
			$("evt_edition_date_fin").value,
			$("evt_edition_heure_fin").value,
			$("evt_edition_note").value,
			$("evt_choix_stock").value,
			$("evt_edition_qte").value
		);
	}
}
//public SaveNewEvent(string)
function SaveNewEvent(scale_used){
	if(panneau_edition_verifier_formulaire()){
		agenda_operation_add_event(scale_used,
			$("evt_edition_lib2").value,
			$("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value,
			$("evt_edition_date_deb").value,
			$("evt_edition_heure_deb").value,
			$("evt_edition_date_fin").value,
			$("evt_edition_heure_fin").value,
			$("evt_edition_note").value);
		$("SaveNewEvent"	).hide();
	}
}

//public MajEvent(string)
function MajEvent(scale_used){
	if(autoUpdate && panneau_edition_verifier_formulaire()){
		agenda_operation_maj_event(scale_used,
				$("id_graphic_event").value,
				$("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value,
				$("evt_edition_type_event_selected").options[$("evt_edition_type_event_selected").selectedIndex].value,
				$("ref_event").value,
				$("evt_edition_lib2").value,
				$("evt_edition_date_deb").value,
				$("evt_edition_heure_deb").value,
				$("evt_edition_date_fin").value,
				$("evt_edition_heure_fin").value, 
				$("evt_edition_note").value);
		gride_is_locked = false;
	}
}
function MajEventLocation(scale_used){
	if(autoUpdate && panneau_edition_verifier_formulaire()){
		agenda_operation_maj_event_location(scale_used,
				$("id_graphic_event").value,
				$("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value,
				$("evt_edition_type_event_selected").options[$("evt_edition_type_event_selected").selectedIndex].value,
				$("ref_event").value,
				$("evt_edition_lib2").value,
				$("evt_edition_date_deb").value,
				$("evt_edition_heure_deb").value,
				$("evt_edition_date_fin").value,
				$("evt_edition_heure_fin").value, 
				$("evt_edition_note").value,
				$("evt_choix_stock").value,
				$("evt_edition_qte").value);
		gride_is_locked = false;
	}
}

//public DelEvent(string)
function DelEvent(scale_used){
	agenda_operation_delete_event(scale_used, $("id_graphic_event").value, $("ref_event").value);
}
function disableContenu(divid){
	inputs = $(divid).getElementsByTagName('input');
	for(i=0;i<inputs.length;i++){
		$(inputs[i].id).setAttribute('readonly', 'readonly');
	}
	textareas = $(divid).getElementsByTagName('textarea');
	for(i=0;i<textareas.length;i++){
		$(textareas[i].id).setAttribute('readonly', 'readonly');
	}
	selects = $(divid).getElementsByTagName('select');
	for(i=0;i<selects.length;i++){
		$(selects[i].id).disabled = true;;
	}							
	$("MajEvent").style.visibility = "hidden";
	$("SupprimerEvent").style.visibility = "hidden";
}
function enableContenu(divid){
	inputs = $(divid).getElementsByTagName('input');
	for(i=0;i<inputs.length;i++){
		$(inputs[i].id).removeAttribute('readonly');
	}
	textareas = $(divid).getElementsByTagName('textarea');
	for(i=0;i<textareas.length;i++){
		$(textareas[i].id).removeAttribute('readonly');
	}
	selects = $(divid).getElementsByTagName('select');
	for(i=0;i<selects.length;i++){
		$(selects[i].id).disabled = false;;
	}							
	$("MajEvent").style.visibility = "visible";
	$("SupprimerEvent").style.visibility = "visible";
}
function read_cook(nom) {
    var deb,fin
    deb = document.cookie.indexOf(nom + "=")
    if (deb >= 0) {
       deb += nom.length + 1
       fin = document.cookie.indexOf(";",deb)
       if (fin < 0) fin = document.cookie.length
       return unescape(document.cookie.substring(deb,fin))
       }
    return ""
}