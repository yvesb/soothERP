<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
$("wait_calcul_content").style.display= "block";

//on lance l'insertions dans le flux xhtml des lignes créés
//variable d'attente du nombre de ligne à inserer depuis un document
wait_for_x_line_doc = 0;
//nombre de lignes chargées
loaded_line_doc = 0;
<?php 
if (isset($_INFOS['new_lines']) && !$document->getQuantite_locked ()) {
	$i = 0;
	$doc_line = $_INFOS['new_lines'];
	for ($j = 0; $j<=count($doc_line)-1; $j++) {
		?>
		// si c'est un article qui a été ajouté, on insére la ref_doc_line dans la ligne correspondant
		<?php
		if ( $doc_line[$j]->type_of_line == "article" && !isset($add_line_link_from_doc) && !isset($insert_line_from_art_categ)) {
			?>
			if ($("ref_doc_line_article_<?php echo $doc_line[$j]->ref_article;?>")) {
				$("ref_doc_line_article_<?php echo $doc_line[$j]->ref_article;?>").value = "<?php echo $doc_line[$j]->ref_doc_line;?>";
				last_ssearch_ref_doc_line = "<?php echo $doc_line[$j]->ref_doc_line;?>";
			}
			<?php 
		}
		
		if ( $doc_line[$j]->type_of_line != "taxe") {
			?>
				wait_for_x_line_doc++;
				var indentation_contenu = $("indentation_contenu").value;
				$("indentation_contenu").value = parseFloat($("indentation_contenu").value)+1;
				var liste_art_doc= $("lignes");
				var addtag= document.createElement("li");
						addtag.setAttribute ("id", "<?php echo $doc_line[$j]->ref_doc_line;?>_"+indentation_contenu);
				liste_art_doc.appendChild(addtag);
				last_parent_doc_line = indentation_contenu;
				
				var AppelAjax = new Ajax.Updater(
												"<?php echo $doc_line[$j]->ref_doc_line;?>_"+indentation_contenu,
												"documents_line_insert.php", 
												{
												parameters: {<?php
													//	print_r ($doc_line);
												foreach ($doc_line[$j] as $variable => $valeur) {
													if (!is_array ($valeur)) {
														echo $variable.': "'.addslashes(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", nl2br(htmlentities(str_replace ("€" ,"¤" , $valeur))))))).'",';
													} else {
														echo $variable.':"';
														foreach ($valeur as $sn_liste) {
															if (is_string($sn_liste)) {
																echo addslashes(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", nl2br(htmlentities($sn_liste)))))).';';
															} else {
																echo addslashes(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", nl2br(htmlentities($sn_liste->numero_serie)))))).';';
															}
														}
														echo '",';
													}
												}
												?> indentation_contenu: indentation_contenu , id_type_doc: '<?php echo $document->getID_TYPE_DOC()?>', ref_doc: $("ref_doc").value },
												evalScripts:true, 
												asynchronous: false, 
												onLoading:S_loading,
												onException: function () { S_failure();},
												onComplete: function (requester){
													add_loaded_line_doc ();
													Sortable.create("lignes",{
														dropOnEmpty:true, 
														ghosting:false, 
														scroll:"document_content", 
														handle: "documents_li_handle", 
														scrollSensitivity: 55, 
														overlap: "vertical", 
														onChange: function(element){
															element_moved=element;
														}, 
														onUpdate: function(){
															doc_line_maj_ordre(element_moved)
														}
													});
												},
												insertion: Insertion.Top
												}
												);



			<?php
			for ($k = 0 ; $k<=count($doc_line)-1; $k++) {
	
				if ( $doc_line[$k]->type_of_line == "taxe" && $doc_line[$j]->ref_doc_line == $doc_line[$k]->ref_doc_line_parent) {
					?>
					var indentation_contenu = $("indentation_contenu").value;
					$("indentation_contenu").value = parseFloat($("indentation_contenu").value)+1;
					
					var parent_line= $("<?php echo $doc_line[$k]->ref_doc_line_parent;?>_"+last_parent_doc_line);
	
					var addtag= document.createElement("div");
							addtag.setAttribute ("id", "<?php echo $doc_line[$k]->ref_doc_line;?>_"+indentation_contenu);
					parent_line.appendChild(addtag);
					
					var AppelAjax = new Ajax.Updater(
													"<?php echo $doc_line[$k]->ref_doc_line;?>_"+indentation_contenu,
													"documents_line_insert.php", 
													{
													parameters: {<?php
													foreach ($doc_line[$k] as $variable => $valeur) {
														if (!is_array ($valeur)) {
															echo $variable.': "'.addslashes(str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", nl2br(htmlentities($valeur)))))).'",';
														}
													}
													?> indentation_contenu: indentation_contenu, id_type_doc: '<?php echo $document->getID_TYPE_DOC()?>', ref_doc: $("ref_doc").value },
													evalScripts:true, 
													asynchronous: false, 
													onLoading:S_loading, onException: function () {S_failure();}, 
													onComplete: function() {
																			}
													}
													);
				
					<?php
				}
			}
		}
		$i++;
		
	}
}
?>

<?php 
// rechargement du block liaisons si l'ajout des lignes a été effectué depuis un document::link_from_doc ()
 if (isset($add_line_link_from_doc)) {
	?>// on recharge les liaisons
	var AppelAjax = new Ajax.Updater(
											"block_liaisons",
											"documents_edition_block_liaisons.php", 
											{
											parameters: { ref_doc: '<?php echo $document->getRef_doc()?>', lets_open: 1 },
											evalScripts:true, 
											asynchronous: false, 
											onLoading:S_loading, onException: function () {S_failure();}, 
											onComplete: function (){
																	H_loading();
																	}
											}
											);
	<?php
}
?>
<?php 
// rechargement du block entete si l'ajout des lignes a été effectué depuis un ajout de art_categ d'un inventaire
 if (isset($insert_line_from_art_categ)) {
	?>// on recharge l'entete
	var AppelAjax = new Ajax.Updater(
											"block_head",
											"documents_entete_maj.php", 
											{
											parameters: { ref_doc: '<?php echo $document->getRef_doc()?>' },
											evalScripts:true, 
											asynchronous: false, 
											onLoading:S_loading, onException: function () {S_failure();}, 
											onComplete: function (){
																	H_loading();
																	}
											}
											);
	<?php
}
?>
//on masque le chargement
H_loading();

<?php
if ($document->getQuantite_locked ()) {?>
alert_qte_locked ();
$("wait_calcul_content").style.display= "none";
<?php } ?>
</script>