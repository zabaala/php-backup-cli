# php-backup-cli
Make backups of your mysql database, saving them in Dropbox

# Commands

 - ./backup show - List all backups
 - ./backup make - make a new backup
 - ./backup delete --path='' - delete a specified backup path
 - ./backup db:config - configure the database that will be backed up
 - ./backup dropbox:config: Create a Dropbox configuration file
 - ./backup dropbox:generate-toke: After configuration file creation, generate Dropbox access-token
 
# License 
MIT.
