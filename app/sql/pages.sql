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

-- HELPER
SELECT * FROM pages;

UPDATE pages SET content = '<p class="lead">Wellcome to our site. We are the best.</p><p>We offer next templates for your site:</p><ul class="list-unstyled"><li><a href="/media/base.html">Base template</a></li></ul>'
    WHERE page_id = 1
;