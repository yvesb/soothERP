<?php
// *************************************************************************************************************
// CREATION OU RESTAURATION DE BACKUP
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['path']))
  $rc = restoreBackup($DIR, $_REQUEST['path']);
else
  $rc = false;
?>

<script type="text/javascript">
  <?php if ($rc) { ?>
  alerte.alerte_erreur ('Restauration du Backup', 'Restauration effectuée avec succès.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
  //page.verify('serveur_backup','serveur_backup.php','true','sub_content');
  <?php } else { ?>
  alerte.alerte_erreur ('Restauration du Backup', 'Erreur lors de la restauration.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
  <?php } ?>
</script>