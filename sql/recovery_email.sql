CREATE table recovery_email
(
    email text PRIMARY KEY REFERENCES users ( email ) ON DELETE CASCADE, 
    hash text NOT NULL,
    updated_at timestamp default current_timestamp
);
