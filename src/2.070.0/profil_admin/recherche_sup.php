<?php
// *************************************************************************************************************
// suppression de Recherche
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$parent = $_REQUEST["parent"];

if(!empty($_REQUEST["id_recherche"])){
	sup_recherche_perso($_REQUEST["id_recherche"]);
}

?>

<script type="text/javascript">

window.parent.changed = false;
window.parent.page.verify('recherche_<?php echo $parent;?>','recherche_<?php echo $parent;?>.php' ,"true" ,"sub_content");

</script>	