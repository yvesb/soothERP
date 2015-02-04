<?php
//  ******************************************************
// EXPORT des lignes en erreurs
//  ******************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$size = 0;
if (file_exists("retour_import.csv"))
	$size = filesize("retour_import.csv");
	
if ($size > 0)
	{
		?> <script type="text/javascript">
		page.verify('retour_import','<?php echo $$PROFILE_DIR.$PLUGINS_REP; ?>_module_import_annuaire_csv/retour_import.csv','true','_blank');
		</script><?php
	}	
//  ******************************************************
// AFFICHAGE
//  ******************************************************

?>
