<?php
// *************************************************************************************************************
// AJOUT DES PIECES JOINTES D'UN OBJET
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
<?php 
if ($erreur) {
echo " erreur=true;";
}
foreach ($_ALERTES as $alerte => $value) {
	
}

?>
if (erreur) {
	window.parent.alerte.alerte_erreur ("Erreur lors du téléchargement", "<?php echo $erreur;?>", "<input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Ok\" />");
} else {
	window.parent.page.verify("pieces_ged","pieces_ged.php?ref_objet=<?php echo $_REQUEST["ref_objet"];?>&type_objet=<?php echo $_REQUEST["type_objet"];?>", "true", "pieces_content");
}
</script>