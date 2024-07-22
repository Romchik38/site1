CREATE table recovery_email
(
    email text PRIMARY KEY REFERENCES users ( email ) ON DELETE CASCADE, 
    hash text NOT NULL,
    updated_at timestamp default current_timestamp
);

INSERT INTO recovery_email (email, hash) VALUES ('pomahehko.c@gmail.com', 'sadasd');

UPDATE recovery_email 
    SET hash = 'aaaaa' , updated_at = current_timestamp 
        WHERE email = 'pomahehko.c@gmail.com'
;