

function start_commune(idcode, idcommune, cible, iframecible, targeturl) {
		
    var cp = $(idcode).value;
    if (cp.length >= 5) {
			
		var AppelAjax = new Ajax.Updater(
																	cible, 
																	targeturl+cp, 
																	{parameters: {ville: idcommune, choix_ville: cible, iframe_choix_ville: iframecible},
																	evalScripts:true, 
																	onComplete: function(requester) {
																					if (requester.responseText!="") {
																					$(cible).style.display="block";
																					$(iframecible).style.display="block";
																			
																					}
																					}
																	}
																	);
    
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

/*-------------------------------------------------------*/
/** DOM event */
if (!window.Event) {
  Event = new Object();
}

Event.event = function(event) {
  // W3C ou alors IE
  return (event || window.event);
}

Event.target = function(event) {
  return (event) ? event.target : window.event.srcElement ;
}

Event.preventDefault = function(event) {
  var event = event || window.event;
  if (event.preventDefault) { // W3C
    event.preventDefault();
  }
  else { // IE
    event.returnValue = false;
  }
}

Event.stopPropagation = function(event) {
  var event = event || window.event;
  if (event.stopPropagation) {
    event.stopPropagation();
  }
  else {
    event.cancelBubble = true;
  }
}

/*-------------------------------------------------------*/
// Permettre new XMLHttpRequest() dans IE sous Windows
if (!window.XMLHttpRequest && window.ActiveXObject) {
  try {
    // Tester si les ActiveX sont autorises
    new ActiveXObject("Microsoft.XMLHTTP");
    // Definir le constructeur
    window.XMLHttpRequest = function() {
      var request;
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(exc) {
        request = new ActiveXObject('Msxml2.XMLHTTP');
      }
      return request;
    }
  }
  catch (exc) {}
}





function SelectUpdater(idSelect, getOptionsUrl) {	
  this.select = document.getElementById(idSelect);
  /** Url de la requête XMLHttpRequest mettant à jour @type String */
  this.url = getOptionsUrl;
  this.request = null;
}

SelectUpdater.prototype = {
	
  run: function(value) {
		
    if (this.request) {
      try {
        this.request.abort();
      }
      catch (exc) {}
    }
    try {
      this.request = new XMLHttpRequest();
      var url = this.url + encodeURIComponent(value);
      this.request.open("GET", url, true);
      this.show();
      var current = this;
      this.request.onreadystatechange = function() {
        try {
          if (current.request.readyState == 4) {
            if (current.request.status == 200) {
              current.onload();
            }
          }
        }
        catch (exc) {}
      }
      this.request.send("");
    }
    catch (exc) {
      //Log.debug(exc);
    }
  },
  
  /** Mettre à jour la liste à la réception de la réponse */
  onload: function() {
    this.select.innerHTML = "";
    this.hide();
    if (this.request.responseText.length != 0) {
      // Le resultat n'est pas vide
      var options = this.request.responseText.split(";");
      var item, option;
      for (var i=0 ; i<options.length ; i++) {
        item = options[i].split("="); // value = text
        option = document.createElement("option");
        option.setAttribute("value", item[0]);
        option.innerHTML = item[1];
        this.select.appendChild(option);
      }
    }
  },
  
  /** Montrer que l'appel est en cours */
  show: function() {

  },
  
  /** Effacer le message */
  hide: function() {

  },
  
  /** Effacer la liste et le message, et annuler l'appel éventuel */
  reset: function() {
    this.select.innerHTML = "";
    try {
      if (this.request) {
        this.request.abort();
      }
    }
    catch (exc) {
    //  Log.debug(exc);
    }
  }
}


function changeclassname (id_cible, newclass) {
	$(id_cible).className=newclass;
}

//mise à jour du contact
//public check_majinfos_contact()
function check_majinfos_contact() {//livraison_ref_adresse
	//check les informtions du formulaire "formulaire_maj_client" de la page "page_user_info.inc.php"
	var listes_alertes = "";
	var alertes = "";
	
	//champs au format normal avant vérification
	changeclassname ("nom", 			"classinput_xsize");
	changeclassname ("pseudo", 			"classinput_xsize");
	changeclassname ("emaila",			"classinput_xsize");
	changeclassname ("passworda", 		"classinput_xsize");
	changeclassname ("passwordb", 		"classinput_xsize");
	changeclassname ("passwordold", 	"classinput_xsize");
	
	changeclassname ("facturation_adresse", 	"classinput_xsize");
	changeclassname ("facturation_code_postal",	"classinput_xsize");
	changeclassname ("facturation_ville", 		"classinput_xsize");
	
	if($("nom").value == "" )
	{	listes_alertes += "nom, "; changeclassname ("nom", "alerteform_xsize");}
	
	var pseudo = $("pseudo").value;
	if (pseudo == "")	// Le champs pseudo est vide
	{	alertes += "Veuillez indiquer un pseudonyme. \n"; changeclassname ("pseudo", "alerteform_xsize");}
	else{	// On vérifie si le pseudo existe déjà 
		var AppelAjax2 = new Ajax.Request(
				"_check_id_present.php",{
				parameters	: {pseudo: pseudo},
				evalScripts	: true, 
				onComplete	: function(requester) {
								if (requester.responseText!="") {
									alertes += "Cette identifiant est déjà utilisé! \n";
									changeclassname ("pseudo", "alerteform_xsize");
								}
							}
				}
			);
	}
	
	
	var emaila = $("emaila").value;
	var patrn_email = "^([a-zA-Z0-9]+(\.)?[\-\_]*[a-zA-Z0-9]+)+\@([a-zA-Z0-9]+(\.)?[\-\_]*[a-zA-Z0-9]+)+\.[a-zA-Z]{2,4}$";
	var regex_email = new RegExp(patrn_email,"i");
	
	if(emaila == "" || !regex_email.test(emaila)){	// Le champs emaila est vide ou l'adresse est mal formée
		alertes += "Veuillez indiquer une adresse Email valide. \n"; 
		changeclassname ("emaila", "alerteform_xsize");
	}else{ // les 2 adresses mails sont bien formée et sont identiques
		var AppelAjax2 = new Ajax.Request(
				"_check_email_present.php",{
				parameters	: {email: emaila},
				evalScripts	: true, 
				onComplete	: function(requester) {
								if (requester.responseText!="") {
									alertes += "Cette adresse email est déjà utilisée! \n";
									changeclassname ("emaila", "alerteform_xsize");
									changeclassname ("emailb", "alerteform_xsize");
								}
							}
				}
			);
	}
	
	if($("facturation_adresse").value == "" )
	{	listes_alertes += "adresse, "; changeclassname ("facturation_adresse", "alerteform_xsize");}
	if($("facturation_code_postal").value == "" )
	{	listes_alertes += "code postal, "; changeclassname ("facturation_code_postal", "alerteform_xsize");}
	if ($("facturation_ville").value == "" )
	{	listes_alertes += "ville, "; changeclassname ("facturation_ville", "alerteform_xsize");}
	
	var passwordold	= $("passwordold").value;
	var passworda 	= $("passworda").value;
	var passwordb	= $("passwordb").value;
	
	alertMDP = false;
	if(passwordold.lenght > 0 || passworda.lenght > 0 || passwordb.lenght > 0){
		// l'utilisateur souhaite changer son mot de passe
		
		if (passwordold == ""){
			alertes += "Veuillez indiquer votre mot de passe. ";
			changeclassname ("passworda", "alerteform_xsize");
			changeclassname ("passwordb", "alerteform_xsize");
			alertMDP = true;
		}else if(passworda.length < 4){
			alertes += "Votre mot de passe fait au minimum 4 caractères. ";
			changeclassname ("passworda", "alerteform_xsize");
			changeclassname ("passwordb", "alerteform_xsize");
			alertMDP = true;
		}
		
		if (passworda == ""){
			alertes += "Veuillez indiquer un mot de passe. ";
			changeclassname ("passworda", "alerteform_xsize");
			changeclassname ("passwordb", "alerteform_xsize");
			alertMDP = true;
		}else if(passworda.length < 4){
			alertes += "Votre mot de passe dois faire au minimum 4 caractères. ";
			changeclassname ("passworda", "alerteform_xsize");
			changeclassname ("passwordb", "alerteform_xsize");
			alertMDP = true;
		}
		
		if (passwordb == ""){
			alertes += "Veuillez confirmer votre nouveau mot de passe. ";
			changeclassname ("passworda", "alerteform_xsize");
			changeclassname ("passwordb", "alerteform_xsize");
			alertMDP = true;
		}else if(passwordb != passworda){
			alertes += "Veuillez confirmer votre mot de passe. ";
			changeclassname ("passwordb", "alerteform_xsize");
			alertMDP = true;
		}
		
		if(!alertMDP){ // Aucune alerte du mot de passe
			
			
		}
	}
	
	if (listes_alertes == "" && alertes == "")
	{	$("formulaire_maj_client").submit();}
	else
	{	part_1 = "";
		part_2 = "";
		if(listes_alertes != "")
		{	part_1 = "Veuillez indiquez le(s) "+listes_alertes+" de contact.";}
		if(alertes != "")
		{	part_2 = alertes;}
		alert (part_1+"\n\n"+part_2);
	}
}


//public function check_infos_nouveau_client()
function check_infos_nouveau_client() {
	//check les informtions du formulaire "formulaire_nouveau_client" de la page "page_inscription.inc.php"
	
	var listes_alertes = "";
	var alertes = "";

	//champs au format normal avant vérification
	changeclassname ("nom", 			"classinput_xsize");
	changeclassname ("pseudo",			"classinput_xsize");
	changeclassname ("emaila",			"classinput_xsize");
	changeclassname ("emailb",			"classinput_xsize");
	changeclassname ("passworda", 		"classinput_xsize");
	changeclassname ("passwordb", 		"classinput_xsize");
	
	changeclassname ("facturation_adresse", 	"classinput_xsize");
	changeclassname ("facturation_code_postal",	"classinput_xsize");
	changeclassname ("facturation_ville", 		"classinput_xsize");
	
	if($("nom").value == "" )
	{	listes_alertes += "nom, "; changeclassname ("nom", "alerteform_xsize");}
	
	var pseudo = $("pseudo").value;
	if (pseudo == "")	// Le champs pseudo est vide
	{	alertes += "Veuillez indiquer un pseudonyme. \n"; changeclassname ("pseudo", "alerteform_xsize");}
	else{	// On vérifie si le pseudo existe déjà 
		var AppelAjax2 = new Ajax.Request(
				"_check_id_present.php",{
				parameters	: {pseudo: pseudo},
				evalScripts	: true, 
				onComplete	: function(requester) {
								if (requester.responseText!="") {
									alertes += "Cette identifiant est déjà utilisé! \n";
									changeclassname ("pseudo", "alerteform_xsize");
								}
							}
				}
			);
	}
	
	var emaila = $("emaila").value;
	var emailb = $("emailb").value;
	
	var patrn_email = "^([a-zA-Z0-9]+(([\.\-\_]?[a-zA-Z0-9]+)+)?)\@(([a-zA-Z0-9]+[\.\-\_])+[a-zA-Z]{2,4})$";
	var regex_email = new RegExp(patrn_email,"i");

	if(emaila == "" || !regex_email.test(emaila)){	// Le champs emaila est vide ou l'adresse est mal formée
		alertes += "Veuillez indiquer une adresse Email valide. \n"; 
		changeclassname ("emaila", "alerteform_xsize");
		changeclassname ("emailb", "alerteform_xsize");
	}else if(emaila != emailb)	
	{	alertes += "Veuillez confirmer votre adresse Email. \n"; changeclassname ("emailb", "alerteform_xsize");}
	else{ // les 2 adresses mails sont bien formée et sont identiques
		var AppelAjax2 = new Ajax.Request(
				"_check_email_present.php",{
				parameters	: {email: emaila},
				evalScripts	: true, 
				onComplete	: function(requester) {
								if (requester.responseText!="") {
									alertes += "Cette adresse email est déjà utilisée! \n";
									changeclassname ("emaila", "alerteform_xsize");
									changeclassname ("emailb", "alerteform_xsize");
								}
							}
				}
			);
	}


	var passworda = $("passworda").value;
	var passwordb = $("passwordb").value;
	
	if (passworda == ""){
		alertes += "Veuillez indiquer un mot de passe. ";
		changeclassname ("passworda", "alerteform_xsize");
		changeclassname ("passwordb", "alerteform_xsize");
	}else if(passworda != passwordb){
		alertes += "Veuillez confirmer votre mot de passe. ";
		changeclassname ("passwordb", "alerteform_xsize");
	}else if(passworda.length < 4){
		alertes += "Votre mot de passe dois faire au minimum 4 caractères. ";
		changeclassname ("passworda", "alerteform_xsize");
		changeclassname ("passwordb", "alerteform_xsize");
	}

	if($("facturation_adresse").value == "" )
	{	listes_alertes += "adresse, "; changeclassname ("facturation_adresse", "alerteform_xsize");}
	if($("facturation_code_postal").value == "" )
	{	listes_alertes += "code postal, "; changeclassname ("facturation_code_postal", "alerteform_xsize");}
	if ($("facturation_ville").value == "" )
	{	listes_alertes += "ville, "; changeclassname ("facturation_ville", "alerteform_xsize");}

	
	if (listes_alertes == "" && alertes == "")
	{	$("formulaire_nouveau_client").submit();}
	else
	{	part_1 = "";
		part_2 = "";
		if(listes_alertes != "")
		{	part_1 = "Veuillez indiquez le(s) "+listes_alertes+" de contact.";}
		if(alertes != "")
		{	part_2 = alertes;}
		alert (part_1+"\n\n"+part_2);
	}
}