CREATE table pages 
(
    page_id serial PRIMARY KEY, 
    name text,
    url text UNIQUE,
    content text
);

INSERT INTO pages (name, url, content)
    VALUES
    ('Main Page of the site', 'index', '<p>Wellcome to our site. We are the best.</p>'),
    ('About Page', 'about', '<p>We sell smartphones for 20 years. Located in Ukraine.</p><p>Contacts: site@site1.com</p>')
;

SELECT * FROM pages;