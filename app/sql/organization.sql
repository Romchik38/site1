CREATE table organization_entity
(
    organization_id serial PRIMARY KEY, 
    name text NOT NULL
);

CREATE table organization_entity_text
(
    organization_id int REFERENCES organization_entity ( organization_id ),
    field_name text PRIMARY KEY, 
    value text NOT NULL
);

INSERT INTO organization_entity VALUES (1, 'Site1');

INSERT INTO organization_entity_text 
    VALUES (1, 'email_contact_recovery', 'ser@ozone.com.ua');