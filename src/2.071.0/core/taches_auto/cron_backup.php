<?php

require_once ($CONFIG_DIR.'config_bdd.inc.php');
require_once ($LIB_DIR.'phpbackup4mysql/phpBackup4MySQL.class.php');
require_once ($LIB_DIR.'phpbackup4mysql/config/config.inc.php');

$num_backup_files_kept = $num_backup_files_kept_cron;

$pb4ms = new phpBackup4MySQL();

$dbh = $pb4ms->dbconnect($bdd_base,$bdd_user,$bdd_pass,$bdd_hote);

$sql_dump = $pb4ms->backupSQL($dbh);

if(!$pb4ms->saveFile($sql_dump, "auto", "cron_job")){
	// False, pour gestion erreur future
	return false;
	} else {
	// True pour éventuelle utilisation
	return true;
	}

?>	