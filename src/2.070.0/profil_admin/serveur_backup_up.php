<?php
// *************************************************************************************************************
// UPLOAD DE BACKUP
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//set_time_limit(0);
ini_set('memory_limit', '300M');
ini_set('upload_max_filesize', '200M');
ini_set('post_max_size', '250M');
ini_set('max_input_time', '2000');
ini_set('max_execution_time', '2000');

$rc = "Upload effectué avec succes.";
if (!is_uploaded_file($_FILES['up_backup']['tmp_name']))
  $rc = "Fichier introuvable.";
else {
  $folder = $DIR."backup/";
  if (strcmp(pathinfo($_FILES['up_backup']['name'], PATHINFO_EXTENSION), "tgz") != 0)
   $rc = "Type de fichier incompatible.";
  else {
    if ($_FILES['up_backup']['error'] == UPLOAD_ERR_OK) {
      if (!move_uploaded_file($_FILES['up_backup']['tmp_name'], $folder.$_FILES['up_backup']['name']))
        $rc = "Echec de l'upload !";
    }
  }
  
}
  
?>

<script type="text/javascript">
  window.parent.alerte.alerte_erreur ('Upload de Backup', '<?php echo $rc; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
  window.parent.page.verify('serveur_backup','serveur_backup.php','true','sub_content');
</script>