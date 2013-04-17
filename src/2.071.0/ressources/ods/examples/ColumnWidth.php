<?php

// Load library
require_once('../ods.php');

// Create Ods object
$ods  = new ods();

$table = new odsTable('Column Width');

// create column width 1cm   
$styleColumn = new odsStyleTableColumn();
$styleColumn->setColumnWidth("1cm");
$column1 = new odsTableColumn($styleColumn);

// create column width 7cm
$styleColumn = new odsStyleTableColumn();
$styleColumn->setColumnWidth("7cm");
$column2 = new odsTableColumn($styleColumn);

// add 2 1cm column
$table->addTableColumn($column1);
$table->addTableColumn($column1);

// add 1 7cm column
$table->addTableColumn($column2);

// Create data
$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("1cm"));
$row->addCell( new odsTableCellString("1cm"));
$row->addCell( new odsTableCellString("7cm ..."));

// Add table to ods
$ods->addTable($table);

// Download the file
$ods->downloadOdsFile("ColumnWidth.ods");
  
?>
