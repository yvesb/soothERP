
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
			S_loading();
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
		H_loading();
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




