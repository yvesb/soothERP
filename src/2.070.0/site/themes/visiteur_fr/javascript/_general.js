
// protype de message d'alerte
function alerte_message(){

}
alerte_message.prototype = {
	//initialisation du système d'affichage des alertes
	initialize : function() {
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
	},
		
	//alerte avec texte envoyé par la fonction (deux boutons)
	alerte_message: function(alerte_titre, alerte_texte, alerte_bouton) {
	
		$("titre_alert").innerHTML = alerte_titre;
		$("texte_alert").innerHTML = alerte_texte;
		$("bouton_alert").innerHTML = alerte_bouton;
	
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		}
	}
	
	
}

// ELEMENT de MISE A dimension
//renvois de la hauteur de la fenetre
function getWindowHeight() {
    var windowHeight=0;
    if (typeof(window.innerHeight)=='number') {
        windowHeight=window.innerHeight;
    }
    else {
     if (document.documentElement&&
       document.documentElement.clientHeight) {
         windowHeight = document.documentElement.clientHeight;
    }
    else {
     if (document.body&&document.body.clientHeight) {
         windowHeight=document.body.clientHeight;
      }
     }
    }
    return windowHeight;
}
//renvois de la largeur de la fenetre

function getWindowWidth() {
    var windowWidth=0;
    if (typeof(window.innerWidth)=='number') {
        windowWidth=window.innerWidth;
    }
    else {
     if (document.documentElement&&
       document.documentElement.clientWidth) {
         windowWidth = document.documentElement.clientWidth;
    }
    else {
     if (document.body&&document.body.clientWidth) {
         windowWidth=document.body.clientWidth;
      }
     }
    }
    return windowWidth;
}

function return_width_element(id_element) {
	if($(id_element)) {
		var dimensions = $(id_element).getDimensions(); 
		return dimensions.width; 
	}
}

function return_height_element(id_element) {
	if($(id_element)) {
		var dimensions = $(id_element).getDimensions(); 
		return dimensions.height; 
	}
}

function centrage_element(id_element){
	if($(id_element)) {
		$(id_element).style.top = ( getWindowHeight()-return_height_element(id_element))/2+"px";
		$(id_element).style.left = (getWindowWidth()-return_width_element(id_element))/2+"px";
	}
}
