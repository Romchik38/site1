'use strict';

(()=>{
    addEventListener("DOMContentLoaded", (event) => {
       
    var notloggedinDivs = document.getElementsByClassName('header-user-notloggedin');
    var loggedinDivs = document.getElementsByClassName('header-user-loggedin');
    var usernameElems = document.getElementsByClassName('user-name-field');

    if (notloggedinDivs.length === 0 ) return;
    var notloggedinDiv = notloggedinDivs[0];

    if (loggedinDivs.length === 0 ) return;
    var loggedinDiv = loggedinDivs[0];
    
    if (usernameElems.length === 0 ) return;
    var usernameElem = usernameElems[0];
    
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
                            usernameElem.innerText = username;
                            notloggedinDiv.style.display = 'none';
                            loggedinDiv.style.display = 'flex';
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