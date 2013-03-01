<?php
// *************************************************************************************************************
// Ajout de Recherche
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$parent = $_REQUEST["parent"];

$id_recherche = $_REQUEST["id_recherche"];
$lib_recherche = $_REQUEST["lib_recherche"];
$desc_recherche = $_REQUEST["desc_recherche"];
$requete = $_REQUEST["requete"];

mod_recherche_perso($id_recherche, $lib_recherche, $desc_recherche, $requete);

?>

<script type="text/javascript">

window.parent.changed = false;
window.parent.page.verify('recherche_<?php echo $parent;?>','recherche_<?php echo $parent;?>.php' ,"true" ,"sub_content");

</script>	