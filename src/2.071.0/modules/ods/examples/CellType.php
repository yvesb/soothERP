<?php
// Load library
require_once('../ods.php');

// Create Ods object
$ods  = new ods();

// Create table named 'Cells'
$table = new odsTable('Cells');

// Empty cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Empty cell") );
$row->addCell( new odsTableCellEmpty() );
$table->addRow($row);

// String cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("String cell") );
$row->addCell( new odsTableCellString("String in my cell") );
$table->addRow($row);

// Email cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Email cell") );
$row->addCell( new odsTableCellStringEmail("lapinator@gmx.fr") );
$table->addRow($row);

// Url cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Url cell") );
$row->addCell( new odsTableCellStringUrl("http://odsphpgenerator.lapinator.net") );
$table->addRow($row);

// Foat cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Float cell") );
$row->addCell( new odsTableCellFloat(5.216) );
$table->addRow($row);

// Date cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Date cell") );
$row->addCell( new odsTableCellString("US :") );
$row->addCell( new odsTableCellDate(date('Y-m-d'), 'MMDDYYYY') );
$row->addCell( new odsTableCellString("FR :") );
$row->addCell( new odsTableCellDate(date('Y-m-d'), 'DDMMYYYY') );
$row->addCell( new odsTableCellString("Or :") );
$row->addCell( new odsTableCellDate(date('Y-m-d'), 'MMMDYYYY') );
$table->addRow($row);

// Time cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Time cell") );
$row->addCell( new odsTableCellString("US :") );
$row->addCell( new odsTableCellTime('PT20H30M50S', 'HHMMSSAMPM') );
$row->addCell( new odsTableCellString("FR :") );
$row->addCell( new odsTableCellTime('PT20H30M50S', 'HHMMSS') );
$table->addRow($row);

// DateTime cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Time cell") );
$row->addCell( new odsTableCellString("US :") );
$row->addCell( new odsTableCellDateTime(date('Y-m-d').'T20:30:50', 'MMDDYYHHMMSSAMPM') );
$row->addCell( new odsTableCellString("FR :") );
$row->addCell( new odsTableCellDateTime(date('Y-m-d').'T20:30:50', 'DDMMYYHHMMSS') );
$table->addRow($row);

// EUR cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Euro cell") );
$row->addCell( new odsTableCellCurrency(rand(0,100), 'EUR') );
$row->addCell( new odsTableCellCurrency(-rand(0,100), 'EUR') );
$table->addRow($row);

// USD cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Dolars cell") );
$row->addCell( new odsTableCellCurrency(rand(0,100), 'USD') );
$row->addCell( new odsTableCellCurrency(-rand(0,100), 'USD') );
$table->addRow($row);

// GBP cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Pounds cell") );
$row->addCell( new odsTableCellCurrency(rand(0,100), 'GBP') );
$row->addCell( new odsTableCellCurrency(-rand(0,100), 'GBP') );
$table->addRow($row);

// Image cell
$row   = new odsTableRow();
$row->addCell( new odsTableCellString("Image cell") );
$row->addCell( new odsTableCellImage("logo.png") );
$table->addRow($row);

$ods->addTable($table);
// Download the file
$ods->downloadOdsFile("CellType.ods");

?>