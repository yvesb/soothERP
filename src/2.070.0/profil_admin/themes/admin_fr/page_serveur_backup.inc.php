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

<span style="color:#FF0000"> Attention système de sauvegarde en version béta (test) (réservé au systèmes hébergés). Pour les installations sous windows utilisez le systeme de back-up intégré à l'installeur de LMB)
</span><br />


<span id="create_backup" style="cursor:pointer; margin:10px;" class="titre_config">Créer une sauvegarde</span>
<br />
<table style="margin: 10px;">
  <thead>
    <tr>
      <td>Date de la sauvegarde</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </thead>
  <tbody id="backup_available">
  <?php foreach ($liste_backup as $backup) { 
     $after = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "$3/$2/$1 $4:$5:$6", basename($backup, ".tgz")); ?>
      <tr>
        <td><?php echo $after; ?></td>
        <td id="<?php echo basename($backup, ".tgz"); ?>" class="titre_config" style="cursor: pointer">Restaurer
        <script type="text/javascript">
          Event.observe('<?php echo basename($backup, ".tgz"); ?>', 'click', function (evt) {
              restoreBackup('<?php echo $backup; ?>');
          },false);
        </script>
        </td>
        <td id="dl_<?php echo basename($backup, ".tgz"); ?>" class="titre_config" style="cursor: pointer">Télécharger
        <script type="text/javascript">
          Event.observe('dl_<?php echo basename($backup, ".tgz"); ?>', 'click', function (evt) {
              window.location.href="<?php echo $backup; ?>";
          },false);
        </script>
        </td>
      </tr>
  <?php } ?>
  </tbody>
</table>

<div style="margin: 10px;display:none">
Uploader une backup : 
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
