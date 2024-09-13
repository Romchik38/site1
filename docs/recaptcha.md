# Recaptcha

- login controller ( unload )
- auth controller ( check )

## Login controller

- if no action names was provided - do not shows recaptcha

## Auth controller

- if 2 or more action names - throws an error
- with 1 action name - do recaptcha check
- with no action name or positive check - send an email