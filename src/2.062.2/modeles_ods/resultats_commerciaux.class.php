<?php
// Load library
require_once('../ressources/ods/ods.php');

// *************************************************************************************************************
// GENERATION DES RESULTATS DES COMMERCIAUX
// *************************************************************************************************************

class ods_resultats_commerciaux{
	var $code_ods_modele = "resultats_commerciaux";
	var $ods;
	var $table;
	var $commerciaux;				
	var $lib_type_printed;
	var $dates;
	var $details;
	var $i;
	
public function ods_resultats_commerciaux () {
	global $ODS_MODELES_DIR;
	global $COMMISSIONS;
	global $MONNAIE;
	
	$liste_commerciaux=$this->init();
	//echo'<pre>';print_r($liste_commerciaux);echo'<pre>';
	
	$form['date_debut'] = "" ;
	if (isset($_REQUEST['date_debut'])) {
	$form['date_debut'] = $_REQUEST['date_debut'];
	$search['date_debut'] = $_REQUEST['date_debut'];
	}

	$form['date_fin'] = "" ;
	if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = $_REQUEST['date_fin'];
	$search['date_fin'] = $_REQUEST['date_fin'];
	}
	$form['date_exercice"'] = "" ;
	if (isset($_REQUEST['date_exercice']) && ($form['date_fin'] == "" && $form['date_debut'] == "")) {
	$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$form['date_debut'] = $search['date_debut'] = date_Us_to_Fr($search['date_exercice'][0]);
	$form['date_fin'] = $search['date_fin'] = date_Us_to_Fr($search['date_exercice'][1]);
	}
	
	//$infos
	$infos = array();
	$lib = "RESULTATS COMMERCIAUX";
	$infos["lib_type_printed"] = $lib;
	$infos["dates"] = "du  ".$search['date_debut']." au ".$search['date_fin'];
	
	$this->commerciaux				= $liste_commerciaux;
	$this->lib_type_printed 	= $infos["lib_type_printed"];
	$this->dates 							= $infos["dates"];
	//$this->details 						= $infos["details"];
	$this->i = 0;
	
	
	include_once ($ODS_MODELES_DIR."config/".$this->code_ods_modele.".config.php");

	// ***************************************************
	// Valeurs par défaut
	//foreach ($COMMISSIONS as $var => $valeur) {
	//	$this->{$var} = $valeur;
	//}
//	return $this;
	$this->ods  = new ods();
	
	$this->table = new odsTable(utf8_encode('Commerciaux'));
	$this->create_titre();
	
	$row=$this->create_row();
	$this->create_cellspan($this->dates,$row, '3');
	$row=$this->create_row();
	$row=$this->create_row();
	$this->create_cellspan('Liste des commerciaux :',$row, '3');
	$row=$this->create_row();
	//Liste commerciaux
	foreach ($this->commerciaux as $commercial) {
	$row=$this->create_row();
	$this->create_cellspan($commercial->nom,$row,'3');
	}
	//Ajout de la table
	$this->ods->addTable($this->table);
	
	foreach ($this->commerciaux as $commercial) {
	$valeur=$commercial->nom;
	// Create table
	$this->table = new odsTable(utf8_encode($valeur));

	$this->create_titre();
	//taille des colonnes
	$this->create_stylecol('2.3 cm');
	$this->create_stylecol('4 cm');
	$this->create_stylecol('5 cm');
	$this->create_stylecol('2.5 cm');
	$this->create_stylecol('2.5 cm');
	$this->create_stylecol('2.5 cm');
	
	//Contenu table
	preg_match('#([0-9\.]*)%CA\+([0-9\.]*)%Mg#i', str_replace(",", ".", $commercial->formule_comm), $result);

	$text_fom_comm = $result[1]."% du Chifre d'affaire plus ".$result[2]."% de la Marge acquit " ;
	switch ($commercial->doc_fom_comm) {
		case "CDC": 
		$text_fom_comm .= "à la commande";
		break;
		case "FAC": 
		$text_fom_comm .= "à la facturation";
		break;
		case "RGM": 
		$text_fom_comm .= "à la facturation acquitée";
		break;
	}
		$row=$this->create_row();
		$text=$commercial->nom." ".$this->dates;
		$this->create_cellspan($text,$row,'5');
		
		$row=$this->create_row();
		$this->create_cellspan($text_fom_comm,$row,'5');
		
		$row=$this->create_row();
		$this->create_cell(" ",$row);
		
		$row=$this->create_row();
		$this->create_cellspan("Chiffre d'affaire généré:",$row, '2');
		$this->create_celleuro($commercial->ca,$row);
		$row=$this->create_row();
		$this->create_cellspan("Marge générée :",$row, '2');
		$this->create_celleuro($commercial->mg,$row);
		$row=$this->create_row();
		$this->create_cellspan("TOTAL COMMISSIONS :",$row, '2');
		$this->create_celleuro($commercial->comm,$row);
		$row=$this->create_row();
		$this->create_cell(" ",$row);
		
		$this->create_entete();
		
		foreach ($commercial->docs as $docu) {
				$row=$this->create_row();
				$this->create_cell(date_Us_to_Fr($docu->date_creation_doc),$row);				
				$this->create_cell($docu->ref_doc,$row);
				$this->create_cell($docu->nom,$row);
				$this->create_celleuro($docu->ca,$row);
				$this->create_celleuro($docu->mg,$row);
				$this->create_celleuro($docu->comm,$row);
		}
	//Ajout de la table
	$this->ods->addTable($this->table);
	}
	// Download the file
	$this->ods->downloadOdsFile("Résultat commerciaux.ods");
}

public function create_titre() {
	//titre
	$titre = new odsStyleTableCell();
	$titre->setFontWeight('bold');
	$titre->setFontSize("18pt");
	
	// Titre
	$row = new odsTableRow();
	$cell = new odsTableCellString(utf8_encode("Résultat commerciaux"), $titre);
	$cell->setNumberColumnsSpanned(4);
	$row->addCell( $cell );
	$this->table->addRow($row);
	$row = new odsTableRow();
	$this->table->addRow($row);
} 
	public function create_stylecol($cm){
	//nb colonne de taille cm   
	$stylecol = new odsStyleTableColumn();
	$stylecol->setColumnWidth($cm);
	$col1 = new odsTableColumn($stylecol);
	$this->table->addTableColumn($col1);
	}

public function create_entete() {
	$row=$this->create_row();
	$this->create_cellgrey('Date',$row);
	$this->create_cellgrey('Document',$row);
	$this->create_cellgrey('Client',$row);
	$this->create_cellgrey('CA',$row);
	$this->create_cellgrey('Marge',$row);
	$this->create_cellgrey('Commission',$row);
}
	
	public function create_cell($contenu, $row){
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu)));
		return $cell;
	}
	
	public function create_cellspan($contenu, $row, $nb){
		$cell = new odsTableCellString(utf8_encode($contenu));
		$cell->setNumberColumnsSpanned($nb);
		$row->addCell( $cell );
		return $cell;
	}
	
	public function create_row(){
		$this->table->addRow($row = new odsTableRow());
		return $row;
	}
	
	public function create_celleuro($contenu, $row){
		$cell=$row->addCell( new odsTableCellCurrency(utf8_encode($contenu), 'EUR'));
		return $cell;
	}
	
		public function create_cellgrey($contenu, $row){
		$fond_gris = new odsStyleTableCell();
		$fond_gris->setBackgroundColor('#999999');
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu), $fond_gris));
		return $cell;
	}
	
public function init(){
global $bdd;
// Informations
$compta_e = new compta_exercices ();
$liste_exercices	= $compta_e->charger_compta_exercices();
//on récupère la dte du dernier exercice cloturé
foreach ($liste_exercices as $exercice) {
	if (!$exercice->etat_exercice) {$last_date_before_cloture = $exercice->date_fin; break;}
}

// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}

$form['date_debut'] = "" ;
if (isset($_REQUEST['date_debut'])) {
	$form['date_debut'] = $_REQUEST['date_debut'];
	$search['date_debut'] = $_REQUEST['date_debut'];
}

$form['date_fin'] = "" ;
if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = $_REQUEST['date_fin'];
	$search['date_fin'] = $_REQUEST['date_fin'];
}
$form['date_exercice"'] = "" ;
if (isset($_REQUEST['date_exercice']) && ($form['date_fin'] == "" && $form['date_debut'] == "")) {
	$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$form['date_debut'] = $search['date_debut'] = date_Us_to_Fr($search['date_exercice'][0]);
	$form['date_fin'] = $search['date_fin'] = date_Us_to_Fr($search['date_exercice'][1]);
}


 
//liste des commerciaux
$liste_commerciaux = charger_liste_commerciaux ();

$bool_affichage=false;
if(isset($_REQUEST['com']))
$affichage=$_REQUEST['com'];
else $bool_affichage=true;

// on retire les commerciaux non sélectionné en checkbox
$i=0;
if(!$bool_affichage)
foreach($liste_commerciaux as $commercial){
if(!in_array($commercial->ref_contact,$affichage))
unset($liste_commerciaux[''.$i.'']);
$i++;}

foreach ($liste_commerciaux as $commercial) {
	$doc_fom_comm = substr($commercial->formule_comm, strpos($commercial->formule_comm, "(")+1 ,3); 
		
	$query_join 	= "";
	$query_where 	= " dvc.ref_contact = '".$commercial->ref_contact."' ";
	$query_group	= "";
	
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	// *************************************************
	// Résultat de la recherche
	$commercial->ca = 0;
	$commercial->mg = 0;
	$commercial->comm = 0;
	$commercial->doc_fom_comm = $doc_fom_comm;
	$commercial->docs = array();
	switch ($doc_fom_comm) {
		case "CDC": 
				// Préparation de la requete
				// Recherche des documents
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc, d.ref_contact, a.nom
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
										LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									WHERE d.id_type_doc = '2' && d.id_etat_doc IN (9,10) &&  ".$query_where." 
									GROUP BY ref_doc
									";
				$resultatd = $bdd->query($queryd);
				while ($doc = $resultatd->fetchObject()) {
					$document = open_doc ($doc->ref_doc);
					$liste_contenu = $document->getContenu ();
					$doc->ca = 0;
					$doc->mg = 0;
					$doc->comm = 0;
					
					foreach ($liste_contenu as $contenu) {
						if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article" || !$contenu->visible) {continue;}
						$tmp_article = new article ($contenu->ref_article);
						$doc->detail[]=$contenu;
						//on ajoute le pa de l'article dans la ligne
						$pa_article = $tmp_article->getPaa_ht ();
						if ( $tmp_article->getPrix_achat_ht ()) {
							$pa_article = $tmp_article->getPrix_achat_ht ();
						}
						$ca_article = (($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))*($doc->part/100);
						$marge_article = ((($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))-($pa_article * $contenu->qte))*($doc->part/100);
						$doc->ca += $ca_article;
						$doc->mg += $marge_article;
						if ($formule_art = article_formule_comm ($tmp_article->getRef_article(), $tmp_article->getRef_art_categ(), $commercial->id_commission_regle)) {
							$comm = new formule_comm($formule_art);
						} else {
							$comm = new formule_comm($commercial->formule_comm);
						}
						$doc->comm += $comm->calcul_commission ($ca_article, $marge_article) ;
					}
					$commercial->ca += $doc->ca;
					$commercial->mg += $doc->mg;
					$commercial->comm += $doc->comm;
					$commercial->docs[] = $doc; 
				}
		break;
		case "FAC": 
				// Préparation de la requete
				// Recherche des documents
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc, d.ref_contact, a.nom
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
										LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									WHERE d.id_type_doc = '4' && d.id_etat_doc IN (18, 19) &&  ".$query_where." 
									GROUP BY ref_doc
									";
				$resultatd = $bdd->query($queryd);
				while ($doc = $resultatd->fetchObject()) {
					$document = open_doc ($doc->ref_doc);
					$liste_contenu = $document->getContenu ();
					$doc->ca = 0;
					$doc->mg = 0;
					$doc->comm = 0;
					
					foreach ($liste_contenu as $contenu) {
						if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article" || !$contenu->visible) {continue;}
						$tmp_article = new article ($contenu->ref_article);
						$doc->detail[]=$contenu;
						//on ajoute le pa de l'article dans la ligne
						$pa_article = $tmp_article->getPaa_ht ();
						if ( $tmp_article->getPrix_achat_ht ()) {
							$pa_article = $tmp_article->getPrix_achat_ht ();
						}
						$ca_article = (($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))*($doc->part/100);
						$marge_article = ((($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))-($pa_article * $contenu->qte))*($doc->part/100);
						$doc->ca += $ca_article;
						$doc->mg += $marge_article;
						if ($formule_art = article_formule_comm ($tmp_article->getRef_article(), $tmp_article->getRef_art_categ(), $commercial->id_commission_regle)) {
							$comm = new formule_comm($formule_art); 
						} else {
							$comm = new formule_comm($commercial->formule_comm); 
						}
						$doc->comm += $comm->calcul_commission ($ca_article, $marge_article) ;
					}
					$commercial->ca += $doc->ca;
					$commercial->mg += $doc->mg;
					$commercial->comm += $doc->comm;
					$commercial->docs[] = $doc; 
				}

		break;
		case "RGM": 
				// Préparation de la requete
				// Recherche des documents
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc, d.ref_contact, a.nom
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
										LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									WHERE d.id_type_doc = '4' && d.id_etat_doc = '19' &&  ".$query_where." 
									GROUP BY ref_doc
									";
				$resultatd = $bdd->query($queryd);
				while ($doc = $resultatd->fetchObject()) {
					$document = open_doc ($doc->ref_doc);
					$liste_contenu = $document->getContenu ();
					$doc->ca = 0;
					$doc->mg = 0;
					$doc->comm = 0;
					
					
					foreach ($liste_contenu as $contenu) {
						if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article" || !$contenu->visible) {continue;}
						$tmp_article = new article ($contenu->ref_article);
						$doc->detail[]=$contenu;
						//on ajoute le pa de l'article dans la ligne
						$pa_article = $tmp_article->getPaa_ht ();
						if ( $tmp_article->getPrix_achat_ht ()) {
							$pa_article = $tmp_article->getPrix_achat_ht ();
						}
						$ca_article = (($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))*($doc->part/100);
						$marge_article = ((($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))-($pa_article * $contenu->qte))*($doc->part/100);
						if ($formule_art = article_formule_comm ($tmp_article->getRef_article(), $tmp_article->getRef_art_categ(), $commercial->id_commission_regle)) {
							$comm = new formule_comm($formule_art);
						} else {
							$comm = new formule_comm($commercial->formule_comm); 
						}
						
						$doc->ca += $ca_article;
						$doc->mg += $marge_article;
						$doc->comm += $comm->calcul_commission ($ca_article, $marge_article) ;
					}
					$commercial->ca += $doc->ca;
					$commercial->mg += $doc->mg;
					$commercial->comm += $doc->comm;
					$commercial->docs[] = $doc; 
				}
		break;
			
	}	
}
	return $liste_commerciaux;
}

}
?>