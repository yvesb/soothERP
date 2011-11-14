<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE COORDONNEE DE CONTACT 
// *************************************************************************************************************


final class coordonnee {
	private $ref_coord;
	private $ref_contact;

	private $lib_coord;
	
	private $tel1;
	private $tel2;
	private $fax;
	private $email;

	private $note;
	private $ordre;
	
	private $ref_coord_parent;
	
	private $type;


function __construct($ref_coord = "") {
	global $bdd;

	// Controle si la ref_coord est précisée
	if (!$ref_coord) { return false; }

	// Sélection des informations générales
	$query = "SELECT ref_contact, lib_coord, tel1, tel2, fax, email, note, ordre, ref_coord_parent, id_type_coordonnee
						FROM coordonnees 
						WHERE ref_coord = '".$ref_coord."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_coord est trouvée
	if (!$coordonnee = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->ref_coord 		= $ref_coord;
	$this->ref_contact 	= $coordonnee->ref_contact;
	$this->lib_coord		= $coordonnee->lib_coord;
	$this->tel1		= $coordonnee->tel1;
	$this->tel2		= $coordonnee->tel2;
	$this->fax		= $coordonnee->fax;
	$this->email	= $coordonnee->email;
	$this->note		= $coordonnee->note;
	$this->ordre	= $coordonnee->ordre;
	$this->ref_coord_parent	= $coordonnee->ref_coord_parent;
	$this->type		= $coordonnee->id_type_coordonnee;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE coordonnee 
// *************************************************************************************************************

final public function create ($ref_contact, $lib_coord, $tel1, $tel2, $fax, $email, $note, $ref_coord_parent, $email_user_creation, $type, $ref_coord = "") {
	global $bdd;
	global $DELAI_USER_CREATION_INVITATION;

	$COORDONNEE_ID_REFERENCE_TAG = 6;		// Référence Tag utilisé dans la base de donnée

	// *************************************************
	// Controle des données transmises
	$this->ref_contact 	= $ref_contact;
	$this->lib_coord 	= $lib_coord;
	$this->tel1 		= $tel1;
	$this->tel2 		= $tel2;
	$this->fax	 		= $fax;
	$this->note		 	= $note;
	$this->ref_coord_parent	= $ref_coord_parent;
	$this->type			= $type;
	
	// Vérifie si l'adresse email est unique
	$this->email 		= trim($email);
	if ($this->email) {
		$query = "SELECT ref_coord, c.ref_contact, c.email, a.nom, a.date_archivage, a.note
							FROM coordonnees c
								LEFT JOIN annuaire a ON c.ref_contact = a.ref_contact  
							WHERE c.email = '".addslashes($email)."' ";
		$resultat = $bdd->query ($query);
		if ($coordonnee = $resultat->fetchObject()) { 
			//vérification de l'appartenance de la coord à un contact valide
			if ($coordonnee->date_archivage) {
				//suppression de l'email de la coordonnée et mise en note de l'email
				$query = "UPDATE coordonnees 
									SET email = NULL
									WHERE ref_coord = '".$coordonnee->ref_coord."' ";
				$bdd->exec ($query);
				$query = "UPDATE annuaire 
									SET note = '".addslashes($coordonnee->note)."L\'adresse email ".$coordonnee->email." de ce contact a été supprimée automatiquement', date_modification = NOW()
									WHERE ref_contact = '".$coordonnee->ref_contact."' ";
				$bdd->exec ($query);

			} else {
				//on renvois une erreur de saisie avec les infos du contact corespondant
				$GLOBALS['_ALERTES']['email_used'] = array($coordonnee->ref_contact, $coordonnee->nom); 
			}
		
		}
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (isset($GLOBALS['_ALERTES']['email_used']) && $this->email) {
		return false;
	}
	// Si aucune valeur, inutile de créer la coordonnée
	if (!$this->lib_coord && !$this->tel1 && !$this->tel2 && !$this->fax && !$this->email && !$this->note) {
		return false;
	}

	// *************************************************
	// Création de la référence
	if (!$ref_coord) {
		$reference = new reference ($COORDONNEE_ID_REFERENCE_TAG);
		$this->ref_coord = $reference->generer_ref();
	} else {
		$this->ref_coord = $ref_coord;
	}
	
	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM coordonnees WHERE ref_contact = '".$this->ref_contact."' ";
	$resultat = $bdd->query($query);
	$tmp = $resultat->fetchObject();
	$this->ordre = $tmp->ordre+1;
	unset ($query, $resultat, $tmp);

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO coordonnees (ref_coord, ref_contact, lib_coord, tel1, tel2, fax, email, note, ordre, ref_coord_parent, id_type_coordonnee)
						VALUES ('".$this->ref_coord."', '".$this->ref_contact."', '".addslashes($this->lib_coord)."', 
										'".addslashes($this->tel1)."', '".addslashes($this->tel2)."', 
										'".addslashes($this->fax)."', ".text_or_null($this->email).", 
										'".addslashes($this->note)."', '".$this->ordre."', ".ref_or_null($this->ref_coord_parent).", ".num_or_null($this->type)." )";
	$bdd->exec($query);

	
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_coordonnée'] = $this->ref_coord;
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE COORDONNEE
// *************************************************************************************************************

public function modification ($lib_coord, $tel1, $tel2, $fax, $email, $note, $type="", $ref_coord_parent) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_coord = $lib_coord;
	$this->tel1 	= $tel1;
	$this->tel2 	= $tel2;
	$this->fax	 	= $fax;
	$this->type		= $type;
	// Vérifie si l'adresse email est unique
	$email = trim($email);
	if ($email && $this->email != $email) {
		$query = "SELECT ref_coord, c.ref_contact, c.email, a.nom, a.date_archivage, a.note
							FROM coordonnees c
								LEFT JOIN annuaire a ON c.ref_contact = a.ref_contact  
							WHERE c.email = '".addslashes($email)."' ";
		$resultat = $bdd->query ($query);
		if ($coordonnee = $resultat->fetchObject()) { 
			//vérification de l'appartenance de la coord à un contact valide
			if ($coordonnee->date_archivage) {
				//suppression de l'email de la coordonnée et mise en note de l'email
				$query = "UPDATE coordonnees 
									SET email = NULL
									WHERE ref_coord = '".$coordonnee->ref_coord."' ";
				$bdd->exec ($query);
				$query = "UPDATE annuaire 
									SET note = '".addslashes($coordonnee->note)."L\'adresse email ".$coordonnee->email." de ce contact a été supprimée automatiquement', date_modification = NOW()
									WHERE ref_contact = '".$coordonnee->ref_contact."' ";
				$bdd->exec ($query);

			} else {
				//on renvois une erreur de saisie avec les infos du contact corespondant
				$GLOBALS['_ALERTES']['email_used'] = array($coordonnee->ref_contact, $coordonnee->nom); 
			}
		
		}
	}
	$this->email = $email;
	$this->note		= $note;
	$this->ref_coord_parent	= $ref_coord_parent;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "UPDATE coordonnees 
						SET lib_coord = '".addslashes($this->lib_coord)."', 
								tel1 = '".addslashes($this->tel1)."', tel2 = '".addslashes($this->tel2)."', 
								fax = '".addslashes($this->fax)."', email = ".text_or_null($this->email).", 
								note = '".addslashes($this->note)."', ref_coord_parent = ".ref_or_null($this->ref_coord_parent).", id_type_coordonnee = ".num_or_null($type)."
						WHERE ref_coord = '".$this->ref_coord."' ";
	//echo $query;
	$bdd->exec ($query);
}


public function modifier_ordre ($new_ordre) {
	global $bdd;
	if ($new_ordre == $this->ordre) { return false; }

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	if ($new_ordre < $this->ordre) {
		$variation = "+";
		$symbole1 = "<";
		$symbole2 = ">=";
	}
	else {
		$variation = "-";
		$symbole1 = ">";
		$symbole2 = "<=";
	}

	$bdd->beginTransaction();
	
	// Mise à jour des autres coordonnees
	$query = "UPDATE coordonnees
						SET ordre = ordre ".$variation." 1
						WHERE ref_contact = '".$this->ref_contact."' && 
									ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de cette coordonnee
	$query = "UPDATE coordonnees
						SET ordre = '".$new_ordre."'
						WHERE ref_coord = '".$this->ref_coord."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();	

	$this->ordre = $new_ordre;

	// *************************************************
	// Résultat positif de la modification
	return true;
}


public function suppression () {
	global $bdd;

	// *************************************************
	// Controle à effectuer le cas échéant
	
	// Sélection des informations sur l'utilisateur
	$query = "SELECT ref_user, ref_coord_user
						FROM users u
						WHERE  ref_coord_user = '".$this->ref_coord."' 
						LIMIT 0,1  ";
	$result = $bdd->query($query);
	$user = $result->fetchObject();
	if (isset($user->ref_user)) {
		$GLOBALS['_ALERTES']['coord_used'] = 1;
		return false;
	}
	
	$query = "UPDATE users SET actif = '0' WHERE ref_coord_user = '".$this->ref_coord."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_user est trouvée
	//if ($utilisateur = $resultat->fetchObject()) { 
	//	$GLOBALS['_ALERTES']['user_exist'] = 1;
	//	return false; 
	//}

	// *************************************************
	// Suppression de la coordonnee
	$query = "DELETE FROM coordonnees 
						WHERE ref_coord = '".$this->ref_coord."' ";
	$bdd->exec ($query);
	
	// Changement de l'ordre des coordonnees suivantes
	$query = "UPDATE coordonnees 
						SET ordre = ordre -1
						WHERE ref_contact = '".$this->ref_contact."' && ordre > '".$this->ordre."'";
	$bdd->exec ($query);

	unset ($this);
	return true;
}


/*
 * @version 2.045
 * Fonction qui permet d'envoyer un mail invitant le contact à s'inscrire en tant qu'utilisateur de l'application
 */
function envoi_mail_invitation(){
	// Envoi d'un email proposant la création d'un compte utilisateur
	global $CONFIG_DIR;
	global $DEFAUT_PROFILS;
	global $ID_MAIL_TEMPLATE_INVITATION_INSCRIPTION;
	global $ID_MAIL_TEMPLATE;
	global $REF_CONTACT_ENTREPRISE;
	global $bdd;
	
	// Création du code de validation
	$code = md5(date('Y-m-d H:M') . $this->ref_coord . $this->lib_coord);

	// Insertion dans la base
	$query = "INSERT INTO users_creations_invitations (ref_coord, date_invitation, code)
						VALUES ('".$this->ref_coord."', NOW(), '" . $code . "') ";
	$bdd->exec($query);

	// Envoi de l'email avec template
	// Envoi d'un email de proposition d'inscription au client
	// Url d'inscription
	$url_site = url_site();
	$url_inscription = $url_site."site/_valider_inscription.php?coord=" . $this->ref_coord . "&code=" . $code;
	$lien_inscription = "<a href=\"" . $url_inscription . "\">" . $url_inscription . "</a>";
	$mail = new email();
	$mail->prepare_envoi(1, 0);
	restore_error_handler();
	error_reporting(0);
	
	// On récupère l'identifiant du template de mail pour l'invitation à la création d'un compte
	$ID_MAIL_TEMPLATE = $ID_MAIL_TEMPLATE_INVITATION_INSCRIPTION;
	// Chargement du nom de l'entreprise
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	$lib_civ = $contact_entreprise->getLib_civ_court();
	// Envoi de l'email
	$destinataire = $this->email;
	$sujet = "[" . $nom_entreprise . "] Création d'un compte utilisateur LMB";
	$message = "<br /><br />Bonjour, <br />" . 
					$lib_civ . " " . $nom_entreprise . 
					" vous propose de créer un compte utilisateur sur son application de gestion. <br />";
	$contact = new contact($this->ref_contact);
	$profils = $contact->getProfils();
	if(count($profils)){
		$message .= "Cet accès vous permettra d'interagir avec " . $nom_entreprise . " en tant que ";
		$i = 0;
		foreach($profils as $id_profil => $profil){
			$message .= getLibProfil($id_profil);
			if($i < count($profils) - 1){
				$message .= " / ";
			}
			$i++;
		}
		$message .=	".<br />";
	}
	$message .=	"Pour ce faire, vous devez cliquez sur le lien suivant (ou le coller dans votre navigateur) : <br />" . 
				$lien_inscription . 
				"<br /><br />" . 
				"L'équipe " . $nom_entreprise;
	
	if(!$mail->envoi_email_templated($destinataire, $sujet, $message)){
		echo "Une erreur est survenue lors de l'envoi à ".$this->email."<br />";
	}
	set_error_handler("error_handler");
} 


// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
// renvois de la ref coord en fonction de l'ordre
static function getRef_coord_from_ordre ($ref_contact, $ordre) {
	global $bdd;
	
	$coordonnee = "";
	$query = "SELECT ref_coord
							FROM coordonnees
						WHERE ref_contact = '".$ref_contact."' 
						AND ordre = ".$ordre." 
						LIMIT 1"	;
	$resultat = $bdd->query ($query);
	if ($coord = $resultat->fetchObject()) { $coordonnee = $coord->ref_coord; }
	return $coordonnee;
}

//retourne une liste des ref_coord en fonction d'un plage d'ordre (mise à jour de l'affichage des coordonnees)
public function liste_ref_coord_in_ordre () {
	global $bdd;
	
	$coordonnees = array();
	$query = "SELECT ref_coord
						FROM coordonnees 
						WHERE ref_contact = '".$this->ref_contact."' 
						&& (ordre> ".$this->ordre." || ordre= ".$this->ordre."-1)";
	$resultat = $bdd->query ($query);
	while ($coord = $resultat->fetchObject()) { $coordonnees[] = $coord; }

	return $coordonnees;
}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_coord () {
	return $this->ref_coord;
}

function getRef_contact () {
	return $this->ref_contact;
}

function getLib_coord () {
	return $this->lib_coord;
}

function getTel1 () {
	return $this->tel1;
}

function getTel2 () {
	return $this->tel2;
}

function getFax () {
	return $this->fax;
}

function getEmail () {
	return $this->email;
}

function getNote () {
	return $this->note;
}

function getOrdre () {
	return $this->ordre;
}
function getType () {
	return $this->type;
}
function getTypeLib () {
	global $bdd;
	$query = "SELECT coord_type FROM coordonnees_types WHERE id_coord_type = '".$this->type."' ";
	$retour = $bdd->query($query);
	if($ret = $retour->fetchObject()){
		return $ret->coord_type;
	}
}

}

?>
