<?php
// *************************************************************************************************************
// Ajout d'une recherche
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$parent = $_REQUEST["parent"];

$idtype = $_REQUEST["idtype"];
$lib_recherche = $_REQUEST["lib_recherche"];
$desc_recherche = $_REQUEST["desc_recherche"];
$requete = $_REQUEST["requete"];

add_recherche_perso($idtype, $lib_recherche, $desc_recherche, $requete);

?>

<script type="text/javascript">

window.parent.changed = false;
window.parent.page.verify('recherche_<?php echo $parent;?>','recherche_<?php echo $parent;?>.php' ,"true" ,"sub_content");

</script>	