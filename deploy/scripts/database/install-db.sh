#!/bin/sh

DBHOST=$1
DBNAME=$2
DBUSER=$3
DBPASSWORD=$4

mysql -u $DBUSER --password=$DBPASSWORD -e "USE $DBNAME"
EXIT_CODE=$?

if [ "$EXIT_CODE" -ne 0 ]; then
 echo "Creating db $DBNAME..."
 mysql -u $DBUSER --password=$DBPASSWORD -e "DROP DATABASE IF EXISTS $DBNAME"
 mysql -u $DBUSER --password=$DBPASSWORD -e "CREATE DATABASE $DBNAME"
 mysql -h $DBHOST -u $DBUSER --password=$DBPASSWORD -e "GRANT ALL ON *.* TO '$DBUSER'@'%'"
 mysql -h $DBHOST -u $DBUSER --password=$DBPASSWORD -e "UPDATE mysql.user SET Grant_priv='Y', Super_priv='Y' WHERE User='$DBUSER'"
 mysql -h $DBHOST -u $DBUSER --password=$DBPASSWORD -e "FLUSH PRIVILEGES"

fi
