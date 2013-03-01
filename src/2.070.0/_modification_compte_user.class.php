<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES MODIFICATION
// *************************************************************************************************************

class Modification_compte_user extends InscriptionModification {
	private $modification_allowed;
	
	function __construct($id_interface, $modificationAllowed = -1) {
		parent::__construct($id_interface);
		
		if($modificationAllowed == -1){
			// Les valeur pour $this->inscription_allowed ou $this->modificationAllowed n'ont pas étés définies
			// il faut ouvrir les fichier config pour pouvoir charger ces valeurs.
			
			// Lecture du fichier config de l'interface $id_interface
						
			if(file_exists($DIR.$this->getDossier()."_interface.config.php")){
				//L'interface possede son porpre fichier de config -> il est lu
				$chemin_file = $DIR.$this->getDossier()."_interface.config.php";
				if(file_exists($chemin_file)){
					$handle = @fopen($chemin_file, "r");
					if($handle){
						while(!feof($handle) && $modificationAllowed == -1){
							$ligne = fgets($handle);
							$modificationAllowed = $this->search_MODIFICATION_ALLOWED_value($ligne);
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
						while(!feof($handle) && $modificationAllowed == -1){
							$ligne = fgets($handle);
							$modificationAllowed = $this->search_MODIFICATION_ALLOWED_value($ligne);
						}
						fclose($handle);
					}
				}
			}
		}
		
		$this->modification_allowed = $modificationAllowed;
	}
	
	private static function search_MODIFICATION_ALLOWED_value($texte){
		$pattern = '\$MODIFICATION_ALLOWED([^\/]{0,2})*=([^\/]{0,2})*(\d);.*';
		$value_searched = preg_replace('/'.$pattern.'/', '$3', $texte);
		if($value_searched != $texte)//	la valeur a été trouvée
		{			return intval($value_searched);}
		else{ return -1;}
	}
	
	// *************************************************************************************************************
	// Fonctions d'accès aux données
	// *************************************************************************************************************
	
	// Retourne inscription_allowed
	public function getModification_allowed(){
		if(!isset($this->modification_allowed))
		{			return false;}
		else{	return $this->modification_allowed;}
	}
	
	// *************************************************************************************************************
	// *************************************************************************************************************
	// MODIFICATION DU COMPTE D'UN CONTACT
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
	//																																				 - soit c'est une modification sans confirmation
	//																																				 - soit c'est une modification avec confirmation, mais l'utilisateur a déjà confirmé son modification
	//																																		2 => validation par un collab : cet utilisateur doit confirmer son modification pour pouvoir passer 
	//																																				 à l'étape suivante : validation_email <- 1
	//																																		3 => validation automatique : cet utilisateur doit confirmer son modification pour pouvoir passer 
	//																																				 à l'étape suivante (modification du contact et supression de la ligne)
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
	//	FONCTIONNEMENT DE La modification
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->modification_allowed == 0 : modification interdite
	//	modification_contact => retourne faux
	//
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->modification_allowed == 1 : modification d'un contact avec une validation par un collaborateur mais sans un mail de confirmation
	//		etape 1 la modification est enregistrée
	//		modification_contact
	//			modification_contact_avec_validation_sans_mail_confirmation
	//				modification_contact_avec_validation_get_sujet_pour_contact
	//				modification_contact_avec_validation_get_message_pour_contact
	//				modification_contact_avec_validation_get_sujet_pour_collaborateur
	//				modification_contact_avec_validation_get_message_pour_collaborateur
	//				getEmail_du_collaborateur
	//				envoi_email_templated => CONTACT
	//				envoi_email_templated => COLLABORATEUR
	//		
	//		etape 2A le collab valide la modification
	//			validation_modification_contact_par_collaborateur
	//				validation_modification_contact
	//				supprimer_modification
	//				validation_modification_contact_par_collaborateur_get_suejt_pour_contact
	//				validation_modification_contact_par_collaborateur_get_message_pour_contact
	//				envoi_email_templated => CONTACT
	//
	//		atape 2B	le collab invalide la modification
	//			refus_modification_contact_par_collaborateur
	//
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->modification_allowed == 3 : modification d'un contact avec une validation par un collaborateur mais avec un mail confirmation
	//		etape 1 la modification est enregistrée
	//		modification_contact
	//			modification_contact_avec_validation_avec_mail_confirmation
	//				modification_contact_avec_validation_avec_mail_confirmation_get_sujet_pour_contact
	//				modification_contact_avec_validation_avec_mail_confirmation_get_message_pour_contact
	//				envoi_email_templated => CONTACT
	//
	//		etape 2 l'utilisateur reçoit le mail et confirme sa modification
	//		contact_confirme_sa_modification
	//			contact_confirme_sa_modification_puis_validation_par_collab
	//				modification_contact_avec_validation_get_sujet_pour_contact
	//				modification_contact_avec_validation_get_message_pour_contact
	//				modification_contact_email_du_contact
	//				modification_contact_avec_validation_get_sujet_pour_collaborateur
	//				modification_contact_avec_validation_get_message_pour_collaborateur
	//				getEmail_du_collaborateur
	//				envoi_email_templated => CONTACT
	//				envoi_email_templated => COLLABORATEUR
	//
	//		etape 3A le collab valide la modification
	//			validation_modification_contact_par_collaborateur
	//				validation_modification_contact
	//				supprimer_modification
	//				validation_modification_contact_par_collaborateur_get_suejt_pour_contact
	//				validation_modification_contact_par_collaborateur_get_message_pour_contact
	//				envoi_email_templated => CONTACT
	//
	//		atape 3B	le collab invalide la modification
	//			refus_modification_contact_par_collaborateur
	//	
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->modification_allowed == 2 : modification d'un contact automatique sans mail de confirmation
	//		etape 1 la modification est enregistrée
	//		modification_contact
	//			modification_contact_automatique_sans_mail_confirmation
	//				validation_modification_contact
	//				modification_automatique_sans_mail_confirmation_get_suejt_pour_contact
	//				modification_automatique_sans_mail_confirmation_get_message_pour_contact
	//				envoi_email_templated => CONTACT
	//	
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	//	$this->modification_allowed == 4 : modification d'un contact automatique avec mail de confirmation
	//		etape 1 la modification est enregistrée
	//		modification_contact
	//			modification_contact_automatique_avec_mail_confirmation
	//				modification_contact_automatique_avec_mail_confirmation_get_sujet_pour_contact
	//				modification_contact_automatique_avec_mail_confirmation_get_message_pour_contact
	//				envoi_email_templated => CONTACT
	//
	//		etae 2 l'utilisateur reçoit le mail et confirme son modification
	//		contact_confirme_sa_modification
	//			contact_confirme_sa_modification_puis_validation_automatique
	//				validation_modification_contact
	//				supprimer_modification
	//				modification_contact_automatique_get_sujet_pour_contact
	//				modification_contact_automatique_get_message_pour_contact
	//				modification_contact_email_du_contact
	//				envoi_email_templated => CONTACT
	//	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//lance la procedure de modification pour un contact
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean	: vrai si la modification du contact s'est bien passé, faux sinon.
	//attention, la modification peut se faire en plusieurs temps suivant la valeur de $this->modification_allowed
	public function modification_contact($ref_contact, $infos_contact, $email){	
		//vérification des paramètres d'entré
		if(is_null($infos_contact) || !is_array($infos_contact) || !$this->verifie_infos_contact_pour_inscription_ou_modification_contact($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		switch ($this->getModification_allowed()){
			case 0 : {	return false;}	//modification interdite
			
			case 1 : {	return $this->modification_contact_avec_validation_sans_mail_confirmation($ref_contact, $infos_contact, $email); break;}
			case 3 : {	return $this->modification_contact_avec_validation_avec_mail_confirmation($ref_contact, $infos_contact, $email); break;}
			
			case 2 : {	return $this->modification_contact_automatique_sans_mail_confirmation($ref_contact, $infos_contact, $email); break;}
			case 4 : {	return $this->modification_contact_automatique_avec_mail_confirmation($ref_contact, $infos_contact, $email); break;}
			
			default: {	return false;}	//valeur non permises
		}
	}
	
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	// MODIFICATION D'UN CONTACT AVEC VALIDATION 
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	
	//procedure de modification pour un contact AVEC VALIDATION et SANS MAIL DE CONFIRMATION
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si l'inscrition du contact s'est bien passé, faux sinon. 
	protected function modification_contact_avec_validation_sans_mail_confirmation($ref_contact, $infos_contact, $email){
		global $bdd;
		
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getModification_allowed() != 1)
		{		return false;}		

		$code_validation = "";
		$query = "INSERT INTO annuaire_tmp
							(id_interface, infos, date_demande, code_validation, validation_email, mode) VALUES 
	 						(".$this->getId_interface().", '".addslashes(implode(";", $infos_contact))."', NOW(), '".$code_validation."', 1, 'modification')";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
		
		$id_contact_tmp = $bdd->lastInsertId();
		
		$sujet_pour_contact		= $this->modification_contact_avec_validation_get_sujet_pour_contact();
		$message_pour_contact	= $this->modification_contact_avec_validation_get_message_pour_contact();
		$email_contact				= $email;
		
		$sujet_pour_collaborateur		= $this->modification_contact_avec_validation_get_sujet_pour_collaborateur();
		$message_pour_collaborateur	= $this->modification_contact_avec_validation_get_message_pour_collaborateur();
		$email_collaborateur				= $this->getEmail_du_collaborateur();
		if($email_collaborateur === false)
		{		return false;}
		
		return	$this->envoi_email_templated($email_contact, 				$sujet_pour_contact,				$message_pour_contact)
		&&			$this->envoi_email_templated($email_collaborateur,	$sujet_pour_collaborateur,	$message_pour_collaborateur);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//procedure de modification pour un contact AVEC VALIDATION et AVEC MAIL DE CONFIRMATION
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si la modification du contact s'est bien passé, faux sinon. 
	protected function modification_contact_avec_validation_avec_mail_confirmation($ref_contact, $infos_contact, $email){
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getModification_allowed() != 3)
		{		return false;}
		
		$code_validation = creer_code_unique($email, $this->getId_interface());
		
		global $bdd;
		$query = "INSERT INTO annuaire_tmp
							(id_interface, infos, date_demande, code_validation, validation_email, mode) VALUES 
	 						(".$this->getId_interface().", '".addslashes(implode(";", $infos_contact))."', NOW(), '".$code_validation."', 2, 'modification')";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
		
		$id_contact_tmp = $bdd->lastInsertId();
		
		$sujet_pour_contact		= $this->modification_contact_avec_validation_avec_mail_confirmation_get_sujet_pour_contact();
		$message_pour_contact	= $this->modification_contact_avec_validation_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation);
		$email_contact				= $email;
		
		return	$this->envoi_email_templated($email_contact, 				$sujet_pour_contact,				$message_pour_contact);
	}
		
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (modification avec validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->modification_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_avec_validation_get_sujet_pour_contact(){
		return "modification de votre compte sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (modification avec validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->modification_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_avec_validation_get_message_pour_contact(){
		global $INFO_LOCALE;
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour,<br />
		Vous venez de modifier mes information concernant votre compte.<br />
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
	
	//sujet du mail envoyé A UN COLLABORATEUR quand un utilisateur s'inscrit sur le site (modification avec validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->modification_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_avec_validation_get_sujet_pour_collaborateur(){
		return "modification d'un compte sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//corps du mail envoyé A UN COLLABORATEUR quand un utilisateur s'inscrit sur le site (modification avec validation)
	//@return string : retourne le corps de l'email envoyé par la fonction Inscription->modification_contact_avec_validation_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_avec_validation_get_message_pour_collaborateur(){
		global $INFO_LOCALE;
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour,<br />
		Un utilisateur vient de modifier son compte sur '".$this->getLib_interface()."' du site '".$_SERVER['HTTP_HOST']."'<br />
		Vous devez valider cette modification à partir de votre interface collaborateur.
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
	
	//sujet du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (modification avec validation)
	//ce message invite l'utilisateur à confirmer sa modification (avant toute autre validation)
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->modification_contact_avec_validation_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_avec_validation_avec_mail_confirmation_get_sujet_pour_contact(){
		return "modification de votre compte sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR quand il s'inscrit sur le site (modification avec validation)
	//ce message invite l'utilisateur à confirmer sa modification (avant toute autre validation)
	//@return string : retourne le message de l'email envoyé par la fonction Inscription->modification_contact_avec_validation_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_avec_validation_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation){
		global $INFO_LOCALE;
		
		$my_pathinfo = pathinfo(str_replace(str_replace("/",  "\\", $_SERVER['DOCUMENT_ROOT']), "", __FILE__));
		
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour,<br />
		La finalisation de la modification de votre compte se fait en deux étape.<br />
		Premièrement, vous devez confirmer votre modification en cliquant ou en copiant/collant le lien ci-dessous.<br />
		<br />
		http://".$_SERVER['HTTP_HOST']."/".$my_pathinfo["dirname"]."/".$this->getDossier()."_modification_valide.php?id_contact_tmp=".$id_contact_tmp.
		"&code_validation=".$code_validation."&modification_allowed=".$this->getModification_allowed()."<br />
		<br />
		Deuxièmement, un de nos collaborateurs va prochainement valider votre fiche. Vous recevrez alors un email de confirmation.<br />
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
	
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	// MODIFICATION D'UN CONTACT AUTOMATIQUE
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	
	//procedure de modification pour un contact AUTOMATIQUE et SANS MAIL de confirmation
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si l'inscrition du contact s'est bien passé, faux sinon.
	protected function modification_contact_automatique_sans_mail_confirmation($ref_contact, $infos_contact, $email){
		global $bdd;
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getModification_allowed() != 2)
		{		return false;}
		
		if(!$this->validation_modification_contact($ref_contact, $infos_contact))
		{			return false;}
		
		$sujet_pour_contact		= $this->modification_contact_automatique_sans_mail_confirmation_get_suejt_pour_contact();
		$message_pour_contact	= $this->modification_contact_automatique_sans_mail_confirmation_get_message_pour_contact();
		$email_contact				= $email;
		
		return	$this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé à l'UTILISATEUR pour lui indiquer que sa modification est terminée
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->modification_contact_automatique_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_automatique_sans_mail_confirmation_get_suejt_pour_contact(){
		return "modification sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR pour lui indiquer que sa modification est terminée
	//@return string : retourne le message de l'email envoyé par la fonction Inscription->modification_contact_automatique_sans_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_automatique_sans_mail_confirmation_get_message_pour_contact(){
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
	
	//procedure de modification pour un contact AUTOMATIQUE et SANS MAIL de confirmation
	//@param $infos_contact array : tableau associatif contenant les informations du contact
	//@param $email string : email du contact.
	//@return boolean : vrai si l'inscrition du contact s'est bien passé, faux sinon.
	protected function modification_contact_automatique_avec_mail_confirmation($ref_contact, $infos_contact, $email){
		if(is_null($infos_contact) || !is_array($infos_contact))
		{		return false;}
		
		if(is_null($email) || !is_string($email))
		{		return false;}
		
		if($this->getModification_allowed() != 4)
		{		return false;}
		
		$code_validation = creer_code_unique($email, $this->getId_interface());
		
		global $bdd;
		$query = "INSERT INTO annuaire_tmp
							(id_interface, infos, date_demande, code_validation, validation_email, mode) VALUES 
	 						(".$this->getId_interface().", '".addslashes(implode(";", $infos_contact))."', NOW(), '".$code_validation."', 3, 'modification')";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
		
		$id_contact_tmp = $bdd->lastInsertId();
		
		$sujet_pour_contact		= $this->modification_contact_automatique_avec_mail_confirmation_get_sujet_pour_contact();
		$message_pour_contact	= $this->modification_contact_automatique_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation);
		$email_contact				= $email;
		
		return	$this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//sujet du mail envoyé à l'UTILISATEUR pour qu'il confirme son modification automatique
	//@return string : retourne le sujet de l'email envoyé par la fonction Inscription->modification_contact_automatique_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_automatique_avec_mail_confirmation_get_sujet_pour_contact(){
		return "Confirmation de votre email pour votre modification sur ".$_SERVER['HTTP_HOST'];
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//message du mail envoyé à l'UTILISATEUR pour qu'il confirme son modification automatique
	//@return string : retourne le message de l'email envoyé par la fonction Inscription->modification_contact_automatique_avec_mail_confirmation()
	//Pour personnaliser ce message, il faut créer un sous classe et redéfinir la fonction.
	//Cette nouvelle classe sera propre au E-commerce, donc, elle sera dans son dossier !
	protected function modification_contact_automatique_avec_mail_confirmation_get_message_pour_contact($id_contact_tmp, $code_validation){
		global $INFO_LOCALE;
		
		$my_pathinfo = pathinfo(str_replace(str_replace("/",  "\\", $_SERVER['DOCUMENT_ROOT']), "", __FILE__));
		
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour et bienvenue,<br />
		Pour finaliser votre modification sur notre site, vous confirmer votre email en cliquant ou en copiant/collant le lien ci-dessous.<br />
		<br />
		http://".$_SERVER['HTTP_HOST']."/".$my_pathinfo["dirname"]."/".$this->getDossier()."_modification_valide.php?id_contact_tmp=".$id_contact_tmp.
		"&code_validation=".$code_validation."&modification_allowed=".$this->getModification_allowed()."<br />
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
	
	//procedure pour qu'un contact confirme sa modification après avoir reçu un mail l'invitant à le faire
	//envoyé par Inscription->modification_contact_avec_validation_avec_mail_confirmation()
	//		ou par Inscription->modification_contact_automatique_avec_mail_confirmation()
	//Après cette étape un collaborateur devra valider cette modification
	//@param $id_contact_tmp int : 
	//@param $code string : 
	//@return boolean : vrai si la confirmation de la modification du contact s'est bien passé, faux sinon.
	protected function contact_confirme_sa_modification_puis_validation_automatique($id_contact_tmp, $code){
		if($this->getModification_allowed() != 4)
		{		return false;}
		
		$email_contact = $this->modification_contact_email_du_contact($id_contact_tmp);
		
		//si le code est bon on confirme la modification
		if(!verifier_code_unique($code, $email_contact, $this->getId_interface()))
		{		return false;}
	 	
		global $bdd;
		$query = "SELECT	infos
							FROM 		annuaire_tmp
							WHERE		id_contact_tmp = ".$id_contact_tmp."";
		$resultat = $bdd->query ($query);
		if (!$res = $resultat->fetchObject())
		{		return false;}
		
		$ref_contact = $this->extractRef_contact($res->infos);
		
		if($ref_contact === false)
		{		return false;}
		
		$resultat = $this->validation_modification_contact($ref_contact, explode(";", $res->infos));
		if($resultat === false)
		{			return false;}
		
		if(!$this->supprimer_modification($id_contact_tmp))
		{			return false;}
		
		$sujet_pour_contact		= $this->modification_contact_automatique_sans_mail_confirmation_get_suejt_pour_contact();
		$message_pour_contact	= $this->modification_contact_automatique_sans_mail_confirmation_get_message_pour_contact();
		if($email_contact === false)
		{		return false;}
		
		return	$this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact);
	}
	
	
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	// CONFIRMATION DE LA PART DE L'UTILISATEUR DE SON MODIFICATION (ne pas confondre avec la validation par un collab) 
	// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *
	
	//procedure pour qu'un contact confirme sa modification après avoir reçu un mail l'invitant à le faire
	//envoyé par Inscription->modification_contact_avec_validation_avec_mail_confirmation()
	//		ou par Inscription->modification_contact_automatique_avec_mail_confirmation()
	//@param $id_contact_tmp int : 
	//@param $code string : 
	//@return boolean : vrai si la confirmation de la modification du contact s'est bien passé, faux sinon. 
	public function contact_confirme_sa_modification($id_contact_tmp, $code){
		//vérification des paramètres d'entré
		if(is_null($id_contact_tmp) || !is_numeric($id_contact_tmp))
		{		return false;}
		
		if(is_null($code) || !is_string($code))
		{		return false;}
		
		if($this->getModification_allowed() === false)
		{		return false;}
		
		switch ($this->getModification_allowed()){
			case 0 : {	return false;}	//modification interdite
			
			case 1 : {	return false;}	//la confirmation n'est pas néncessaire
			case 3 : {	return $this->contact_confirme_sa_modification_puis_validation_par_collab($id_contact_tmp, $code); break;}
			
			case 2 : {	return false;}	//la confirmation n'est pas néncessaire
			case 4 : {	return $this->contact_confirme_sa_modification_puis_validation_automatique($id_contact_tmp, $code); break;}
			
			default: {	return false;}	//valeur non permises
		}
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//procedure pour qu'un contact confirme sa modification après avoir reçu un mail l'invitant à le faire
	//envoyé par Inscription->modification_contact_avec_validation_avec_mail_confirmation()
	//		ou par Inscription->modification_contact_automatique_avec_mail_confirmation()
	//Après cette étape un collaborateur devra valider cette modification
	//@param $id_contact_tmp int : 
	//@param $code string : 
	//@return boolean : vrai si la confirmation de lamodificationon du contact s'est bien passé, faux sinon.
	protected function contact_confirme_sa_modification_puis_validation_par_collab($id_contact_tmp, $code){
		if($this->getModification_allowed() != 3)
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
		
		//si le code est bon on confirme la modification
		if(!verifier_code_unique($code, $email, $this->getId_interface()))
		{		return false;}
		
		$query = "UPDATE annuaire_tmp  SET validation_email = 1
							WHERE id_contact_tmp = '".$id_contact_tmp."' ";
		if($bdd->exec($query) == 0)
		{		return false;}	//Aucune ligne n'é été modifiée
				
		$sujet_pour_contact		= $this->modification_contact_avec_validation_get_sujet_pour_contact();
		$message_pour_contact	= $this->modification_contact_avec_validation_get_message_pour_contact();
		$email_contact				= $this->modification_contact_email_du_contact($id_contact_tmp);
		if($email_contact === false)
		{		return false;}
		
		$sujet_pour_collaborateur		= $this->modification_contact_avec_validation_get_sujet_pour_collaborateur();
		$message_pour_collaborateur	= $this->modification_contact_avec_validation_get_message_pour_collaborateur();
		$email_collaborateur				= $this->getEmail_du_collaborateur();
		if($email_collaborateur === false)
		{		return false;}
		
		return	$this->envoi_email_templated($email_contact, 				$sujet_pour_contact,				$message_pour_contact)
		&&			$this->envoi_email_templated($email_collaborateur,	$sujet_pour_collaborateur,	$message_pour_collaborateur);
	}
	
	
	// *************************************************************************************************************
	// VALIDATION DE LA MODIFICATION
	// *************************************************************************************************************
	
	
	public function refus_modification_contact_par_collaborateur($id_contact_tmp){
		return $this->supprimer_modification($id_contact_tmp);
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	public function validation_modification_contact_par_collaborateur($id_contact_tmp){
		// vérification si on peut créer un user à partir d'une modification
		switch ($this->getModification_allowed()){
			case 1 : case 2 : case 3: case 4 : {break;}	//les modifications sont permises
			default : {return false;}
		}
		global $bdd;
		
		$query = "SELECT	infos
							FROM 		annuaire_tmp
							WHERE		id_contact_tmp = ".$id_contact_tmp."";
		$resultat = $bdd->query ($query);
		if (!$res = $resultat->fetchObject())
		{		return false;}
		
		$ref_contact = $this->extractRef_contact($res->infos);

		if($ref_contact === false)
		{		return false;}
		
		$resultat = $this->validation_modification_contact($ref_contact, explode(";", $res->infos));
		if($resultat === false)
		{		return false;}
		
		if($this->supprimer_modification($id_contact_tmp) === false)
		{		return false;}
	
		$sujet_pour_contact		= $this->validation_modification_contact_par_collaborateur_get_suejt_pour_contact();
		$message_pour_contact	= $this->validation_modification_contact_par_collaborateur_get_message_pour_contact();
		$email_contact				= $this->extractEmail($res->infos);
		if($email_contact === false)
		{		return false;}
		
		return $this->envoi_email_templated($email_contact, $sujet_pour_contact, $message_pour_contact);
	}
	
	protected function validation_modification_contact_par_collaborateur_get_suejt_pour_contact(){
		return "modification sur ".$_SERVER['HTTP_HOST'];
	}
	
	protected function validation_modification_contact_par_collaborateur_get_message_pour_contact(){
		global $INFO_LOCALE;
		return "Date d'envois ".lmb_strftime('le %A %d %B %Y à %H:%M:%S', $INFO_LOCALE)."<br />
		<br />
		Bonjour,<br />
		Votre modification vient d'être validée, Vous pouvez maintenant vous connecter sur ".$_SERVER['HTTP_HOST']." à l'aide de votre login et mot de passe 
		<br />
		<br />
		".$this->getNom_entreprise()."
		<br />
		<br />
		-------------------------------------------------------------------------------------------------------------------------<br />
		";
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	protected function validation_modification_contact($ref_contact, $infos_from_modification){
		global $bdd;
		
		if(!is_string($ref_contact) || $ref_contact == "" )
		{		return false;}
		
		// *************************************************
		// vérification si on peut créer un user à partir d'une modification
		
		switch($this->getModification_allowed()){
			case 1	: case 2	: case 3	: case 4	: {break;}	//les modifications sont permises
			default	: {return $null;}
		}
		
		// *************************************************
		//	Vérification et initialisation des variables
		
		$this->verifie_infos_contact_pour_inscription_ou_modification_contact($infos_from_modification);
		
		$infos_edit_contact['id_civilite']	= 5;
		$infos_edit_contact['siret'] 				= '';
		$infos_edit_contact['tva_intra'] 		= '';
		$infos_edit_contact['id_categorie']	= '1';
		$infos_edit_contact['note'] 				= '';
		$infos_edit_contact['sites']				= array();
		
		// *************************************************
		//	Récupération des valeurs de l'modification 
		
		
		
		$infos_contact = array();
		foreach($infos_from_modification as &$tmp_ann) {
			$tmp = explode("=", $tmp_ann);
			if (count($tmp)==2) {
				$infos_contact[$tmp[0]] = $tmp[1];
			}
		}
		unset($infos_from_modification);
		
		// *************************************************
		if(isset($infos_contact['id_civilite']))
		{		$infos_edit_contact['id_civilite'] = $infos_contact['id_civilite'];}
		
		if(!isset($infos_contact['nom']))
		{		return $null;}
		$infos_edit_contact['nom'] = $infos_contact['nom'];
		
		if(isset($infos_contact['siret']))
		{		$infos_edit_contact['siret']  = $infos_contact['siret'];}
		
		if(isset($infos_contact['tva_intra']))
		{		$infos_edit_contact['tva_intra'] = $infos_contact['tva_intra'];}
		
		if(!isset($infos_contact['id_categorie']))
		{		return $null;}
		$infos_edit_contact['id_categorie'] = $infos_contact['id_categorie'];
		
		if(isset($infos_contact['note']))
		{		$infos_edit_contact['note']  = $infos_contact['note'];}
		
		if(!$this->modification_edition_contact($ref_contact, $infos_edit_contact))
		{		return false;}
		
		// *************************************************
		$ref_adresse_facturation = adresse::getRef_adresse_from_ordre($ref_contact, 2);
		
		if(!isset($infos_contact['adresse_adresse']))
		{			$infos_contact['adresse_adresse'] = "";}
		
		if(!isset($infos_contact['adresse_code']))
		{			$infos_contact['adresse_code'] = "";}
		
			if(!isset($infos_contact['adresse_ville']))
		{			$infos_contact['adresse_ville'] = "";}
		
		if(!isset($infos_contact['id_pays_contact']))
		{			$infos_contact['id_pays_contact'] = "";}
		
		if($ref_adresse_facturation != ""){// l'adresse de facturation exitse -> édition
			$adresse = new adresse($ref_adresse_facturation);
			$adresse->modification("Adresse de Facturation", $infos_contact['adresse_adresse'], $infos_contact['adresse_code'], $infos_contact['adresse_ville'], $infos_contact['id_pays_contact'], "",false);
		}else{//l'adresse de facturation n'exitse pas -> création
			$adresse = new adresse();
			if(!$adresse->create($ref_contact, "Adresse de Facturation", $infos_contact['adresse_adresse'], $infos_contact['adresse_code'], $infos_contact['adresse_ville'], $infos_contact['id_pays_contact'], ""))
			{		return false;}
		}
		unset($adresse);
		
		// *************************************************
		$ref_adresse_livraison = adresse::getRef_adresse_from_ordre($ref_contact, 1);
		
		if(!isset($infos_contact['livraison_adresse']))
		{			$infos_contact['livraison_adresse'] = "";}
		
		if(!isset($infos_contact['livraison_code']))
		{			$infos_contact['livraison_code'] = "";}
		
			if(!isset($infos_contact['livraison_ville']))
		{			$infos_contact['livraison_ville'] = "";}
		
		if(!isset($infos_contact['id_pays_livraison']))
		{			$infos_contact['id_pays_livraison'] = "";}
		
		if($ref_adresse_livraison != ""){//l'adresse de livraison existe -> édition
			$adresse = new adresse($ref_adresse_livraison);			
			$adresse->modification("Adresse de Livraison", $infos_contact['livraison_adresse'], $infos_contact['livraison_code'], $infos_contact['livraison_ville'], $infos_contact['id_pays_livraison'], "",false);
			unset($adresse);
		}else{//l'adresse de livraison n'existe pas -> création
			$adresse = new adresse();
			if(!$adresse->create($ref_contact, "Adresse de Livraison", $infos_contact['livraison_adresse'], $infos_contact['livraison_code'], $infos_contact['livraison_ville'], $infos_contact['id_pays_livraison'], ""))
			{		return false;}
		}
		unset($adresse);
		
		// *************************************************
		if(!isset($infos_contact['coordonnee_tel1']))
		{			$infos_contact['coordonnee_tel1'] = "";}
		
		if(!isset($infos_contact['coordonnee_tel2']))
		{			$infos_contact['coordonnee_tel2'] = "";}
		
		if(!isset($infos_contact['coordonnee_fax']))
		{			$infos_contact['coordonnee_fax'] = "";}
		
		if(!isset($infos_contact['admin_emaila']))
		{			return false;}

		// *************************************************
		$ref_coordonnee = coordonnee::getRef_coord_from_ordre($ref_contact, 1);
		
		if($ref_coordonnee != ""){//l'adresse de livraison existe -> édition
			$coordonnee = new coordonnee($ref_coordonnee);
			$coordonnee->modification("Coordonnées principales", $infos_contact['coordonnee_tel1'], $infos_contact['coordonnee_tel2'], $infos_contact['coordonnee_fax'], $infos_contact['admin_emaila'], "", "",false);
		}else{//l'adresse de livraison n'existe pas -> création
			$coordonnee = new coordonnee();
			if(!$coordonnee->create($ref_contact, "Coordonnées principales", $infos_contact['coordonnee_tel1'], $infos_contact['coordonnee_tel2'], $infos_contact['coordonnee_fax'], $infos_contact['admin_emaila'], "", "", ""))
			{		return false;}
		}
		unset($coordonnee);
		// *************************************************

		if(!isset($infos_contact['admin_pseudo']))
		{			return $null;}
		
		if(!isset($infos_contact['admin_passworda']))
		{			$infos_contact['admin_passworda'] = "";}
		
		if(!isset($infos_contact['admin_passwordold']))
		{			$infos_contact['admin_passwordold'] = "";}
		
		// *************************************************
		
		return $this->modification_edition_user($ref_contact, $infos_contact['admin_pseudo'], $infos_contact['admin_passworda'],  $infos_contact['admin_passwordold']);
	}
	// Connecter l'utilisateur
	//$_SESSION['user']->login ($infos_from_modification['admin_pseudo'], $infos_from_modification['admin_passworda'], "", $infos_from_modification['profils_modification']);
	
	
	//créer un nouveau contact grâce aux informations récoltées lors de l'modifications.
	//Ce nouveau contact sera retourné (pointer)
	//@param string $ref_contact : référence du contact
	//@param array $infos_from_modification : informations récupérées lors de l'modification
	//@return boolean : retourne vrai si la modification a eu lieu et s'est bien déroulée, faux sinon
	protected function modification_edition_contact($ref_contact, $infos_from_modification){
		//// *************************************************
		////Profils
		///$infos_profils = array();
		//$id_profil = 4;
		//$infos_profils[$id_profil]['id_profil'] = $id_profil;
		////include_once ("./profil_create_".$_SESSION['profils'][$id_profil]->getCode_profil().".inc.php");
		
		// *************************************************
		// Création du contact
		$contact = new contact($ref_contact);
		$contact->modification($infos_from_modification);
		$contact->maj_tva_intra($infos_from_modification['tva_intra']);
		
		return count($GLOBALS['_ALERTES']) == 0;
	}
	
	//$this->supprimer_modification($id_contact_tmp);
	
	
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
	//Edite un user
	//@param string $ref_contact : informations récupérées lors de l'modification
	//@param string $pseudo : 
	//@param string $password : 
	//@return boolean :  si la l'édition de l'utilisateur s'est bien passée, faux sinon.
	protected function modification_edition_user($ref_contact, $pseudo, $password, $password_old){
		$password_changed = false;
		$ref_utilisateur = utilisateur::getRef_user_from_ordre($ref_contact, 1);// @todo : modifier la structure pour récupérer le bon utilisateur s'il y en a plusieurs !
		if($ref_utilisateur == "")
		{		return false;}
		// *************************************************
		$utilisateur = new utilisateur($ref_utilisateur);
		
		if($password != "" || $password_old != ""){	//modification du mot de passe
			if($password != "" && $password_old != ""){
				global $bdd;
				$query = "SELECT 	count(u.ref_user) as IS_OK
									FROM 		users u
									WHERE 	u.ref_user = '".$ref_utilisateur."'
									&&			u.code = md5('".$password_old."')";
				$resultat = $bdd->query($query);
				$password_changed = ($r = $resultat->fetchObject()) && $r->IS_OK && $utilisateur->changer_code($password);
			}
		}else{	$password_changed = true;	}
		return $password_changed && $utilisateur->modification($utilisateur->getRef_coord_user(), $pseudo, $utilisateur->getActif(), $utilisateur->getId_langage());
	}
	
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	
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
	public static function getModifications_confirmees(){
		global $bdd;
	  $inscriptions = array();
		
	  $query ="	SELECT	a.id_contact_tmp, a.id_interface, a.infos, a.date_demande, a.validation_email, 
	  									i.id_interface, i.lib_interface, i.dossier, i.id_profil, 
	  									p.id_profil, p.lib_profil, p.code_profil
	  	  			FROM			annuaire_tmp a
	  	  			LEFT JOIN interfaces i ON a.id_interface = i.id_interface
	  	  			LEFT JOIN profils p ON i.id_profil = p.id_profil
	  	  			WHERE		a.validation_email = 1
	  					&&			a.mode = 'modification'";
	  $resultat = $bdd->query($query);
	  
	  while($res = $resultat->fetchObject()){
	  	$inscriptions[] = array("id_contact_tmp"=> $res->id_contact_tmp,
	  													"date_demande"	=> $res->date_demande, 
	  													"infos"					=> $res->infos,
	  													"id_civilite"		=> Modification_compte_user::extractCivilite($res->infos),
	  													"nom"						=> Modification_compte_user::extractNom($res->infos),
	  													"id_profil"			=> $res->id_profil,
	  													"lib_profil"		=> $res->lib_profil,
	  													"id_interface"	=> $res->id_interface,
	  													"lib_interface"	=> $res->lib_interface,
	  													"ref_contact" 	=> Modification_compte_user::extractRef_contact($res->infos),
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
	//$inscriptions[]["id_categorie"]
	//$inscriptions[]["lib_categorie"]
	public static function getModifications_non_confirmees(){
		global $bdd;
	  $inscriptions = array();
		
	  $query ="	SELECT	a.id_contact_tmp, a.id_interface, a.infos, a.date_demande, a.validation_email, 
	  									i.id_interface, i.lib_interface, i.dossier, i.id_profil, p.lib_profil, p.code_profil
	  	  			FROM			annuaire_tmp a
	  	  			LEFT JOIN interfaces i ON a.id_interface = i.id_interface
	  	  			LEFT JOIN profils p ON i.id_profil = p.id_profil
	  	  			WHERE		a.validation_email = 2
	  	  			||			a.validation_email = 3
	  					&&			a.mode = 'modification'";
	  $resultat = $bdd->query($query);
	  
	  while($res = $resultat->fetchObject()){
	  	$inscriptions[] = array("id_contact_tmp"=> $res->id_contact_tmp,
	  													"date_demande"	=> $res->date_demande, 
	  													"infos"					=> $res->infos,
	  													"id_civilite"		=> Modification_compte_user::extractCivilite($res->infos),
	  													"nom"						=> Modification_compte_user::extractNom($res->infos),
	  													"id_profil"			=> $res->id_profil,
	  													"lib_profil"		=> $res->lib_profil,
	  													"id_interface"	=> $res->id_interface,
	  													"lib_interface"	=> $res->lib_interface,
	  													"ref_contact" 	=> Modification_compte_user::extractRef_contact($res->infos),
	  		  										"id_categorie"	=> "",
	  													"lib_categorie"	=> "");
	  }
	  return $inscriptions;
	}
}


?>