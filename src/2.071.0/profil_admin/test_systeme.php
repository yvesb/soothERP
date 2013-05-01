<?php
/* **************************************************************************************************
************    TEST DE LA COMPATIBILITE DU SYSTEME AVEC LMB   **************************************
****************************************************************************************************/
ini_set ("session.cookie_lifetime", 86400) ;
if(!session_id()) {session_start(); }

header('Content-type: text/html; charset=iso-8859-15');
require ("_dir.inc.php");

// neregistrement des erreurs dans un tableau 
$GLOBALS['_INFOS']['test_systeme'] = array();
$GLOBALS['_INFOS']['test_systeme_non_bloquant'] = array();

if (!isset($_SESSION['TEST_SYSTEME']) || !$_SESSION['TEST_SYSTEME']) {
	// ETAPE 1: VERIFICATION DE LA CONFIGURATION DE PHP
		$retour_texte = "TEST DE VOTRE CONFIGURATION PHP<br><br>";
	
	for ($i=1; $i<=1; $i++) {
		// Vérification de la version php 
		if (version_compare(PHP_VERSION, '5.2.0') < 0) {
			$retour_texte .= "Votre version de PHP est insuffisante. <br> Actuellement: ".PHP_VERSION." / Recquis: 5.2.0<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "Votre version de PHP est insuffisante. <br> Actuellement: ".PHP_VERSION." / Recquis: 5.2.0<br>";
			break;
		} 
		$retour_texte .=  "Version de PHP suffisante: Actuellement: ".PHP_VERSION." / Requis: 5.2.0<br>";

	
		// Test de la présence de la librairie GD
		if (!@extension_loaded('gd')) {
			$retour_texte .=  "	La bibliothèque GD doit être installée.<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "La bibliothèque GD doit être installée.<br>";
			break;
		}
		$retour_texte .=   "La bibliothèque GD est installée.<br>";
	
	
		// Test de la disponibilité de la fonction fopen()
		if (!@fopen("./test_systeme.php", "r")) {
			$retour_texte .=   " La fonction PHP fopen() est désactivée sur ce serveur.<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "La fonction PHP fopen() est désactivée sur ce serveur.<br>";
			break;
		}
		$retour_texte .=   "La fonction PHP fopen() est activée.<br>";
	
	
		// Test du support XML
		if (!@function_exists('xml_parser_create')) {
			$retour_texte .=   " Le support XML est désactivée sur ce serveur.<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "Le support XML est désactivée sur ce serveur.<br>";
			break;
		}
		$retour_texte .=   "Le serveur support XML.<br>";
		
		// Test de la configuration des Magic_quote
		if (get_magic_quotes_gpc()) {
			$retour_texte .=   " L'option MAGIC_QUOTES_GPC doit être désactivé sur votre ce serveur. (non bloquant)<br>";
			$GLOBALS['_INFOS']['test_systeme_non_bloquant'][] = "L'option MAGIC_QUOTES_GPC doit être désactivé sur votre ce serveur. (non bloquant)<br>";
		}
		if (get_magic_quotes_runtime()) {
			$retour_texte .=   " L'option MAGIC_QUOTES_RUNTIME doit être désactivé sur votre ce serveur. (non bloquant)<br>";
			$GLOBALS['_INFOS']['test_systeme_non_bloquant'][] = "L'option MAGIC_QUOTES_RUNTIME doit être désactivé sur votre ce serveur. (non bloquant)<br>";
		}
		if (!get_magic_quotes_runtime() && !get_magic_quotes_gpc()) {
			$retour_texte .=   "Les options Magic_quotes_gpc et Magic_quotes_runtime sont désactivées.<br>";
		}
		
		
		
		
		
		
		
	
	// ETAPE 2: VERIFICATION DES DROITS SUR LES FICHIERS ET DOSSIERS LOCAUX
	$retour_texte .= "<br><br><hr>
	TEST DE VOS DROITS SUR LES FICHIERS ET DOSSIERS LOCAUX<br><br>";
	
		// Droits en lecture / écriture sur les fichiers et dossiers locaux
		$erreur = test_file_auth();	
		if ($erreur) {
			$retour_texte .= "".$erreur."<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "".$erreur."<br>";
			break;
		}
		$retour_texte .= "Les droits en lecture / écriture sont suffisants.<br>";
		
	
	
	
	
	
	
	
	
	
		
	// ETAPE 3: VERIFICATION DE LA CONFIGURATION DE MYSQL
	$retour_texte .= "<br><br><hr>
	TEST DE VOTRE CONFIGURATION MYSQL<br><br>";
	
		// Test la présence et la version de mysql
		if (!@extension_loaded('mysql')) {
			$retour_texte .= "MySQL n'est pas installé sur votre serveur.<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "MySQL n'est pas installé sur votre serveur.<br>";
			break;
		}
		include ($DIR."config/config_bdd.inc.php");
		mysql_connect($bdd_hote, $bdd_user, $bdd_pass);
		if (version_compare(mysql_get_server_info(), '5.0') < 0) {
			$retour_texte .= "	Votre version de MySQL est insuffisante. <br>
					Actuellement: ".mysql_get_server_info()." / Recquis: 5.0<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "Votre version de MySQL est insuffisante. <br>
					Actuellement: ".mysql_get_server_info()." / Recquis: 5.0<br>";
			break;
		}
		$retour_texte .= "MySQL est présent sur le serveur: Actuellement: ".mysql_get_server_info()." / Recquis: 5.0<br>";
	
	
		// Test la présence de la librairie PDO
		if (!method_exists('PDO', 'exec')) {
			$retour_texte .= "	La bibliothèque PDO/MySQL doit être installée.<br>";
			$GLOBALS['_INFOS']['test_systeme'][] = "".$erreur."<br>";
			break;
		}
		$retour_texte .= "La bibliothèque PDO/MySQL est installée.<br>";	
	
	
		// Test de la configuration de MySQL
		include ($DIR."config/config_bdd.inc.php");
		try {
			$bdd = new PDO("mysql:host=".$bdd_hote."; dbname=".$bdd_base."", $bdd_user, $bdd_pass, NULL);
		} catch (Exception $e) {
			$retour_texte .= "Les paramètres de connexion à la base de données sont incorrects<br />";
			$GLOBALS['_INFOS']['test_systeme'][] = "Les paramètres de connexion à la base de données sont incorrects<br />";
			break;
		}
		$retour_texte .= "Les paramètres d'accès à la base de données sont corrects.<br>";
	
	
		// Test des droits sur la base de données
		$query = "CREATE TABLE IF NOT EXISTS `table_test` (`test` FLOAT NULL) ENGINE = innodb;";
		$bdd->query($query);
		$table_test_ok = mysql_table_exists($bdd, $bdd_base, "table_test");
		if (!$table_test_ok) {
			$retour_texte .= "Vos droits sur la base de données ".$bdd_base." sont insuffisants. (Impossible de créer une table).<br />";
			$GLOBALS['_INFOS']['test_systeme'][] = "Vos droits sur la base de données ".$bdd_base." sont insuffisants. (Impossible de créer une table).<br />";
			break;
		}
		$query = "DROP TABLE IF EXISTS `table_test`;";
		$bdd->query($query);
		$table_test_deleted = mysql_table_exists($bdd, $bdd_base, "table_test");
		if ($table_test_deleted) {
			$retour_texte .= "Vos droits sur la base de données ".$bdd_base." sont insuffisants. (Impossible de supprimer une table).<br />";
			$GLOBALS['_INFOS']['test_systeme'][] = "Vos droits sur la base de données ".$bdd_base." sont insuffisants. (Impossible de supprimer une table).<br />";
			break;
		}
		$retour_texte .= "Vous avez les droits nécessaires sur la base de données.<br>";
	
	
	
		
	// ETAPE 4: Vérification du fonctionnement des emails
	$retour_texte .= "<br><br><hr>
	TEST DU FONCTIONNEMENT DES MAILS<br><br>";
	
	// Initialisation de la variable $EMAIL_DEV pour test de mail
	$CONFIG_DIR = $DIR."config/";
	require_once ($CONFIG_DIR."config_serveur.inc.php");
	global $EMAIL_DEV;

		// Test de la variable si nulle (i.e. non définie dans le fichier de config)
		if (is_null($EMAIL_DEV)) {
			$retour_texte .= "Le mail de test n'est pas paramètré, veuillez contacter un administrateur pour configurer la variable \$EMAIL_DEV";
			$retour_texte .= "La fonction Mail() n'a pu être testée.";
			$GLOBALS['_INFOS']['test_systeme_non_bloquant'][] = "La fonction Mail() n'a pu être testée. (Non bloquant)";			}
		// Si non nulle, test de l'envoi de mail à l'adresse définie
		else if (@!mail($EMAIL_DEV, 'test', "test systeme")) {
			$retour_texte .= "La fonction Mail() ne fonctionne pas. (Non bloquant mais nécessite un paramétrage)";
			$GLOBALS['_INFOS']['test_systeme_non_bloquant'][] = "La fonction Mail() ne fonctionne pas. (Non bloquant)";
		} else {
			$retour_texte .= "L'envoi d'emails semble fonctionner.";
		}
	
	
		
	// ETAPE 5: Présence des fichiers d'installation
	$retour_texte .= "<br><br><hr>
	PRESENCE DES FICHIERS D'INSTALLATION<br><br>";
	
		if (is_file($DIR."install_lmb.php")) {
			$retour_texte .= "Le fichier d'installation install_lmb.php est toujours présent. (Non bloquant)";
			$GLOBALS['_INFOS']['test_systeme_non_bloquant'][] = "Le fichier d'installation install_lmb.php est toujours présent. (Non bloquant)
	";
		}
		if (is_file($DIR."install_lmb.config.php")) {
			$retour_texte .= "Le fichier d'installation install_lmb.config.php est toujours présent. (Non bloquant)";
			$GLOBALS['_INFOS']['test_systeme_non_bloquant'][] = "Le fichier d'installation install_lmb.config.php est toujours présent. (Non bloquant)";
		}
		if (!is_file($DIR."install_lmb.config.php") && !is_file($DIR."install_lmb.php")) {
			$retour_texte .= "Les fichiers d'installation ont bien été supprimés.";
		} 
	
		
	
		
	// ETAPE 6: Présence des fichiers principaux de l'application
	$retour_texte .= "<br><br><hr>
	PRESENCE DES FICHIERS DE FONCTION ET DE CLASSE<br><br>";
	
		$tab_files = array("_adresse.class.php", "_annuaire.lib.php", "_article.class.php", "_article_categ.class.php", "_article_liaisons_types.class.php", "_article_modele.class.php", "_catalogue.lib.php", "_catalogue_client.class.php", "_fonctions.class.php", "_compta_exercices.class.php", "_compte_bancaire.class.php", "_compte_caisse.class.php", "_compte_cb.class.php", "_compte_tpe.class.php", "_contact.class.php", "_contact_profil.class.php", "_coordonnee.class.php", "_dir.inc.php", "_divers.lib.php", "_document.class.php", "_document.lib.php", "_edition_mode.lib.php", "_erreurs.lib.php", "_exceptions.lib.php", "_facture_niveau_relance.class.php", "_fonctions_generales.inc.php", "_formule_tarif.class.php", "_magasin.class.php", "_maj.class.php", "_pdf.class.php", "_pdo_etendu.class.php", "_profil.class.php", "_reference.class.php", "_reglement.class.php", "_securite.lib.php", "_session.inc.php", "_site_web.class.php", "_stock.class.php", "_stock.lib.php", "_tarif.lib.php", "_tarif_liste.class.php", "_taxe.class.php", "_theme.class.php", "_tva.class.php", "_user.class.php", "_utilisateur.class.php");
		$compteur = 0;
		foreach ($tab_files as $file) {
			if (!is_file($DIR.$file)) {
				$retour_texte .= "Le fichier suivant est absent de votre système: ".$file." <br />";
				$GLOBALS['_INFOS']['test_systeme'][] = "Le fichier suivant est absent de votre système: ".$file." <br />";
				$compteur++;
			}
		}
		if (!$compteur) {
			$retour_texte .= "Les fichiers systèmes sont tous présents.<br />";
		}
		
		$tab_dirs = array("config", "documents", "fichiers", "modeles_pdf", "modules", "profil_admin", "profil_client", "profil_collab", "profil_fournisseur");
		$compteur = 0;
		foreach ($tab_dirs as $dir) {
			if (!is_dir($DIR.$dir)) {
				$retour_texte .= "Le dossier suivant est absent de votre système: ".$dir." <br />";
				$GLOBALS['_INFOS']['test_systeme'][] = "Le dossier suivant est absent de votre système: ".$dir." <br />";
				$compteur++;
			}
		}
		if (!$compteur) {
			$retour_texte .= "Les dossiers systèmes sont tous présents.<br />";
		}
	
	// ETAPE 7: Présence des tables principales de l'application
	$retour_texte .= "<br><br><hr>
	PRESENCE DES TABLES DE LA BASE DE DONNEES<br><br>";
	
		$tab_sql = array("adresses","annuaire","annuaire_categories","annuaire_profils","annu_admin","annu_client","annu_collab","annu_constructeur","annu_fournisseur","articles","articles_caracs","articles_codes_barres","articles_composants","articles_formules_tarifs","articles_images","articles_liaisons","articles_modele_materiel","articles_modele_service","articles_modele_service_abo","articles_paa_archive","articles_pa_archive","articles_pv_archive","articles_ref_fournisseur","articles_stocks_alertes","articles_tarifs","articles_tarifs_maj","articles_taxes","articles_variantes","art_categs","art_categs_caracs","art_categs_caracs_groupes","art_categs_formules_tarifs","art_categs_taxes","art_liaisons_types","cartes_bancaires_types","catalogues_clients","catalogues_clients_dirs","civilites","civilites_categories","clients_categories","comm_events","comm_events_types","compta_docs","compta_exercices","compta_exercices_reports","compta_journaux","comptes_bancaires","comptes_bancaires_moves","comptes_bancaires_releves","comptes_caisses","comptes_caisses_ar_fonds","comptes_caisses_contenu","comptes_caisses_controles","comptes_caisses_controles_montants","comptes_caisses_depots","comptes_caisses_depots_montants","comptes_caisses_moves","comptes_caisses_retraits","comptes_caisses_retraits_montants","comptes_caisses_transferts","comptes_caisses_transferts_montants","comptes_cbs","comptes_moves_types","comptes_tpes","comptes_tpv","comptes_tp_contenu","comptes_tp_telecollecte","comptes_tp_telecollecte_montant","coordonnees","docs_lines","docs_lines_sn","documents","documents_editions","documents_etats","documents_events","documents_events_types","documents_liaisons","documents_types","documents_types_groupes","doc_blc","doc_blf","doc_cdc","doc_cdf","doc_def","doc_des","doc_des_sn","doc_dev","doc_fab","doc_fab_sn","doc_fac","doc_faf","documents_filigranes","doc_inv","doc_lines_blc","doc_lines_blf","doc_lines_cdc","doc_lines_cdf","doc_lines_def","doc_lines_faf","doc_modeles_pdf","doc_pac","doc_trm","editions_modes","factures_relances_niveaux","fonctions","fonctions_permissions","fournisseurs_categories","images_articles","import_export_types","import_serveurs","import_types","langages","magasins","pays","pdf_modeles","pdf_types","permissions","plan_comptable","profils","references_tags","reglements","reglements_docs","reglements_modes","regmt_avc","regmt_avf","regmt_e_cb","regmt_e_chq","regmt_e_esp","regmt_e_lcr","regmt_e_prb","regmt_e_tpv","regmt_e_vir","regmt_s_cb","regmt_s_chq","regmt_s_esp","regmt_s_lcr","regmt_s_prb","regmt_s_vir","sites_web","site_web_referencement","stocks","stocks_articles","stocks_articles_sn","stocks_moves","taches","taches_admin","taches_collabs","taches_collabs_fonctions","tarifs_listes","taxes","interfaces_themes","tvas","users","users_creations_invitations","users_logs","users_logs_errors","users_permissions","users_themes","users_web_link","villes");
		$compteur = 0;
		foreach ($tab_sql as $table) {
			if (!mysql_table_exists($bdd, $bdd_base, $table)) {
				$retour_texte .= "La table suivante est absente de votre base de données: ".$table." <br />";
				$GLOBALS['_INFOS']['test_systeme'][] = "La table suivante est absente de votre base de données: ".$table." <br />";
				$compteur++;
			}
		}
		if (!$compteur) {
			$retour_texte .= "Toutes les tables sont présentes.<br />";
		}
		
		
		$tab_sql_count = array(array("annuaire_categories","5"), array("art_liaisons_types","4"), array("cartes_bancaires_types","3"), array("civilites","15"), array("civilites_categories","19"), array("comptes_moves_types","6"), array("documents_etats","55"), array("documents_events_types","6"), array("documents_types","13"), array("editions_modes","3"), array("factures_relances_niveaux","3"), array("import_export_types","3"), array("langages","5"), array("pays","239"), array("pdf_types","2"), array("permissions","3"), array("profils","5"), array("references_tags","28"), array("reglements_modes","16"), array("interfaces_themes","4"), array("villes","56031"));
		$compteur = 0;
		foreach ($tab_sql_count as $table_count) {
			if (!mysql_table_count_line($bdd, $table_count[0], $table_count[1])) {
				$retour_texte .= "Des données sont manquantes dans la table suivante: ".$table_count[0]." <br />";
				$GLOBALS['_INFOS']['test_systeme'][] = "Des données sont manquantes dans la table suivante: ".$table_count[0]." <br />";
				$compteur++;
			}
		}
		if (!$compteur) {
			$retour_texte .= "Toutes les tables possèdent les informations minimales.<br />";
		}
		
	}
	
}
// Fonctions diverses

// Test de la presence d'une table
function mysql_table_exists($bdd, $base, $table){
	$query_test = "SHOW TABLES FROM `".$base."` LIKE '".$table."' ";
	$result = $bdd->query($query_test);
	if($tmp = $result->fetchObject()) {
		return TRUE;
	}

	return FALSE;
} 
// Test du nombre d'enregistrements attendus dans un table
function mysql_table_count_line($bdd, $table, $count_line){
	$query_test = "SELECT COUNT(*)as compte FROM ".$table." ";
	$resultat = $bdd->query($query_test);

	if($tmp = $resultat->fetchObject() ) {
		if( $tmp->compte >= $count_line) {
			return TRUE;
		}
	}
	return FALSE;
} 


	
// Vérification des droits en écriture local
function test_file_auth() {
	
	// Création d'un fichier test
	$test_file = @fopen("lmb_test.txt","w");
	@fclose($test_file);
	// Test de son existence
	if (!is_file("lmb_test.txt")) {
		return ("Droits en écriture insuffisants sur le dossier racine (Impossible de créer le fichier de test.)");
	}

	// Suppression du fichier de test
	@unlink("lmb_test.txt");
	if (is_file("lmb_test.txt")) {
		return ("Droits en écriture insuffisants sur le dossier racine (Impossible de supprimer le fichier de test.)");
	}

	// Création d'un dossier de test
	if (!@mkdir("lmb_test", 0777)) {
		return ("Droits en écriture insuffisants sur le dossier racine (Impossible de créer le dossier de test.)");
	}

	// Création et suppression d'un fichier dans le dossier
	$test_file = @fopen("lmb_test/lmb_test.txt","w");
	@fclose($test_file);	
	if (!is_file("lmb_test/lmb_test.txt")) {
		return ("Droits en écriture insuffisants sur le dossier racine (Impossible de créer un fichier sur le dossier de test.)");
	}
	@unlink("lmb_test/lmb_test.txt");
	if (is_file("lmb_test/lmb_test.txt")) {
		return ("Droits en écriture insuffisants sur le dossier racine (Impossible de supprimer un fichier sur le dossier de test.)");
	}

	// Suppression du dossier
	@rmdir("lmb_test");
	if (is_dir("lmb_test")) {
		return ("Droits en écriture insuffisants sur le dossier racine (Impossible de supprimer le dossier de test.)");
	}

	return "";
}	

if (!count($GLOBALS['_INFOS']['test_systeme']) && !count($GLOBALS['_INFOS']['test_systeme_non_bloquant'])) {
	$_SESSION['TEST_SYSTEME'] = 1;
}

if (!count($GLOBALS['_INFOS']['test_systeme'])) {
	?>
	<span style="float:left; padding-right:20px"><img src="themes/admin_fr/images/ico_valide.png" /></span>Votre syst&egrave;me est compatible avec l'application.<br />
<br />
	<?php
	foreach ($GLOBALS['_INFOS']['test_systeme_non_bloquant'] as $erreur_test_non_bloquant) {
		?>
		<span style="float:left; padding-right:20px"><img src="themes/admin_fr/images/blank.gif" width="22px" /></span><em style="color:#FF0000"><?php echo ($erreur_test_non_bloquant)?></em><br />
		<?php
	}
} else {
	?>
	<span style="float:left; padding-right:20px"><img src="themes/admin_fr/images/ico_unvalide.png" /></span>Votre syst&egrave;me est incompatible avec l'application.<br /><br />
	<?php
	foreach ($GLOBALS['_INFOS']['test_systeme'] as $erreur_test) {
		?>
		<span style="float:left; padding-right:20px"><img src="themes/admin_fr/images/blank.gif" width="22px" /></span><em style="color:#FF0000"><?php echo ($erreur_test);?></em><br />
		<?php
	}
	
	foreach ($GLOBALS['_INFOS']['test_systeme_non_bloquant'] as $erreur_test_non_bloquant) {
		?>
		<span style="float:left; padding-right:20px"><img src="themes/admin_fr/images/blank.gif" width="22px" /></span><em style="color:#FF0000"><?php echo ($erreur_test_non_bloquant)?></em><br />
		<?php
	}
	?>
	<span style="float:left; padding-right:20px"><img src="themes/admin_fr/images/blank.gif" width="22px" /></span><span id="aff_rapport" style="cursor:pointer; text-decoration:underline;" >Voir le rapport de test</span><br />
	<div style="display:none; padding-left:42px; font-weight:bolder" id="rapport_text"><?php echo $retour_texte;?></div>
	<script type="text/javascript">
		Event.observe("aff_rapport", "click", function() {$("rapport_text").show();}, false);

	</script>
	<?php
}
?>
<script type="text/javascript">
//on masque le chargement
H_loading();
</script>