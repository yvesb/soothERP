


<div ><br />

<?php if ($_REQUEST["fin"] > $nombre_articles) {echo $nombre_articles;} else {echo $ndebut;}?> articles importés sur <?php echo $_REQUEST["nombre_articles"]; ?><br />
<hr />
</div>

<script type="text/javascript">

<?php

if ($_REQUEST["load_info"] == "articles") {
	?>
	$("progression_article").innerHTML = "<?php if ($_REQUEST["fin"] > $nombre_articles) {echo $nombre_articles;} else {echo $ndebut;}?> articles importés sur <?php echo $_REQUEST["nombre_articles"]; ?>";
	<?php
}
if ($_REQUEST["load_info"] == "compo") {
	?>
	$("progression_compo").innerHTML = "<?php if ($_REQUEST["fin"] > $nombre_articles) {echo $nombre_articles;} else {echo $ndebut;}?> informations d'articles importés sur <?php echo $_REQUEST["nombre_articles"]; ?>";
	<?php
}

if ($nfin != 0 && $load_info == "articles") {

	?>
	
	var AppelAjax = new Ajax.Updater(
									"maj_encours",
									"serveur_import_data_2_maj.php", 
									{
									parameters: {ref_serveur : "<?php echo $import_serveur->getRef_serveur_import();?>", load_info: "<?php echo $load_info;?>", debut : "<?php echo $ndebut;?>", fin: "<?php echo $nfin ?>", nombre_articles : "<?php echo $_REQUEST["nombre_articles"]; ?>" },
									evalScripts:true,
									insertion: Insertion.Bottom
									}
									);
	<?php
}
if ($nfin != 0 && $load_info == "compo") {

	?>
	
	var AppelAjax = new Ajax.Updater(
									"maj_encours",
									"serveur_import_data_2_maj.php", 
									{
									parameters: {ref_serveur : "<?php echo $import_serveur->getRef_serveur_import();?>", load_info: "<?php echo $load_info;?>", debut : "<?php echo $ndebut;?>", fin: "<?php echo $nfin ?>", nombre_articles : "<?php echo $_REQUEST["nombre_articles"]; ?>" },
									evalScripts:true,
									insertion: Insertion.Bottom
									}
									);
	<?php
}
?>		
									
//on masque le chargement
H_loading();
</script>
</div>