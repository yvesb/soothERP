<?php

// Load library
require_once($LIB_DIR_EXT .'ods/ods.php');

class tab_result {
		
	public function tab_result($result_recherche,$info_recherche) {
		global $ODS_MODELES_DIR;

		// Create Ods object
		$this->ods  = new ods();
		// Liste cmd non chargé
		$this->qte_cmd_loaded = false;

		// Create table
		$this->table = new odsTable('Resultat recherche');
		
		$this->create_titre($info_recherche);
		$this->create_col($result_recherche);
		$this->create_entete($result_recherche);
		$this->create_tab($result_recherche);
		
		//Ajout de la table
		$this->ods->addTable($this->table);
		
		// Download the file
		$this->ods->downloadOdsFile("Recherche.ods");
		
	}
	
	public function create_titre($info) {
		//titre
		$titre = new odsStyleTableCell();
		$titre->setFontWeight('bold');
		$titre->setFontSize("18pt");
		
		// Titre
		$row = new odsTableRow();
		$cell = new odsTableCellString($info->lib_recherche_perso.' - '.$info->desc_recherche, $titre);
		$cell->setNumberColumnsSpanned(4);
		$row->addCell( $cell );
		$this->table->addRow($row);
		$row = new odsTableRow();
		$this->table->addRow($row);
	} 
	
	public function create_col($result_recherche) {
		//Un objet
		$entete=array();
		if(isset($result_recherche[0]))
		$entete=$result_recherche[0];
		foreach ($entete as $cle => $valeur) {	
			$this->create_stylecol("3cm");
		}
	}
	
	public function create_entete($result_recherche) {
		//Création de l'entête du tableau
		$fond_gris = new odsStyleTableCell();
		$fond_gris->setBackgroundColor('#999999');
		$this->table->addRow($row = new odsTableRow());
		
		//Un objet pour récuperer les dénominations des champs pour l'entete
		$entete=array();
		if(isset($result_recherche[0]))
		$entete=$result_recherche[0];
		else{
		$this->create_stylecol("3cm");
		$row->addCell( new odsTableCellString("Pas de résultat", $fond_gris));
		}
		foreach ($entete as $cle => $valeur) {
			$row->addCell( new odsTableCellString($cle, $fond_gris));
		}
	}
	
	public function create_tab($result_recherche) {
		//Création du tableau
		//Affichage des lignes
		foreach ($result_recherche as $objet) {
			$this->table->addRow($row = new odsTableRow());	
			//Affichage des champs
			foreach ($objet as $champ) {
			$row->addCell( new odsTableCellString($champ));
			}
		}
	}
	
	public function create_cell($contenu, $row){
		$cell=$row->addCell( new odsTableCellString($contenu));
		return $cell;
	}
	
	public function create_cellgrey($contenu, $row){
		$fond_gris = new odsStyleTableCell();
		$fond_gris->setBackgroundColor('#999999');
		$cell=$row->addCell( new odsTableCellString($contenu, $fond_gris));
		return $cell;
	}
	
	public function create_cellblue($contenu, $row){
		$fond_bleu = new odsStyleTableCell();
		$fond_bleu->setBackgroundColor('#CCFFFF');
		$cell=$row->addCell( new odsTableCellString($contenu, $fond_bleu));
		return $cell;
	}
	
	public function create_row(){
		$this->table->addRow($row = new odsTableRow());
		return $row;
	}
	
	public function create_stylecol($cm){
	//nb colonne de taille cm   
	$stylecol = new odsStyleTableColumn();
	$stylecol->setColumnWidth($cm);
	$col1 = new odsTableColumn($stylecol);
	$this->table->addTableColumn($col1);
	}
}
?>