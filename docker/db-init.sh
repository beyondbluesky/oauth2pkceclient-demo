#!/bin/sh
echo "Initializing SQL Database..."
mysql -h db -ptest -u admin dcatcher < /docker-entrypoint-initdb.d/init.sql 
