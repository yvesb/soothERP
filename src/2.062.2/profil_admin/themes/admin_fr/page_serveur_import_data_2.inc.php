
<p class="titre">Import des articles <?php echo $import_serveur->getLib_serveur_import();?></p>

<div id="list_articles">
<?php
if (is_numeric($contenu_fichier)) {
	echo  $nombre_articles; ?> articles à importer depuis le serveur  <?php echo $import_serveur->getLib_serveur_import();?><br />
	<?php 
} else {
	echo $contenu_fichier;
}
?>
</div>
<?php 
if ($nombre_articles != "0") {
	?>
	<div style="text-align:center"><span id="lauch_maj_article" style="cursor:pointer; font-weight:bolder">LANCER LA MISE A JOUR</span></div>
	
	Mise à jour des articles:
	<span id="progression_article"></span>
	
	<br />
	
	Mise à jour des liaisons et composants:
	<span id="progression_compo"></span>
	
	<div id="maj_encours">
	</div>
	
	<script type="text/javascript">
	
	Event.observe('lauch_maj_article', 'click',  function(evt){
		Event.stop(evt); 
		var AppelAjax = new Ajax.Updater(
										"maj_encours",
										"serveur_import_data_2_maj.php", 
										{
										parameters: {ref_serveur : "<?php echo $import_serveur->getRef_serveur_import();?>", load_info: "articles", debut : "0", fin: "<?php echo $IMPORT_ARTICLE_LIMIT ?>", nombre_articles : "<?php readfile($fichier); ?>" },
										evalScripts:true,
										insertion: Insertion.Bottom
										}
										);
	}, false);
	//on masque le chargement
	H_loading();
	</script>
	<?php 
}
?>
</div>