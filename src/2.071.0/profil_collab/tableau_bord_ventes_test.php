<?php
// *************************************************************************************************************
// Tableau de bord des ventes test
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


require_once ($RESSOURCE_DIR."/php-ofc-library/open-flash-chart.php");

// generate some random data
srand((double)microtime()*1000000);

$max = 20;
$tmp = array();
for( $i=0; $i<10; $i++ )
{
  $tmp[] = new pie_value(rand(0,$max), "Label ".$i);
}
$title = new title("");

$pie = new pie();
$pie->start_angle(35)
    ->add_animation( new pie_fade() )
    ->add_animation( new pie_bounce(6) )
    ->label_colour('#432BAF') // <-- uncomment to see all labels set to blue
  //  ->tooltip( '#val# de #total#<br>#percent# of 100%' )
    ->colours(array("#97bf0d","#ab8cbc","#f29400","#8baed8","#ffed00"));
				
$pie->set_tooltip( '#label#<br>#val# '.$MONNAIE[4].' (#percent#)' );
$pie->set_no_labels();
$pie->set_values( $tmp );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->set_bg_colour( "#FFFFFF" );
$chart->add_element( $pie );
                    
echo $chart->toString();

?>