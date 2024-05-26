# Readme

This is a test repository

1. Create Server
2. Create App

## Folders

```txt
app/                all app files  
    config/         config files  
    code/           app code
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

### Router

- method `execute` returns `RouterResult`
  - Result->getResponse() returns `string` ( default `empty string` )
  - Result->getHeaders()  returns `[[string, true/false, int], ...]`
  - Result->getStatus()   returns `int` ( default `0` )

### Controller

- return array with fields
  - response -  ControllerResult
  - headers - array of arrays [ [string, true/false, int], ... ]
