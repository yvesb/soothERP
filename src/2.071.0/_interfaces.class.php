<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS D'une interface
// *************************************************************************************************************



class interfaces {
	private $id_interface;
	private $lib_interface;
	private $dossier;
	private $url;
	private $id_profil;
	private $defaut_id_theme;

function __construct ($id_interface = 0, $infos_interface) {
	global $bdd;

	// Controle si objet créé depuis une requete
	if (isset($infos_interface)) {
		$this->charger_from_object($infos_interface);
		return true;
	}

	if (!$id_interface || $is_numeric($id_interface)) { 
		return false;
	}

	$query = "SELECT id_interface, lib_interface, dossier, url, id_profil, defaut_id_theme
						FROM interfaces 
						WHERE id_interface = '".$id_interface."' ";
	$resultat = $bdd->query ($query);
	if (!$interfaces = $resultat->fetchObject()) {
		return false; 
	}

	$this->id_interface 	= $interfaces->id_interface;
	$this->lib_interface 	= $interfaces->lib_interface;
	$this->dossier 			= $interfaces->dossier;
	$this->url 				= $interfaces->url;
	$this->id_profil 		= $interfaces->id_profil;
	$this->defaut_id_theme = $interfaces->defaut_id_theme;

	return true;
}


function charger_from_object($interface) {	
	// Attribution des informations 
	$this->id_interface 	= $interface->id_interface;
	$this->lib_interface	= $interface->lib_interface;
	$this->dossier				= $interface->dossier;
	$this->url						= $interface->url;
	$this->id_profil			= $interface->id_profil;
	$this->defaut_id_theme	= $interface->defaut_id_theme;

	return true;
}


// Ajoute une nouvelle interface
public function create_interface ($id_interface, $lib_interface, $dossier, $url, $id_profil, $defaut_id_theme) {
	global $bdd;

	if ($lib_interface == "") {
			$GLOBALS['_ALERTES']['lib_interface'] = 1;
	}

	// *************************************************
	// Verification qu'il n'y a pas eu d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	$query = "INSERT INTO interfaces (id_interface, lib_interface, dossier, url, id_profil, defaut_id_theme)
						VALUES (".$id_interface.", '".addslashes($lib_interface)."', '".addslashes($dossier)."', '".addslashes($url)."', 
								'".num_or_null($id_profil)."', '".$num_or_null($defaut_id_theme)."'  ";
	$bdd->exec ($query);

	$this->id_interface 	= $bdd->lastInsertId();
	$this->lib_interface 	= $lib_interface;
	$this->dossier 			= $dossier;
	$this->url 				= $url;
	$this->id_profil 		= $id_profil;
	$this->defaut_id_theme 	= $defaut_id_theme;

	return true;
}



// *************************************************************************************************************
// Fonctions de modification
// *************************************************************************************************************
public function maj_interface  ($lib_interface, $url) {
	global $bdd;

	$query = "UPDATE interfaces 
 			  SET lib_interface = '".addslashes($lib_interface)."', url = '".addslashes($url)."'
				WHERE id_interface = '".$this->id_interface."' ";
	$bdd->exec ($query);

	$this->lib_interface 	= $lib_interface;
	$this->url 				= $url;

	return true;
}



// *************************************************************************************************************
// Fonctions de réception de données supplémentaires
// *************************************************************************************************************

//envoi du mail permettant à l'utilisateur de changer son mot de passe
function mdp_oublie($identifiant){
	global $bdd;
	global $REF_CONTACT_ENTREPRISE;
	global $SUJET_MDP_OUBLIE;
	global $CONTENU_MDP_OUBLIE;
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	
	$query = "SELECT u.ref_contact
				FROM users u
				JOIN coordonnees c ON c.ref_contact = u.ref_contact
				WHERE u.pseudo = '".$identifiant."'
				OR c.email = '".$identifiant."';";
	
	$resultat = $bdd->query ($query);
	if (!$annuaire_tmp = $resultat->fetchObject()) {
		return false; 
	}
	
	$email = $annuaire_tmp->email;
	
	$CONTENU_MDP_OUBLIE_2 = "
			<a href='".$_SERVER['HTTP_HOST'].$this->dossier."mdp_valide.php?modif=1&ref=".$identifiant."'>".$_SERVER['HTTP_HOST'].$this->dossier."mdp_valide.php?modif=1&ref=".$identifiant."</a>
			<br /><br />
			".$nom_entreprise."
			<br /><br />
			-------------------------------------------------------------------------------------------------------------------------<br />
			";
	
	$message = $CONTENU_MDP_OUBLIE.$CONTENU_MDP_OUBLIE_2;
	
	$this->envoi_email_templated ($email,$SUJET_MDP_OUBLIE,$message);
	
	return true;
}

// enregistrement d'un nouvel inscrit en attente de confirmation
public function inscription_contact($liste_reponse, $email) {
	global $bdd;
	global $INSCRIPTION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $CONTENU_INSCRIPTION_VALIDATION;
	global $SUJET_INSCRIPTION_VALIDATION;
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	
	$code_validation = creer_code_unique ($email, $this->id_interface) ;

	$query = "INSERT INTO annuaire_tmp (id_interface, infos, date_demande, code_validation, validation_email )
 						VALUES (".$this->id_interface.", '".addslashes(implode(";", $liste_reponse))."', NOW(), '".$code_validation."', 0)
					 ";
	$bdd->exec ($query);
	
	$id_contact_tmp = $bdd->lastInsertId();
	
	
	$CONTENU_INSCRIPTION_VALIDATION_2 = "http:".$_SERVER['HTTP_HOST'].str_replace($this->dossier."_inscription_envoi.php", "", $_SERVER['PHP_SELF']).$this->dossier."_inscription_valide.php?id_contact_tmp=".$id_contact_tmp."&code_validation=".$code_validation."
	 
	".$nom_entreprise."
	 
	-------------------------------------------------------------------------------------------------------------------------
	";
	
	$message = $CONTENU_INSCRIPTION_VALIDATION.$CONTENU_INSCRIPTION_VALIDATION_2;
	
	$this->envoi_email_templated ($email , $SUJET_INSCRIPTION_VALIDATION , $message );
	 
	return $message;
}

// enregistrement d'un nouvel inscrit en attente de confirmation
public function inscription_avec_valid($liste_reponse, $email) {
	global $bdd;
	global $INSCRIPTION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $CONTENU_INSCRIPTION_VALIDATION;
	global $SUJET_INSCRIPTION_VALIDATION;
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	$coordonnees_entreprise = $contact_entreprise->getCoordonnees();
	
	$i = 0;
	while (!$coordonnees_entreprise[$i]->getEmail()) {
		$i++;
	}
	$mail_entreprise = $coordonnees_entreprise[$i]->getEmail();
	
	$query = "INSERT INTO annuaire_tmp (id_interface, infos, date_demande, code_validation, validation_email )
 						VALUES (".$this->id_interface.", '".addslashes(implode(";", $liste_reponse))."', NOW(), '', 1)
					 ";
	$bdd->exec ($query);
	
	$SUJET_INSCRIPTION_AVEC_VALID = "Inscription sur ".$_SERVER['HTTP_HOST'];
	$CONTENU_INSCRIPTION_AVEC_VALID = "Bonjour et bienvenue,<br />
	Vous venez de vous inscrire sur notre site et nous vous en remercions.
	<br />
	<br />
	Un de nos collaborateurs va prochainement valider votre fiche. Vous recevrez alors un email de confirmation.<br />
	<br />
	<br />
	".$nom_entreprise."
	<br />
	<br />
	-------------------------------------------------------------------------------------------------------------------------<br />
	";
	
	$message = $CONTENU_INSCRIPTION_AVEC_VALID;
	
	$this->envoi_email_templated ($email , $SUJET_INSCRIPTION_AVEC_VALID , $message );
	
	
	$SUJET_INSCRIPTION_AVEC_VALID_2 = "Inscription sur ".$_SERVER['HTTP_HOST'];
	$CONTENU_INSCRIPTION_AVEC_VALID_2 = "Bonjour,<br />
	Un nouvel inscrit s'est enregistré sur ".$_SERVER['HTTP_HOST']."
	Vous devez valider son inscription à partir de votre interface collaborateur.
	<br />
	<br />
	<br />
	".$nom_entreprise."
	<br />
	<br />
	-------------------------------------------------------------------------------------------------------------------------<br />
	";
	
	$message_2 = $CONTENU_INSCRIPTION_AVEC_VALID_2;
	
	$this->envoi_email_templated ($mail_entreprise, $SUJET_INSCRIPTION_AVEC_VALID_2, $message_2);
	
	return true;
}

/*
 * Fonction permettant de valider l'inscription (commune aux différents modes de validation)
 */
function valider_inscription($liste_reponse){
	global $bdd;
	global $INSCRIPTION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $SUJET_INSCRIPTION_VALIDATION;
	global $CONTENU_INSCRIPTION_VALIDATION;
	global $SUJET_INSCRIPTION_VALIDATION_FINAL;
	global $CONTENU_INSCRIPTION_VALIDATION_FINAL;
	global $MAIL_ENVOI_INSCRIPTIONS;
	
	$infos_generales['id_civilite']	= "";
	if (isset($liste_reponse['civilite'])) { 
		$infos_generales['id_civilite'] = $liste_reponse['civilite'];
	}
	
	$infos_generales['nom'] = "";
	if (isset($liste_reponse['nom'])) {
		$infos_generales['nom'] = $liste_reponse['nom'];
	}
	$infos_generales['siret'] = "";
	if (isset($liste_reponse['siret'])) {
		$infos_generales['siret']  = $liste_reponse['siret'];
	}
	$infos_generales['tva_intra'] = "";
	if (isset($liste_reponse['tva_intra'])) {
		$infos_generales['tva_intra'] = $liste_reponse['tva_intra'];
	}
	$infos_generales['id_categorie'] = "";
	if (isset($liste_reponse['id_categorie'])) {
		$infos_generales['id_categorie'] = $liste_reponse['id_categorie'];
	}
	$infos_generales['note'] = "";
	if (isset($liste_reponse['note'])) {
		$infos_generales['note']  = $liste_reponse['note'];
	}
	
	$infos_generales['adresses']		= array();
	$infos_generales['coordonnees']		= array();
	$infos_generales['sites']			= array();
	
	if (isset($liste_reponse['livraison_adresse'])) {
		$infos_generales['adresses'][] = array('lib_adresse' => "", 'text_adresse' => $liste_reponse['livraison_adresse'], 'code_postal' => $liste_reponse['livraison_code'], 'ville' =>  $liste_reponse['livraison_ville'], 'id_pays' => $liste_reponse['id_pays_livraison'], 'note' => "");		
	}
	
	if (isset($liste_reponse['adresse_adresse'])) {
		$infos_generales['adresses'][] = array('lib_adresse' => "", 'text_adresse' => $liste_reponse['adresse_adresse'], 'code_postal' => $liste_reponse['adresse_code'], 'ville' =>  $liste_reponse['adresse_ville'], 'id_pays' => $liste_reponse['id_pays_contact'], 'note' => "");		
	}

	if (isset($liste_reponse['coordonnee_tel1'])) {
		$infos_generales['coordonnees'][]	= array('lib_coord' => "", 'tel1' => $liste_reponse['coordonnee_tel1'], 'tel2' => $liste_reponse['coordonnee_tel2'], 'fax' => $liste_reponse['coordonnee_fax'], 'email' => $liste_reponse['admin_emaila'], 'note' => "", 'ref_coord_parent' => NULL, 'email_user_creation' => 0 );
	}
	
	$infos_profils = array();
	if (isset($liste_reponse['profils_inscription'])) {
		if (is_array($liste_reponse['profils_inscription'])) {
			foreach ($liste_reponse['profils_inscription'] as $id_profil) {
				if (!isset($_SESSION['profils'][$id_profil])) { continue; }
				$infos_profils[$id_profil]['id_profil'] = $id_profil;
				include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
			}
		} else {
			if (isset($_SESSION['profils'][$liste_reponse['profils_inscription']])) {
				$infos_profils[$liste_reponse['profils_inscription']]['id_profil'] = $liste_reponse['profils_inscription'];
				$id_profil = $liste_reponse['profils_inscription'];
				include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
			}
		}
	}
	
	// *************************************************
	// Création du contact
	$contact = new contact ();
	$contact->create ($infos_generales, $infos_profils);
	
	$coord = $contact->getCoordonnees ();
	// Générer un utilisateur pour ce contact
	if (isset($coord[0])) {
		$utilisateur = new utilisateur ();
		$utilisateur->create ($contact->getRef_contact(), $coord[0]->getRef_coord (), $liste_reponse['admin_pseudo'], 1,  $liste_reponse['admin_passworda'], 1);
		
		// Connecter l'utilisateur
		$_SESSION['user']->login ($liste_reponse['admin_pseudo'], $liste_reponse['admin_passworda'], "", $liste_reponse['profils_inscription']);
	}
	return true;
}


/*
 * Validation de l'inscription depuis le panier
 */
function inscription_valide_panier ($liste_reponse, $email) {
	global $bdd;
	global $INSCRIPTION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $SUJET_INSCRIPTION_VALIDATION;
	global $CONTENU_INSCRIPTION_VALIDATION;
	global $SUJET_INSCRIPTION_VALIDATION_FINAL;
	global $CONTENU_INSCRIPTION_VALIDATION_FINAL;
	global $MAIL_ENVOI_INSCRIPTIONS;
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	
	if ($INSCRIPTION_ALLOWED == 2 ) {
		$this->valider_inscription($liste_reponse);
		
		//confirmation de l'inscription par email et rappel des identifiants
		$CONTENU_INSCRIPTION_VALIDATION_FINAL_2 = "<br />
		Votre identifiant: ".$liste_reponse['admin_pseudo']." ou ".$liste_reponse['admin_emaila']."<br />
		Votre mot de passe: ".$liste_reponse['admin_passworda']."
		 <br /><br />
		".$nom_entreprise."
		 <br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
		$message = $CONTENU_INSCRIPTION_VALIDATION_FINAL.$CONTENU_INSCRIPTION_VALIDATION_FINAL_2;
		$this->envoi_email_templated ($email, $SUJET_INSCRIPTION_VALIDATION_FINAL , $message );
		return true;
	}
	return false;

}

function inscription_valide ($id_contact_tmp, $code ) {
	global $bdd;
	global $INSCRIPTION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $SUJET_INSCRIPTION_VALIDATION;
	global $CONTENU_INSCRIPTION_VALIDATION;
	global $SUJET_INSCRIPTION_VALIDATION_FINAL;
	global $CONTENU_INSCRIPTION_VALIDATION_FINAL;
	global $MAIL_ENVOI_INSCRIPTIONS;
	
	$query = "SELECT id_contact_tmp, infos, date_demande, code_validation, validation_email
						FROM annuaire_tmp  
						WHERE id_contact_tmp = '".$id_contact_tmp."' ";
	$resultat = $bdd->query ($query);
	if (!$annuaire_tmp = $resultat->fetchObject()) {
		return false; 
	}
	$annuaire_resultat = array();
	$tmp_resultat_ann = explode (";",$annuaire_tmp->infos);
	foreach ($tmp_resultat_ann as $tmp_ann) {
		$tmp = explode("=", $tmp_ann);
		if (count($tmp)==2) {
			$annuaire_resultat[$tmp[0]] = $tmp[1];
			if ($tmp[0] == "admin_emaila") {$email = $tmp[1];}
		}
	}
	
	//si le code est bon on valide l'inscription
	if (verifier_code_unique ($code, $email, $this->id_interface)) {
		// si inscription auto on cré le contact on cré l'user, on log l'utilisateur, on vire le tmp
		if ($INSCRIPTION_ALLOWED == 2 ) {
			$this->valider_inscription($annuaire_resultat);
			
			//supprimer l'inscription	
			$this->supprimer_inscription ($id_contact_tmp);
			
			//confirmation de l'inscription par email et rappel des identifiants
			$CONTENU_INSCRIPTION_VALIDATION_FINAL_2 = "<br />
			Votre identifiant: ".$annuaire_resultat['admin_pseudo']." ou ".$annuaire_resultat['admin_emaila']."<br />
			Votre mot de passe: ".$annuaire_resultat['admin_passworda']."<br /><br />
			http:".$_SERVER['HTTP_HOST'].str_replace($this->dossier."_inscription_valide.php", "", $_SERVER['PHP_SELF'])."
			 <br /><br />
			".$nom_entreprise."
			 <br />
			-------------------------------------------------------------------------------------------------------------------------<br />
			";
			$message = $CONTENU_INSCRIPTION_VALIDATION_FINAL.$CONTENU_INSCRIPTION_VALIDATION_FINAL_2;
			$this->envoi_email_templated ($coord[0]->getEmail() , $SUJET_INSCRIPTION_VALIDATION_FINAL , $message );
			return true;
		}
		
		//si inscription auto, on met le tmp en valide, on envoie un mail aux collab désignés pour la validation
		if ($INSCRIPTION_ALLOWED == 1 ) {
			if ($MAIL_ENVOI_INSCRIPTIONS){
			$this->envoi_email_templated ($MAIL_ENVOI_INSCRIPTIONS , "Nouvelle inscription sur le site" , "Rendez-vous dans l'interface Collaborateur > Annuaire > Valider les inscriptions.   pour confirmer les nouvelles inscriptions" );
			}
			$query = "UPDATE annuaire_tmp  SET validation_email = 1
								WHERE id_contact_tmp = '".$id_contact_tmp."' ";
			$bdd->exec ($query);
			return true;
		}
	}
	return false;
}


function inscription_contact_valide ($id_contact_tmp) {
	global $bdd;
	global $INSCRIPTION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $SUJET_INSCRIPTION_VALIDATION;
	global $CONTENU_INSCRIPTION_VALIDATION;
	global $SUJET_INSCRIPTION_VALIDATION_FINAL;
	global $CONTENU_INSCRIPTION_VALIDATION_FINAL;
	global $MAIL_ENVOI_INSCRIPTIONS;


	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));

	$query = "SELECT id_contact_tmp, infos, date_demande, code_validation, validation_email
						FROM annuaire_tmp  
						WHERE id_contact_tmp = '".$id_contact_tmp."' ";
	$resultat = $bdd->query ($query);
	if (!$annuaire_tmp = $resultat->fetchObject()) {
		return false; 
	}
	
	$annuaire_resultat = array();
	$tmp_resultat_ann = explode (";",$annuaire_tmp->infos);
	foreach ($tmp_resultat_ann as $tmp_ann) {
		$tmp = explode("=", $tmp_ann);
		if (count($tmp)==2) {
			$annuaire_resultat[$tmp[0]] = $tmp[1];
			if ($tmp[0] == "admin_emaila") {$email = $tmp[1];}
			if ($tmp[0] == "ref_contact") {$ref_contact = $tmp[1];}
		}
	}
	$infos_generales['id_civilite']		= "";
			if (isset($annuaire_resultat['civilite'])) { $infos_generales['id_civilite'] = $annuaire_resultat['civilite']; }
			
			$infos_generales['nom'] 					= "";
			if (isset($annuaire_resultat['nom'])) { $infos_generales['nom']  = $annuaire_resultat['nom']; }
			$infos_generales['siret'] 					= "";
			if (isset($annuaire_resultat['siret'])) { $infos_generales['siret']  = $annuaire_resultat['siret']; }
			$infos_generales['tva_intra'] 					= "";
			if (isset($annuaire_resultat['tva_intra'])) { $infos_generales['tva_intra']  = $annuaire_resultat['tva_intra']; }
			$infos_generales['id_categorie'] 					= "";
			if (isset($annuaire_resultat['id_categorie'])) { $infos_generales['id_categorie']  = $annuaire_resultat['id_categorie']; }
			$infos_generales['note'] 					= "";
			if (isset($annuaire_resultat['note'])) { $infos_generales['note']  = $annuaire_resultat['note']; }
			
			$infos_generales['adresses']			= array();
			$infos_generales['coordonnees']		= array();
			$infos_generales['sites']					= array();
			
			if (isset($annuaire_resultat['livraison_adresse'])) {
				$infos_generales['adresses'][] = array('lib_adresse' => "", 'text_adresse' => $annuaire_resultat['livraison_adresse'], 'code_postal' => $annuaire_resultat['livraison_code'], 'ville' =>  $annuaire_resultat['livraison_ville'], 'id_pays' => $annuaire_resultat['id_pays_livraison'], 'note' => "");		
			}
			
			if (isset($annuaire_resultat['adresse_adresse'])) {
				$infos_generales['adresses'][] = array('lib_adresse' => "", 'text_adresse' => $annuaire_resultat['adresse_adresse'], 'code_postal' => $annuaire_resultat['adresse_code'], 'ville' =>  $annuaire_resultat['adresse_ville'], 'id_pays' => $annuaire_resultat['id_pays_contact'], 'note' => "");		
			}
	
			if (isset($annuaire_resultat['coordonnee_tel1'])) {
				$infos_generales['coordonnees'][]	= array('lib_coord' => "", 'tel1' => $annuaire_resultat['coordonnee_tel1'], 'tel2' => $annuaire_resultat['coordonnee_tel2'], 'fax' => $annuaire_resultat['coordonnee_fax'], 'email' => $annuaire_resultat['admin_emaila'], 'note' => "", 'ref_coord_parent' => NULL, 'email_user_creation' => 0 );
			}
			
				
			$infos_profils = array();
			if (isset($annuaire_resultat['profils_inscription'])) {
				if (is_array($annuaire_resultat['profils_inscription'])) {
					foreach ($annuaire_resultat['profils_inscription'] as $id_profil) {
						if (!isset($_SESSION['profils'][$id_profil])) { continue; }
						$infos_profils[$id_profil]['id_profil'] = $id_profil;
						include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
					}
				} else {
					if (!isset($_SESSION['profils'][$annuaire_resultat['profils_inscription']])) {
						$infos_profils[$annuaire_resultat['profils_inscription']]['id_profil'] = $annuaire_resultat['profils_inscription'];
						include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
					}
				}
			}
			
			// *************************************************
			// Création du contact
			$contact = new contact ();
			$contact->create ($infos_generales, $infos_profils);
			
			$coord = $contact->getCoordonnees ();
			//générer un utilisateur pour ce contact
			if (isset($coord[0])) {
			
				$utilisateur = new utilisateur ();
				$utilisateur->create ($contact->getRef_contact(), $coord[0]->getRef_coord (), $annuaire_resultat['admin_pseudo'], 1,  $annuaire_resultat['admin_passworda'], 1);
			
			
				//connecter l'utilisateur
				$_SESSION['user']->login ($annuaire_resultat['admin_pseudo'], $annuaire_resultat['admin_passworda'], "", $annuaire_resultat['profils_inscription']);
			}
			
			
			//supprimer l'inscription	
			$this->supprimer_inscription ($id_contact_tmp);
			
			
			//confirmation de l'inscription par email et rappel des identifiants
			$CONTENU_INSCRIPTION_VALIDATION_FINAL_2 = "
			Votre identifiant: ".$annuaire_resultat['admin_pseudo']." ou ".$annuaire_resultat['admin_emaila']."
			Votre mot de passe: ".$annuaire_resultat['admin_passworda']."
			
			http:".$_SERVER['HTTP_HOST'].str_replace($this->dossier."_inscription_valide.php", "", $_SERVER['PHP_SELF'])."
			 
			".$nom_entreprise."
			 
			-------------------------------------------------------------------------------------------------------------------------
			";
			
			$message = $CONTENU_INSCRIPTION_VALIDATION_FINAL.$CONTENU_INSCRIPTION_VALIDATION_FINAL_2;
			
			$this->envoi_email_templated ($coord[0]->getEmail() , $SUJET_INSCRIPTION_VALIDATION_FINAL , $message );
	 
			return true;
}


function valider_inscription_contact ($id_contact_tmp) {
	global $bdd;
	global $INSCRIPTION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $SUJET_INSCRIPTION_VALIDATION;
	global $CONTENU_INSCRIPTION_VALIDATION;
	global $SUJET_INSCRIPTION_VALIDATION_FINAL;
	global $CONTENU_INSCRIPTION_VALIDATION_FINAL;
	global $MAIL_ENVOI_INSCRIPTIONS;


	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));

	$query = "SELECT id_contact_tmp, infos, date_demande, code_validation, validation_email
						FROM annuaire_tmp  
						WHERE id_contact_tmp = '".$id_contact_tmp."' ";
	$resultat = $bdd->query ($query);
	if (!$annuaire_tmp = $resultat->fetchObject()) {
		return false; 
	}
	
	$annuaire_resultat = array();
	$tmp_resultat_ann = explode (";",$annuaire_tmp->infos);
	foreach ($tmp_resultat_ann as $tmp_ann) {
		$tmp = explode("=", $tmp_ann);
		if (count($tmp)==2) {
			$annuaire_resultat[$tmp[0]] = $tmp[1];
			if ($tmp[0] == "admin_emaila") {$email = $tmp[1];}
			if ($tmp[0] == "ref_contact") {$ref_contact = $tmp[1];}
		}
	}
	$infos_generales['id_civilite']		= "";
			if (isset($annuaire_resultat['civilite'])) { $infos_generales['id_civilite'] = $annuaire_resultat['civilite']; }
			
			$infos_generales['nom'] 					= "";
			if (isset($annuaire_resultat['nom'])) { $infos_generales['nom']  = $annuaire_resultat['nom']; }
			$infos_generales['siret'] 					= "";
			if (isset($annuaire_resultat['siret'])) { $infos_generales['siret']  = $annuaire_resultat['siret']; }
			$infos_generales['tva_intra'] 					= "";
			if (isset($annuaire_resultat['tva_intra'])) { $infos_generales['tva_intra']  = $annuaire_resultat['tva_intra']; }
			$infos_generales['id_categorie'] 					= "";
			if (isset($annuaire_resultat['id_categorie'])) { $infos_generales['id_categorie']  = $annuaire_resultat['id_categorie']; }
			$infos_generales['note'] 					= "";
			if (isset($annuaire_resultat['note'])) { $infos_generales['note']  = $annuaire_resultat['note']; }
			
			$infos_generales['adresses']			= array();
			$infos_generales['coordonnees']		= array();
			$infos_generales['sites']					= array();
			
			if (isset($annuaire_resultat['livraison_adresse'])) {
				$infos_generales['adresses'][] = array('lib_adresse' => "", 'text_adresse' => $annuaire_resultat['livraison_adresse'], 'code_postal' => $annuaire_resultat['livraison_code'], 'ville' =>  $annuaire_resultat['livraison_ville'], 'id_pays' => $annuaire_resultat['id_pays_livraison'], 'note' => "");		
			}
			
			if (isset($annuaire_resultat['adresse_adresse'])) {
				$infos_generales['adresses'][] = array('lib_adresse' => "", 'text_adresse' => $annuaire_resultat['adresse_adresse'], 'code_postal' => $annuaire_resultat['adresse_code'], 'ville' =>  $annuaire_resultat['adresse_ville'], 'id_pays' => $annuaire_resultat['id_pays_contact'], 'note' => "");		
			}
	
			if (isset($annuaire_resultat['coordonnee_tel1'])) {
				$infos_generales['coordonnees'][]	= array('lib_coord' => "", 'tel1' => $annuaire_resultat['coordonnee_tel1'], 'tel2' => $annuaire_resultat['coordonnee_tel2'], 'fax' => $annuaire_resultat['coordonnee_fax'], 'email' => $annuaire_resultat['admin_emaila'], 'note' => "", 'ref_coord_parent' => NULL, 'email_user_creation' => 0 );
			}
			
			$infos_profils = array();
			if (isset($annuaire_resultat['profils_inscription'])) {
				if (is_array($annuaire_resultat['profils_inscription'])) {
					foreach ($annuaire_resultat['profils_inscription'] as $id_profil) {
						if (!isset($_SESSION['profils'][$id_profil])) { continue; }
						$infos_profils[$id_profil]['id_profil'] = $id_profil;
						include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
					}
				} else {
					if (isset($_SESSION['profils'][$annuaire_resultat['profils_inscription']])) {
						$infos_profils[$annuaire_resultat['profils_inscription']]['id_profil'] = $annuaire_resultat['profils_inscription'];
						$id_profil = $annuaire_resultat['profils_inscription'];
						$infos_profils[$id_profil]['id_client_categ'] 		=  "1";
						$infos_profils[$id_profil]['type_client'] 			=  "client";
						$infos_profils[$id_profil]['id_tarif'] 				=  "1";
						$infos_profils[$id_profil]['ref_adr_livraison'] 	=  "";
						$infos_profils[$id_profil]['ref_adr_facturation']	=  "";
						$infos_profils[$id_profil]['app_tarifs'] 			=  "HT";
						$infos_profils[$id_profil]['facturation_periodique'] 	=  "0";
						$infos_profils[$id_profil]['encours']				=  "0";
						$infos_profils[$id_profil]['delai_reglement'] 		=  "";
						$infos_profils[$id_profil]['ref_commercial'] 		=  "";
						//include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
					}
				}
			}
			
			// *************************************************
			// Création du contact
			$contact = new contact ();
			$contact->create ($infos_generales, $infos_profils);
			
			$coord = $contact->getCoordonnees ();
			
			//confirmation de l'inscription par email et rappel des identifiants
			$SUJET_VALIDATION_INSCRIPTION = "Inscription sur ".$_SERVER['HTTP_HOST'];
			
			$CONTENU_VALIDATION_INSCRIPTION = "Bonjour,<br />
			<br />
			Votre compte client sur ".$_SERVER['HTTP_HOST']." vient d&ecirc;tre activ&eacute;.<br />
			<br />
			Rappel de vos identifiants : <br />
			Votre identifiant: ".$annuaire_resultat['admin_pseudo']." ou ".$annuaire_resultat['admin_emaila']."<br />
			Votre mot de passe: ".$annuaire_resultat['admin_passworda']."<br />
			<br />
			Vous pouvez maintenant vous connecter sur <a href='http://".$_SERVER['HTTP_HOST']."'>".$_SERVER['HTTP_HOST']."</a><br />
			A tr&egrave;s bient&ocirc;t sur notre site!<br />
			<br />
			Nous vous conseillons de conserver cet e-mail.<br />
			<br />
			".$nom_entreprise."<br />
			<br />
			-------------------------------------------------------------------------------------------------------------------------<br />
			";
			
			$message = $CONTENU_VALIDATION_INSCRIPTION;
			
			
			//générer un utilisateur pour ce contact
			if (isset($coord[0])) {
			
				$utilisateur = new utilisateur ();
				$utilisateur->create ($contact->getRef_contact(), $coord[0]->getRef_coord (), $annuaire_resultat['admin_pseudo'], 1,  $annuaire_resultat['admin_passworda'], 1);
				
				//connecter l'utilisateur
				//$_SESSION['user']->login ($annuaire_resultat['admin_pseudo'], $annuaire_resultat['admin_passworda'], "", $annuaire_resultat['profils_inscription']);
				
				$this->envoi_email_templated ($coord[0]->getEmail() , $SUJET_VALIDATION_INSCRIPTION , $message );
			}
			
			
			//supprimer l'inscription	
			$this->supprimer_inscription ($id_contact_tmp);
			
			return true;
}



// enregistrement des modifications d'un inscrit
public function modification_contact ($liste_reponse, $ref_contact, $email) {
	global $bdd;
	global $MODIFICATION_ALLOWED;
	global $REF_CONTACT_ENTREPRISE;
	global $CONTENU_MODIFICATION_VALIDATION;
	global $SUJET_MODIFICATION_VALIDATION;
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	
	$contact = new contact ($ref_contact);
	$liste_coordonnees = $contact->getCoordonnees();
	
	
	$code_validation = creer_code_unique ($email, $this->id_interface) ;

	$query = "INSERT INTO annuaire_tmp (id_interface, infos, date_demande, code_validation, validation_email, mode )
 						VALUES (".$this->id_interface.", '".addslashes(implode(";", $liste_reponse))."', NOW(), '".$code_validation."', 0, 'modification')
					 ";
	$bdd->exec ($query);
	
	$id_contact_tmp = $bdd->lastInsertId();
	
	
	if ($liste_coordonnees[0]->getEmail() != $email) {
		$CONTENU_MODIFICATION_VALIDATION_2 = "http:".$_SERVER['HTTP_HOST'].str_replace($this->dossier."_inscription_envoi.php", "", $_SERVER['PHP_SELF']).$this->dossier."_modification_valide.php?id_contact_tmp=".$id_contact_tmp."&code_validation=".$code_validation."
		 
		".$nom_entreprise."
		 
		-------------------------------------------------------------------------------------------------------------------------
		";
		$message = $CONTENU_MODIFICATION_VALIDATION.$CONTENU_MODIFICATION_VALIDATION_2;
		
		$this->envoi_email_templated ($email , $SUJET_MODIFICATION_VALIDATION , $message );
		
		$GLOBALS['_INFOS']["mail_change"] = 1;
	} else {
		if ($MODIFICATION_ALLOWED == 1) {
			$GLOBALS['_INFOS']["verification_collab"] = 1;
			$this->modification_contact_confirmation ($id_contact_tmp, $code_validation);
		}
		if ($MODIFICATION_ALLOWED == 2) {
			$this->modification_contact_valide ($id_contact_tmp);
		}
	}
	 
	return true;

}

function modification_contact_confirmation ($id_contact_tmp, $code_validation) {
	global $bdd;
	global $MAIL_ENVOI_INSCRIPTIONS;
	
	$query = "SELECT id_contact_tmp, infos, date_demande, code_validation, validation_email
						FROM annuaire_tmp  
						WHERE id_contact_tmp = '".$id_contact_tmp."' ";
	$resultat = $bdd->query ($query);
	if (!$annuaire_tmp = $resultat->fetchObject()) {
		return false; 
	}
	$annuaire_resultat = array();
	$tmp_resultat_ann = explode (";",$annuaire_tmp->infos);
	foreach ($tmp_resultat_ann as $tmp_ann) {
		$tmp = explode("=", $tmp_ann);
		if (count($tmp)==2) {
			$annuaire_resultat[$tmp[0]] = $tmp[1];
			if ($tmp[0] == "admin_emaila") {$email = $tmp[1];}
		}
	}
	
	if (verifier_code_unique ($code_validation, $email, $this->id_interface)) {
		//confirmation de l'inscription
		$query = "UPDATE annuaire_tmp  SET validation_email = 1
							WHERE id_contact_tmp = '".$id_contact_tmp."' ";
		$bdd->exec ($query);
		
		//mail au collaborateurs
		if ($MAIL_ENVOI_INSCRIPTIONS){
			$this->envoi_email_templated ($MAIL_ENVOI_INSCRIPTIONS , "Nouvelle inscription sur le site" , "Rendez-vous dans l'interface Collaborateur > Annuaire > Valider les inscriptions.   pour confirmer les nouvelles inscriptions" );
		}
	}

}

function modification_contact_valide ($id_contact_tmp) {
	global $bdd;
	global $MODIFICATION_ALLOWED;
	global $SUJET_MODIFICATION_VALIDATION_FINAL;
	global $CONTENU_MODIFICATION_VALIDATION_FINAL;
	global $CLIENT_ID_PROFIL;

	$query = "SELECT id_contact_tmp, infos, date_demande, code_validation, validation_email
						FROM annuaire_tmp  
						WHERE id_contact_tmp = '".$id_contact_tmp."' ";
	$resultat = $bdd->query ($query);
	if (!$annuaire_tmp = $resultat->fetchObject()) {
		return false; 
	}
	
	$annuaire_resultat = array();
	$tmp_resultat_ann = explode (";",$annuaire_tmp->infos);
	foreach ($tmp_resultat_ann as $tmp_ann) {
		$tmp = explode("=", $tmp_ann);
		if (count($tmp)==2) {
			$annuaire_resultat[$tmp[0]] = $tmp[1];
			if ($tmp[0] == "admin_emaila") {$email = $tmp[1];}
			if ($tmp[0] == "ref_contact") {$ref_contact = $tmp[1];}
		}
	}
	
	//modification des infos du contact
	$contact = new contact ($ref_contact);
	
	$profil_client = $contact->getProfil ($CLIENT_ID_PROFIL);
	
	$infos_generales = array();
	$infos_profils= array();
	$infos_generales['id_civilite']		= $contact->getId_civilite();
	if (isset($annuaire_resultat['civilite'])) { $infos_generales['id_civilite'] = $annuaire_resultat['civilite']; }
	
	$infos_generales['nom'] 					= $contact->getNom();
	if (isset($annuaire_resultat['nom'])) { $infos_generales['nom']  = $annuaire_resultat['nom']; }
	$infos_generales['siret'] 					= $contact->getSiret();
	if (isset($annuaire_resultat['siret'])) { $infos_generales['siret']  = $annuaire_resultat['siret']; }
	$infos_generales['tva_intra'] 					= $contact->getTva_intra();
	if (isset($annuaire_resultat['tva_intra'])) { $infos_generales['tva_intra']  = $annuaire_resultat['tva_intra']; }
	$infos_generales['id_categorie'] 					= $contact->getId_categorie();
	if (isset($annuaire_resultat['id_categorie'])) { $infos_generales['id_categorie']  = $annuaire_resultat['id_categorie']; }
	
	
	
	if (isset($annuaire_resultat['ref_adr_livraison']) && isset($annuaire_resultat['ref_adr_facturation'])) {
	
		if ($annuaire_resultat['ref_adr_livraison'] && $annuaire_resultat['ref_adr_facturation'] != $annuaire_resultat['ref_adr_livraison']  ) {
			$adresse = new adresse ($annuaire_resultat['ref_adr_livraison']);
			$adresse->modification($adresse->getLib_adresse (), $annuaire_resultat['livraison_adresse'],  $annuaire_resultat['livraison_code'], $annuaire_resultat['livraison_ville'], $annuaire_resultat['id_pays_livraison'], $adresse->getNote ());
		} else {
			$adresse = new adresse ();
			$adresse->create ($ref_contact, "", $annuaire_resultat['livraison_adresse'], $annuaire_resultat['livraison_code'], $annuaire_resultat['livraison_ville'], $annuaire_resultat['id_pays_livraison'], "");
			if (isset($GLOBALS['_INFOS']['Création_adresse'])) {
				$profil_client->maj_ref_adr_livraison($GLOBALS['_INFOS']['Création_adresse']);
				unset ($GLOBALS['_INFOS']['Création_adresse']);
			}
		}
		unset($adresse);
		
		
		if ($annuaire_resultat['ref_adr_facturation'] && ($annuaire_resultat['ref_adr_facturation'] != $annuaire_resultat['ref_adr_livraison'] || !$annuaire_resultat['ref_adr_livraison']) ) {
			$adresse = new adresse ($annuaire_resultat['ref_adr_facturation']);
			$adresse->modification($adresse->getLib_adresse (), $annuaire_resultat['adresse_adresse'],  $annuaire_resultat['adresse_code'], $annuaire_resultat['adresse_ville'], $annuaire_resultat['id_pays_contact'], $adresse->getNote ());
		} else {
			$adresse = new adresse ();
			$adresse->create ($ref_contact, "", $annuaire_resultat['adresse_adresse'], $annuaire_resultat['adresse_code'], $annuaire_resultat['adresse_ville'], $annuaire_resultat['id_pays_contact'], "");
			if (isset($GLOBALS['_INFOS']['Création_adresse'])) {
				$profil_client->maj_ref_adr_facturation($GLOBALS['_INFOS']['Création_adresse']);
				unset ($GLOBALS['_INFOS']['Création_adresse']);
			}
		}
	}

	if (isset($annuaire_resultat['ref_coordonnee'])) {
		if ($annuaire_resultat['ref_coordonnee']) {
			$coordonnee = new coordonnee ($annuaire_resultat['ref_coordonnee']);
			$coordonnee->modification ($coordonnee->getLib_coord(), $annuaire_resultat['coordonnee_tel1'], $annuaire_resultat['coordonnee_tel2'], $annuaire_resultat['coordonnee_fax'], $annuaire_resultat['admin_emaila'], $coordonnee->getNote(), "");
		} else {
			$coordonnee = new coordonnee ($annuaire_resultat['ref_coordonnee']);
			$coordonnee->create ($ref_contact, "", $annuaire_resultat['coordonnee_tel1'], $annuaire_resultat['coordonnee_tel2'], $annuaire_resultat['coordonnee_fax'], $annuaire_resultat['admin_emaila'], "", "", 0);
		}
	
	}
	$contact->modification ($infos_generales, $infos_profils);
	
		
	$infos_profils = array();
	
	//supprimer l'inscription	
	$this->supprimer_inscription ($id_contact_tmp);
	
	//envoi email confirmation au contact si validation par collab
	if ($MODIFICATION_ALLOWED == 1) {
		//confirmation par email et rappel des identifiants	
					
		$CONTENU_INSCRIPTION_VALIDATION_FINAL_2 = "
		Votre identifiant: ".$annuaire_resultat['admin_pseudo']." ou ".$annuaire_resultat['admin_emaila']."
		Votre mot de passe: ".$annuaire_resultat['admin_passworda']."
		".$nom_entreprise."
		 
		-------------------------------------------------------------------------------------------------------------------------
		";
		$message = $CONTENU_MODIFICATION_VALIDATION_FINAL.$CONTENU_MODIFICATION_VALIDATION_FINAL_2;
		$this->envoi_email_templated ($email , $SUJET_MODIFICATION_VALIDATION_FINAL , $message );
	}
	return true;
}


	//supprimer l'inscription	
function supprimer_inscription ($id_contact_tmp) {
	global $bdd;
	$query = "DELETE FROM annuaire_tmp  
						WHERE id_contact_tmp = '".$id_contact_tmp."' ";
	$bdd->exec ($query);
	
}

//fonction d'envoi des mail avec template
function envoi_email_templated ($to, $sujet, $message) {
	// Envoi de l'email
	$mail = new email();
	$mail->prepare_envoi(0, 1);
	return $mail->envoi_email_templated ($to, $sujet, $message);
}

// *************************************************************************************************************
// Fonctions d'accès aux données
// *************************************************************************************************************

// Retourne l'identifiant du id_interface
final public function getId_interface () {
	return $this->id_interface;
}

// Retourne lib_interface
final public function getLib_interface () {
	return $this->lib_interface;
}


// Retourne le dossier
final public function getDossier () {
	return $this->dossier;
}

// Retourne l'url
final public function getUrl () {
	return $this->url;
}
// Retourne l'identifiant du profil
final public function getId_profil () {
	return $this->id_profil;
}


// Retourne defaut_id_theme
final public function getDefaut_id_theme () {
	return $this->defaut_id_theme;
}


}

//chargement de la liste des interfaces
function charger_all_interfaces () {
	global $bdd;
	
	$interfaces_liste = array();

	$query = "SELECT id_interface, dossier, url, lib_interface, id_profil, defaut_id_theme
						FROM interfaces  ";
	$resultat = $bdd->query ($query);
	while ($interface = $resultat->fetchObject()) {
		$interfaces_liste[] = $interface; 
	}
	return $interfaces_liste;
}


// Charge la liste des documents en cours
function get_liste_doc($id_type_doc, $liste_id_etat_doc, $ref_contact ) {
	global $bdd;
	
	$documents = array();
	$query = "SELECT d.ref_doc
						FROM documents d 
						WHERE d.id_type_doc = '".$id_type_doc."' ";
	if($liste_id_etat_doc != ""){
		$query .= " && d.id_etat_doc IN (".$liste_id_etat_doc.") "; 
	}
	$query .= " && ref_contact = '". $ref_contact ."'
						GROUP BY d.ref_doc
						ORDER BY d.id_etat_doc ASC, d.date_creation_doc DESC ";
	$resultat = $bdd->query ($query);
	
	while ($doc = $resultat->fetchObject()) {
		$documents[] = open_doc($doc->ref_doc);
	}

	return $documents;
}

function loadValidInProgress($email = 1, $id = null) {
  global $bdd;
  
  $query = "SELECT id_contact_tmp, id_interface, infos, date_demande, code_validation, validation_email, mode
  			FROM annuaire_tmp";
  if ($email != 2 && $id == null)
    $query .= " WHERE validation_email='".$email."'";
  if ($id != null)
    $query .= " WHERE id_contact_tmp='".$id."'";
  $query .= ";";
  $res = $bdd->query($query);
  $wait_valids = array();
  $wait_modifs = array();
  while ($tmp = $res->fetchObject()) { if (strpos($tmp->infos, "ref_contact") < 0) $wait_valids[] = $tmp;  else $wait_modifs[] = $tmp; }
  foreach ($wait_valids as &$wait_valid) {
    $infos = explode(";", $wait_valid->infos);
    $tab_tmp = array();
    foreach ($infos as $info) {
      $tab_tmp2 = explode("=", $info);
      $tab_tmp[$tab_tmp2[0]] = (isset($tab_tmp2[1])) ? $tab_tmp2[1] : "";
    }
    $wait_valid->infos = $tab_tmp;
  }
  foreach ($wait_modifs as &$wait_modif) {
    $infos = explode(";", $wait_modif->infos);
    $tab_tmp = array();
    foreach ($infos as $info) {
      $tab_tmp2 = explode("=", $info);
      $tab_tmp[$tab_tmp2[0]] = (isset($tab_tmp2[1])) ? $tab_tmp2[1] : "";
    }
    $wait_modif->infos = $tab_tmp;
  }
  
  return array($wait_valids, $wait_modifs);
}

function getAllLibProfils() {
  global $bdd;
  
  $query = "SELECT id_profil, lib_profil FROM profils";
  $res = $bdd->query($query);
  $tab_tmp = array();
  while ($tmp = $res->fetchObject()) { $tab_tmp [$tmp->id_profil] = $tmp->lib_profil; }
  return $tab_tmp;
}

function getAllLibAnnuCategs() {
  global $bdd;
  
  $query = "SELECT id_categorie, lib_categorie FROM annuaire_categories";
  $res = $bdd->query($query);
  $tab_tmp = array();
  while ($tmp = $res->fetchObject()) { $tab_tmp [$tmp->id_categorie] = $tmp->lib_categorie; }
  return $tab_tmp;
}
?>
