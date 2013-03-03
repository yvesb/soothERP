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
																	onLoading:S_loading, onException: function (){S_failure();}, 
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
					Event.observe(survol, "click",  function(){start_coordonnee (ref_contatct, lib_coord, user_coord, choix_coord, iframe_coord, pagecible);}, false);
					
}

function start_coordonnee (ref_contact, iddiv, idinput, cible, iframecible, targeturl) {

if ($(cible).style.display=="none") {
	var AppelAjax = new Ajax.Updater(
																	cible, 
																	targeturl, 
																	{parameters: {ref_contact: ref_contact, choix_coord: cible, iframe_choix_coord: iframecible, input: idinput, div: iddiv},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function (){S_failure();}, 
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
					Event.observe(survol, "click",  function(){start_adresse_crea ( lib_adresse, user_adresse, choix_adresse, iframe_adresse);}, false);
					
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

Event.observe("li_choix_adresse_"+idinput+"_"+i, "click",  function(){$(idinput).value=ordre; $(cible).style.display="none"; $(iframecible).style.display="none"; $(iddiv).innerHTML = texte_racourci; }, false);
}


// affichage liste déroulante des adresses pour un profil client sur une fiche de contact en mode édition
function pre_start_adresse (survol, bt_survol, ref_contatct, lib_adresse, user_adresse, choix_adresse, iframe_adresse, pagecible) {

				//effet de survol sur le faux select
					Event.observe(survol, "mouseover",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_hover.gif";}, false);
					Event.observe(survol, "mousedown",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select_down.gif";}, false);
					Event.observe(survol, "mouseup",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					Event.observe(survol, "mouseout",  function(){$(bt_survol).src=dirtheme+"images/bt-arrow_select.gif";}, false);
					
//affichage des choix
					Event.observe(survol, "click",  function(){start_adresse (ref_contatct, lib_adresse, user_adresse, choix_adresse, iframe_adresse, pagecible);}, false);
					
}

//affichage des adresses présentes dans la base de données pour un contact.
function start_adresse (ref_contact, iddiv, idinput, cible, iframecible, targeturl) {

if ($(cible).style.display=="none") {
	var AppelAjax = new Ajax.Updater(
																	cible, 
																	targeturl, 
																	{parameters: {ref_contact: ref_contact, choix_adresse: cible, iframe_choix_adresse: iframecible, input: idinput, div: iddiv},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function (){S_failure();}, 
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

//
//Masques de saisies de formulaire
//

//masque de date au format jj/mm/aaaa

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
	
	

	
}

$(id_field.id).value=jo+mm+aaaa;
}


//masque de date expiration au format mm-aa

function expdatemask(evt) {
var array_num=new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var mm="";
var aa="";
var error=0;

	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" " && u_field_num[i]!="/"){
		array_num.push(u_field_num[i]);
		}
	}


	for ( i=0; i < array_num.length; i++ ) {

		if (i==0) {
			if (array_num[0]>1) {
			error=1;
			}
				mm+=array_num[i];
		}
		if (i==1) {
			if (array_num[1]>2 && array_num[0]==1) {
			error=1;
			}

			mm+=array_num[i];

		}

			if (i==2 || i==3) {


			aa+=array_num[i];
		}

		if (error==0) {
			$(id_field.id).value=mm+"-"+aa;
			} else {
			$(id_field.id).value="Valeur incorrecte";
			}

	}

}






//masque de saisie numérique
function nummask(evt, val_def, masque) {
// masque type:
// X.X (nombre flotant
// X.XX nombre à deux desimales
// X nombre entier
// X;X masque de tableau 1;25;50
var array_num=new Array;
var id_field = Event.element(evt);
var field_value = id_field.value;
var u_field_num = Array.from(field_value);
var result="";

switch(masque) {
 case "X.X":
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
	$(id_field.id).value=array_num.toString().replace(/,/g,"");
 
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
	$(id_field.id).value=parseFloat(array_num.toString().replace(/,/g,"")).toFixed(2);
 
 break;
 case "X":
 
	for( i=0; i < u_field_num.length; i++ ) {
		if (!isNaN(u_field_num[i]) && u_field_num[i]!=" "){
  	 array_num.push(u_field_num[i]);
		}
	}
	$(id_field.id).value=Math.round((array_num.toString().replace(/,/g,"")));
 
 break;
 case "X;X":
	for( i=0; i < u_field_num.length; i++ ) {
		if ((!isNaN(u_field_num[i]) || u_field_num[i]==";") && u_field_num[i]!=" "){
			array_num.push(u_field_num[i]);
		}
	}
	$(id_field.id).value=array_num.toString().replace(/,/g,"").replace(/;;/g,";");
 
 break;

}

	if ($(id_field.id).value=="") {$(id_field.id).value=val_def;}
}

function count_car_field(element){
	
	var field_value = $(element).value;
	var u_field_num = Array.from(field_value);
	return u_field_num.length;
	
}

function limit_car_field (element, count) {
	
	var field_value = $(element).value;
	var u_field_num = Array.from(field_value);
	var t_field_num = new Array;
	if (count < u_field_num.length) {
		for( i=0; i < count; i++ ) {
			t_field_num.push(u_field_num[i]);
		}
		$(element).value = t_field_num.join("");
		return t_field_num.length;
	}
}

// Teste si le mail a une forme correcte
function checkmail(email) {
	var reg = /^[a-z0-9._-]+@[a-z0-9.-]{2,}[.][a-z]{2,4}$/
	return (reg.exec(email)!=null);
}

function loadFormInterface(int_path){
	var AppelAjax = new Ajax.Updater(
			"view_config_interface",
			"site_interfaces_config.load.php", 
			{
			parameters: { int_path: int_path },
			evalScripts:true, 
			onLoading:S_loading, onException: function () {S_failure();},
			onSuccess: function (requester){
			requester.responseText.evalScripts();
			H_loading();
			}
			}
			);
}