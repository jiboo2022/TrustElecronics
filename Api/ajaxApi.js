$(document).ready(function(){
    $(document).on('click','.signupbtn', function(e){
      
      e.preventDefault();
      var fname = document.getElementById('firstname').value 
      var lname = document.getElementById('lastname').value 
      var email = document.getElementById('email').value 
      var phone = document.getElementById('phone').value 
      var addy = document.getElementById('address').value 
      var password = document.getElementById('passwordord').value
      
      var flen = fname.length;   
      var lname = lname.length
      var lmail= email.length
      var lphone = phone.length
      var laddy = addy.length
      var lpass = password.length
      

        if(flen == 0 || lname == 0 || lmail == 0 || lphone== 0 || laddy== 0 || lpass == 0 ){
          alert('please fill in all the information in the Form')
          exit();
        }
      
     

      $.ajax({
        url:'../Api/ajaxdata.php',
        method:'POST',
        data:{Registration:1,name:fname,surname:lname,emailaddress:email,phoneno:phone,address:addy,pass:password},
        success: function(data){

            //alert(data)

            $('.modal-body').html(data);
       
            $('#myModal8').modal('show');
        }


      });



    });



});

//setInterval(get,1000)//Runs the function every second


// verifiation 

$(document).ready(function(){
  $(document).on('click','.verifybutton', function(e){
     e.preventDefault()
   var indx1 = document.getElementById('token1').value 
   var indx2 = document.getElementById('token2').value 
   var indx3 = document.getElementById('token3').value 
   var indx4 = document.getElementById('token4').value 
   
    if(indx1 == ""){
     document.getElementById('token1').focus()
     exit()
    }
    if(indx2 == ""){
     document.getElementById('token2').focus()
     exit()
    }
    if(indx3 == ""){
     document.getElementById('token3').focus()
     exit()
    }
    if(indx4 == ""){
     document.getElementById('token4').focus()
     exit()
    }
    
 var num = indx1+indx2+indx3+indx4
  var newnum = parseInt(num)
 // alert(typeof newnum)

 $.ajax({
     url:"../Api/ajaxdata.php",
     method:'POST',
     data:{Token:newnum},
     success:function(data){
      
      $('.modal-body').html(data);
       
      $('#myModal8').modal('show');
     }
 })


  })
})

// get script
$(document).ready(function(){
  $(document).on('click','.otp',function(e){
    e.preventDefault()
    //alert('we are go to go to otp')
    window.location.href = "../Pages/confirmation.php" 
  })
})

//login redirecet script

$(document).ready(function(){
  $(document).on('click','.gotologin',function(e){
    e.preventDefault()
    //alert('we are go to go to otp')
    window.location.href = "../Pages/login.php" 
  })
})
  

//login redirecet script
$(document).ready(function(){
  $(document).on('click','.loginbutton',function(e){
    e.preventDefault()
   var email = document.getElementById('email').value 
   var password = document.getElementById('password').value 

   var elen = email.length;   
   var lpas = password.length

   if(elen == 0 || lpas == 0 ){
    alert('please fill in uesrname / password')
    exit();
   }
    $.ajax({
      url:'../Api/ajaxdata.php',
      method:'POST',
      data:{Login:1,useremail:email,userpassword:password},
      success: function(data){
        if(data === 'successful'){
          window.location.href="../index.php"
        }
        if(data === 'failed'){
          alert('Opps ! wrong username or password')
        }

      }
    })
   // window.location.href = "../Pages/login.php" 
  })
})





product();
function product(){
    $.ajax({
        url:'Api/ajaxdata.php',
        method:"POST",
        data:{getProduct:1},
        success: function(data){
          //console.log(data)
            $('#allcat').html(data);
        }

    })

}


electronics();
function electronics(){
    $.ajax({
        url:'../Api/ajaxdata.php',
        method:"POST",
        data:{getElectronics:1},
        success: function(data){
          //console.log(data)
            $('#electronics').html(data);
        }

    })

}


computing();
function computing(){
    $.ajax({
        url:'../Api/ajaxdata.php',
        method:"POST",
        data:{getComputing:1},
        success: function(data){
          //console.log(data)
            $('#computing').html(data);
        }

    })

}


phones();
function phones(){
    $.ajax({
        url:'../Api/ajaxdata.php',
        method:"POST",
        data:{getPhones:1},
        success: function(data){
          //console.log(data)
            $('#phones').html(data);
        }

    })

}




games();
function games(){
    $.ajax({
        url:'../Api/ajaxdata.php',
        method:"POST",
        data:{getGames:1},
        success: function(data){
          //console.log(data)
            $('#games').html(data);
        }

    })

}










cartcount();
function cartcount(){
    $.ajax({
        url:'Api/ajaxdata.php',
        method:"POST",
        data:{Cartcount:1},
        success: function(data){
          //console.log(data)
            $('#cartcount').html(data);
        }

    })

}

setInterval(cartcount,1000)//Runs the function every second



// add item to cart
$(document).ready(function(){
  $(document).on('click','#addcart',function(e){
    e.preventDefault()

   var proid = $(this).attr("proid")
   var price = $(this).attr("price")
   var name = $(this).attr("name")
   
   //var password = document.getElementById('password').value 
    $.ajax({
      url:'Api/ajaxdata.php',
      method:'POST',
      data:{Addcart:1,pid:proid,price:price,product:name},
      success: function(data){
        if(data === 'successful'){
          alert('1 item added to cart')
          //window.location.href="../index.php"
        }
        if(data === 'failed'){
          alert('Opps ! something went wrong')
        }
        if(data === 'nosignin'){
          alert('You must Login Or Register to add items to cart ')
          
          window.location.href="Pages/login.php"


        }

      }
    })
   // window.location.href = "../Pages/login.php" 
  })
})



$(document).ready(function(){
  $(document).on('click','#addcart2',function(e){
    e.preventDefault()

   var proid = $(this).attr("proid")
   var price = $(this).attr("price")
   var name = $(this).attr("name")
   
   //var password = document.getElementById('password').value 
    $.ajax({
      url:'../Api/ajaxdata.php',
      method:'POST',
      data:{Addcart:1,pid:proid,price:price,product:name},
      success: function(data){
        if(data === 'successful'){
          alert('1 item added to cart')
          //window.location.href="../index.php"
        }
        if(data === 'failed'){
          alert('Opps ! something went wrong')
        }
        if(data === 'nosignin'){
          alert('You must Login into your acoount Or Register an account to add items to cart ')
          
          window.location.href="../Pages/login.php"


        }

      }
    })
   // window.location.href = "../Pages/login.php" 
  })
})


showcart();
function showcart(){
    $.ajax({
        url:'../Api/ajaxdata.php',
        method:"POST",
        data:{Showcart:1},
        success: function(data){
          //console.log(data)
          $('#cartpage').html(data);
        }

    })

}







// view cart cart
$(document).ready(function(){
  $(document).on('click','#viewcart',function(e){
    e.preventDefault()

   var uid = $(this).attr("userid")
   //var price = $(this).attr("price")
   //var name = $(this).attr("name")

   //alert(uid)
   
   //var password = document.getElementById('password').value 
    $.ajax({
      url:'Api/ajaxdata.php',
      method:'POST',
      data:{Viewcart:1,uid:uid},
      success: function(data){
        if(data === 'noitem'){
          alert('Opps !! ,You have no Items in your Cart')
        }
        else if(data==='nologin'){
           alert('Please login to view yort cart')
        }
        else{
          //alert('can see this')
          
          window.location.href="Pages/cart.php"


        }

      }
    })
   // window.location.href = "../Pages/login.php" 
  })
})




// view cart cart
$(document).ready(function(){
  $(document).on('click','#viewcart2',function(e){
    e.preventDefault()

   var uid = $(this).attr("userid")
   //var price = $(this).attr("price")
   //var name = $(this).attr("name")

   //alert(uid)
   
   //var password = document.getElementById('password').value 
    $.ajax({
      url:'../Api/ajaxdata.php',
      method:'POST',
      data:{Viewcart:1,uid:uid},
      success: function(data){
        if(data === 'noitem'){
          alert('Opps !! ,You have no Items in your Cart')
        }
        else if(data==='nologin'){
           alert('Please login to view yort cart')
        }
        else{
          //alert('can see this')
          
          window.location.href="../Pages/cart.php"


        }

      }
    })
   // window.location.href = "../Pages/login.php" 
  })
})



// payment
$(document).ready(function(){
  $(document).on('click','#checkout',function(e){
    e.preventDefault()

   
   //alert('checkout is goo to go')
   
    $.ajax({
      url:'../Api/ajaxdata.php',
      method:'POST',
      data:{Checkout:1},
      success: function(data){
        if(data === 'noitem'){
          alert('Opps !! ,You have no Items in your Cart')
        }
        else if(data==='nologin'){
           alert('Please login to view yort cart')
        }
        else{
          
          window.location.href="../Pages/payment2.php"


        }

      }
    })
   // window.location.href = "../Pages/login.php" 
  })
})




// an sucessful paymeny
$(document).ready(function(){
  $(document).on('click','#paybutton',function(e){
    e.preventDefault()

   
  // alert('payment is ready to go')
   
    $.ajax({
      url:'../Api/ajaxdata.php',
      method:'POST',
      data:{Success:1},
      success: function(data){
        if(data === 'failed'){
          alert('Opps !! ,You have no Items in your Cart')
        }
      
        else{
          
          window.location.href="../Pages/success.php"


        }

      }
    })
   // window.location.href = "../Pages/login.php" 
  })
})


