<?php
/*-
 * Copyright (c) 2009 Laurent VUIBERT
 * License : GNU Lesser General Public License v3
 */

class odsTableRow {
	private $styleName;
	private $cells;
	
	public function __construct(odsStyleTableRow $odsStyleTableRow = null) {
		if($odsStyleTableRow) $this->styleName = $odsStyleTableRow->getName;
		else                  $this->styleName = "ro1";
		$this->cells                           = array();
	}
	
	public function addCell(odsTableCell $odsTableCell) {
		array_push($this->cells,$odsTableCell);
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$table_table_row = $dom->createElement('table:table-row');
			$table_table_row->setAttribute("table:style-name", $this->styleName);
		
			if(count($this->cells)) {
				foreach($this->cells as $cell) {
					$table_table_row->appendChild($cell->getContent($ods, $dom));
					if($cell->getNumberColumnsSpanned() > 1) {
						$odsCoveredTableCell = new odsCoveredTableCell();
						$odsCoveredTableCell->setNumberColumnsRepeated($cell->getNumberColumnsSpanned()-1);
						$table_table_row->appendChild($odsCoveredTableCell->getContent($ods, $dom));
					}
				}
					
			} else {
				$cell = new odsTableCellEmpty();
				$table_table_row->appendChild($cell->getContent($ods, $dom));
			}
		
		return $table_table_row;
	}
	
}






?>
