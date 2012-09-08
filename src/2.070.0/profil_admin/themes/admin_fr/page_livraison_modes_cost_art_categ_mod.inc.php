<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>liv_mode_cost_art_categ MAJ</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

foreach ($_INFOS as $info => $value) {
	echo $info." => ".$value."<br>";
}
?>
<script type="text/javascript">
var texte_erreur="";
var erreur=false;
<?php 
if (count($_ALERTES)>0) {
}
?>
if (erreur) {
	
}
else
{
window.parent.changed = false;
window.parent.page.traitecontent('livraison_modes_cost_art_categ_det','livraison_modes_cost_art_categ_det.php?id_livraison_mode=<?php echo $livraison_mode->getId_livraison_mode();?>&ref_art_categ=<?php echo $_REQUEST["ref_art_categ"];?>' ,"true" ,"mode_liv_cost_<?php echo $_REQUEST["ref_art_categ"];?>");
}
</script>