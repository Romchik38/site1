'use strict';

(()=>{
    addEventListener("DOMContentLoaded", (event) => {
       
    var notloggedinElems = document.getElementsByClassName('header-user-notloggedin');
    var loggedinElems = document.getElementsByClassName('header-user-loggedin');
    var usernameElems = document.getElementsByClassName('user-name-field');

    if (notloggedinElems.length === 0 || loggedinElems.length === 0 || usernameElems.length === 0) {
        console.error('userinfo script started, but some of the elements not found on the page, pls check it: [header-user-notloggedin, header-user-loggedin, user-name-field]');
        return;
    }
    
        var url = window.location.origin + '/api/userinfo';
        
        fetch(url).then(function(response){

            if (response.status === 200) {
                response.json().then((data) => {
                    var dataKeys = Object.keys(data);
                    if (dataKeys.indexOf('success') > -1) {
                        var success = data['success'];
                        var successKeys = Object.keys(success);
                        if(successKeys.indexOf('username') > -1) {
                            var username = success['username'];
                            for(var elem of usernameElems) {
                                elem.innerText = username;
                            }

                            for(var elem of notloggedinElems) {
                                elem.style.display = 'none';
                            }
                            for(var elem of loggedinElems) {
                                elem.style.display = 'flex';
                            }
                        }
                    }
                }, (err)=> {
                   console.log(err);
                    
                }) 
            }
            
        }, function(error){
            console.log(error);
            
        });
    });
})();