<?php
	// bac 18/05/2010 2.054.0 on recupère les informations du contact et de la catégorie de client 
	// si infos du contact client vides alors on affiche celles de la catégorie client
	//require_once $DIR.'profil_client/_contact_client.class.php';
	$ce_client = array();
	$ce_client['id_client_categ']			= $profils[$id_profil]->getId_client_categ ();
	$ce_client['id_tarif']					= $profils[$id_profil]->getId_tarif (false);
	$ce_client['facturation_periodique']	= $profils[$id_profil]->getFactures_par_mois (false);
	$ce_client['delai_reglement']			= $profils[$id_profil]->getDelai_reglement_client ();
	$ce_client['defaut_encours']			= $profils[$id_profil]->getEncours (false);
	$ce_client['prepaiement_ratio']			= $profils[$id_profil]->getPrepaiement_ratio (false);
	$ce_client['prepaiement_type']			= $profils[$id_profil]->getPrepaiement_type (false);
	$ce_client['id_reglement_mode_favori']	= $profils[$id_profil]->getId_reglement_mode_favori (false);
	$ce_client['id_cycle_relance']			= $profils[$id_profil]->getId_cycle_relance (false);
	$ce_client['id_edition_mode_favori']	= $profils[$id_profil]->getId_edition_mode_favori_client (false);
	if ($ce_client['id_edition_mode_favori']=="") $ce_client['id_edition_mode_favori']=0;	// si null on force à 0
	$ce_client['app_tarifs']				= $profils[$id_profil]->getApp_tarifs ();
	$ce_client['ref_commercial']			= $profils[$id_profil]->getRef_commercial (false);
	$ce_client['nom_commercial']			= $profils[$id_profil]->getNom_commercial (false);
	$categorie_client = array();
	foreach ($liste_categories_client as $liste_categorie_client)
	{	if ( $ce_client['id_client_categ'] == $liste_categorie_client->id_client_categ )
		{
			$categorie_client = $liste_categorie_client;
		}
	}
	if ($ce_client['id_tarif']=="") 				$ce_client['id_tarif']=$categorie_client->id_tarif;
        if ($ce_client['nom_commercial']=="") 				$ce_client['nom_commercial']=$categorie_client->nom_commercial;
	if ($ce_client['facturation_periodique']=="") 	$ce_client['facturation_periodique']=$categorie_client->facturation_periodique;
	if ($ce_client['delai_reglement']=="") 			$ce_client['delai_reglement']=$categorie_client->delai_reglement;
	if ($ce_client['defaut_encours']=="") 			$ce_client['defaut_encours']=$categorie_client->defaut_encours;
	if ($ce_client['prepaiement_ratio']=="") 		$ce_client['prepaiement_ratio']=$categorie_client->prepaiement_ratio;
	if ($ce_client['prepaiement_type']=="") 		$ce_client['prepaiement_type']=$categorie_client->prepaiement_type;
	if ($ce_client['id_reglement_mode_favori']=="") $ce_client['id_reglement_mode_favori']=$categorie_client->id_reglement_mode_favori;
	if ($ce_client['id_cycle_relance']=="") 		$ce_client['id_cycle_relance']=$categorie_client->id_relance_modele;
	if ($ce_client['id_edition_mode_favori']=="") 	$ce_client['id_edition_mode_favori']=$categorie_client->id_edition_mode_favori;
        ?>

<table style="width:100%">
<tr>
<td>
<div>
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil4_suppression" name="annu_edition_profil4_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations client </p>
<div class="reduce_in_edit_mode" style="width: 75%;">



<!-- bac zone modifications -->
<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil4" name="annu_edition_profil4" target="formFrame" style="display:none;">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de client:</span>
			</td>
			<td>
				<select  id="id_client_categ"  name="id_client_categ" class="classinput_xsize">
				<?php
				$id_client_categ = "";
				foreach ($liste_categories_client as $liste_categorie_client){
					?>
					<option value="<?php echo $liste_categorie_client->id_client_categ;?>" <?php if ($profils[$id_profil]->getId_client_categ () == $liste_categorie_client->id_client_categ) {echo 'selected="selected"'; $id_client_categ =  htmlentities($liste_categorie_client->lib_client_categ);}?>>
					<?php echo htmlentities($liste_categorie_client->lib_client_categ)?></option>
					<?php 
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Etat du compte:</span>
			</td>
			<td>
			<select  id="type_client"  name="type_client" class="classinput_xsize">
				<option value="piste" <?php $type_client = ""; if ($profils[$id_profil]->getType_client() == "Piste") {echo 'selected="selected"';$type_client = "Piste";} ?>>Piste</option>
				<option value="prospect" <?php if ($profils[$id_profil]->getType_client() == "Prospect") {echo 'selected="selected"';$type_client =  $profils[$id_profil]->getType_client();} ?>>Prospect</option>
				<option value="client" <?php if ($profils[$id_profil]->getType_client() == "Client") {echo 'selected="selected"';$type_client =  $profils[$id_profil]->getType_client();} ?>>Client</option>
				<option value="ancien client" <?php if ($profils[$id_profil]->getType_client() == "Ancien client") {echo 'selected="selected"';$type_client =  $profils[$id_profil]->getType_client();} ?>>Ancien client</option>
				<option value="Compte bloqué" <?php if ($profils[$id_profil]->getType_client() == "Compte bloqué") {echo 'selected="selected"';$type_client =  $profils[$id_profil]->getType_client();} ?>>Compte bloqué</option>
                        </select>
			</td>
		</tr>

		<tr <?php global $GESTION_COMM_COMMERCIAUX;if (!$GESTION_COMM_COMMERCIAUX){ echo "style='display:none'";} ?>>
			<td class="size_strict"><span class="labelled_ralonger">Commercial:</span>
			</td>
			<td><input name="ref_commercial" id="ref_commercial" type="hidden"
				value="<?php echo $ce_client['ref_commercial'];?>" />
			<table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
				<tr>
					<td>
						<input name="nom_commercial" id="nom_commercial" type="text" value="<?php echo $ce_client['nom_commercial'];?>" class="classinput_xsize" readonly="" />
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
				<span id="lib_adresse_livraison_choisie"><?php echo getLib_adresse($profils[$id_profil]->getRef_adr_livraison ())?></span>
			</div>
			<input name="ref_adr_livraison" id="ref_adr_livraison" type="hidden" class="classinput_xsize" value="<?php echo htmlentities($profils[$id_profil]->getRef_adr_livraison ()); ?>" />
							
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
				<span id="lib_adresse_facturation_choisie"><?php echo getLib_adresse($profils[$id_profil]->getRef_adr_facturation ())?></span>
			</div>
			<input name="ref_adr_facturation" id="ref_adr_facturation" type="hidden" class="classinput_xsize" value="<?php echo htmlentities($profils[$id_profil]->getRef_adr_facturation ()); ?>" />
			</td>
		</tr>
		</table>
		
		
		<script type="text/javascript" language="javascript">
			//  la fonction toggle_cadenas_et_valeurs est définie dans _annuaire.js		
			Event.observe('valeurs_default_flag', 'click',function(evt){$("champs_par_defaut").toggle();}, false);
			Event.observe('libelle_valeurs_default_flag', 'click',function(evt){$("valeurs_default_flag").click();}, false);

			// si on change la catégorie client, les cadenas sont mis à ouvert et on recopie les valeurs de la categorie dans les valeurs de retour
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
				toggle_cadenas_et_valeurs('flg_app_tarifs', 				'app_tarifs', 				'img_app_tarifs_cadenas-ouvert', 				'img_app_tarifs_cadenas-ferme', 				'listereadonly', 'ferme','def_app_tarifs', 					'retour_value_app_tarifs');
				annu_client_categ_modifie_preselect ($("id_client_categ").value);
			}, false);
						
			// facturation périodique
			Event.observe('img_facturation_periodique_cadenas-ferme',	'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ouvert',	'def_facturation_periodique', 'retour_value_facturation_periodique');
                            $('retour_value_facturation_periodique').value 		= $('def_facturation_periodique').value;
                        }, false);
			Event.observe('img_facturation_periodique_cadenas-ouvert',	'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ferme', 	'def_facturation_periodique', 'retour_value_facturation_periodique');
                        }, false);
			Event.observe('facturation_periodique', 					'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_facturation_periodique', 'retour_value_facturation_periodique');
                        }, false);
			// mode édition favori
			Event.observe('img_id_edition_mode_favori_cadenas-ferme',	'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');
                            $('retour_value_id_edition_mode_favori').value 		= $('def_id_edition_mode_favori').value;
                        }, false);
			Event.observe('img_id_edition_mode_favori_cadenas-ouvert',	'click',
                        function(evt){toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');
                        }, false);
			Event.observe('id_edition_mode_favori', 					'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');
                        }, false);
			// délai de règlement
			Event.observe('img_delai_reglement_cadenas-ferme',			'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert',	'def_delai_reglement', 'retour_value_delai_reglement');
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');
                            $('retour_value_delai_reglement').value 			= $('def_delai_reglement').value;
                            $('retour_value_delai_reglement_fdm').checked			= $('def_delai_reglement_fdm').checked;
                        }, false);
			Event.observe('img_delai_reglement_cadenas-ouvert',			'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ferme', 	'def_delai_reglement', 'retour_value_delai_reglement');
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ferme', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');
                        }, false);
			Event.observe('delai_reglement', 							'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_delai_reglement', 'retour_value_delai_reglement');
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');
                        }, false);
			Event.observe('delai_reglement', 							'change',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_delai_reglement', 'retour_value_delai_reglement');
                            if ($('delai_reglement').value=="") $('retour_value_delai_reglement').value='';
                        }, false);
			Event.observe('delai_reglement_fdm', 						'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_delai_reglement', 'retour_value_delai_reglement');
                            toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement_fdm', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 'def_delai_reglement_fdm', 'retour_value_delai_reglement_fdm');
                        }, false);
			// règlement favori
			Event.observe('img_id_reglement_mode_favori_cadenas-ferme',	'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');
                            $('retour_value_id_reglement_mode_favori').value 	= $('def_id_reglement_mode_favori').value;
                        }, false);
			Event.observe('img_id_reglement_mode_favori_cadenas-ouvert','click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');
                        }, false);
			Event.observe('id_reglement_mode_favori', 					'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');
                        }, false);
			// cycle de relance
			Event.observe('img_id_cycle_relance_cadenas-ferme',			'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_cycle_relance', 'retour_value_id_cycle_relance');
                        }, false);
			Event.observe('img_id_cycle_relance_cadenas-ouvert',		'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_cycle_relance', 'retour_value_id_cycle_relance');
                        }, false);
			Event.observe('id_cycle_relance', 							'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_cycle_relance', 'retour_value_id_cycle_relance');
                        }, false);
			// Encours
			Event.observe('img_encours_cadenas-ferme',					'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ouvert',	'def_encours', 'retour_value_encours');
                            $('retour_value_encours').value 					= $('def_encours').value;
                        }, false);
			Event.observe('img_encours_cadenas-ouvert',					'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ferme', 	'def_encours', 'retour_value_encours');
                        }, false);
			Event.observe('encours', 									'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_encours', 'retour_value_encours');
                        }, false);
			Event.observe('encours', 									'change',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_encours', 'retour_value_encours');
                        }, false);
			// prepaiement et ratio
			Event.observe('img_prepaiement_type_cadenas-ferme',			'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert',	'def_prepaiement_type', 'retour_value_prepaiement_type');
                            $('retour_value_prepaiement_type').value 			= $('def_prepaiement_type').value;
                            $('retour_value_prepaiement_ratio').value 			= $('def_prepaiement_ratio').value;
                        }, false);
			Event.observe('img_prepaiement_type_cadenas-ouvert',		'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_type', 'retour_value_prepaiement_type');
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');
                        }, false);
			Event.observe('prepaiement_type', 							'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');
                        }, false);
			Event.observe('prepaiement_type', 							'change',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');
                        }, false);
			Event.observe('prepaiement_ratio', 							'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');
                        }, false);
			Event.observe('prepaiement_ratio', 							'change',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');}, false);
			Event.observe("prepaiement_type", "change", function(evt){
				if ($("prepaiement_type").options[0].selected){
					$("prepaiement_ratio").value = $("prepaiement_ratio_defaut").value;
				}else{
					$("prepaiement_ratio").value = '0';
					// version 2.051
					$("retour_value_prepaiement_ratio").value = '0';
				}
				}, false);
			// grille tarifs
			Event.observe('img_id_tarif_cadenas-ferme',					'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ouvert',	'def_id_tarif', 'retour_value_id_tarif');
                            $('retour_value_id_tarif').value 					= $('def_id_tarif').value;
                        }, false);
			Event.observe('img_id_tarif_cadenas-ouvert',				'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_tarif', 'retour_value_id_tarif');
                        }, false);
			Event.observe('id_tarif', 									'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_tarif', 'retour_value_id_tarif');
                        }, false);
			Event.observe('retour_value_id_tarif', 						'change',
                        function(evt)
			{
				if ($('retour_value_id_tarif').value == 0 )
					$('retour_value_id_tarif').value="";
			}, false);			
			// Afficher tarifs
			Event.observe('img_app_tarifs_cadenas-ferme',				'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ouvert',	'def_app_tarifs', 'retour_value_app_tarifs');
                        }, false);
			Event.observe('img_app_tarifs_cadenas-ouvert',				'click', 
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ferme', 	'def_app_tarifs', 'retour_value_app_tarifs');
                            $('retour_value_app_tarifs').value = $('def_app_tarifs').value;
                        }, false);
			Event.observe('app_tarifs', 								'click',
                        function(evt){
                            toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_app_tarifs', 'retour_value_app_tarifs');
                        }, false);
			Event.observe('retour_value_app_tarifs', 					'change',
                        function(evt){
                            if ($('retour_value_app_tarifs').value == 0 ) $('retour_value_app_tarifs').value = $('def_app_tarifs').value;
                        }, false);

		</script>		
		
		<hr class="bleu_liner" />
		<p class="labelled_ralonger" style="width: 100%; margin-left: 25px;">
			<input type="checkbox" id="valeurs_default_flag" />
			<a id="libelle_valeurs_default_flag">Editer les informations avancées</a>
		</p>
		<div class="reduce_in_edit_mode" id="champs_par_defaut" style="display: none">
			
			<table class="minimizetable" id="table_champs_par_defaut"
				cellpadding="0" cellspacing="4" border="0">

				<tr>
					<td class="size_strict">
						<span class="labelled_ralonger">Facturation	p&eacute;riodique:</span>
					</td>
					<td class="size_strict">
						<img align="center"
							id="img_facturation_periodique_cadenas-ferme"
							src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
							/ width="12px" height="12px" style="float: center; cursor: pointer">
						</img>
						<img align="center" id="img_facturation_periodique_cadenas-ouvert"
							src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
							/ width="12px" height="12px"
							style="float: center; cursor: pointer; display: none;">
						</img>
						<input type="checkbox" id="flg_facturation_periodique" style="display:none;"/>
					</td>
					<td colspan="4">
						<select id="facturation_periodique" 
							<?php if ($ce_client['facturation_periodique'] == $categorie_client->facturation_periodique) { ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>
							>
							<?php
							foreach ($FACTURES_PAR_MOIS as $key=>$valeur)
							{	?>
							<option value="<?php echo $key;?>"<?php if ($profils[$id_profil]->getFactures_par_mois () == $key) {echo 'selected="selected"';} ?>>
							<?php echo $valeur;?>
							</option>
                                                                <?php if ($ce_client['facturation_periodique'] == $categorie_client->facturation_periodique) { ?>
									<script type="text/javascript" language="javascript">
										toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ferme',	'def_facturation_periodique', 'retour_value_facturation_periodique');
									</script>
								<?php } else {?>
									<script type="text/javascript" language="javascript">
										toggle_cadenas_et_valeurs('flg_facturation_periodique', 'facturation_periodique', 'img_facturation_periodique_cadenas-ouvert', 'img_facturation_periodique_cadenas-ferme', 'listereadonly', 'ouvert',	'def_facturation_periodique', 'retour_value_facturation_periodique');
									</script>
								<?php }?>

							<?php
							}	?>
						</select> <!-- la valeur par défaut $FACTURES_PAR_MOIS[0] -->
						<input type="text" id="def_facturation_periodique" class="classinput_xsize"
							value="<?php echo $categorie_client->facturation_periodique;?>" style="display:none;">
						<input id="retour_value_facturation_periodique"
							name="retour_value_facturation_periodique" type="text" value=""
							class="classinput_lsize" size="4" style="width:30%;display:none;" />
					</td>
				</tr>



				<tr>
					<td class="size_strict">
						<span class="labelled_ralonger">Mode d'&eacute;dition favori:</span>
					</td>
					<td>
						<img id="img_id_edition_mode_favori_cadenas-ferme"
							src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
							/ width="12px" height="12px" style="float: center; cursor: pointer">
						</img>
						<img id="img_id_edition_mode_favori_cadenas-ouvert"
							src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
							/ width="12px" height="12px"
							style="float: center; cursor: pointer; display: none;">
						</img>
						<input type="checkbox" id="flg_id_edition_mode_favori" style="display:none;" />
					</td>
					<td colspan="4" style="width: 100%;">
						<select id="id_edition_mode_favori" class="classinput_xsize listereadonly"
							<?php if ($ce_client['id_edition_mode_favori'] == $categorie_client->id_edition_mode_favori){ ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>
							>
							<option value="0" <?php if (($ce_client['id_edition_mode_favori'] == "") || ($ce_client['id_edition_mode_favori'] == 0)) {echo ' selected="selected"';}?>>Non Défini</option>
							<?php
								$modes_edition = getEdition_modes_actifs();
								foreach ($modes_edition as $mode_edition)
								{?>
									<option 
										<?php
										if ( $mode_edition->id_edition_mode == $ce_client['id_edition_mode_favori'] )
											echo ' selected="selected" ';
										echo ' value="'.$mode_edition->id_edition_mode.'"';
										?>><?php
										echo $mode_edition->lib_edition_mode;
										if ($ce_client['id_edition_mode_favori'] == $categorie_client->id_edition_mode_favori){ ?>
											<script type="text/javascript" language="javascript">
												toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');
											</script>
										<?php } else {?>
											<script type="text/javascript" language="javascript">
											toggle_cadenas_et_valeurs('flg_id_edition_mode_favori', 'id_edition_mode_favori', 'img_id_edition_mode_favori_cadenas-ouvert', 'img_id_edition_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_edition_mode_favori', 'retour_value_id_edition_mode_favori');
											</script>
										<?php }?>
									</option>
								<?php }?>
						</select>
						<input id="def_id_edition_mode_favori" type="text"
							class="classinput_xsize"
							value="
									<?php
										$def_edition_mode = $categorie_client->id_edition_mode_favori;
										if (is_null($def_edition_mode) || ($def_edition_mode==0))
											$def_edition_mode = 0;
										echo $def_edition_mode;
									?>
									"
							style="display:none;">
							<input name="retour_value_id_edition_mode_favori"
								id="retour_value_id_edition_mode_favori" type="text" value=""
								class="classinput_lsize" size="4" style="width:30%;display:none;" />
					</td>
				</tr>
				
				
				
				
				<tr>
					<td class="size_strict"><span class="labelled_ralonger">D&eacute;lai
					de r&egrave;glement:</span></td>
					<td>
						<img id="img_delai_reglement_cadenas-ferme"
							src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png"
							 width="12px" height="12px" style="float: center; cursor: pointer"></img>
						<img id="img_delai_reglement_cadenas-ouvert"
							src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png"
							 width="12px" height="12px"
							style="float: center; cursor: pointer; display: none;"></img>
						<input
							type="checkbox" id="flg_delai_reglement" style="display:none;">
					</td>
					<td colspan="2">
										<?php
											$val_delai_reglement = "";
											$val_delai_reglement_fdm = 0;										
											if (!is_null($ce_client['delai_reglement']))
											{
												if(strpos($ce_client['delai_reglement'],"FDM") === false)
													$val_delai_reglement = $ce_client['delai_reglement'];
												else
												{
													$val_delai_reglement = substr($ce_client['delai_reglement'], 0, strlen($ce_client['delai_reglement'])-3);
													$val_delai_reglement_fdm = 1;
												}
											}
                                                                                        ?>
						<input id="delai_reglement" type="text"
							value="<?php echo $val_delai_reglement ?>"
                                                        <?php if ($ce_client['delai_reglement'] == $categorie_client->delai_reglement) { ?>
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>

							size="4" maxlength="4"
							style="width: 30px;"/> jour(s)
							
							<?php
							if ($ce_client['delai_reglement'] == $categorie_client->delai_reglement){ ?>
								<script type="text/javascript" language="javascript">
								toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ferme', 	'def_delai_reglement', 'retour_value_delai_reglement');
								</script>
							<?php } else {?>
								<script type="text/javascript" language="javascript">
								toggle_cadenas_et_valeurs('flg_delai_reglement', 'delai_reglement', 'img_delai_reglement_cadenas-ouvert', 'img_delai_reglement_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_delai_reglement', 'retour_value_delai_reglement');
								</script>
							<?php }?>							
							
										<?php
											$def_delai_reglement = "";
											$def_delai_reglement_fdm = 0;										
											if (!is_null($categorie_client->delai_reglement))
											{
												if(strpos($categorie_client->delai_reglement,"FDM") === false)
													$def_delai_reglement = $categorie_client->delai_reglement;
												else
												{
													$def_delai_reglement = substr($categorie_client->delai_reglement, 0, strlen($categorie_client->delai_reglement)-3);
													$def_delai_reglement_fdm = 1;
												}
											}
											 ?>
						<input id="def_delai_reglement" type="text"
							value=	"<?php echo $def_delai_reglement ?>"
							class="classinput_lsize"
							size="4" style="width:30px;display:none;" />
						<input id="retour_value_delai_reglement" name="retour_value_delai_reglement"
							type="text" value="" class="classinput_lsize" size="4"
							style="width:30px;display:none;" value=""/>
						<input type="checkbox" id="delai_reglement_fdm" value="1"
							class="listereadonly"
							<?php
							if( $val_delai_reglement_fdm == 1 )
							{
								echo 'checked=true';
							}
							?>>
                                                Fin de mois
						<input type="checkbox" id="def_delai_reglement_fdm" value="1"
						 	<?php
							if( $def_delai_reglement_fdm == 1 )
							{
								echo 'checked=true';
							}
							?> style="display:none;">
						<input type="checkbox"
							id="retour_value_delai_reglement_fdm"
							name="retour_value_delai_reglement_fdm" value="1" 
							style="display:none;"
							<?php
							if( $val_delai_reglement_fdm == 1 )
							{
								echo 'checked=true';
							}
							?>							
							>
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
							id="flg_id_reglement_mode_favori" style="display:none;">
					</td>
					<td colspan="4" style="width: 100%;">
						<select
							id="id_reglement_mode_favori" 
							<?php if ($ce_client['id_reglement_mode_favori'] == $categorie_client->id_reglement_mode_favori) { ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>								
							>
							<option value="0" <?php if ( $ce_client['id_reglement_mode_favori']=="" ) echo 'selected="selected"';?>>Non Défini</option>
							<?php
								$modes_reglement = getReglements_modes();
								foreach ($modes_reglement as $mode_reglement)
								{
									echo '<option ';
									if ( $mode_reglement->id_reglement_mode == $ce_client['id_reglement_mode_favori'])
										echo 'selected="selected" ';
									echo 'value="'.$mode_reglement->id_reglement_mode.'"/>'.$mode_reglement->lib_reglement_mode;
									?><?php 								
								}
							?>
						</select>
						<?php
							if ($ce_client['id_reglement_mode_favori'] == $categorie_client->id_reglement_mode_favori){ ?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');
								</script>
							<?php } else {?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_id_reglement_mode_favori', 'id_reglement_mode_favori', 'img_id_reglement_mode_favori_cadenas-ouvert', 'img_id_reglement_mode_favori_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_reglement_mode_favori', 'retour_value_id_reglement_mode_favori');
								</script>
							<?php }?>
						<input id="def_id_reglement_mode_favori" type="text"
							value="<?php if ($categorie_client->id_reglement_mode_favori=="") echo "0"; else echo $categorie_client->id_reglement_mode_favori; ?>"
							style="display:none;">
						<input
							name="retour_value_id_reglement_mode_favori"
							id="retour_value_id_reglement_mode_favori" type="text" style="display:none;">
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
							id="flg_id_cycle_relance" style="display:none;">
					</td>
					<td colspan="4" style="width: 100%;">
						<select
							id="id_cycle_relance" 
							<?php if ($ce_client['id_cycle_relance'] == $categorie_client->id_relance_modele) { ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>								
							>
							<?php
							$cycles_relances = charger_factures_relances_modeles ();
							foreach ($cycles_relances as $cycle_relance)
							{
								echo '<option ';
								if ( $cycle_relance->id_relance_modele == $ce_client['id_cycle_relance'])
								{
									echo 'selected="selected" ';
								}
								echo 'value="'.$cycle_relance->id_relance_modele.'"/>'.$cycle_relance->lib_relance_modele;
							}
							?>
						</select>
						<?php
							if ($ce_client['id_cycle_relance'] == $categorie_client->id_relance_modele){ ?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_cycle_relance', 'retour_value_id_cycle_relance');
								</script>
							<?php } else {?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_id_cycle_relance', 'id_cycle_relance', 'img_id_cycle_relance_cadenas-ouvert', 'img_id_cycle_relance_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_cycle_relance', 'retour_value_id_cycle_relance');
								</script>
							<?php }?>
						<input id="def_id_cycle_relance" type="text"
							value="<?php if ($categorie_client->id_relance_modele=="") echo "0"; else echo $categorie_client->id_relance_modele; ?>"
							style="display:none;">
						<input
							name="retour_value_id_cycle_relance"
							id="retour_value_id_cycle_relance" type="text" style="display:none;">
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
					<td style="width: 80px;">
						<input id="encours" type="text"
							<?php if ($ce_client['defaut_encours'] == $categorie_client->defaut_encours) { ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>							
							size="4"
							value="<?php echo $ce_client['defaut_encours'];?>"
							style="width: 80px;"> <?php echo $MONNAIE[1];?>
						
						<?php
						if ($ce_client['defaut_encours'] == $categorie_client->defaut_encours){ ?>
							<script type="text/javascript" language="javascript">
							toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ferme', 	'def_encours', 'retour_value_encours');
							</script>
						<?php } else {?>
							<script type="text/javascript" language="javascript">
							toggle_cadenas_et_valeurs('flg_encours', 'encours', 'img_encours_cadenas-ouvert', 'img_encours_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_encours', 'retour_value_encours');
							</script>
						<?php }?>							
						
						
						<input id="def_encours" type="text" class="classinput_xsize"
							value="<?php echo $categorie_client->defaut_encours; ?>" style="display:none;">
						<input name="retour_value_encours" id="retour_value_encours"
							type="text" class="classinput_xsize" style="display:none;">
					</td>
				</tr>				
				
				
				
				<tr>
					<td class="size_strict"><span class="labelled_ralonger">Pré-paiement:</span>
					</td>
					<td>
						<img id="img_prepaiement_type_cadenas-ferme" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ferme.png" width="12px" height="12px" style="float: center; cursor: pointer">
						<img id="img_prepaiement_type_cadenas-ouvert" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cadenas-ouvert.png" width="12px" height="12px" style="float: center; cursor: pointer; display: none;">
						<input type="checkbox" id="flg_prepaiement_type" style="display: none" />
                                        </td>
                                        <td>
						<select id="prepaiement_type" 
						 	<?php if (($ce_client['prepaiement_type'] == $categorie_client->prepaiement_type) && ($ce_client['prepaiement_ratio'] == $categorie_client->prepaiement_ratio)){ ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>	
						>
							<?php
								$liste_pre_paiements = array("Acompte", "Arrhes");
								foreach ($liste_pre_paiements as $liste_pre_paiement)
								{
									echo '<option value="'. $liste_pre_paiement. '"';
									if ( $liste_pre_paiement == $ce_client['prepaiement_type'])
										echo ' selected="selected" ';
									echo '>'. $liste_pre_paiement . '</option>';
								}
							?>
						</select>
						<input id="def_prepaiement_type" type="text" class="classinput_lsize listereadonly"
							value="<?php echo $categorie_client->prepaiement_type; ?>" style="display:none;">
						<input name="retour_value_prepaiement_type"
							id="retour_value_prepaiement_type" type="text" style="display:none;">
					</td>
					<td colspan="2">&nbsp;
						<input id="prepaiement_ratio" type="text" value="<?php echo $ce_client['prepaiement_ratio']; ?>"
						 	<?php if (($ce_client['prepaiement_type'] == $categorie_client->prepaiement_type) && ($ce_client['prepaiement_ratio'] == $categorie_client->prepaiement_ratio)){ ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>	 
							style="width: 30px" /> %
							<?php if (($ce_client['prepaiement_type'] == $categorie_client->prepaiement_type) && ($ce_client['prepaiement_ratio'] == $categorie_client->prepaiement_ratio)){ ?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_type', 'retour_value_prepaiement_type');toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');
									toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ferme', 	'def_prepaiement_type', 'retour_value_prepaiement_type');
								</script>
							<?php } else {?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');
									toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_ratio','img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_ratio', 'retour_value_prepaiement_ratio');toggle_cadenas_et_valeurs('flg_prepaiement_type', 'prepaiement_type', 'img_prepaiement_type_cadenas-ouvert', 'img_prepaiement_type_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_prepaiement_type', 'retour_value_prepaiement_type');									
								</script>
							<?php }?>							
						<input id="def_prepaiement_ratio" type="text" class="classinput_xsize" style="display:none;" value="<?php echo $categorie_client->prepaiement_ratio; ?>">
						<input name="retour_value_prepaiement_ratio" id="retour_value_prepaiement_ratio" type="text" class="classinput_xsize" style="display:none;">
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
						<input
							type="checkbox" id="flg_id_tarif"
							style="display:none;">
					</td>
					<td colspan="4" style="width: 100%;">
						<select id="id_tarif"
							<?php $id_client_tarif = "Automatique";?>
						 	<?php if ($ce_client['id_tarif'] == $categorie_client->id_tarif){ ?> 
								class="classinput_xsize listereadonly"
							<?php } else {?>
								class="classinput_xsize"
							<?php }?>							
						>
							<option value="0" <?php if ($ce_client['id_tarif'] == ""){ echo 'selected="selected"'; }?>>Automatique</option>
							<?php
								foreach ($tarifs_liste as $tarif_liste)
								{
								?>
									<option
	 									<?php if ($ce_client['id_tarif'] == $tarif_liste->id_tarif){ ?>
											selected="selected"
										<?php }?>
										value="<?php echo $tarif_liste->id_tarif; ?>"><?php echo htmlentities($tarif_liste->lib_tarif); ?>
									</option>
								<?php }?>
						</select>
							<?php if ($ce_client['id_tarif'] == $categorie_client->id_tarif){ ?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ferme', 	'def_id_tarif', 'retour_value_id_tarif');
								</script>
							<?php } else {?>
								<script type="text/javascript" language="javascript">
									toggle_cadenas_et_valeurs('flg_id_tarif', 'id_tarif', 'img_id_tarif_cadenas-ouvert', 'img_id_tarif_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_id_tarif', 'retour_value_id_tarif');
								</script>
							<?php }?>
						<input id="def_id_tarif" type="text" class="classinput_xsize" value="
							<?php
								if (is_null($categorie_client->id_tarif) || ($categorie_client->id_tarif == 0))
									echo "0";
								else
									echo $categorie_client->id_tarif;
							?>		
						" style="display:none;">
						<input name="retour_value_id_tarif" id="retour_value_id_tarif" type="text" value="" class="classinput_lsize" size="4" style="width:30%;display:none;">
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
							style="display:none;">
					</td>
					<td colspan="4" style="width: 100%;">
					<select id="app_tarifs" name="app_tarifs"
					 	<?php if ($ce_client['app_tarifs'] == $profils[$id_profil]->getApp_Tarifs_Categorie()){ ?> 
							class="classinput_xsize listereadonly"
						<?php } else {?>
							class="classinput_xsize"
						<?php }?>>
						<option value="0" <?php if ($ce_client['app_tarifs'] == "") {echo 'selected="selected"';}?>>Automatique</option>
						<?php $liste_afficher_tarifs = array('HT', 'TTC');
							foreach ($liste_afficher_tarifs as $liste_afficher_tarif)
							{
								?><option value="<?php echo $liste_afficher_tarif;?>"
								<?php
								if ($liste_afficher_tarif== $ce_client['app_tarifs'])
									echo ' selected="selected" ';
								?>><?php echo $liste_afficher_tarif;
								?></option><?php
							}
						?>
					</select>
						<?php if ($ce_client['app_tarifs'] == $profils[$id_profil]->getApp_Tarifs_Categorie()){ ?>
						<script type="text/javascript" language="javascript">
							toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ferme', 	'def_app_tarifs', 'retour_value_app_tarifs');
						</script>
						<?php } else {?>
						<script type="text/javascript" language="javascript">
							toggle_cadenas_et_valeurs('flg_app_tarifs', 'app_tarifs', 'img_app_tarifs_cadenas-ouvert', 'img_app_tarifs_cadenas-ferme', 'listereadonly', 'ouvert', 	'def_app_tarifs', 'retour_value_app_tarifs');
						</script>
						<?php }?>
						<input id="def_app_tarifs" type="text" style="display:none;" value="<?php echo $profils[$id_profil]->getApp_Tarifs_Categorie();?>">
						<input name="retour_value_app_tarifs" id="retour_value_app_tarifs" type="text" value="" style="display:none;">
					</td>
				</tr>				
				
			</table>

		</div>
			<p style="text-align:center">
			<input type="image" name="profsubmit<?php echo $id_profil?>" id="profsubmit<?php echo $id_profil?>"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
			</p>
			
		<script type="text/javascript" language="javascript">
			// affectation des valeurs de retour au chargement
			$('retour_value_facturation_periodique').value 		= $('facturation_periodique').value;
			$('retour_value_id_edition_mode_favori').value 		= $('id_edition_mode_favori').value;
			$('retour_value_delai_reglement').value 			= $('delai_reglement').value;
			$('retour_value_delai_reglement_fdm').checked		= $('delai_reglement_fdm').checked;
			$('retour_value_id_reglement_mode_favori').value 	= $('id_reglement_mode_favori').value;
			$('retour_value_id_cycle_relance').value 			= $('id_cycle_relance').value;
			$('retour_value_encours').value 					= $('encours').value;
			$('retour_value_prepaiement_type').value 			= $('prepaiement_type').value;
			$('retour_value_prepaiement_ratio').value 			= $('prepaiement_ratio').value;
			$('retour_value_id_tarif').value 					= $('id_tarif').value;
			$('retour_value_app_tarifs').value 					= $('app_tarifs').value;
		</script>
					
	</form>

	<!-- bac zone modifications. -->
	
	
	
	
	
	
	
	
	<!-- bac zone affichage -->
	<table class="minimizetable"  id="start_visible_profil<?php echo $id_profil?>" border="0">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de client:</span>
			</td>
			<td>
			<a href="#" id="show4_id_client_categ" class="modif_select1"><?php echo  ($id_client_categ)?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Etat du compte:</span>
			</td>
			<td>
			<a href="#" id="show4_type_client" class="modif_select1"><?php echo $profils[$id_profil]->getType_client();?></a>
			</td>
		</tr>

                <tr <?php global $GESTION_COMM_COMMERCIAUX;if (!$GESTION_COMM_COMMERCIAUX){ echo "style='display:none'";} ?>>
                        <td class="size_strict"><span class="labelled_ralonger">Commercial:</span>
                        </td>
                        <td>
                        <a href="#" id="show4_nom_commercial" class="modif_select1"><?php echo $ce_client['nom_commercial']?></a>
                        </td>
                </tr>


		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse de Livraison:</span>
			</td>
			<td>
			<a href="#" id="show4_adresse_livraison_choisie" class="modif_input1"><?php echo  htmlentities( getLib_adresse($profils[$id_profil]->getRef_adr_livraison ()))?></a>
				</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse de Facturation:</span>
			</td>
			<td>
			<a href="#" id="show4_adresse_facturation_choisie" class="modif_input1"><?php echo  htmlentities( getLib_adresse($profils[$id_profil]->getRef_adr_facturation ()))?></a>
			</td>
		</tr>

		<tr>
			<td class="size_strict">
				<span class="labelled_ralonger">Facturation p&eacute;riodique:</span>
			</td>
			
			<td>
				<a href="#" id="show4_facturation_periodique" class="modif_input1">
				 <?php 
				 foreach ($FACTURES_PAR_MOIS as $key=>$valeur) {
				 	?>
					<?php if ($profils[$id_profil]->getFactures_par_mois () == $key) {echo $valeur;}?>
					<?php
					}
				?></a>
			</td>
		</tr>

		<tr>
			<td class="size_strict">
				<span class="labelled_ralonger">Mode d'&eacute;dition favori:</span>
			</td>
			<td>
				<a href="#" id="show4_id_edition_mode_favori" class="modif_input1">
				 <?php 
				 	$modes_edition_txt = "Non défini";
					$modes_edition = getEdition_modes_actifs();
					foreach ($modes_edition as $mode_edition)
					{
						if ( $mode_edition->id_edition_mode == $ce_client['id_edition_mode_favori'] )
							$modes_edition_txt = $mode_edition->lib_edition_mode;
					}
					echo $modes_edition_txt;
				?>
				</a>
			</td>
		</tr>

		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">D&eacute;lai de r&egrave;glement:</span>
			</td>
			<td>
				<a href="#" id="show4_delai_reglement" class="modif_input1"><?php if(substr($profils[$id_profil]->getDelai_reglement(),-3)=="FDM"){echo  htmlentities(substr($profils[$id_profil]->getDelai_reglement (),0,-3))." jour(s) Fin de mois"; }else{echo  htmlentities($profils[$id_profil]->getDelai_reglement ()). " jours(s)";}?></a>
			</td>
		</tr>	

		<tr>
			<td class="size_strict">
				<span class="labelled_ralonger">R&egrave;glement favori par:</span>
			</td>
			<td>
				<a href="#" id="show4_id_reglement_mode_favori" class="modif_input1">
				<?php
					$modes_reglement = getReglements_modes();
					$reglement_mode_txt = "Non défini";
					foreach ($modes_reglement as $mode_reglement)
					{
						if ( $mode_reglement->id_reglement_mode == $ce_client['id_reglement_mode_favori'])
							$reglement_mode_txt = $mode_reglement->lib_reglement_mode;
					}
					echo $reglement_mode_txt;
					?>
				</a>
			</td>
		</tr>
		
		<tr>
			<td class="size_strict">
				<span class="labelled_ralonger">Cycle de relance:</span>
			</td>
			<td>
				<a href="#" id="show4_id_cycle_relance" class="modif_input1">
				<?php
					$cycles_relances = charger_factures_relances_modeles ();
					$cycle_relance_txt = "";
					foreach ($cycles_relances as $cycle_relance)
					{
						if ($cycle_relance->id_relance_modele == $ce_client['id_cycle_relance'])
							$cycle_relance_txt = $cycle_relance->lib_relance_modele;
					}
                                        echo $cycle_relance_txt;
					?>
				</a>
			</td>
		</tr>

		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Encours:</span>
			</td>
			<td>
			<a href="#" id="show4_encours" class="modif_input1"><?php if ( $ce_client['defaut_encours']>=0 ) {echo $ce_client['defaut_encours'].' '. $MONNAIE[1];}?></a>
			</td>
		</tr>

		<tr>
			<td class="size_strict">
				<span class="labelled_ralonger">Pré-paiement:</span>
			</td>
			<td>
				<a href="#" id="show4_prepaiement_type" class="modif_input1">
					<?php
						$liste_pre_paiements_txt = "";
						$liste_pre_paiements = array("Acompte", "Arrhes");
						foreach ($liste_pre_paiements as $liste_pre_paiement)
						{
							if ( $liste_pre_paiement == $ce_client['prepaiement_type'])
								$liste_pre_paiements_txt = $liste_pre_paiement. ' ';
						}
						$liste_pre_paiements_txt .= $ce_client['prepaiement_ratio'] . '%';
						echo $liste_pre_paiements_txt;
					?>
				</a>
			</td>
		</tr>

		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Grille tarifaire:</span>
			</td>
			<td>
				<a href="#" id="show4_id_tarif" class="modif_input1">
					<?php
						$tarif_lib_txt = "Non Défini";
						foreach ($tarifs_liste as $tarif_liste)
						{
							if ($ce_client['id_tarif'] == $tarif_liste->id_tarif)
								$tarif_lib_txt = ltrim(htmlentities($tarif_liste->lib_tarif));
						}
						echo $tarif_lib_txt; 
					?>
				</a>
			</td>
		</tr>
				
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Afficher Tarifs:</span>
			</td>
			<td>
			<a href="#" id="show4_app_tarifs" class="modif_input1"><?php echo  ltrim(htmlentities($profils[$id_profil]->getApp_tarifs ()))?></a>
			</td>
		</tr>
		

		
		<tr>
			<td colspan="2" style="text-align:center">
			 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" id="modifier_profil<?php echo $id_profil?>" />
			</td>
		</tr>
	</table>
	<!-- bac zone affichage -->	
	
	
	
	
<script type="text/javascript" language="javascript">

	Event.observe("modifier_profil<?php echo $id_profil?>", "click",  function(evt){
		Event.stop(evt); 
		$('annu_edition_profil<?php echo $id_profil?>').toggle();
		$('start_visible_profil<?php echo $id_profil?>').toggle();
	}, false);
	
	Event.observe("show4_delai_reglement", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','delai_reglement');}, false);
	Event.observe("show4_encours", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','encours');}, false);
	Event.observe("show4_facturation_periodique", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','facturation_periodique');}, false);
	// bac 2.0.54.0
	
	Event.observe("show4_id_edition_mode_favori", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_edition_mode_favori');}, false);
	Event.observe("show4_id_reglement_mode_favori", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_reglement_mode_favori');}, false);
	Event.observe("show4_id_cycle_relance", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_reglement_mode_favori');}, false);
	Event.observe("show4_prepaiement_type", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','prepaiement_type');}, false);
	Event.observe("show4_nom_commercial", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','nom_commercial');}, false);
	// bac 2.0.54.0.
	
	Event.observe("show4_app_tarifs", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','app_tarifs');}, false);
	Event.observe("show4_adresse_facturation_choisie", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','adresse_facturation_choisie');}, false);
	Event.observe("show4_adresse_livraison_choisie", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','adresse_livraison_choisie');}, false);
	Event.observe("show4_id_tarif", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_tarif');}, false);
	Event.observe("show4_id_client_categ", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_client_categ');}, false);
	Event.observe("show4_type_client", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','type_client');}, false);
//	Event.observe("show4_nom_commercial", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','nom_commercial');}, false);
	
	//chargement en cas de changement de client_categ des champs correspondannt
	
	new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});
	
	//masque numérique pour l'encours
	Event.observe("encours", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
	//masque numérique pour le délai de règlement
	Event.observe("delai_reglement", "blur", function(evt){ nummask(evt, "0", "X");}, false);	
	//fonction de choix de adresses
	
	//effet de survol sur le faux select adresse_livraison
		Event.observe('adresse_livraison_choisie', 'mouseover',  function(){$("bt_adresse_livraison_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_hover.gif";}, false);
		Event.observe('adresse_livraison_choisie', 'mousedown',  function(){$("bt_adresse_livraison_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_down.gif";}, false);
		Event.observe('adresse_livraison_choisie', 'mouseup',  function(){$("bt_adresse_livraison_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
		Event.observe('adresse_livraison_choisie', 'mouseout',  function(){$("bt_adresse_livraison_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
						
	//effet de survol sur le faux select adresse_facturation
		Event.observe('adresse_facturation_choisie', 'mouseover',  function(){$("bt_adresse_facturation_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_hover.gif";}, false);
		Event.observe('adresse_facturation_choisie', 'mousedown',  function(){$("bt_adresse_facturation_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_down.gif";}, false);
		Event.observe('adresse_facturation_choisie', 'mouseup',  function(){$("bt_adresse_facturation_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
		Event.observe('adresse_facturation_choisie', 'mouseout',  function(){$("bt_adresse_facturation_choisie").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
						
	//affichage des choix
		Event.observe('adresse_livraison_choisie', 'click',  function(evt){Event.stop(evt); start_adresse ("<?php echo $contact->getRef_contact()?>", "lib_adresse_livraison_choisie", "ref_adr_livraison", "choix_liste_choix_adresse_livraison", "iframe_liste_choix_adresse_livraison", "annuaire_liste_choix_adresse.php");}, false);
						
		Event.observe('adresse_facturation_choisie', 'click',  function(evt){Event.stop(evt); start_adresse ("<?php echo $contact->getRef_contact()?>", "lib_adresse_facturation_choisie", "ref_adr_facturation", "choix_liste_choix_adresse_facturation", "iframe_liste_choix_adresse_facturation", "annuaire_liste_choix_adresse.php");}, false);
						
	//on masque le chargement
	H_loading();
	
	
	//affichage de la liste des boutons des documents client
	$("liste_document_client").show();

</script>
</div>
</div>
<br />
<?php
if ($USE_COTATIONS){
?>
<div style="padding-left:10px">
	<a href="#" id="show_cotations" class="common_link">Cotations en cours pour ce contact</a>
	<SCRIPT type="text/javascript">
	Event.observe("show_cotations", "click",  function(evt){Event.stop(evt); page.verify('annuaire_edition_view_cotations','index.php#'+escape('annuaire_edition_view_cotations.php?ref_contact=<?php echo $_REQUEST["ref_contact"];?>'),'true','_blank');}, false);
	</script>
</div>
<?php
}
?>
<br>
<p class="sous_titre2">	Documents en cours:</p>
<?php
$first_docs = 0;
if (count($client_last_DEV_en_cours )) {
	?>

Devis en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_DEV_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_DEV_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Devis en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_DEV_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=1&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_CDC_en_cours )) {
	?>

Commandes en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_CDC_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_CDC_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Commandes en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_CDC_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=2&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?><?php
$first_docs = 0;
if (count($client_last_BLC_en_cours )) {
	?>

Bons de Livraisons en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_BLC_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_BLC_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Bons de livraisons en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_BLC_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=3&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;

if (count($client_last_FAC_en_cours )) {
	?>

Factures en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_FAC_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	unset($contact_last_doc);
	?>
	<div id="show_all_FAC_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Factures en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_FAC_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=4&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<p class="sous_titre2">	Documents en archive:</p>
<?php
$first_docs = 0;
if (count($client_last_DEV_archive )) {
	?>
Devis en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_DEV_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
		unset($contact_last_doc);
	?>
	<div id="show_all_DEV_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des devis en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_DEV_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=1&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_CDC_archive )) {
	?>
Commandes en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_CDC_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
		unset($contact_last_doc);
	?>
	<div id="show_all_CDC_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Commandes en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_CDC_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=2&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_BLC_archive )) {
	?>
Bons de commandes en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_BLC_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
		unset($contact_last_doc);
	?>
	<div id="show_all_BLC_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Bons de commandes en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_BLC_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=3&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_FAC_archive )) {
	?>
Factures en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_FAC_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
		unset($contact_last_doc);
	?>
	<div id="show_all_FAC_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Factures en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_FAC_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=4&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
</td>
<td style="width:2%">
	&nbsp;
</td>
<td style="width:33%">
	<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
		<tr>
			<td style="padding:10px">
				<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
					<tr style="">
						<td class="aff_an_article">&nbsp;</td>
						<td class="aff_an_article">N</td>
						<td class="aff_an_article">N-1</td>
						<td class="aff_an_article">N-2</td>
					</tr>
					<tr>
						<td class="aff_tit_article">C.A. Client </td>
						<td class="aff_ca_article">
							<?php if (isset($client_CA[0])) {?>
							<?php echo price_format($client_CA[0])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
						</td>
						<td class="aff_ca_article">
							<?php if (isset($client_CA[1])) {?>
							<?php echo price_format($client_CA[1])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
						</td>
						<td class="aff_ca_article">
							<?php if (isset($client_CA[2])) {?>
							<?php echo price_format($client_CA[2])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	<span style="font-weight:bolder">Solde comptable: <?php echo price_format($solde_comptable)." ".$MONNAIE[1];?></span>
	<br />
	<br />
	<?php if (count($client_abo)>0){?>
	<div id="show_abo_client">
		<?php 
		include($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_contact_client_abo.inc.php");
		?>
	</div>
	<?php }?>
	<?php if (count($client_conso)>0){?>
	<div id="show_conso_client">
		<?php 
		include($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_contact_client_conso.inc.php");
		?>
	</div>
	<?php }?>
</td>
</tr>
</table>
<script type="text/javascript">
	centrage_element("edition_abonnement");
	Event.observe(window, "resize", function(evt){centrage_element("edition_abonnement");});
</script>
<script type="text/javascript">
	centrage_element("edition_consommation");
	Event.observe(window, "resize", function(evt){centrage_element("edition_consommation");});
</script>