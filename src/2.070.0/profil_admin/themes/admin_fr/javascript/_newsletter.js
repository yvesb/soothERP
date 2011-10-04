//------------------------------------------
//------------------------------------------
//fonctions destinées aux newsletters
//------------------------------------------
//------------------------------------------


// affichage des formulaires de profil à la création d'une nouvelle newsletter
function affiche_newsletter_profil_nvl (nprofil) {
	if ($("profils"+nprofil).checked) {
		var npzone=$("zoneprofils");
		var npadd=document.createElement("div");
		npadd.setAttribute ("id", "typeprofil"+nprofil);
		npzone.appendChild (npadd);
		page.traitecontent("profil"+nprofil,"communication_nouvelle_newsletter_profil"+nprofil+".php", true ,"typeprofil"+nprofil);
	}
	else
	{
		remove_tag("typeprofil"+nprofil);
	}
}

// affichage des formulaires de profil à l'édition d'une newsletter
function affiche_newsletter_profil_edition (nprofil,id_newsletter) {
	if ($("profils"+nprofil).checked) {
		var npzone=$("zoneprofils");
		var npadd=document.createElement("div");
		npadd.setAttribute ("id", "typeprofil"+nprofil);
		npzone.appendChild (npadd);
		page.traitecontent("profil"+nprofil,"communication_edition_newsletter_profil"+nprofil+".php?id_newsletter="+id_newsletter, true ,"typeprofil"+nprofil);
	}
	else
	{
		remove_tag("typeprofil"+nprofil);
	}
}


//affichage du mail_template
function affiche_mail_template(evt,source,cible) {
	var id_field = Event.element(evt);
	var id_mail_template = id_field.options[id_field.selectedIndex].value;
	
	if (id_mail_template=="0") {
				$(cible).style.visibility="hidden";
	}
	else {
				$(cible).value = $(source+id_mail_template).value;
				$(cible).style.visibility="visible";
	}
}