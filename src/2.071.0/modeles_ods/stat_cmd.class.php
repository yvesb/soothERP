<?php

// Load library
require_once('../ressources/ods/ods.php');

class ods_stat_cmd {
	var $code_ods_modele = "stat_cmd";
	var $ods;
	var $ca_day;
	var $ca_week;
	var $ca_month;
	var $histo_ventes_m;
	var $sousTotaux;

	//****Debut modele****//
	public function ods_stat_cmd() {

	// Create Ods object
	$ods  = new ods();
	// Liste cmd non chargé
	$this->qte_cmd_loaded = false;

	// Create table
	$table = new odsTable('Statistique de vente');

	//titre
	$titre = new odsStyleTableCell();
	$titre->setFontWeight('bold');
	$titre->setFontSize("18pt"); 

	// Titre
	$row = new odsTableRow();
	$cell = new odsTableCellString(utf8_encode('Quantité commandée par article'), $titre);
	$cell->setNumberColumnsSpanned(4);
	$row->addCell( $cell );
	$table->addRow($row);
	$row = new odsTableRow();
	$table->addRow($row);

	//1ere colonne de taille 10cm   
	$stylecol1 = new odsStyleTableColumn();
	$stylecol1->setColumnWidth("10cm");
	$col1 = new odsTableColumn($stylecol1);
	$table->addTableColumn($col1);

	//Création de l'entête du tableau
		//protected function create_entete(){
	
		$fond_gris = new odsStyleTableCell();
		$fond_gris->setBackgroundColor('#999999');
	
		$table->addRow($row = new odsTableRow());
		$row->addCell( new odsTableCellString("Chiffre d'affaires", $fond_gris));
	
		for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    	
			if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
				else{ $mois_max = 12; }
			if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
				else{ $mois_deb = 1; }
		
			//affichage des mois
			for($m=$mois_deb; $m<=$mois_max ; ++$m ){
				$row->addCell( new odsTableCellString(utf8_encode($this->getLib_mois($m)."-".substr($y, -2)), $fond_gris));
			}
		}
	$row->addCell( new odsTableCellString(utf8_encode('Total'), $fond_gris));
   //}

	//Creation liste article
	global $bdd;	
	$qte_total = 0;

	$query = "SELECT ref_article, lib_article
							FROM articles";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
	$article[$var->ref_article] = $var->lib_article;
	}

	//pour chaque article
	foreach ($article as $ref_art => $lib_art) {
	//encodage utf8
		$result=utf8_encode($lib_art);
	
		$row   = new odsTableRow();
		$row->addCell( new odsTableCellString($result) );
				//pour chaque mois
				$qtesoustotal=0;
		for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    	
			if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
				else{ $mois_max = 12; }
			if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
				else{ $mois_deb = 1; }
		
			//affichage des mois
			for($m=$mois_deb; $m<=$mois_max ; ++$m ){
				$row->addCell( new odsTableCellFloat($this->get_qte_cmd_mensuel($ref_art,$y,$m)));
				//sous total par article
				$qtesoustotal+= $this->get_qte_cmd_mensuel($ref_art,$y,$m);  
			}
		}
	$row->addCell( new odsTableCellFloat($qtesoustotal, $fond_gris));
	$table->addRow($row);
	}
	$row   = new odsTableRow();
	$row->addCell( new odsTableCellString(utf8_encode('Total général'), $fond_gris));

	for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    	
		if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
			else{ $mois_max = 12; }
		if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
			else{ $mois_deb = 1; }
	
		//affichage des mois
			for($m=$mois_deb; $m<=$mois_max ; ++$m ){
				$qte = $this->get_qte_cmd($y,$m);
				$row->addCell( new odsTableCellFloat($qte, $fond_gris));
				$qte_total += $qte;
			}
	}
	$row->addCell( new odsTableCellFloat($qte_total, $fond_gris));
	$table->addRow($row);

	//Ajout de la table
	$ods->addTable($table);
	// Download the file
	$ods->downloadOdsFile("Quantité commandée par article.ods");
}

	//**************************************************
	// FONCTION DE RECUPERATION DES INFORMATIONS
	
	protected function charger_qte_cmd(){
		//creer un tableau contenant la quantité commander par mois et par categorie d'article
		global $bdd;
		
		$query = "SELECT dl.ref_article, doc.date_creation_doc as date, dl.ref_article, dl.qte
						FROM doc_cdc dc
							LEFT JOIN documents doc ON doc.ref_doc = dc.ref_doc
							LEFT JOIN docs_lines dl ON dl.ref_doc = dc.ref_doc
						WHERE doc.id_etat_doc = 10 OR doc.id_etat_doc = 9";
		$resultat = $bdd->query ($query);

		while ($line = $resultat->fetchObject()) { 
			$line->date = date_parse($line->date);
			
			if(empty($this->qte_cmd[$line->ref_article][$line->date['year']][$line->date['month']])){
				$this->qte_cmd[$line->ref_article][$line->date['year']][$line->date['month']] = 0;
			}
			$this->qte_cmd[$line->ref_article][$line->date['year']][$line->date['month']] += $line->qte;
		}
		
		$this->qte_cmd_loaded = true;
	}
	
	protected function get_qte_cmd_mensuel($ref_article, $annee, $mois){
		//retourne la quantité
		if(!$this->qte_cmd_loaded){ $this->charger_qte_cmd(); }
		if(empty($this->qte_cmd[$ref_article][$annee][$mois])){ return 0; }
		return $this->qte_cmd[$ref_article][$annee][$mois];
	} 
	
	public function get_qte_cmd($annee_deb, $mois_deb){
		//retourne la quantité
		if(!$this->qte_cmd_loaded){ $this->charger_qte_cmd(); }
		if(empty($this->qte_cmd)){ return 0; }
		
		$res = 0;
		foreach($this->qte_cmd as $line){
			if(!empty($line[$annee_deb][$mois_deb])){ $res += $line[$annee_deb][$mois_deb]; }
		}
			
		return $res;
		
	} 

	//************************************************
	// FONCTION DIVERSE
  
	protected function getLib_mois($i){
		switch ($i){
			case 1 : return "janvier"; break;
			case 2 : return "février"; break;
			case 3 : return "mars"; break;
			case 4 : return "avril"; break;
			case 5 : return "mai"; break;
			case 6 : return "juin"; break;
			case 7 : return "juillet"; break;
			case 8 : return "août"; break;
			case 9 : return "septembre"; break;
			case 10 : return "octobre"; break;
			case 11 : return "novembre"; break;
			case 12 : return "décembre"; break;
			default : return false; 
		}
	}

}

?>