
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
<p>suppression de formule </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
if (count($_ALERTES)>0) {
echo "erreur";
}
?>

<script type="text/javascript">
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	
}

?>
if (erreur) {

}
else
{
window.parent.document.getElementById("aff_formule_tarif_<?php echo $_REQUEST["n_liste"]?>").innerHTML="<?php echo $reset_formule;?>";
window.parent.document.getElementById("formule_tarif_<?php echo $_REQUEST["n_liste"]?>").value="<?php echo $reset_formule;?>";
window.parent.document.getElementById("formule_add_<?php echo $_REQUEST["n_liste"]?>").value="0";
window.parent.document.getElementById('tarif_del_<?php echo $_REQUEST["n_liste"]?>').style.display="none";
}
</script>