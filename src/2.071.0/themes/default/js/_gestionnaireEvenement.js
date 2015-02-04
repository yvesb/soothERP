//###########################################################################
//###########################################################################
//###########################################################################

//DEB CLASSE gestionnaireEvenement

//###########################################################################
//###########################################################################
//###########################################################################
function new_GestionnaireEvenement(droitsAgendas, droitsTypesEvents)
{return  new GestionnaireEvenement(droitsAgendas, droitsTypesEvents);}
GestionnaireEvenement = Class.create();
GestionnaireEvenement.prototype = {
	initialize: function(droitsAgendas, droitsTypesEvents){
		this.droitsAgendas = droitsAgendas;
		this.droitsTypesEvents = droitsTypesEvents;
	},

	//###########################################################################
	// GETTERs & SETTERs
	//###########################################################################
	setTitre : function(evenement){return true;},
	
	getTitre : function(evenement){return true;},
		
	setDescription : function(evenement){return true;},
	
	getDescription : function(evenement){return true;},
	
	setRef_Event: function(evenement){return true;},
	
	getRef_Event: function(evenement){ return true;},
	
	setId_type_event: function(evenement){return true;},
	
	getId_type_event: function(evenement){return true;},
	
	setColors: function(evenement){return true;},
	
	getColors: function(evenement){return true;},
	
	//###########################################################################
	// MATRICE
	//###########################################################################
	addIntoMatrice : function(evenement){return true;},

	deleteFromMatrice : function(evenement){return true;},
	
	//###########################################################################
	// DEPLACEMENT ET REDIMENTIONNEMENT
	//###########################################################################
	move : function(evenement){return true;},
	
	canMove : function(evenement){return true;},
	
	setPosition : function(evenement){return true;},

	edit: function(evenement){return true;},
	
	resizeTitre : function(evenement){return true;},
	
	resizeDescription : function(evenement){return true;},
	
	resizeNode : function(evenement){return true;},
	
	//###########################################################################
	// COMMUNICATION
	//###########################################################################
	showOnPanel : function(evenement){return true;},

	save : function(evenement){ return true;}

//###########################################################################
//###########################################################################
//###########################################################################
};//FIN CLASSE gestionnaireEvenement
//###########################################################################
//###########################################################################
//###########################################################################
//
//
//
//
//
//
//
//
//
//
//###########################################################################
//###########################################################################
//###########################################################################
//DEB CLASSE droitAgenda
//###########################################################################
//###########################################################################
//###########################################################################
function new_DroitAgenda(ref_agenda, agenda_permission, events_types_permission)
{return  new DroitAgenda(ref_agenda, agenda_permission, events_types_permission);}
DroitAgenda = Class.create();
DroitAgenda.prototype = {
		
	initialize: function(ref_agenda, agenda_permission, events_types_permission){
		this.ref_agenda = ref_agenda;
		this.agenda_permission = agenda_permission;
		this.events_types_permission = events_types_permission;
	},
	
	getRef_agenda : function(){return this.ref_agenda;},
	
	getAgenda_permission : function(){return this.agenda_permission;},
	
	getEvents_types_permission : function(){return this.events_types_permission;},
	
	getEvent_type_permission : function(id_type_event){
		if(this.events_types_permission[id_type_event] != undefined)
		{		return this.events_types_permission[id_type_event];}
		else{	return null;}
	}

//###########################################################################
//###########################################################################
//###########################################################################
};//FIN CLASSE droitAgenda
//###########################################################################
//###########################################################################
//###########################################################################
