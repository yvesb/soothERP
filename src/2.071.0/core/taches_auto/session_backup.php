<?php

require_once ($CONFIG_DIR.'config_bdd.inc.php');
require_once ($LIB_DIR_EXT.'phpbackup4mysql/phpBackup4MySQL.class.php');
require_once ($LIB_DIR_EXT.'phpbackup4mysql/config/config.inc.php');

$num_backup_files_kept = $num_backup_files_kept_session;

$pb4ms = new phpBackup4MySQL();

$dbh = $pb4ms->dbconnect($bdd_base,$bdd_user,$bdd_pass,$bdd_hote);

$sql_dump = $pb4ms->backupSQL($dbh);

if(!$pb4ms->saveFile($sql_dump, "session", "session_start")){
	// False, pour gestion erreur future
	return false;
	} else {
	// True pour éventuelle utilisation
	return true;
	}

?>	