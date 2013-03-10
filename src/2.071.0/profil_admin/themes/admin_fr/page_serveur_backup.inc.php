<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_maintenance", "smenu_maintenance.php" ,"true" ,"sub_content", "Maintenance");
tableau_smenu[1] = Array('serveur_backup','serveur_backup.php','true','sub_content', "Gestion des sauvegardes");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des sauvegardes</p>
<div class="contactview_corps"><br />

<span style="color:#FF0000;"> <p style="margin:10px;">Système de sauvegarde testé avec succès mais toujours en version d'évaluation, merci de faire part de vos retours.<br />
</p>
</span>
<p style="margin:10px;">
Un backup automatique peut être lancé, en appelant le fichier "/taches_auto/cron_backup.php" depuis une tâche cron (avec les mêmes paramètres que ceux du fichier config. du gestionnaire de backup, sauf le nombre de backup(s) qui peut être spécifique et est à définir dans ce même fichier).
</p>
<p style="margin:10px;">
Un backup de session peut être lancé à l'ouverture d'une session Sooth ERP (configurable dans le fichier "config_serveur.inc.php"), pour récupération éventuelle de l'état précédent en cas de fausse manip.</ br>
Cette option augmente le temps d'ouverture de la session.
</p>
<p style="margin:10px;">
Les backups sont classés dans le dossier "backup", dans un sous-dossier du nom de la base (possibilité de plusieurs bases), avec pour chaque base jusqu'à trois sous-dossiers selon le type de backup ("cron_job" pour les backups automatiques, "user" pour les backups manuels et "session_start" pour les backups de session).
</p>
<br /> </span>


<span id="create_backup" style="cursor:pointer; margin:10px;" class="titre_config">Créer une sauvegarde</span>
<br />
<table style="margin: 10px;">
  <thead>
    <tr>
      <td>Version(s) de sauvegarde(s)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </thead>
  <tbody id="backup_available">
  <?php foreach ($liste_backup as $backup) { 
     $after = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "$3/$2/$1 $4:$5:$6", basename($backup)); ?>
      <tr>
        <td><?php echo $after; ?></td>
        <td id="<?php echo basename($backup); ?>" class="titre_config" style="cursor: pointer">Restaurer
        <script type="text/javascript">
          Event.observe('<?php echo basename($backup); ?>', 'click', function (evt) {
              restoreBackup('<?php echo $backup; ?>');
          },false);
        </script>
        </td>
        <td id="dl_<?php echo basename($backup); ?>" class="titre_config" style="cursor: pointer">Télécharger
        <script type="text/javascript">
          Event.observe('dl_<?php echo basename($backup); ?>', 'click', function (evt) {
              window.location.href="<?php echo "download_backup.php?file=".$backup; ?>";
          },false);
        </script>
        </td>
      </tr>
  <?php } ?>
  </tbody>
</table>

<div style="margin: 10px;display:none">
Uploader un backup :
<form action="serveur_backup_up.php" method="post" enctype="multipart/form-data" id="serveur_backup_up" name="serveur_backup_up" target="formFrame">
  <input type="hidden" name="MAX_FILE_SIZE", value="25395200000"/> 
  <input id="up_backup" type="file" name="up_backup" class="classinput_nsize" />
  <input id="upload" name="upload" type="submit" value="Uploader" />
</form>
<br /></div>
</div>

<SCRIPT type="text/javascript">
  Event.observe('create_backup', 'click', function (evt) {
    Element.hide('create_backup');
    createBackup();
    }, false);
  
//on masque le chargement
H_loading();
</SCRIPT>
</div>


<div class="emarge">
<!--
<p class="titre">Edition du fichier de configuration du gestionnaire de backup (phpBackup4MySQL)</p>
<div style="height:50px">
	<div class="contactview_corps">


			<?php 
				$dir = opendir(__DIR__.'/../../../ressources/phpbackup4mysql/config/');
				$idx = 0;
				while($fichier = readdir($dir)){
					if(is_dir(__DIR__.'/../../../ressources/phpbackup4mysql/config/'.$fichier) || $fichier == '.' || $fichier =='..'){ continue; }
					// Masque le fichier index destiné à protéger le répertoire du listing
					if ( basename($fichier) == "index.html"){ continue; }
					++$idx;
					
					$config_file = file(__DIR__.'/../../../ressources/phpbackup4mysql/config/'.$fichier);
										
					$text_config_file = '';
					foreach ($config_file as $config_line) {
						$text_config_file .= $config_line;
					}
					
					?>
					<form onSubmit="return confirm('Voulez-vous vraiment modifier ce fichier de configuration?')" action="config_files_mod_pb4ms.php" method="post" id="" name="" target="formFrame" >
						<input type="hidden" id="nom_fichier" name="nom_fichier" value=<?php echo $fichier; ?> />
						
						<table style="width:100%;">
						<tr>
							<td class="titre_config" id="titre_<?php echo $idx;?>" colspan="4"><?php echo $fichier;?></td>
						</tr><tr id="line_txt_file_<?php echo $idx;?>" style="display:none">
							<td><textarea  id="new_text_file" name="new_text_file" class="classinput_xsize" rows="20"><?php echo $text_config_file;?></textarea></td>
						</tr><tr id="line_input_file_<?php echo $idx;?>" style="display:none">
							<td style="text-align: right; padding-right:10px;">
							<input name="valider_<?php echo $idx;?>" id="valider_<?php echo $idx;?>" src="<?php echo $DIR;?>profil_admin/themes/admin_fr/images/bt-valider.gif" type="image">
							</td>
						<tr>
						</table>
					</form>
					<?php 
				}
				closedir($dir);
			?>
		
	</div>
</div>
-->
<script type="text/javascript">

idx_open = 1;
</SCRIPT>

<?php 
for($i=1; $i<=$idx; ++$i){
	?>
	<script type="text/javascript">

	//Script permettant l'affichage ou le masquage des fichiers
	Event.observe("titre_<?php echo $i; ?>", "click",  function(evt){
		Event.stop(evt);

		//masquage de l'ancien fichier selectionné
		$("line_txt_file_"+idx_open).hide();
		$("line_input_file_"+idx_open).hide();

		//affichage du fichier selectionné
		idx_open = <?php echo $i; ?>;
		$("line_txt_file_<?php echo $i; ?>").show();
		$("line_input_file_<?php echo $i; ?>").show();
		
	}, false);
	</SCRIPT>
	<?php 
}   ?>
<script type="text/javascript">
//Script permettant l'affichage ou le masquage des fichiers
//on masque le chargement
H_loading();
</SCRIPT>
</div>
