// fonctiobn profil_admin

//gestion des catégories d'articles

//lancement de sauvegarde ou de suppréssion à la coche ou à la décoche des choix.
//non utilisée
function saveordeleteifcheck (id_coche, page2call, ref_coche, ref_globale) {
		if ($(id_coche).checked) {
			var AppelAjax = new Ajax.Request(
									page2call, {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { checked_case: '1', id_t : ref_coche, ref_g: ref_globale}
									}
									);
		}
		else
		{
			var AppelAjax = new Ajax.Request(
									page2call, {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { checked_case: '0', id_t : ref_coche, ref_g: ref_globale}
									}
									);
			
		}
	
	
}

function maj_commission_art_categ (id_commission_regle, ref_art_categ, formule_comm, old_formule_comm) {
			var AppelAjax = new Ajax.Request(
									'commission_art_categ_mod.php', {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { id_commission_regle: id_commission_regle, ref_art_categ : ref_art_categ, formule_comm: formule_comm, old_formule_comm: old_formule_comm}
									}
									);
}

function maj_commission_article (id_commission_regle, ref_article, formule_comm, old_formule_comm) {
			var AppelAjax = new Ajax.Request(
									'commission_article_mod.php', {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { id_commission_regle: id_commission_regle, ref_article : ref_article, formule_comm: formule_comm, old_formule_comm: old_formule_comm}
									}
									);
}