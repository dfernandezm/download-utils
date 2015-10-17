#!/bin/sh

DBHOST=$1
DBNAME=$2
DBUSER=$3
DBPASSWORD=$4
BACKUP_PATH=$5

mysql -u $DBUSER --password=$DBPASSWORD -e "USE $DBNAME"
EXIT_CODE=$?

if [ "$EXIT_CODE" -ne 0 ]; then
 echo "Database $DBNAME does not exist, creating db $DBNAME..."
 mysql -u $DBUSER --password=$DBPASSWORD -e "DROP DATABASE IF EXISTS $DBNAME"
 mysql -u $DBUSER --password=$DBPASSWORD -e "CREATE DATABASE $DBNAME"
 mysql -h $DBHOST -u $DBUSER --password=$DBPASSWORD -e "GRANT ALL ON *.* TO '$DBUSER'@'%'"
 mysql -h $DBHOST -u $DBUSER --password=$DBPASSWORD -e "UPDATE mysql.user SET Grant_priv='Y', Super_priv='Y' WHERE User='$DBUSER'"
 mysql -h $DBHOST -u $DBUSER --password=$DBPASSWORD -e "FLUSH PRIVILEGES"
else

 if [ -n "$BACKUP_PATH" ]; then
   echo "Database $DBNAME exists, creating backup..."
   mkdir -p $BACKUP_PATH
   BACKUP_FILE="$BACKUP_PATH/db_backup.sql"
   mysqldump -h$DBHOST -u$DBUSER -p$DBPASSWORD $DBNAME > $BACKUP_FILE
   echo "Database $DBNAME backed up in $BACKUP_FILE"
 else
   echo "Database $DBNAME exists, but backup path not provided, skipping..."
 fi

fi
