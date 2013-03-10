//PANIER : maj de la qte d'une ligne
function maj_line_qte(qte_article, ref_article, indentation) {
	var AppelAjax = new Ajax.Request(
			"catalogue_panier_line_maj_qte.php",{
			parameters	: {ref_article : ref_article, qte_article : qte_article, indentation : indentation },
			evalScripts	:true,
			onComplete	: function () {window.open("catalogue_panier_view.php", "_self");}
			}
		);
}


//masque de saisie numérique
function nummask(evt, val_def, masque) {
	// masque type:
	// X.X nombre flotant
	// X.XX nombre à deux desimales
	// X nombre entier
	// X;X masque de tableau 1;25;50
	var to_return = false;
	var array_num=new Array;
	var id_field = Event.element(evt);
	var field_value = id_field.value;
	var u_field_num = Array.from(field_value);
	var result="";
	
	switch(masque) {
	 case "X.X":{
		var firstdot= false;
		for(i=0; i < u_field_num.length; i++){
			if((!isNaN(u_field_num[i]) || u_field_num[i]=="," || u_field_num[i]=="." || u_field_num[i]=="-") && u_field_num[i]!=" "){
				if ((u_field_num[i]=="," || u_field_num[i]==".") && firstdot==false) {
					array_num.push(".");
					firstdot=true;
				}else{ array_num.push(u_field_num[i]);}
			}
		}
		if ($(id_field.id))
		{	$(id_field.id).value=array_num.toString().replace(/,/g,"");}
		break;}
	}
	
	if ($(id_field.id) && $(id_field.id).value=="") {$(id_field.id).value=val_def; to_return = false;} else {to_return  = true;}
	return to_return;
}

//PANIER : supprime une ligne
function doc_sup_line (ref_article) {
	var AppelAjax = new Ajax.Request(
			"catalogue_panier_line_sup.php",{
			parameters	: {ref_article: ref_article},
			evalScripts	:true,
			onComplete	: function () {window.open("catalogue_panier_view.php", "_self");}
			}
		);
}

//suppression d'une balise
function remove_tag(id_balise) {
	Element.remove($(id_balise));
}