<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INSCRIPTIONS
// *************************************************************************************************************

class Inscription_compte_user extends InscriptionModification {
	private $inscription_allowed;
	
	function __construct($id_interface, $inscriptionAllowed = -1) {
		parent::__construct($id_interface);

		if($inscriptionAllowed == -1){
			// La valeur pour $this->inscription_allowed n'a pas été définie
			// il faut ouvrir le fichier config pour pouvoir charger cette valeur.
			
			// Lecture du fichier config de l'interface $id_interface
			if(file_exists($DIR.$this->getDossier()."_interface.config.php")){
				//L'interface possede son porpre fichier de config -> il est lu
				$chemin_file = $DIR.$this->getDossier()."_interface.config.php";
				if(file_exists($chemin_file)){
					$handle = @fopen($chemin_file, "r");
					if($handle){
						while(!feof($handle) && $inscriptionAllowed == -1){
							$ligne = fgets($handle);
							$inscriptionAllowed = $this->search_INSCRIPTION_ALLOWED_value($ligne);
						}
						fclose($handle);
					}
				}
			}else{
				//L'interface ne possede pas son porpre fichier de config -> c'est celui du profil client qui est lu
				$chemin_file = $DIR."profil_client/_interface.config.php";
				if(file_exists($chemin_file)){
					$handle = @fopen($chemin_file, "r");
					if($handle){
						while(!feof($handle) && $inscriptionAllowed == -1){
							$ligne = fgets($handle);
							$inscriptionAllowed = $this->search_INSCRIPTION_ALLOWED_value($ligne);
						}
						fclose($handle);
					}
				}
			}
		}
		
		$this->inscription_allowed = $inscriptionAllowed;
	}
	
	private static function search_INSCRIPTION_ALLOWED_value($texte){
		$pattern = '\$INSCRIPTION_ALLOWED([^\/]{0,2})*=([^\/]{0,2})*(\d);.*';
		$value_searched = preg_replace('/'.$pattern.'/', '$3', $texte);
		if($value_searched != $texte)//	la valeur a été trouvée
		{		return intval($value_searched);}
		else{ return -1;}
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
	//
	//
	//	FONCTIONNEMENT DE L'inscription
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->inscription_allowed == 0 : inscription interdite
	//	inscription_contact => retourne faux
	//
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->inscription_allowed == 1 : inscription d'un contact avec une validation par un collaborateur mais sans un mail de confirmation
	//	inscription_contact
	//		etape 1 l'inscription est enregistrée
	//		inscription_contact_avec_validation_sans_mail_confirmation
	//			inscription_contact_avec_validation_get_sujet_pour_contact
	//			inscription_contact_avec_validation_get_message_pour_contact
	//			inscription_contact_avec_validation_get_sujet_pour_collaborateur
	//			inscription_contact_avec_validation_get_message_pour_collaborateur
	//			getEmail_du_collaborateur
	//			envoi_email_templated => CONTACT
	//			envoi_email_templated => COLLABORATEUR
	//
	//		etape 2A le collab valide l'inscription
	//			validation_inscription_contact_par_collaborateur
	//				validation_inscription_contact
	//				supprimer_inscription
	//					inscription_creation_contact
	//					inscription_creation_user
	//				envoi_email_templated => CONTACT
	//
	//		atape 2B	le collab invalide l'inscription
	//			refus_inscription_contact_par_collaborateur
	//	
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->inscription_allowed == 3 : inscription d'un contact avec une validation par un collaborateur mais avec un mail confirmation
	//	inscription_contact
	//		etape 1 l'inscription est enregistrée
	//		inscription_contact_avec_validation_avec_mail_confirmation
	//			inscription_contact_avec_validation_avec_mail_confirmation_get_sujet_pour_contact
	//			inscription_contact_avec_validation_avec_mail_confirmation_get_message_pour_contact
	//		
	//		etape 2 l'utilisateur reçoit le mail et confirme sont inscription
	//		contact_confirme_son_inscription
	//			contact_confirme_son_inscription_puis_validation_par_collab
	//				inscription_contact_avec_validation_get_sujet_pour_contact
	//				inscription_contact_avec_validation_get_message_pour_contact
	//				inscription_contact_email_du_contact
	//				inscription_contact_avec_validation_get_sujet_pour_collaborateur
	//				inscription_contact_avec_validation_get_message_pour_collaborateur
	//				getEmail_du_collaborateur
	//				envoi_email_templated => CONTACT
	//				envoi_email_templated => COLLABORATEUR
	//
	//		etape 3A le collab valide l'inscription
	//			validation_inscription_contact_par_collaborateur
	//				validation_inscription_contact
	//				supprimer_inscription
	//					inscription_creation_contact
	//					inscription_creation_user
	//				envoi_email_templated => CONTACT
	//
	//		atape 3B	le collab invalide l'inscription
	//			refus_inscription_contact_par_collaborateur
	//	
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->inscription_allowed == 2 : inscription d'un contact automatique sans mail de confirmation
	//	inscription_contact
	//		etape 1 l'inscription est enregistrée
	//		inscription_contact_automatique_sans_mail_confirmation
	//			validation_inscription_contact
	//			inscription_automatique_sans_mail_confirmation_get_suejt_pour_contact
	//			inscription_automatique_sans_mail_confirmation_get_message_pour_contact
	//			envoi_email_templated => CONTACT
	//
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->inscription_allowed == 4 : inscription d'un contact automatique avec mail de confirmation
	//	inscription_contact
	//		etape 1 l'inscription est enregistrée
	//		inscription_contact_automatique_avec_mail_confirmation
	//			inscription_contact_automatique_avec_mail_confirmation_get_sujet_pour_contact
	//			inscription_contact_automatique_avec_mail_confirmation_get_message_pour_contact
	//		envoi_email_templated => CONTACT
	//
	//		etae 2 l'utilisateur reçoit le mail et confirme sont inscription
	//		contact_confirme_son_inscription
	//			contact_confirme_son_inscription_puis_validation_automatique
	//				validation_inscription_contact
	//				supprimer_inscription
	//				inscription_contact_automatique_get_sujet_pour_contact
	//				inscription_contact_automatique_get_message_pour_contact
	//				inscription_contact_email_du_contact
	//			envoi_email_templated => CONTACT
	//
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		
		
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//lance la procedure d'inscription pour un contact
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean	: vrai si l'inscrition du contact s'est bien passé, faux sinon.
	//attention, l'insrciption peut se faire en plusieurs temps suivant la valeur de $this->inscription_allowed
	public function inscription_contact($infos_contact, $email){	
		//vérification des paramètres d'entré
		if(is_null($infos_contact) || !is_array($infos_contact) || !$this->verifie_infos_contact_pour_inscription_ou_modification_contact($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		switch ($this->getInscription_allowed()){
			case 0 : {	return false;}	//inscription interdite
			
			case 1 : {	return $this->inscription_contact_avec_validation_sans_mail_confirmation($infos_contact, $email); break;}
			case 3 : {	return $this->inscription_contact_avec_validation_avec_mail_confirmation($infos_contact, $email); break;}
			
			case 2 : {	return $this->inscription_contact_automatique_sans_mail_confirmation($infos_contact, $email); break;}
			case 4 : {	return $this->inscription_contact_automatique_avec_mail_confirmation($infos_contact, $email); break;}
			
			default: {	return false;}	//valeur non permises
		}
	}
		
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	// INSCRIPTION D'UN CONTACT AVEC VALIDATION 
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *

	//procedure d'inscription pour un contact AVEC VALIDATION et SANS MAIL DE CONFIRMATION
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si l'inscrition du contact s'est bien passé, faux sinon. 
	protected function inscription_contact_avec_validation_sans_mail_confirmation($infos_contact, $email){
		global $bdd;
		
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getInscription_allowed() != 1)
		{		return false;}

		global $INSCRIPTION_VALIDATION_CONTENU;
		global $INSCRIPTION_VALIDATION_SUJET;
		

		$code_validation = "";
		$query = "INSERT INTO annuaire_tmp
							(id_interface, infos, date_demande, code_validation, validation_email, mode) VALUES 
	 						(".$this->getId_interface().", '".addslashes(implode(";", $infos_contact))."', NOW(), '".$code_validation."', 1, 'inscription')";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
		
		$id_contact_tmp = $bdd->lastInsertId();
		
		$sujet_pour_contact		= $this->inscription_contact_avec_validation_get_sujet_pour_contact();
		$message_pour_contact	= $this->inscription_contact_avec_validation_get_message_pour_contact();
		$email_contact				= $email;
		
		$sujet_pour_collaborateur		= $this->inscription_contact_avec_validation_get_sujet_pour_collaborateur();
		$message_pour_collaborateur	= $this->inscription_contact_avec_validation_get_message_pour_collaborateur();
		$email_collaborateur				= $this->getEmail_du_collaborateur();
		if($email_collaborateur === false)
		{		return false;}
		
		return	$this->envoi_email_templated($email_contact, 				$sujet_pour_contact,				$message_pour_contact)
		&&			$this->envoi_email_templated($email_collaborateur,	$sujet_pour_collaborateur,	$message_pour_collaborateur);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//procedure d'inscription pour un contact AVEC VALIDATION et AVEC MAIL DE CONFIRMATION
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si l'inscrition du contact s'est bien passé, faux sinon. 
	protected function inscription_contact_avec_validation_avec_mail_confirmation($infos_contact, $email){
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getInscription_allowed() != 3)
		{		return false;}

		global $INSCRIPTION_VALIDATION_CONTENU;
		global $INSCRIPTION_VALIDATION_SUJET;
		
		$code_validation = creer_code_unique($email, $this->getId_interface());
		
		global $bdd;
		$query = "INSERT INTO annuaire_tmp
							(id_interface, infos, date_demande, code_validation, validation_email, mode) VALUES 
	 						(".$this->getId_interface().", '".addslashes(implode(";", $infos_contact))."', NOW(), '".$code_validation."', 2, 'inscription')";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
		
		$id_contact_tmp = $bdd->lastInsertId();
		
		$sujet_pour_contact		= $this->inscription_contact_avec_validation_avec_mail_confirmation_get_sujet_pour_contact();
		$message_pour_contact	= $this->inscription_contact_avec_validation_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation);
		$email_contact				= $email;
		
		return	$this->envoi_email_templated($email_contact, 				$sujet_pour_contact,				$message_pour_contact);
	}
		
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (inscription avec validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->inscription_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_avec_validation_get_sujet_pour_contact(){
		return "Inscription sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (inscription avec validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->inscription_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_avec_validation_get_message_pour_contact(){
		global $INFO_LOCALE;
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour et bienvenue,<br />
		Vous venez de vous inscrire sur notre site et nous vous en remercions.<br />
		<br />
		Un de nos collaborateurs va prochainement valider votre fiche. Vous recevrez alors un email de confirmation.<br />
		<br />
		<br />
		".$this->getNom_entreprise()."
		<br />
		<br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé A UN COLLABORATEUR quand un utilisateur s'inscrit sur le site (inscription avec validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->inscription_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_avec_validation_get_sujet_pour_collaborateur(){
		return "Inscription sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//corps du mail envoyé A UN COLLABORATEUR quand un utilisateur s'inscrit sur le site (inscription avec validation)
	//@return string : retourne le corps de l'email envoyé par la fonction Inscription->inscription_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_avec_validation_get_message_pour_collaborateur(){
		global $INFO_LOCALE;
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour,<br />
		Un nouvel inscrit s'est enregistré sur '".$this->getLib_interface()."' du site '".$_SERVER['HTTP_HOST']."'<br />
		Vous devez valider son inscription à partir de votre interface collaborateur.
		<br />
		<br />
		<br />
		".$this->getNom_entreprise()."
		<br />
		<br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
	
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (inscription avec validation)
	//ce message invite l'utilisateur à confirmer son inscription (avant toute autre validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->inscription_contact_avec_validation_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_avec_validation_avec_mail_confirmation_get_sujet_pour_contact(){
		return "Inscription sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (inscription avec validation)
	//ce message invite l'utilisateur à confirmer son inscription (avant toute autre validation)
	//@return string : retourne le message de l'email envoyé par la fonction Inscription->inscription_contact_avec_validation_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_avec_validation_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation){
		global $INFO_LOCALE;
		
		$my_pathinfo = pathinfo(str_replace(str_replace("/",  "\\", $_SERVER['DOCUMENT_ROOT']), "", __FILE__));
		
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour,<br />
		<br />
		votre demande a bien été prise en compte.<br />
		Cette validation se fait en deux temps.<br />
		Premièrement, vous devez confirmer votre inscription en cliquant sur ce lien :<br />
		http://".$_SERVER['HTTP_HOST']."/".$my_pathinfo["dirname"]."/".$this->getDossier()."_inscription_valide.php?id_contact_tmp=".$id_contact_tmp."&code_validation=".$code_validation."<br />
		Deuxièmement, notre équipe validera celle-ci.<br />
		<br />
		<br />
		".$this->getNom_entreprise()."
		<br />
		<br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
	}
		
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//retourne l'eamil du collaborateur à qui les demandes de validation doivent être envoyé
	//@param $id_contact_tmp int : indentifiant du contact temporaire
	//@return mixed : l'email sous forme de string s'il a été trouvé, faux sinon.
	protected function inscription_contact_email_du_contact($id_contact_tmp){
		global $bdd;
		
		$query = "SELECT	infos
							FROM 		annuaire_tmp
							WHERE		id_contact_tmp = ".$id_contact_tmp."";
		$resultat = $bdd->query ($query);
		if (!$res = $resultat->fetchObject())
		{		return false;}
		
		return $this->extractEmail($res->infos);
	}
	
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	// INSCRIPTION D'UN CONTACT AUTOMATIQUE
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	
	//procedure d'inscription pour un contact AUTOMATIQUE et SANS MAIL de confirmation
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si l'inscrition du contact s'est bien passé, faux sinon.
	protected function inscription_contact_automatique_sans_mail_confirmation($infos_contact, $email){
		global $bdd;
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getInscription_allowed() != 2)
		{		return false;}
		
		$user =& $this->validation_inscription_contact($infos_contact);
		if(is_null($user))
		{			return false;}
		
		$sujet_pour_contact		= $this->inscription_contact_automatique_sans_mail_confirmation_get_suejt_pour_contact();
		$message_pour_contact	= $this->inscription_contact_automatique_sans_mail_confirmation_get_message_pour_contact();
		$email_contact				= $email;
		
		return	$this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé à l'UTILISATEUR pour lui indiquer que son inscription est terminée
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->inscription_contact_automatique_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_automatique_sans_mail_confirmation_get_suejt_pour_contact(){
		return "Inscription sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR pour lui indiquer que son inscription est terminée
	//@return string : retourne le message de l'email envoyé par la fonction Inscription->inscription_contact_automatique_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_automatique_sans_mail_confirmation_get_message_pour_contact(){
		global $INFO_LOCALE;
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour et bienvenue,<br />
		Vous venez de vous inscrire sur notre site et nous vous en remercions.<br />
		<br />
		<br />
		".$this->getNom_entreprise()."
		<br />
		<br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//procedure d'inscription pour un contact AUTOMATIQUE et SANS MAIL de confirmation
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si l'inscrition du contact s'est bien passé, faux sinon.
	protected function inscription_contact_automatique_avec_mail_confirmation($infos_contact, $email){
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getInscription_allowed() != 4)
		{		return false;}
		
		$code_validation = creer_code_unique($email, $this->getId_interface());
		
		global $bdd;
		$query = "INSERT INTO annuaire_tmp
							(id_interface, infos, date_demande, code_validation, validation_email, mode) VALUES 
	 						(".$this->getId_interface().", '".addslashes(implode(";", $infos_contact))."', NOW(), '".$code_validation."', 3, 'inscription')";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
		
		$id_contact_tmp = $bdd->lastInsertId();
		
		$sujet_pour_contact		= $this->inscription_contact_automatique_avec_mail_confirmation_get_sujet_pour_contact();
		$message_pour_contact	= $this->inscription_contact_automatique_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation);
		$email_contact				= $email;
		
		return	$this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé à l'UTILISATEUR pour qu'il confirme son inscription automatique
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->inscription_contact_automatique_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_automatique_avec_mail_confirmation_get_sujet_pour_contact(){
		return "Confirmation de votre email pour votre inscription sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR pour qu'il confirme son inscription automatique
	//@return string : retourne le message de l'email envoyé par la fonction Inscription->inscription_contact_automatique_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function inscription_contact_automatique_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation){
		global $INFO_LOCALE;
		
		$my_pathinfo = pathinfo(str_replace(str_replace("/",  "\\", $_SERVER['DOCUMENT_ROOT']), "", __FILE__));
		
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour et bienvenue,<br />
		Pour finaliser votre inscription sur notre site, vous confirmer votre email en cliquant ou en copiant/collant le lien ci-dessous.<br />
		<br />
		http://".$_SERVER['HTTP_HOST']."/".$my_pathinfo["dirname"]."/".$this->getDossier()."_inscription_valide.php?id_contact_tmp=".$id_contact_tmp."&code_validation=".$code_validation."<br />
		<br />
		".$this->getNom_entreprise()."
		<br />
		<br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
	}
	
	
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	

	
	

	
	
	
	
	
	
	

	
	
	
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//procedure pour qu'un contact confirme son inscription après avoir reçu un mail l'invitant à le faire
	//envoyé par Inscription->inscription_contact_avec_validation_avec_mail_confirmation()
	//		ou par Inscription->inscription_contact_automatique_avec_mail_confirmation()
	//Après cette étape un collaborateur devra valider cette inscription
	//@param $id_contact_tmp int : 
	//@param $code string : 
	//@return boolean : vrai si la confirmation de l'inscription du contact s'est bien passé, faux sinon.
	protected function contact_confirme_son_inscription_puis_validation_automatique($id_contact_tmp, $code){
		if($this->getInscription_allowed() != 4)
		{		return false;}
		
		$email_contact = $this->inscription_contact_email_du_contact($id_contact_tmp);
		
		//si le code est bon on confirme l'inscription
		if(!verifier_code_unique($code, $email_contact, $this->getId_interface()))
		{		return false;}
	 	
		global $bdd;
		$query = "SELECT	infos
							FROM 		annuaire_tmp
							WHERE		id_contact_tmp = ".$id_contact_tmp."";
		$resultat = $bdd->query ($query);
		if (!$res = $resultat->fetchObject())
		{		return false;}
		
		$user =& $this->validation_inscription_contact(explode(";", $res->infos));
		if(is_null($user))
		{			return false;}
		
		if(!$this->supprimer_inscription($id_contact_tmp))
		{			return false;}
		
		$sujet_pour_contact		= $this->inscription_contact_automatique_sans_mail_confirmation_get_suejt_pour_contact();
		$message_pour_contact	= $this->inscription_contact_automatique_sans_mail_confirmation_get_message_pour_contact();
		if($email_contact === false)
		{		return false;}
		
		return	$this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact);
	}
	
	
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	// CONFIRMATION DE LA PART DE L'UTILISATEUR DE SON INSCRIPTION (ne pas confondre avec la validation par un collab) 
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	
	//procedure pour qu'un contact confirme son inscription après avoir reçu un mail l'invitant à le faire
	//envoyé par Inscription->inscription_contact_avec_validation_avec_mail_confirmation()
	//		ou par Inscription->inscription_contact_automatique_avec_mail_confirmation()
	//@param $id_contact_tmp int : 
	//@param $code string : 
	//@return boolean : vrai si la confirmation de l'inscription du contact s'est bien passé, faux sinon. 
	public function contact_confirme_son_inscription($id_contact_tmp, $code){
		//vérification des paramètres d'entré
		if(is_null($id_contact_tmp) || !is_numeric($id_contact_tmp))
		{		return false;}
		
		if(is_null($code) || !is_string($code))
		{		return false;}
		
		if($this->getInscription_allowed() === false)
		{		return false;}
				
		switch ($this->getInscription_allowed()){
			case 0 : {	return false;}	//inscription interdite
			
			case 1 : {	return false;}	//la confirmation n'est pas néncessaire
			case 3 : {	return $this->contact_confirme_son_inscription_puis_validation_par_collab($id_contact_tmp, $code); break;}
			
			case 2 : {	return false;}	//la confirmation n'est pas néncessaire
			case 4 : {	return $this->contact_confirme_son_inscription_puis_validation_automatique($id_contact_tmp, $code); break;}
			
			default: {	return false;}	//valeur non permises
		}
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//procedure pour qu'un contact confirme son inscription après avoir reçu un mail l'invitant à le faire
	//envoyé par Inscription->inscription_contact_avec_validation_avec_mail_confirmation()
	//		ou par Inscription->inscription_contact_automatique_avec_mail_confirmation()
	//Après cette étape un collaborateur devra valider cette inscription
	//@param $id_contact_tmp int : 
	//@param $code string : 
	//@return boolean : vrai si la confirmation de l'inscription du contact s'est bien passé, faux sinon.
	protected function contact_confirme_son_inscription_puis_validation_par_collab($id_contact_tmp, $code){
		if($this->getInscription_allowed() != 3)
		{		return false;}
		
		global $bdd;
		$query = "SELECT id_contact_tmp, infos
							FROM annuaire_tmp
							WHERE id_contact_tmp = ".$id_contact_tmp;
		$resultat = $bdd->query($query);
		if (!$res = $resultat->fetchObject())
		{		return false;}
		
		$email = $this->extractEmail($res->infos);
		if($email === false)
		{		return false;}
		
		//si le code est bon on confirme l'inscription
		if(!verifier_code_unique($code, $email, $this->getId_interface()))
		{		return false;}
		
		$query = "UPDATE annuaire_tmp  SET validation_email = 1
							WHERE id_contact_tmp = '".$id_contact_tmp."' ";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
				
		$sujet_pour_contact		= $this->inscription_contact_avec_validation_get_sujet_pour_contact();
		$message_pour_contact	= $this->inscription_contact_avec_validation_get_message_pour_contact();
		$email_contact				= $this->inscription_contact_email_du_contact($id_contact_tmp);
		if($email_contact === false)
		{		return false;}
		
		$sujet_pour_collaborateur		= $this->inscription_contact_avec_validation_get_sujet_pour_collaborateur();
		$message_pour_collaborateur	= $this->inscription_contact_avec_validation_get_message_pour_collaborateur();
		$email_collaborateur				= $this->getEmail_du_collaborateur();
		if($email_collaborateur === false)
		{		return false;}
		
		return	$this->envoi_email_templated($email_contact, 				$sujet_pour_contact,				$message_pour_contact)
		&&			$this->envoi_email_templated($email_collaborateur,	$sujet_pour_collaborateur,	$message_pour_collaborateur);
	}
	
	
	// *************************************************************************************************************
	// VALIDATION DE L'INSCRIPTION
	// *************************************************************************************************************
	
	
	public function refus_inscription_contact_par_collaborateur($id_contact_tmp){
		return $this->supprimer_inscription($id_contact_tmp);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	public function &validation_inscription_contact_par_collaborateur($id_contact_tmp){
		$null = null;
		
		// vérification si on peut créer un user à partir d'une inscription
		switch ($this->getInscription_allowed()){
			case 1 : case 2 : case 3: case 4 : {break;}	//les inscriptions sont permises
			default : {return $null;}
		}
		global $bdd;

		$query = "SELECT	infos
							FROM 		annuaire_tmp
							WHERE		id_contact_tmp = ".$id_contact_tmp."";
		$resultat = $bdd->query ($query);
		if (!$res = $resultat->fetchObject())
		{		return $null;}
		
		$user =& $this->validation_inscription_contact(explode(";", $res->infos));
		if(is_null($user))
		{			return $null;}

		if($this->supprimer_inscription($id_contact_tmp)){
			$sujet_pour_contact		= $this->validation_inscription_contact_par_collaborateur_get_suejt_pour_contact();
			$message_pour_contact	= $this->validation_inscription_contact_par_collaborateur_get_message_pour_contact();
			$email_contact				= $this->extractEmail($res->infos);
			if($email_contact === false)
			{		return $null;}
			
			if($this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact))
			{			return $user;}
			else{	return $null;}
		}else{	return $null;}
	}
	
	protected function validation_inscription_contact_par_collaborateur_get_suejt_pour_contact(){
		return "Inscription sur ".$_SERVER['HTTP_HOST'];
	}
	
	protected function validation_inscription_contact_par_collaborateur_get_message_pour_contact(){
		global $INFO_LOCALE;
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour,<br />
		Votre inscription vient d'être validée, Vous pouvez maintenant vous connecter sur ".$_SERVER['HTTP_HOST']." à l'aide de votre login et mot de passe 
		<br />
		<br />
		".$this->getNom_entreprise()."
		<br />
		<br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	protected function &validation_inscription_contact($infos_from_inscription){
		global $bdd;
		$null = null;
		
		// *************************************************
		// vérification si on peut créer un user à partir d'une inscription
		
		switch($this->getInscription_allowed()){
			case 1	: case 2	: case 3	: case 4	: {break;}	//les inscriptions sont permises
			default	: {return $null;}
		}
		
		// *************************************************
		//	Vérification et initialisation des variables
		
		$this->verifie_infos_contact_pour_inscription_ou_modification_contact($infos_from_inscription);
		
		$infos_new_contact['id_civilite']		= 5;
		$infos_new_contact['siret'] 				= '';
		$infos_new_contact['tva_intra'] 		= '';
		$infos_new_contact['id_categorie']	= '1';
		$infos_new_contact['note'] 					= '';
		$infos_new_contact['adresses']			= array();
		$infos_new_contact['coordonnees']		= array();
		$infos_new_contact['sites']					= array();
		
		// *************************************************
		//	Récupération des valeurs de l'inscription 
		
		
		
		$infos_contact = array();
		foreach($infos_from_inscription as &$tmp_ann) {
			$tmp = explode("=", $tmp_ann);
			if (count($tmp)==2) {
				$infos_contact[$tmp[0]] = $tmp[1];
			}
		}
		unset($infos_from_inscription);
		
		// *************************************************
		
		if(isset($infos_contact['civilite']))
		{		$infos_new_contact['id_civilite'] = $infos_contact['civilite'];}
		
		if(!isset($infos_contact['nom']))
		{		return $null;}
		$infos_new_contact['nom'] = $infos_contact['nom'];
		
		if(isset($infos_contact['siret']))
		{		$infos_new_contact['siret']  = $infos_contact['siret'];}
		
		if(isset($infos_contact['tva_intra']))
		{		$infos_new_contact['tva_intra'] = $infos_contact['tva_intra'];}
		
		if(!isset($infos_contact['id_categorie']))
		{		return $null;}
		$infos_new_contact['id_categorie'] = $infos_contact['id_categorie'];
		
		if(isset($infos_contact['note']))
		{		$infos_new_contact['note']  = $infos_contact['note'];}
		
		if(!isset($infos_contact['adresse_adresse']))
		{		return $null;}
		
		if(!isset($infos_contact['admin_emaila']))
		{			return $null;}

		
		if(!isset($infos_contact['coordonnee_tel1']))
		{			$infos_contact['coordonnee_tel1'] = "";}
		
		if(!isset($infos_contact['coordonnee_tel2']))
		{			$infos_contact['coordonnee_tel2'] = "";}
		
		if(!isset($infos_contact['coordonnee_fax']))
		{			$infos_contact['coordonnee_fax'] = "";}
		
		$infos_new_contact['coordonnees'][]	= array('lib_coord' => "", 'tel1' => $infos_contact['coordonnee_tel1'], 'tel2' => $infos_contact['coordonnee_tel2'], 'fax' => $infos_contact['coordonnee_fax'], 'email' => $infos_contact['admin_emaila'], 'note' => "", 'ref_coord_parent' => NULL, 'email_user_creation' => 0 );
		
		if(!isset($infos_contact['admin_pseudo']))
		{			return $null;}
		
		if(!isset($infos_contact['admin_passworda']))
		{			return $null;}
		
		// *************************************************
		
		$contact =& $this->inscription_creation_contact($infos_new_contact);
		
		if(is_null($contact))
		{			return $contact;}
		
		require_once("profil_client/_contact_client.class.php");
		$contact_client = new contact_client($contact->getRef_contact());
		
		// *************************************************

		$adresse = new adresse();
		if(isset($infos_contact['livraison_adresse'])){
			if(!$adresse->create($contact->getRef_contact(), "Adresse de Livraison", $infos_contact['livraison_adresse'], $infos_contact['livraison_code'], $infos_contact['livraison_ville'], $infos_contact['id_pays_livraison'], ""))
			{		return false;}
		}else{
			if(!$adresse->create($contact->getRef_contact(), "Adresse de Livraison", $infos_contact['adresse_adresse'], $infos_contact['adresse_code'], $infos_contact['adresse_ville'], $infos_contact['id_pays_contact'], ""))
			{		return false;}
		}
		
		$contact_client->maj_ref_adr_livraison($adresse->getRef_adresse());
		
		// *************************************************
		
		$adresse = new adresse();
		if(!$adresse->create($contact->getRef_contact(), "Adresse de Facturation", $infos_contact['adresse_adresse'], $infos_contact['adresse_code'], $infos_contact['adresse_ville'], $infos_contact['id_pays_contact'], ""))
		{		return false;}

		$contact_client->maj_ref_adr_facturation($adresse->getRef_adresse());
		
		unset($contact_client, $adresse);
		
		// *************************************************
		
		$user =& $this->inscription_creation_user($contact, $infos_contact['admin_pseudo'], $infos_contact['admin_passworda']);
		return $user;
	}
	// Connecter l'utilisateur
	//$_SESSION['user']->login ($infos_from_inscription['admin_pseudo'], $infos_from_inscription['admin_passworda'], "", $infos_from_inscription['profils_inscription']);
	
	
	//créer un nouveau contact grâce aux informations récoltées lors de l'inscriptions.
	//Ce nouveau contact sera retourné (pointer)
	//@param array $infos_from_inscription : informations récupérées lors de l'inscription
	//@return &contact 
	protected function &inscription_creation_contact($infos_from_inscription){
		// *************************************************
		//Profils
		$infos_profils = array();
		$id_profil = 4;
		$infos_profils[$id_profil]['id_profil'] = $id_profil;
		//include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
		
		// *************************************************
		// Création du contact
		$contact = new contact();
		$contact->create($infos_from_inscription, $infos_profils);
		
		if(count($GLOBALS['_ALERTES']) == 0)
		{			return $contact;}
		else{	$null = null; return $null;}
	}
	
	//$this->supprimer_inscription($id_contact_tmp);
	
	
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//créer un nouveau user à partir d'un contact. Ce nouveau user sera retourné (pointer)
	//@param contact &$contact : informations récupérées lors de l'inscription
	//@return &user :  si la création s'est bien passée, on retourne un user, null sinon
	protected function &inscription_creation_user(&$contact, $admin_pseudo, $admin_passworda){
		$utilisateur = null;
		$coord = $contact->getCoordonnees();
		if(isset($coord[0])){
			$utilisateur = new utilisateur();
			$utilisateur->create($contact->getRef_contact(), $coord[0]->getRef_coord(), $admin_pseudo, 1,  $admin_passworda, 1);
		}
		return $utilisateur;
	}
		
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
			
	public static function getInscriptions_attendant_validation($validation_email = -1, $id_contact_tmp = null) {
  	global $bdd;
  	$inscriptions_attendant_validation = array();
  	$to = new stdClass();
		//	Utilisation de la table Table: annuaire_tmp 
		//
		//	id_contact_tmp		smallint(5) UNSIGNED 	NOTNULL	auto_increment	:	
		//	id_interface			smallint(5) UNSIGNED	NOTNULL									:	
		//	infos							mediumtext						NOTNULL									:	liste de couple clé/valeur séparé par un ;
		//	date_demande			datetime							NOTNULL									:	
		//	code_validation		varchar(64)						NOTNULL									:	code pour que l'utilisateur confirme son inscription 
		//	validation_email	tinyint(3)						NOTNULL									:	
		//	mode							enum('inscription', 'modification')	NOTNULL		:	
		
	  $query = "SELECT	id_contact_tmp, id_interface, infos, date_demande, code_validation, validation_email, mode
	  					FROM		annuaire_tmp
	  					WHERE		mode = 'inscription'";
  	if($validation_email >= 0 && is_null($id_contact_tmp))
    	$query .= "&&		validation_email = '".$email."'";
 		elseif(!is_numm($id_contact_tmp))
			$query .= "&&		id_contact_tmp = '".$id_contact_tmp."'";
  	$query .= ";";
  	
  	$resultat = $bdd->query($query);
  	
	  while ($res = $resultat->fetchObject()){
	  	$infos = explode(";", $res->infos);
	    $tab_tmp = array();
	    foreach ($infos as $info) {
	      $tab_tmp2 = explode("=", $info);
	      $tab_tmp[$tab_tmp2[0]] = (isset($tab_tmp2[1])) ? $tab_tmp2[1] : "";
	    }
	    $res->infos = $tab_tmp;
	  	$inscriptions_attendant_validation[] = $res;
	  }
	  
  	return $inscriptions_attendant_validation;
	}
	
	// *************************************************************************************************************
	// Fonctions d'accès aux données
	// *************************************************************************************************************
	
	// Retourne inscription_allowed
	public function getInscription_allowed(){
		if(!isset($this->inscription_allowed))
		{			return false;}
		else{	return $this->inscription_allowed;}
	}
		
	// *************************************************************************************************************
	
	
	//$inscriptions[]["id_contact_tmp"]
	//$inscriptions[]["date_demande"]
	//$inscriptions[]["infos"]
	//$inscriptions[]["id_civilite"]
	//$inscriptions[]["nom"]
	//$inscriptions[]["id_profil"]
	//$inscriptions[]["lib_profil"]
	//$inscriptions[]["id_interface"]
	//$inscriptions[]["lib_interface"]
	//$inscriptions[]["ref_contact"]
	//$inscriptions[]["id_categorie"]
	//$inscriptions[]["lib_categorie"]
	public static function getInscriptions_confirmees(){
		global $bdd;
	  $inscriptions = array();
		
	  $query ="	SELECT	a.id_contact_tmp, a.id_interface, a.infos, a.date_demande, a.validation_email, 
	  									i.id_interface, i.lib_interface, i.dossier, i.id_profil, 
	  									p.id_profil, p.lib_profil, p.code_profil
	  	  			FROM			annuaire_tmp a
	  	  			LEFT JOIN interfaces i ON a.id_interface = i.id_interface
	  	  			LEFT JOIN profils p ON i.id_profil = p.id_profil
	  	  			WHERE		a.validation_email = 1
	  					&&			a.mode = 'inscription'";
	  $resultat = $bdd->query($query);
	  
	  while($res = $resultat->fetchObject()){
	  	$inscriptions[] = array("id_contact_tmp"=> $res->id_contact_tmp,
	  													"date_demande"	=> $res->date_demande, 
	  													"infos"					=> $res->infos,
	  													"id_civilite"		=> InscriptionModification::extractCivilite($res->infos),
	  													"nom"						=> InscriptionModification::extractNom($res->infos),
	  													"id_profil"			=> $res->id_profil,
	  													"lib_profil"		=> $res->lib_profil,
	  													"id_interface"	=> $res->id_interface,
	  													"lib_interface"	=> $res->lib_interface,
	  													"ref_contact"		=> "",
	  		  										"id_categorie"	=> "",
	  													"lib_categorie"	=> "");
	  }
	  return $inscriptions;
	}
	
	//$inscriptions[]["id_contact_tmp"]
	//$inscriptions[]["date_demande"]
	//$inscriptions[]["infos"]
	//$inscriptions[]["id_civilite"]
	//$inscriptions[]["nom"]
	//$inscriptions[]["id_profil"]
	//$inscriptions[]["lib_profil"]
	//$inscriptions[]["id_interface"]
	//$inscriptions[]["lib_interface"]
	//$inscriptions[]["ref_contact"]
	//$inscriptions[]["id_categorie"]
	//$inscriptions[]["lib_categorie"]
	public static function getInscriptions_non_confirmees(){
		global $bdd;
	  $inscriptions = array();
		
	  $query ="	SELECT	a.id_contact_tmp, a.id_interface, a.infos, a.date_demande, a.validation_email, 
	  									i.id_interface, i.lib_interface, i.dossier, i.id_profil, 
	  									p.id_profil, p.lib_profil, p.code_profil
	  	  			FROM			annuaire_tmp a
	  	  			LEFT JOIN interfaces i ON a.id_interface = i.id_interface
	  	  			LEFT JOIN profils p ON i.id_profil = p.id_profil
	  	  			WHERE		a.validation_email = 3
	  	  			||			a.validation_email = 2
	  					&&			a.mode = 'inscription'";
	  $resultat = $bdd->query($query);
	  
	  while($res = $resultat->fetchObject()){
	  	$inscriptions[] = array("id_contact_tmp"=> $res->id_contact_tmp,
	  													"date_demande"	=> $res->date_demande, 
	  													"infos"					=> $res->infos,
	  													"id_civilite"		=> Inscription_compte_user::extractCivilite($res->infos),
	  													"nom"						=> Inscription_compte_user::extractNom($res->infos),
	  													"id_profil"			=> $res->id_profil,
	  													"lib_profil"		=> $res->lib_profil,
	  													"id_interface"	=> $res->id_interface,
	  													"lib_interface"	=> $res->lib_interface,
	  													"ref_contact" 	=> Inscription_compte_user::extractRef_contact($res->infos),
	  		  										"id_categorie"	=> "",
	  													"lib_categorie"	=> "");
	  }
	  return $inscriptions;
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
}


?>