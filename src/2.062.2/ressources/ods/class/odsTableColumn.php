<?php

/*-
 * Copyright (c) 2009 Laurent VUIBERT
 * License : GNU Lesser General Public License v3
 */

class odsTableColumn {
	//private $styleName;
	private $repeated;
	private $odsStyleTableColumn;
	
	public function __construct(odsStyleTableColumn $odsStyleTableColumn) {
		$this->odsStyleTableColumn = $odsStyleTableColumn;
		$this->repeated = null;
	}
	
	public function getContent(ods $ods,DOMDocument $dom) {
		if(!$ods->getStyleByName($this->odsStyleTableColumn->getName()))
			$ods->addTmpStyles($this->odsStyleTableColumn);
		
		$table_table_column = $dom->createElement('table:table-column');
			$table_table_column->setAttribute("table:style-name", $this->odsStyleTableColumn->getName());
			if($this->repeated)
				$table_table_column->setAttribute("table:number-columns-repeated", $this->repeated);
			$table_table_column->setAttribute("table:default-cell-style-name", "Default");
		return $table_table_column;
	}

	public function setRepeated($repeated) {
		$this->repeated = $repeated;
	}
	
	function getOdsStyleTableColumn() {
		return $this->odsStyleTableColumn;
	}
}

class odsTableColumnWithWidth extends odsTableColumn {
	public function __construct($width) {
		$styleColumn = new odsStyleTableColumn();
		$styleColumn->setColumnWidth($width);
		parent::__construct($styleColumn);
	}
}

?>
