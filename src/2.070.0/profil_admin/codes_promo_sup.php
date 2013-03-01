<?php
// *************************************************************************************************************
// suppression de Modes de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if(!empty($_REQUEST["id_code_promo"])){
	$code_promo = new code_promo($_REQUEST["id_code_promo"]);
	$code_promo->supprimer();
}
			


?>
<script type="text/javascript">

window.parent.changed = false;
window.parent.page.verify('codes_promo','codes_promo.php' ,"true" ,"sub_content");

</script>		