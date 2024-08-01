menu
menu_id  name

CREATE table menu
(
    menu_id serial PRIMARY KEY, 
    name text NOT NULL UNIQUE
);

CREATE table menu_links
(
    link_id serial PRIMARY KEY,
    name text NOT NULL UNIQUE, 
    url text NOT NULL UNIQUE, 
    description text NOT NULL, 
    menu_id int REFERENCES menu ( menu_id ) ON DELETE CASCADE,
);

CREATE table menu_to_links
(
    menu_id int REFERENCES menu ( menu_id ) ON DELETE CASCADE,
    link_id int REFERENCES menu_links ( link_id ) ON DELETE CASCADE,
    CONSTRAINT pk_menu_to_links PRIMARY KEY ( menu_id, link_id )
);


