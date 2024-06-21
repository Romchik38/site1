CREATE table users 
(
    user_id serial PRIMARY KEY, 
    user_name text UNIQUE NOT NULL,
    first_name text NOT NULL,
    last_name text NOT NULL,
    password text NOT NULL,
    active boolean DEFAULT FALSE
);

INSERT INTO users (user_name, first_name, last_name, password, active)
    VALUES
    ('ser', 'Serhii', 'Romanenko', '123', TRUE)
;

SELECT * FROM users;