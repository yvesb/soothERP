<?php
// *************************************************************************************************************
// CONFIG DES DONNEES pdf
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


ini_set("memory_limit","40M");
//on cré un mini class afin de charger les données des différents types de doc pdf 
final class tmp_doc {
	protected $app_tarifs;
	protected $ID_TYPE_DOC;
	protected $code_pdf_modele;
	
public function __construct($ID_TYPE_DOC) {
	global $bdd;
	global $PDF_MODELES_DIR;
	global $AFF_REMISES;
		
		
	$this->ID_TYPE_DOC = $ID_TYPE_DOC;
	$this->app_tarifs ="";
		
		
	$query = "SELECT dt.id_type_doc,
									 dt.lib_type_doc, dt.lib_type_printed, pm.code_pdf_modele
									
						FROM  documents_types dt 
							LEFT JOIN doc_modeles_pdf dmp ON dt.id_type_doc = dmp.id_type_doc && dmp.usage = 'defaut' 
							LEFT JOIN pdf_modeles pm ON pm.id_pdf_modele = dmp.id_pdf_modele
						WHERE dt.id_type_doc = '".$this->ID_TYPE_DOC."' ";
	$resultat = $bdd->query ($query);
	if (!$doc = $resultat->fetchObject()) { return false; }
		
	$this->lib_type_doc			= $doc->lib_type_doc;
	$this->lib_type_printed	= $doc->lib_type_printed;
	$this->code_pdf_modele	= $doc->code_pdf_modele;
		
	}
	
// Créé et affiche le PDF d'un document
public function create_pdf ($print = 0) {	
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;

	// Création du fichier
	$pdf = new PDF_etendu ();

	// Ajout du document au PDF
	$pdf->add_doc ("", $this);

	// Sortie
	return $pdf;
}


//changement du code_pdf_modele
public function change_code_pdf_modele ($code_pdf_modele) {
	$this->code_pdf_modele = $code_pdf_modele;
} 

// Affiche le PDF du document
public function view_pdf ($print = 0) {
	$pdf = $this->create_pdf ($print);

	// Sortie
	$pdf->Output();
}

	
function getRef_doc () {
	return "";
}

function getLib_type_doc () {
	return $this->lib_type_doc;
}
 
function getLib_type_printed () {
	return $this->lib_type_printed;
}
 
function getId_etat_doc () {
	return "";
}
 
function getLib_etat_doc () {
	return "";
}

function getDate_creation () {
	return date ("Y-m-d H:i:s");
}
 
function getIs_open () {
	return 0;
}
 
function getRef_contact () {
	return "";
}
 
function getContact () {
	return "";
}
 
function getNom_contact () {
	return "";
}
 
function getRef_adr_contact () {
	return "";
}
 
function getAdresse_contact () {
	return "";
}

function getAdresse_livraison () {
	return "";
}
 
function getApp_tarifs () {
	return "TTC";
}
 
function getDescription () {
	return "";
}
 
function getContenu () {
	return array();
}

function get_code_pdf_modele () {
    return $this->code_pdf_modele;
}

function getTVAs () {
	return array();
}

function getMontant_ht () {
	return 0;
}

function getMontant_tva () {
	return 0;
}

function getMontant_ttc () {
	return 0;
}

function getMontant_to_pay () {
	return 0;
}
 
function getReglements () {
	return array();
}

function getID_TYPE_DOC () {
	return $this->ID_TYPE_DOC;
}

function getLIB_TYPE_DOCUMENT () {
	return "";
}
 
 
function getDEFAUT_ID_ETAT () {
	return "";
}

function getID_ETAT_ANNULE () {
	return $this->ID_ETAT_ANNULE;
}
function getDate_echeance () {
	return false;
}


function getId_niveau_relance () {
	return false;
}

function getRef_doc_externe () {
	return "";
}

function getLiaisons () {
	return array("source"=>array(), "dest"=>array());
}
function getDate_livraison () {
	return false;
}
 
function getRef_article () {
	return "";
}

function getId_magasin(){
	return 1;
}

function getId_stock(){
	return 1;
}
 
 
}


function document(){
	$document = new tmp_doc($_REQUEST["id_type_doc"]) ;
	//changement du code pdf_modele
	if (isset($_REQUEST["code_pdf_modele"])) {
		$document->change_code_pdf_modele ($_REQUEST["code_pdf_modele"]);
	}
	// AFFICHAGE
	$document->view_pdf();
}

function courrier(){
		$courrier = new CourrierPDFvierge($_REQUEST["id_type_courrier"], $_REQUEST["id_pdf_modele"], Courrier::ETAT_EN_REDAC(), date("d-m-Y 00:00:00"), ""/*objet*/, ""/*contenu*/);

		//changement du code pdf_modele
		if (isset($_REQUEST["code_pdf_modele"])) {
			$courrier->change_code_pdf_modele ($_REQUEST["code_pdf_modele"]);
		}
		// AFFICHAGE
		$courrier->view_pdf();
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if (isset($_REQUEST["type"])){
	switch ($_REQUEST["type"]){
		case "doc": { document();break; }
		case "courrier": {courrier();break; }
	}
}
else{ //ANCIEN FONCTIONNEMEMENT
	document();
}

?>