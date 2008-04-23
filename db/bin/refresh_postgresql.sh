#!/bin/bash
tables=( jump_page staff_permission staff_group staff_group_staff_permission ) 

if [ "$1" = '' ]
then
    echo "o hi, pass the database password as an argument plx. thx.";
    exit 2;
fi

export PGPASSWORD=$1
pg_dump -s -U itorrent -h localhost itorrent > postgres_ddl.sql

for table in  ${tables[@]}
do
    pg_dump -a -U itorrent -h localhost --table=$table itorrent > pgsql_data/${table}.sql
done
