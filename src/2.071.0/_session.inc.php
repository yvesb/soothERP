<?php


// *************************************************************************************************************
// FICHIERS DE CONFIGURATION
// *************************************************************************************************************
$CONFIG_DIR = $DIR."config/";

require_once ($CONFIG_DIR."config_systeme.inc.php");
require_once ($CONFIG_DIR."config_serveur.inc.php");
require_once ($CONFIG_DIR."config_generale.inc.php");
require_once ($CONFIG_DIR."config_bdd.inc.php");

if (!function_exists  ("__autoload")){
	function __autoload($classname){
		global $DIR;
		global $DIR_PLUS;
		
		if(class_exists($classname)){return true;} // La classe est déjà chargée.
		
		//On la chreche en tant que vrai calsse.
		if(file_exists($DIR_PLUS."_".$classname.".class.php")){
                        require_once($DIR_PLUS."_".$classname.".class.php");
                    }elseif(file_exists($DIR."_".$classname.".class.php")){
                        require_once($DIR."_".$classname.".class.php");
                        }
		//On la cherche en tant que librairie -- $classname est une classe static abstraite.
		elseif(file_exists($DIR_PLUS."_".$classname.".lib.php"))
		{		require_once($DIR_PLUS."_".$classname.".lib.php");}
		elseif(file_exists($DIR."_".$classname.".lib.php"))
		{		require_once($DIR."_".$classname.".lib.php");}
		else{return false;}
		if(class_exists($classname)){ return true; } else { return false; }
	}
}

// *************************************************************************************************************
// Date - Timezone
// ***************************************************************************************************************
setlocale(LC_TIME, "fr_FRA", "fr_FR", "fra", "France", "French");
date_default_timezone_set($TIMEZONE);
header('Content-type: text/html; charset=iso-8859-15');


// *************************************************************************************************************
// CONSTANTES & VARIABLES D'ENVIRONNEMENT
// *************************************************************************************************************
// Chemin absolu du serveur
$prefix = "http://";
if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]){
    $prefix = "https://";
}
$_ENV['CHEMIN_ABSOLU'] = $prefix.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/".$DIR;

// Tableau des alertes & erreurs
$GLOBALS['_ALERTES'] 	= array();
$GLOBALS['_INFOS'] 		= array();



// *************************************************************************************************************
// LIBRAIRIES DE FONCTIONS
// *************************************************************************************************************
require_once ($DIR."_erreurs.lib.php");								// Gestion des erreurs 
require_once ($DIR."_exceptions.lib.php");						// Gestion des exceptions 
require_once ($DIR."_fonctions_generales.inc.php");		// Fonctions générales
require_once ($DIR."_annuaire.lib.php");							// Fonctions liées à l'annuaire
require_once ($DIR."_catalogue.lib.php");							// Fonctions liées au catalogue
require_once ($DIR."_document.lib.php");
require_once ($DIR."_tarif.lib.php");									// Fonctions liées aux tarifs
require_once ($DIR."_divers.lib.php");								// Fonctions diverses
require_once ($DIR."_referencement.lib.php");					// Fonctions liées au référencement
require_once ($DIR."_panier.lib.php");								// Fonctions liées aux paniers clients
require_once ($DIR."_courrier.lib.php");
require_once ($DIR."_stock.lib.php");
require_once ($DIR."_recherche_perso.lib.php");			// Fonctions liées aux recherches personnalisée

require_once ($DIR."modules/edi/edi_event.php");

// *************************************************************************************************************
// CLASSES A CHARGER
// *************************************************************************************************************
require_once ($DIR."_pdo_etendu.class.php");
require_once ($DIR."_reference.class.php");

require_once ($DIR."_profil.class.php");
require_once ($DIR."_interfaces.class.php");
require_once ($DIR."_theme.class.php");
require_once ($DIR."_user.class.php");
require_once ($DIR."_fonctions.class.php");

require_once ($DIR."_contact.class.php");
require_once ($DIR."_contact_profil.class.php");
require_once ($DIR."_adresse.class.php");
require_once ($DIR."_coordonnee.class.php");
require_once ($DIR."_site_web.class.php");
require_once ($DIR."_utilisateur.class.php");

require_once ($DIR."_article.class.php");
require_once ($DIR."_article_categ.class.php");
require_once ($DIR."_article_modele.class.php");
require_once ($DIR."_document_duree_abo.class.php");

require_once ($DIR."_catalogue_client.class.php");
require_once ($DIR."_liste.class.php");

require_once ($DIR."_document.class.php");
require_once ($DIR."_livraison_modes.class.php");

require_once ($DIR."_formule_tarif.class.php");
require_once ($DIR."_taxe.class.php");
require_once ($DIR."_tva.class.php");

require_once ($DIR."_tarif_liste.class.php");
require_once ($DIR."_stock.class.php");
require_once ($DIR."_magasin.class.php");

require_once ($DIR."_reglement.class.php");
require_once ($DIR."_compte_bancaire.class.php");
require_once ($DIR."_compte_caisse.class.php");
require_once ($DIR."_compte_tpe.class.php");
require_once ($DIR."_compte_tpv.class.php");
require_once ($DIR."_compte_cb.class.php");
require_once ($DIR."_modele_echeancier.class.php");
require_once ($DIR."_compta_exercices.class.php");
require_once ($DIR."_compta_plan_general.class.php");
require_once ($DIR."_compta_journaux.class.php");
require_once ($DIR."_document_echeancier.class.php");

require_once ($DIR."_facture_niveau_relance.class.php");
require_once ($DIR."_facture_niveau_relance.lib.php");

require_once ($DIR."_tache.class.php");
require_once ($DIR."_tache_admin.class.php");
require_once ($DIR."_web_link.class.php");

require_once ($DIR."_fournisseurs_import_tarifs.class.php");

require_once ($DIR."_pdf.class.php");

require_once ($DIR."_import_serveur.class.php");

require_once ($DIR."_email.class.php");
require_once ($DIR."_newsletter.class.php");
require_once ($DIR."_mail_template.class.php");
require_once ($DIR."_newsletters_profils.lib.php");
require_once ($DIR."_courrier.class.php");

require_once ($DIR."_formule_comm.class.php");
require_once ($DIR."_commission_liste.class.php");

require_once ($DIR."_inscription.class.php");
require_once ($DIR."_inscription_compte_user.class.php");
require_once ($DIR."_modification_compte_user.class.php");

require_once ($DIR."_import_tarifs_fournisseur_csv.class.php");
require_once ($DIR."_import_commandes_csv.class.php");

require_once ($DIR."_edition_mode.lib.php");
require_once ($DIR."_document_echeancier.class.php");
require_once ($DIR."_template.class.php");
require_once ($DIR."_msg_modele.class.php");

require_once ($DIR."_helper.class.php");

// Classes chargées dynamiquement selon l'installation et la configuration du serveur.
require_once ($CONFIG_DIR."load_profils.inc.php");
require_once ($CONFIG_DIR."load_modules.inc.php");
require_once ($CONFIG_DIR."load_docs.inc.php");

// Classes de modeles de messages chargées dynamiquement
foreach (glob($MSG_MODELES_DIR."_msg_modele_*.class.php") as $file){
    require_once ($file);
}

if (!$_SERVER['ACTIF'] && !isset($_SERVER['MAJ_EN_COURS'])) {
	header ("Location: ".$_ENV['CHEMIN_ABSOLU']."site/__serveur_stopped.php");
	exit(); 
}

// *************************************************************************************************************
// CONNEXION A LA BASE DE DONNEES
// *************************************************************************************************************
$bdd = new PDO_etendu("mysql:host=".$bdd_hote."; dbname=".$bdd_base."", $bdd_user, $bdd_pass);

// Afficher les erreurs PDO (liées à la base de donnée)
$bdd->setAttribute (PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
$bdd->setAttribute (PDO::ATTR_EMULATE_PREPARES, true);
$bdd->setAttribute (PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);



//@ini_set('memory_limit', '128M');
// *************************************************************************************************************
// INITIALISATION DE LA SESSION
// *************************************************************************************************************
ini_set ("session.cookie_lifetime", $SESSION_LT) ;

if(!session_id()) {session_start(); }

//traitement du register_globals à on
if (ini_get('register_globals')) {
  $superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET);
  if (isset($_SESSION)) {
    array_unshift($superglobals, $_SESSION);
  }
  foreach ($superglobals as $superglobal) {
    foreach ($superglobal as $global => $value) {
      unset($GLOBALS[$global]);
    }
  }
  ini_set('register_globals', false);
}

if (!isset($DONT_EXTAND_USER_SESSION)) {
	$_SESSION['date_debut_user_session'] = time();
}

//mise à jour des données de session si le fichier _session_maj a été modifié
if (isset($_SESSION['user']) && $_SESSION['user']->getLogin()) {
	// ini_set("memory_limit","12M");
	// recupération du fichier témoin de mise à jour pour comparaison et remise à zero des informations de session.
	$filename = $DIR.'_session_maj.php';
	if (file_exists($filename)) {    
		if ($_SESSION['user']->last_log_connexion() < date ("Y-m-d H:i:s.", filemtime($filename))) {
			if (isset($_SESSION['profils'])) {unset($_SESSION['profils']);}
			if (isset($_SESSION['interfaces'])) {unset($_SESSION['interfaces']);}
			if (isset($_SESSION['magasins'])) {unset($_SESSION['magasins']);}
			if (isset($_SESSION['stocks'])) {unset($_SESSION['stocks']);}
			if (isset($_SESSION['types_docs'])) {unset($_SESSION['types_docs']);}
			
		}
	}
}


// *************************************************************************************************************
// DONNEES DE SESSION
// *************************************************************************************************************

// PROFILS
if (!isset($_SESSION['profils'])) {
	$query = "SELECT id_profil, lib_profil, code_profil, actif, ordre, niveau_secu, defaut_id_interface
						FROM profils
						WHERE actif >= 1
						ORDER BY ordre";
	$result = $bdd->query($query);
	// Chargement des profils en donnée de session
	while ($profil = $result->fetchObject()) {
		$_SESSION['profils'][$profil->id_profil] = new profil($profil);
	}
	
	unset ($profil, $result);
}

// INTERFACES
if (!isset($_SESSION['interfaces'])) {
	$query = "SELECT id_interface, dossier, url, lib_interface, id_profil, defaut_id_theme
						FROM interfaces  ";
	$resultat = $bdd->query ($query);
	while ($interface = $resultat->fetchObject()) {
		$_SESSION['interfaces'][$interface->id_interface] = new interfaces(0, $interface);
	}
}

// MAGASINS
if (!isset($_SESSION['magasins'])) {
	// Liste des magasins
	$query = "SELECT m.id_magasin, m.lib_magasin,  m.abrev_magasin, m.id_stock, m.id_tarif, m.mode_vente, m.actif, 
									 t.lib_tarif, s.lib_stock, s.abrev_stock, s.ref_adr_stock,
									 me.id_mag_enseigne, me.lib_enseigne
						FROM magasins m
							LEFT JOIN tarifs_listes t ON m.id_tarif = t.id_tarif
							LEFT JOIN stocks s ON m.id_stock = s.id_stock
							LEFT JOIN magasins_enseignes me ON me.id_mag_enseigne = m.id_mag_enseigne
						WHERE m.actif >= 1
						ORDER BY m.lib_magasin";
	$result = $bdd->query($query);
	// Chargement des magasins en donnée de session
	while ($mag = $result->fetchObject()) {
		$_SESSION['magasins'][$mag->id_magasin] = new magasin(0, $mag);
	}

	if (isset($_COOKIE['last_id_magasin'])) { $id_magasin = $_COOKIE['last_id_magasin']; }
	else 									{ $id_magasin = $DEFAUT_ID_MAGASIN; }

	if (isset($_SESSION['magasins'][$id_magasin])) {
		$_SESSION['magasin'] = $_SESSION['magasins'][$id_magasin];
	}
}


// STOCKS
if (!isset($_SESSION['stocks'])) {
	// Liste des stocks
	$query = "SELECT id_stock, lib_stock, abrev_stock, ref_adr_stock, actif
				FROM stocks 
				WHERE actif >= 1
				ORDER BY lib_stock";
	$result = $bdd->query($query);
	// Chargement des stocks en donnée de session
	while ($stock = $result->fetchObject()) {
		$_SESSION['stocks'][$stock->id_stock] = new stock(0, $stock);
	}
}


// Date de debut du dernier exercice non clot
if (!isset($_SESSION['date_compta_closed'])) {
	$_SESSION['date_compta_closed'] = $ENTREPRISE_DATE_CREATION;

	$query = "SELECT ce.date_fin, ce.etat_exercice
						FROM compta_exercices ce
						WHERE ce.etat_exercice = '0'
						ORDER BY ce.date_fin DESC
						LIMIT 1 ";
	$resultat = $bdd->query ($query);
	
	if ($compta_e = $resultat->fetchObject()) { $_SESSION['date_compta_closed'] = $compta_e->date_fin;}
	
}

// TYPES DE DOCUMENTS COMMERCIAUX
if (!isset($_SESSION['types_docs'])) {
	// Liste des types de document
	$query = "SELECT id_type_doc, code_doc, lib_type_doc, lib_type_printed, id_type_groupe
				FROM documents_types 
						WHERE actif = 1
						ORDER BY id_type_groupe ASC, lib_type_doc ASC";
	$result = $bdd->query($query);
	// Chargement des types de document en donnée de session
	while ($type = $result->fetchObject()) {
		$_SESSION['types_docs'][$type->id_type_doc] = $type;
	}
}

// *************************************************************************************************************
// Verification des maj dispo
// *************************************************************************************************************
if (!isset($_SESSION['NEW_MAJ_DISPO']) && isset($_SESSION['user']) && isset($ID_PROFIL) && ($ID_PROFIL == 2 || $ID_PROFIL == 3)) {
	$last_version_dispo = "0";
	if ($MAJ_SERVEUR['url'] && @remote_file_exists ($MAJ_SERVEUR['url']."check_version_dispo.php?version_actuelle=".$_SERVER['VERSION'])) {
		$version_file = @file ($MAJ_SERVEUR['url']."check_version_dispo.php?version_actuelle=".$_SERVER['VERSION']);
		if (isset($version_file[0])) { 
			$last_version_dispo = str_replace("\n", "", $version_file[0]);
		}
	}
  $_SESSION['NEW_MAJ_DISPO'] = $last_version_dispo;
}


// *************************************************************************************************************
// UTILISATEUR
// *************************************************************************************************************
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = new user ();
}



// *************************************************************************************************************
// VERIFICATIONS DE SECURITE
// *************************************************************************************************************

// If ip is banned => display message and exit
if (is_banned($_SERVER['REMOTE_ADDR'])) {
	echo 'Accès utilisateur désactivé suite à de trop nombreux échecs de connexion. Si vous êtes un utilisateur légitime, veuillez contacter votre administrateur';
	exit();
}


if (isset($THIS_DIR) && is_file($THIS_DIR."_interface.config.php")) { 
	require_once ($THIS_DIR."_interface.config.php");
}
else {
	require_once ($DIR."site/_interface.config.php");
}

// La page que consulte l'utilisateur est elle accessible à tous ?
if( !function_exists('page_accessible_a_tous')){
    function page_accessible_a_tous(){
    	global $_INTERFACE;
    	global $THIS_DIR;
	
    	if (!$_SESSION['user']->getLogin()) {
    		if ($_INTERFACE['ID_PROFIL'] == 4 && isset($THIS_DIR)) {
    			$page_from = str_replace($THIS_DIR, "", substr($_SERVER['REQUEST_URI'], 1));
    			header ("Location: ".$_ENV['CHEMIN_ABSOLU']."site/".$THIS_DIR."_user_login.php");
    		} else {
    			// L'utilisateur n'est pas loggué et devrait l'etre => Direction page de login
    			$page_from = substr($_SERVER['REQUEST_URI'], 1);
    			if ($page_from == "site/__user_login.php") { $page_from = "";}
    			header ("Location: ".$_ENV['CHEMIN_ABSOLU']."site/__user_login.php");
    		}
    		exit();
    	}
    }
}
if(isset($_INTERFACE['MUST_BE_LOGIN'])){
	if(isset($_PAGE['MUST_BE_LOGIN'])){
	//CAS 1
	//$_INTERFACE['MUST_BE_LOGIN'] est défini
	//$_PAGE['MUST_BE_LOGIN'] est défini
		if($_PAGE['MUST_BE_LOGIN']){page_accessible_a_tous();}
	}else{
	//CAS 2
	//$_INTERFACE['MUST_BE_LOGIN'] est défini
	//$_PAGE['MUST_BE_LOGIN'] n'est pas défini
		if($_INTERFACE['MUST_BE_LOGIN']){page_accessible_a_tous();}
	}
}else{
	if(isset($_PAGE['MUST_BE_LOGIN'])){
	//CAS 3
	//$_INTERFACE['MUST_BE_LOGIN'] n'est pas défini
	//$_PAGE['MUST_BE_LOGIN'] est défini
		if($_PAGE['MUST_BE_LOGIN']){page_accessible_a_tous();}
	}else{
	//CAS 4
	//$_INTERFACE['MUST_BE_LOGIN'] n'est pas défini
	//$_PAGE['MUST_BE_LOGIN'] n'est pas défini
		//NE RIEN FAIRE
	}
}



// Vérifie si il y a changement d'interface
if ($_INTERFACE['ID_INTERFACE'] != $_SESSION['user']->getId_interface()) {
	// Si l'utilisateur n'a pas le droit d'accéder à cette interface
	if (!$_SESSION['user']->interface_is_allowed ($_INTERFACE['ID_INTERFACE'])) {
		// Si il n'est pas identifié, renvoi vers la page de login
		if (!$_SESSION['user']->getLogin()) {
			$page_from = substr($_SERVER['REQUEST_URI'], 1);
			header ("Location: ".$_ENV['CHEMIN_ABSOLU']."site/__user_login.php?page_from=".$page_from);
			exit();
		}
		// Si il est identifié, il n'a tout simplement pas le droit
		if (isset($_SESSION['profils'][$DEFAUT_PROFILS[0]]) && isset($_SESSION['interfaces'][$_SESSION['profils'][$DEFAUT_PROFILS[0]]->getDefaut_id_interface()]) ) {
			header("Location: ".$_ENV['CHEMIN_ABSOLU'].$_SESSION['interfaces'][$_SESSION['profils'][$DEFAUT_PROFILS[0]]->getDefaut_id_interface()]->getDossier()."__user_choix_profil.php");
		} else {
		//raffraichissement forcé de la session
			header ("Location: ".$_ENV['CHEMIN_ABSOLU']."site/__session_stop.php");
		}
		exit();
	}
	
	// Changement de l'interface pour l'utilisateur/
	$_SESSION['user']->set_interface($_INTERFACE['ID_INTERFACE']);
	global $ID_MAGASIN;
	if (isset($_COOKIE['last_id_magasin'])) { $id_magasin = $_COOKIE['last_id_magasin']; }
	else 									{ $id_magasin = $DEFAUT_ID_MAGASIN; }

	if (isset($_SESSION['magasins'][$id_magasin])) {


// *************************************************************************************************************
// Modification éffectuée par Yves Bourvon
// Verification que l'ID MAGASIN existe et est paramètré dans la configuration, sinon message d'alerte et destruction de la session pour éviter un accès forcé en reloadant la page.

	if (isset($ID_MAGASIN)) {
		if (isset($_SESSION['magasins'][$ID_MAGASIN])){
		$_SESSION['magasin'] = $_SESSION['magasins'][$ID_MAGASIN];
		}
		else {
		?>
		<div id="alert_onException" class="alert_pop_up__exception_tab">
			<div id="alert_onException_content">
				<table cellpadding=0 cellspacing=0 border=0 style="width:100%; text-align:center">
					<tr>
						<td>
							<table width="100%" cellpadding=0 cellspacing=0 border=0 align="center">
								<tr>
									<td colspan="2" style="text-align:center; font-weight:bolder; line-height:20px; height:20px;  border-bottom:1px solid #000000;">
										Erreur de configuration des magasins
									</td>
								</tr>
								<tr>
									<td style="text-align: right">&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" style="text-align: center;">
										<p>Le magasin appelé pour la connexion client ne semble pas être correctement configuré.<br />
											Le magasin attribué à la connexion client est le <strong>n°<?php echo $ID_MAGASIN; ?></strong>, or il ne semble pas être défini dans la configuration des magasins VPC.<br /><br />
											Veuillez vérifier les configurations (vous pouvez définir un magasin VPC dans l'inteface admninistrateur > Points de vente,<br />
											un même magasin ne peut être défini comme VAC et VPC sur la même ligne)
										</p>
									</td>
								</tr>
								<tr>
									<td style="text-align: right">&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan=2 align="center">
									<input type="button" onclick="javascript: history.go(-1)" value="Retour à la page précédente" />
									</td>
								</tr>
								<tr>
									<td colspan=2 align="right"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php
		session_unset();
		session_destroy();
		exit;
		}

		}
// Fin de modification
// *************************************************************************************************************
	}
	
}
/*
if (!isset($ID_PROFIL)) { $ID_PROFIL = 0; }
// Profil nécessaire pour consulter la page en cours
if ($ID_PROFIL != $_SESSION['user']->getId_profil()) {
	try {
		$resultat = $_SESSION['user']->set_profil ($ID_PROFIL);

		if (!$resultat) {
			throw new AccesException ($ID_PROFIL);
		}
	}
	catch (AccesException $exception) {
		$exception->alerte(); 
	}
}
*/


// *************************************************************************************************************
// Maj du cache 
if ($_SESSION['user']->getLogin() && ($_INTERFACE['ID_INTERFACE'] == 2 || $_INTERFACE['ID_INTERFACE'] == 3)) {
	// recupération du fichier témoin de mise à jour pour comparaison et remise à zero des informations en cache.
	$ID_PROFIL = $_SESSION['interfaces'][$_SESSION['user']->getId_interface()]->getId_profil();
	$filename = $DIR.'_last_update.php';
	if (file_exists($filename) && (isset($_COOKIE["uncahe_profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()]) &&  
			date ("Y-m-d H:i:s.",strtotime($_COOKIE["uncahe_profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()])) < date ("Y-m-d H:i:s.", filemtime($filename))))
	{
		
		setcookie("uncahe_profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil(), "" , time()-42000 , '/');
		session_unset();
		session_destroy();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		$page_from = "";
		if (!isset($_REQUEST["page_from"])) {
			$page_from = substr($_SERVER['REQUEST_URI'], 1);
		}
		header ("Location: ".$_ENV['CHEMIN_ABSOLU']."site/__user_login.php?uncache=1&page_from=".$page_from);
		exit();
	}
}



// *************************************************************************************************************
// CRONS, a délocaliser au niveau du système !!
// ***************************************************************************************************************
if (!isset($_SESSION['maj'])) {
	$_SESSION['maj']['count_pages'] = 0;
}
$_SESSION['maj']['count_pages'] ++;

if ($_SESSION['maj']['count_pages'] > 5) {
	flush_maj_articles();
}
?>
