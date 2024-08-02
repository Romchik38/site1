CREATE table menu
(
    menu_id serial PRIMARY KEY, 
    name text NOT NULL UNIQUE
);

CREATE table menu_links
(
    -- link with id 0 is a default parrent lonk and shouldn't be displayed
    -- so 0 can't be in menu_to_links.link_id
    link_id serial PRIMARY KEY,
    name text NOT NULL UNIQUE, 
    url text NOT NULL UNIQUE, 
    description text NOT NULL
);

CREATE table menu_to_links
(
    -- before insert any values into the table, add default link with id 0
    -- in the menu_links table
    menu_id int REFERENCES menu ( menu_id ) ON DELETE CASCADE,
    link_id int REFERENCES menu_links ( link_id ) ON DELETE CASCADE,
    parrent_link_id int REFERENCES menu_links ( link_id ) ON DELETE CASCADE DEFAULT 0,
    order_by int NOT NULL DEFAULT 0,
    CONSTRAINT pk_menu_to_links PRIMARY KEY ( menu_id, link_id, parrent_link_id),
    CONSTRAINT valid_link CHECK ( link_id <> parrent_link_id ),
    CONSTRAINT do_not_add_zerro_link CHECK ( link_id <> 0 )
);

INSERT INTO menu (menu_id, name) VALUES (1, 'Main menu');

INSERT INTO menu_links (link_id, name, url, description) VALUES
    (0, 'Parrent Link', '/parrent', 'Parrent link'),
    (1, 'Home', '/', 'Home Page'),
    (2, 'Login', '/login/index', 'Login Page'),
    (3, 'About', '/about', 'About Page'),
    (4, 'Recovery password', '/login/recovery', 'Login recovery password page'),
    (5, 'Login pages', '/login/all', 'All login pages ( login, recovery, etc)')
;

INSERT INTO menu_to_links (menu_id, link_id, parrent_link_id) VALUES
    (1, 1, 0),
    (1, 2, 5),
    (1, 3, 0),
    (1, 4, 5),
    (1, 5, 0)
;

