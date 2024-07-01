CREATE table entity
(
    entity_id serial PRIMARY KEY, 
    name text NOT NULL UNIQUE
);

CREATE table entity_text
(
    field_name text PRIMARY KEY, 
    entity_id int REFERENCES entity ( entity_id ),
    value text NOT NULL
);

CREATE table entity_int
(
    field_name text PRIMARY KEY, 
    entity_id int REFERENCES entity ( entity_id ),
    value int NOT NULL
);

--INFORMATION 
INSERT INTO entity VALUES (1, 'Company Site1');

INSERT INTO entity_text 
    VALUES 
        ('email_contact_recovery', 1, 'ser@ozone.com.ua'),
        ('email_contact_main', 1, 'office@ozone.com.ua')
;

INSERT INTO entity_int 
    VALUES ('min_order_sum', 1, 100);
