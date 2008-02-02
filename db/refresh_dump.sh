#!/bin/bash
tables=( jump_page staff_permission staff_group staff_group_staff_permission )

if [ "$1" = '' ]
then
    echo "o hi, pass the database password as an argument plx. thx.";
    exit 2;
fi

mysqldump -d -u root --password=$1 itorrent > mysql5_ddl.sql

for table in  ${tables[@]}
do
    mysqldump -t -c -u root --password=$1 itorrent $table > data/${table}.sql
done
