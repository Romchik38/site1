CREATE table entities
(
    entity_id serial PRIMARY KEY, 
    name text NOT NULL UNIQUE
);

CREATE table entity_text
(
    field_name text PRIMARY KEY, 
    entity_id int REFERENCES entities ( entity_id ),
    value text NOT NULL,
    type text CHECK ( type IN ('int', 'float', 'string') )
);

--INFORMATION 
INSERT INTO entities VALUES (1, 'Company Site1');

INSERT INTO entity_text 
    VALUES 
        ('email_contact_recovery', 1, 'ser@ozone.com.ua', 'string'),
        ('email_contact_main', 1, 'office@ozone.com.ua', 'string'),
        ('min_order_sum', 1, '100', 'int');
;
