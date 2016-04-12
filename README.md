# php-backup-cli
Make backups of your mysql database, saving them in Dropbox

# Requirements
 - Mysql server;
 - PHP (PHP >= 5.6; Php-Cli; Php-Oauth; Php-Mcrypt);
 - Dropbox account; and
 - Internet connection. =)

# How to use

Download this repository and etract files into preferred folder. Access folder via terminal, then execute any command listed below.

# Commands

 * ./backup show - List all backups
 * ./backup make - make a new backup
 * ./backup delete --path='' - delete a specified backup path
 * ./backup db:config - configure the database that will be backed up
 * ./backup dropbox:config - Create a Dropbox configuration file
 * ./backup dropbox:generate-token - After configuration file creation, generate Dropbox access-token

# Help

Open a issue or contact me: mauricio.vsr@gmail.com
 
# License 
MIT.
