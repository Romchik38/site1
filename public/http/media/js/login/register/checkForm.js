'use strict';

// add class  
//  <input> <textarea> with .form-control
//  <select>s with .form-select
//  .form-check

//   is-valid
//   is-invalid
//      .invalid-feedback

// <div class="valid-feedback">
//      Looks good!
// </div>

(()=>{

    var errorField = document.getElementById('error_button');
    var registerButton = document.getElementById('register-button');
    
    /** 
     * `var inputPassword` 
     * must be equal to 
     * `var inputRepeatPassword` 
     * */
    var inputPassword = document.getElementById('input-password');
    var inputRepeatPassword = document.getElementById('input-repeat-password');

    registerButton.addEventListener('click', (e)=>{
        if (inputPassword.value.length > 0 && inputRepeatPassword.value.length > 0) {
            if (inputPassword.value === inputRepeatPassword.value) {
                // do request
                return;
            } else {
                e.preventDefault();
                errorField.innerText = "Passwords doesn't mutch";
                setTimeout(()=>{
                    errorField.innerText = '';
                }, 3000);
            }
        }
        
    });
})();


