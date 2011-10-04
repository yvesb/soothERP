<?php
// *************************************************************************************************************
// IMPORT FICHIER ANNUAIRE CSV correspondances avec les valeurs de colones
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$dao_csv_import_annu_ligne = new import_annuaire_csv_ligne();
$arrayLigne = array();
$listes_champs = array();
$lib_champ = "";
switch ($_REQUEST["lmb_col"]) {
	case "id_categorie":
		$lib_champ = "la catégorie du contact";
		$liste_categories = get_categories();
		foreach ($liste_categories as $categ) {
			$listes_champs[] = array("id"=>$categ->id_categorie, "lib"=>$categ->lib_categorie);
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	case "id_civilite":
		$lib_champ = "la civilité du contact";
		$liste_civilites = get_civilites();
		foreach ($liste_civilites as $civilite) {
			$listes_champs[] = array("id"=>$civilite->id_civilite, "lib"=>$civilite->lib_civ_court);
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	case "id_pays":
		$lib_champ = "le pays de l'adresse";
		$liste_pays = getPays_select_list ();
		foreach ($liste_pays as $pays) {
			$listes_champs[] = array("id"=>$pays->id_pays, "lib"=>$pays->pays);
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	
	// profil CLIENT
	case "id_client_categ":
	
		if ($CLIENT_ID_PROFIL != 0) {
			include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
			contact::load_profil_class($CLIENT_ID_PROFIL);
			$liste_categories_client = contact_client::charger_clients_categories ();
		}
		$lib_champ = "la catégorie de client";
		foreach ($liste_categories_client as $categorie_client) {
			$listes_champs[] = array("id"=>$categorie_client->id_client_categ, "lib"=>$categorie_client->lib_client_categ);
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	
	case "type":
	
		$lib_champ = "la catégorie de client";
		$listes_champs[] = array("id"=>"piste", "lib"=>"Piste");
		$listes_champs[] = array("id"=>"prospect", "lib"=>"Prospect");
		$listes_champs[] = array("id"=>"client", "lib"=>"Client");
		$listes_champs[] = array("id"=>"ancien client", "lib"=>"Ancien client");
		$listes_champs[] = array("id"=>"Compte bloqué", "lib"=>"Compte bloqué");
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	
	case "id_tarif":
		$tarifs_liste = get_full_tarifs_listes ();
		$lib_champ = "le tarif client";
		foreach ($tarifs_liste as $tarif) {
			$listes_champs[] = array("id"=>$tarif->id_tarif, "lib"=>$tarif->lib_tarif);
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	
	case "facturation":
		require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );
		$facturations = $FACTURES_PAR_MOIS;
		$lib_champ = "le tarif client";
		foreach ($facturations as $key=>$val) {
			$listes_champs[] = array("id"=>$key, "lib"=>$val);
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	
	
	//PROFIL FOURNISSEUR
	case "id_fournisseur_categ":
		if ($FOURNISSEUR_ID_PROFIL != 0) {
			include ($CONFIG_DIR."profil_".$_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getCode_profil().".config.php"); 
			contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
			$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();
		}
		$lib_champ = "la catégorie de fournisseur";
		foreach ($liste_categories_fournisseur as $categorie_fournisseur) {
			$listes_champs[] = array("id"=>$categorie_fournisseur->id_fournisseur_categ, "lib"=>$categorie_fournisseur->lib_fournisseur_categ);
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	case "id_stock_livraison":
		$stocks_liste = $_SESSION['stocks'];
		$lib_champ = "le lieu de livraison";
		foreach ($stocks_liste as $stocks_list) {
			$listes_champs[] = array("id"=>$stocks_list->getId_stock(), "lib"=>$stocks_list->getLib_stock());
		}
		$arrayLigne = $dao_csv_import_annu_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;

}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_annuaire_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_annuaire_csv_correspondances.inc.php");




?>