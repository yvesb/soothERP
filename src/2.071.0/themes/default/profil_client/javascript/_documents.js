function loadArchives(box, id_type_doc, id_etat_doc, ref_contact){
	var AppelAjax = new Ajax.Updater(
			box,
			"_user_infos_archives.php", 
			{
			parameters: { id_type_doc: id_type_doc, id_etat_doc: id_etat_doc, ref_contact: ref_contact },
			//evalScripts:true, 
			//onLoading:S_loading, onException: function () {S_failure();},
			onSuccess: function (requester){
				Element.hide(box.substr(4));
				Element.show(box);
			//requester.responseText.evalScripts();
			//H_loading();
			}
			}
			);
}