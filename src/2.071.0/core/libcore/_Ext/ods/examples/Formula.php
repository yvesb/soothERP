<?php
// All file is writen in UTF-8

// Load library
require_once('../ods.php');

// Create Ods object
$ods  = new ods();

// Create table named 'table 1'
$table = new odsTable('table 1');

// Create the first row
$row   = new odsTableRow();

// Create 10 number cell
for($i=0; $i<10; $i++) {
	$row  = new odsTableRow();
	$row->addCell( new odsTableCellEmpty());
	$row->addCell( new odsTableCellFloat(rand(0,50)));
	$table->addRow($row);
}

// Add Formula cell
// Forumla is writen in english language, it's internal format for formula
$row  = new odsTableRow();

$row->addCell( new odsTableCellString("Sum :") );

$cell = new odsTableCellFloat(0);
$cell->setFormula("SUM([.B1:.B10])");
$row->addCell( $cell );

$table->addRow($row);

// Empty row
$row  = new odsTableRow();
$table->addRow($row);

// 2nd example contatenate string
$row  = new odsTableRow();

$row->addCell( new odsTableCellString("Laurent") );
$row->addCell( new odsTableCellString("VUIBERT") );

$cell = new odsTableCellString("");
$row->addCell( $cell );
$cell->setFormula('CONCATENATE([.A13];" ";[.B13];" : ";[.B11])');

$table->addRow($row);


// Attach talble to ods
$ods->addTable($table);

// Download the file
$ods->downloadOdsFile("HelloWorld.ods");


?>
