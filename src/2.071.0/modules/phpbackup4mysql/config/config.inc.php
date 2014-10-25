<?php

/***
*
* PhpBackup4MySQL config file 
*
* ############################################################################################################
* SoothERP specific variables $num_backup_files_kept_cron and $num_backup_files_kept_session added, see below
* ############################################################################################################
*
***/

/**
* Database connexion parameters
*/
define ('USER', $bdd_user);
define ('PASS', $bdd_pass);
define ('HOST', $bdd_hote);
define ('DBNAME', $bdd_base);

/**
 * Set the directory in which backups will be stored
 * Defaults to ./Backup/
 */

define ( "BACKUP_DIRECTORY" , __DIR__.'/../../../backup/');

/**
 * SQL Query size limit (i.e. size above which the query is spiltted into several queries)
 * Lower this value in case you get "Mysql Error 1153: Got a packet bigger than 'max_allowed_packet' bytes" when importing back the backup
 */
define ( "MAX_QUERY_SIZE" , 100000 );

/**
 * IGNORE_FOREIGN_KEYS
 * If this set to True, Foreign keys will be ignored during the export and constraints will be exported after the create table queries to alter the tables accordingly
 * SET FOREIGN_KEY_CHECKS will bet set again to 1 at the end of the export.
 */
define ( "IGNORE_FOREIGN_KEYS", TRUE);

/**
 * DROP_TABLE
 * If this set to True,  the existing tables in the database will be dropped first at time of backup restore
 */
define ( "DROP_TABLE", TRUE);

/**
 * NO_AUTO_VALUE_ON_ZERO
 * If this set to True,  the following will be applied SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"
 */
define ( "NO_AUTO_VALUE", TRUE);

/**
 * $num_backup_files_kept
 * This defines how many backup will be kept in the backup directory. If the number of backups exceeds this value, the backup file with the
 * lowest index will be erased (that is, the oldest one erase unless you've renmamed them) and the new backup file added in replacement.
 * To set no limit in the number of backup kept, set value to 0.
 *
 * ##############################################################################################################
 * Separated values added for SoothERP usage regarding cron backups and session start backups
 * ##############################################################################################################
 */
$num_backup_files_kept = 5; // Number of manual bakup held in "history"
$num_backup_files_kept_cron = 7; // Typically one backup a day over a week for cron job
$num_backup_files_kept_session = 2; // Two sessions strats backups seems a good safe starting point

/**
 * STRICT_NUM_BACKUP_FILES
 * Defines whether the num_backup_files_kept is an exact number of maximun backup files kept (option: TRUE) or an limit
 * under which it won't go. Say num_backup_files_kept is set 5 but you end up with 7 files in the backup directory (because manually tweaked for instance)
 * option TRUE will erased lowest indexed backup up untill the total count of 5, whereas option FALSE will keep the count to 7
 */
define ( "STRICT_NUM_BACKUP_FILES", TRUE);

/**
* Below are S3 settings for uploading backup to S3
* If below parameters are set and are valid S3 credentials, MySQL backup will be uploaded to corresponding bucket
*
* AMAZON_WEB_SERVICES_KEY
* Amazon Web Services Key. Found in the AWS Security Credentials.
*/

define ( "AMAZON_WEB_SERVICES_KEY", "");

/**
* AMAZON_WEB_SERVICES_SECRET_KEY
* Amazon Web Services Secret Key. Found in the AWS Security Credentials.
*/

define ( "AMAZON_WEB_SERVICES_SECRET_KEY", "");

/**
* AMAZON_S3_BUCKET
* Amazon s3 bucket name
*/

define ( "AMAZON_S3_BUCKET", "");


?>