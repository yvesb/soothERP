//###########################################################################
//###########################################################################
//###########################################################################
//
//DEB CLASSE calculette
//
//###########################################################################
//###########################################################################
//###########################################################################
calculette = Class.create();
calculette.prototype = {
	initialize: function(impRes, bt_Ok, bt_c, bt_point, bt_PlusMoins, bt_remise, bt_prix, bt_qte, bt_0, bt_1, bt_2, bt_3, bt_4, bt_5, bt_6, bt_7, bt_8, bt_9, retour){
		
		this.impRes = impRes;
		this.bt_Ok = bt_Ok;
		this.bt_c = bt_c;
		this.bt_point = bt_point;
		this.bt_PlusMoins = bt_PlusMoins;
		this.bt_remise = bt_remise;
		this.bt_prix = bt_prix;
		this.bt_qte = bt_qte;
		this.bt_0 = bt_0;
		this.bt_1 = bt_1;
		this.bt_2 = bt_2;
		this.bt_3 = bt_3;
		this.bt_4 = bt_4;
		this.bt_5 = bt_5;
		this.bt_6 = bt_6;
		this.bt_7 = bt_7;
		this.bt_8 = bt_8;
		this.bt_9 = bt_9;

		this.retour = retour;
		
		this.cible_id = "";
		this.cible_action = "";
		this.cible_type_action = "";
		
		this.res_isfloat = false;
		this.res_isNeg = false;
		this.res_val_entier= "0";
		this.res_val_flottant = "00";
		this.res_length_flottant = 0;
	},
	
	// ************************************************************************************
	// GETTERS & SETTERS
	// ************************************************************************************
	getCible_action : function(){
		//listes des actions possibles :
		//	REMISE
		//	PUTTC
		//	QTE
		//	MOYENS_DE_PAIEMENT
		return this.cible_action;
	},
	
	setCible_action : function(cible_action){
		//listes des actions possibles :
		//	REMISE
		//	PUTTC
		//	QTE
		//	MOYENS_DE_PAIEMENT
		this.cible_action = cible_action;
	},
	
	getCible_id : function(){
		return this.cible_id;
	},
	
	setCible_id : function(cible_id){//ancien ligne name
		this.cible_id = cible_id;
	},
	
	getCible_type_action : function(){
		//listes des actions possibles :
		//	TICKET
		//	MOYENS_DE_PAIEMENT
		return this.cible_type_action;
	},
	
	setCible_type_action : function(cible_type_action){
		//listes des actions possibles :
		//	TICKET
		//	MOYENS_DE_PAIEMENT
		this.reset_calculette();
		this.cible_type_action = cible_type_action;
	},
	
	getRetour : function(){
		return this.retour;
	},
	
	setRetour : function(retour){
		this.retour = retour;
	},
	
	// ************************************************************************************
	// 
	// ************************************************************************************
	
	bt_PlusMoins_click : function(signe){
		if(signe == undefined)
		{	this.res_isNeg = !this.res_isNeg;}
		else
		{	if(signe == "-")
			{	 this.res_isNeg = true;}
			else{this.res_isNeg = false;}
		}
		this.afficher_res();
	},
	
	bt_remise_click : function(){
		switch(this.cible_type_action){
			case "TICKET":{
				this.cible_action = "REMISE";
				this.impRes.focus();
				break; }
			case "MOYENS_DE_PAIEMENT":{
				this.impRes.focus();
				break; }
			default:{break;}
		}
	},
	
	bt_prix_click : function(){
		switch(this.cible_type_action){
			case "TICKET":{
				this.cible_action = "PUTTC";
				this.impRes.focus();
				break;}
			case "MOYENS_DE_PAIEMENT":{
				this.impRes.focus();
				break; }
			default:{break;}
		}
	},
	
	bt_qte_click : function(){
		switch(this.cible_type_action){
			case "TICKET":{
				this.cible_action = "QTE";
				this.impRes.focus();
				break; }
			case "MOYENS_DE_PAIEMENT":{
				this.impRes.focus();
				break; }
			default:{break;}
		}
	},
	
	bt_Ok_click : function(){
		if(this.cible_id != ""){ 
			switch(this.cible_type_action){
				case "TICKET":{
					switch(this.cible_action){
						case "REMISE":
						{	caisse_maj_ligne_ticket($("ref_ticket").value, this.cible_id, this.impRes.value, "", "" ); break; }
						case "PUTTC":
						{	caisse_maj_ligne_ticket($("ref_ticket").value, this.cible_id, "", this.impRes.value, "" ); break; }
						case "QTE":
						{	caisse_maj_ligne_ticket($("ref_ticket").value, this.cible_id, "", "", this.impRes.value); break; }
						default:{break;}
					}
					break; }
				case "MOYENS_DE_PAIEMENT":{
					switch(this.cible_action){
						case "MOYENS_DE_PAIEMENT":
						{	$(this.cible_id).value = price_format(parseFloat(this.calcul_res()));
							$(this.cible_id).className = "panneau_encaissement_ligne_reglement_effectue_MONTANT";
							cible_id_MONTANT = "";
							caisse_afficher_a_rendre();
							; break; }
						default:{break;}
					}
					break; }
				default:{break;}
			}
			var tmp_cible_type_action = this.cible_type_action;
			var tmp_cible_id = this.cible_id;
			this.reset_calculette();
			this.cible_type_action = tmp_cible_type_action;
			this.cible_id = tmp_cible_id;
			this.retour.focus();
		}else{
			this.impRes.focus();
		}
	},
	
	impRes_keypress : function(key){
		switch(key){
			case Event.KEY_RETURN : // meme action que quand on clic sur OK
			{	this.bt_Ok_click(); return true; }
		}
	},
	
	impRes_keydown : function(keyCode){
		//alert(keyCode);
		switch(keyCode){
			case 109 : {//touche -
				this.bt_PlusMoins_click("-");
				return true;
			}
			case 107 : {//touche +
				this.bt_PlusMoins_click("+");
				return true;
			}
			/*
			case 96:case 97:case 98:case 99:case 100:case 101:case 102:case 103:case 104:case 105:{//Touche de 0 à 9 : clavier numérique
				Event.stop(evt);
				if(this.impRes.value == "-0"){
					this.impRes.value = "-"+(evt.keyCode-96);
				}else{
					if(this.impRes.value == "0"){
						this.impRes.value = (evt.keyCode-96);
					}else{
						this.impRes.value = this.impRes.value + (evt.keyCode-96);
					}
				}
				break;
			}
			case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{//Touche de 0 à 9 : clavier azerty
				Event.stop(evt);
				if(this.impRes.value == "-0"){
					this.impRes.value = "-"+(evt.keyCode-48);
				}else{
					if(this.impRes.value == "0"){
						this.impRes.value = (evt.keyCode-48);
					}else{
						this.impRes.value = this.impRes.value + (evt.keyCode-48);
					}
				}
				Event.stop(evt);
				break;
			}*/
			case 110:case 190:case 188 : {//touche . et ,
				this.bt_point_click();
				return true;
			}
			default : {
				return false;
			}
		}
	},
	
	bt_c_click : function (){
		this.reset_impRes();
	},
	
	bt_point_click : function (){
		this.res_isfloat = true;
		this.impRes.focus();
	},
	
	bt_0_9_click : function(bt_val){
		if(this.res_isfloat){
			if(this.res_length_flottant == 0){
				this.res_val_flottant  = bt_val+"0";
				this.res_length_flottant++;
			}
			else{
				if(this.res_length_flottant == 1)
				{	this.res_val_flottant = this.res_val_flottant.substr(0, 1)+bt_val;}
				else
				{	this.res_val_flottant += bt_val;}
				this.res_length_flottant++;
			}
		}else{
			if(this.res_val_entier == "0")
			{	 this.res_val_entier  = bt_val;}
			else{this.res_val_entier += bt_val;}
		}
		this.afficher_res();
	},

	reset_impRes : function(){
		this.res_val_entier= "0";
		this.res_val_flottant = "00";
		this.res_length_flottant = 0;
		this.res_isfloat = false;
		this.afficher_res();
	},
	
	reset_calculette : function(){
		this.reset_impRes();
		this.cible_action = "";
		this.cible_id = "";
		this.cible_type_action = "";
	},
	
	calcul_res : function(){
		if(this.res_isNeg)
		{	return "-"+this.res_val_entier+"."+this.res_val_flottant;}
		else
		{	return this.res_val_entier+"."+this.res_val_flottant;}	
	},
	
	afficher_res : function(){
		this.impRes.value = this.calcul_res();
		this.impRes.focus();
	}
	
	
	
	//###########################################################################
	// GETTERs & SETTERs
	//###########################################################################
	
//###########################################################################
//###########################################################################
//###########################################################################
	
};// FIN CLASSE calculette

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
//Fonctions
//###########################################################################

function aaaaaaaaaaa(){

}

function bbbbbbbbbbb(){

}