//###########################################################################
//###########################################################################
//###########################################################################

//DEB CLASSE EvenementJour

//###########################################################################
//###########################################################################
//###########################################################################
EvenementJour = Class.create();
EvenementJour.prototype = Object.extend(new Evenement(), {
	initialize: function(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event, detail_bool, modif_bool){
		
		this.grille = grille;
		this.zero = zero;
		this.node = node;
		this.gestionnaireEvenement = gestionnaireEvenement;
		this.id_type_agenda = id_type_agenda;
		this.ref_agenda = ref_agenda;
		this.id_type_event = id_type_event;
		this.ref_event = ref_event;
		this.detail_bool = detail_bool;
		this.modif_bool = modif_bool;
		
		this.id = "";
		
		this.x = -1; // int > 0
		this.y = -1; // int > 0
		this.originalX= -1; // int > 0
		this.originalY= -1; // int > 0
		
		this.width = -1;  // int > 0
		this.height = -1; // int > 0
		this.originalWidth = -1;  // int > 0
		this.originalHeight = -1; // int > 0
	
		this.cellJour = -1; 	// int [0-6]
		this.cellHeurDeb = -1; 	// int [0-47]
		this.cellHeurFin = -1;	// int [0-47]
	
		this.description = "";
		this.titre = "&nbsp;";
	},
	
	initializeObject : function(){
		this.id = this.node.id.substr(8);
	
		var coordsOfEvent = getCoordsOfEvent(this.node);
		
		this.x = 0;
		this.y = coordsOfEvent.y;
		this.originalX= this.x;
		this.originalY= this.y;
		
		this.width = this.node.offsetWidth; 
		this.height = this.node.offsetHeight;
		this.originalWidth = this.width;
		this.originalHeight = this.height;
	
		this.cellJour = Math.max(Math.floor(this.node.offsetLeft / this.getLargeurColone()), 0); 		// int [0-6]
		this.cellHeurDeb = Math.floor(this.node.offsetTop / HAUTEUR_DEMIE_HEURE); 						// int [0-47]
		this.cellHeurFin = this.cellHeurDeb + Math.round(this.height / HAUTEUR_DEMIE_HEURE); 			// int [0-47]
	},
	
	//###########################################################################
	// DEPLACEMENT ET REDIMENTIONNEMENT
	//###########################################################################
	move : function(mouse_X , mouse_Y, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.move(this)))){
			this.deleteFromMatrice();
			var coords = getCoordsOnGride(this.zero.parentNode);
			var res = false;
			var futurCellHeurDeb = 		Math.floor((mouse_Y - coords.y + $("sub_content").scrollTop + this.grille.scrollTop) / HAUTEUR_DEMIE_HEURE);
			var futurCellHeurFin = 		futurCellHeurDeb + Math.round(this.height / HAUTEUR_DEMIE_HEURE);
			
			var futurY = futurCellHeurDeb * HAUTEUR_DEMIE_HEURE;
			
			if(futurY >= 0 && futurY <= (HAUTEUR_DEMIE_HEURE*47)){
				this.y = futurY;
				this.node.style.top = this.y + "px";
				res = true;
			}
			if(res){
				this.cellHeurDeb = futurCellHeurDeb;
				this.cellHeurFin = futurCellHeurFin;
			}
			this.addIntoMatrice();
			return res;
		}else{
			return false;
		}
	},
	
	setPosition : function(futurX, futurY, futurDuree, demanderPermission){//futurX, futurY, futurDuree en px
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setPosition(this)))){
			this.deleteFromMatrice();
			
			if(futurY >= 0 && futurY <= (HAUTEUR_DEMIE_HEURE*47) && (futurY + futurDuree) <= (HAUTEUR_DEMIE_HEURE*47) ){
				this.y = futurY;
				this.node.style.top = futurY + "px";
				this.node.style.height = futurDuree + "px";
				this.cellHeurDeb = Math.floor(futurY / HAUTEUR_DEMIE_HEURE);
				this.cellHeurFin = this.cellHeurDeb + Math.round(futurDuree / HAUTEUR_DEMIE_HEURE);
			}
			
			return this.addIntoMatrice() && true;
		}else{
			return false;
		}
	},
	
	//###########################################################################
	// COMMUNICATION
	//###########################################################################
	showOnPanel : function(demanderPermission, readOnly){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.showOnPanel(this, readOnly)))){
			var Udate_even  = Udate_deb_jour + this.cellHeurDeb*1800000;
			var duree_event = Math.ceil(((this.node.offsetHeight * 30) / HAUTEUR_DEMIE_HEURE)/15) * (900);
			//		Math.ceil(((  this.height * DemieHeure) / HAUTEUR_DEMIE_HEURE)/15) * (15*UNE_MINUTE);
			showOnPanel("JOUR", this.id, this.ref_event, Udate_even, duree_event, readOnly);
			
			return true;
		}else{
			return false;
		}
	}

//###########################################################################
//###########################################################################
//###########################################################################
	
});// FIN CLASSE EvenementJour
