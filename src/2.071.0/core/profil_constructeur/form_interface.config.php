<?php
//  **********************************************
// FORMULAIRE DE CONFIG - INTERFACE CONSTRUCTEUR
//  **********************************************

$_INTERFACE['MUST_BE_LOGIN'] = 1;
require("_dir.inc.php");
require ("_profil.inc.php");
//require ("_session.inc.php");

$string_config_file = file_get_contents($CORE_DIR."profil_constructeur/_interface.config.php");
require($CORE_DIR."profil_constructeur/_interface.config.php");
$matches = array();

// AFFICHAGE
?>

<br />

<form id="configure_interface" name="configure_interface" enctype="multipart/form-data" action="<?php echo $CORE_DIR; ?>profil_constructeur/site_interfaces_config.generate.php" method="POST" target="formFrame">
	<div id="confint">
  <input id="file_path" name="file_path" type="hidden" value="profil_constructeur/_interface.config.php" /> 
  <table width="100%">
    <tr class="smallheight">
      <td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
      <td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
      <td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
    </tr>          
    <tr><td><p>Pas de configuration encore disponible.</p></td></tr>
	<tr>
      <td>
        <input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/bt-valider.gif" />
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
  </table>
  </div>
</form>
