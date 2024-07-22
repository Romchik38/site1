create role "service" LOGIN;

GRANT connect on database site1 to "service";

GRANT select on table pages to "service";
GRANT insert on table pages to "service";

--
GRANT select on table entities to "php-fpm";
GRANT select on table entity_field to "php-fpm";

GRANT insert on table users to "php-fpm";
GRANT USAGE, SELECT ON SEQUENCE users_user_id_seq TO "php-fpm";

GRANT select, insert, update on table recovery_email to "php-fpm";
