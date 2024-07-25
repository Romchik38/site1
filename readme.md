# Readme

This is a test repository

1. Create Server
2. Create App

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
server/             all server files  
```

## Concept

Uses MVC

### Server

- can filter traffic
- know about Router
- send headers
- send response
- upper try/catch
  - make site do not crush
  - also logs error if there was a logger in a container

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
/changepassword/index     shows change password form for logged in user
                          or show link to login page
/changepassword/recovery  

**POST**
/auth/index     login/password check
                redirect to /login/index
/auth/logout    destroy a session if userId was provided
                redirect to /login/index
/auth/register  register from check
/auth/recovery  send a recovery link 

/auth/changepassword  change a password