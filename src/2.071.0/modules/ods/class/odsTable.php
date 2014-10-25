<?php
/*-
 * Copyright (c) 2009 Laurent VUIBERT
 * License : GNU Lesser General Public License v3
 */

class odsTable {
	private $name;
	private $styleName;
	private $print;
	
	private $cursorPositionX;
	private $cursorPositionY;
	private $horizontalSplitMode;
	private $verticalSplitMode;
	private $horizontalSplitPosition;
	private $verticalSplitPosition;
	private	$positionLeft;
	private	$positionRight;
	private	$positionTop;
	private	$positionBottom;
	
	private $shapes;
	private $tableColumns;
	private $rows;
	
	public function __construct($name, $odsStyleTable = null) {
		$this->name                         = $name;
		if($odsStyleTable) $this->styleName = $odsStyleTable->getName;
		else               $this->styleName = "ta1";
		$this->print                        = "false";
		
		$this->cursorPositionX              = 0;
		$this->cursorPositionY              = 0;
		$this->horizontalSplitMode          = 0;
		$this->verticalSplitMode            = 0;
		$this->horizontalSplitPosition      = 0;
		$this->verticalSplitPosition        = 0;
		$this->positionLeft                 = 0;
		$this->positionRight                = 0;
		$this->positionTop                  = 0;
		$this->positionBottom               = 0;
		
		$this->shapes                       = array();
		$this->tableColumns                 = array();
		$this->rows                         = array();
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setHorizontalSplit($colones = 1) {
		$this->setHorizontalSplitMode(2);
		$this->setHorizontalSplitPosition($colones);
		$this->setPositionRight($colones);
	}
	
	public function setVerticalSplit($lines = 1) {
		$this->setVerticalSplitMode(2);
		$this->setVerticalSplitPosition($lines);
		$this->setPositionBottom($lines);
	}
	
	public function addDraw(odsDraw $odsDraw) {
		array_push($this->shapes, $odsDraw);
	}
	
	public function addRow($odsTableRow) {
		array_push($this->rows,$odsTableRow);
	}
	
	public function addTableColumn($odsTableColumn) {
		array_push($this->tableColumns, $odsTableColumn);
	}
	
	public function setCursorPositionX($cursorPositionX) {
		$this->cursorPositionX = $cursorPositionX;
	}

	public function setCursorPositionY($cursorPositionY) {
		$this->cursorPositionY = $cursorPositionY;
	}
	
	public function setHorizontalSplitMode($horizontalSplitMode) {
		$this->horizontalSplitMode = $horizontalSplitMode;
	}

	public function setVerticalSplitMode($verticalSplitMode) {
		$this->verticalSplitMode = $verticalSplitMode; 
	}
	
	public function setHorizontalSplitPosition($horizontalSplitPosition) {
		$this->horizontalSplitPosition = $horizontalSplitPosition;
	}
	
	public function setVerticalSplitPosition($verticalSplitPosition) {
		$this->verticalSplitPosition = $verticalSplitPosition;
	}
	
	public function setPositionLeft($positionLeft) {
		$this->positionLeft = $positionLeft;
	}
	
	public function setPositionRight($positionRight) {
		$this->positionRight = $positionRight;
	}
	
	public function setPositionTop($positionTop) {
		$this->positionTop = $positionTop;
	}
	
	public function setPositionBottom($positionBottom) {
		$this->positionBottom = $positionBottom;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$table_table = $dom->createElement('table:table');
			$table_table->setAttribute("table:name", $this->name);
			$table_table->setAttribute("table:style-name", $this->styleName);
			$table_table->setAttribute("table:print", $this->print);
			
			if(count($this->shapes)) {
				$table_shapes = $dom->createElement('table:shapes');
				
				foreach($this->shapes as $shapes) {
					$table_shapes->appendChild($shapes->getContent($ods,$dom));
				}
				
				$table_table->appendChild($table_shapes);
			}
			
			if(count($this->tableColumns)) {
				foreach($this->tableColumns as $tableColumn) 
					$table_table->appendChild($tableColumn->getContent($ods,$dom));
			} else {
				$column = new odsTableColumn($ods->getStyleByName('co1'));
				$table_table->appendChild($column->getContent($ods,$dom));
			}

			if(count($this->rows)) {
				foreach($this->rows as $row) 
					$table_table->appendChild($row->getContent($ods,$dom));
			} else {
				$row = new odsTableRow();
				$table_table->appendChild($row->getContent($ods,$dom));
			}
				
		return $table_table;
	}
	
	public function getSettings(ods $ods, DOMDocument $dom) {
		$config_config_item_map_entry2 = $dom->createElement('config:config-item-map-entry');
			$config_config_item_map_entry2->setAttribute("config:name", $this->name);
			//$config_config_item_map_named->appendChild($config_config_item_map_entry2);
			
			$config_config_item = $dom->createElement('config:config-item',$this->cursorPositionX);
				$config_config_item->setAttribute("config:name", "CursorPositionX");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);
			
			$config_config_item = $dom->createElement('config:config-item',$this->cursorPositionY);
				$config_config_item->setAttribute("config:name", "CursorPositionY");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);
	
			$config_config_item = $dom->createElement('config:config-item',$this->horizontalSplitMode);
				$config_config_item->setAttribute("config:name", "HorizontalSplitMode");
				$config_config_item->setAttribute("config:type", "short");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item', $this->verticalSplitMode);
				$config_config_item->setAttribute("config:name", "VerticalSplitMode");
				$config_config_item->setAttribute("config:type", "short");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',$this->horizontalSplitPosition);
				$config_config_item->setAttribute("config:name", "HorizontalSplitPosition");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);
		
			$config_config_item = $dom->createElement('config:config-item',$this->verticalSplitPosition);
				$config_config_item->setAttribute("config:name", "VerticalSplitPosition");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',2);
				$config_config_item->setAttribute("config:name", "ActiveSplitRange");
				$config_config_item->setAttribute("config:type", "short");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',$this->positionLeft);
				$config_config_item->setAttribute("config:name", "PositionLeft");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',$this->positionRight);
				$config_config_item->setAttribute("config:name", "PositionRight");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',$this->positionTop);
				$config_config_item->setAttribute("config:name", "PositionTop");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',$this->positionBottom);
				$config_config_item->setAttribute("config:name", "PositionBottom");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',0);
				$config_config_item->setAttribute("config:name", "ZoomType");
				$config_config_item->setAttribute("config:type", "short");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',100);
				$config_config_item->setAttribute("config:name", "ZoomValue");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',60);
				$config_config_item->setAttribute("config:name", "PageViewZoomValue");
				$config_config_item->setAttribute("config:type", "int");
				$config_config_item_map_entry2->appendChild($config_config_item);

			$config_config_item = $dom->createElement('config:config-item',"true");
				$config_config_item->setAttribute("config:name", "ShowGrid");
				$config_config_item->setAttribute("config:type", "boolean");
				$config_config_item_map_entry2->appendChild($config_config_item);
		
		return $config_config_item_map_entry2;
	}
}

?>
