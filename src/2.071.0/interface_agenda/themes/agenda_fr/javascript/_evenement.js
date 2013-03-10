//###########################################################################
//###########################################################################
//###########################################################################
//
//DEB CLASSE Evenement
//
//###########################################################################
//###########################################################################
//###########################################################################
function new_Evenement(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event, detail_bool, modif_bool){
	var tmp = null;
	switch (scale_used) {
	case "jour":{
		tmp  = new EvenementJour(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event, detail_bool, modif_bool);
		tmp.initializeObject();
		break;}
	case "semaine":{
		tmp  = new EvenementSemaine(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event, detail_bool, modif_bool);
		tmp.initializeObject();
		break;}
	case "mois":{break;}
	}
	return tmp;
}

Evenement =  /*abstract*/ Class.create();
Evenement.prototype = {
	initialize: function(grille, zero, node, gestionnaireEvenement, id_type_agenda, ref_agenda, id_type_event, ref_event, modif_bool){
		
		this.grille = grille;
		this.zero = zero;
		this.node = node;
		this.gestionnaireEvenement = gestionnaireEvenement;
		this.id_type_agenda = id_type_agenda;
		this.ref_agenda = ref_agenda;
		this.id_type_event = id_type_event;
		this.ref_event = ref_event;
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

		this.cellJour = -1;
		this.cellHeurDeb = -1;
		this.cellHeurFin = -1;

		this.description = "";
		this.titre = "&nbsp;";
	},
	
	initializeObject :  /*abstract*/ function(){},
	
	
	deleteThis : function(){
		this.node.parentNode.removeChild(this.node);
		this.deleteFromMatrice();
		
		delete(evenements[this.id]);
	},
	
	//###########################################################################
	// GETTERs & SETTERs
	//###########################################################################
	
	getLargeurColone : function(){
		return this.zero.offsetWidth + 1;
	},
	
	getEvenementMaxWidth : function(){
		return this.getLargeurColone() - 15;
	},
	
	getTitre : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getTitre(this)))){
			return this.titre;
		}else{
			return "";
		}
	},
	
	setTitre : function(titre, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setTitre(this)))){
			this.titre = titre;
			return true;
		}else{
			return false;
		}
	},
	
	getDescription : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getDescription(this)))){
			return this.description;
		}else{
			return "";
		}
	},
	
	setDescription : function(description, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setDescription(this)))){
			this.description = description;
			return true;
		}else{
			return false;
		}
	},
	
	getRef_Event: function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getRef_Event(this)))){
			return this.ref_event;
		}else{
			return "";
		}
	},
	
	setRef_Event: function(ref, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setRef_Event(this)))){
			this.ref_event = ref;
			return true;
		}else{
			return false;
		}
	},

	getColor_1: function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getColors(this)))){	
			return this.color_1;
		}else{
			return "";
		}
	},
	
	getColor_2: function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getColors(this)))){	
			return this.color_2;
		}else{
			return "";
		}
	},
	
	getColor_3: function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getColors(this)))){	
			return this.color_3;
		}else{
			return "";
		}
	},
	
	setColors: function(color_1, color_2, color_3, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setColors(this)))){
			//divPrincipale
			this.node.style.borderColor = color_3;
			this.node.style.backgroundColor = color_2;
			
			//divPrincipale.divContenu.divTitreMoveG
			this.node.childNodes[0].childNodes[0].style.backgroundColor = color_1;
			
			//divPrincipale.divContenu.divTitreMoveD
			this.node.childNodes[0].childNodes[1].style.backgroundColor = color_1;
	
			//divPrincipale.divContenu.divDescription
			this.node.style.borderColor = color_3;
			this.node.childNodes[0].childNodes[2].style.borderColor = color_3;
			
			return true;
		}else{
			return false;
		}
	},
	
	getId_Type_Event: function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getId_Type_Event(this)))){
			return this.id_type_event;
		}else{
			return -1;
		}
	},
	
	setId_Type_Event: function(id_type_event, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setId_Type_Event(this)))){
			this.id_type_event = id_type_event;
			return true;
		}else{
			return false;
		}
	},

	getId_Type_Agenda : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getId_Type_Agenda(this)))){
			return this.id_type_agenda;
		}else{
			return null;
		}
	},
	
	setId_Type_Agenda : function(id_type_agenda, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setId_Type_Agenda(this)))){
			this.id_type_agenda = id_type_agenda;
			return true;
		}else{
			return false;
		}
	},
	
	getRef_Agenda : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getRef_Agenda(this)))){
			return this.ref_agenda;
		}else{
			return null;
		}
	},
	
	setRef_Agenda : function(ref_agenda, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.setId_Type_Agenda(this)))){
			this.ref_agenda  = ref_agenda;
			return true;
		}else{
			return false;
		}
	},
	getModif_bool : function(demanderPermission){
		//if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getRef_Agenda(this)))){
			return this.modif_bool;
		//}else{
		//	return null;
		//}
	},
	getDetail_bool : function(demanderPermission){
		//if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.getRef_Agenda(this)))){
			return this.detail_bool;
		//}else{
		//	return null;
		//}
	},
	//###########################################################################
	// MATRICE
	//###########################################################################
	addIntoMatrice : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.addIntoMatrice(this)))){
			for(i = 0; i < (this.cellHeurFin - this.cellHeurDeb); i++){
				matriceDemieHeure[this.cellJour][this.cellHeurDeb+i].push(this);
			}
			
			return true;
		}else{
			return false;
		}
	},

	deleteFromMatrice : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.deleteFromMatrice(this)))){
			for(i = 0; i < (this.cellHeurFin - this.cellHeurDeb); i++){
				for(k = 0; k<matriceDemieHeure[this.cellJour][this.cellHeurDeb+i].length; k++){
					if(matriceDemieHeure[this.cellJour][this.cellHeurDeb+i][k] == this){
						matriceDemieHeure[this.cellJour][this.cellHeurDeb+i][k] = matriceDemieHeure[this.cellJour][this.cellHeurDeb+i][0];
						matriceDemieHeure[this.cellJour][this.cellHeurDeb+i].shift();
						break;
					}
				}
			}
			
			return true;
		}else{
			return false;
		}
	},
	
	//###########################################################################
	// DEPLACEMENT ET REDIMENTIONNEMENT
	//###########################################################################
	
	
	move : /*abstract*/ function(mouse_X , mouse_Y, demanderPermission){return false;},
	
	canMove: function(demanderPermission){
		return demanderPermission == null || this.gestionnaireEvenement == null || this.gestionnaireEvenement.canMove(this);
	},
	
	setPosition : /*abstract*/ function(futurX, futurY, futurDuree, demanderPermission){return false;},//futurX, futurY, futurDuree en px

	edit: function(mouse_X, mouse_Y, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.edit(this)))){
			this.deleteFromMatrice();
			var coords = getCoordsOnGride(this.zero.parentNode);
			this.cellHeurFin = Math.floor((mouse_Y - coords.y + $("sub_content").scrollTop + this.grille.scrollTop) / HAUTEUR_DEMIE_HEURE) +1;
			var futurY_deFin = this.cellHeurFin * HAUTEUR_DEMIE_HEURE;
	
			var res = false;
			
			if(!res && futurY_deFin >= (this.node.offsetTop+3*HAUTEUR_DEMIE_HEURE) && futurY_deFin <= (HAUTEUR_DEMIE_HEURE*48)){
				this.height = (futurY_deFin - this.node.offsetTop - 7); //7 = la taille de la dernière div nommée : "event_edit_"+id avec la css : event_div_edition_zone
				this.node.style.height = this.height + "px";
				res = true;
			}
			if(!res && futurY_deFin <= (HAUTEUR_DEMIE_HEURE*48)){
				this.height = 2*HAUTEUR_DEMIE_HEURE - 7; //7 = la taille de la dernière div nommée : "event_edit_"+id avec la css : event_div_edition_zone
				this.node.style.height = this.height + "px";
				res = true;
			}
			
			this.addIntoMatrice();
			return res;
		}else{
			return false;
		}
	},
	
	resizeTitre : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.resizeTitre(this)))){
			var t = this.getTitre(demanderPermission);
			var fontFamily = this.node.childNodes[0].childNodes[0].style.fontFamily;
			var fontSize = this.node.childNodes[0].childNodes[0].style.fontSize;
				
			var dimentionLigneAInserer = t.textWidth(fontFamily, fontSize);
			
			while(dimentionLigneAInserer.width > this.node.childNodes[0].childNodes[0].offsetWidth){
				t = t.substring(0,t.length-1);
				dimentionLigneAInserer = t.textWidth(fontFamily, fontSize);
			}
			this.node.childNodes[0].childNodes[0].innerHTML = t;
			
			return true;
		}else{
			return false;
		}
	},
	
	resizeDescription : function(demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.resizeDescription(this)))){
			var d = this.description;
			var fontFamily = this.node.childNodes[0].childNodes[2].style.fontFamily;
			var fontSize = this.node.childNodes[0].childNodes[2].style.fontSize;
			var height = this.node.childNodes[0].offsetHeight;
			var dimentionLigneAInserer = d.textWidth(fontFamily, fontSize);
			var NB_LIGNE =  (height-20) / dimentionLigneAInserer.height;
			
			while(dimentionLigneAInserer.width > (NB_LIGNE * this.node.childNodes[0].childNodes[2].offsetWidth) ){
				d = d.substring(0,d.length-7)+" ...";
				dimentionLigneAInserer = d.textWidth(fontFamily, fontSize);
			}
			this.node.childNodes[0].childNodes[2].innerHTML = d;
			
			return true;
		}else{
			return false;
		}
	},
	
	resizeNode : function(ecart, indice, demanderPermission){
		if(demanderPermission == null || (demanderPermission && (this.gestionnaireEvenement == null || this.gestionnaireEvenement.resizeNode(this)))){
			//var largeur = Math.round(this.getEvenementMaxWidth() / ecart) - 4;
			var largeur = Math.round(this.getEvenementMaxWidth() / ecart);
			this.node.style.width = largeur + "px";
			//this.node.style.left = (this.cellJour * this.getLargeurColone() + indice * (largeur + 8) )+ "px";
			this.node.style.left = (this.cellJour * this.getLargeurColone() + indice * largeur + 2 )+ "px";
			
			this.resizeTitre();
			this.resizeDescription();
			
			return true;
		}else{
			return false;
		}
	},
	
	//###########################################################################
	// COMMUNICATION
	//###########################################################################
	showOnPanel : /*abstract*/ function(demanderPermission){ return false; },

	save : function(auto){}

//###########################################################################
//###########################################################################
//###########################################################################
	
};// FIN CLASSE evenement

//###########################################################################
//###########################################################################
//###########################################################################


function largeurColonneSemaine(){
	return $("ZEROsemaine").offsetWidth + 2;
}

function largeurColonneJour(){
	return $("ZEROjour").offsetWidth + 2;
}

function evenementMaxWidthJour(){
	return largeurColonneJour() - 15;
}

function evenementMaxWidthSemaine(){
	return largeurColonneSemaine() - 15;
}

function evenementMaxWidth(){
	return largeurColonneSemaine() - 15;
}
