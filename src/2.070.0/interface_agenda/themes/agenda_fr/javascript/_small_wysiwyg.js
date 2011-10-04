// _small_wysiwyg.js

var usehtmleditor; 
usehtmleditor = true;

//
//
// protype de de small edidor wysiwyg
function HTML_wysiwyg(){
this.IE  = window.ActiveXObject ? true : false; 
this.MOZ = window.sidebar       ? true : false; 
this.bookmark = null;
}
HTML_wysiwyg.prototype = {
	initialize : function() {
	},
	
	//démarage c'est ici qu'on parametre l'éditeur
	HTML_editor : function(formbox, htmlbox, editfctname)	{
			this.formbox	=	formbox;
			this.htmlbox	=	htmlbox;
			this.editfctname	=	editfctname;

			var postcontent = $(this.formbox).value;
			$(this.htmlbox).contentWindow.document.designMode = "on"; 
			try { 
				$(this.htmlbox).contentWindow.document.execCommand("undo", false, null); 
					}  catch (e) { 
						alert("Cet éditeur de texte ne fonctionne pas sur ce navigateur"); 
					} 
			$(this.htmlbox).contentWindow.document.open();
			$(this.htmlbox).contentWindow.document.write('<html><body bgcolor="FFFFFF" leftmargin="1" topmargin="1" style="font-family:  Arial, Verdana; font-size: 0.8em; color: 000000; ">');
			$(this.htmlbox).contentWindow.document.write(postcontent);
			$(this.htmlbox).contentWindow.document.write('</body></html>');
			$(this.htmlbox).contentWindow.document.close();
			$(this.formbox).style.display = 'none';
			$(this.htmlbox).style.display = 'block';		
		
	},
	
	//exécute les commandes de base
	HTML_exeCmd: function (cmd, param) {
			$(this.htmlbox).contentWindow.document.execCommand(cmd, false, param); 
	},
	//récupére le texte sélectionné
	HTML_getTexteselect: function () { 
   if (this.MOZ) { 
      var sel = $(this.htmlbox).contentWindow.getSelection(); 
   } 
   	else 
   { 
      var sel = $(this.htmlbox).contentWindow.document.selection.createRange().text; 
   } 
   return sel; 
	},
	
	//vérifie que nous somme bien dans la fenêtre d'édition
	isSelected: function () {
		if (this.target().focus){
				if (($(this.htmlbox).contentWindow.document.selection.type == "Text") || ($(this.htmlbox).contentWindow.document.selection.type == "Control")) {
					return true;
				} else {
					return false;
				}
		 }
  },

	//enregistre la sélection courante
	recordRange : function(optional) {
	if (!this.MOZ ) {
		selection = $(this.htmlbox).contentWindow.document.selection;
		if (selection != null) rng = selection.createRange();
			this.bookmark = rng.getBookmark ? rng.getBookmark() : null;
		if (optional==2){
			setTimeout(function() {
			  	if (rng.select)
				  	rng.select();
				},2);
		}
	} else {
		selection = this.HTML_getTexteselect();	
		rng = (selection.rangeCount == 0) ? null : selection.getRangeAt(0).cloneRange(); 
		if (rng && !this.isContentEditable(rng.commonAncestorContainer))
			rng = null;
		else {
			this.startContainer = rng.startContainer;
			this.endContainer = rng.endContainer;
			this.startOffset = rng.startOffset;
			this.endOffset= rng.endOffset;			
		}
	}

	return rng;
},
	//restaure la sélection dans la fenetre
	restoreRange: function () {
		if (this.bookmark){
			rng.moveToBookmark(this.bookmark);
			rng.select();
		}
		else if (this.startContainer) {
			rng.setStart(this.startContainer,this.startOffset);
			rng.setEnd(this.endContainer,this.endOffset);
		}
	},
	//verify que le contenu est éditable
	isContentEditable : function(element) {		
		if (!this.MOZ)
			return element.isContentEditable;
		do {
			if (element.getAttribute && element.contentEditable)
				return true;
		}
		while (element.contentEditable!==false && (element = element.parentNode))
	},

	//masque la palette de couleur
	dismisscolorpalette : function () { 
			document.getElementById("colorpalette").style.display="none"; 
	},
	//donne le nom d'argument qui correspond au surlignage suivant le navigateur
	HTML_surlignage: function () {
		if (!this.MOZ) {
			parent.command = "backcolor";
		} else {
			parent.command = "hilitecolor";
		}
	},
	// récup des styles de la sélection  
	//pas fini
	HTML_getstyle : function () {
		if (!this.MOZ) {
			A = $(this.htmlbox).contentWindow.document.selection.createRange().parentElement();
			
		} else {
			A=this.HTML_getTexteselect().anchorNode;
		}
	},
	// delai avant de lancer la récup de style en cas de saisie clavier
		HTML_getstyle_delay : function (delay) {
			if (this.LastOnChangeTimer) window.clearTimeout(this.LastOnChangeTimer);
			this.LastOnChangeTimer=setTimeout(this.editfctname+".HTML_getstyle()",delay);
	},
	
	//retourne l'id de l'iframe cible
	target: function (){
		return this.htmlbox;
	},
	HTML_save: function () {
	$(this.formbox).value=$(this.htmlbox).contentWindow.document.body.innerHTML;
		
	},
	HTML_load: function () {
	$(this.htmlbox).contentWindow.document.body.innerHTML=$(this.formbox).value;
		
	}
 

	
}

function getOffsetTop(elm) {

  var mOffsetTop = elm.offsetTop;
  var mOffsetParent = elm.offsetParent;

  while(mOffsetParent){
    mOffsetTop += mOffsetParent.offsetTop;
    mOffsetParent = mOffsetParent.offsetParent;
  }
 
  return mOffsetTop;
}

function getOffsetLeft(elm) {

  var mOffsetLeft = elm.offsetLeft;
  var mOffsetParent = elm.offsetParent;

  while(mOffsetParent){
    mOffsetLeft += mOffsetParent.offsetLeft;
    mOffsetParent = mOffsetParent.offsetParent;
  }
 
  return mOffsetLeft;
}