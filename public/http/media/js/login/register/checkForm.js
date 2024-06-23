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

    var errorField = document.getElementsByClassName('error_message');
    var registerButton = document.getElementById('register-button');
    
    /** 
     * `var inputPassword` 
     * must be equal to 
     * `var inputRepeatPassword` 
     * */
    var inputPassword = document.getElementById('input-password');
    var inputRepeatPassword = document.getElementById('input-repeat-password');

    console.log(inputRepeatPassword);


})();


