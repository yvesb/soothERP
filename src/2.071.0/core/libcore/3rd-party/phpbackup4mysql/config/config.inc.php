<?php
/***
*
* PhpBackup4MySQL config file 
* Copyright (c) 2011-2014, Yves BOURVON. <groovyprog AT gmail DOT com>
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*
*     * Redistributions of source code must retain the above copyright
*       notice, this list of conditions and the following disclaimer.
*     * Redistributions in binary form must reproduce the above copyright
*       notice, this list of conditions and the following disclaimer in the
*       documentation and/or other materials provided with the distribution.
*     * Neither the names of Yves Bourvon, Groovyprog, phpBackup4MySQL nor the
*       names of its contributors may be used to endorse or promote products
*       derived from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
* DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
* FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
* DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
* SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
* CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
* OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
* OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
***/

/**
*
* phpBackup4MySQL V0.5 config file
*
* ############################################################################################################
* SoothERP specific variables $num_backup_files_kept_cron and $num_backup_files_kept_session added, see below
* ############################################################################################################
*
*/
 
 /**
* TIMEZONE Setting
* This may be used to set the TIMEZONE (required since Php 5.4), but you may leave this empty
* if your timezone is set up system wide or otherwise, in which case this parameter will have no
* effect
*/

define ( "TIMEZONE", "");

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

define ( "BACKUP_DIRECTORY" , $DIR . '/backup/');

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
 * Defines whether the num_backup_files_kept is an exact number of maximun backup files kept (option: TRUE) or some limit
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