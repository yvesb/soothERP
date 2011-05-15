//*********************************************
// FORMULAIRE
//**********************************************

// gestion des bouton de supression dans les nouveau CAIU

function supp_new_caiu (id_bt, id_li) {
	Event.observe(id_bt, 'click',  function(evt){Event.stop(evt); remove_tag(id_li);}, false);	
	
}

// affichage liste déroulante des villes par saisie du code postal
function pre_start_commune(idcode, idcommune, cible, iframecible, targeturl, id_pays){

	Event.observe(idcommune, 'focus',  function(){ start_commune(idcode, idcommune, cible, iframecible, targeturl); }, false);	
	Event.observe(id_pays, 'focus',  function(){delay_close(cible, iframecible);}, false);	
}

function start_commune(idcode, idcommune, cible, iframecible, targeturl) {
		
    var cp = $(idcode).value;
    if (cp.length >= 5) {
			
		var AppelAjax = new Ajax.Updater(
																	cible, 
																	targeturl+cp, 
																	{parameters: {ville: idcommune, choix_ville: cible, iframe_choix_ville: iframecible},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete: function(requester) {
																					H_loading(); 
																					if (requester.responseText!="") {
																					$(cible).style.display="block";
																					$(iframecible).style.display="block";
																			
																					}
																					}
																	}
																	);
    
  	}	
}


// affichage liste déroulante des coordonnees pour un utilisateur
function pre_start_coordonnee (survol, bt_survol, ref_contatct, lib_coord, user_coord, choix_coord, iframe_coord, pagecible) {

				//effet de survol sur le faux select
					Event.observe(survol, "mouseover",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_hover.gif";}, false);
					Event.observe(survol, "mousedown",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_down.gif";}, false);
					Event.observe(survol, "mouseup",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					Event.observe(survol, "mouseout",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					
//affichage des choix
					Event.observe(survol, "click",  function(evt){Event.stop(evt); start_coordonnee (ref_contatct, lib_coord, user_coord, choix_coord, iframe_coord, pagecible);}, false);
					
}

function start_coordonnee (ref_contact, iddiv, idinput, cible, iframecible, targeturl) {

if ($(cible).style.display=="none") {
	var AppelAjax = new Ajax.Updater(
																	cible, 
																	targeturl, 
																	{parameters: {ref_contact: ref_contact, choix_coord: cible, iframe_choix_coord: iframecible, input: idinput, div: iddiv},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete: function(requester) {
																						H_loading(); 
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}


// affichage liste déroulante des adresses pour un profil client sur une fiche de contact en mode création
function pre_start_adresse_crea (survol, bt_survol, lib_adresse, user_adresse, choix_adresse, iframe_adresse) {

				//effet de survol sur le faux select
					Event.observe(survol, "mouseover",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_hover.gif";}, false);
					Event.observe(survol, "mousedown",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_down.gif";}, false);
					Event.observe(survol, "mouseup",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					Event.observe(survol, "mouseout",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					
//affichage des choix
					Event.observe(survol, "click",  function(evt){Event.stop(evt); start_adresse_crea ( lib_adresse, user_adresse, choix_adresse, iframe_adresse);}, false);
					
}

//affichage des adresses présentes dans la liste des adresse pour un contact en mode création.
function start_adresse_crea ( iddiv, idinput, cible, iframecible, targeturl) {

if ($(cible).style.display == "none") {
$(cible).style.display = "block";
$(iframecible).style.display = "block"; 
$(cible).innerHTML = "";
	var zone= $(cible);
	var divul= document.createElement("div");
		divul.setAttribute ("id", "div_choix_adr_"+idinput);
		divul.setAttribute("class","divstyle_adre") ;
		divul.setAttribute ("className", "divstyle_adre");
	var ulli= document.createElement("ul");
		ulli.setAttribute ("id", "ul_choix_adr_"+idinput);
		ulli.setAttribute("class","complete_adresse") ;
		ulli.setAttribute ("className", "complete_adresse");
		
	zone.appendChild(divul);
	$("div_choix_adr_"+idinput).appendChild(ulli);
	var ordre = 0 ;
for (i=0; i<id_index_contentcoord; i++) {
if ($("adressecontent_li_"+i)) {
	ordre++;
	var licontent= document.createElement("li");
			licontent.setAttribute ("id", "li_choix_adresse_"+idinput+"_"+i);
			licontent.setAttribute("class","complete_coordonnee") ;
			licontent.setAttribute ("className", "complete_coordonnee");
	$("ul_choix_adr_"+idinput).appendChild(licontent);
	var span1= document.createElement("span");
			span1.setAttribute ("id", "span1_choix_adresse_"+idinput+"_"+i);
			span1.setAttribute("class","spanstyle_adre_bolder") ;
			span1.setAttribute ("className", "spanstyle_adre_bolder");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(span1);
	$("span1_choix_adresse_"+idinput+"_"+i).innerHTML=$("adresse_lib"+i).value;
	var br1= document.createElement("br");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(br1);


	var span2= document.createElement("span");
			span2.setAttribute ("id", "span2_choix_adresse_"+idinput+"_"+i);
			span2.setAttribute("class","spanstyle_adre") ;
			span2.setAttribute ("className", "spanstyle_adre");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(span2);
	$("span2_choix_adresse_"+idinput+"_"+i).innerHTML = $("adresse_adresse"+i).value.truncate(25);
	var span2b= document.createElement("span");
			span2b.setAttribute ("id", "span2b_choix_adresse_"+idinput+"_"+i);
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(span2b);
	$("span2b_choix_adresse_"+idinput+"_"+i).innerHTML = "Adresse: ";
	var br2= document.createElement("br");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(br2);

	var span3= document.createElement("span");
			span3.setAttribute ("id", "span3_choix_adresse_"+idinput+"_"+i);
			span3.setAttribute("class","spanstyle_adre") ;
			span3.setAttribute ("className", "spanstyle_adre");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(span3);
	$("span3_choix_adresse_"+idinput+"_"+i).innerHTML=$("adresse_code"+i).value;
	var span3b= document.createElement("span");
			span3b.setAttribute ("id", "span3b_choix_adresse_"+idinput+"_"+i);
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(span3b);
	$("span3b_choix_adresse_"+idinput+"_"+i).innerHTML = "Code Postal:";
	var br3= document.createElement("br");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(br3);
	
	var span4= document.createElement("span");
			span4.setAttribute ("id", "span4_choix_adresse_"+idinput+"_"+i);
			span4.setAttribute("class","spanstyle_adre") ;
			span4.setAttribute ("className", "spanstyle_adre");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(span4);
	$("span4_choix_adresse_"+idinput+"_"+i).innerHTML = $("adresse_ville"+i).value.truncate(25);
	var span4b= document.createElement("span");
			span4b.setAttribute ("id", "span4b_choix_adresse_"+idinput+"_"+i);
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(span4b);
	$("span4b_choix_adresse_"+idinput+"_"+i).innerHTML = "Ville:";
	var br4= document.createElement("br");
	$("li_choix_adresse_"+idinput+"_"+i).appendChild(br4);
	
	var texte_racourci = (($("adresse_lib"+i).value)+" - "+($("adresse_adresse"+i).value)+" - "+($("adresse_code"+i).value)+" - "+($("adresse_ville"+i).value)).truncate(25)+".."
	
	evenement_listechoix_adresse(texte_racourci, iddiv, iframecible, cible, idinput, i, ordre ); 
}
}


} else {
	delay_close (cible,iframecible);
	}

}
//observateur d'événement pour liste des adresse à la création contact pour un profil client
function evenement_listechoix_adresse(texte_racourci, iddiv, iframecible, cible, idinput, i, ordre ) {
	Event.observe("li_choix_adresse_"+idinput+"_"+i, "mouseout",  function(){Element.removeClassName($("li_choix_adresse_"+idinput+"_"+i), "complete_coordonnee_hover"); Element.addClassName($("li_choix_adresse_"+idinput+"_"+i), "complete_coordonnee");}, false);

Event.observe("li_choix_adresse_"+idinput+"_"+i, "mouseover",  function(){ Element.addClassName($("li_choix_adresse_"+idinput+"_"+i), "complete_coordonnee_hover"); Element.removeClassName($("li_choix_adresse_"+idinput+"_"+i), "complete_coordonnee");}, false);

Event.observe("li_choix_adresse_"+idinput+"_"+i, "click",  function(evt){Event.stop(evt); $(idinput).value=ordre; $(cible).style.display="none"; $(iframecible).style.display="none"; $(iddiv).innerHTML = texte_racourci; }, false);
}


// affichage liste déroulante des adresses pour un profil client sur une fiche de contact en mode édition
function pre_start_adresse (survol, bt_survol, ref_contatct, lib_adresse, user_adresse, choix_adresse, iframe_adresse, pagecible) {

				//effet de survol sur le faux select
					Event.observe(survol, "mouseover",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_hover.gif";}, false);
					Event.observe(survol, "mousedown",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_down.gif";}, false);
					Event.observe(survol, "mouseup",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					Event.observe(survol, "mouseout",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					
//affichage des choix
					Event.observe(survol, "click",  function(evt){Event.stop(evt); start_adresse (ref_contatct, lib_adresse, user_adresse, choix_adresse, iframe_adresse, pagecible);}, false);
					
}

//affichage des adresses présentes dans la base de données pour un contact.
function start_adresse (ref_contact, iddiv, idinput, cible, iframecible, targeturl) {

if ($(cible).style.display=="none") {
	var AppelAjax = new Ajax.Updater(
																	cible, 
																	targeturl, 
																	{parameters: {ref_contact: ref_contact, choix_adresse: cible, iframe_choix_adresse: iframecible, input: idinput, div: iddiv},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete: function(requester) {
																						H_loading(); 
																							if (requester.responseText!="") {
																							$(cible).style.display="block";
																							$(iframecible).style.display="block";
																							}
																					}
																	}
																	);
  } else {
	delay_close (cible,iframecible);
	}
}


function delay_close (cible,iframecible) {
$(cible).style.display="none";
$(iframecible).style.display="none";
}



//récupére la liste des civilités en fonction d'une catégorie
function start_civilite(idcat, idcivi, cible) {
  civiliteUpdater = new SelectUpdater(idcivi, cible);
  ancienCat = "";
  $(idcat).onchange = function() {
    var cat = $(idcat).value;
      if (cat != ancienCat) {
        civiliteUpdater.run(cat);
        ancienCat = cat;
      }
  }
}



//récupére la liste des états d'une type de document donné 
function start_doc_etat(idtype, idetat, cible) {
  var etatUpdater = new SelectUpdater(idetat, cible);
  ancientype = " ";
  $(idtype).onchange = function() {
    var type = $(idtype).value;
      if (type != ancientype) {
        etatUpdater.run(type);
        ancientype = type;
      }
  }
}


//
//Masques de saisies de formulaire
//

//masque de date au format jj-mm-aaaa

function datemask(evt) {
var array_num=new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var jo="";
var mm="";
var aaaa="";

	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" "){
  	 array_num.push(u_field_num[i]);
		}
	}
	
	
	for ( i=0; i < array_num.length; i++ ) {
		if (i==0) {
			if (array_num[0]>3) {
				array_num.splice(1,0,array_num[0]);
				array_num[0]=0;
			}
				jo=array_num[0]+"";
		}
		if (i==1) {
			if (array_num[0]==3 && array_num[1]>1) {
				array_num[1]=1;
			}
				jo+=array_num[1];
		}
		if (i==2) {
			if (array_num[2]>1) {
				array_num.splice(3,0,array_num[2]);
				array_num[2]=0;
			}
				mm+="-"+array_num[i]+"";
		}
		if (i==3) {
			if (array_num[3]>2 && array_num[2]==1) {
				array_num[3]=2;
			}
			if (array_num[3]==2 && array_num[2]==0 ) {
				if (array_num[0]>2) {
					array_num[0]=2;
					array_num[1]=8;
				jo=array_num[0]+""+array_num[1];
				}
			}
			mm+=array_num[i];
	
		}
		if (i==4 || i==5 || i==6 || i==7) {
			if (i==4) {
			 aaaa +="-";
			 }
			if (i==4 && (array_num[i]>2 || array_num[i]<2)) {
					if (array_num[i]>2) {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	9;
						array_num[4]	=	1;
					} else {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	0;
						array_num[4]	=	2;
					}
			}
			aaaa+=array_num[i]+"";
		}
		
		
	
		
	}

$(id_field.id).value=jo+mm+aaaa;
}


//masque de date au format jj/mm/aaaa
function datemaskslash(evt) {
var array_num=new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var jo="";
var mm="";
var aaaa="";

	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" "){
  	 array_num.push(u_field_num[i]);
		}
	}


	for ( i=0; i < array_num.length; i++ ) {
		if (i==0) {
			if (array_num[0]>3) {
				array_num.splice(1,0,array_num[0]);
				array_num[0]=0;
			}
				jo=array_num[0]+"";
		}
		if (i==1) {
			if (array_num[0]==3 && array_num[1]>1) {
				array_num[1]=1;
			}
				jo+=array_num[1];
		}
		if (i==2) {
			if (array_num[2]>1) {
				array_num.splice(3,0,array_num[2]);
				array_num[2]=0;
			}
				mm+="/"+array_num[i]+"";
		}
		if (i==3) {
			if (array_num[3]>2 && array_num[2]==1) {
				array_num[3]=2;
			}
			if (array_num[3]==2 && array_num[2]==0 ) {
				if (array_num[0]>2) {
					array_num[0]=2;
					array_num[1]=8;
				jo=array_num[0]+""+array_num[1];
				}
			}
			mm+=array_num[i];

		}
		if (i==4 || i==5 || i==6 || i==7) {
			if (i==4) {
			 aaaa +="/";
			 }
			if (i==4 && (array_num[i]>2 || array_num[i]<2)) {
					if (array_num[i]>2) {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	9;
						array_num[4]	=	1;
					} else {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	0;
						array_num[4]	=	2;
					}
			}
			aaaa+=array_num[i]+"";
		}
	}

$(id_field.id).value=jo+mm+aaaa;
}


//masque de date au format jj/mm/aaaa
function datemaskslash2(obj) {
var array_num=new Array;
var field_value = obj.value;
var u_field_num = Array.from(field_value);
var jo="";
var mm="";
var aaaa="";

	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" "){
  	 array_num.push(u_field_num[i]);
		}
	}


	for ( i=0; i < array_num.length; i++ ) {
		if (i==0) {
			if (array_num[0]>3) {
				array_num.splice(1,0,array_num[0]);
				array_num[0]=0;
			}
				jo=array_num[0]+"";
		}
		if (i==1) {
			if (array_num[0]==3 && array_num[1]>1) {
				array_num[1]=1;
			}
				jo+=array_num[1];
		}
		if (i==2) {
			if (array_num[2]>1) {
				array_num.splice(3,0,array_num[2]);
				array_num[2]=0;
			}
				mm+="/"+array_num[i]+"";
		}
		if (i==3) {
			if (array_num[3]>2 && array_num[2]==1) {
				array_num[3]=2;
			}
			if (array_num[3]==2 && array_num[2]==0 ) {
				if (array_num[0]>2) {
					array_num[0]=2;
					array_num[1]=8;
				jo=array_num[0]+""+array_num[1];
				}
			}
			mm+=array_num[i];

		}
		if (i==4 || i==5 || i==6 || i==7) {
			if (i==4) {
			 aaaa +="/";
			 }
			if (i==4 && (array_num[i]>2 || array_num[i]<2)) {
					if (array_num[i]>2) {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	9;
						array_num[4]	=	1;
					} else {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	0;
						array_num[4]	=	2;
					}
			}
			aaaa+=array_num[i]+"";
		}
	}
$(obj.id).value=jo+mm+aaaa;
}

//masque d'heure au format hh:mm

function timemask(evt) {
var array_num=new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var hh="";
var mm="";

	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" "){
  	 array_num.push(u_field_num[i]);
		}
	}
	
	
	for ( i=0; i < array_num.length; i++ ) {
		if (i==0) {
			if (array_num[0]>2) {
				array_num.splice(1,0,array_num[0]);
				array_num[0]=0;
			}
				hh=array_num[0]+"";
		}
		if (i==1) {
			if (array_num[0]==2 && array_num[1]>3) {
				array_num[1]=3;
			}
				hh+=array_num[1];
		}
		if (i==2) {
			if (array_num[2]>5) {
				array_num.splice(3,0,array_num[2]);
				array_num[2]=0;
			}
				mm+=":"+array_num[i]+"";
		}
		if (i==3) {
			mm+=array_num[i];
	
		}
		
		
	
		
	}
	
	if (hh.length == 0) {hh="00";}
	if (hh.length == 1) {hh+="0";}
	if (mm.length == 0) {mm=":00";}
	if (mm.length == 1) {mm+="00";}
	if (mm.length == 2) {mm+="0";}
	
	$(id_field.id).value=hh+mm;
}















//masque de date time au format jj/mm/aaaa hh:mn

function datetimemask(evt) {
var array_num=new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var jo="";
var mm="";
var aaaa="";
var hh="";
var mn="";
var ladate=new Date();

if (field_value == ""){return false;}

	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" "){
  	 array_num.push(u_field_num[i]);
		}
	}
	
	
	for ( i=0; i < array_num.length; i++ ) {
		if (i==0) {
			if (array_num[0]>3) {
				array_num.splice(1,0,array_num[0]);
				array_num[0]=0;
			}
				jo=array_num[0]+"";
		}
		if (i==1) {
			if (array_num[0]==3 && array_num[1]>1) {
				array_num[1]=1;
			}
				jo+=array_num[1];
		}
		if (i==2) {
			if (array_num[2]>1) {
				array_num.splice(3,0,array_num[2]);
				array_num[2]=0;
			}
				mm+="-"+array_num[i]+"";
		}
		if (i==3) {
			if (array_num[3]>2 && array_num[2]==1) {
				array_num[3]=2;
			}
			if (array_num[3]==2 && array_num[2]==0 ) {
				if (array_num[0]>2) {
					array_num[0]=2;
					array_num[1]=8;
				jo=array_num[0]+""+array_num[1];
				}
			}
			mm+=array_num[i];
	
		}
		if (i==4 || i==5 || i==6 || i==7) {
			if (i==4) {
			 aaaa +="-";
			 }
			if (i==4 && (array_num[i]>2 || array_num[i]==0)) {
					if (array_num[i]>2) {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	9;
						array_num[4]	=	1;
					} else {
						array_num[7]	=	array_num[i+1];
						array_num[6]	=	array_num[i];
						array_num[5]	=	0;
						array_num[4]	=	2;
					}
			}
			aaaa+=array_num[i]+"";
		}
		
		
	
		if (i==8) {
			if (array_num[8]>2) {
				array_num[8]=0;
			}
				hh=" "+array_num[8]+"";
		}
		if (i==9) {
			if (array_num[8]==2 && array_num[9]>3) {
				array_num[9]=3;
			}
				hh+=array_num[9];
		}
		if (i==10) {
			if (array_num[10]>5) {
				array_num[10]=0;
			}
				mn+=":"+array_num[i]+"";
		}
		if (i==11) {
			mn+=array_num[i];
	
		}
		
		
	
		
	}
	
	if (jo.length != 2) {
		if ((ladate.getDate()) < 10) {
			jo="0"+(ladate.getDate());
		} else {
			jo=""+(ladate.getDate());
		}
	}
	if (mm.length != 3) {
		if ((ladate.getMonth()+1) < 10) {
			mm="-0"+(ladate.getMonth()+1);
		} else {
			mm="-"+(ladate.getMonth()+1);
		}
	}
	if (aaaa.length != 5) {
		aaaa="-"+ladate.getFullYear();
	}
	
	if (hh.length == 0) {hh=" 00";}
	if (hh.length == 1) {hh+="00";}
	if (hh.length == 2) {hh+="0";}
	
	if (mn.length == 0) {mn=":00";}
	if (mn.length == 1) {mn+="00";}
	if (mn.length == 2) {mn+="0";}
	
	
	$(id_field.id).value=jo+mm+aaaa+hh+mn;
}








//masque de saisie numérique
function nummask(evt, val_def, masque) {
// masque type:
// X.X (nombre flotant
// X.XX nombre à deux desimales
// X nombre entier
// X;X masque de tableau 1;25;50
var to_return = false;
var array_num = new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var result="";

switch(masque) {
 case "X.X":
	var firstdot= false;
	for( i=0; i < u_field_num.length; i++ ) {
		if ((!isNaN(u_field_num[i]) || u_field_num[i]=="," || u_field_num[i]=="." || u_field_num[i]=="-") && u_field_num[i]!=" "){
			if ((u_field_num[i]=="," || u_field_num[i]==".") && firstdot==false) {
			array_num.push(".");
			firstdot=true;
			} else {
  	 	array_num.push(u_field_num[i]);
		 }
		}
	}
	if ($(id_field.id)) {
	$(id_field.id).value=array_num.toString().replace(/,/g,"");
	}
 break;
 case "X.XY":
	var firstdot= false;
	for( i=0; i < u_field_num.length; i++ ) {
		if ((!isNaN(u_field_num[i]) || u_field_num[i]=="," || u_field_num[i]=="." || u_field_num[i]=="-") && u_field_num[i]!=" "){
			if ((u_field_num[i]=="," || u_field_num[i]==".") && firstdot==false) {
			array_num.push(".");
			firstdot=true;
			} else {
  	 	array_num.push(u_field_num[i]);
		 }
		}
	}
	if ($(id_field.id)) {
	$(id_field.id).value=parseFloat(array_num.toString().replace(/,/g,"")).toFixed(tarifs_nb_decimales);
	}
 
 break;
 case "X.XX":
	var firstdot= false;
	 for( i=0; i < u_field_num.length; i++ ) {
			if ((!isNaN(u_field_num[i]) || u_field_num[i]=="," || u_field_num[i]==".") && u_field_num[i]!=" "){
				if ((u_field_num[i]=="," || u_field_num[i]==".") && firstdot==false) {
				array_num.push(".");
				firstdot=true;
				} else {
				array_num.push(u_field_num[i]);
				}
			}
		}
	if ($(id_field.id)) {
	$(id_field.id).value=parseFloat(array_num.toString().replace(/,/g,"")).toFixed(tarifs_nb_decimales);
	}
 
 break;
 case "X":
 
	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" "){
  	 array_num.push(u_field_num[i]);
		}
	}
	if ($(id_field.id)) {
	$(id_field.id).value=Math.round((array_num.toString().replace(/,/g,"")));
	}
 
 break;
 case "X;X":
	for( i=0; i < u_field_num.length; i++ ) {
		if ((!isNaN(u_field_num[i]) || u_field_num[i]==";") && u_field_num[i]!=" "){
			array_num.push(u_field_num[i]);
		}
	}
	if ($(id_field.id)) {
	$(id_field.id).value=array_num.toString().replace(/,/g,"").replace(/;;/g,";");
	}
 
 break;
 case "X.XX;X.XX":
		for( i=0; i < u_field_num.length; i++ ) {
			if ((!isNaN(u_field_num[i]) || u_field_num[i]==";" || u_field_num[i]=="," || u_field_num[i]==".")){
				if (u_field_num[i]==","){
					array_num.push(".");
				}
				array_num.push(u_field_num[i]);
			}
		}
		if ($(id_field.id)) {
		var regex0 = new RegExp(",.,,,", "g");
		var regex1 = new RegExp(",;,", "g");
		var regex2 = new RegExp(",", "g");
		var regex3 = new RegExp(",", "g");
		$(id_field.id).value=array_num.toString().replace(regex0,".").replace(regex1,";").replace(regex2,"");//.replace(regex3,".");
		}
	 
	 break;

}
	
	if ($(id_field.id) && ($(id_field.id).value=="" || $(id_field.id).value=="NaN") ) {$(id_field.id).value=val_def; to_return = false;} else {to_return  = true;}
	return to_return;
}
//*****************************************************************************************************************
//fonction de simplification des evenement sur fausse liste de sélection de catégorie d'articles
//*****************************************************************************************************************

//fonction de change ref_ art_categ dans l'edition d'un article

function changeref_art_categ3() { 
var AppelAjax = new Ajax.Request(
							"catalogue_articles_edition_test_modele_info.php", 
							{
							parameters: {ref_art_categ: $("mod_ref_art_categ").value, old_ref_art_categ: $("old_ref_art_categ").value},
							evalScripts:true, 
							onLoading:S_loading, onException: function () {S_failure();},
							onSuccess: function (requester){
								if (requester.responseText == "new") {
									page.traitecontent('catalogue_articles_modele_info_bis','catalogue_articles_edition_new_modele_info.php?ref_art_categ='+$("mod_ref_art_categ").value,'true','new_modele_info'); 
									$("old_ref_art_categ").value = $("mod_ref_art_categ").value;
								}
								H_loading();
							
							}
							}
							);
}


// affichage liste déroulante simulée des categories d'articles
function pre_start_art_categ (ref_art_categ, lib_art_categ, inpendice){
	Event.observe('tr_'+ref_art_categ+inpendice, 'mouseover',  function(){changeclassname ('tr_'+ref_art_categ+inpendice, 'list_art_categs_hover');}, false);
			
	Event.observe('tr_'+ref_art_categ+inpendice, 'mouseout',  function(){changeclassname ('tr_'+ref_art_categ+inpendice, 'list_art_categs');}, false);
			
	Event.observe('mod_'+ref_art_categ+inpendice, 'click',  function(evt){
		Event.stop(evt);
		var constructeurUpdater = new SelectUpdater("ref_constructeur"+inpendice, "constructeurs_liste.php?ref_art_categ="+ref_art_categ);
		constructeurUpdater.run("");
		$("ref_art_categ"+inpendice).value=ref_art_categ; 
		if(ref_art_categ == "tous") {
		$("ref_art_categ"+inpendice).value=""; 
		}
		Element.toggle('liste_de_categorie_selectable'+inpendice); 
		Element.toggle('iframe_liste_de_categorie_selectable'+inpendice); 
		$("lib_art_categ"+inpendice).innerHTML=lib_art_categ; 
 }, false);

}


// affichage liste déroulante simulée des categories d'articles (variation pour moteur de recherche article avancé
function pre_start_art_categ2 (ref_art_categ, lib_art_categ, inpendice){
	
	Event.observe('tr_'+ref_art_categ+inpendice, 'mouseover',  function(){changeclassname ('tr_'+ref_art_categ+inpendice, 'list_art_categs_hover');}, false);
			
	Event.observe('tr_'+ref_art_categ+inpendice, 'mouseout',  function(){changeclassname ('tr_'+ref_art_categ+inpendice, 'list_art_categs');}, false);

	Event.observe('mod_'+ref_art_categ+inpendice, 'click',  function(evt){
		Event.stop(evt);  
		$("ref_art_categ").value=ref_art_categ; 
		var constructeurUpdater = new SelectUpdater("ref_constructeur", "constructeurs_liste.php?ref_art_categ="+ref_art_categ);
		constructeurUpdater.run("");
		Element.toggle('liste_de_categorie_selectable'+inpendice); 
		Element.toggle('iframe_liste_de_categorie_selectable'+inpendice);  
		Element.show("caract_simple"); 
		$("lib_art_categ"+inpendice).innerHTML=lib_art_categ; charger_carac_simple(ref_art_categ, "caract_simple");
																																																																																																																																																																																					}, false);
}

// affichage liste déroulante simulée des categories d'articles modification de l'art_categ de l'article
function pre_start_art_categ3 (ref_art_categ, lib_art_categ, inpendice){
	Event.observe('tr_'+ref_art_categ+inpendice, 'mouseover',  function(){changeclassname ('tr_'+ref_art_categ+inpendice, 'list_art_categs_hover');}, false);
			
	Event.observe('tr_'+ref_art_categ+inpendice, 'mouseout',  function(){changeclassname ('tr_'+ref_art_categ+inpendice, 'list_art_categs');}, false);
			
	Event.observe('mod_'+ref_art_categ+inpendice, 'click',  function(evt){Event.stop(evt);  $("mod_ref_art_categ"+inpendice).value=ref_art_categ; changeref_art_categ3(); Element.toggle('liste_de_categorie_selectable'+inpendice); Element.toggle('iframe_liste_de_categorie_selectable'+inpendice); $("lib_art_categ"+inpendice).innerHTML=lib_art_categ; }, false);
			
}

// affichage liste déroulante simulée des categories d'articles ajout dans l'inventaire de l'art_categ
function pre_start_art_categ4 (ref_art_categ, lib_art_categ, inpendice){
	Event.observe('tr_inv_'+ref_art_categ+inpendice, 'mouseover',  function(){changeclassname ('tr_inv_'+ref_art_categ+inpendice, 'list_art_categs_hover');}, false);
			
	Event.observe('tr_inv_'+ref_art_categ+inpendice, 'mouseout',  function(){changeclassname ('tr_inv_'+ref_art_categ+inpendice, 'list_art_categs');}, false);
			
	Event.observe('mod_inv_'+ref_art_categ+inpendice, 'click',  function(evt){Event.stop(evt);  $("new_inv_ref_art_categ"+inpendice).value=ref_art_categ; Element.toggle('liste_de_categorie_selectable'+inpendice); Element.toggle('iframe_liste_de_categorie_selectable'+inpendice); $("lib_art_categ"+inpendice).innerHTML=lib_art_categ; }, false);
			
}


function tb2_aff_resultat_1() {
	
	var AppelAjax = new Ajax.Updater(
																	"tb2_det_aff", 
																	"tableau_bord_ventes_tb2_contener2.php", 
																	{parameters: {date_debut: $("date_debut").value, date_fin: $("date_fin").value, type_progress: $("type_progress").value},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete: function(requester) {
																						H_loading(); 
																					}
																	}
																	);
}

function recalcul_date_search (date_debut, date_fin, type_progress, valeur) {
	var val_depart_calcul = "";
	var reg1=new RegExp("[0-9]{2}-[0-9]{2}-[0-9]{4}","g");
	if ( date_fin.length == 10 && date_fin.match(reg1) ) {
		val_depart_calcul = date_fin;
	}
	if ( date_debut.length == 10 && date_debut.match(reg1) ) {
		val_depart_calcul = date_debut;
	}
	if (val_depart_calcul){
		switch(type_progress) {
		 case "J":
				var tab = val_depart_calcul.split("-");
				if (tab[1].substr(0,1) == '0') { tab[1] = tab[1].substr(1,2); }
				if (tab[0].substr(0,1) == '0') { tab[0] = tab[0].substr(1,2); }
		 		var tmp_date_fin=new Date(tab[2],(parseInt(tab[1])-1),(parseInt(tab[0])+parseInt(valeur)),0,0);
				
				tmp_jour = tmp_date_fin.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_fin.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_fin").value= (tmp_jour+"-"+tmp_mois+"-"+tmp_date_fin.getFullYear());
				
				var tmp_date_debut = new Date(tab[2],(parseInt(tab[1])-1),(parseInt(tab[0])+parseInt(valeur)),0,0);
				tmp_jour = tmp_date_debut.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_debut.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_debut").value=  (tmp_jour+"-"+tmp_mois+"-"+tmp_date_debut.getFullYear());

		 break;
		 case "S":
		 		var pendent_valeur = 7;
				var tab = val_depart_calcul.split("-");
				if (tab[1].substr(0,1) == '0') { tab[1] = tab[1].substr(1,2); }
				if (tab[0].substr(0,1) == '0') { tab[0] = tab[0].substr(1,2); }
				
		 		var tmp_date_fin=new Date(tab[2],(parseInt(tab[1])-1),(parseInt(tab[0])+(parseInt(valeur)*pendent_valeur)+6 ),0,0);
				
				var tmp_date_debut = new Date(tab[2],(parseInt(tab[1])-1),(parseInt(tab[0])+(parseInt(valeur)*pendent_valeur)),0,0);
				
				tmp_jour = tmp_date_fin.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_fin.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_fin").value= (tmp_jour+"-"+tmp_mois+"-"+tmp_date_fin.getFullYear());
				
				tmp_jour = tmp_date_debut.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_debut.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_debut").value=  (tmp_jour+"-"+tmp_mois+"-"+tmp_date_debut.getFullYear());

		 break;
		 case "M":
				var tab = val_depart_calcul.split("-");
				if (tab[1].substr(0,1) == '0') { tab[1] = tab[1].substr(1,2); }
				if (tab[0].substr(0,1) == '0') { tab[0] = tab[0].substr(1,2); }
		 		var tmp_date_fin=new Date(tab[2],(parseInt(tab[1])+parseInt(valeur)),0,0,0);
				
				tmp_jour = tmp_date_fin.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_fin.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_fin").value= (tmp_jour+"-"+tmp_mois+"-"+tmp_date_fin.getFullYear());
				
				var tmp_date_debut = new Date(tab[2],(parseInt(tab[1])-1+parseInt(valeur)),1,0,0);
				tmp_jour = tmp_date_debut.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_debut.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_debut").value=  (tmp_jour+"-"+tmp_mois+"-"+tmp_date_debut.getFullYear());

		 break;
		 case "A":
				var tab = val_depart_calcul.split("-");
				if (tab[1].substr(0,1) == '0') { tab[1] = tab[1].substr(1,2); }
				if (tab[0].substr(0,1) == '0') { tab[0] = tab[0].substr(1,2); }
		 		var tmp_date_fin=new Date(parseInt(tab[2])+parseInt(valeur),11,31,0,0);
				
				tmp_jour = tmp_date_fin.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_fin.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_fin").value= (tmp_jour+"-"+tmp_mois+"-"+tmp_date_fin.getFullYear());
				
				var tmp_date_debut = new Date(parseInt(tab[2])+parseInt(valeur),0,1,0,0);
				tmp_jour = tmp_date_debut.getDate();
				if (tmp_jour< 10) {tmp_jour = "0"+tmp_jour}
				tmp_mois = (tmp_date_debut.getMonth()+1);
				if (tmp_mois< 10) {tmp_mois = "0"+tmp_mois}
		 		$("date_debut").value=  (tmp_jour+"-"+tmp_mois+"-"+tmp_date_debut.getFullYear());

		 break;
		}
	}
}

function tb4_aff_resultat_1() {
	
	var AppelAjax = new Ajax.Updater(
																	"tb4_det_aff", 
																	"documents_historique_ventes_content.php", 
																	{parameters: {date_debut: $("date_debut").value, date_fin: $("date_fin").value, type_progress: $("type_progress").value, id_stock: "", type_values: $("type_values").value},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete: function(requester) {
																						H_loading(); 
																					}
																	}
																	);
}