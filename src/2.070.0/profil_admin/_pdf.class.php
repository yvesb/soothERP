<?php
// *************************************************************************************************************
// UTILISATION DE LA CLASSE FPDF 
// *************************************************************************************************************
define('FPDF_FONTPATH', $RESSOURCE_DIR."FPDF_fonts/");
require_once ($RESSOURCE_DIR."fpdf.php");

// La classe FPDF doit etre définie en "abstract" afin de l'adapter à PHP5
// Doc sur http://www.fpdf.org/



// *************************************************************************************************************
// CLASSES NECESSAIRE A LA GESTION DES DOCUMENTS PDF
// *************************************************************************************************************

class PDF_etendu extends FPDF {

function __construct ($orientation= 'P', $unit = 'mm', $format = 'A4') {
	// $orientation 		P = Portrait / L = Paysage
	// $unit						Unité de mesure (pt,mm/cm/in)
	// $format					Format de la page: A4, A5, A3

	parent::FPDF($orientation, $unit, $format);

	global $REF_CONTACT_ENTREPRISE;
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));

	$this->SetAuthor	($nom_entreprise);
	$this->SetCreator	("SoothERP (un fork de Lundi Matin Business®)");
	$this->SetDisplayMode ("real", "single");
	$this->SetAutoPageBreak(0, 1);

	// Valeurs par défaut
	if (!isset($GLOBALS['PDF_OPTIONS']['HideToolbar'])) { $GLOBALS['PDF_OPTIONS']['HideToolbar'] = 1; }
	if (!isset($GLOBALS['PDF_OPTIONS']['AutoPrint'])) 	{ $GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0; 	}

	// Préférences et options
	if ($GLOBALS['PDF_OPTIONS']['HideToolbar']) {
		$this->DisplayPreferences ("HideToolbar");
	}
	if ($GLOBALS['PDF_OPTIONS']['AutoPrint']) {
		$this->AutoPrint(true);
	}

}



// *************************************************************************************************************
// GESTION DES CODES BARRES CODE39

function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5) {
/* 
	Ce script implémente les codes-barres Code 39. 
	Ce type de code-barres peut encoder les chaînes composées des caractères suivants : 
	- chiffres (0 à 9), 
	- lettres majuscules (A à Z)
	- 8 autres caractères (- . espace $ / + % *).

	Code39(float xpos, float ypos, string code [, float baseline [, float height]])
	xpos : abscisse du code-barres
	ypos : ordonnée du code-barres
	code : valeur du code-barres
	baseline : correspond à la largeur d'une barre épaisse (valeur par défaut : 0.5)
	height : hauteur des barres (valeur par défaut : 5) 
*/

    $wide = $baseline;
    $narrow = $baseline / 3 ; 
    $gap = $narrow;

    $barChar['0'] = 'nnnwwnwnn';
    $barChar['1'] = 'wnnwnnnnw';
    $barChar['2'] = 'nnwwnnnnw';
    $barChar['3'] = 'wnwwnnnnn';
    $barChar['4'] = 'nnnwwnnnw';
    $barChar['5'] = 'wnnwwnnnn';
    $barChar['6'] = 'nnwwwnnnn';
    $barChar['7'] = 'nnnwnnwnw';
    $barChar['8'] = 'wnnwnnwnn';
    $barChar['9'] = 'nnwwnnwnn';
    $barChar['A'] = 'wnnnnwnnw';
    $barChar['B'] = 'nnwnnwnnw';
    $barChar['C'] = 'wnwnnwnnn';
    $barChar['D'] = 'nnnnwwnnw';
    $barChar['E'] = 'wnnnwwnnn';
    $barChar['F'] = 'nnwnwwnnn';
    $barChar['G'] = 'nnnnnwwnw';
    $barChar['H'] = 'wnnnnwwnn';
    $barChar['I'] = 'nnwnnwwnn';
    $barChar['J'] = 'nnnnwwwnn';
    $barChar['K'] = 'wnnnnnnww';
    $barChar['L'] = 'nnwnnnnww';
    $barChar['M'] = 'wnwnnnnwn';
    $barChar['N'] = 'nnnnwnnww';
    $barChar['O'] = 'wnnnwnnwn'; 
    $barChar['P'] = 'nnwnwnnwn';
    $barChar['Q'] = 'nnnnnnwww';
    $barChar['R'] = 'wnnnnnwwn';
    $barChar['S'] = 'nnwnnnwwn';
    $barChar['T'] = 'nnnnwnwwn';
    $barChar['U'] = 'wwnnnnnnw';
    $barChar['V'] = 'nwwnnnnnw';
    $barChar['W'] = 'wwwnnnnnn';
    $barChar['X'] = 'nwnnwnnnw';
    $barChar['Y'] = 'wwnnwnnnn';
    $barChar['Z'] = 'nwwnwnnnn';
    $barChar['-'] = 'nwnnnnwnw';
    $barChar['.'] = 'wwnnnnwnn';
    $barChar[' '] = 'nwwnnnwnn';
    $barChar['*'] = 'nwnnwnwnn';
    $barChar['$'] = 'nwnwnwnnn';
    $barChar['/'] = 'nwnwnnnwn';
    $barChar['+'] = 'nwnnnwnwn';
    $barChar['%'] = 'nnnwnwnwn';

    //$this->SetFont('Arial','',10);
    //$this->Text($xpos, $ypos + $height + 4, $code);
    $this->SetFillColor(0);

    $code = '*'.strtoupper($code).'*';
    for($i=0; $i<strlen($code); $i++){
        $char = $code{$i};
        if(!isset($barChar[$char])){
            $this->Error('Invalid character in barcode: '.$char);
        }
        $seq = $barChar[$char];
        for($bar=0; $bar<9; $bar++){
            if($seq{$bar} == 'n'){
                $lineWidth = $narrow;
            }else{
                $lineWidth = $wide;
            }
            if($bar % 2 == 0){
                $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
            }
            $xpos += $lineWidth;
        }
        $xpos += $gap;
    }
}




// *************************************************************************************************************
// GESTION DES RECTANGLES ARRONDIS
function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
{
/*
	Ce script permet de tracer un rectangle avec certains bords arrondis (tous ou au choix). 
	Les paramètres sont :
		x, y : coin supérieur gauche du rectangle.
		w, h : largeur et hauteur.
		r : rayon des coins arrondis.
		style : D: contour (draw), F : remplissage (fill) => F, D (défaut), FD ou DF.
		angle : numéro du ou des angles à arrondir : 1, 2, 3, 4 ou toutes combinaisons 
						(1=haut gauche, 2=haut droite, 3=bas droite, 4=bas gauche). 
*/
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }



// *************************************************************************************************************
// GESTION DES PREFERENCES D'AFFICHAGE

/* 	DisplayPreferences(string preferences)
		Les options disponibles sont les suivantes (sensibles à la casse) :
			FullScreen : affiche le document en plein écran (escape pour revenir en mode normal) 
			HideMenubar : masque la barre de menu 
			HideToolbar : masque les barres d'outils 
			HideWindowUI : masque tous les éléments de la fenêtre (barres de défilement, contrôles de navigation, signets...) 
			DisplayDocTitle : affiche le titre du document au lieu du nom du fichier (pas d'effet dans le plug-in) 
			CenterWindow : centre la fenêtre (pas d'effet dans le plug-in) 
			FitWindow : ajuste la taille de la fenêtre (lorsqu'elle n'est pas maximisée) sur celle de la page (pas d'effet dans le plug-in)*/

protected $DisplayPreferences = '';

function DisplayPreferences ($preferences) {
    $this->DisplayPreferences .= $preferences;
}

function _putcatalog() {
	parent::_putcatalog();

	// Partie nécessaire pour la gestion du Javascript
	if (isset($this->javascript)) {
		$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
	}

	// Partie nécessaire pour la gestion des préférences
	if(is_int(strpos($this->DisplayPreferences,'FullScreen')))
		$this->_out('/PageMode /FullScreen');

	if($this->DisplayPreferences) {
		$this->_out('/ViewerPreferences<<');
		if(is_int(strpos($this->DisplayPreferences,'HideMenubar')))
		    $this->_out('/HideMenubar true');
		if(is_int(strpos($this->DisplayPreferences,'HideToolbar')))
		    $this->_out('/HideToolbar true');
		if(is_int(strpos($this->DisplayPreferences,'HideWindowUI')))
		    $this->_out('/HideWindowUI true');
		if(is_int(strpos($this->DisplayPreferences,'DisplayDocTitle')))
		    $this->_out('/DisplayDocTitle true');
		if(is_int(strpos($this->DisplayPreferences,'CenterWindow')))
		    $this->_out('/CenterWindow true');
		if(is_int(strpos($this->DisplayPreferences,'FitWindow')))
		    $this->_out('/FitWindow true');
		$this->_out('>>');
	}
}



// *************************************************************************************************************
// GESTION DU JAVASCRIPT
// *************************************************************************************************************
var $javascript;
var $n_js;

function IncludeJS($script) {
	$this->javascript=$script;
}

function _putjavascript() {
	$this->_newobj();
	$this->n_js=$this->n;
	$this->_out('<<');
	$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
	$this->_out('>>');
	$this->_out('endobj');
	$this->_newobj();
	$this->_out('<<');
	$this->_out('/S /JavaScript');
	$this->_out('/JS '.$this->_textstring($this->javascript));
	$this->_out('>>');
	$this->_out('endobj');
}

function _putresources() {
	parent::_putresources();
	if (!empty($this->javascript)) {
		$this->_putjavascript();
	}
}



// *************************************************************************************************************
// Impression automatique
function AutoPrint($dialog=false)
{
    // Lance la boîte d'impression ou imprime immediatement sur l'imprimante par défaut
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
    //Imprime sur une imprimante partagée (requiert Acrobat 6 ou supérieur)
    $script = "var pp = getPrintParams();";
    if($dialog)
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
    else
        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
    $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
    $script .= "print(pp);";
    $this->IncludeJS($script);
}

// *************************************************************************************************************
// EXEMPLE PERMETTANT L'IMPRESSION AUTOMATIQUE APRES OUVERTURE
/*
Cet exemple montre comment démarrer l'impression à l'ouverture du document. Il est possible d'afficher la boîte de dialogue (en passant true à la méthode AutoPrint()), ou bien d'imprimer directement avec les paramètres par défaut (avec false).

<?php
define('FPDF_FONTPATH','font/');
require('fpdf_js.php');

class PDF_AutoPrint extends PDF_Javascript
{
function AutoPrint($dialog=false)
{
    //Lance la boîte d'impression ou imprime immediatement sur l'imprimante par défaut
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
    //Imprime sur une imprimante partagée (requiert Acrobat 6 ou supérieur)
    $script = "var pp = getPrintParams();";
    if($dialog)
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
    else
        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
    $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
    $script .= "print(pp);";
    $this->IncludeJS($script);
}
}

$pdf=new PDF_AutoPrint();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',20);
$pdf->Text(80, 50, 'Imprimez-moi !');
//Ouvre la boîte d'impression
$pdf->AutoPrint(true);
$pdf->Output();
?>  
*/



// ************************************************************************************************************************
// ******** Fonctions relatives à l'ajout d'un document au PDF
// ************************************************************************************************************************
function add_doc ($ref_doc, $document = "") {
	global $PDF_MODELES_DIR;

	// On vérifie la présence du document en tant qu'objet sinon on le charge
	if (!$document) {	$document = open_doc($ref_doc); }
	if (!is_object($document)) { return false; }

	// Chargement des fonctions relatives au type de document
	$pdf_modele = $document->get_code_pdf_modele ();

	include_once ($PDF_MODELES_DIR.$pdf_modele.".class.php");
	$classe = "pdf_content_".$pdf_modele;
	$composant = new $classe($this, $document);

}

var $compo;
function add_art($ref_art, $article = ""){
	global $PDF_MODELES_DIR;
	
	if (!$article) { $article = new article($ref_art); }
	if (!is_object($article)) { return false; }
	
	$pdf_modele = $article->get_code_pdf_modele();
	//$pdf_modele = "art_standard";
	include_once ($PDF_MODELES_DIR.$pdf_modele.".class.php");
	$classe = "pdf_".$pdf_modele;
	//$composant  = new $classe($this, $article);
	$this->compo = new $classe($this, $article);
	$this->compo->writePdf();
}

function add_contact($ref_contact, $contact = ""){
	global $PDF_MODELES_DIR;
	
		if (!$contact) { $contact = new contact($ref_art); }
	if (!is_object($contact)) { return false; }
	
	if (! ($pdf_modele = $contact->get_code_pdf_modele())) { return false; }
	//$pdf_modele = "art_standard";
	include_once ($PDF_MODELES_DIR.$pdf_modele.".class.php");
	$classe = "pdf_".$pdf_modele;
	//$composant  = new $classe($this, $article);
	$this->compo = new $classe($this, $contact);
	$this->compo->writePdf();
}

function add_stats($pdf_modele = ""){
	global $PDF_MODELES_DIR;
	
	if(!$pdf_modele){
		if (!($pdf_modele = get_code_pdf_modele_stat())) { return false; }
	}
	include_once ($PDF_MODELES_DIR.$pdf_modele.".class.php");
	$classe = "pdf_".$pdf_modele;
	$this->compo = new $classe($this);
	$this->compo->writePdf();
}

function Header(){
	if (method_exists($this->compo, 'getHeader'))
		eval($this->compo->getHeader());
}

function Footer(){
	if (method_exists($this->compo, 'getFooter'))
		eval($this->compo->getFooter());
}

}

?>
