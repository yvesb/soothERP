
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
<p>enregistrement envoi news letter </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
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

window.parent.page.traitecontent('communication_newsletters_gestion_envoi_valide','communication_newsletters_gestion_envoi_valide.php?id_newsletter=<?php echo $_REQUEST["id_newsletter"];?>&id_envoi=<?php echo $id_envoi;?>','true','sub_content');

}
</script>