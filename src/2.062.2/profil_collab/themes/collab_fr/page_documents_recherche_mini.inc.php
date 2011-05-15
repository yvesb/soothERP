<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Formulaire de recherche
?>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_mini_moteur_doc_iframe" class="mini_moteur_doc_iframe"></iframe>
<div id="pop_up_mini_moteur_doc" class="mini_moteur_doc">
<div id="recherche_documents" class="corps_mini_moteur">
<div id="recherche_documents_simple" class="menu_link_affichage">
	<a href="#" id="link_close_pop_up_mini_moteur_doc" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
<script type="text/javascript">
Event.observe("link_close_pop_up_mini_moteur_doc", "click",  function(evt){Event.stop(evt); close_mini_moteur_documents();}, false);
</script>
<div style="font-weight:bolder">Recherche d'un document </div>
<form action="#" method="GET" id="form_recherche_doc_m" name="form_recherche_doc_m">
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
			<input type="hidden" name="ref_contact_doc_m" id="ref_contact_doc_m" value="" />
			<input type="hidden" name="orderby_doc_m" id="orderby_doc_m" value="date_doc" />
			<input type="hidden" name="orderorder_doc_m" id="orderorder_doc_m" value="DESC" />
			<input type="hidden" name="fonction_retour_doc_m" id="fonction_retour_doc_m" value="" />
			<input type="hidden" name="param_retour_doc_m" id="param_retour_doc_m" value="" />
			<input type=hidden name="recherche" value="1" />
			</td>
			<td>
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style="position:relative; width:100%;" class="simule_champs" id="liste_de_contact_doc_m">
						<span id="ref_contact_nom_doc_m" style=" float:left; height:18px; margin-left:3px; line-height:18px;">Tous</span>
						</span>
						</td>
						<td style="width:20px">
						<a href="#" id="ref_contact_select_doc_m" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_contact_select_img_doc_m">
						</a>
						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_contact_select_doc_m', 'mouseover',  function(){$("ref_contact_select_img_doc_m").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_contact_select_doc_m', 'mousedown',  function(){$("ref_contact_select_img_doc_m").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_contact_select_doc_m', 'mouseup',  function(){$("ref_contact_select_img_doc_m").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_contact_select_doc_m', 'mouseout',  function(){$("ref_contact_select_img_doc_m").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_contact_select_doc_m', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_contact_doc_m\', \'ref_contact_nom_doc_m\' ")}, false);
				</script>
			</td>
			<td style="width:20px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" title="Vider le contact" id="empty_contact">
				<script type="text/javascript">
						Event.observe('empty_contact', 'click',  function(evt){
						Event.stop(evt); 
						$("ref_contact_nom_doc_m").innerHTML = "Tous";
						$("ref_contact_doc_m").value = "";
						}, false);
				</script>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><span class="labelled_text">Type de document:</span></td>
			<td>
				<select name="id_type_doc_doc_m" id="id_type_doc_doc_m" class="classinput_xsize" style="width:100%"/>
					<option value="">Tous</option>
				<?php 
				foreach ($types_liste as $type_liste) {
					?>
					<option value="<?php echo $type_liste->id_type_doc;?>"><?php echo htmlentities($type_liste->lib_type_doc);?></option>
					<?php 
				}
				?>
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td><span class="labelled_text">&Eacute;tat du document:</span></td>
			<td>
				<select name="id_etat_doc_doc_m" id="id_etat_doc_doc_m" class="classinput_xsize" style="width:100%">
				<option value="">Tous</option>
		
				</select>			</td>
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right">
			<input name="submit" type="image" onclick="$('page_to_show_m').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche_doc_m" id="annuler_recherche_doc_m" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
		</td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="page_to_show_m" id="page_to_show_m" value="1"/>
</form>
	</div>

</div>

<div id="resultat_documents_mini" style="overflow:auto; height:215px"></div>

<SCRIPT type="text/javascript">

Event.observe('annuler_recherche_doc_m', "click", function(evt){Event.stop(evt); reset_moteur_doc_s ('form_recherche_doc_m', 'ref_contact_doc_m', 'ref_contact_nom_doc_m', 'id_etat_doc_doc_m');	});

//lance la recherche
Event.observe('form_recherche_doc_m', "submit", function(evt){page.documents_recherche_mini();  
	Event.stop(evt);});
	
//demarage de l'observateur pour le changement detype decos afin d'afficher les états correspondant
start_doc_etat("id_type_doc_doc_m", "id_etat_doc_doc_m", "documents_etat.php?doc_type=");

//on masque le chargement
H_loading();
</SCRIPT>
</div>