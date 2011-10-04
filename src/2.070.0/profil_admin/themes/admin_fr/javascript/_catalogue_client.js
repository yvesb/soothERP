//tableau contenant les categorie à mettre à jour
//format: $maj_categ[$id_catalogue][$ref_art_categ] = (1 ou 0)
maj_categ = new Array();


// Catalogues clients
function add_catalogue_client_dir(id_catalogue_client, ref_art_categ, ref_art_categ_parent) {
	var AppelAjax = new Ajax.Request(
									"catalogues_clients_dir_add.php", 
									{
									parameters: {id_catalogue_client: id_catalogue_client, ref_art_categ: ref_art_categ, ref_art_categ_parent: ref_art_categ_parent  },
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading();
									}
									}
									);
}
 
 
 

function del_catalogue_client_dir(id_catalogue_client, ref_art_categ) {
	var AppelAjax = new Ajax.Request(
									"catalogues_clients_dir_del.php", 
									{
									parameters: {id_catalogue_client: id_catalogue_client, ref_art_categ: ref_art_categ},
									evalScripts:true, 
									onLoading:S_loading, onException: function () {S_failure();},
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading();
									}
									}
									);
	
}

//@param number id_categ - id du catalogue a modifier
//@param array maj_categ - format: $maj_categ[$ref_art_categ] = (1 ou 0)
function maj_catalogue_client(id_catal, maj_categ1) {
	for(x in maj_categ1)
	{
		if(typeof(maj_categ1[x]) == 'number'){
			var tab_tmp = x.split('@'); 
			var ref_categ_parent = tab_tmp[0];
			var ref_categ = tab_tmp[1];
			if(maj_categ1[x] == 1){
				add_catalogue_client_dir(id_catal, ref_categ, ref_categ_parent)
			}else{
				del_catalogue_client_dir(id_catal, ref_categ);
			}
		}
	}
	
}


function coche_all_art_categ_to_catalogue(nb_lignes , id_catalogue_client) {
	for (i=0; i < nb_lignes ; i++) {
		$("ins_"+id_catalogue_client+"_"+i).checked = true;
	}
}

function decoche_all_art_categ_to_catalogue(nb_lignes , id_catalogue_client) {
	for (i=0; i < nb_lignes ; i++) {
		$("ins_"+id_catalogue_client+"_"+i).checked = false;
	}
}
