<?php
// *************************************************************************************************************
// Tableau de bord des ventes 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


require_once ($RESSOURCE_DIR."/php-ofc-library/open-flash-chart.php");

	
$jour_liste = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");

$mois_liste = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre");

// mauve $bar2->colour('#8a5b9d' );

$d = new solid_dot();
$d->size(2)->halo_size(1)->colour('#f29400');

$x = new x_axis();
$x->set_stroke(1);
$x->set_colour("#cccccc");

$line = new line();
$line->set_default_dot_style($d);
$line->set_width( 2 );
$line->set_colour( '#f29400' );


$x_labels = new x_axis_labels();
$x_labels->set_colour( '#cccccc' );
$x_labels->set_size( 11 );


// switch data
//
switch ($_REQUEST["data"]) {
	case "7":
		$title = new title("Evolution du chiffre d'affaire sur les 7 derniers jours");
		$resultats = array();
		for ($j = 6; $j >= 0; $j--) {
			$resultats[] = array(
													date("N", mktime(0,0,0, date("m"), date("d")-$j, date("Y"))),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m"), date("d")-$j, date("Y")) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m"), date("d")-$j, date("Y")) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = $jour_liste[$resultats[$i][0]-1];
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		
	break;
	case "7_less":
		$title = new title(utf8_encode("Evolution du chiffre d'affaire sur les 7 jours précédents "));
		$resultats = array();
		for ($j = 6; $j >= 0; $j--) {
			$resultats[] = array(
													date("N", mktime(0,0,0, date("m"), date("d")-$j-7, date("Y"))),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m"), date("d")-$j-7, date("Y")) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m"), date("d")-$j-7, date("Y")) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = $jour_liste[$resultats[$i][0]-1];
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		$d->colour('#8a5b9d');
		$line->set_colour( '#8a5b9d' );
		
	break;
	case "7_equi":
		$title = new title(utf8_encode("Evolution du chiffre d'affaire sur la période équivalente l'an passé"));
		$resultats = array();
		$lasemaine = get_semaine(date("W"), date("Y")-1);
		$lejour = $lasemaine[date("N")-1];
		
		for ($j = 6; $j >= 0; $j--) {
			$resultats[] = array(
													date("N", mktime(0,0,0, date("m", strtotime($lejour)), date("d", strtotime($lejour))-$j, date("Y")-1)),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m", strtotime($lejour)), date("d", strtotime($lejour))-$j, date("Y")-1) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m", strtotime($lejour)), date("d", strtotime($lejour))-$j, date("Y")-1) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = $jour_liste[$resultats[$i][0]-1];
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		$d->colour('#8a5b9d');
		$line->set_colour( '#8a5b9d' );
		
	break;
	
	//periode 30 jours
	
	case "30":
		$title = new title("Evolution du chiffre d'affaire sur les 30 derniers jours");
		$resultats = array();
		for ($j = 29; $j >= 0; $j--) {
			$resultats[] = array(
													date("d", mktime(0,0,0, date("m"), date("d")-$j, date("Y"))),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m"), date("d")-$j, date("Y")) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m"), date("d")-$j, date("Y")) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = $resultats[$i][0];
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		
	break;
	case "30_less":
		$title = new title(utf8_encode("Evolution du chiffre d'affaire sur les 30 jours précédents "));
		$resultats = array();
		for ($j = 29; $j >= 0; $j--) {
			$resultats[] = array(
													date("d", mktime(0,0,0, date("m"), date("d")-$j-30, date("Y"))),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m"), date("d")-$j-30, date("Y")) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m"), date("d")-$j-30, date("Y")) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = $resultats[$i][0];
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		$d->colour('#8a5b9d');
		$line->set_colour( '#8a5b9d' );
		
	break;
	case "30_equi":
		$title = new title(utf8_encode("Evolution du chiffre d'affaire sur la période équivalente l'an passé"));
		$resultats = array();
		$lasemaine = get_semaine(date("W"), date("Y")-1);
		
		$lejour = $lasemaine[date("N")-1];
		for ($j = 29; $j >= 0; $j--) {
			$resultats[] = array(
													date("d", mktime(0,0,0, date("m", strtotime($lejour)), date("d", strtotime($lejour))-$j, date("Y",strtotime($lejour)))),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m", strtotime($lejour)), date("d", strtotime($lejour))-$j, date("Y", strtotime($lejour))) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m", strtotime($lejour)), date("d", strtotime($lejour))-$j, date("Y", strtotime($lejour))) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = $resultats[$i][0];
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		$d->colour('#8a5b9d');
		$line->set_colour( '#8a5b9d' );
		
	break;
	//periode 12 mois
	
	case "12":
		$title = new title("Evolution du chiffre d'affaire sur les 12 derniers mois");
		$resultats = array();
		for ($j = 11; $j >= 0; $j--) {
			$resultats[] = array(
													date("m", mktime(0,0,0, date("m")-$j, 1, date("Y"))),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m")-$j, 1, date("Y")) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m")-$j+1, 0, date("Y")) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = utf8_encode($mois_liste[$resultats[$i][0]-1]);
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		
	break;
	case "12_less":
		$title = new title(utf8_encode("Evolution du chiffre d'affaire sur les 12 mois précédents "));
		$resultats = array();
		for ($j = 11; $j >= 0; $j--) {
			$resultats[] = array(
													date("m", mktime(0,0,0, date("m")-$j-12, 1, date("Y"))),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, date("m")-$j-12, 1, date("Y")) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, date("m")-$j-11, 0, date("Y")) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = utf8_encode($mois_liste[$resultats[$i][0]-1]);
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		$d->colour('#8a5b9d');
		$line->set_colour( '#8a5b9d' );
		
	break;
	//periode 3 ans
	
	case "3":
		$title = new title(utf8_encode("Evolution du chiffre d'affaire sur les 3 dernières années"));
		$resultats = array();
		for ($j = 2; $j >= 0; $j--) {
			$resultats[] = array(
													date("Y", mktime(0,0,0, 1, 1, date("Y")-$j)),
													charger_doc_CA (
														array(
														date("Y-m-d H:i:s", mktime(0,0,0, 1, 1, date("Y")-$j) ) ,
														date("Y-m-d H:i:s", mktime(23,59,59, 12, 31, date("Y")-$j) )
														)
													)
													);
		}
		$liste_label = array();
		$max = 0;
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = $resultats[$i][0];
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		
	break;


}
//nl2br(print_r($GLOBALS['_ALERTES']['st']));
$line->set_values( $data );

$x_labels->set_labels($liste_label);
$x->set_labels( $x_labels );


$y = new y_axis();
$y->set_range(0, round($max+1), round($max/2));
$y->set_stroke(1);
$y->set_colour("#cccccc");
$y->set_steps( round($max/2) );


$title->set_style( "{font-size: 12px; color: #999999; text-align: center;}" );

$chart = new open_flash_chart();

$chart->set_title( $title );

$chart->set_number_format(0, true, true, true );
$chart->set_bg_colour( "#FFFFFF" );
$chart->add_element( $line );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );


//
// Add the X Axis object to the chart:
//

echo $chart->toString();
?>