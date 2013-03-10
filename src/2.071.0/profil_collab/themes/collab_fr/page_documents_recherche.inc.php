<?php

// *************************************************************************************************************
// RECHERCHE D'UN DOCUMENT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);
$listes_magasin = charger_all_magasins ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>

<script type="text/javascript" language="javascript">
array_menu_r_article	=	new Array();
array_menu_r_article[0] 	=	new Array('recherche_simple', 'menu_1');
array_menu_r_article[1] 	=	new Array('recherche_avancee', 'menu_2');
array_menu_r_article[2] 	=	new Array('recherche_perso', 'menu_3');
</script>
<div class="emarge">
<p class="titre">Recherche d'un document </p>

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div>
<ul id="menu_recherche" class="menu">
<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
<li><a href="#" id="menu_2" class="menu_unselect">Recherche avanc&eacute;e</a></li>
<li><a href="#" id="menu_3" class="menu_unselect">Recherche personnalis&eacute;e</a></li>
</ul>
</div>
<div id="recherche" class="corps_moteur">
<div id="recherche_simple" class="menu_link_affichage">
<form action="#" method="GET" id="form_recherche_s" name="form_recherche_s">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:15%">&nbsp;</td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%">&nbsp;</td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Contact:</span>
			<input type="hidden" name="ref_contact_s" id="ref_contact_s" value="<?php if (isset($_REQUEST["ref_contact_docsearch"])) { echo $_REQUEST["ref_contact_docsearch"];}?>" />
			<input type="hidden" name="orderby_s" id="orderby_s" value="date_doc" />
			<input type="hidden" name="orderorder_s" id="orderorder_s" value="DESC" />
			<input type=hidden name="recherche" value="1" />			</td>
			<td>
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style=" width:100%;" class="simule_champs" id="liste_de_contact_s">
						<span id="ref_contact_nom_s" style=" float:left; height:18px; margin-left:3px; line-height:18px;"><?php if (isset($_REQUEST["lib_contact_docsearch"])) { echo (urldecode($_REQUEST["lib_contact_docsearch"]));} else { ?>Tous<?php } ?></span>						</span>						</td>
						<td style="width:28px; text-align:right">
						<a href="#" id="ref_contact_select_s" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_contact_select_img_s">						</a>						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_contact_select_s', 'mouseover',  function(){$("ref_contact_select_img_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_contact_select_s', 'mousedown',  function(){$("ref_contact_select_img_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_contact_select_s', 'mouseup',  function(){$("ref_contact_select_img_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_contact_select_s', 'mouseout',  function(){$("ref_contact_select_img_s").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_contact_select_s', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_contact_s\', \'ref_contact_nom_s\' ")}, false);
				</script>			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_contact_empty_s">
			
			<script type="text/javascript">
			Event.observe('ref_contact_empty_s', 'click',  function(evt){Event.stop(evt); 
			$("ref_contact_s").value = "";
			$("ref_contact_nom_s").innerHTML = "Tous";
			}, false);
			</script>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td><span class="labelled_text">Type de document:</span></td>
			<td>
			<select name="id_type_doc_s" id="id_type_doc_s" class="classinput_xsize" style="width:100%"/>
			<option value="">Tous</option>
				<?php 
				foreach ($types_liste as $type_liste) {
					?>
					<option value="<?php echo $type_liste->id_type_doc;?>" <?php if (isset($_REQUEST["id_type_doc"]) && $type_liste->id_type_doc == $_REQUEST["id_type_doc"]) { echo ' selected="selected"'; }?> ><?php echo htmlentities($type_liste->lib_type_doc);?></option>
					<?php 
				}
				?>
				</select>			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td><span class="labelled_text">&Eacute;tat du document:</span></td>
			<td>
				<input type="hidden" name="list_id_etat_doc_s" id="list_id_etat_doc_s" value="" class="classinput_xsize" />	
				<select name="id_etat_doc_s" id="id_etat_doc_s" class="classinput_xsize" style="width:100%">
				<option value="">Tous</option>
				
				<option value="<?php 
				if (isset($_REQUEST["id_type_doc"])) {
				echo implode(",", get_etat_is_open(1, $_REQUEST["id_type_doc"]));
				} else {
				echo implode(",", get_etat_is_open(1));
				}
				
				?>" <?php if (isset($_REQUEST["is_open"]) && $_REQUEST["is_open"] == "1") { ?>selected="selected"<?php }?>>Documents en cours</option>
				
				<option value="<?php 
				if (isset($_REQUEST["id_type_doc"])) {
				echo implode(",", get_etat_is_open(0, $_REQUEST["id_type_doc"]));
				} else {
				echo implode(",", get_etat_is_open(0));
				}
				
				?>" 
				<?php if (isset($_REQUEST["is_open"]) && $_REQUEST["is_open"] == "0") { ?>selected="selected"<?php }?>>Documents en archive</option>
				
				</select>
				<script type="text/javascript">
					Event.observe("id_etat_doc_s", "focus", function(evt){
						if ($("id_etat_doc_s").options.length > 3) {
							new Insertion.After($("id_etat_doc_s").options[2], "<option value='' disabled ></option>");
						}
					});
				</script>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td><span class="labelled_text">R&eacute;f&eacute;rence du document:</span></td>
			<td>
				<input type="text" name="ref_doc_s" id="ref_doc_s" value="<?php if (isset($_REQUEST["acc_ref_document"])) { echo $_REQUEST["acc_ref_document"];}?>" class="classinput_xsize" />			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right">
			<input name="submit" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche_s" id="annuler_recherche_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5"></td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</form>
</div>



<div id="recherche_avancee" style="display:none;" class="menu_link_affichage">
<form action="#" method="GET" id="form_recherche_a" name="form_recherche_a">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:15%">&nbsp;</td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%">&nbsp;</td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Dans le document par :</span>
			<input type="hidden" name="ref_contact" id="ref_contact" value="<?php if (isset($_REQUEST["ref_contact_docsearch"])) { echo $_REQUEST["ref_contact_docsearch"];}?>" />
			
			<input type="hidden" name="ref_commercial" id="ref_commercial" value="" />
			<input type="hidden" name="orderby" id="orderby" value="date_doc" />
			<input type="hidden" name="orderorder" id="orderorder" value="DESC" />
			<input type=hidden name="recherche" value="1" />
			</td>
			<td>
			<span class="labelled_text">Contact:</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style=" width:100%;" class="simule_champs" id="liste_de_contact">
						<span id="ref_contact_nom" style=" float:left; height:18px; margin-left:3px; line-height:18px;"><?php if (isset($_REQUEST["lib_contact_docsearch"])) { echo (urldecode($_REQUEST["lib_contact_docsearch"]));} else { ?>Tous<?php } ?></span>						</span>						</td>
						<td style="width:28px; text-align:right">
						<a href="#" id="ref_contact_select" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_contact_select_img">						</a>						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_contact_select', 'mouseover',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_contact_select', 'mousedown',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_contact_select', 'mouseup',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_contact_select', 'mouseout',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_contact_select', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_contact\', \'ref_contact_nom\' ")}, false);
				</script>
			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_contact_empty">
			
			<script type="text/javascript">
			Event.observe('ref_contact_empty', 'click',  function(evt){Event.stop(evt); 
			$("ref_contact").value = "";
			$("ref_contact_nom").innerHTML = "Tous";
			}, false);
			</script>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			</td>
			<td>
			<span class="labelled_text">Type de document:</span>
			</td>
			<td>&nbsp;</td>
			<td>
			
			<select name="id_type_doc" id="id_type_doc" class="classinput_xsize" style="width:100%">
			<option value="">Tous</option>
				<?php 
				foreach ($types_liste as $type_liste) {
					?>
					<option value="<?php echo $type_liste->id_type_doc;?>" <?php if (isset($_REQUEST["id_type_doc"]) && $type_liste->id_type_doc == $_REQUEST["id_type_doc"]) { echo ' selected="selected"'; }?> ><?php echo htmlentities($type_liste->lib_type_doc);?></option>
					<?php 
				}
				?>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			</td>
			<td>
			<span class="labelled_text">&Eacute;tat du document:</span>
			</td>
			<td>&nbsp;</td>
			<td>
			
				<input type="hidden" name="list_id_etat_doc" id="list_id_etat_doc" value="" class="classinput_xsize" />	
				<select name="id_etat_doc" id="id_etat_doc" class="classinput_xsize" style="width:100%">
				<option value="">Tous</option>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			</td>
			
			<td>
			<span class="labelled_text">Magasin:</span>
			</td>
			<td>&nbsp;</td>
			<td>
			
			<select name="id_magasin" id="id_magasin" class="classinput_xsize" style="width:100%">
			<option value="">Tous</option>
				<?php 
				foreach ($listes_magasin as $magasin) {
					?>
					<option value="<?php echo $magasin->id_magasin;?>" name="id_magasin" <?php if (isset($_REQUEST["id_magasin"]) && $magasin->id_magasin == $_REQUEST["id_magasin"]) { echo ' selected="selected"'; }?> ><?php echo htmlentities($magasin->lib_magasin);?></option>
					<?php 
				}
				?>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			</td>
			
			
			<td>
			<span class="labelled_text">Commercial:</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style=" width:100%;" class="simule_champs" id="liste_de_commercial">
						<span id="ref_commercial_nom" style=" float:left; height:18px; margin-left:3px; line-height:18px;"><?php if (isset($_REQUEST["lib_commercial_docsearch"])) { echo (urldecode($_REQUEST["lib_commercial_docsearch"]));} else { ?>Tous<?php } ?></span>						</span>						</td>
						<td style="width:28px; text-align:right">
						<a href="#" id="ref_commercial_select" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_commercial_select_img">						</a>						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_commercial_select', 'mouseover',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_commercial_select', 'mousedown',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_commercial_select', 'mouseup',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_commercial_select', 'mouseout',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_commercial_select', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_commercial\', \'ref_commercial_nom\' "); preselect ('<?php echo $COMMERCIAL_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
				</script>
			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_commercial_empty">
			
			<script type="text/javascript">
			Event.observe('ref_commercial_empty', 'click',  function(evt){Event.stop(evt); 
			$("ref_commercial").value = "";
			$("ref_commercial_nom").innerHTML = "Tous";
			}, false);
			</script>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			</td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_ref_article" value="ref_article" <?php if (isset($_REQUEST["ref_article_docsearch"])) { ?> checked="checked" <?php }?>>
			<span id="mode_recherche_ref_article_txt">R&eacute;f&eacute;rence d'un article</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="ref_article" id="ref_article" value="<?php if (isset($_REQUEST["ref_article_docsearch"])) { echo $_REQUEST["ref_article_docsearch"];}?>" class="classinput_xsize" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_lib_article"  value="lib_article">
			<span id="mode_recherche_lib_article_txt">Libell&eacute; d'un article</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="lib_article" id="lib_article" value="" class="classinput_xsize" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr <?php if (!$GESTION_SN) {?> style="display:none"<?php } ?>>
			<td></td>
			<td></td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_numero_serie"  value="numero_serie">
			<span id="mode_recherche_numero_serie_txt">Num&eacute;ro de s&eacute;rie</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="numero_serie" id="numero_serie" value="" class="classinput_xsize" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_code_barre"  value="code_barre">
			<span id="mode_recherche_code_barre_txt">Code barre</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="code_barre" id="code_barre" value="" class="classinput_xsize" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_ref_doc"  value="ref_doc">
			<span id="mode_recherche_ref_doc_txt">R&eacute;f&eacute;rence du document</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="ref_doc" id="ref_doc" value="" class="classinput_xsize" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_code_affaire"  value="code_affaire">
			<span id="mode_recherche_code_affaire_txt">Code affaire</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="code_affaire" id="code_affaire" value="" class="classinput_xsize" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_montant"  value="montant">
			<span id="mode_recherche_montant_txt">Montant du document (TTC)</span>
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="montant" id="montant" value="" class="classinput_xsize" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
			<input type="checkbox" name="mode_recherche" id="mode_recherche_date"  value="date">
			<span id="mode_recherche_date_txt">Date du document</span>
			</td>
			<td style="text-align:right">du&nbsp;</td>
			<td>
			
			<input type="text" name="date_debut" id="date_debut" value="" class="classinput_nsize" size="12" />
			au 
			<input type="text" name="date_fin" id="date_fin" value="" class="classinput_nsize" size="12" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:right">
			<input name="submit" type="image" onClick="$('page_to_show').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche" id="annuler_recherche" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<input type="hidden" name="page_to_show" id="page_to_show" value="1"/></form>
</div>
	<div id="recherche_perso"  style="display:none;" class="menu_link_affichage">
	
			<form action="ods_gen_req.php" id="form_recherche_perso" name="form_recherche_perso" method="POST">
			<table style="width:97%">
				<tr class="smallheight">
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td></td>
					<?php
					$mode=isset($_GET["mode"]) ? $_GET["mode"] : false;
					switch ($mode){
						case "vente" : $mode="3"; break;
						case "achat" : $mode="4"; break;
						case "trm"   : $mode="5"; break;
					}
					$liste_recherche=charge_recherche_type($mode);
					if ($liste_recherche) { 
					?>
					<td><span class="labelled">Recherches :</span>
					</td>
					<td>
					<select name="id_recherche" id="id_recherche"  class="classinput_xsize">
						<?php
						foreach ($liste_recherche as $recherche) {
							?>
							<option value="<?php echo $recherche->id_recherche_perso; ?>"><?php echo $recherche->lib_recherche_perso.' - '.$recherche->desc_recherche;?></option>
							<?php 
							}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td><input name="submit_s" value="Exporter" type="submit" /></td>
					</td>
					<?php
					}else{
					echo 'Aucune recherche personnalisée';
					}
					?>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
	
	</div>

</div>

<div id="resultat"></div>

</div>

<script type="text/javascript">
Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_simple', 'menu_1', array_menu_r_article);}, false);
Event.observe("menu_2", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_avancee', 'menu_2', array_menu_r_article);}, false);
Event.observe("menu_3", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_perso', 'menu_3', array_menu_r_article );}, false);

$("ref_doc_s").focus();
//clic sur text check radio, focus field dans recherche avancée
Event.observe('mode_recherche_ref_article_txt', "click", function(evt){
	if ($("mode_recherche_ref_article").checked) { $("mode_recherche_ref_article").checked= false;} else { $("mode_recherche_ref_article").checked=true;}
});
Event.observe('mode_recherche_ref_doc_txt', "click", function(evt){
	if ($("mode_recherche_ref_doc").checked) { $("mode_recherche_ref_doc").checked= false;} else { $("mode_recherche_ref_doc").checked=true;}
});
Event.observe('mode_recherche_lib_article_txt', "click", function(evt){
	if ($("mode_recherche_lib_article").checked) { $("mode_recherche_lib_article").checked= false;} else { $("mode_recherche_lib_article").checked=true;}
});
Event.observe('mode_recherche_numero_serie_txt', "click", function(evt){
	if ($("mode_recherche_numero_serie").checked) { $("mode_recherche_numero_serie").checked= false;} else { $("mode_recherche_numero_serie").checked=true;}
});
Event.observe('mode_recherche_code_barre_txt', "click", function(evt){
	if ($("mode_recherche_code_barre").checked) { $("mode_recherche_code_barre").checked= false;} else { $("mode_recherche_code_barre").checked=true;}
});
Event.observe('mode_recherche_montant_txt', "click", function(evt){
	if ($("mode_recherche_montant").checked) { $("mode_recherche_montant").checked= false;} else { $("mode_recherche_montant").checked=true;}
});
Event.observe('mode_recherche_date_txt', "click", function(evt){
	if ($("mode_recherche_date").checked) { $("mode_recherche_date").checked= false;} else { $("mode_recherche_date").checked=true;}
});
Event.observe('mode_recherche_code_affaire_txt', "click", function(evt){
	if ($("mode_recherche_code_affaire").checked) { $("mode_recherche_code_affaire").checked= false;} else { $("mode_recherche_code_affaire").checked=true;}
});

//focus du champ correspondant au radio 
Event.observe('mode_recherche_ref_article', "click", function(evt){
	if (!$("mode_recherche_ref_article").checked) { $("mode_recherche_ref_article").checked= false;} else { $("mode_recherche_ref_article").checked=true;}
});
Event.observe('mode_recherche_ref_doc', "click", function(evt){
	if (!$("mode_recherche_ref_doc").checked) { $("mode_recherche_ref_doc").checked= false;} else { $("mode_recherche_ref_doc").checked=true;}
});
Event.observe('mode_recherche_lib_article', "click", function(evt){
	if (!$("mode_recherche_lib_article").checked) { $("mode_recherche_lib_article").checked= false;} else { $("mode_recherche_lib_article").checked=true;}
});
Event.observe('mode_recherche_numero_serie', "click", function(evt){
	if (!$("mode_recherche_numero_serie").checked) { $("mode_recherche_numero_serie").checked= false;} else { $("mode_recherche_numero_serie").checked=true;}
});
Event.observe('mode_recherche_code_barre', "click", function(evt){
	if (!$("mode_recherche_code_barre").checked) { $("mode_recherche_code_barre").checked= false;} else { $("mode_recherche_code_barre").checked=true;}
});
Event.observe('mode_recherche_montant', "click", function(evt){
	if (!$("mode_recherche_montant").checked) { $("mode_recherche_montant").checked= false;} else { $("mode_recherche_montant").checked=true;}
});
Event.observe('mode_recherche_date', "click", function(evt){
	if (!$("mode_recherche_date").checked) { $("mode_recherche_date").checked= false;} else { $("mode_recherche_date").checked=true;}
});

//focus sur champ

Event.observe('ref_article', "focus", function(evt){
	if (!$("mode_recherche_ref_article").checked) { $("mode_recherche_ref_article").checked=true;}
});

Event.observe('ref_doc', "focus", function(evt){
	if (!$("mode_recherche_ref_doc").checked) { $("mode_recherche_ref_doc").checked=true;}
});

Event.observe('lib_article', "focus", function(evt){
	if (!$("mode_recherche_lib_article").checked) { $("mode_recherche_lib_article").checked=true;}
});

Event.observe('numero_serie', "focus", function(evt){
	if (!$("mode_recherche_numero_serie").checked) { $("mode_recherche_numero_serie").checked=true;}
});

Event.observe('code_barre', "focus", function(evt){
	if (!$("mode_recherche_code_barre").checked) { $("mode_recherche_code_barre").checked=true;}
});

Event.observe('montant', "focus", function(evt){
	if (!$("mode_recherche_montant").checked) { $("mode_recherche_montant").checked=true;}
});

Event.observe('montant', "blur", function(evt){ nummask(evt, '', "X.XY");});


Event.observe('date_debut', "focus", function(evt){
	if (!$("mode_recherche_date").checked) { $("mode_recherche_date").checked=true;}
});
Event.observe('date_fin', "focus", function(evt){
	if (!$("mode_recherche_date").checked) { $("mode_recherche_date").checked=true;}
});

Event.observe('date_debut', "blur", function(evt){
	 datemask (evt);
});
Event.observe('date_fin', "blur", function(evt){
	 datemask (evt);
});

Event.observe('code_affaire', "focus", function(evt){
	if (!$("mode_recherche_code_affaire").checked) { $("mode_recherche_code_affaire").checked=true;}
});


//remise à zero du formulaire
Event.observe('annuler_recherche_s', "click", function(evt){Event.stop(evt); reset_moteur_doc_s ('form_recherche_s', 'ref_contact_s', 'ref_contact_nom_s', 'id_etat_doc_s');	});
Event.observe('annuler_recherche', "click", function(evt){Event.stop(evt); $('form_recherche_a').reset();});

//lance la recherche
Event.observe('form_recherche_s', "submit", function(evt){page.documents_recherche_simple();  
	Event.stop(evt);});
Event.observe('form_recherche_a', "submit", function(evt){page.documents_recherche_avancee();  
	Event.stop(evt);});
	
//blocage du retour chariot automatique à la saisie du code barre
function stopifcode_barre (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	Event.stop(event);
	break;   
	}
}
//observer le retour chariot lors de la saisie du code barre pour lancer la recherche
function submit_simple_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	page.documents_recherche_simple();   
	Event.stop(event);
	break;   
	}
}
function submit_avancee_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	page.documents_recherche_avancee();   
	Event.stop(event);
	break;   
	}
}
<?php if (isset($_REQUEST["ref_contact_docsearch"]) || isset($_REQUEST["acc_ref_document"])) {
	?>
	//recherche automatique des documents d'un contact depuis la fiche du contact
	page.documents_recherche_simple();   
	<?php
}
?>

<?php if (isset($_REQUEST["ref_article_docsearch"])) {
	?>
	//recherche automatique des documents d'un article depuis la fiche article
	view_menu_1('recherche_avancee', 'menu_2', array_menu_r_article);
	page.documents_recherche_avancee();   
	<?php
}
?>

<?php 
if (isset($_REQUEST["code_affaire"])) {
	$code_affaire = $_REQUEST["code_affaire"];
?>
	view_menu_1('recherche_avancee', 'menu_2', array_menu_r_article);
	$("mode_recherche_code_affaire").checked = true;
	$("code_affaire").value = "<?php echo $code_affaire; ?>";
	page.documents_recherche_avancee();
<?php
}
?>

//centrage du mini_moteur de recherche de contact

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});

//demarage de l'observateur pour le changement detype decos afin d'afficher les états correspondant

start_doc_etat("id_type_doc_s", "id_etat_doc_s", "documents_etat.php?doc_type=");
start_doc_etat("id_type_doc", "id_etat_doc", "documents_etat.php?doc_type=");

//remplissage si on fait un retour dans l'historique
if (historique_request[2][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
	//history sur recherche simple
	if (historique_request[2][1] == "simple") {
	<?php if (!isset($_REQUEST["ref_contact_docsearch"])) {?>
	if (historique_request[2]["ref_contact_s"] != "") {
	$("ref_contact_nom_s").innerHTML = historique_request[2]["ref_contact_nom_s"];
	}
	$('ref_contact_s').value = historique_request[2]["ref_contact_s"];
	<?php } ?>
	preselect (parseInt(historique_request[2]["id_type_doc_s"]), 'id_type_doc_s') ;
  	var etatUpdater = new SelectUpdater("id_etat_doc_s", "documents_etat.php?doc_type=");
	etatUpdater.run(parseInt(historique_request[2]["id_type_doc_s"]));
	preselect (parseInt(historique_request[2]["id_etat_doc_s"]), 'id_etat_doc_s') ;
	
	
	$('ref_doc_s').value = historique_request[2]["ref_doc_s"];
	$('page_to_show_s').value = historique_request[2]["page_to_show_s"];  
	$('orderby_s').value = historique_request[2]["orderby_s"]; 
	$('orderorder_s').value = historique_request[2]["orderorder_s"]; 
	
	view_menu_1('recherche_simple', 'menu_1', array_menu_r_article);
	<?php if (!isset($_REQUEST["ref_contact_docsearch"]) && !isset($_REQUEST["acc_ref_document"])) {?>
	page.documents_recherche_simple();
	<?php } ?>
	}
	//history sur recherche avancee
	if (historique_request[2][1] == "avancee") {
	
	$('mode_recherche_'+historique_request[2]["mode_recherche"]).checked = true;
	
	$(historique_request[2]["mode_recherche"]).value = historique_request[2][historique_request[2]["mode_recherche"]];
	
	
	$('page_to_show').value = historique_request[2]["page_to_show"];  
	$('orderby').value = historique_request[2]["orderby"]; 
	$('orderorder').value = historique_request[2]["orderorder"]; 
	
	view_menu_1('recherche_avancee', 'menu_2', array_menu_r_article);
	page.documents_recherche_avancee(); 
	

	}
}
//on masque le chargement
H_loading();
</SCRIPT>