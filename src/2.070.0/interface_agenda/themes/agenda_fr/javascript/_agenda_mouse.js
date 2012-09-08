//###########################################################################
//COORDONNEES
//###########################################################################
function getCoordsOfEvent(node){
	if(node.nodeType == 1 && node.nodeName != "body"){
		//nodeType == 1 -> ELEMENT
		var c = getCoordsOfEvent(node.parentNode);
		if(node.nodeName == "TD")
		{	return {x:c.x+node.offsetLeft, y:c.y+0};}
		if(node.nodeName == "DIV")
			{return {x:c.x, y:node.offsetHeight};}//+node.offsetLeft
		return {x:c.x+node.offsetLeft, y:c.y+node.offsetTop};
	}
	else{
		return {x:0, y:0};
	}
}

function mouseCoordsSemaine(ev){
	if(ev.pageX || ev.pageY){
		return {x:ev.pageX, y:ev.pageY};
	}
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
}

function getCoordsOnGride(node){
	//$("debug_tx").value += "node.nodeName: " + node.nodeName;
	if(node.nodeType == 1//ELEMENT
		&& node.nodeName != "body"){
		var c = getCoordsOnGride(node.parentNode);
		if(node.nodeName == "TD")
		{	return {x:c.x+node.offsetLeft, y:c.y+0};}
		return {x:c.x+node.offsetLeft, y:c.y+node.offsetTop};
	}
	else{
		return {x:0, y:0};
	}
}

//###########################################################################
//CALCUL DE POSITION
//###########################################################################
//
//return 
//		ecart : écartement
//		prof : profondeur pour laquelle l'écart est valable
function calculEcartementSAVE(heures, index){
	if(!index)
	{	index = 0;}
	if(heures.length > index){
		if(heures[index].length > 0){
			var ecartement = calculEcartement(heures, index + 1);
			return {ecart:Math.max(ecartement.ecart, heures[index].length), prof:ecartement.prof + 1};
		}else{
			return {ecart:0, prof:0};
		}
	}else{
		return {ecart:0, prof:0};
	}
}

function calculEcartement(heures, index){
	if(!index)
	{	index = 0;}
	var e = heures[index].length;
	if (e == 0)
	{return {ecart:0, prof:0};}
	var p = 1;
	index++;
	var inter;
	while(index < heures.length){
		inter = heures[index].intersect(heures[index-1]);
		//$("textdebug").value += "\n " + inter.length;
		if(inter.length == 0){break;}
		e = Math.max(e, heures[index].length);
		p++;
		index++;
	}
	return {ecart: e, prof: p};
}

function ecarterEvenements(j){//jour

	h = 0;
	var ecrtement = null;
	var prof  = 0;
	var e = 0;
	var index = 0;
	var temp = null;
	var tempJour = new Array();
	tEcrtements = new Array();
	while(h<48){
		ecrtement = calculEcartement(matriceDemieHeure[j], h);
		tEcrtements.unshift(ecrtement);
		matriceDemieHeure[j][h].reverse(reverseByHeight);
		tempJour.unshift(matriceDemieHeure[j][h].slice(0));
		if(ecrtement.ecart > 1 && ecrtement.prof > 1){
			for(p = 1; p < ecrtement.prof; p++){
				tEcrtements.unshift(ecrtement);
				h++;
				matriceDemieHeure[j][h].reverse(reverseByHeight);
				tempJour.unshift(matriceDemieHeure[j][h].slice(0));
				e = 0;
				while(e < ecrtement.ecart){
					if(tempJour[0][e] == null){e++; continue;}
					if(tempJour[0][e] == tempJour[1][e]){e++; continue;}
					index = tempJour[1].indexOf(tempJour[0][e]);
					if(index < 0){e++; continue;}
					temp = tempJour[0][index];
					tempJour[0][index] = tempJour[0][e]; 
					tempJour[0][e] = temp;
				}
			}
		}else{
			h++;
		}
	}

	
	var eventResized = new Array(); 
	
	for(l = 0; l<tempJour.length; l++){
		if(tEcrtements[l].ecart > 0 && tEcrtements[l].prof > 0){
			for(e = 0; e < tempJour[l].length; e++){
				if( tempJour[l][e] != null){// && !eventResized.contains(tempJour[l][e])
					tempJour[l][e].resizeNode(tEcrtements[l].ecart, e);
					eventResized.push(tempJour[l][e]);
					
				}
			}
		}
	}
}


//###########################################################################
//GESTION DE LA SOURIS -- JOUR
//###########################################################################
function mouseDownJour(ev){
	ev         = ev || window.event;
	beginMousePos = mouseCoordsSemaine(ev);
	target = ev.target || ev.srcElement;
	iMouseDown = true;
	if(target != null){
		var type = target.id.substr(0,5);
		if(type == "event"){
			action = target.id.substr(6, 4);
			if(action == "edit" || action == "move")
			{	$("grilleDemieHeure").style.cursor="progress";}
			while (target){
				if(target.id && target.id.substr(0,7) == "eventId")
				{	break;}
				target = target.parentNode;
			}
			if(gride_is_locked && target.id.substr(8)!=$("id_graphic_event").value){
				action = "";
				$("grilleDemieHeure").style.cursor="not-allowed";
			}else{
				var tmpEvenement = evenements[target.id.substr(8)];
				if($("id_graphic_event").value != tmpEvenement.id){
					panneau_eition_reset_formulaire();
					if(tmpEvenement.getModif_bool(true) != 0){
						disableContenu("panneau_event_edition");
						if(tmpEvenement.getDetail_bool(true) == 0 && typeof(tmpEvenement.getDetail_bool(true)) != "undefined"){
							tmpEvenement.showOnPanel(true, true);
						}
					}else{
						enableContenu("panneau_event_edition");
						tmpEvenement.showOnPanel(true, false);
					}
				}
				if(tmpEvenement.canMove(true)){
					if(tmpEvenement.getModif_bool(true) == 0 || typeof(tmpEvenement.getDetail_bool(true)) == "undefined"){
						evenementUsed = tmpEvenement;
					}
				}else{
					evenementUsed = null;
					$("grilleDemieHeure").style.cursor="not-allowed";
					action = "";
				}
			}
		}else{
			if(!gride_is_locked && type == "gride"){	
				action = "nouv";
				panneau_eition_reset_formulaire();
			}
			else{action = "";}
		}
	}else
	{	evenementUsed = null;}
}

function mouseMoveJour(ev){

}

function mouseUpJour(ev){
	$("grilleDemieHeure").style.cursor="default";
	ev         = ev || window.event;
	var mousePos = mouseCoordsSemaine(ev);

	iMouseDown = false;

	if(evenementUsed != null && ( (gride_is_locked && $("id_graphic_event").value == evenementUsed.id) || !gride_is_locked) ){//On est sur un event
		if(action == "move"){//On vient de modifier la position de l'event -> On doit l'enregistrer
			if(evenementUsed.move(0, mousePos.y, true)){
				evenementUsed.showOnPanel(true, false);
				ecarterEvenements(0);
			}
		}else if(action == "edit"){//On vient de modifier la taille de l'event -> On doit l'enregistrer
			if(evenementUsed.edit(0, mousePos.y)){
				evenementUsed.showOnPanel(true, false);
				ecarterEvenements(0);
			}
		}
	}else{
		if(!gride_is_locked && action == "nouv"){//nouveau
			enableContenu("panneau_event_edition");
			var id = genIdGraphicEvent();
			var coords = getCoordsOnGride($("ZEROjour").parentNode);
			if(beginMousePos.x == mousePos.x && beginMousePos.y == mousePos.y){//c'est un clic sur la grille -> création d'un event d'1h
				var new_y = Math.floor((mousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_jour").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
				var eventNode = CreateDivEvenement("eventId_"+id, new_y, 0, evenementMaxWidthJour(), HAUTEUR_DEMIE_HEURE*2, "");
				$("ZEROjour").appendChild(eventNode);
				//			new_Evenement(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event)
				var event = new_Evenement($("grille_jour"),$("ZEROjour"), eventNode);
				evenements[id] = event;
				event.addIntoMatrice();
				event.showOnPanel(true, false);
			}else{//c'est une sélection sur la grille -> création d'un évenement de X h
				var y_deDeb = Math.floor((beginMousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_jour").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
				var y_deFin = Math.floor((mousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_jour").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
				
				var b = true;
				if(b && y_deDeb < y_deFin){
					var h = Math.max(2*HAUTEUR_DEMIE_HEURE, y_deFin - y_deDeb + HAUTEUR_DEMIE_HEURE);
					var eventNode = CreateDivEvenement("eventId_"+id, y_deDeb, 0, evenementMaxWidthJour(), h, "");
					$("ZEROjour").appendChild(eventNode);
					//				new_Evenement(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event)
					evenementUsed = new_Evenement($("grille_jour"),$("ZEROjour"), eventNode);
					evenements[id] = evenementUsed;
					evenementUsed.addIntoMatrice();
					evenementUsed.showOnPanel(true, false);
					b= false;
				}
				if(b && y_deDeb > y_deFin){
					var h = Math.max(2*HAUTEUR_DEMIE_HEURE, y_deDeb - y_deFin + HAUTEUR_DEMIE_HEURE);
					var eventNode = CreateDivEvenement("eventId_"+id, y_deFin, 0, evenementMaxWidthJour(), h, "");
					$("ZEROjour").appendChild(eventNode);
					//				new_Evenement(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event)
					evenementUsed = new_Evenement($("grille_jour"),$("ZEROjour"), eventNode);
					evenements[id] = evenementUsed;
					evenementUsed.addIntoMatrice();
					evenementUsed.showOnPanel(true, false);
					b= false;
				}
				if(b){//y_deDeb == y_deFin
					var eventNode = CreateDivEvenement("eventId_"+id, y_deFin, 0, evenementMaxWidthJour(), HAUTEUR_DEMIE_HEURE*2, "");
					$("ZEROjour").appendChild(eventNode);
					//				new_Evenement(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event)
					evenementUsed = new_Evenement($("grille_jour"),$("ZEROjour"), eventNode);
					evenements[id] = evenementUsed;
					evenementUsed.addIntoMatrice();
					evenementUsed.showOnPanel(true, false);
					b= false;
				}
				if(!b){
					ecarterEvenements(0);
				}
				delete b;
			}
			
			//On verrouille la grille
			gride_is_locked = true;
		}
	}
	delete evenementUsed;
	evenementUsed = null;
}


//###########################################################################
//GESTION DE LA SOURIS -- SEMAINE
//###########################################################################
function mouseDownSemaine(ev){
	ev         = ev || window.event;
	beginMousePos = mouseCoordsSemaine(ev);
	target = ev.target || ev.srcElement;

	iMouseDown = true;
	if(target != null){
		var type = target.id.substr(0,5);
		if(type == "event"){
			
			action = target.id.substr(6, 4);
			if(action == "edit" || action == "move")
			{	$("grilleDemieHeure").style.cursor="progress";}
			while (target){
				if(target.id && target.id.substr(0,7) == "eventId")
				{	break;}
				target = target.parentNode;
			}
			if(gride_is_locked && target.id.substr(8)!=$("id_graphic_event").value){
				action = "";
				$("grilleDemieHeure").style.cursor="not-allowed";
			}else{
				var tmpEvenement = evenements[target.id.substr(8)];
				if($("id_graphic_event").value != tmpEvenement.id){
					panneau_eition_reset_formulaire();
					if(tmpEvenement.getModif_bool(true) != 0 && typeof(tmpEvenement.getDetail_bool(true)) != "undefined"){
						disableContenu("panneau_event_edition");
						if(tmpEvenement.getDetail_bool(true) == 0){
							tmpEvenement.showOnPanel(true, true);
						}
					}else{
						enableContenu("panneau_event_edition");
						tmpEvenement.showOnPanel(true, false);
					}
				}
				if(tmpEvenement.canMove(true)){
					if(tmpEvenement.getModif_bool(true) == 0 || typeof(tmpEvenement.getDetail_bool(true)) == "undefined"){
						evenementUsed = tmpEvenement;
					}
				}else{
					evenementUsed = null;
					$("grilleDemieHeure").style.cursor="not-allowed";
					action = "";
				}
			}
		}else{
			if(!gride_is_locked && type == "gride"){	
				action = "nouv";
				panneau_eition_reset_formulaire();
				idNew = genIdGraphicEvent();
		        var coords = getCoordsOnGride($("ZEROsemaine").parentNode);        
		        
		        var new_x = Math.floor((beginMousePos.x - coords.x) / largeurColonneSemaine()) * largeurColonneSemaine();
		        var new_y = Math.floor((beginMousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_semaine").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
		        var eventNode = CreateDivEvenement("eventId_"+idNew, new_y, new_x, 100, HAUTEUR_DEMIE_HEURE*2, "");
		        
		        $("ZEROsemaine").appendChild(eventNode);
		        var eventNew = new_Evenement($("grille_semaine"),$("ZEROsemaine"), eventNode);//new evenement(eventNode);//, new_x, new_y);
		        
		        evenements[idNew] = eventNew;
		        //eventNew.addIntoMatrice();
		        //eventNew.showOnPanel();
		        //ecarterEvenements(eventNew.cellJour);
		        //FKV 14/03/2010 FIN
		        evenements[idNew].setColors();
			}
			else{action = "";}
		}
	}else
	{	evenementUsed = null;}
}

function mouseMoveSemaine(ev){
	  ev     = ev || window.event;
	  target = ev.target || ev.srcElement;
	  var mousePos = mouseCoordsSemaine(ev);

	  if(target != null){ 
		var type = target.id.substr(0,5);
	    var coords = getCoordsOnGride($("ZEROsemaine").parentNode);
	    
	    if(iMouseDown && !gride_is_locked && (type == "event" || type == "gride") && action != "nouv" ){//modification d'un évenement déjà existant
	      if(typeof(h_old)=='undefined'){h_old = 0;}

	    	if(h_old != h){
		    	h_old = h;
		    	if(action == "move"){//On vient de modifier la position de l'event -> On doit l'enregistrer
						var oldDay = evenementUsed.cellJour;
						if(evenementUsed.move(mousePos.x, mousePos.y)){
							//evenementUsed.showOnPanel();
							ecarterEvenements(evenementUsed.cellJour);
							if(oldDay != evenementUsed.cellJour)
							{	ecarterEvenements(oldDay);}
						}
				}else if(action == "edit"){//On vient de modifier la taille de l'event -> On doit l'enregistrer
						if(evenementUsed.edit(mousePos.x, mousePos.y)){
							//evenementUsed.showOnPanel();
							ecarterEvenements(evenementUsed.cellJour);
						}
				}
		  	}
	    }
	    if(!gride_is_locked && iMouseDown && (type == "event" || type == "gride") &&action == "nouv"){//modification du nouvel évenement créé 

	      eventNew = evenements[idNew];
	      
	      var x_deDeb = Math.floor((beginMousePos.x - coords.x) / largeurColonneSemaine()) * largeurColonneSemaine();
	      var y_deDeb = Math.floor((beginMousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_semaine").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
	      var y_deFin = Math.floor((mousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_semaine").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
	      
	      if(typeof(h_old)=='undefined'){h_old = 0;}
	      
	      if(h_old != h){
	    	  h_old = h;
	    	  //$("event_moveG"+idNew).innerHTML = "test";
	    	  //alert(y_deFin_old+" - "+y_deFin);
		      if(y_deDeb < y_deFin){//déplacement vers le bas -> redimensionnement simple
		        var h = Math.max(2*HAUTEUR_DEMIE_HEURE, y_deFin - y_deDeb + HAUTEUR_DEMIE_HEURE);
		        $("grilleDemieHeure").style.cursor="n-resize";
		        eventNew.edit(mousePos.x, mousePos.y);
				//eventNew.showOnPanel();
				ecarterEvenements(eventNew.cellJour);
		      }
		      if( y_deDeb > y_deFin){//déplacement vers le haut -> repositionnement de la div + redimensionnement
		        var h = Math.max(2*HAUTEUR_DEMIE_HEURE, y_deDeb - y_deFin + HAUTEUR_DEMIE_HEURE);
		        eventNew.move(mousePos.x, mousePos.y)
		        eventNew.edit(beginMousePos.x, beginMousePos.y);
		        //eventNew.showOnPanel();
				ecarterEvenements(eventNew.cellJour);
		      }
	      }
	    }
	  }
}

function mouseUpSemaine(ev){
		$("grilleDemieHeure").style.cursor="default";
		ev         = ev || window.event;
		var mousePos = mouseCoordsSemaine(ev);
	
		iMouseDown = false;
	
		if(evenementUsed != null && ( (gride_is_locked && $("id_graphic_event").value == evenementUsed.id) || !gride_is_locked) ){//On est sur un event
			if(action == "move"){//On vient de modifier la position de l'event -> On doit l'enregistrer
				var oldDay = evenementUsed.cellJour;
				if(evenementUsed.move(mousePos.x, mousePos.y, true)){
					evenementUsed.showOnPanel(true, false);
					ecarterEvenements(evenementUsed.cellJour);
					if(oldDay != evenementUsed.cellJour)
					{	ecarterEvenements(oldDay);}
				}
			}else if(action == "edit"){//On vient de modifier la taille de l'event -> On doit l'enregistrer
				if(evenementUsed.edit(mousePos.x, mousePos.y)){
					evenementUsed.showOnPanel(true, false);
					ecarterEvenements(evenementUsed.cellJour);
				}
			}
		}else{
			if(!gride_is_locked && action == "nouv"){//nouveau
				enableContenu("panneau_event_edition");
				var id = idNew;//genIdGraphicEvent();
				var event = evenements[id];
				//event.addIntoMatrice();
				event.showOnPanel(true);
				//ecarterEvenements(event.cellJour);
				/*
				var coords = getCoordsOnGride($("ZEROsemaine").parentNode);
				if(beginMousePos.x == mousePos.x && beginMousePos.y == mousePos.y){//c'est un clic sur la grille -> création d'un event d'1h
					var new_x = Math.floor((mousePos.x - coords.x) / largeurColonneSemaine()) * largeurColonneSemaine();
					var new_y = Math.floor((mousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_semaine").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
					var eventNode = CreateDivEvenement("eventId_"+id, new_y, new_x, evenementMaxWidthSemaine(), HAUTEUR_DEMIE_HEURE*2, "");
					$("ZEROsemaine").appendChild(eventNode);
					var event = new_Evenement($("grille_semaine"),$("ZEROsemaine"), eventNode);
					evenements[id] = event;
					event.addIntoMatrice();
					event.showOnPanel(true, false);
				}else{//c'est une sélection sur la grille -> création d'un évenement de X h
					var x_deDeb = Math.floor((beginMousePos.x - coords.x) / largeurColonneSemaine()) * largeurColonneSemaine();
					var y_deDeb = Math.floor((beginMousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_semaine").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
					var y_deFin = Math.floor((mousePos.y - coords.y + $("sub_content").scrollTop +  $("grille_semaine").scrollTop) / HAUTEUR_DEMIE_HEURE) * HAUTEUR_DEMIE_HEURE;
					
					var b = true;
					if(b && y_deDeb < y_deFin){
						var h = Math.max(2*HAUTEUR_DEMIE_HEURE, y_deFin - y_deDeb + HAUTEUR_DEMIE_HEURE);
						var eventNode = CreateDivEvenement("eventId_"+id, y_deDeb, x_deDeb, evenementMaxWidthSemaine(), h, "");
						$("ZEROsemaine").appendChild(eventNode);
						evenementUsed = new_Evenement($("grille_semaine"),$("ZEROsemaine"), eventNode);
						evenements[id] = evenementUsed;
						evenementUsed.addIntoMatrice();
						evenementUsed.showOnPanel(true, false);
						b= false;
					}
					if(b && y_deDeb > y_deFin){
						var h = Math.max(2*HAUTEUR_DEMIE_HEURE, y_deDeb - y_deFin + HAUTEUR_DEMIE_HEURE);
						var eventNode = CreateDivEvenement("eventId_"+id, y_deFin, x_deDeb, evenementMaxWidthSemaine(), h, "");
						$("ZEROsemaine").appendChild(eventNode);
						evenementUsed = new_Evenement($("grille_semaine"),$("ZEROsemaine"), eventNode);
						evenements[id] = evenementUsed;
						evenementUsed.addIntoMatrice();
						evenementUsed.showOnPanel(true, false);
						b= false;
					}
					if(b){//y_deDeb == y_deFin
						var eventNode = CreateDivEvenement("eventId_"+id, y_deFin, x_deDeb, evenementMaxWidthSemaine(), HAUTEUR_DEMIE_HEURE*2, "");
						$("ZEROsemaine").appendChild(eventNode);
						evenementUsed = new_Evenement($("grille_semaine"),$("ZEROsemaine"), eventNode);
						evenements[id] = evenementUsed;
						evenementUsed.addIntoMatrice();
						evenementUsed.showOnPanel(true, false);
						b= false;
					}
					if(!b){
						ecarterEvenements(evenementUsed.cellJour);
					}
					delete b;
				}*/
				
				//On verrouille la grille
				gride_is_locked = true;
			}
		}
		delete evenementUsed;
		evenementUsed = null;
}


//###########################################################################
//GESTION DE LA SOURIS -- MOIS
//###########################################################################
function mouseDownMois(ev){
	iMouseDown = true;
}

function mouseMoveMois(ev){

}

function mouseUpMois(ev){
		iMouseDown = false;
}

/*
function resieze_grille_semaine(){
	$("grille_semaine").style.height = 20+"px";
	var coords = getCoordsOnGride($("ZEROsemaine").parentNode);
	
	$("grille_semaine").style.height = (Math.max(
		Math.max(document.body.scrollHeight, document.documentElement.scrollHeight),
		Math.max(document.body.offsetHeight, document.documentElement.offsetHeight),
		Math.max(document.body.clientHeight, document.documentElement.clientHeight)
		) -coords.y - $("pied_de_page").offsetHeight)+"px";
}
*/

function resieze_grille_jour(){
	$("grille_jour").style.height = 20+"px";
	var coords = getCoordsOnGride($("ZEROjour").parentNode);
	
	$("grille_jour").style.height = (Math.max(
		Math.max(document.body.scrollHeight, document.documentElement.scrollHeight),
		Math.max(document.body.offsetHeight, document.documentElement.offsetHeight),
		Math.max(document.body.clientHeight, document.documentElement.clientHeight)
		) -coords.y - $("pied_de_page").offsetHeight)+"px";
}
