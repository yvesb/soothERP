<?php
// *************************************************************************************************************
// Tableau de bord des ventes test
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

require_once ($RESSOURCE_DIR."/php-ofc-library/open-flash-chart.php");


$mois_liste = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre");

// mauve $bar2->colour('#8a5b9d' );

$d = new solid_dot();
$d->size(2)->halo_size(1)->colour('#f29400');
$d2 = new solid_dot();
$d2->size(2)->halo_size(1)->colour('#8a5b9d');

$x = new x_axis();
$x->set_stroke(1);
$x->set_colour("#cccccc");




$x_labels = new x_axis_labels();
$x_labels->set_colour( '#cccccc' );
$x_labels->set_size( 11 );


		$max = 0;
// switch data
//
switch ($_REQUEST["type"]) {
		case "1":
		$title = new title("Evolution du nombre de fiches clients sur les 12 derniers mois");
		$line = new line();
		$line->set_default_dot_style($d);
		$line->set_width( 1 );
		$line->set_colour( '#f29400' );
		$resultat_ca = array();
		$resultats = array();
		for ($j = 11; $j >= 0; $j--) {
			$nb=0;
			$query = "SELECT DISTINCT ac.ref_contact 								
								FROM annu_client ac
								LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
								LEFT JOIN annuaire a ON a.ref_contact = ac.ref_contact
								WHERE a.date_creation <= '".date("Y-m-d H:i:s", mktime(23,59,59, date("m")-$j+1, 0, date("Y")) )."' &&  ( ISNULL(a.date_archivage) || a.date_archivage > '".date("Y-m-d H:i:s", mktime(23,59,59, date("m")-$j+1, 0, date("Y")) )."' ) ";	
			$resultat = $bdd->query ($query);
			while ($contact_client = $resultat->fetchObject()) { $nb ++; }
		
			$resultats[] = array(
													date("m", mktime(0,0,0, date("m")-$j, 1, date("Y"))),
													$nb
													);
		}
		$liste_label = array();
		for ($i = 0; $i < count($resultats); $i++) {
			$liste_label[] = utf8_encode($mois_liste[$resultats[$i][0]-1]);
			$resultat_ca[] = $resultats[$i][1];
			if ($resultats[$i][1] > $max) {$max = $resultats[$i][1];}
		}
		$data = $resultat_ca;
		$line->set_values( $data );
		break;
		
		
		
		case "2":
		$title = new title(utf8_encode("Evolution du nombre de création clients sur les 12 derniers mois"));
		$line = new line();
		$line->set_default_dot_style($d2);
		$line->set_width( 1 );
		$line->set_colour( '#8a5b9d' );
		$resultat_ca = array();
		$resultats2 = array();
		for ($k = 11; $k >= 0; $k--) {
			$nb2=0;
			$query2 = "SELECT DISTINCT ac.ref_contact 								
								FROM annu_client ac
								LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
								LEFT JOIN annuaire a ON a.ref_contact = ac.ref_contact
								WHERE a.date_creation <= '".date("Y-m-d H:i:s", mktime(23,59,59, date("m")-$k+1, 0, date("Y")) )."' &&  a.date_creation >= '".date("Y-m-d H:i:s", mktime(0,0,0, date("m")-$k, 1, date("Y")) )."'  ";	

			$resultat2 = $bdd->query ($query2);
			while ($contact_client2 = $resultat2->fetchObject()) { $nb2 ++; }
		
			$resultats2[] = array(
													date("m", mktime(0,0,0, date("m")-$k, 1, date("Y"))),
													$nb2
													);
		}
		$liste_label = array();
		for ($i = 0; $i < count($resultats2); $i++) {
			$liste_label[] = utf8_encode($mois_liste[$resultats2[$i][0]-1]);
			$resultat_ca[] = $resultats2[$i][1];
			if ($resultats2[$i][1] > $max) {$max = $resultats2[$i][1];}
		}
		$data2 = $resultat_ca;
		
		$line->set_values( $data2 );
		break;
}

//nl2br(print_r($GLOBALS['_ALERTES']['st']));

$x_labels->set_labels($liste_label);
$x->set_labels( $x_labels );


$y = new y_axis();
$y->set_range(0, round($max+1), round($max/2));
$y->set_stroke(1);
$y->set_colour("#cccccc");
$y->set_steps( round($max/2) );


$title->set_style( "{font-size: 12px; color: #000000; text-align: center; font-weight: bold}" );

$chart = new open_flash_chart();

$chart->set_title( $title );

$chart->set_number_format(0, true, true, true );
$chart->set_bg_colour( "#FFFFFF" );
$chart->add_element( $line );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );

                    
echo $chart->toString();

?>