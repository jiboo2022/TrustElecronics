
$(document).ready(function() {
  $("#LOGIN").validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
       email: {
        required: true,
        email: true
      },

       password: {
        required: true,
        minlength: 5
      },

     

    messages : {
     

      email: {
        email: "The email should be in the format: abc@domain.tld"
      },


      password: {
        required: "Please enter password",
        minlength: "password should be at least 5 character"
        
      },

      
    }
}
  });
});




$(document).ready(function() {
  $(document).on('click','.signupbtn',function(){  
  $("#ORD").validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      firstname: {
        required: true,
        minlength: 3
      },

      lastname: {
        required: true,
        minlength: 3
      },

       email: {
        required: true,
        email: true
      },

       passwordord: {
        required: true,
        minlength: 5
      },

      pswrepeat: {
        required: true,
        minlength: 5,
        equalTo:'#passwordord'
      },



    messages : {
      mdas: {
      	required: "Please enter your name",
        minlength: "Name should be at least 3 characters"
      },

      bank: {
        required: "Please select your bank"
        
      },

      bankacct: {
        required: "Please select your acount number",
        number: "Please enter only a numerical value",
        minlength: "Account should nuban 10 digits"
      },

      email: {
        email: "The email should be in the format: abc@domain.tld"
      },


      password: {
        required: "Please enter password",
        minlength: "password should be at least 5 character"
        
      },


      pswrepeat: {
        required: "Please repeat password",
        minlength: "password should be at least 5 character", 
        equalTo: "Please enter same password as above"
        
      },



      
    }
}
});
  });
});
