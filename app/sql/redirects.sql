CREATE table redirects 
(
    url text NOT NULL, 
    redirect_to text NOT NULL,
    redirect_code smallint DEFAULT 301,
    PRIMARY KEY (url, redirect_to)
);

INSERT INTO redirects VALUES
    ('/login', '/login/index')
;

SELECT * FROM redirects;