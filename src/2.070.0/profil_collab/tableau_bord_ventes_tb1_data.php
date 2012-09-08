<?php
// *************************************************************************************************************
// Tableau de bord des ventes 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


require_once ($RESSOURCE_DIR."/php-ofc-library/open-flash-chart.php");

	
	
$title = new title("");

$bar = new bar();
$bar->colour( '#f29400' );

$bar2 = new bar();
$bar2->colour('#8a5b9d' );

$x = new x_axis();
$x->set_colour( '#000000' );
$x->set_stroke(1);
$x->set_grid_colour( '#CCCCCC' );

//
// switch data
//
switch ($_REQUEST["data"]) {
	case "by_day":
		$data = array(round($_REQUEST["val_1"]));
		$data2 = array(round($_REQUEST["val_2"]));
		$x->set_labels_from_array(array( '' )	);
		$max = $_REQUEST["val_2"];
		if ($_REQUEST["val_1"] > $_REQUEST["val_2"]) {$max = $_REQUEST["val_1"];}
	break;
	case "by_week":
		$data = array(round($_REQUEST["val_1"]));
		$data2 = array(round($_REQUEST["val_2"]));
		$x->set_labels_from_array(array( '')	);
		$max = $_REQUEST["val_2"];
		if ($_REQUEST["val_1"] > $_REQUEST["val_2"]) {$max = $_REQUEST["val_1"];}
	break;
	case "by_month":
		$data = array(round($_REQUEST["val_1"]));
		$data2 = array(round($_REQUEST["val_2"]));
		$x->set_labels_from_array(array( '' ));
		$max = $_REQUEST["val_2"];
		if ($_REQUEST["val_1"] > $_REQUEST["val_2"]) {$max = $_REQUEST["val_1"];}
	break;
	case "by_year":
		$data = array(round($_REQUEST["val_1"]));
		$data2 = array(round($_REQUEST["val_2"]));
		$x->set_labels_from_array(array( '' )	);
		$max = $_REQUEST["val_2"];
		if ($_REQUEST["val_1"] > $_REQUEST["val_2"]) {$max = $_REQUEST["val_1"];}
	break;

}
$bar2->set_values( $data2 );
$bar->set_values( $data );


$y = new y_axis();
$y->set_range(0, round($max), round($max/2));
$y->set_label_text("");
$y->set_grid_colour("#FFFFFF");
$y->set_stroke(0);

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->set_number_format(0, true, true, true );
$chart->set_bg_colour( "#FFFFFF" );
$chart->add_element( $bar );
$chart->add_element( $bar2 );
$chart->set_y_axis( $y );
$chart->set_x_axis( $x );

//
// Add the X Axis object to the chart:
//

echo $chart->toString();
?>