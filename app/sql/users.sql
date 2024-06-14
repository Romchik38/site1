CREATE table users 
(
    user_id serial PRIMARY KEY, 
    login text UNIQUE NOT NULL,
    first_name text NOT NULL,
    last_name text NOT NULL,
    pass text NOT NULL,
    active boolean DEFAULT FALSE
);

INSERT INTO users (login, first_name, last_name, pass, active)
    VALUES
    ('ser', 'Serhii', 'Romanenko', 'qwerty', TRUE)
;

SELECT * FROM users;