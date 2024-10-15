CREATE table menu
(
    menu_id serial PRIMARY KEY, 
    name text NOT NULL UNIQUE
);

CREATE table menu_links
(
    -- link with id 0 is a default parent link and shouldn't be displayed
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
    parent_link_id int REFERENCES menu_links ( link_id ) ON DELETE CASCADE DEFAULT 0,
    priority int NOT NULL DEFAULT 0,
    CONSTRAINT pk_menu_to_links PRIMARY KEY ( menu_id, link_id, parent_link_id),
    CONSTRAINT valid_link CHECK ( link_id <> parent_link_id ),
    CONSTRAINT do_not_add_zero_link CHECK ( link_id <> 0 )
);

INSERT INTO menu (menu_id, name) VALUES (1, 'Main menu');

INSERT INTO menu_links (link_id, name, url, description) VALUES
    (0, 'Parent Link', '/parent', 'Parent link'),
    (1, 'Home', '/', 'Home Page'),
    (2, 'Login', '/login/index', 'Login Page'),
    (3, 'About', '/about', 'About Page'),
    (4, 'Recovery password', '/login/recovery', 'Login recovery password page'),
    (5, 'Login pages', '/login', 'All login pages ( login, recovery, etc)'),
    (6, 'Register new user', '/login/register', 'New users can be registered via this page'),
    (7, 'Change password', '/login/changepassword', 'Registered users can change compromised password on this page'),
    (8, 'Sitemap', '/sitemap', 'All pages are shown here. Visit it to see all in one')
;

INSERT INTO menu_to_links (menu_id, link_id, parent_link_id, priority) VALUES
    (1, 2, 5, 0),
    (1, 3, 0, 0),
    (1, 4, 5, 0),
    (1, 5, 0, 100),
    (1, 6, 5, 0),
    (1, 7, 5, 0)
;

SELECT * FROM menu_to_links 
    WHERE menu_id = 1
    ORDER BY parent_link_id ASC, priority DESC
;

---VIRTUAL
SELECT menu_to_links.*,
    menu_links.name,
    menu_links.url,
    menu_links.description
    FROM menu_links, menu_to_links
    WHERE 

        menu_to_links.menu_id = 1 AND
        menu_to_links.link_id = menu_links.link_id
;

