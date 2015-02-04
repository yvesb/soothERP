<?php

//  ******************************************************
// CONTROLE DU THEME
//  ******************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

// ***********
// Variables communes d'affichage
// ***********

// AFFICHAGE
?>
<script type="text/javascript">
var PLUGINS_REP = '<?php echo $PROFILE_DIR.$PLUGINS_REP; ?>' ;
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('<?php echo $import_catalogue_csv['menu_admin'][1][0];?>','<?php echo $import_catalogue_csv['menu_admin'][1][1];?>','<?php echo $import_catalogue_csv['menu_admin'][1][2];?>','<?php echo $import_catalogue_csv['menu_admin'][1][3];?>', "<?php echo $import_catalogue_csv['menu_admin'][1][4];?>");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Import de fiches d'articles - FORMAT CSV</p>
<div>

<?php
if ($import_catalogue->getEtape() == "2") {
	?>
	Un précédent import non terminé a été détecté.<br />
	Souhaitez vous reprendre l'import des données concernées?  <span id="reprendre_import" style="cursor:pointer; font-weight:bolder"> Reprendre l'import</span>
	<script type="text/javascript">
	Event.observe('reprendre_import', "click", function(evt){
		page.verify('<?php echo $import_catalogue_csv['menu_admin'][1][0];?>','<?php echo $PROFILE_DIR.$PLUGINS_REP .$import_catalogue_csv['folder_name'];?>import_catalogue_csv_step2.php','true','sub_content');  
		Event.stop(evt);
	});
	</script><br /><br />


	<?php 
}
?>
<form action="<?php echo $PROFILE_DIR.$PLUGINS_REP; ?>_module_import_catalogue_csv/import_catalogue_csv_done.php" enctype="multipart/form-data" method="POST" id="import_catalogue_csv_done" name="import_catalogue_csv_done" target="formFrame" class="classinput_nsize" />

<table class="contactview_corps" style="width:100%">
	<tr>
		<td>
		<span style="width:280px; text-align: left; float:left">Indiquez l'emplacement de votre fichier:</span> 
		<input type="file" size="35" name="fichier_csv" class="classinput_nsize" />	
		</td>
		<td>
		</td>
		<td>
		<input type="submit" name="Submit" value="Valider" />
		</td>
	</tr>
</table>
<br />

		<span style="width:380px; text-align: right; float:left">&nbsp;</span> 
		<br />
		<br />
		<span style="font-weight:bolder">L'utilisation de ce module demande des connaissances techniques sur l'utilisation d'un tableur.</span><br />
		
		<br />


	Le fichier dois être au format CSV. (texte séparé par ;)<br />
	Les informations de la première ligne doivent correspondre aux différentes informations des articles (libellé, catégorie ect.) sans symbole particulier.<br />
	Idéalement il est recommandé de supprimer les colonnes inutiles.<br />
	
	Si votre fichier comporte une ou plusieurs colonnes avec les noms d'images (et leur extension) pour chaque article, placer ces images via votre accès ftp dans le dossier du plugins "<?php echo $import_catalogue_csv['import_images_folder'] ;?>".


		<br />
		<br />
		
		<p>Vous pouvez télécharger <a id="download_exemple" title="" target="_blank" href="<?php echo $PROFILE_DIR.$RESSOURCES_REP."echange/exemple_import_articles.csv"?>">ici</a> un exemple de fichier CSV</p><br /><br />

<br />
</form>
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
</div>