CREATE table users 
(
    user_id serial PRIMARY KEY, 
    user_name text UNIQUE NOT NULL,
    first_name text NOT NULL,
    last_name text NOT NULL,
    password text NOT NULL,
    active boolean DEFAULT FALSE,
    email text NOT NULL
);

INSERT INTO users (user_name, first_name, last_name, password, active, email)
    VALUES
    ('ser', 'Serhii', 'Romanenko', '$2y$10$FpQOZIj2P7uyxejlqbc5jeC4YBSJo3U5Ue70amobO4gLOECs0TxQa', TRUE, 'ser@localhost')
;

SELECT * FROM users;