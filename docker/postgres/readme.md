# Postgres readme

## Create a database first time

1. Connect to server inside a container

    `psql -U postgres`

2. run all sql commands from project's [sql directory](./../../../sql/)

## Import a database

1. Put a database export file into *docker/postgres/home* dir

2. Inside a container lanch commands:

    `psql -U postgres < /home/postgres/database_file.sql`
