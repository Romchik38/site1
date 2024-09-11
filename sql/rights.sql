create role "service" LOGIN;

GRANT connect on database site1 to "service";

GRANT select on table pages to "service";
GRANT insert on table pages to "service";

GRANT select on table redirects to "service";
--
GRANT select on table entities to "service";
GRANT select on table entity_field to "service";


GRANT select, insert, update on table users to "service";
GRANT USAGE, SELECT ON SEQUENCE users_user_id_seq TO "service";

GRANT select, insert, update on table recovery_email to "service";

GRANT select, insert, update, delete on table menu, menu_links, menu_to_links to "service";

GRANT select, insert, update on table recaptcha, recaptcha_google to "service";
