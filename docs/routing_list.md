# Routing list

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