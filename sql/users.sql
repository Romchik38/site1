CREATE table users 
(
    user_id serial PRIMARY KEY, 
    user_name text UNIQUE NOT NULL,
    first_name text NOT NULL,
    last_name text NOT NULL,
    password text NOT NULL,
    active boolean DEFAULT FALSE,
    email text UNIQUE NOT NULL 
);

--PLEASE add your first user by yourself
--  visit /login/register page

SELECT * FROM users;