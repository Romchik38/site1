CREATE table redirects 
(
    redirect_id serial PRIMARY KEY,
    redirect_from text NOT NULL, 
    redirect_to text NOT NULL,
    redirect_code smallint DEFAULT 301,
    redirect_method text DEFAULT 'GET',
    UNIQUE (redirect_from, redirect_to, redirect_method),
    CONSTRAINT method_list CHECK ( redirect_method in ('GET', 'POST') )
);

INSERT INTO redirects (redirect_from, redirect_to)
    VALUES
        ('/index', '/')
;

SELECT * FROM redirects;