<?php

// Load library
require_once('../ressources/ods/ods.php');

class ods_export_selected_docs {
		
	public function ods_export_selected_docs() {
	// Create Ods object
            $ods  = new ods();

            // Create table named 'table 1'
            $this->table = new odsTable('Liste des documents');

            // create column width 7cm
            $styleColumn = new odsStyleTableColumn();
            $styleColumn->setColumnWidth("5cm");
            $column2 = new odsTableColumn($styleColumn); 

            // add 1 7cm column
            $this->table->addTableColumn($column2);
            $this->table->addTableColumn($column2);
            $this->table->addTableColumn($column2);
            $this->table->addTableColumn($column2);
            $this->table->addTableColumn($column2);
            $this->table->addTableColumn($column2);
            
            // Bold [bold, normal]
            $bold = new odsStyleTableCell();
            $bold->setFontWeight('bold');
            // Grey Background
            $grey_bg = new odsStyleTableCell();
            $grey_bg->setBackgroundColor('#eeeeee');
            $grey_bg->setTextAlign('start');
            
            $this->create_titre();
            
            // Create the first row
            $row   = new odsTableRow();

            $row->addCell( new odsTableCellString(utf8_encode("Référence"), $bold) );
            $row->addCell( new odsTableCellString("Type de document", $bold) );
            $row->addCell( new odsTableCellString(utf8_encode("État"), $bold) );
            $row->addCell( new odsTableCellString("Contact", $bold) );
            $row->addCell( new odsTableCellString("Montant TTC", $bold) );
            $row->addCell( new odsTableCellString("Date", $bold) );
            $this->table->addRow($row);
            
            $docs = $this->get_docs_infos($_POST['liste_doc']);
            foreach($docs as $d) {
                $row   = new odsTableRow();
                $row->addCell( new odsTableCellString(utf8_encode($d['ref_doc'])) );
                $row->addCell( new odsTableCellString(utf8_encode($d['lib_type_doc'])) );
                $row->addCell( new odsTableCellString(utf8_encode($d['lib_etat_doc'])) );
                $row->addCell( new odsTableCellString(utf8_encode($d['nom_contact'])) );
                if(empty($d['montant_ttc']) && $d['montant_ttc']!=='0')
                    $row->addCell( new odsTableCellString("NaN") );
                else $row->addCell( new odsTableCellCurrency($d['montant_ttc'], 'EUR', $grey_bg) );
                $row->addCell( new odsTableCellString(utf8_encode('Le '.date('d/m/Y à H:i:s', strtotime($d['date_doc'])))) );
                $this->table->addRow($row);
            }

            // Attach talble to ods
            $ods->addTable($this->table);

            // Download the file
            $ods->downloadOdsFile("Liste des documents.ods");
	}
	
        public function create_titre() {
		//titre
		$titre = new odsStyleTableCell();
		$titre->setFontWeight('bold');
		$titre->setFontSize("18pt");
		
		// Titre
		$row = new odsTableRow();
		$cell = new odsTableCellString(utf8_encode("Liste des documents exportés"), $titre);
		$cell->setNumberColumnsSpanned(4);
		$row->addCell( $cell );
		$this->table->addRow($row);
		$row = new odsTableRow();
		$this->table->addRow($row);
	} 
        
	public function get_docs_infos($string) {
            global $bdd;

            $liste_docs = explode(';', $string);
            $sql_in='';
            foreach($liste_docs as $d)
                if(!empty($d)) $sql_in .= ',\''.$d.'\'';
            $sql_in = substr($sql_in,1);

            $query = "SELECT d.ref_doc, dt.lib_type_doc, de.lib_etat_doc, nom_contact, 
                    (SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
                    FROM docs_lines dl
                    WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
                    d.date_creation_doc as date_doc
                FROM documents d 
                    LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
                    LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
                    LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
                WHERE d.ref_doc IN (".$sql_in.") GROUP BY d.ref_doc";

            $resultat = $bdd->query($query);
            $docs = $resultat->fetchAll();
            return $docs;
        }
}
?>