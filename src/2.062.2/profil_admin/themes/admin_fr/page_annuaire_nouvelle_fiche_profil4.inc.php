<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("liste_categories_client");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<!-- Début de l'affichage -->
<hr class="bleu_liner" />
<div class="">
	<p class="sous_titre1">Informations client </p>
	<div class="reduce_in_edit_mode">
	<table class="minimizetable">
		<tr>
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de client:</span>
			</td>
			<td>
			<select  id="id_client_categ"  name="id_client_categ" class="classinput_xsize">
				<?php
				foreach ($liste_categories_client as $liste_categorie_client){
					?>
					<option value="<?php echo $liste_categorie_client->id_client_categ;?>" <?php if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG) {echo 'selected="selected"';}?>>
					<?php echo htmlentities($liste_categorie_client->lib_client_categ); ?></option>
					<?php 
				}
				?>
			</select>
			<script type="text/javascript">
			var listing_defaut_encours = new Array();
			<?php
			foreach ($liste_categories_client as $liste_categorie_client){
			?>
			listing_defaut_encours['<?php echo $liste_categorie_client->id_client_categ;?>'] = "<?php echo $liste_categorie_client->defaut_encours;?>";
			<?php
			}
			?>
			$("encours").value = listing_defaut_encours[$("id_client_categ").value];
			
			Event.observe('id_client_categ', "change",  function(evt){
				Event.stop(evt); 
				$("encours").value = listing_defaut_encours[$("id_client_categ").value];
			}, false);
			</script>
			</td>
		</tr>
		 <tr>
			<td class="size_strict"><span class="labelled_ralonger">Etat du compte:</span>
			</td>
			<td>
			<select  id="type_client"  name="type_client" class="classinput_xsize">
				<option value="piste">Piste</option>
				<option value="prospect">Prospect</option>
				<option value="client">Client</option>
				<option value="ancien client">Ancien client</option>
				<option value="Compte bloqué">Compte bloqué</option>
			</select>
			</td>
		</tr>
		<!--  gestion des commerciaux -->
		<tr <?php global $GESTION_COMM_COMMERCIAUX;if (!$GESTION_COMM_COMMERCIAUX){ echo "style='display:none'";} ?>>
		<td class="size_strict"><span class="labelled_ralonger">Commercial:</span>
		</td>
		<td><input name="ref_commercial" id="ref_commercial" type="hidden"
			value="" />
		<table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<tr>
				<td>
					<input name="nom_commercial" id="nom_commercial" type="text" value="" class="classinput_xsize" readonly="" />
				</td>
				<td style="width: 20px">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif" style="float: right; cursor: pointer" id="ref_commercial_select_img">
				</td>
				<td style="width: 20px">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" style="cursor: pointer" id="ref_commercial_empty_s">
					<script type="text/javascript">
							Event.observe('ref_commercial_empty_s', 'click',  function(evt){Event.stop(evt);
							$("ref_commercial").value = "";
							$("nom_commercial").value = "";
							}, false);
					</script>
				</td>
			</tr>
		</table>

		<script type="text/javascript">
				//effet de survol sur le faux select
					Event.observe('ref_commercial_select_img', 'mouseover',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
					Event.observe('ref_commercial_select_img', 'mousedown',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
					Event.observe('ref_commercial_select_img', 'mouseup',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
					Event.observe('ref_commercial_select_img', 'mouseout',  function(){$("ref_commercial_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
					Event.observe('ref_commercial_select_img', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_client_set_contact", "\'ref_commercial\', \'nom_commercial\' "); preselect ('<?php echo $COMMERCIAL_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
				</script></td>
		</tr>
		
		
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse de Livraison:</span>
			</td><td>
			<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
			<iframe id="iframe_liste_choix_adresse_livraison" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_coordonnee" style="display:none"></iframe>
			<div id="choix_liste_choix_adresse_livraison"  class="choix_liste_choix_coordonnee" style="display:none"></div></div>
			<div id="adresse_livraison_choisie" class="simule_champs" style="width:99%;cursor: default;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="bt_adresse_livraison_choisie">
				<span id="lib_adresse_livraison_choisie"></span>
			</div>
			<input name="ref_adr_livraison" id="ref_adr_livraison" type="hidden" class="classinput_xsize" value="" />
							
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Adresse de Facturation:</span>
			</td><td>
			<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
			<iframe id="iframe_liste_choix_adresse_facturation" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_coordonnee" style="display:none"></iframe>
			<div id="choix_liste_choix_adresse_facturation"  class="choix_liste_choix_coordonnee" style="display:none"></div></div>
			<div id="adresse_facturation_choisie" class="simule_champs" style="width:99%;cursor: default;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="bt_adresse_facturation_choisie">
				<span id="lib_adresse_facturation_choisie"></span>
			</div>
			<input name="ref_adr_facturation" id="ref_adr_facturation" type="hidden" class="classinput_xsize" value="" />
			</td>
			</tr>
		</table>
	</div>
<!-- 	MAJ du 28/06/2010 version 2.058 modification affichage formulaire client 	-->
	<script type="text/javascript" language="javascript">
		
			//  la fonction toggle_cadenas_et_valeurs est définie dans _annuaire.js		
			Event.observe('valeurs_default_flag', 'click',function(evt){$("champs_par_defaut").toggle();}, false);
			Event.observe('libelle_valeurs_default_flag', 'click',function(evt){$("valeurs_default_flag").click();}, false);

			// si on change la catégorie client, les cadenas sont mis à ouvert
			Event.observe('id_client_categ', 'change',function(evt)
			{
				toggle_cadenas_et_valeurs('flg_facturation_periodique', 	'facturation_periodique',	'img_facturation_periodique_cadenas-ouvert',	'img_facturation_periodique_cadenas-ferme',		'listereadonly', 'ferme', 'def_facturation_periodique', 	'retour_value_facturation_periodique');
				toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 	'id_edition_mode_favori', 	'img_id_edition_mode_favori_cadenas-ouvert', 	'img_id_edition_mode_favori_cadenas-ferme', 	'listereadonly', 'ferme', 'def_id_edition_mode_favori', 	'retour_value_id_edition_mode_favori');
				toggle_cadenas_et_valeurs('flg_delai_reglement', 			'delai_reglement', 			'img_delai_reglement_cadenas-ouvert', 			'img_delai_reglement_cadenas-ferme', 			'listereadonly', 'ferme', 'def_delai_reglement', 			'retour_value_delai_reglement');
				toggle_cadenas_et_valeurs('flg_delai_reglement', 			'delai_reglement_fdm', 		'img_delai_reglement_cadenas-ouvert', 			'img_delai_reglement_cadenas-ferme', 			'listereadonly', 'ferme', 'def_delai_reglement_fdm', 		'retour_value_delai_reglement_fdm');
				toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 	'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 	'img_id_reglement_mode_favori_cadenas-ferme',	'listereadonly', 'ferme', 'def_id_reglement_mode_favori', 	'retour_value_id_reglement_mode_favori');
				toggle_cadenas_et_valeurs('flg_id_cycle_relance', 			'id_cycle_relance', 		'img_id_cycle_relance_cadenas-ouvert', 			'img_id_cycle_relance_cadenas-ferme',			'listereadonly', 'ferme', 'def_id_cycle_relance', 			'retour_value_id_cycle_relance');
				toggle_cadenas_et_valeurs('flg_encours', 					'encours', 					'img_encours_cadenas-ouvert', 					'img_encours_cadenas-ferme', 					'listereadonly', 'ferme', 'def_encours', 					'retour_value_encours');
				toggle_cadenas_et_valeurs('flg_prepaiement_type', 			'prepaiement_type',  		'img_prepaiement_type_cadenas-ouvert', 			'img_prepaiement_type_cadenas-ferme', 			'listereadonly', 'ferme', 'def_prepaiement_type', 			'retour_value_prepaiement_type');
				toggle_cadenas_et_valeurs('flg_prepaiement_type', 			'prepaiement_ratio', 		'img_prepaiement_type_cadenas-ouvert', 			'img_prepaiement_type_cadenas-ferme', 			'listereadonly', 'ferme', 'def_prepaiement_ratio', 			'retour_value_prepaiement_ratio');
				toggle_cadenas_et_valeurs('flg_id_tarif', 					'id_tarif', 				'img_id_tarif_cadenas-ouvert', 					'img_id_tarif_cadenas-ferme', 					'listereadonly', 'ferme', 'def_id_tarif', 					'retour_value_id_tarif');
				toggle_cadenas_et_valeurs('flg_app_tarifs', 				'app_tarifs', 				'img_app_tarifs_cadenas-ouvert', 				'img_app_tarifs_cadenas-ferme', 				'listereadonly', 'ferme', 'def_app_tarifs', 				'retour_value_app_tarifs');
				
			}, false);
			// facturation périodique
			Event.observe('img_facturation_periodique_cadenas-ferme',	'click', function(evt){toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ouvert',	'def_facturation_periodique', 'retour_value_facturation_periodique');}, false);
			Event.observe('img_facturation_periodique_cadenas-ouvert',	'click', function(evt){toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ferme', 	'def_facturation_periodique', 'retour_value_facturation_periodique');}, false);
			Event.observe('facturation_periodique', 					'click', function(evt){toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_facturation_periodique', 'retour_value_facturation_periodique');}, false);
			// mode édition favori
			Event.observe('img_id_edition_mode_favori_cadenas-ferme',	'click', function(evt){toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');}, false);
			Event.observe('img_id_edition_mode_favori_cadenas-ouvert',	'click', function(evt){toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');}, false);
			Event.observe('id_edition_mode_favori', 					'click', function(evt){toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');}, false);
			// délai de règlement
			Event.observe('img_delai_reglement_cadenas-ferme',			'click', function(evt){toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert',	'def_delai_reglement', 'retour_value_delai_reglement');toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');}, false);
			Event.observe('img_delai_reglement_cadenas-ouvert',			'click', function(evt){toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ferme', 	'def_delai_reglement', 'retour_value_delai_reglement');toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ferme', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');}, false);
			Event.observe('delai_reglement', 							'click', function(evt){toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_delai_reglement', 'retour_value_delai_reglement');toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');}, false);
			Event.observe('delai_reglement', 							'change',function(evt){toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_delai_reglement', 'retour_value_delai_reglement');}, false);			
			Event.observe('delai_reglement_fdm', 						'click', function(evt){toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_delai_reglement', 'retour_value_delai_reglement');toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');}, false);
			// règlement favori
			Event.observe('img_id_reglement_mode_favori_cadenas-ferme',	'click', function(evt){toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');}, false);
			Event.observe('img_id_reglement_mode_favori_cadenas-ouvert','click', function(evt){toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');}, false);
			Event.observe('id_reglement_mode_favori', 					'click', function(evt){toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');}, false);
			// cycle de relance
			Event.observe('img_id_cycle_relance_cadenas-ferme',			'click', function(evt){toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_cycle_relance', 'retour_value_id_cycle_relance');}, false);
			Event.observe('img_id_cycle_relance_cadenas-ouvert',		'click', function(evt){toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_cycle_relance', 'retour_value_id_cycle_relance');}, false);
			Event.observe('id_cycle_relance', 							'click', function(evt){toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_cycle_relance', 'retour_value_id_cycle_relance');}, false);
			// Encours
			Event.observe('img_encours_cadenas-ferme',					'click', function(evt){toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ouvert',	'def_encours', 'retour_value_encours');}, false);
			Event.observe('img_encours_cadenas-ouvert',					'click', function(evt){toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ferme', 	'def_encours', 'retour_value_encours');}, false);
			Event.observe('encours', 									'click', function(evt){toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_encours', 'retour_value_encours');}, false);
			Event.observe('encours', 									'change',function(evt){toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_encours', 'retour_value_encours');}, false);			
			// prepaiement et ratio
			Event.observe('img_prepaiement_type_cadenas-ferme',			'click', function(evt){toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert',	'def_prepaiement_type', 'retour_value_prepaiement_type');}, false);
			Event.observe('img_prepaiement_type_cadenas-ouvert',		'click', function(evt){toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_type', 'retour_value_prepaiement_type');toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');}, false);
			Event.observe('prepaiement_type', 							'click', function(evt){toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');}, false);
			Event.observe('prepaiement_type', 							'change',function(evt){toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');}, false);
			Event.observe('prepaiement_ratio', 							'click', function(evt){toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');}, false);
			Event.observe('prepaiement_ratio', 							'change',function(evt){toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');}, false);							
			// grille tarifs
			Event.observe('img_id_tarif_cadenas-ferme',					'click', function(evt){toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_tarif', 'retour_value_id_tarif');}, false);
			Event.observe('img_id_tarif_cadenas-ouvert',				'click', function(evt){toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_tarif', 'retour_value_id_tarif');}, false);
			Event.observe('id_tarif', 									'click', function(evt){toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_tarif', 'retour_value_id_tarif');}, false);
			Event.observe('retour_value_id_tarif', 						'change',function(evt)
			{
				if ($('retour_value_id_tarif').value == 0 )
					$('retour_value_id_tarif').value="";
			}, false);			
			// Afficher tarifs
			Event.observe('img_app_tarifs_cadenas-ferme',				'click', function(evt){toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ouvert',	'def_app_tarifs', 'retour_value_app_tarifs');}, false);
			Event.observe('img_app_tarifs_cadenas-ouvert',				'click', function(evt){toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ferme', 	'def_app_tarifs', 'retour_value_app_tarifs');}, false);
			Event.observe('app_tarifs', 								'click', function(evt){toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_app_tarifs', 'retour_value_app_tarifs');}, false);
			Event.observe('retour_value_app_tarifs', 					'change',function(evt){if ($('retour_value_app_tarifs').value == 0 ) $('retour_value_app_tarifs').value=""; }, false);

		</script>

		
		<p class="labelled_ralonger" style="width: 100%; margin-left: 25px;"><input
	type="checkbox" id="valeurs_default_flag" style="cursor:pointer"/><a
	id="libelle_valeurs_default_flag" style="cursor:pointer">Editer les informations avancées</a></p>
<div class="reduce_in_edit_mode" id="champs_par_defaut"
	style="display: none">

<table class="minimizetable" id="table_champs_par_defaut"
	cellpadding="0" cellspacing="4" border="0">

	<tr>
		<td class="size_strict"><img
			src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif"
			width="100%" height="1" id="imgsizeform" /></td>
		<td><img
			src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif"
			width="100%" height="1" id="imgsizeform" /></td>
	</tr>

	<tr>
		<td class="size_strict"><span class="labelled_ralonger">Facturation
		p&eacute;riodique:</span></td>
		<td class="size_strict">
			<img align="center"
				id="img_facturation_periodique_cadenas-ferme"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img align="center" id="img_facturation_periodique_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer; display: none;"></img>
			<input
				type="checkbox" id="flg_facturation_periodique" style="display: none" />
		</td>
		<td colspan="4">
			<select id="facturation_periodique" class="classinput_xsize listereadonly" style="cursor:pointer">
				<?php
				foreach ($FACTURES_PAR_MOIS as $key=>$valeur)
				{	?>
					<option value="<?php echo $key;?>" class="listereadonly"><?php echo $valeur;?></option>
					<?php
				}	?>
			</select> <!-- la valeur par défaut $FACTURES_PAR_MOIS[0] --> 
				<input
					type="text" id="def_facturation_periodique" class="classinput_xsize"
					value="
					<?php
						$def_facturation_periodique = null;
						foreach ($liste_categories_client as $liste_categorie_client)
						{
							if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG)
								$def_facturation_periodique = $liste_categorie_client->facturation_periodique;
						}					
						echo $def_facturation_periodique;
					?>
					" style="display: none">
				<!-- le champ qui sera renvoyé -->
				<input
				id="retour_value_facturation_periodique"
				name="retour_value_facturation_periodique" type="text" value=""
				class="classinput_lsize" size="4" style="width: 30%; display: none" />
		</td>
	</tr>


	<tr>
		<td class="size_strict"><span class="labelled_ralonger">Mode
		d'&eacute;dition favori:</span>
		</td>
		<td>
			<img id="img_id_edition_mode_favori_cadenas-ferme"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img id="img_id_edition_mode_favori_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer;display:none;"></img>
			<input
				type="checkbox" id="flg_id_edition_mode_favori"
				style="display: none;" />
		</td>
		<td colspan="4" style="width: 100%;"><!-- valeurs par défaut catégorie client -->
			<select id="id_edition_mode_favori"
				class="classinput_xsize listereadonly" style="cursor:pointer">
				<?php
				$def_edition_mode = null;
				foreach ($liste_categories_client as $liste_categorie_client)
				{
					if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG)
					$def_edition_mode = $liste_categorie_client->id_edition_mode_favori;
				}
				if (is_null($def_edition_mode) || ($def_edition_mode==0))
					$def_edition_mode = 0; // non défini
				?>
				<option value="0"<?php if ($def_edition_mode==0) echo ' selected="selected" ';?>>Non Défini</option>
				<?php
				$modes_edition = getEdition_modes_actifs();
				foreach ($modes_edition as $mode_edition)
				{
					echo '<option ';
					if ( $mode_edition->id_edition_mode == $def_edition_mode )
						echo 'selected="selected "';
					echo 'value="'.$mode_edition->id_edition_mode.'">'.$mode_edition->lib_edition_mode.'</option>';
				}
				?>
			</select>
			<!-- la valeur par défaut catégorie client, mode édition -->
			<input id="def_id_edition_mode_favori" type="text"
				class="classinput_xsize"
				value="<?php echo $def_edition_mode; ?>"
				style="display:none">
				<!-- le champ qui sera renvoyé -->
			<input
				name="retour_value_id_edition_mode_favori"
				id="retour_value_id_edition_mode_favori" type="text" value=""
				class="classinput_lsize" size="4" style="width: 30%;display:none" />
		</td>
	</tr>


	<tr>
		<td class="size_strict"><span class="labelled_ralonger">D&eacute;lai
		de r&egrave;glement:</span></td>
		<td>
			<img id="img_delai_reglement_cadenas-ferme"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img id="img_delai_reglement_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer; display: none;"></img>
			<input
				type="checkbox" id="flg_delai_reglement" style="display: none;">
		</td>
		<td colspan="2"><!-- valeurs par défaut catégorie client délai de règlement -->
			<input id="delai_reglement" type="text"
				value="
							<?php 
								$def_delai_reglement = "";
								$def_delai_reglement_fdm = 0;
								foreach ($liste_categories_client as $liste_categorie_client)
								{
									if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG)
										$def_delai_reglement = $liste_categorie_client->delai_reglement;
								}	
								if (is_null($def_delai_reglement))
									$def_delai_reglement = 0;
								if(strpos($liste_categorie_client->delai_reglement,"FDM") === false)
									echo $def_delai_reglement;
								else
								{
									$def_delai_reglement_fdm = 1;
									echo substr($def_delai_reglement, 0, strlen($def_delai_reglement)-3);
								}
							?>
							"
				class="classinput_lsize listereadonly" size="4" maxlength="4"
				style="width: 30px;cursor:pointer"> jour(s)</input> <!-- la valeur par défaut catégorie client, délai règlement -->
			<input id="def_delai_reglement" type="text"
				value="<?php echo $def_delai_reglement;?>" class="classinput_lsize"
				size="4" style="width:30px; display:none" /> <!-- le champ qui sera renvoyé -->
			<input id="retour_value_delai_reglement" name="retour_value_delai_reglement"
				type="text" value="" class="classinput_lsize" size="4"
				style="width:30px; display:none" /> <!-- catégorie client delai règlement fin de mois -->
			<input type="checkbox" id="delai_reglement_fdm" value="1"
				class="listereadonly"
				<?php
				if( $def_delai_reglement_fdm == 1 )
				{
					echo 'checked=true';
				}
				?> style="cursor:pointer"> Fin de mois</input> <!-- valeurs par défaut catégorie client delai règlement fin de mois -->
			<input type="checkbox" id="def_delai_reglement_fdm" value="1" style="display:none">
			<!-- le champ qui sera renvoyé -->
			<input type="checkbox"
				id="retour_value_delai_reglement_fdm"
				name="retour_value_delai_reglement_fdm" value="1" style="display:none">
		</td>
	</tr>


	<tr>
		<td class="size_strict"><span class="labelled_ralonger">R&egrave;glement
		favori par:</span></td>
		<td>
			<img id="img_id_reglement_mode_favori_cadenas-ferme"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img id="img_id_reglement_mode_favori_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer; display: none;"></img>
			<input
				type="checkbox" 
				id="flg_id_reglement_mode_favori" style="display: none;">
		</td>
		<td colspan="4" style="width: 100%;">
			<select
				id="id_reglement_mode_favori" class="classinput_xsize listereadonly" style="cursor:pointer">
				<!-- <option value="defaut"/>Par defaut ()-->
				<?php
				$id_reglement_mode_favori = "";
				$def_id_reglement_mode_favori = "";
				foreach ($liste_categories_client as $liste_categorie_client)
				{
					if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG)
						$id_reglement_mode_favori = $liste_categorie_client->id_reglement_mode_favori;
				}
				$modes_reglement = getReglements_modes();
				$premiereligneSelectionnee = 0;
				if (is_null($id_reglement_mode_favori) || ($id_reglement_mode_favori==""))
					$premiereligneSelectionnee = 1;
				?><option value="0" <?php if ($premiereligneSelectionnee==1 ) echo ' selected="selected" '; ?>>Non Défini</option><?php
				foreach ($modes_reglement as $mode_reglement)
				{
					echo '<option ';
					if ( $mode_reglement->id_reglement_mode == $id_reglement_mode_favori)
					{
						echo 'selected="selected" ';
						$def_id_reglement_mode_favori = $mode_reglement->id_reglement_mode;
					}
					echo 'value="'.$mode_reglement->id_reglement_mode.'"/>'.$mode_reglement->lib_reglement_mode;
				}
				?>
			</select> <!-- valeur par défaut catégorie client règlement favori -->
			<input id="def_id_reglement_mode_favori" type="text"
				value="<?php echo $def_id_reglement_mode_favori; ?>"
				style="display:none"> <!-- le champ qui sera renvoyé -->
			<input
				name="retour_value_id_reglement_mode_favori"
				id="retour_value_id_reglement_mode_favori" type="text" style="display:none">
		</td>
	</tr>

	<tr>
		<td class="size_strict"><span class="labelled_ralonger">Cycle de relance:</span></td>
		<td>
			<img id="img_id_cycle_relance_cadenas-ferme"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img id="img_id_cycle_relance_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer; display: none;"></img>
			<input
				type="checkbox" 
				id="flg_id_cycle_relance" style="display: none;">
		</td>
		<td colspan="4" style="width: 100%;">
			<select
				id="id_cycle_relance" class="classinput_xsize listereadonly" style="cursor:pointer">
				<option value="">Mod&egrave;le par d&eacute;faut</option>
				<?php
				$id_cycle_relance = "";
				$def_id_cycle_relance = "";
				foreach ($liste_categories_client as $liste_categorie_client)
				{
					if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG)
						$id_cycle_relance = $liste_categorie_client->id_relance_modele;
				}
				$cycles_relances = charger_factures_relances_modeles ();
				$premiereligneSelectionnee = 0;
				if (is_null($id_cycle_relance) || ($id_cycle_relance==""))
					$premiereligneSelectionnee = 1;
				foreach ($cycles_relances as $cycle_relance)
				{
					echo '<option ';
					if ( $cycle_relance->id_relance_modele == $id_cycle_relance)
					{
						echo 'selected="selected" ';
						$def_id_cycle_relance = $cycle_relance->id_relance_modele;
					}
					echo 'value="'.$cycle_relance->id_relance_modele.'"/>'.$cycle_relance->lib_relance_modele;
				}
				?>
			</select> <!-- valeur par défaut catégorie client règlement favori -->
			<input id="def_id_cycle_relance" type="text"
				value="<?php echo $def_id_cycle_relance; ?>"
				style="display:none"> <!-- le champ qui sera renvoyé -->
			<input
				name="retour_value_id_cycle_relance"
				id="retour_value_id_cycle_relance" type="text" style="display:none">
		</td>
	</tr>

	<tr>
		<td class="size_strict"><span class="labelled_ralonger">Encours:</span>
		</td>
		<td><img id="img_encours_cadenas-ferme"
			src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
			/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
		<img id="img_encours_cadenas-ouvert"
			src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
			/ width="12px" height="12px"
			style="float: center; cursor: pointer; display: none;"></img> <input
			type="checkbox" id="flg_encours"
			style="display: none;"></td>
		<td style="width: 80px;"><!-- valeurs règlement favori -->
			<input id="encours" class="classinput_lsize listereadonly" type="text"
				value="0" size="4"
				value="
							<?php 
		 						$defaut_encours = "";
								foreach ($liste_categories_client as $liste_categorie_client)
								{
									if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG)
										$defaut_encours = $liste_categorie_client->defaut_encours;
								}
								echo $defaut_encours;
							?>
							"
				style="width: 80px; cursor:pointer"> <?php echo $MONNAIE[1];?> <!-- valeur par défaut catégorie client règlement favori -->
			<input id="def_encours" type="text" class="classinput_xsize"
				value="<?php echo $defaut_encours; ?>" style="display:none"> <!-- le champ qui sera renvoyé -->
			<input name="retour_value_encours" id="retour_value_encours"
				type="text" class="classinput_xsize" style="display:none">
		</td>
	</tr>


	<tr>
		<td class="size_strict"><span class="labelled_ralonger">Pré-paiement:</span>
		</td>
		<td>
			<img id="img_prepaiement_type_cadenas-ferme"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img id="img_prepaiement_type_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer; display: none;"></img> <input
				type="checkbox" id="flg_prepaiement_type"
				style="display: none" /></td>
			<!-- valeurs par défaut -->
			<select id="prepaiement_type" class="classinput_xsize listereadonly" style="cursor:pointer">
			<?php
				$prepaiement_type = "Acompte";
				foreach ($liste_categories_client as $liste_categorie_client)
				{
					if ($liste_categorie_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG)
						$prepaiement_type = $liste_categorie_client->prepaiement_type;
				}
				if ($prepaiement_type=="Acompte")
				{
					echo '<option value="Acompte" selected="selected">Acompte</option>';
					echo '<option value="Arrhes">Arrhes</option>';
				}
				if ($prepaiement_type=="Arrhes")
				{
					echo '<option value="Acompte">Acompte</option>';
					echo '<option value="Arrhes" selected="selected">Arrhes</option>';
				}
			?>
				<!-- <option value="Acompte" selected="selected">Acompte</option>-->
				<!-- <option value="Arrhes">Arrhes</option>-->
			</select>
			<!-- valeur par défaut -->
			<input id="def_prepaiement_type" type="text" class="classinput_lsize listereadonly" value="<?php echo $prepaiement_type; ?>" style="display:none">
			<input name="retour_value_prepaiement_type"
				id="retour_value_prepaiement_type" type="text" style="display:none">
		</td>
		<td colspan="2">&nbsp; <!-- valeurs par défaut -->
			<input id="prepaiement_ratio" type="text" value="Par defaut"
				class="classinput_lsize listereadonly" style="width: 30px;cursor:pointer" /> % <!-- valeur par défaut -->
			<input id="def_prepaiement_ratio" type="text" class="classinput_xsize" style="display:none">
			<input name="retour_value_prepaiement_ratio" id="retour_value_prepaiement_ratio" type="text" class="classinput_xsize" style="display:none">
		</td>
		<input type="hidden" id="prepaiement_ratio_defaut" value="" />
	</tr>


	<tr>
		<td class="size_strict"><span class="labelled_ralonger">Grille
		tarifaire:</span></td>
		<td>
			<img id="img_id_tarif_cadenas-ferme"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img id="img_id_tarif_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer; display: none;"></img>
			<input type="checkbox" id="flg_id_tarif" style="display: none;">
		</td>
		<td colspan="4" style="width: 100%;"><!-- valeurs par défaut -->
			<select id="id_tarif" class="classinput_xsize listereadonly" style="cursor:pointer">
				<option value="0">Automatique</option>
				<?php
					foreach ($tarifs_liste as $tarif_liste)
					{
					?>
				<option value="<?php echo $tarif_liste->id_tarif; ?>"><?php echo htmlentities($tarif_liste->lib_tarif); ?>
				</option>
				<?php
				}
				?>
			</select> <!-- valeur par défaut -->
			<input id="def_id_tarif" type="text" class="classinput_xsize" value="
				<?php
					if (is_null($tarif_liste->id_tarif) || ($tarif_liste->id_tarif == 0))
						echo "0";
					else
						echo $tarif_liste->id_tarif;
				?>" style="display:none">
			<input name="retour_value_id_tarif" id="retour_value_id_tarif" type="text" value="" class="classinput_lsize" size="4" style="width: 30%;display:none">
		</td>
	</tr>


	<tr>
		<td class="size_strict"><span class="labelled_ralonger">Afficher Tarifs:</span></td>
		<td>
			<img id="img_app_tarifs_cadenas-ferme" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
				/ width="12px" height="12px" style="float: center; cursor: pointer"></img>
			<img id="img_app_tarifs_cadenas-ouvert"
				src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
				/ width="12px" height="12px"
				style="float: center; cursor: pointer; display: none;"></img>
			<input
				type="checkbox" id="flg_app_tarifs"
				style="display: none;">
		</td>
		<td colspan="4" style="width: 100%;">
			<!-- valeurs par défaut en dur Afficher tarifs -->
			<select id="app_tarifs" class="classinput_xsize listereadonly" style="cursor:pointer">
				<option value="0" selected="selected">Automatique</option>
				<option value="1">HT</option>
				<option value="2">TTC</option>
			</select>
			<!-- valeur par défaut -->
			<input id="def_app_tarifs" type="text" style="display:none" value="0">
			<!-- valeur de retour -->
			<input name="retour_value_app_tarifs" id="retour_value_app_tarifs" type="text" value="" style="display:none">
		</td>
	</tr>


</table>
</div>
<!-- bac 08/04/2010 version 2.051 -->
</div>	
				
<!-- **************************************Fin insertion *********************************************** -->


<script type="text/javascript">

//chargement en cas de changement de client_categ des champs correspondant
Event.observe("id_client_categ", "change", function(evt){ annu_client_categ_preselect ($("id_client_categ").value);}, false);	
Event.observe("prepaiement_type", "change", function(evt){
	if ($("prepaiement_type").options[0].selected){
		$("prepaiement_ratio").value = $("prepaiement_ratio_defaut").value;
	}else{
		$("prepaiement_ratio").value = '0';
		$("retour_value_prepaiement_ratio").value = '0';
	}
	}, false);	


annu_client_categ_preselect ($("id_client_categ").value);

//masque numérique pour l'encours
Event.observe("encours", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
//masque numérique pour le délai de règlement
Event.observe("delai_reglement", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
<?php
if (isset($_REQUEST["crea"])) {
	?>
	 pre_start_adresse_crea ("adresse_livraison_choisie", "bt_adresse_livraison_choisie",   "lib_adresse_livraison_choisie", "ref_adr_livraison", "choix_liste_choix_adresse_livraison", "iframe_liste_choix_adresse_livraison");
				
	 pre_start_adresse_crea ("adresse_facturation_choisie", "bt_adresse_facturation_choisie",  "lib_adresse_facturation_choisie", "ref_adr_facturation", "choix_liste_choix_adresse_facturation", "iframe_liste_choix_adresse_facturation");
	<?php 
} else { 
	?>
	 pre_start_adresse ("adresse_livraison_choisie", "bt_adresse_livraison_choisie", $("ref_contact").value, "lib_adresse_livraison_choisie", "ref_adr_livraison", "choix_liste_choix_adresse_livraison", "iframe_liste_choix_adresse_livraison", "annuaire_liste_choix_adresse.php");
				
	 pre_start_adresse ("adresse_facturation_choisie", "bt_adresse_facturation_choisie", $("ref_contact").value, "lib_adresse_facturation_choisie", "ref_adr_facturation", "choix_liste_choix_adresse_facturation", "iframe_liste_choix_adresse_facturation", "annuaire_liste_choix_adresse.php");
	<?php 
}
?>
//on masque le chargement
H_loading();
</script>
