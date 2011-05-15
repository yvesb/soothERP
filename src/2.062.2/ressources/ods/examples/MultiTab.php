<?php
// This example is writen in UTF-8

// Load library
require_once('../ods.php');

// Create Ods object
$ods  = new ods();

// Create table named 'table 1'
$table1 = new odsTable('table 1');
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Hello") );
$row->addCell( new odsTableCellString("World") );
$table1->addRow($row);
$ods->addTable($table1);

// Create table named 'table 2'
$table2 = new odsTable('table 2');
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Rand1") );
$row->addCell( new odsTableCellString("=") );
$row->addCell( new odsTableCellString( rand() ) );
$table2->addRow($row);

$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Rand2") );
$row->addCell( new odsTableCellString("=") );
$row->addCell( new odsTableCellString( rand() ) );
$table2->addRow($row);

$ods->addTable($table2);

//Select 'table 2'
$ods->setDefaultTable($table2);

// Download the file
$ods->downloadOdsFile("multiTable.ods");
?>
