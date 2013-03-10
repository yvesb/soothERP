<?php
// *************************************************************************************************************
// Ajout de Modes de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$lib_code_promo = $_REQUEST["lib_code_promo"];
$code = $_REQUEST["code"];
$pourcentage = $_REQUEST["pourcentage"];

echo $_REQUEST["lib_code_promo"].','.$_REQUEST["code"].','.$_REQUEST["pourcentage"];

$code_promo = new code_promo();
$code_promo->create($lib_code_promo, $code, $pourcentage);


// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);

foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

foreach ($_INFOS as $info => $value) {
	echo $info." => ".$value."<br>";
}

?>

<script type="text/javascript">

window.parent.changed = false;
window.parent.page.verify('codes_promo','codes_promo.php' ,"true" ,"sub_content");

</script>	