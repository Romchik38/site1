create role "service" LOGIN;

GRANT connect on database site1 to "service";

GRANT select on table pages to "service";