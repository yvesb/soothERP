<?php
// *************************************************************************************************************
// Tableau de bord des ventes test
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

require_once ($RESSOURCE_DIR."/php-ofc-library/open-flash-chart.php");
//if (!$_SESSION['user']->check_permission ("6")) { exit();}


if (!isset($_REQUEST['ref_article'])) {
	echo "La référence de l'article n'est pas précisée";
	exit;
}

$article = new article ($_REQUEST['ref_article']);
if (!$article->getRef_article()) {
	echo "La référence de l'article est inconnue";		exit;

}
$tarifs_liste = get_tarifs_listes_formules ($article->getRef_art_categ ());




$mois_liste = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre");

// mauve $bar2->colour('#8a5b9d' );

$x = new x_axis();
$x->set_stroke(1);
$x->set_colour("#cccccc");


$x_labels = new x_axis_labels();
$x_labels->set_colour( '#cccccc' );
$x_labels->set_size( 11 );

$y = new y_axis();
$y->set_stroke(1);
$y->set_colour("#cccccc");
$max = 0;


$chart = new open_flash_chart();
$title = new title("Evolution des prix de vente par semaine");


$title->set_style( "{font-size: 12px; color: #000000; text-align: left; font-weight: bold}" );
$chart->set_title( $title );

$chart->set_number_format(0, true, true, true );
$chart->set_bg_colour( "#FFFFFF" );


$liste_label = array();

$lasemaine = get_semaine(date("W"), date("Y"));

$couleurs = array("#97bf0d","#ab8cbc","#f29400","#8baed8","#ffed00");
$h = 0;
foreach ($tarifs_liste as $tarif_liste) {

	$resultat_ca = array();
	
	${"d".$tarif_liste->id_tarif} = new solid_dot();
	${"d".$tarif_liste->id_tarif}->size(2)->halo_size(1)->colour($couleurs[$h]);
	${"line".$tarif_liste->id_tarif} = new line();
	${"line".$tarif_liste->id_tarif}->set_default_dot_style(${"d".$tarif_liste->id_tarif});
	${"line".$tarif_liste->id_tarif}->set_width( 1 );
	${"line".$tarif_liste->id_tarif}->set_colour( $couleurs[$h] );
	${"line".$tarif_liste->id_tarif}->set_text(utf8_encode($tarif_liste->lib_tarif));
	$resultat_ca = array();
	$resultats2 = array();
	$nb2=0;
	
	
	$query2 = "SELECT apa.pu_ht	
						FROM articles_pv_archive apa
						LEFT JOIN articles a ON a.ref_article = apa.ref_article
						WHERE a.ref_article = '".$_REQUEST["ref_article"]."' && date_maj <= '".date("Y-m-d H:i:s", mktime(23,59,59, date("m")-11, 0, date("Y")) )."'  && !ISNULL(apa.pu_ht) && id_tarif = '".$tarif_liste->id_tarif."' ORDER BY date_maj DESC  LIMIT 0,1";	
	
	$resultat2 = $bdd->query ($query2);
	
	if ($article2 = $resultat2->fetchObject()) { if ($article2->pu_ht) { $nb2 = round($article2->pu_ht);} }
	
	for ($k = 52; $k >= 0; $k--) {
		$date_debut =  date("Y-m-d H:i:s", mktime(23,59,59, date("m", strtotime($lasemaine[0])), date("d", strtotime($lasemaine[0]))-($k*7), date("Y", strtotime($lasemaine[0]))) );
		$date_fin = date("Y-m-d H:i:s", mktime(23,59,59, date("m", strtotime($lasemaine[6])), date("d", strtotime($lasemaine[6]))-($k*7), date("Y", strtotime($lasemaine[6]))) );
	
		$query2 = "SELECT apa.pu_ht
							FROM articles_pv_archive apa
							LEFT JOIN articles a ON a.ref_article = apa.ref_article
							WHERE a.ref_article = '".$_REQUEST["ref_article"]."' && date_maj <= '".$date_fin."' &&  date_maj >= '".$date_debut."' && id_tarif = '".$tarif_liste->id_tarif."' ORDER BY date_maj DESC  LIMIT 0,1";	
		$resultat2 = $bdd->query ($query2);

		while ($article2 = $resultat2->fetchObject()) { if ($article2->pu_ht) { $nb2 = round($article2->pu_ht);} }
	
		$resultats2[] = array(
												date("W", strtotime($date_debut)),
												$nb2
												);
	}
	for ($i = 0; $i < count($resultats2); $i++) {
		$resultat_ca[] = $resultats2[$i][1];
		if ($resultats2[$i][1] > $max) {$max = $resultats2[$i][1];}
	}
	$data2 = $resultat_ca;
	
	${"line".$tarif_liste->id_tarif}->set_values( $data2 );
	
	
	$h ++;
	if ($h >= count($tarifs_liste)) {$h = 0;}
	
$chart->add_element(${"line".$tarif_liste->id_tarif});
			
}

for ($i = 0; $i < count($resultats2); $i++) {
	$liste_label[] = utf8_encode($resultats2[$i][0]);
}


$x_labels->set_labels($liste_label);
$x->set_labels( $x_labels );
$y->set_range(0, round($max+1), round($max/2));
$y->set_steps( round($max/2) );


$chart->set_x_axis( $x );
$chart->set_y_axis( $y );

                    
echo $chart->toString();

?>