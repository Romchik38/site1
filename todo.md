# Todo

## Current

- update to php-server v1.11.1
  - Controller replace `RequestInterface` with `ServerRequestInterface`
  - Refactor all files, that uses `RequestInterface` consts
  - Remove `RequestInterface`
  - Remove `UserRegisterDTOInterface`, factories, DTOs after romoving `request`
  - refactor dynamic action `auth`
    - index
    - changepassword
    - logout
    - recovery
    - register
  - refactor default action `Changepassword`
- registration with the same login shows an error on frontend `duplicate key users_email_key`

## Next

[-] opdate google recapcha
[-] check html syntax for all pages  
[-] phpstan  
