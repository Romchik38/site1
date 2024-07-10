CREATE table entities
(
    entity_id serial PRIMARY KEY, 
    name text NOT NULL UNIQUE
);

CREATE table entity_field
(
    field_id serial PRIMARY KEY,
    field_name text NOT NULL, 
    entity_id int REFERENCES entities ( entity_id ) ON DELETE CASCADE,
    value text NOT NULL,
    type text CHECK ( type IN ('int', 'float', 'string') ),
    CONSTRAINT unique_entity_field UNIQUE ( field_name, entity_id )
);

--INFORMATION 
INSERT INTO entities VALUES (1, 'Company Site1');
INSERT INTO entities VALUES (2, 'Html');

INSERT INTO entity_field (field_name, entity_id, value, type)
    VALUES 
        ('email_contact_recovery', 1, 'ser@ozone.com.ua', 'string'),
        ('email_contact_main', 1, 'office@ozone.com.ua', 'string'),
        ('min_order_sum', 1, '100', 'int'),
        ('default_phone_number', 1, '0-800-500-00-00', 'string');
;

INSERT INTO entity_field (field_name, entity_id, value, type)
    VALUES 
        ('default_company', 2, '1', 'int'),
        ('default_layout', 2, 'column1', 'string')
;

--for listByFields
SELECT entities.* FROM entities 
    WHERE entity_id IN 
        (SELECT DISTINCT entity_field.entity_id 
            FROM entity_field 
            WHERE field_name 
                LIKE '%defa%')
;