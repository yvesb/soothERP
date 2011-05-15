<?php
// *************************************************************************************************************
// CREATION D'UN NOUVEAU DOC À PARTIR DES LIGNES D'ARTICLES D'UN ANCIEN
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Formulaire de recherche
?>
<script type="text/javascript" language="javascript">
</script>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_newmini_moteur_doc_iframe" class="newmini_moteur_doc_iframe"></iframe>
<div id="pop_up_newmini_moteur_doc" class="newmini_moteur_doc">
<div id="recherche_documents" class="corps_mini_moteur">
<div id="recherche_documents_simple" class="menu_link_affichage">
	<a href="#" id="link_close_pop_up_newmini_moteur_doc" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
<script type="text/javascript">
Event.observe("link_close_pop_up_newmini_moteur_doc", "click",  function(evt){Event.stop(evt); close_mini_moteur_documents_new();}, false);
</script>
<div style="font-weight:bolder">Copier vers un nouveau document </div>
<form action="#" method="GET" id="form_recherche_doc_nm" name="form_recherche_doc_nm">
<table style="width:97%">
	<tr class="smallheight">
		<td style="width:2%">&nbsp;</td>
		<td style="width:35%">&nbsp;</td>
		<td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:3%">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		<span class="labelled_text">Contact:</span>
		<input type="hidden" name="ref_contact_doc_nm" id="ref_contact_doc_nm" value="" />
		<input type="hidden" name="orderby_doc_nm" id="orderby_doc_nm" value="date_doc" />
		<input type="hidden" name="orderorder_doc_nm" id="orderorder_doc_nm" value="DESC" />
		<input type="hidden" name="fonction_retour_doc_nm" id="fonction_retour_doc_nm" value="" />
		<input type="hidden" name="param_retour_doc_nm" id="param_retour_doc_nm" value="" />
		<input type=hidden name="recherche" value="1" />
		</td>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
				<tr>
					<td>
					<span style="position:relative; width:100%;" class="simule_champs" id="liste_de_contact_doc_nm">
					<span id="ref_contact_nom_doc_nm" style=" float:left; height:18px; margin-left:3px; line-height:18px;">Tous</span>
					</span>
					</td>
					<td style="width:20px">
					<a href="#" id="ref_contact_select_doc_nm" style="display:block; width:100%;">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_contact_select_img_doc_nm">
					</a>
					</td>
				</tr>
			</table>
			<script type="text/javascript">
			
	//effet de survol sur le faux select
		Event.observe('ref_contact_select_doc_nm', 'mouseover',  function(){$("ref_contact_select_img_doc_nm").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
		Event.observe('ref_contact_select_doc_nm', 'mousedown',  function(){$("ref_contact_select_img_doc_nm").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
		Event.observe('ref_contact_select_doc_nm', 'mouseup',  function(){$("ref_contact_select_img_doc_nm").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
		
		Event.observe('ref_contact_select_doc_nm', 'mouseout',  function(){$("ref_contact_select_img_doc_nm").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
		Event.observe('ref_contact_select_doc_nm', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_contact_doc_nm\', \'ref_contact_nom_doc_nm\' ")}, false);
			</script>
		</td>
		<td style="width:20px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" title="Vider le contact" id="new_empty_contact">
			<script type="text/javascript">
					Event.observe('new_empty_contact', 'click',  function(evt){
					Event.stop(evt); 
					$("ref_contact_nom_doc_nm").innerHTML = "Tous";
					$("ref_contact_doc_nm").value = "";
					}, false);
			</script>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><span class="labelled_text">Type de document:</span></td>
		<td>
			<select name="id_type_doc_doc_nm" id="id_type_doc_doc_nm" class="classinput_xsize" />
				
			<?php 
                        $doc_clients = true;
			$doc_fournisseurs = true;
			$doc_stock = true;

                        foreach ($types_liste as $type_liste) {
				if ( $type_liste->id_type_doc == 10) {continue;}
				if ( $type_liste->id_type_groupe == 1 && $doc_clients) { ?>
				<optgroup label="Documents clients"></optgroup>
				<?php $doc_clients = false;
				}
				if ( $type_liste->id_type_groupe == 2 && $doc_fournisseurs) {?>
				<optgroup label="Documents fournisseurs"></optgroup>
				<?php $doc_fournisseurs = false;
				}
				if ( $type_liste->id_type_groupe == 3 && $doc_stock) { ?>
				<optgroup label="Documents stock"></optgroup>
				<?php $doc_stock = false;
				} ?>
                                <option value="<?php echo $type_liste->id_type_doc;?>" <?php if ($type_liste->id_type_doc == $id_type_doc) { ?>selected="selected"<?php } ?>><?php echo htmlentities($type_liste->lib_type_doc);?></option>
                                <?php
			}
			?>
			</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			<input type="checkbox" name="link_doc_doc_nm" id="link_doc_doc_nm" ><span class="labelled_text">Créer une liaison avec le document source:</span>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right">
			<input name="submit" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"  style="float:left" />
		</td>
		<td>&nbsp;</td>
	</tr>
</table>
</form>
	</div>

</div>


<SCRIPT type="text/javascript">

Event.observe('form_recherche_doc_nm', "submit", function(evt){
	Event.stop(evt);
	link_it = 0;
	
	if ($("link_doc_doc_nm").checked) {	link_it = 1;}
	copie_lines_to_new_doc ($("param_retour_doc_nm").value, $("id_type_doc_doc_nm").options[$("id_type_doc_doc_nm").selectedIndex].value, $("ref_contact_doc_nm").value, link_it);
});
	

//centrage du mini_moteur de recherche d'un document
centrage_element("pop_up_newmini_moteur_doc");
centrage_element("pop_up_newmini_moteur_doc_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_newmini_moteur_doc_iframe");
centrage_element("pop_up_newmini_moteur_doc");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>