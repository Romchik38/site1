CREATE table recovery_email
(
    email PRIMARY KEY, 
    hash text NOT NULL,
    updated datetime default current_timestamp
);
