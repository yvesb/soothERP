<?php
//  **********************************************
// FORMULAIRE DE CONFIG - INTERFACE COLLAB
//  **********************************************

$_INTERFACE['MUST_BE_LOGIN'] = 1;
require("_dir.inc.php");
require ("_profil.inc.php");
//require ("_session.inc.php");

$string_config_file = file_get_contents($CORE_DIR."profil_collab/_interface.config.php");
$string_config_file2 = file_get_contents($CONFIG_DIR."profil_collab.config.php");
require($CORE_DIR."profil_collab/_interface.config.php");
require($CONFIG_DIR."profil_collab.config.php");
$matches = array();

// AFFICHAGE
?>

<br />

<form id="configure_interface" name="configure_interface" enctype="multipart/form-data" action="<?php echo $CORE_DIR; ?>profil_collab/site_interfaces_config.generate.php" method="POST" target="formFrame">
	<div id="confint">
  <input id="file_path" name="file_path" type="hidden" value="_interface.config.php" />
  <input id="file_path2" name="file_path2" type="hidden" value="<?php echo $CONFIG_DIR."profil_collab.config.php";?>" /> 
  <table width="100%">
    <tr class="smallheight">
      <td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
      <td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
      <td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
    </tr>          
    <tr>
      <td class="taches_showed">
		  Nombre de taches affichées :
      </td>
      <td>
		<input id="nb_taches_showed" name="nb_taches_showed" type="text" class="classinput_xsize" value="<?php preg_match("/.*?NB_TACHES_SHOWED = \"(.*?)\";.*?/", $string_config_file2, $matches); if(count($matches)>0) {echo stripslashes($matches[1]);} ?>"/>
      </td>
      <td class="infos_config">(Par default à 10)</td>
    </tr>
		<tr>
      <td class="taches_showed">
        Nombre de taches affichées sur l'accueil: 
      </td>
      <td>
        <input id="nb_taches_showed_acc" name="nb_taches_showed_acc" type="text" class="classinput_xsize" value="<?php preg_match("/.*?NB_TACHES_SHOWED_ACCUEIL = \"(.*?)\";.*?/", $string_config_file2, $matches); if(count($matches)>0) {echo stripslashes($matches[1]);} ?>"/>
      </td>
      <td class="infos_config">(Par default à 5)</td>
    </tr>
	<tr>
      <td>
        <input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/bt-valider.gif" />
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
  </table>
  </div>
</form>
