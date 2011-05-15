<?php
// *************************************************************************************************************
// UPLOAD D'IMAGES D'UN ARTICLE EN MODE VISUALISATION
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
	window.parent.page.verify("articles_view_ingo_images","catalogue_articles_view_info_images.php?ref_article=<?php echo $article->getRef_article ();?>", "true", "info_images");
}
</script>