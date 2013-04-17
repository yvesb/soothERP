<?php

// *************************************************************************************************************
// RECHERCHE D'UNE COMMANDE EN COURS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);

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
array_menu_r_article[0] 	=	new Array('recherche_dev', 'menu_1');
</script>
<div class="emarge">
<p class="titre">Recherche de devis clients en cours</p>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" //mini_moteur contact?>

<div id="recherche" class="corps_moteur">
<div id="recherche_cmde" class="menu_link_affichage">
<form action="#" method="GET" id="form_recherche" name="form_recherche">
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
			<td style="width:2%">&nbsp;</td>
			<td style="width:15%; font-style : italic ; font-weight:bold">Critères d'affichage</td>
			<td style="width:30%"></td>
			<td style="width:10%"></td>
			<td style="width:20%; font-style : italic; font-weight:bold">Etat du devis</td>
			<td style="width:20%"></td>
			<td style="width:3%">&nbsp;</td>
		</tr>
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
			<td>
			</td>
			<td><span class="labelled_text">Par magasin:</span>
			<input type="hidden" name="ref_client" id="ref_client" value="<?php if (isset($_REQUEST["ref_contact_docsearch"])) { echo $_REQUEST["ref_contact_docsearch"];}?>" />
			<input type="hidden" name="ref_constructeur" id="ref_constructeur" value="" />
			<input type="hidden" name="ref_fournisseur" id="ref_fournisseur" value="" />
			<input type="hidden" name="ref_commercial" id="ref_commercial" value="" />
			<input type="hidden" name="orderby" id="orderby" value="date_doc" />
			<input type="hidden" name="orderorder" id="orderorder" value="DESC" />
			<input type="hidden" name="id_type_doc" id="id_type_doc" value="1" />
			<input type="hidden" name="app_tarifs" id="app_tarifs" value="<?php echo $DEFAUT_APP_TARIFS_CLIENT;?>" />
			<input type=hidden name="recherche" value="1" />
			</td>
			<td>
			<select name="id_name_mag" id="id_name_mag" class="classinput_xsize" style="width:100%"/>
			<option value="">Tous</option>
				<?php 
				$liste_mag = charger_all_magasins ();
				foreach ($liste_mag as $mag) {
					$i = 1;?>
					<option value="<?php echo $mag->id_magasin;?>" <?php if ( $mag->id_magasin == $_SESSION['magasin']->getId_magasin ()) { echo ' selected="selected"'; } ?> ><?php echo htmlentities($mag->lib_magasin);?></option>
					<?php 
					$i++;
				}
				?>
				</select>			</td>
			<td></td>
			<?php $i = 1;?>
			<td style="width:25%">
			
				<input type="radio" name="etat" id="devcours" value="devcours" checked="checked" />
			
			<span class="labelled_text">Tous les devis en cours</span>
			</td>
			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Par commercial:</span>
			
			
			</td>
			<td>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style=" width:100%;" class="simule_champs" id="liste_de_commercial">
						<span id="ref_commercial_nom" style=" float:left; height:18px; margin-left:3px; line-height:18px;"><?php if (isset($_REQUEST["lib_commercial_docsearch"])) { echo (urldecode($_REQUEST["lib_commercial_docsearch"]));} else { ?>Tous<?php } ?></span>						</span>						</td>
						<td style="width:28px; text-align:right">
						<a href="#" id="ref_commercial_select" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_client_select_img">						</a>						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_commercial_select', 'mouseover',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_commercial_select', 'mousedown',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_commercial_select', 'mouseup',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_commercial_select', 'mouseout',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_commercial_select', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_commercial\', \'ref_commercial_nom\' "); preselect ('<?php echo $COMMERCIAL_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
			Event.observe('liste_de_commercial', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_commercial\', \'ref_commercial_nom\' "); preselect ('<?php echo $COMMERCIAL_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="width:30%">
			
				<input type="radio" name="etat" id="devaredig" value="devaredig" />
			
			<span class="labelled_text">Uniquement les devis à rédiger</span>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Par client:</span>
			
			
			</td>
			<td>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style=" width:100%;" class="simule_champs" id="liste_de_client">
						<span id="ref_client_nom" style=" float:left; height:18px; margin-left:3px; line-height:18px;"><?php if (isset($_REQUEST["lib_client_docsearch"])) { echo (urldecode($_REQUEST["lib_client_docsearch"]));} else { ?>Tous<?php } ?></span>						</span>						</td>
						<td style="width:28px; text-align:right">
						<a href="#" id="ref_client_select" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_client_select_img">						</a>						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_client_select', 'mouseover',  function(){$("ref_client_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_client_select', 'mousedown',  function(){$("ref_client_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_client_select', 'mouseup',  function(){$("ref_client_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_client_select', 'mouseout',  function(){$("ref_client_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_client_select', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_client\', \'ref_client_nom\' "); preselect ('<?php echo $CLIENT_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
			Event.observe('liste_de_client', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_client\', \'ref_client_nom\' "); preselect ('<?php echo $CLIENT_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
				</script>
			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_client_empty">
			
			<script type="text/javascript">
			Event.observe('ref_client_empty', 'click',  function(evt){Event.stop(evt); 
			$("ref_client").value = "";
			$("ref_client_nom").innerHTML = "Tous";
			}, false);
			</script>
			</td>
			<td style="width:30%">
			
				<input type="radio" name="etat" id="devrec" value="devrec" />
			
			<span class="labelled_text">Uniquement les devis récents</span>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td><span class="labelled_text">Par catégorie d'article:</span>
			<input type="hidden"value="" />
			<input type="hidden" name="id_tarif" id="id_tarif" value="<?php echo $_SESSION['magasin']->getId_tarif()?>" />
			<!--<input type="hidden" name="id_stock" id="id_stock" value="?php echo $_SESSION['magasin']->getId_stock()?>" />-->
			<input type="hidden" name="app_tarifs" id="app_tarifs" value="<?php echo $DEFAUT_APP_TARIFS_CLIENT;?>" />
			</td>
			<td>
			<select name="id_name_categ_art" id="id_name_categ_art" class="classinput_xsize" style="width:100%"/>
			<option value="">Toutes</option>
			<?php 
				$select_art_categ =	get_articles_categories();
					foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>">
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>
			</td>
			<td></td>
			
			<td style="width:20%">
				<input type="radio" name="etat" id="devperim" value="devperim" />
			<span class="labelled_text">Uniquement les devis périmés</span>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Par fabricant:</span>
			
			</td>
			<td>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style=" width:100%;" class="simule_champs" id="liste_de_constructeur">
						<span id="ref_constructeur_nom" style=" float:left; height:18px; margin-left:3px; line-height:18px;"><?php if (isset($_REQUEST["lib_constructeur_docsearch"])) { echo (urldecode($_REQUEST["lib_constructeur_docsearch"]));} else { ?>Tous<?php } ?></span>						</span>						</td>
						<td style="width:28px; text-align:right">
						<a href="#" id="ref_constructeur_select" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_constructeur_select_img">						</a>						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_constructeur_select', 'mouseover',  function(){$("ref_constructeur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_constructeur_select', 'mousedown',  function(){$("ref_constructeur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_constructeur_select', 'mouseup',  function(){$("ref_constructeur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_constructeur_select', 'mouseout',  function(){$("ref_constructeur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_constructeur_select', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_constructeur\', \'ref_constructeur_nom\' "); preselect ('<?php echo $CONSTRUCTEUR_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
			Event.observe('liste_de_constructeur', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_constructeur\', \'ref_constructeur_nom\' "); preselect ('<?php echo $CONSTRUCTEUR_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
			</script>
			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_constructeur_empty">
			
			<script type="text/javascript">
			Event.observe('ref_constructeur_empty', 'click',  function(evt){Event.stop(evt); 
			$("ref_constructeur").value = "";
			$("ref_constructeur_nom").innerHTML = "Tous";
			}, false);
			</script>
			</td>
			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Par fournisseur:</span>
			
			</td>
			<td>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
					<tr>
						<td>
						<span style=" width:100%;" class="simule_champs" id="liste_de_fournisseur">
						<span id="ref_fournisseur_nom" style=" float:left; height:18px; margin-left:3px; line-height:18px;"><?php if (isset($_REQUEST["lib_fournisseur_docsearch"])) { echo (urldecode($_REQUEST["lib_fournisseur_docsearch"]));} else { ?>Tous<?php } ?></span>						</span>						</td>
						<td style="width:28px; text-align:right">
						<a href="#" id="ref_fournisseur_select" style="display:block; width:100%;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_fournisseur_select_img">						</a>						</td>
					</tr>
				</table>
				<script type="text/javascript">
				
		//effet de survol sur le faux select
			Event.observe('ref_fournisseur_select', 'mouseover',  function(){$("ref_fournisseur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
			Event.observe('ref_fournisseur_select', 'mousedown',  function(){$("ref_fournisseur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
			Event.observe('ref_fournisseur_select', 'mouseup',  function(){$("ref_fournisseur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			
			Event.observe('ref_fournisseur_select', 'mouseout',  function(){$("ref_fournisseur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
			Event.observe('ref_fournisseur_select', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_fournisseur\', \'ref_fournisseur_nom\' "); preselect ('<?php echo $FOURNISSEUR_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
			Event.observe('liste_de_fournisseur', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_docu_set_contact", "\'ref_fournisseur\', \'ref_fournisseur_nom\' "); preselect ('<?php echo $FOURNISSEUR_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
				</script>
			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="ref_fournisseur_empty">
			
			<script type="text/javascript">
			Event.observe('ref_fournisseur_empty', 'click',  function(evt){Event.stop(evt); 
			$("ref_fournisseur").value = "";
			$("ref_fournisseur_nom").innerHTML = "Tous";
			}, false);
			</script>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		
		
		
		
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right">
			<input name="submit" type="image" onclick="$('page_to_show').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche" id="annuler_recherche" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
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
<input type="hidden" name="page_to_show" id="page_to_show" value="1"/>
</form>
</div>

<div id="resultat"></div>

</div>
<script type="text/javascript">


//remise à zero du formulaire
Event.observe('annuler_recherche', "click", function(evt){Event.stop(evt); $('form_recherche').reset();});
//lance la recherche
Event.observe('form_recherche', "submit", function(evt){page.documents_recherche_dev();  
	Event.stop(evt);});
	
//centrage du mini_moteur de recherche de contact

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});


//remplissage si on fait un retour dans l'historique
if (historique_request[8][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
	//history sur recherche simple
	if (historique_request[8][1] == "dev") {
	<?php if (!isset($_REQUEST["ref_contact_docsearch"])) {?>
	if (historique_request[8]["ref_client"] != "") {
	$("ref_client_nom").innerHTML = historique_request[8]["ref_client_nom"];
	}
	$('ref_client').value = historique_request[8]["ref_client"];
	<?php } ?>
	if (historique_request[8]["ref_constructeur"] != "") {
	$("ref_constructeur_nom").innerHTML = historique_request[8]["ref_constructeur_nom"];
	}
	$('ref_constructeur').value = historique_request[8]["ref_constructeur"];
	if (historique_request[8]["ref_fournisseur"] != "") {
	$("ref_fournisseur_nom").innerHTML = historique_request[8]["ref_fournisseur_nom"];
	}
	$('ref_fournisseur').value = historique_request[8]["ref_fournisseur"];
	
	if (historique_request[8]["ref_commercial"] != "") {
	$("ref_commercial_nom").innerHTML = historique_request[8]["ref_commercial_nom"];
	}
	$('ref_commercial').value = historique_request[8]["ref_commercial"];
	
	
	preselect ((historique_request[8]["id_name_mag"]), 'id_name_mag');
	
	
	preselect ((historique_request[8]["id_name_categ_art"]), 'id_name_categ_art');
	
	
	if (historique_request[8]["devcours"] == "1") {	$('devcours').checked = true;	}
	if (historique_request[8]["devaredig"] == "1") {	$('devaredig').checked = true;	}
	if (historique_request[8]["devrec"] == "1") {	$('devrec').checked = true;	}
	if (historique_request[8]["devperim"] == "1") {	$('devperim').checked = true;	}
	
	$('page_to_show').value = historique_request[8]["page_to_show"];  
	$('orderby').value = historique_request[8]["orderby"]; 
	$('orderorder').value = historique_request[8]["orderorder"]; 
	
	
	<?php if (!isset($_REQUEST["ref_contact_docsearch"]) && !isset($_REQUEST["acc_ref_document"])) {?>
	page.documents_recherche_dev();
	<?php } ?>
	}

}
//on masque le chargement
H_loading();
</SCRIPT>