<?php
	// bac 19/04/2010 version 2.051 modification des noms des champs de retour dans page_annuaire_nouvelle_fiche_profil4.inc.php
	/*
	$infos_profils[$id_profil]['id_client_categ'] 			=  $_REQUEST['id_client_categ'];
	$infos_profils[$id_profil]['type_client'] 				=  $_REQUEST['type_client'];
	$infos_profils[$id_profil]['id_tarif'] 					=  $_REQUEST['id_tarif'];
	$infos_profils[$id_profil]['ref_adr_livraison'] 		=  $_REQUEST['ref_adr_livraison'];
	$infos_profils[$id_profil]['ref_adr_facturation'] 		=  $_REQUEST['ref_adr_facturation'];
	$infos_profils[$id_profil]['app_tarifs'] 				=  $_REQUEST['app_tarifs'];
	$infos_profils[$id_profil]['facturation_periodique'] 	=  $_REQUEST['facturation_periodique'];
	$infos_profils[$id_profil]['encours']					=  $_REQUEST['encours'];
	$infos_profils[$id_profil]['delai_reglement'] 			=  $_REQUEST['delai_reglement'];
	$infos_profils[$id_profil]['ref_commercial'] 			=  $_REQUEST['ref_commercial'];
	*/
	$infos_profils[$id_profil]['id_client_categ'] 			=  $_REQUEST['id_client_categ'];
	$infos_profils[$id_profil]['type_client'] 				=  $_REQUEST['type_client'];
	$infos_profils[$id_profil]['id_tarif'] 					=  $_REQUEST['retour_value_id_tarif'];
	$infos_profils[$id_profil]['ref_adr_livraison'] 		=  $_REQUEST['ref_adr_livraison'];
	$infos_profils[$id_profil]['ref_adr_facturation'] 		=  $_REQUEST['ref_adr_facturation'];
	$infos_profils[$id_profil]['app_tarifs'] 				=  $_REQUEST['retour_value_app_tarifs'];
	$infos_profils[$id_profil]['facturation_periodique'] 	=  $_REQUEST['retour_value_facturation_periodique'];
	$infos_profils[$id_profil]['encours']					=  $_REQUEST['retour_value_encours'];
	$infos_profils[$id_profil]['delai_reglement'] 			=  $_REQUEST['retour_value_delai_reglement'];
	//modif
	if (isset($_REQUEST['retour_value_delai_reglement_fdm']))
		$infos_profils[$id_profil]['delai_reglement_fdm'] 	=  $_REQUEST['retour_value_delai_reglement_fdm'];
	if (isset($_REQUEST['ref_commercial']))
		$infos_profils[$id_profil]['ref_commercial'] 		=  $_REQUEST['ref_commercial'];
	$infos_profils[$id_profil]['prepaiement_type'] 			=  $_REQUEST['retour_value_prepaiement_type'];
	$infos_profils[$id_profil]['prepaiement_ratio'] 		=  $_REQUEST['retour_value_prepaiement_ratio'];
	$infos_profils[$id_profil]['id_reglement_mode_favori'] 	=  $_REQUEST['retour_value_id_reglement_mode_favori'];
	$infos_profils[$id_profil]['id_cycle_relance'] 			=  $_REQUEST['retour_value_id_cycle_relance'];
	$infos_profils[$id_profil]['id_edition_mode_favori'] 	=  $_REQUEST['retour_value_id_edition_mode_favori'];
	// bac version 2.058 .
?>