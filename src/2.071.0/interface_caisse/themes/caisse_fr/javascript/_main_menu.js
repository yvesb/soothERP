//
// MENU PRINCIPAL 
//
// contruction du menu
function construct_menu () {
	left_deca=20;
	for (i=0; i < menu_id.length; i++) {
		$(menu_id[i]).style.left=left_deca+"px";
		$(menu_id[i]).style.display="block";
		table_id="table_"+menu_id[i];
		left_deca=left_deca + $(table_id).clientWidth+10;
	}
}

//affichage des sous-menu
function montre(id,idorigin) {
	var d = $(id);
	var table_d= $("table_"+id);
	var dori = $(idorigin);

	if (navigator.appName=='Microsoft Internet Explorer') {
		$("framemenu").style.display="none";
	}
	for (var i = 1; i<=10; i++) {
		if (document.getElementById("smenu"+i)) {document.getElementById("smenu"+i).style.display="none";}
	}
	if (d) {
	d.style.display="block";
	d.style.left=dori.style.left;
	
		if (navigator.appName=='Microsoft Internet Explorer') {
		$("framemenu").style.display="block";
		$("framemenu").style.width=table_d.offsetWidth;
		$("framemenu").style.height=table_d.offsetHeight;
		$("framemenu").style.left=dori.style.left;
		}
	}
}


