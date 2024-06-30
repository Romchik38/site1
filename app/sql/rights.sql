create role "service" LOGIN;

GRANT connect on database site1 to "service";

GRANT select on table pages to "service";
GRANT insert on table pages to "service";

GRANT USAGE, SELECT ON SEQUENCE users_user_id_seq TO "php-fpm";
