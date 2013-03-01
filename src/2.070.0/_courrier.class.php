<?php
// *************************************************************************************************************
// CLASSES REGISSANT LES INFORMATIONS SUR UN COURRIER 
// *************************************************************************************************************
// 
// 
// 
/*
 * 3 classes : 
 * courrier <: CourrierPDFvierge
 * courrier <: CourrierEtendu
 * 
 * Pour un utilisation normale du courrier, nous utiliserons a classe CourrierEtendu.
 * */

// *************************************************************************************************************
// CLASSE Courrier 
// *************************************************************************************************************
abstract class Courrier{

	//@TODO COURRIER : PDF : doc_tmp est-il le bon répertoire pour stocker temporairement un courrier temporaire?
	//exemple : envoi d'un courrier par mail
	public static final function GET_TMP_FOLDER() {return  "doc_tmp/";}
	
	//voir dans la BD la TABLE : COURRIERS
	private $id_type_courrier;
	private $date_courrier;
	private $objet;
	private $contenu;
	
	//voir dans la BD la TABLE : COURRIERS_TYPES 
	private $lib_type_courrier;
	private $code_courrier;
	private $actif;

	//voir dans la BD la TABLE : COURRIERS_ETATS
	private $id_etat_courrier;
	private $lib_etat_courrier;
	//Valeur des différents états
	public static final function ETAT_EN_REDAC(){return 1;}
	public static final function ETAT_REDIGE()  {return 2;}
	public static final function ETAT_ANNULE()  {return 3;}

	private $id_pdf_modele;
	private $lib_pdf_modele;
	private $desc_pdf_modele;
	
	private $id_pdf_type;
	private $lib_pdf_type;
	
	//@TODO COURRIER : MODELE PDF : comment utiliser $code_file
	private $code_file; //code md5 du nom du fichier pdf généré lors de l'envois du document
	private $code_pdf_modele;			// Code du modèle utilisé pour l'impression	

	
	public function __construct($id_type_courrier, $id_pdf_modele,  $id_etat_courrier, $date_courrier, $objet, $contenu){

		global $bdd;
		if (!is_numeric($id_type_courrier) || !is_numeric($id_pdf_modele) || !is_numeric($id_etat_courrier))
			return false;
			
			$query = "SELECT 	ct.id_type_courrier, ct.lib_type_courrier, ct.code_courrier, ct.actif,
											pm.id_pdf_modele, pm.lib_modele, pm.desc_modele, pm.code_pdf_modele, 
											pt.id_pdf_type, pt.lib_pdf_type
					FROM courriers_modeles_pdf cmp
					LEFT JOIN courriers_types ct ON cmp.id_type_courrier = ct.id_type_courrier
					LEFT JOIN pdf_modeles pm ON cmp.id_pdf_modele = pm.id_pdf_modele
					LEFT JOIN pdf_types pt ON pm.id_pdf_type = pt.id_pdf_type
					WHERE cmp.id_type_courrier = '".$id_type_courrier."' AND
								cmp.id_pdf_modele = '".$id_pdf_modele."' ";
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())
			return false; 
		$this->id_pdf_modele = $r->id_pdf_modele;
		$this->lib_pdf_modele = $r->lib_modele;
		$this->desc_pdf_modele = $r->desc_modele;
		$this->code_pdf_modele = $r->code_pdf_modele;
		$this->id_pdf_type = $r->id_pdf_type;
		$this->lib_pdf_type = $r->lib_pdf_type;
		
		$this->date_courrier = $date_courrier;
		$this->objet = $objet;
		$this->contenu = $contenu;
		$this->id_type_courrier = $r->id_type_courrier;
		$this->lib_type_courrier = $r->lib_type_courrier;
		$this->code_courrier = $r->code_courrier;
		$this->actif = $r->actif;

		$this->code_file = md5(uniqid(rand(), true));
		
		if (!$this->setId_etat_courrier($id_etat_courrier))
			return false;
	}

	// *************************************************************************************************************
	// Getters & Setters pour le courrier
	// *************************************************************************************************************
	public function getDate_courrier(){
		return $this->date_courrier;
	}

	protected function setDate_courrier($date_courrier){
		return $this->date_courrier = $date_courrier;
	}
	
	public function getObjet(){
		return $this->objet;
	}
	
	public function setObjet($objet){
		$this->objet = $objet;
	}
	
	public function getContenu(){
		return $this->contenu;
	}
	
	public function setContenu($contenu){


                $search = array(
                    "<BR/>",
                    "&eacute;",
                    "&egrave;",
                    "&apos;",
                    "&agrave;",
                    "&ugrave;",
                    "&euro;"
                );
                $replace = array(
                    "<br>",
                    "é",
                    "è",
                    "'",
                    "à",
                    "ù",
                    "EUR"
                );

		$this->contenu = str_replace($search, $replace, $contenu);
	}
	
	public function getCode_file(){
		return $this->code_file;
	}

	// *************************************************************************************************************
	// Getters & Setters pour l'etat du courrier
	// *************************************************************************************************************
	public function setId_etat_courrier($id_etat_courrier){
		global $bdd;

		if(!is_numeric($id_etat_courrier))
			return false;
		
		$query = "SELECT id_etat_courrier, lib_etat_courrier
							FROM courriers_etats
							WHERE id_etat_courrier = '".$id_etat_courrier."' ";
		$r = $bdd->query ($query);
		if (!$r = $r->fetchObject())
			return false;
			
		$this->id_etat_courrier = $r->id_etat_courrier;
		$this->lib_etat_courrier = $r->lib_etat_courrier;
		return true;
	}
	
	public function getId_etat_courrier(){
		return $this->id_etat_courrier;
	}
	
	public function getLib_etat_courrier(){
		return $this->lib_etat_courrier;
	}
	
	// *************************************************************************************************************
	// Getters & Setters pour le type du courrier
	// *************************************************************************************************************
	public function setId_type_courrier($id_type_courrier){
		global $bdd;

		if(!is_numeric($id_type_courrier))
			return false;
		
		$query = "SELECT id_type_courrier, lib_type_courrier, code_courrier, actif
							FROM courriers_types
							WHERE id_type_courrier = '".$id_type_courrier."' ";
		$r = $bdd->query ($query);
		if (!$r = $r->fetchObject())
			return false; 
		$this->id_type_courrier = $r->id_type_courrier;
		$this->lib_type_courrier = $r->lib_type_courrier;
		$this->code_courrier = $r->code_courrier;
		$this->actif = $r->actif;
		return true;
	}
	
	public function getId_type_courrier(){
		return $this->id_type_courrier;		
	}

	public function getLib_type_courrier(){
		return $this->lib_type_courrier;
	}

	public function getCode_courrier(){
		return $this->code_courrier;
	}
	
	public function getActif(){
		return $this->actif;
	}

	
	public abstract function getExpediteur();
	
	// *************************************************************************************************************
	// Getters & Setters pour le modele PDF
	// *************************************************************************************************************
	public function setId_pdf_modele($id_pdf_modele){
		global $bdd;

		if(!is_numeric($id_pdf_modele))
			return false;
		
		$query = "SELECT pm.id_pdf_modele, pm.id_pdf_type, pm.lib_modele, pm.desc_modele, pm.code_pdf_modele, pt.lib_pdf_type
							FROM pdf_modeles pm LEFT JOIN pdf_types pt ON pm.id_pdf_type = pt.id_pdf_type
							WHERE pm.id_pdf_modele = '".$id_pdf_modele."' ";
		$r = $bdd->query ($query);
		if (!$r = $r->fetchObject())
			return false; 
		
		$this->id_pdf_modele = $r->id_pdf_modele;
		$this->id_pdf_type = $r->id_pdf_type;
		$this->lib_pdf_modele = $r->lib_modele;
		$this->desc_pdf_modele = $r->desc_modele;
		$this->code_pdf_modele = $r->code_pdf_modele;
		$this->lib_pdf_type = $r->lib_pdf_type;

		return true;
	}
	
	public function getId_pdf_modele(){
		return $this->id_pdf_modele;
	}
	
	public function getId_pdf_type(){
		return $this->id_pdf_type;
	}
	
	public function getLib_pdf_modele(){
		return $this->lib_pdf_modele;
	}
	
	public function getDesc_pdf_modele(){
		return $this->desc_pdf_modele;
	}
	
	public function getCode_pdf_modele () {
	    return $this->code_pdf_modele;
	}
	

	public function getLib_pdf_type(){
		return $this->lib_pdf_type;
	}

	/*
	//@TODO COURRIER : MODELE PDF : doit-on utiliser $code_file, et si oui, comment
	public function getCode_file(){
		return $this->code_file; //code md5 du nom du fichier pdf généré lors de l'envois du document
	}
	
	protected  function setCode_file($code_file){
		$this->code_file = $code_file; //code md5 du nom du fichier pdf généré lors de l'envois du document
	}
	*/
	
	// *************************************************************************************************************
	// FONCTIONS DE GENERATION D'UN PDF 
	// *************************************************************************************************************
	public function create_pdf ($print = 0) {	
		// Préférences et options
		$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
		$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
		// Création du fichier
		$pdf = new PDF_etendu ();
		// Sortie
		return $pdf;
	}
		
	// Affiche le PDF du document
	public function view_pdf ($print = 0) {
		$pdf = $this->create_pdf ($print);
	
		// Sortie
		$pdf->Output();
	}
	
	// Affiche le PDF du document
	public function print_pdf () {
		$this->view_pdf(1);
	}

	//changement du code_pdf_modele
	public function change_code_pdf_modele ($code_pdf_modele) {
		$this->code_pdf_modele = $code_pdf_modele;
	} 
}

// *************************************************************************************************************
// CLASSE CourrierPDFvierge
// *************************************************************************************************************
class CourrierPDFvierge extends Courrier{
	
	public function __construct($id_type_courrier, $id_pdf_modele,  $id_etat_courrier, $date_courrier, $objet, $contenu){
		return parent::__construct($id_type_courrier, $id_pdf_modele,  $id_etat_courrier, $date_courrier, $objet, $contenu);	
	}
	
	// *************************************************************************************************************
	// Getters & Setters
	// *************************************************************************************************************
	
	public function getExpediteur(){
		return new utilisateur($_SESSION['user']->getRef_user());
	}
	
	// *************************************************************************************************************
	// FONCTIONS DE GENERATION D'UN PDF 
	// *************************************************************************************************************
	
	// Créé et affiche le PDF d'un document
	public function create_pdf($print = 0) {
		
		$pdf = parent::create_pdf($print);
	
		// Ajout du document au PDF
		$pdf->add_courrier("", $this);
	
		// Sortie
		return $pdf;
	}
}

// *************************************************************************************************************
// CLASSE CourrierEtendu
// *************************************************************************************************************
class CourrierEtendu extends Courrier{
	
	private $id_courrier;
	private $destinataires;
	private $events;

	
	public function __construct($id_courrier = "") {
		global $bdd;
		global $PDF_MODELES_DIR;
		
		if (!is_numeric($id_courrier))
			return false;
		
		$this->id_courrier = $id_courrier;
				
		$query = "SELECT c.id_courrier, c.id_type_courrier, c.id_pdf_modele, c.id_etat_courrier, c.date_courrier, c.objet, c.contenu
							FROM courriers c
							WHERE id_courrier = '".$id_courrier."' ";
		$resultat = $bdd->query ($query);
		if (!$courrier = $resultat->fetchObject()) {
			return false; 
		}

		$this->events = array();
		$query = "SELECT 		ce.id_courrier_event
							FROM 			courriers_events ce
							WHERE 		ce.id_courrier = '".$courrier->id_courrier."' ";
		$resultat = $bdd->query ($query);
		while ($r = $resultat->fetchObject()) {
			$this->events[] = new courrierEvent($r->id_courrier_event);
		}
		
		$this->destinataires = array();
		$query = "SELECT 		cd.ref_destinataire
							FROM 			courriers_destinataires cd
							WHERE 		cd.id_courrier = '".$courrier->id_courrier."' ";
		$resultat = $bdd->query ($query);
		while ($r = $resultat->fetchObject()) {
			$this->destinataires[] = new contact($r->ref_destinataire);
		}
		
		return (parent::__construct($courrier->id_type_courrier, $courrier->id_pdf_modele, $courrier->id_etat_courrier, $courrier->date_courrier, $courrier->objet, $courrier->contenu)&& true);
}

	public final static function newCourrierEtendu($id_type_courrier, $id_pdf_modele, $id_etat_courrier, $date_courrier, $objet, $contenu, $ref_destinataire, $utilisateur){

		if (!is_numeric($id_type_courrier) || !is_numeric($id_pdf_modele) || !is_numeric($id_etat_courrier) || $ref_destinataire=="")
			return false;

		if(is_null($utilisateur))
			$utilisateur = $_SESSION['user'];

                $search = array(
                    "<BR/>",
                    "&eacute;",
                    "&egrave;",
                    "&apos;",
                    "&agrave;",
                    "&ugrave;",
                    "&euro;"
                );
                $replace = array(
                    "<br>",
                    "é",
                    "è",
                    "'",
                    "à",
                    "ù",
                    "EUR"
                );
		$contenu = str_replace($search, $replace, $contenu);


		global $bdd;
		$bdd->beginTransaction();{
			$query = "INSERT INTO courriers
							(id_courrier, id_type_courrier, id_pdf_modele, id_etat_courrier, date_courrier, objet, contenu)
							VALUES (NULL, '".$id_type_courrier."', '".$id_pdf_modele."', '".$id_etat_courrier."', '".$date_courrier."', '".addslashes($objet)."', '".addslashes($contenu)."')";

			$bdd->exec ($query);
			
			$tmp_id_courrier = $bdd->lastInsertId();
			
			$query = "INSERT INTO courriers_destinataires
							(id_courrier, ref_destinataire) VALUES
							('".$tmp_id_courrier."', '".$ref_destinataire."')";
			
			$date_event = new DateTime();
			
			$event = $date_event->format("d-m-Y H:i:s")." - Création du courrier n°".$tmp_id_courrier."<br/>";
			$event.= "Destinataire : ".$ref_destinataire."<br/>";
			$event.= "Expéditeur : ".$utilisateur->getRef_user()."<br/>"; 
			
			CourrierEvent::newCourrierEvent($tmp_id_courrier, $date_event->format("Y-m-d H:i:s"), 1, $event, $utilisateur->getRef_user());
			
			$bdd->exec ($query);
		}$bdd->commit();
		return new CourrierEtendu($tmp_id_courrier);
	}
	
	
	// *************************************************************************************************************
	// Getters & Setters pour les destinataire du courrier
	// *************************************************************************************************************
	public function getDestinataires(){
		return $this->destinataires;
	}
			
	protected function setDestinataires($destinataires){
		return $this->destinataires = $destinataires;
	}
	
	// *************************************************************************************************************
	// Getters & Setters du courrier
	// *************************************************************************************************************
	public function getId_courrier(){
		return $this->id_courrier;
	}
	
	public function getEvents(){
		return $this->events;
	}
	
	public function addEvent($date_event = "", $id_courrier_event_type, $event, $ref_user = ""){
		if($date_event == ""){
			$d = new DateTime();
			$date_event = $d->format("Y-m-d H:i:s");
		}
		if($ref_user == "")
			$ref_user = $_SESSION['user']->getRef_user ();
		
		$this->events[] = CourrierEvent::newCourrierEvent($this->getId_courrier(), $date_event, $id_courrier_event_type, $event, $ref_user);
	}
		
	public function setObjet($objet){
		global $bdd;
		$query = "UPDATE courriers SET objet = '".addslashes($objet)."'
							WHERE id_courrier = '".$this->getId_courrier()."' ";
		$bdd->exec($query);
		parent::setObjet($objet);
	}
	
	public function setContenu($contenu){
		global $bdd;
		$query = "UPDATE courriers SET contenu = '".addslashes($contenu)."'
							WHERE id_courrier = '".$this->getId_courrier()."' ";
		$bdd->exec($query);
		parent::setContenu($contenu); 
	}

	// ATTENTION, POUR l'instant, on considère que l'expéditeur est le créateur du mail
	public function getExpediteur(){
		$e = $this->getEvents();
		return $e[0]->getUtilisateur();
	}
	
	// *************************************************************************************************************
	// Getters & Setters de l'état du courrier
	// *************************************************************************************************************
	public function setId_etat_courrier($id_etat_courrier){
		if (!parent::setId_etat_courrier($id_etat_courrier)) return false; 
		global $bdd;
		$query = "UPDATE courriers SET id_etat_courrier = '".$id_etat_courrier."'
							WHERE id_courrier = '".$this->id_courrier."' ";
		$bdd->exec($query);
		return true;
	}
	
	// *************************************************************************************************************
	// Getters & Setters sur le type du courrier
	// *************************************************************************************************************
	public function setId_type_courrier($id_type_courrier){
		global $bdd;
		$query = "UPDATE courriers SET id_type_courrier = '".$id_type_courrier."'
							WHERE id_courrier = '".$this->getId_courrier()."' ";
		$bdd->exec($query);
		return (parent::setId_etat_courrier($id_type_courrier));
	}
	
	// *************************************************************************************************************
	// Getters & Setters pour le modele PDF
	// *************************************************************************************************************
	public function setId_pdf_modele($id_pdf_modele){
		global $bdd;
		$query = "UPDATE courriers SET id_pdf_modele = '".$id_pdf_modele."'
							WHERE id_courrier = '".$this->getId_courrier()."' ";
		$bdd->exec($query);
		return (parent::setId_pdf_modele($id_pdf_modele));
	}
	// *************************************************************************************************************
	// Fonction liées au PDF
	// *************************************************************************************************************
	// Affiche le PDF du document
	public function print_pdf () {
		$this->courrier_edition_add(1);
		parent::print_pdf();
	}
	
	// Créé et affiche le PDF d'un document
	public function create_pdf($print = 0) {
		
		$pdf = parent::create_pdf($print);
		
		// Ajout du document au PDF
		$pdf->add_courrier("", $this);
		
		// Sortie
		return $pdf;
	}
	
	// sauvegarde le PDF du document
	public function save_pdf () {
		global $FICHIERS_DIR;
		
		$pdf = $this->create_pdf ();
	
		// Sortie
		$pdf->Output($FICHIERS_DIR.Courrier::GET_TMP_FOLDER().$this->id_courrier."_".$this->getCode_file().".pdf" , "F");
	
		return true;
	}

	// *************************************************************************************************************
	// Fonction liées à la table courriers_editions
	// *************************************************************************************************************
	
	//voir dans la BD la TABLE : COURRIERS_EDITIONS
	
	// Enregistre l'edition du document
	public function courrier_edition_add ($id_edition_mode, $ref_user = "") {
		global $bdd;
		
		if (!$id_edition_mode) { return false; }
		if ($ref_user == "") {
			$ref_user = $_SESSION['user']->getRef_user();
		}
		$query = "INSERT INTO courriers_editions
								(id_courrier_envoi, id_courrier, id_edition_mode, date_edition, ref_user) VALUES 
								(NULL, '".$this->getId_courrier()."', '".$id_edition_mode."', NOW(), '".$ref_user."' ) ";
		$bdd->exec ($query);
		return true;
	}
	
	//retourne le nombre de fois que ce courrier a été envoyé
	public function getNb_envois($id_edition_mode = "", $ref_user = "", $date_edition_deb = "" /*format Y-m-d H:i:s*/,$date_edition_fin = "" /*format Y-m-d H:i:s*/){
		global $bdd;
		$query_where = "";
		if($id_edition_mode != ""){
			$query_where.=" AND id_edition_mode = '".$id_edition_mode."'";
		}
		if($ref_user != ""){
			$query_where.=" AND ref_user = '".$ref_user."'";
		}
		if($date_edition_deb != ""){
			$query_where.=" AND date_edition >= '".$date_edition_deb."'";
		}
		if($date_edition_fin != ""){
			$query_where.=" AND date_edition <= '".$date_edition_fin."'";
		}

		$query = "SELECT 	count(id_courrier_envoi) as nb_envois
							FROM courriers_editions ce
							WHERE id_courrier = '".$id_type_courrier."'".$query_where;
		$resultat = $bdd->query ($query);
		if (!$r = $resultat->fetchObject())
			return false; 
		return $r->nb_envois;
	}
	
	// *************************************************************************************************************
	// Fonction liées à l'envoi d'un courrier
	// *************************************************************************************************************

	// Envoi du document par email
	//fonction recopiée depuis la classe document 
	//@TODO COURRIER : Gestion du mail : A tester
	public function mail_courrier ($to , $sujet , $message) {
		global $bdd;
		global $FICHIERS_DIR;
		global $REF_CONTACT_ENTREPRISE;
		
		$this->save_pdf();
		
		$filename 	= array();
		$filename[] = $FICHIERS_DIR.Courrier::GET_TMP_FOLDER().$this->id_courrier."_".$this->getCode_file().".pdf";
		$typemime		= "application/pdf";
		$nom				= array();
		$nom[]			= $this->id_courrier."_".$this->getCode_file().".pdf";
		
		//on génere un nom de fichier en remplacement
		$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
		$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
		$nom_aff				= array();
		$nom_aff[]			= $this->id_courrier."_".$nom_entreprise.".pdf";
	
	
		//on récupère l'email de l'utilisateur en cours pour envoyer le mail
		$reply 			= $_SESSION['user']->getEmail();
		$from 			= $_SESSION['user']->getEmail();
		
		// Envoi de l'email
		$mail = new email();
		$mail->prepare_envoi(0, 1);
		
		if ($mail->mail_attachement ($to , $sujet , $message , $filename , $typemime , $nom , $reply , $from, $nom_aff)) {
			$this->courrier_edition_add(2);
			return true;
		} 
		else {
			return false;
		}
	}
	
	//@TODO COURRIER : Gestion du FAX : Traitement du FAX dans la classe courrier
	//fonction recopiée depuis la classe document 
	public function faxer_courrier ($to , $sujet , $message) {
		global $bdd;
		global $FICHIERS_DIR;
		global $REF_CONTACT_ENTREPRISE;
		
		$this->save_pdf();
		
		$filename 	= array();
		$filename[] = $FICHIERS_DIR.Courrier::$TMP_FOLDER.$this->id_courrier."_".$this->code_file.".pdf";
		$typemime		= "application/pdf";
		$nom				= array();
		$nom[]			= $this->id_courrier."_".$this->code_file.".pdf";
		
		//on génere un nom de fichier en remplacement
		$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
		$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
		$nom_aff				= array();
		$nom_aff[]			= $this->id_courrier."_".$nom_entreprise.".pdf";
	
	
		//on récupère l'email de l'utilisateur en cours pour envoyer le mail
		$reply 			= $_SESSION['user']->getEmail();
		$from 			= $_SESSION['user']->getEmail();
		
		if (mail_attachement ($to , $sujet , $message , $filename , $typemime , $nom , $reply , $from, $nom_aff)) {
			$this->courrier_edition_add(3);
			return true;
		} 
		else {
			return false;
		}
	}
}


// *************************************************************************************************************
// CLASSE CourrierEvent
// *************************************************************************************************************
// Classe régissant les information d'une évènement VOIR la TABLE : COURRIERS_EVENTS_TYPES
class CourrierEvent{
	
	//voir dans la BD la TABLE : COURRIERS_EVENTS et la TABLE : COURRIERS_EVENTS_TYPES
	private $id_courrier_event;
	private $date_event;
	private $id_courrier_event_type;
	private $lib_courrier_event_type;
	private $event;
	private $utilisateur;
	
	public function __construct($id_courrier_event = "") {
		global $bdd;
		
		if (!is_numeric($id_courrier_event)) return false;
		
		$this->id_courrier_event = $id_courrier_event;
				
		$query = "SELECT ce.id_courrier_event, ce.id_courrier, ce.date_event, ce.id_courrier_event_type, ce.event, ce.ref_user, cet.lib_courrier_event_type
							FROM courriers_events ce
							LEFT JOIN courriers_events_types cet ON ce.id_courrier_event_type = cet.id_courrier_event_type
							WHERE ce.id_courrier_event = '".$id_courrier_event."' ";
		$resultat = $bdd->query ($query);
		if (!$courrier_event = $resultat->fetchObject()) return false;
		
		$this->id_courrier_event = $courrier_event->id_courrier_event;
		$this->date_event = $courrier_event->date_event;
		$this->id_courrier_event_type = $courrier_event->id_courrier_event_type;
		$this->event = $courrier_event->event;
		$this->utilisateur = new utilisateur($courrier_event->ref_user);
		$this->lib_courrier_event_type = $courrier_event->lib_courrier_event_type;
	}
	
	public final static function newCourrierEvent($id_courrier, $date_event, $id_courrier_event_type, $event, $ref_user){

		if (!is_numeric($id_courrier) || !is_numeric($id_courrier_event_type)) return false;
		
		if($ref_user == ""){
			$utilisateur = $_SESSION['user'];
			$ref_user = $utilisateur->getRef_user();
		}
		if($date_event == "")
			$d = "NOW()";
		else
			$d = "'".$date_event."'";
			
		global $bdd;
		$query = "INSERT INTO courriers_events
						(id_courrier_event, id_courrier, date_event, id_courrier_event_type, event, ref_user)
						VALUES (NULL, '".$id_courrier."', ".$d.", '".$id_courrier_event_type."', '".addslashes($event)."', '".$ref_user."')";
		
		$bdd->exec ($query);
		$tmp_id_courrier_event = $bdd->lastInsertId();
		return new CourrierEvent($tmp_id_courrier_event);
	}
	
	// *************************************************************************************************************
	// Getters & Setters
	// *************************************************************************************************************
	public function getId_courrier_event(){
		return $this->id_courrier_event;
	}
	
	public function getDate_event(){
		return $this->date_event;
	}
	
	public function setDate_event($date_event){
		global $bdd;
		$query = "UPDATE courriers_events SET date_event = '".$date_event."'
							WHERE id_courrier_event = '".$this->getId_courrier_event()."' ";
		$bdd->exec($query);
		$this->date_event = $date_event;
	}
	
	public function getId_courrier_event_type(){
		return $this->id_courrier_event_type;
	}
	
	public function setId_courrier_event_type($id_courrier_event_type){
		if(!is_numeric($id_courrier_event_type))return false;
		global $bdd;
		$query = "SELECT cet.id_courrier_event_type, cet.lib_courrier_events_type
							FROM courriers_event_types cet
							WHERE cet.id_courrier_event_type = '".$id_courrier_event_type."' ";
		$resultat = $bdd->query ($query);
		if (!$courriers_event_type = $resultat->fetchObject()) {return false;}

		$query = "UPDATE courriers_events SET id_courrier_event_type = '".$id_courrier_event_type."'
							WHERE id_courrier_event = '".$this->getId_courrier_event()."' ";
		$bdd->exec($query);
		
		$this->id_courrier_event_type = $courriers_event_type->id_courrier_event_type;
		$this->lib_courrier_event_type = $courriers_event_type->lib_courrier_event_type;
	}
	
	public function getLib_courrier_event_type(){
		return $this->lib_courrier_event_type;
	}
		
	public function getEvent(){
		return $this->event;
	}
	
	public function setEvent($event){
		global $bdd;
		$query = "UPDATE courriers_events SET event = '".addslashes($event)."'
							WHERE id_courrier_event = '".$this->getId_courrier_event()."' ";
		$bdd->exec($query);
		$this->event = $event;
	}
	
	public function getUtilisateur(){
		return $this->utilisateur;
	}
	
	public function setUser($ref_user){
		global $bdd;
		$query = "UPDATE courriers_events SET ref_user = '".$ref_user."'
							WHERE id_courrier_event = '".$this->getId_courrier_event()."' ";
		$bdd->exec($query);
		$this->utilisateur = new utilisateur($ref_user);
	}
}
?>