<?php
// *************************************************************************************************************
// Tableau de bord des ventes test
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$lasemaine = get_semaine(date("W"), date("Y")-1);
$CA_day_1 = charger_doc_CA (array($lasemaine[date("N")-1]." 00:00:00" , $lasemaine[date("N")-1]." 23:59:59" ));

$lasemaine = get_semaine(date("W"), date("Y"));
$CA_day_0 = charger_doc_CA (array($lasemaine[date("N")-1]." 00:00:00" , $lasemaine[date("N")-1]." 23:59:59" ));


$lasemaine = get_semaine(date("W"), date("Y")-1);
$CA_week_1 = charger_doc_CA (array($lasemaine[0]." 00:00:00" , $lasemaine[6]." 23:59:59" ));

$lasemaine = get_semaine(date("W"), date("Y"));
$CA_week_0 = charger_doc_CA (array($lasemaine[0]." 00:00:00" , $lasemaine[6]." 23:59:59" ));

$CA_month_1 = charger_doc_CA (array(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")-1) ) , date("Y-m-d H:i:s", mktime(23, 59, 59, date("m", time()), date("d"), date("Y")-1) ) ));
$CA_month_0 = charger_doc_CA (array(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")) ) , date("Y-m-d H:i:s", mktime(23, 59, 59, date("m", time()), date("d"), date("Y")) ) ));

$CA_year_1 = charger_doc_CA (array(date("Y-m-d H:i:s", mktime(0, 0, 0, 01, 01, date("Y")-1) ) , date("Y-m-d H:i:s", mktime(23, 59, 59, 12, 31, date("Y")-1) ) ));

$CA_year_0 = charger_doc_CA (array(date("Y-m-d H:i:s", mktime(0, 0, 0, 01, 01, date("Y")) ) , date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d"), date("Y") ) ) ));
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_tableau_bord_ventes_tb1_contener.inc.php");

?>