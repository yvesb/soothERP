<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE NEWSLETTER
// *************************************************************************************************************


final class newsletter {
	protected $id_newsletter;
	protected $nom;
	protected $periodicite;
	protected $description_interne;
	protected $description_publique;
	protected $id_mail_template;
	protected $archives_publiques;
	protected $inscription_libre;
	protected $nom_expediteur;
	protected $mail_expediteur;
	protected $mail_retour;
	protected $mail_inscription_titre;
	protected $mail_inscription_corps;
	protected $titre_brouillon;
	protected $brouillon;
	
	

public function __construct ($id_newsletter = "") {
	global $bdd;

	if (!$id_newsletter) { return false; }

	$query = "SELECT  n.nom_newsletter, n.periodicite, n.description_interne, n.description_publique, 
										n.id_mail_template, n.archives_publiques, n.inscription_libre, n.nom_expediteur, 
										n.mail_expediteur, n.mail_retour, n.mail_inscription_titre, n.mail_inscription_corps, n.titre_brouillon, n.brouillon
						FROM newsletters n
						WHERE n.id_newsletter = '".$id_newsletter."' ";


	$resultat = $bdd->query ($query);
	if (!$newsletter = $resultat->fetchObject()) { return false; }

	$this->id_newsletter			= $id_newsletter;
	$this->nom_newsletter 			= $newsletter->nom_newsletter;
	$this->periodicite 				= $newsletter->periodicite;
	$this->description_interne 		= $newsletter->description_interne;
	$this->description_publique 	= $newsletter->description_publique;
	$this->id_mail_template 		= $newsletter->id_mail_template;
	$this->archives_publiques 		= $newsletter->archives_publiques;
	$this->inscription_libre 		= $newsletter->inscription_libre;
	$this->nom_expediteur 			= $newsletter->nom_expediteur;
	$this->mail_expediteur 			= $newsletter->mail_expediteur;
	$this->mail_retour 				= $newsletter->mail_retour;
	$this->mail_inscription_titre 	= $newsletter->mail_inscription_titre;
	$this->mail_inscription_corps 	= $newsletter->mail_inscription_corps;
	$this->titre_brouillon			= $newsletter->titre_brouillon;
	$this->brouillon				= $newsletter->brouillon;

	return true;
}

// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES
// *************************************************************************************************************

// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION ET MISE A JOUR D'UNE NEWSLETTER
// *************************************************************************************************************

public function create_newsletter ($infos) {
	global $bdd;

  // *************************************************
	// Réception des données
	$this->nom_newsletter 				= $infos['nom_newsletter'];
	$this->periodicite 					= $infos['periodicite_newsletter'];
	$this->description_interne 			= $infos['description_interne_newsletter'];
	$this->description_publique 		= $infos['description_publique_newsletter'];
	$this->id_mail_template 			= $infos['id_mail_template_newsletter'];
	$this->archives_publiques 			= $infos['archives_publiques_newsletter'];
	$this->inscription_libre 			= $infos['inscription_libre_newsletter'];
	$this->nom_expediteur 				= $infos['nom_expediteur_newsletter'];
	$this->mail_expediteur 				= $infos['mail_expediteur_newsletter'];
	$this->mail_retour 					= $infos['mail_retour_newsletter'];
	$this->mail_inscription_titre 		= $infos['mail_inscription_titre_newsletter'];
	$this->mail_inscription_corps 		= $infos['mail_inscription_corps_newsletter'];

	if (!$this->nom_newsletter) {
		$this->nom_newsletter = "Newsletter ".date("d-m-Y");
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO newsletters (nom_newsletter, periodicite, description_interne, description_publique, 
												id_mail_template, archives_publiques, inscription_libre, nom_expediteur, mail_expediteur, mail_retour, 
												mail_inscription_titre, mail_inscription_corps)
						VALUES ('".addslashes($this->nom_newsletter)."', '".$this->periodicite."', 
										'".addslashes($this->description_interne)."', '".addslashes($this->description_publique)."', 
										'".$this->id_mail_template."',  '".$this->archives_publiques."', 
										'".$this->inscription_libre."', '".addslashes($this->nom_expediteur)."', 
										'".addslashes($this->mail_expediteur)."', '".addslashes($this->mail_retour)."', 
										'".addslashes($this->mail_inscription_titre)."', 
										'".addslashes($this->mail_inscription_corps)."')";

	$bdd->exec ($query);
	$this->id_newsletter = $bdd->lastInsertId();

	return true;
}

//fonction de la mise à jour des informations de la newsletter
public function maj_newsletter ($infos) {
	global $bdd;

  // *************************************************
	// Réception des données
	$this->nom_newsletter 				= $infos['nom_newsletter'];
	$this->periodicite 					= $infos['periodicite_newsletter'];
	$this->description_interne 			= $infos['description_interne_newsletter'];
	$this->description_publique 		= $infos['description_publique_newsletter'];
	$this->id_mail_template 			= $infos['id_mail_template_newsletter'];
	$this->archives_publiques 			= $infos['archives_publiques_newsletter'];
	$this->inscription_libre 			= $infos['inscription_libre_newsletter'];
	$this->nom_expediteur 				= $infos['nom_expediteur_newsletter'];
	$this->mail_expediteur 				= $infos['mail_expediteur_newsletter'];
	$this->mail_retour 					= $infos['mail_retour_newsletter'];
	$this->mail_inscription_titre 		= $infos['mail_inscription_titre_newsletter'];
	$this->mail_inscription_corps 		= $infos['mail_inscription_corps_newsletter'];

	if (!$this->nom_newsletter) {
		$this->nom_newsletter = "Newsletter ".date("d-m-Y");
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Insertion dans la bdd
	$query = "UPDATE newsletters 
						SET nom_newsletter='".addslashes($this->nom_newsletter)."', 
								periodicite='".$this->periodicite."', 
								description_interne='".addslashes($this->description_interne)."', 
								description_publique='".addslashes($this->description_publique)."', 
								id_mail_template = '".$this->id_mail_template."', 
								archives_publiques = '".$this->archives_publiques."', 
								inscription_libre= '".$this->inscription_libre."', 
								nom_expediteur = '".addslashes($this->nom_expediteur)."', 
								mail_expediteur = '".addslashes($this->mail_expediteur)."', 
								mail_retour = '".addslashes($this->mail_retour)."',  
								mail_inscription_titre = '".addslashes($this->mail_inscription_titre)."', 
								mail_inscription_corps = '".addslashes($this->mail_inscription_corps)."'
						WHERE id_newsletter = '".$this->id_newsletter."' ";
	$bdd->exec ($query);

	return true;
}

//sauvegarde du brouillon de newsletter en cours
public function save_brouillon ($brouillon, $titre_brouillon) {
	global $bdd;

	// *************************************************
	// Réception des données
	$this->brouillon 						= $brouillon;
	$this->titre_brouillon 			= $titre_brouillon;
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Insertion dans la bdd
	$query = "UPDATE newsletters 
						SET brouillon = '".addslashes($this->brouillon)."', titre_brouillon = '".addslashes($this->titre_brouillon)."'
						WHERE id_newsletter = '".$this->id_newsletter."' ";
	$bdd->exec ($query);

	return true;
}

// Suppression d'une newsletter
public function suppression () {
	global $bdd;

	// Suppression dans la BDD
	$query = "DELETE FROM newsletters WHERE id_newsletter = '".$this->id_newsletter."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}


// *************************************************************************************************************
// fonction liées à la gestion des inscrits à la newsletter
// *************************************************************************************************************

//ajout d'un email à cette liste
public function add_newsletter_inscrit ($email, $nom, $inscrit = 1) {
	global $bdd;
	
	$query = "SELECT email
						FROM newsletters_inscrits
						WHERE id_newsletter = '".$this->id_newsletter."' && email = '".$email."' ";
	$resultat = $bdd->query ($query);
	//email déjà inscrit, on ne l'enregistre pas
	if ($tmp = $resultat->fetchObject()) { return false; }
	
	$query = "INSERT INTO newsletters_inscrits (id_newsletter, nom, email, inscrit) 
						VALUES ('".$this->id_newsletter."', '".addslashes($nom)."',  '".addslashes($email)."', '".$inscrit."')";
	$bdd->exec ($query);
	return true;
	
}

//Mise à jour d'un inscrit à une newsletter dans les non-inscrits
public function maj_newsletter_inscrit ($email, $inscrit = 0, $nom = ""){
	global $bdd;
	
	$query = "SELECT email
						FROM newsletters_inscrits
						WHERE id_newsletter = '".$this->id_newsletter."' && email = '".$email."' ";
	$resultat = $bdd->query ($query);
	//email déjà inscrit, on le passe en desincrit
	if ($tmp = $resultat->fetchObject()) {
		$query = "UPDATE newsletters_inscrits 
							SET id_newsletter = '".$this->id_newsletter."',
									 nom = '".addslashes($nom)."', email = '".addslashes($email)."', inscrit = '".$inscrit."'
							WHERE id_newsletter = '".$this->id_newsletter."' && email = '".$email."' ";
		$bdd->exec ($query);
	} else {
		$query = "INSERT INTO newsletters_inscrits (id_newsletter, nom, email, inscrit) 
							VALUES ('".$this->id_newsletter."', '".addslashes($nom)."',  '".addslashes($email)."', '".$inscrit."')";
		$bdd->exec ($query);
	}
	return true;
}

//suppression d'un email de cette liste
public function del_newsletter_inscrit ($email) {
	global $bdd;
	
	// Suppression dans la BDD
	$query = "DELETE FROM newsletters_inscrits WHERE id_newsletter = '".$this->id_newsletter."' && email = '".$email."' ";
	$bdd->exec ($query);
	return true;
}

//chargement de la liste des incrits
public function charge_inscrits ($inscrit) {
	global $bdd;
	
	$liste = array();
	$query = "SELECT email, nom
						FROM newsletters_inscrits
						WHERE id_newsletter = '".$this->id_newsletter."' && inscrit = '".$inscrit."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $liste[] = $tmp;}
	
	return $liste;
}

//ajout préinscrit newletter

//ajout d'un préinscrit
public function add_newsletter_newsletters_inscriptions ($email) {
	global $bdd;
	
	if (!$email) { return false; }
	
	// On vérifie que l'email n'est pas déjà inscrit (en préinscription) pour la newsletter
	$query = "SELECT id_newsletter FROM newsletters_inscriptions" . 
				" WHERE id_newsletter = '" . $this->id_newsletter . "'" . 
				" AND email = '" . $email . "';";
	$res = $bdd->query($query);
	if($res->rowCount()){return false; }
	
	// On vérifie que l'email n'est pas déjà inscrit (inscription validée) pour la newsletter
	$query = "SELECT id_newsletter FROM newsletters_inscrits" . 
				" WHERE id_newsletter = '" . $this->id_newsletter . "'" . 
				" AND email = '" . $email . "';";
	$res = $bdd->query($query);
	if($res->rowCount()){return false; }
	
	$code_secret = creer_code_unique ($email, $this->id_newsletter);
	// Enregistrement de la preinscription
	$query = "INSERT INTO newsletters_inscriptions (id_newsletter, email, code_secret, date_demande) 
						VALUES ('".$this->id_newsletter."', '".addslashes($email)."', '".addslashes($code_secret)."', NOW())";
	$bdd->exec ($query);
	
	//url d'inscription et de comptage des lectures
	$url_insciption = "site/newsletters/inscription.php?id_newsletter=".$this->id_newsletter."&email=".$email."&code=".$code_secret;

	return $url_insciption;	
}

//maj d'un préinscrit
public function maj_newsletter_newsletters_inscriptions ($email, $code_secret) {
	global $bdd;

	$query = "SELECT id_newsletter FROM newsletters_inscrits WHERE id_newsletter = '" . $this->id_newsletter . "'
				AND email = '" . $email . "' AND inscrit='1';";
	$resultat = $bdd->query($query);
	// Inscription déjà validée
	if($tmp = $resultat->fetchObject()){
		$GLOBALS['_INFOS']['validation_inscription_newsletter'] = -2;
		return false;
	}
	
	$query = "SELECT code_secret
						FROM newsletters_inscriptions
						WHERE id_newsletter = '".$this->id_newsletter."' 
							&& email = '".$email."' 
							&& date_demande > '".date ("Y-m-d", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")))."' ";
	$resultat = $bdd->query ($query);
	// Email (pré-inscription) non présent ou date dépassée
	if (!$tmp = $resultat->fetchObject()) {
		return false;
	}
	// Code secret dans l'URL de validation incorrect
	if ($code_secret != $tmp->code_secret) {
		$GLOBALS['_INFOS']['validation_inscription_newsletter'] = -1;
		return false;
	}
	
	$query = "INSERT INTO newsletters_inscrits (id_newsletter, nom, email, inscrit) 
						VALUES ('".$this->id_newsletter."', '',  '".addslashes($email)."', '1')";
	$bdd->exec ($query);
	
	$query = "DELETE FROM newsletters_inscriptions 
						WHERE id_newsletter = '".$this->id_newsletter."' && email = '".addslashes($email)."'";
	$bdd->exec ($query);
	
	//maintenance... vidange des email préinscrits dépassant le mois
	$query = "DELETE FROM newsletters_inscriptions 
						WHERE date_demande < '".date ("Y-m-d", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")))."' ";
	$bdd->exec ($query);
	
	return true;
	
}

// *************************************************************************************************************
//fonction liées à la création d'un envois
// *************************************************************************************************************

//ajout d'un envoi
public function add_newsletter_envoi ($contenu, $entete, $pied, $titre) {
	global $bdd;
	
	$query = "INSERT INTO newsletters_envois (id_newsletter, entete, contenu, pied, titre, date_envoi) 
						VALUES ('".$this->id_newsletter."', '".addslashes($entete)."', '".addslashes($contenu)."', '".addslashes($pied)."', '".addslashes($titre)."',  NOW())";
	$bdd->exec ($query);
	
	return $bdd->lastInsertId();
	
}

public function add_newsletter_envoi_destinataire ($id_envoi, $nom, $email, $lecture = 0) {
	global $bdd;
	
	$query = "INSERT INTO newsletters_destinataires (id_envoi, nom, email, lecture) 
						VALUES ('".$id_envoi."', '".addslashes($nom)."', '".addslashes($email)."', '".$lecture."')";
	$bdd->exec ($query);
	
	return true;
	
}

//chargement de la liste des envois de newsletter
public function charger_envois_newsletter () {
	global $bdd;

	$liste_envois = array();
	$query = "SELECT ne.id_envoi, ne.entete, ne.contenu, ne.pied, ne.titre, ne.date_envoi, ne.fin_envoi, ne.id_newsletter,
										(SELECT 	COUNT(nd.id_envoi) 
										FROM newsletters_destinataires nd
										WHERE nd.id_envoi = ne.id_envoi) as nb_inscrits,
										(SELECT 	COUNT(nd.id_envoi) 
										FROM newsletters_destinataires nd
										WHERE nd.id_envoi = ne.id_envoi && lecture = 1) as nb_lus
						FROM newsletters_envois ne
						WHERE ne.id_newsletter = '".$this->id_newsletter."'
						ORDER BY ne.date_envoi DESC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { 
		$liste_envois[] = $tmp;
	}
	return $liste_envois;
}
//chargement de la liste des destinataire d'un envoi de newsletter
public function charger_envoi_destinataires_newsletter ($id_envoi) {
	global $bdd;

	$liste_dest_envois = array();
	$query = "SELECT id_envoi, nom, email, lecture
										FROM newsletters_destinataires nd
										WHERE nd.id_envoi = '".$id_envoi."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { 
		$liste_dest_envois[] = $tmp;
	}
	return $liste_dest_envois;
}

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_newsletter() {
	return $this->id_newsletter;
}

function getNom_newsletter() {
	return $this->nom_newsletter;
}

function getPeriodicite() {
	return $this->periodicite;
}

function getDescription_interne() {
	return $this->description_interne;
}

function getDescription_publique() {
	return $this->description_publique;
}

function getId_mail_template() {
	return $this->id_mail_template;
}

function getArchives_publiques() {
	return $this->archives_publiques;
}

function getInscription_libre() {
	return $this->inscription_libre;
}

function getNom_expediteur() {
	return $this->nom_expediteur;
}

function getMail_expediteur() {
	return $this->mail_expediteur;
}

function getMail_retour() {
	return $this->mail_retour;
}

function getMail_inscription_titre() {
	return $this->mail_inscription_titre;
}

function getMail_inscription_corps() {
	return $this->mail_inscription_corps;
}

function getTitre_brouillon() {
	if (!$this->titre_brouillon) {return $this->nom_newsletter;}
	return $this->titre_brouillon;
}

function getBrouillon() {
	return $this->brouillon;
}


}

// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger toutes les newsletters
function charger_newsletters () {
	global $bdd;

	$newsletters = array();
	$query = "SELECT  n.id_newsletter, nom_newsletter, periodicite, description_interne, 
										description_publique, id_mail_template, archives_publiques,
										inscription_libre, nom_expediteur, mail_expediteur,
										mail_retour, mail_inscription_titre, mail_inscription_corps,
										(SELECT 	MAX(ne.date_envoi) 
										FROM newsletters_envois ne
										WHERE n.id_newsletter = ne.id_newsletter) as date_envoi
						FROM newsletters n
						GROUP BY n.id_newsletter
						ORDER BY n.id_newsletter ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $newsletters[] = $tmp; }
	
	return $newsletters;
}

//chargement du nombre total d'abonnés à une newsletter
function charger_total_abonnes ($id_newsletter) {
	global $bdd;
	global $ADMIN_ID_PROFIL;
	global $COLLAB_ID_PROFIL;
	global $CLIENT_ID_PROFIL;
	global $FOURNISSEUR_ID_PROFIL;
	global $CONSTRUCTEUR_ID_PROFIL;
	
	$newsletter_profils = getNewsletter_Profils($id_newsletter);
	
	$liste_email = array();
	foreach ($_SESSION['profils'] as $profil) {
		if(array_search($profil->getId_profil(),$newsletter_profils)!== false) {
			$criteres = array();
			$query_where = "";
			
			$query = "SELECT criteres
							 FROM newsletters_profils
							 WHERE id_newsletter = ".$id_newsletter." && id_profil = ".$profil->getId_profil();
			$resultat = $bdd->query ($query);
			while ($tmp = $resultat->fetchObject()) {
				$criteres = explode("//", $tmp->criteres);
			}
			unset($query, $resultat);
			
			switch ($profil->getId_profil()) {
				case $ADMIN_ID_PROFIL:
					$query = "SELECT TRIM(c.email)email, a.nom
										FROM coordonnees c
											LEFT JOIN annuaire a ON a.ref_contact = c.ref_contact
											LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
											LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact 
										WHERE c.email != '' && a.date_archivage IS NULL  && ap.id_profil  = '".$ADMIN_ID_PROFIL."' ";
					$resultat = $bdd->query ($query);
					while ($tmp = $resultat->fetchObject()) { $liste_email[$tmp->email] = $tmp;}
				break;
				case $COLLAB_ID_PROFIL:
					$collab_fct = explode(";", $criteres[0]);
					if (count($collab_fct) && $collab_fct[0] != "") {$query_where = " && uf.id_fonction IN ( ".implode(",", $collab_fct)." )";}
					$query = "SELECT TRIM(c.email)email, a.nom
										FROM coordonnees c
											LEFT JOIN annuaire a ON a.ref_contact = c.ref_contact
											LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
											LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact 
											LEFT JOIN users u ON u.ref_contact = a.ref_contact 
											LEFT JOIN annu_collab_fonctions uf ON uf.ref_contact = u.ref_contact 
										WHERE c.email != '' && a.date_archivage IS NULL  && ap.id_profil  = '".$COLLAB_ID_PROFIL."' ".$query_where;
					$resultat = $bdd->query ($query);
					while ($tmp = $resultat->fetchObject()) { $liste_email[$tmp->email] = $tmp;}
				break;
				case $CLIENT_ID_PROFIL:
				
					$client_categorie = explode(";", $criteres[0]);
					if (count($client_categorie) && $client_categorie[0] != "") {$query_where .= " && ac.id_categorie IN ( ".implode(",", $client_categorie)." )";}
					
					$client_type = explode(";", $criteres[1]);
					if (count($client_type) && $client_type[0] != "") {$query_where .= " && anc.type_client IN ( '".implode("','", $client_type)."' )";}
					
					$client_categ = explode(";", $criteres[2]);
					if (count($client_categ) && $client_categ[0] != "") {$query_where .= " && anc.id_client_categ IN ( ".implode(",", $client_categ)." )";}
					
					$client_cp = explode(";", $criteres[3]);
					if (count($client_cp) && $client_cp[0] != "") {
						$query_where .= " && ( ";
						for($j = 0; $j <count($client_cp); $j++) {
							if ( $j ) {$query_where .= " || " ;}
							$query_where .= " adr.code_postal LIKE '".$client_cp[$j]."%'";
						}
						$query_where .= " ) ";
						
					
					}
					$query = "SELECT TRIM(c.email)email, a.nom
										FROM coordonnees c
											LEFT JOIN annuaire a ON a.ref_contact = c.ref_contact
											LEFT JOIN adresses adr ON a.ref_contact = adr.ref_contact
											LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
											LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact 
											LEFT JOIN annu_client anc ON a.ref_contact = anc.ref_contact 
										WHERE c.email != '' && a.date_archivage IS NULL  && ap.id_profil  = '".$CLIENT_ID_PROFIL."' ".$query_where;
					$resultat = $bdd->query ($query);
					while ($tmp = $resultat->fetchObject()) { $liste_email[$tmp->email] = $tmp;}
				break;

				case $FOURNISSEUR_ID_PROFIL:
				
					$fourn_cat = explode(";", $criteres[0]);
					if (count($fourn_cat) && $fourn_cat[0] != "") {$query_where = " && af.id_fournisseur_categ IN ( ".implode(",", $fourn_cat)." )";}
					$query = "SELECT TRIM(c.email)email, a.nom
										FROM coordonnees c
											LEFT JOIN annuaire a ON a.ref_contact = c.ref_contact
											LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
											LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact 
											LEFT JOIN annu_fournisseur  af ON a.ref_contact = af.ref_fournisseur 
										WHERE c.email != '' && a.date_archivage IS NULL  && ap.id_profil  = '".$FOURNISSEUR_ID_PROFIL."' ".$query_where;
					$resultat = $bdd->query ($query);
					while ($tmp = $resultat->fetchObject()) { $liste_email[$tmp->email] = $tmp;}

				break;
				case $CONSTRUCTEUR_ID_PROFIL:
					$query = "SELECT TRIM(c.email)email, a.nom
										FROM coordonnees c
											LEFT JOIN annuaire a ON a.ref_contact = c.ref_contact
											LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
											LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact 
										WHERE c.email != '' && a.date_archivage IS NULL  && ap.id_profil  = '".$CONSTRUCTEUR_ID_PROFIL."' ";
					$resultat = $bdd->query ($query);
					while ($tmp = $resultat->fetchObject()) { $liste_email[$tmp->email] = $tmp;}
				break;
	
	
			}	
			
		}
		
	}
	
	
	$query = "SELECT TRIM(email)email, nom
						FROM newsletters_inscrits
						WHERE id_newsletter = '".$id_newsletter."' && inscrit = '1' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $liste_email[$tmp->email] = $tmp;}
	
	
	$query = "SELECT TRIM(email)email, nom
						FROM newsletters_inscrits
						WHERE id_newsletter = '".$id_newsletter."' && inscrit = '0' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { unset($liste_email[$tmp->email]);}

	return $liste_email;
}


//génération d'un code de sécurité pour les inscriptions et desincriptions à une newletter
function creer_code_unique ($email, $id_newsletter) {
	global $DIR;
	if (!file_exists($DIR."config/newsletter.config.php")){
		//vérification de l'existence du code sécurité de l'envoi de newsletter
		if(!$file_config_newsletter = @fopen ($DIR."config/newsletter.config.php", "w")){
			$erreur = "Impossible de créer le fichier de configuration config/newsletter.config.php ";
			return false;	// L'ERREUR N'EST PAS GEREE DANS CE CODE : Trouver un moyen propre de le faire proprement
		}else{
//Il est important de coller le code contre le bord de la page
$file_content = "<?php
// *************************************************************************************************************
// CODE DE SECURITE DE L'ENVOI DE NEWSLETTERS
// *************************************************************************************************************

\$CODE_SECU_NEWSLETTER = \"".rand(1000, 9999)."\"; 

?>";
			if (!fwrite ($file_config_newsletter, $file_content)) {
				$erreur = "Impossible d'écrire dans le fichier de configuration config/newsletter.config.php";
				return false;	// L'ERREUR N'EST PAS GEREE DANS CE CODE : Trouver un moyen propre de le faire proprement
			}
		}
		fclose ($file_config_newsletter);
	}
	require($DIR."config/newsletter.config.php");
	$code_unique = crypt($email."_".$id_newsletter, $CODE_SECU_NEWSLETTER);
	return $code_unique;
}

//vérification de la validité d'un code de sécurité
function verifier_code_unique ($code_unique, $email, $id_newsletter) {
	global $DIR;
	if (!file_exists($DIR."config/newsletter.config.php"))
	{		return false;}	// L'ERREUR N'EST PAS GEREE DANS LE CODE : Trouver un moyen propre de le faire proprement
											// Il n'est pas nécessaire de générer le fichier car dans tous les cas, le code ne sera pas vérifié
	require($DIR."config/newsletter.config.php");
	$code_unique2 = crypt ($email."_".$id_newsletter, $CODE_SECU_NEWSLETTER);
	if ($code_unique != $code_unique2)
	{		return false;}
	return true;
}

//charger contenu d'un envois de newsletter
function charger_envoi_newsletter ($id_envoi) {
	global $bdd;

	$query = "SELECT entete, contenu, pied, titre, date_envoi, id_newsletter 
						FROM newsletters_envois
						WHERE id_envoi = '".$id_envoi."'";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { 
		return $tmp;
	}

}

//mettre à jour l'état de lecture d'un email
function maj_envoi_lecture ($id_envoi, $email, $lecture = 1) {
	global $bdd;
	
	$query = "UPDATE newsletters_destinataires SET lecture = ".$lecture."
						WHERE id_envoi = '".$id_envoi."' && email = '".addslashes($email)."'
						";
	$bdd->exec ($query);
	
	return true;
	
}

//miseà jour de la durée de l'envoi
function duree_newsletter_envoi ($id_envoi) {
	global $bdd;
	
	$query = "UPDATE newsletters_envois SET fin_envoi = NOW()
						WHERE id_envoi = '".$id_envoi."'";
	$bdd->exec ($query);
	
	return true;
}





?>