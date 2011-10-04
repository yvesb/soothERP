//------------------------------------------
//------------------------------------------
// function visuelles des menus de liste horizontaux (changement de couleur et affichage)
//------------------------------------------
//------------------------------------------


//
//menu d'affichage menu horizontaux géré par tableau javascript
//
function view_menu_1(id_contenu, id_menu, array_id) {
array_id.each(function(j) {
								if(j!=undefined) {
									if ($(j[0])) {
										$(j[0]).style.display="none";
										$(j[1]).className="menu_unselect";
									}
								}
							}
						);

$(id_contenu).style.display="block";
$(id_menu).className="menu_select";
}
//
//
//menu d'affichage menu horizontaux de la page visualisation d'un contact et moteur de recherche
//
function view_menu(id_contenu, id_menu, menu, id_aff) {
var menuselected = document.getElementsByClassName('menu_select', menu);
for (var i=0; i<menuselected.length;i++) {
$(menuselected[i]).className="menu_unselect";
}
var aff_menu_selected = document.getElementsByClassName('menu_link_affichage', id_aff);
for (var j=0; j<aff_menu_selected.length;j++) {
$(aff_menu_selected[j]).style.display="none";
}
		$(id_contenu).style.display="block";
		$(id_menu).className="menu_select";
}
//
//menu d'affichage menu horizontaux secondaire (affichage de coord adresse sites)
//
function view_menu_sec() {
    for ( var n=0; n<arguments.length;n++)
    {
			if (pair(n)) {
				
				if (n==0) {
				$(arguments[n]).style.display='block';
				}else {
				$(arguments[n]).style.display='none';
				}
			
		} else {
				if (n==1) {
				$(arguments[n]).className="menu_sec_select";
				}else {
				$(arguments[n]).className="menu_sec_unselect";
				}
		}
    }
}

// fontion connexe au menu horizontaux
function pair(nombre)
{
   if(nombre/2 == Math.round(nombre/2))
   {
      return 1;
   }
   else
   {
      return 0;
   }
}

//
function view_one_content_of_x (id_contenu, array_id) {
array_id.each(function(j) {
								if(j!=undefined) {
									if ($(j[0])) {
										$(j[0]).style.display="none";
									}
								}
							}
						);

$(id_contenu).style.display="block";
}


//menu page accueil
function view_menu_accueil(id_contenu, id_menu, array_id, hide_class, show_class) {
	array_id.each(function(j) {
									if(j!=undefined) {
										if ($(j[0])) {
											$(j[0]).style.display="none";
											$(j[1]).className= hide_class;
										}
									}
								}
							);
	
	$(id_contenu).style.display="block";
	$(id_menu).className=show_class;
}