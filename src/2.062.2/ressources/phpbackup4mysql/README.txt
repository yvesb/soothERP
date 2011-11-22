PLEASE NOTE FIRST THAT THIS CLASS IS STILL UNDER DEVELOPMENT STATUS, SO YOU 
SHOULD NOT USE IT "OUT OF THE BOX" FOR PRODUCTION UNLESS YOU HAVE DONE PROPER
TESTING. THIS RESPONSIBILITY SOLELY RELIES ON YOU.
FOR THAT MATTER, IT IS REMINDED HERE THAT THIS SOFTWARE IS PROVIDED "AS IS" 
WITHOUT WARRANTY OF ANY KIND (PLEASE REFER TO THE LICENSE FOR FULL CONDITIONS 
OF USE)

*******************************************************************************
*******************************************************************************

Requirements: Php Ver 5.3, PDO

*******************************************************************************
*******************************************************************************

V0.2

Added restore feature
Added count of backup hold in store (can be setup in config)
Some code cleaning and better code documentation (still to be improved though)




V0.1

"phpBackup4MySQL" is a php class meant to easily handle SQL backup using php.
This class holds a few functions that can be used for that purpose but the 
basics are as simple as the example that is supplied in the "TestBackup.php"
file, that is:
1/ Make a backup file.
2/ Save the SQL backup file.

Database connexion can be setup through the config.php file.

Different parameters can be accessed through the config file namely:
- Database connexion parameters.
- Directory path for the backup to be stored.
- "Max Query Size" to handle the limit of the SQL query that may occur when
importing back the backup, depending on the particular MySQL settings.
- "Ignore Foreign Keys" option to properly handle constraints whenever
relevant.
- "No Auto Value on Zero" option.
- Option to force table drop first before creating it (in case of database
replacement).

At this time no restore function is available yet (though it should be in a 
near future), so restoring the database should be done for now using phpMyAdmin
for instance.

*******************************************************************************
*******************************************************************************
TERMS OF LICENSE (BSD License):

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
