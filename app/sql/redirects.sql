CREATE table redirects 
(
    redirect_id serial PRIMARY KEY,
    url text NOT NULL, 
    redirect_to text NOT NULL,
    redirect_code smallint DEFAULT 301,
    UNIQUE (url, redirect_to)
);

INSERT INTO redirects (url, redirect_to)
    VALUES
        ('/login', '/login/index'),
        ('/index', '/')
;

SELECT * FROM redirects;