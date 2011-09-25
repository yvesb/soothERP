<?php
// *************************************************************************************************************
// Ajout de Modes de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$id_code_promo = $_REQUEST["id_code_promo"];
$code = $_REQUEST["code_promo"];
$lib_code_promo = $_REQUEST["lib_code_promo"];
$pourc_code_promo = $_REQUEST["pourc_code_promo"];
$actif = (empty($_REQUEST["actif_code_promo"]))? false : true;

if(is_numeric($pourc_code_promo)){	
	echo "modification";
	$instance_code_promo = new code_promo($_REQUEST["id_code_promo"]);
	$instance_code_promo->modifier($lib_code_promo, $code, $pourc_code_promo, $actif);
}else{
	
}

?>

<script type="text/javascript">

window.parent.changed = false;
window.parent.page.verify('codes_promo','codes_promo.php' ,"true" ,"sub_content");

</script>	