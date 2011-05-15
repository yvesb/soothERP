
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
<p>art_categ grp_caract supp </p>
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
foreach ($_ALERTES as $alerte => $value) {


	
}

?>
if (erreur) {


}
else
{
<?php 
if (isset ($_REQUEST['ref_art_categ']) ) {?>
window.parent.changed = false;

//mise à jour des grp de caracteristique
window.parent.document.getElementById("grp_caract_art_categ").innerHTML="";
window.parent.page.verify('grp_caract_art_categ', 'catalogue_categorie_grpcaract.php?ref_art_categs=<?php echo $_REQUEST['ref_art_categ']?>', 'true', 'grp_caract_art_categ');

//mise à jour des caracteristiques
window.parent.page.verify('caract_art_categ', 'catalogue_categorie_caract.php?ref_art_categs=<?php echo $_REQUEST['ref_art_categ']?>', 'true', 'caract_art_categ');
<?php }?>
}
</script>