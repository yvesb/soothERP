# PhpBackup4MySQL

*PhpBackup4MySQL is a very easy to use, lightweight Php class to handle MySQL
backups.
This class may be really usefull when direct exec of SQL dump is not an option
(i.e. on most shared hosting).
Despite being simple to use, this class has advanced capabilities like foreign
key constraints handling.*


PLEASE NOTE FIRST THAT THIS CLASS IS STILL UNDER DEVELOPMENT STATUS, SO YOU 
SHOULD NOT USE IT "OUT OF THE BOX" FOR PRODUCTION UNLESS YOU HAVE DONE PROPER
TESTING. THIS RESPONSIBILITY SOLELY RELIES ON YOU.
FOR THAT MATTER, IT IS REMINDED HERE THAT THIS SOFTWARE IS PROVIDED "AS IS" 
WITHOUT WARRANTY OF ANY KIND (PLEASE REFER TO THE LICENSE FOR FULL CONDITIONS 
OF USE)


----
## Prerequisite 

- Php Ver 5.3
- PDO extension
- Php Curl extension for Amazon s3 upload


----
## Usage

"phpBackup4MySQL" is a php class meant to easily handle SQL backup using php.

Database connexion can be setup through the config.php file.

This class holds a few functions that can be used for that purpose but the 
basics are as simple as the example that is supplied in the "TestBackup.php"
file, that is:

1. Create an instance of PhpBackup4MySQL
2. Make a backup file with backupSQL() method
3. Save the SQL backup file with saveFile() method

Similarly, restoring a backup is as simple as the following (see example
code in "testRestore.php" file):

1. Create an instance of PhpBackup4MySQL
2. Connect to the databse with dbconnect() method
3. Restore the backup using the restoreSQL() method.

Some basic documentation can be found in the config and class comments. 


Different parameters can be accessed through the config file namely:

- Database connexion parameters.
- Directory path for the backup to be stored.
- Optional Amazon S3 credentials for upload of the backup to S3.
- "Max Query Size" to handle the limit of the SQL query that may occur when
importing back the backup, depending on the particular MySQL settings.
- "Ignore Foreign Keys" option to properly handle constraints whenever
relevant.
- "No Auto Value on Zero" option.
- Option to force table drop first before creating it (in case of database
replacement).

 
----
## Changelog

### V0.4

- Added backup file upload to Amazon S3 bucket capability. Simply add bucket
name and S3 credentials in the config file, this will upload the local backup
to the declared bucket.
 


### V0.3

- Added check regarding glob() function that can have unpredicted behaviour, 
depending on host config. (kind of Php bug)
- Added sub directories and prefixes option for save function
- Changed $num\_backup\_files_kept (from constant to variable and use of global)
since this was usefull for some use to have this parameter changeable.



### V0.2

- Added restore feature
- Added count of backup hold in store (can be setup in config)
- Some code cleaning and better code documentation (still to be improved though)



### V0.1

- Original working release




----
## TERMS OF PhpBackup4Mysql LICENSE (BSD License):

Copyright (c) 2011, Yves BOURVON. <groovyprog AT gmail DOT com>
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

   * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
   * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
   * Neither the names of Yves Bourvon, Groovyprog, phpBackup4MySQL nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE 
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL 
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR 
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER 
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE 
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.


**END OF TERMS OF PhpBackup4MySQL LICENSE**


----
## THIRD PARTY ATTRIBUTION

This software makes use of following third party library:

**AWS SDK for PHP**, Licensed under the Apache 2.0 license.

- [AWS SDK for PHP site] (http://aws.amazon.com/sdkforphp)
- [Documentation] (http://docs.amazonwebservices.com/AWSSDKforPHP/latest/)
- [License (Apache 2.0)] (http://aws.amazon.com/apache2.0/)