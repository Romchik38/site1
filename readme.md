# Readme

This is a test repository

## Folders

```txt
app/                all app files 
    bootstrap/      app init
    code/           app code
    config/         config files  
    sql/            sql tables
    var/            log files ( created manualy [see](./help.md))
nginx/              nginx files
public/             public files  
    index.php/      entry point  
    media/          static files  
        js/  
        img/  
        css/  
        other/  
```

## Concept

Uses MVC

### Routing list

**GET**
/                   page controller
/some_page
/index                    equal /

/login                    login controller
/login/index              main page
                          shows login/password form for guests
/login/register           shows register form
/login/recovery           shows recovery form
/login/changepassword     shows change password form for logged in user
                          or show link to recovery/login page
/changepassword           check a recovery link.
                          if it is active - do auth and redirect to /changepassword/index
                          if it is not - redirect to /changepassword/index 
                          [!] it must be a POST controller, but link can be crated for GET

**POST**
/auth/index     login/password check
                redirect to /login/index
/auth/logout    destroy a session if userId was provided
                redirect to /login/index
/auth/register  register from check
/auth/recovery  send a recovery link
/auth/changepassword  check provided new password from /login/changepassword

## Menu

- static
- dynamic
- breadcrumbs

## Design

- used Bootstrap 5
- design 60x30x10
  60 - white ( background )
  30 - bg-primary ( menu )
  10 - bg-secondary ( buttons etc )

## Google Recaptcha 

Visit `/login/recovery` page. Recovery button is protected by google recaptcha V3
