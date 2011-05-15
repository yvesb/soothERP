<?php
// *************************************************************************************************************
// CREATION OU RESTAURATION DE BACKUP
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$rc = createBackup();

?>

<script type="text/javascript">
  alerte.alerte_erreur ('Création de Backup', '<?php echo $rc; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
  page.verify('serveur_backup','serveur_backup.php','true','sub_content');
</script>