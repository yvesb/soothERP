<?php
// *************************************************************************************************************
// CLASSE COMMUNE AU INSCRIPTION ET AU MODIFICATION
// *************************************************************************************************************

abstract class InscriptionModification{
	private $id_profil;
	private $id_interface;
	private $id_theme;
	private $dossier;
	
	private $lib_interface;
	private $url;
	
	private $nom_entreprise;
	
	function __construct($id_interface) {
		global $bdd;
		global $DIR;
		
		if (is_null($id_interface) || !is_numeric($id_interface))
		{		return false;}
	
		$query = "SELECT id_profil, id_interface, lib_interface, dossier, url, defaut_id_theme as id_theme
							FROM interfaces 
							WHERE id_interface = '".$id_interface."' ";
		$resultat = $bdd->query ($query);
		if (!$interfaces = $resultat->fetchObject())
		{		return false;}
		
		$this->id_profil 				= $interfaces->id_profil;
		$this->id_interface 		= $interfaces->id_interface;
		$this->lib_interface 		= $interfaces->lib_interface;
		$this->dossier 					= $interfaces->dossier;
		$this->url 							= $interfaces->url;
		$this->id_theme					= $interfaces->id_theme;
		
		global $REF_CONTACT_ENTREPRISE;
		
		$contact_entreprise		= new contact($REF_CONTACT_ENTREPRISE);
		$this->nom_entreprise	= str_replace(CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	}
	
	// *************************************************************************************************************
	// *************************************************************************************************************
	// INSCRIPTION D'UN CONTACT
	// *************************************************************************************************************
	// *************************************************************************************************************
	
	//	Utilisation de la table Table: annuaire_tmp 
	//
	//	id_contact_tmp		smallint(5) UNSIGNED 	NOTNULL	auto_increment	:	
	//	id_interface			smallint(5) UNSIGNED	NOTNULL									:	
	//	infos							mediumtext						NOTNULL									:	liste de couple clé/valeur séparé par un ;
	//	date_demande			datetime							NOTNULL									:	
	//	code_validation		varchar(64)						NOTNULL									:	code pour que l'utilisateur confirme son inscription 
	//	validation_email	tinyint(2)						NOTNULL									:	1 => validation par un collab : ce contact n'a pas de besoin la confirmation par mail :
	//																																				 - soit c'est une inscription sans confirmation
	//																																				 - soit c'est une inscription avec confirmation, mais l'utilisateur a déjà confirmé son inscription
	//																																		2 => validation par un collab : cet utilisateur doit confirmer son inscription pour pouvoir passer 
	//																																				 à l'étape suivante : validation_email <- 1
	//																																		3 => validation automatique : cet utilisateur doit confirmer son inscription pour pouvoir passer 
	//																																				 à l'étape suivante (création du contact et supression de la ligne)
	//	mode							enum('inscription', 'modification')	NOTNULL		:	
	//
	//
	// listes des clé contenu dans le champ infos :
	//	id_categorie
	//	civilite
	//	nom
	//	siret
	//	tva_intra
	//	admin_pseudo
	//	admin_emaila
	//	admin_passworda
	//	livraison_adresse
	//	livraison_code
	//	livraison_ville
	//	id_pays_livraison
	//	adresse_adresse
	//	adresse_code
	//	adresse_ville
	//	id_pays_contact
	//	coordonnee_tel1
	//	coordonnee_tel2
	//	coordonnee_fax
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//vérifie qu'il y a les données minimum dans le tableau
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@return boolean : vrai si les données nécessaire à l'inscription sont présente, faux sinon.
	protected static function verifie_infos_contact_pour_inscription_ou_modification_contact($infos_contact){
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		return isset($infos_contact["nom"])
				&& isset($infos_contact["admin_pseudo"])
				&& isset($infos_contact["admin_emaila"])
				&& isset($infos_contact["admin_passworda"])
				&& isset($infos_contact["adresse_adresse"])
				&& isset($infos_contact["adresse_code"])
				&& isset($infos_contact["adresse_ville"])
				&& isset($infos_contact["id_pays_contact"]);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//retourne l'eamil du collaborateur à qui les demandes de validation doivent être envoyé
	//@return mixed : l'email sous forme de string s'il a été trouvé, faux sinon.
	protected function getEmail_du_collaborateur(){
		global $REF_CONTACT_ENTREPRISE;
		$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
		$coordonnees_entreprise = $contact_entreprise->getCoordonnees();
		
		for($i = 0; $i < count($coordonnees_entreprise); $i++){
			if($coordonnees_entreprise[$i]->getEmail())
			{		return $coordonnees_entreprise[$i]->getEmail();}
		}
		return false;
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//supprimer l'inscription
	//@param int $id_contact_tmp : Id du contact temporaire à effacer dans la liste des contact en attente de validation 
	//(pour une inscription ou une modification
	//@return bool : retourne vrai si le contact temporaire à été effécé, faux sinon
	protected function supprimer_inscription($id_contact_tmp) {
		global $bdd;
		$query = "DELETE FROM annuaire_tmp  
							WHERE id_contact_tmp = '".$id_contact_tmp."' ";
		return $bdd->exec($query) > 0;
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//fonction d'envoi des mail avec template
	protected function envoi_email_templated($to, $sujet, $message) {
		//simulation denvois de mail 
		/*
		$separateur_long = "<br /><br />--------------------------------------------------------------------------------<br /><br />";
		$separateur_court = "<br />-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
												"&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
												"&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
												"&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<br />";
		$fichier = fopen ("simulation_email.html", "a");
		fputs($fichier, $separateur_long.$to.$separateur_court.$sujet.$separateur_court.$message);
		fclose($fichier);
		
		return true;
		*/
		//NORMAL
		// Envoi de l'email
		$mail = new email();
		$mail->prepare_envoi(0, 1);
		return $mail->envoi_email_templated ($to, $sujet, $message);
	}
	
	// *************************************************************************************************************
	// Fonctions d'accès aux données
	// *************************************************************************************************************
	
	// Retourne l'identifiant du profil
	public function getId_profil() {
		return $this->id_profil;
	}
	
	// Retourne l'identifiant du id_interface
	public function getId_interface() {
		return $this->id_interface;
	}
	
	// Retourne defaut_id_theme
	public function getId_theme() {
		return $this->id_theme;
	}
	
	// Retourne le dossier
	public function getDossier() {
		return $this->dossier;
	}
	
	// Retourne lib_interface
	public function getLib_interface() {
		return $this->lib_interface;
	}
	
	// Retourne l'url
	public function getUrl() {
		return $this->url;
	}
	
	// Retourne le nom de l'entreprise
	public function getNom_entreprise(){
		return $this->nom_entreprise;
	}
	
	// *************************************************************************************************************
	
	public static function extractEmail($infos){
		//expression régulière qui extrait l'email de la forme "toto@toto.com" du champ info
		$pattern = '.*admin_emaila=(([a-zA-Z0-9]+(([\.\-\_]?[a-zA-Z0-9]+)+)?)\@(([a-zA-Z0-9]+[\.\-\_])+[a-zA-Z]{2,4}));.*';
		$email_contact = preg_replace('/'.$pattern.'/', '$1', $infos);
		if($email_contact == $infos)
		{			return false;}	//	l'email n'a pas été trouvé
		else{	return $email_contact;}
	}
	
	public static function extractNom($infos){
		//expression régulière qui extrait le du champ info
		//le champ nom 
		$pattern = '(.*;nom|$nom)=([^=;]*)(^|;[a-zA-Z_]+=.*)';
		$email_contact = preg_replace('/'.$pattern.'/', '$2', $infos);
		if($email_contact == $infos)
		{			return false;}	//	l'email n'a pas été trouvé
		else{	return $email_contact;}
	}
	
	public static function extractCivilite($infos){
		//expression régulière qui extrait le du champ info
		//le champ nom 
		$pattern = '(.*;civilite|$civilite)=([^=;]*)(^|;[a-zA-Z_]+=.*)';
		$email_contact = preg_replace('/'.$pattern.'/', '$2', $infos);
		if($email_contact == $infos)
		{			return false;}	//	l'email n'a pas été trouvé
		else{	return $email_contact;}
	}
	
	public static function extractRef_contact($infos){
		//expression régulière qui extrait le du champ info
		//le champ nom 
		$pattern = '(.*;)?ref_contact=([^=;]*);?.*';
		$email_contact = preg_replace('/'.$pattern.'/', '$2', $infos);
		if($email_contact == $infos)
		{			return false;}	//	l'email n'a pas été trouvé
		else{	return $email_contact;}
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//retourne l'eamil du collaborateur à qui les demandes de validation doivent être envoyé
	//@param $id_contact_tmp int : indentifiant du contact temporaire
	//@return mixed : l'email sous forme de string s'il a été trouvé, faux sinon.
	protected function modification_contact_email_du_contact($id_contact_tmp){
		global $bdd;
		
		$query = "SELECT	infos
							FROM 		annuaire_tmp
							WHERE		id_contact_tmp = ".$id_contact_tmp."";
		$resultat = $bdd->query ($query);
		if (!$res = $resultat->fetchObject())
		{		return false;}
		
		return $this->extractEmail($res->infos);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//supprimer l'modification
	//@param int $id_contact_tmp : Id du contact temporaire à effacer dans la liste des contact en attente de validation 
	//(pour une modification ou une modification
	//@return bool : retourne vrai si le contact temporaire à été effécé, faux sinon
	protected function supprimer_modification($id_contact_tmp) {
		global $bdd;
		$query = "DELETE FROM annuaire_tmp  
							WHERE id_contact_tmp = '".$id_contact_tmp."' ";
		return $bdd->exec($query) > 0;
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
}


?>