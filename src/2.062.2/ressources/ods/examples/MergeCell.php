<?php

// Load library
require_once('../ods.php');

// Create Ods object
$ods  = new ods();

// Create table
$table = new odsTable('MergeCell');
$ods->addTable($table);

// Merge 4 horizontal cell
$row = new odsTableRow();
$cell = new odsTableCellString('Merge 4 cells');
$cell->setNumberColumnsSpanned(4);
$row->addCell( $cell );
$table->addRow($row);

// Merge 4 vertical cell
$row = new odsTableRow();
$cell = new odsTableCellString('Merge 4 cells');
$cell->setNumberRowsSpanned(4);
$row->addCell( $cell );
$table->addRow($row);

for($i=0; $i<3; $i++) { // You need add cell odsCoveredTableCell, in covered cell except the first row (implicit)
	$row = new odsTableRow();
	$row->addCell( new odsCoveredTableCell() );
	$table->addRow($row);
}

// Merge 4*7 cell
$row = new odsTableRow();
$cell = new odsTableCellString('Merge 4*4 cells');
$cell->setNumberColumnsSpanned(4);
$cell->setNumberRowsSpanned(4);
$row->addCell( $cell );
$table->addRow($row);

for($i=0; $i<3; $i++) { // You need add cell odsCoveredTableCell, in covered cell except the first row (implicit)
	$row = new odsTableRow();
	$row->addCell( new odsCoveredTableCell() );
	$row->addCell( new odsCoveredTableCell() );
	$row->addCell( new odsCoveredTableCell() );
	$row->addCell( new odsCoveredTableCell() );
	$table->addRow($row);
}

// Download the file
$ods->downloadOdsFile("MergeCell.ods");

?>
