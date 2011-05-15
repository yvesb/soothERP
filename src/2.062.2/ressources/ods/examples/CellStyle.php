<?php

// Load library
require_once('../ods.php');

// Create Ods object
$ods  = new ods();

// Red text
$style1 = new odsStyleTableCell();
$style1->setColor('#ff0000');

// Green background
$style2 = new odsStyleTableCell();
$style2->setBackgroundColor('#00ff00');

// Blue border
$style3 = new odsStyleTableCell();
$style3->setBorder('0.01cm solid #0000ff');

// Align start
$style4_1 = new odsStyleTableCell();
$style4_1->setTextAlign('start');

// Align center
$style4_2 = new odsStyleTableCell();
$style4_2->setTextAlign('center');

// Align end
$style4_3 = new odsStyleTableCell();
$style4_3->setTextAlign('end');

// Align justify
$style4_4 = new odsStyleTableCell();
$style4_4->setTextAlign('justify');

// Bold [bold, normal]
$style5 = new odsStyleTableCell();
$style5->setFontWeight('bold');

// Italic [italic, normal]
$style6 = new odsStyleTableCell();
$style6->setFontStyle('italic');

// Underline [font-color, #000000, null]
$style7 = new odsStyleTableCell();
$style7->setUnderline("font-color"); 

// Font size
$style8 = new odsStyleTableCell();
$style8->setFontSize("18pt"); 

// Font Face
$TimesNewRoman = new odsFontFace('Times New Roman');
$ods->addFontFaces($TimesNewRoman);
$style9 = new odsStyleTableCell();
$style9->setFontFace($TimesNewRoman);

// Font Face
$Webdings = new odsFontFace('Webdings');
$ods->addFontFaces($Webdings);
$style10 = new odsStyleTableCell();
$style10->setFontFace($Webdings);

$table = new odsTable('odsStyleTableCell');

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Red text", $style1));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Green background", $style2));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Blue border", $style3));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Align :"));
$row->addCell( new odsTableCellString("start", $style4_1));
$row->addCell( new odsTableCellString("center", $style4_2));
$row->addCell( new odsTableCellString("end", $style4_3));
$row->addCell( new odsTableCellString("justify : 0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 ...  ", $style4_4));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Bold", $style5));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Italic", $style6));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Underline", $style7));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Font size", $style8));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Times New Roman", $style9));

$table->addRow($row = new odsTableRow());
$row->addCell( new odsTableCellString("Webdings", $style10));

$ods->addTable($table);

// Download the file
$ods->downloadOdsFile("Properties.ods");  

?>