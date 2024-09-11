CREATE table recaptcha
(
    action text PRIMARY KEY, 
    active boolean NOT NULL DEFAULT false
);

CREATE table recaptcha_google
(
    action text REFERENCES recaptcha ( action ) ON DELETE CASCADE,
    score float NOT NULL DEFAULT 0.5,
    CONSTRAINT check_score CHECK ( score >= 0 AND score <= 1.0 )
);

INSERT INTO recaptcha (action, active) VALUES
    ('login_recovery_emeil_submit', true)
;

INSERT INTO recaptcha_google (action, score) VALUES
    ('login_recovery_emeil_submit', 0.5)
;
