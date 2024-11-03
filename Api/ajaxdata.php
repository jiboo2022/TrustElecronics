<?php
 require_once('../config/connection.php');
 include '../Api/generaterand.php';
 include '../config/session.php';
      ?>
<?php 

//  User Registration
if (isset($_POST["Registration"]) ) {
  
    $connection = db_connect();
    $code = n_digit_random();
    $fname = $_POST['name'];
    $lname = mysqli_escape_string($connection,$_POST['surname']);
    $email = $_POST['emailaddress'];
    $phone = mysqli_escape_string($connection,$_POST['phoneno']);
    $address = mysqli_escape_string($connection,$_POST['address']);
    $pass = mysqli_escape_string($connection,$_POST['pass']);
    $activated = 'no';

     // check if email exiat in the database
  
     $getemailsql= mysqli_query($connection,"select count(*) FROM login WHERE email='$email' ") or die(mysqli_error($connection));
  
     $getemail = mysqli_fetch_row($getemailsql);
     $statemail = $getemail[0]; 

      if($statemail >= 1) 
       {

        $data = '<p style="text-align:center">Sorry This Email Already Exist</p>';
       
        mysqli_close($connection);
      } else
      
       {

     // encrypt password
     $passw = password_hash("$pass", PASSWORD_DEFAULT);

     // insert user information onto customer table

     $insert = mysqli_query($connection,"insert into customer(firstname,lastname,email,phone,address,activate_status) values ('$fname','$lname','$email','$phone','$address','$activated')") or die(mysqli_error($connection));
    
     // insert login information onto login table

     $lnsertlogin = mysqli_query($connection,"insert into login(email,password) values ('$email','$passw')") or die(mysqli_error($connection));

     $registerpin = mysqli_query($connection,"insert into activate(email,pin) values ('$email','$code')") or die(mysqli_error($connection));

         if($insert)

         {
            // stoer email address in session

            $_SESSION['activateemail']=$email;
                                                    
            $data = 'Registration Successful ! Your Confirmation pin is <h2 style="text-align:center"><b>'.$code.'</b></h2> ';
            $data .= '<br><p style="text-align:center"><b>Use PIN to complete registration</b></p><br>';
            $data .= '<div class="modal-footer">
                <button type="button" class="otp"  style="color:white;padding:20px;background-color:rgb(20, 51, 214);height:50px;witdth:90%"><b>Complete Registration</b></button>
                </div>';
        
            mysqli_close($connection);
                                                  
        }

     
   
    }

    echo $data;

}


//  Token verification
if (isset($_POST["Token"]) ) {
  
    $connection = db_connect();

    if(isset($_SESSION['activateemail'])){
        $email = $_SESSION['activateemail'];
        $token = $_POST['Token'];
          
        if($email){
            $data = $email.$token;
            // check if token exist for the user


            $check= mysqli_query($connection,"select count(*) FROM activate WHERE email='$email' && pin = $token ") or die(mysqli_error($connection));
  
            $getresult = mysqli_fetch_row($check);
            $statemail = $getresult[0]; 
       
             if($statemail >= 1) 
              {
       
               $data = '<p style="text-align:center">Token Confimation Successful </p>';
               $data .= '<div style="text-align:center">
                <button type="button" class="gotologin"  style="color:white;background-color:rgb(20, 51, 214);"><b>Proceed to Login Page</b></button>
                </div>';
              
               mysqli_close($connection);
             } else
             
              {
                
               $data = '<p style="text-align:center">Sorry This Token does not exist</p>';    
                
              }






        }
       
          }else{
            $data = 'cannot find email';
        
    }
    
    echo $data;
}


//  Login script
if (isset($_POST["Login"]) ) 
{
  
    $connection = db_connect();
    $email = mysqli_escape_string($connection,$_POST['useremail']);
    $password= mysqli_escape_string($connection,$_POST['userpassword']);
    
        //$data = $email.$password;

        $check= mysqli_query($connection,"select count(*) FROM login WHERE email='$email' ") or die(mysqli_error($connection));
  
            $getresult = mysqli_fetch_row($check);
            $statemail = $getresult[0]; 
       
             if($statemail >= 1) 
              {
                // get login details
        $queryresult = mysqli_query($connection, "SELECT * FROM login
        WHERE email ='$email' ") or die (mysqli_error($conn));

                
              if($queryresult != NULL){

                // get user details
                $userprofile1 = mysqli_query($connection, "SELECT * FROM customer
                WHERE email ='$email' ") or die (mysqli_error($conn));
                $userprofile = mysqli_fetch_array($userprofile1);

                $getresult = mysqli_fetch_array($queryresult);

                $dbpass = $getresult['password'];
                //$userid = $getresult['id'];
                // $now = date("l jS \of F Y h:i:s A");

                          if(password_verify($password, $dbpass)){

                                        $_SESSION['userprofile'] = $userprofile; 

                                       $data  = 'successful';

                                       //print_r($_SESSION['user']);
                                       // insert login in
                          }else{
                            $data='failed';
                          }

                        }


              }else{
                $data='failed';
              }
                               
   
  echo $data;
}




if(isset($_POST['getProduct'])){

   // $data = 'we are in for good ';
    // get the product information for live listings

        $currdate = date("Y-m-d");
        $connection = db_connect();
    $result = mysqli_query($connection,"SELECT * FROM product ORDER BY RAND() LIMIT 0,8   ");

      $i = 0;

       while($row = mysqli_fetch_array($result)){

        $i++;
        $productid = $row['productid'];
        $name = ucwords($row['name']);
        $price = $row['price'];
        $description = $row['description'];
        $imagename = $row['image'];
        $nprice =number_format($price,2);
        

    
         echo $data ="<div class='carddiv'>
         <div class='card' style='width: 18rem;height:70vh;margin-top:1px'>
            <img src='Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height='215' width:'160'>
            <div class='card-body'>
                <div style='height:'50px;background-color:green'>$name</div>
                <h5 class='card-title'></h5>
                <p class='card-text'><span>Price</span> &nbsp$nprice</p>
                <a href='Pages/product.php?productid=$productid' class='btn btn-primary' style='background-color:rgb(35, 53, 192)'>View Item</a>
                <button type='submit' class='btn btn-dark' id='addcart' name='$name'  price=$price proid=$productid>add to cart</button>
                
             </div>
             </div>
         </div>";
       
       }

       mysqli_close($connection);
}





if(isset($_POST['getSearch'])){

  // $data = 'we are in for good ';
   // get the product information for live listings

       $currdate = date("Y-m-d");
       $connection = db_connect();

       if(isset($_SESSION['search'])){
        $term = $_SESSION['search'];
         // count if the database

         $check= mysqli_query($connection,"select count(*) FROM  product
          WHERE name LIKE '%" . $term . "%' OR description LIKE '%" . $term  ."%'  ORDER BY RAND() LIMIT 0,4  ") or die(mysqli_error($connection));
  
         $getresult = mysqli_fetch_row($check);
         $statemail = $getresult[0]; 
    
          if($statemail >= 1) 
           {
            $result = mysqli_query($connection,"SELECT * FROM product WHERE name LIKE '%" . $term . "%' OR description LIKE '%" . $term  ."%'  ORDER BY RAND() LIMIT 0,8   ");

            $i = 0;

            while($row = mysqli_fetch_array($result)){
      
             $i++;
             $productid = $row['productid'];
             $name = ucwords($row['name']);
             $price = $row['price'];
             $description = $row['description'];
             $imagename = $row['image'];
             $nprice =number_format($price,2);
             
      
         
              echo $data ="<div class='carddiv'>
              <div class='card' style='width: 18rem;height:70vh;margin-top:1px'>
                 <img src='../Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height='215' width:'160'>
                 <div class='card-body'>
                     <div style='height:'50px;background-color:green'>$name</div>
                     <h5 class='card-title'></h5>
                     <p class='card-text'><span>Price</span> &nbsp$nprice</p>
                     <a href='../Pages/product.php?productid=$productid' class='btn btn-primary' style='background-color:rgb(35, 53, 192)'>View Item</a>
                     <button type='submit' class='btn btn-dark' id='addcart2' name='$name'  price=$price proid=$productid>add to cart</button>
                     
                  </div>
                  </div>
              </div>";
            
            }

           }
           else{
            echo $data ="<div style='text-align:center'><h3>Sorry we could not get your item ! try using a more common term for the search</h3></div>";

          }



        
    }else{
      // if session is not set

      $result = mysqli_query($connection,"SELECT * FROM product WHERE name LIKE '%" . $term . "%' OR description LIKE '%" . $term  ."%'  ORDER BY RAND() LIMIT 0,8   ");

            $i = 0;

            while($row = mysqli_fetch_array($result)){
      
             $i++;
             $productid = $row['productid'];
             $name = ucwords($row['name']);
             $price = $row['price'];
             $description = $row['description'];
             $imagename = $row['image'];
             $nprice =number_format($price,2);
             
      
         
              echo $data ="<div class='carddiv'>
              <div class='card' style='width: 18rem;height:70vh;margin-top:1px'>
                 <img src='../Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height='215' width:'160'>
                 <div class='card-body'>
                     <div style='height:'50px;background-color:green'>$name</div>
                     <h5 class='card-title'></h5>
                     <p class='card-text'><span>Price</span> &nbsp$nprice</p>
                     <a href='Pages/product.php?productid=$productid' class='btn btn-primary' style='background-color:rgb(35, 53, 192)'>View Item</a>
                     <button type='submit' class='btn btn-dark' id='addcart' name='$name'  price=$price proid=$productid>add to cart</button>
                     
                  </div>
                  </div>
              </div>";
            
            }

    }

      
    mysqli_close($connection);
     
    }
     







  if(isset($_POST['getComputing'])){

    // $data = 'we are in for good ';
     // get the product information for live listings
 
         $currdate = date("Y-m-d");
         $connection = db_connect();
     $result = mysqli_query($connection,"SELECT * FROM product WHERE categoryid=2 ORDER BY RAND() LIMIT 0,6  ");
 
       $i = 0;
 
        while($row = mysqli_fetch_array($result)){
 
         $i++;
         $productid = $row['productid'];
         $name = ucwords($row['name']);
         $price = $row['price'];
         $description = $row['description'];
         $imagename = $row['image'];
         $nprice =number_format($price,2);
         
 
     
          echo $data ="<div class='cards'>

          <div class='card' style='width: 18rem;height:70vh;margin-top:1px'>
         <img src='../Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height='215' width:'160'>
         <div class='card-body'>
             <div style='height:'50px;background-color:green'>$name</div>
             <h5 class='card-title'></h5>
             <p class='card-text'><span>Price</span> $price</p>
             <a href='../Pages/product.php?productid=$productid' class='btn btn-primary' style='background-color:rgb(35, 53, 192)'>View Item</a>
             <button type='submit' class='btn btn-dark' id='addcart2' name='$name'  price=$price proid=$productid>add to cart</button>
             
          </div>
          </div>
          </div>";
        
        }
 
        mysqli_close($connection);
 }


 
 if(isset($_POST['getPhones'])){

  // $data = 'we are in for good ';
   // get the product information for live listings

       $currdate = date("Y-m-d");
       $connection = db_connect();
   $result = mysqli_query($connection,"SELECT * FROM product WHERE categoryid=3 ORDER BY RAND() LIMIT 0,6  ");

     $i = 0;

      while($row = mysqli_fetch_array($result)){

       $i++;
       $productid = $row['productid'];
       $name = ucwords($row['name']);
       $price = $row['price'];
       $description = $row['description'];
       $imagename = $row['image'];
       $nprice =number_format($price,2);
       

   
        echo $data ="<div class='cards'>

        <div class='card' style='width: 18rem;height:70vh;margin-top:1px'>
       <img src='../Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height='215' width:'160'>
       <div class='card-body'>
           <div style='height:'50px;background-color:green'>$name</div>
           <h5 class='card-title'></h5>
           <p class='card-text'><span>Price</span> $price</p>
           <a href='../Pages/product.php?productid=$productid' class='btn btn-primary' style='background-color:rgb(35, 53, 192)'>View Item</a>
           <button type='submit' class='btn btn-dark' id='addcart2' name='$name'  price=$price proid=$productid>add to cart</button>
           
        </div>
        </div>
        </div>";
      
      }

      mysqli_close($connection);
}




if(isset($_POST['getGames'])){

  // $data = 'we are in for good ';
   // get the product information for live listings

       $currdate = date("Y-m-d");
       $connection = db_connect();
   $result = mysqli_query($connection,"SELECT * FROM product WHERE categoryid=4 ORDER BY RAND() LIMIT 0,6  ");

     $i = 0;

      while($row = mysqli_fetch_array($result)){

       $i++;
       $productid = $row['productid'];
       $name = ucwords($row['name']);
       $price = $row['price'];
       $description = $row['description'];
       $imagename = $row['image'];
       $nprice =number_format($price,2);
       

   
        echo $data ="<div class='cards'>

        <div class='card' style='width: 18rem;height:70vh;margin-top:1px'>
       <img src='../Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height='215' width:'160'>
       <div class='card-body'>
           <div style='height:'50px;background-color:green'>$name</div>
           <h5 class='card-title'></h5>
           <p class='card-text'><span>Price</span> $price</p>
           <a href='../Pages/product.php?productid=$productid' class='btn btn-primary' style='background-color:rgb(35, 53, 192)'>View Item</a>
           <button type='submit' class='btn btn-dark' id='addcart2' name='$name'  price=$price proid=$productid>add to cart</button>
           
        </div>
        </div>
        </div>";
      
      }

      mysqli_close($connection);
}






 

 if(isset($_POST['getElectronics'])){

  // $data = 'we are in for good ';
   // get the product information for live listings

       $currdate = date("Y-m-d");
       $connection = db_connect();
   $result = mysqli_query($connection,"SELECT * FROM product WHERE categoryid=1 ORDER BY RAND() LIMIT 0,6  ");

     $i = 0;

      while($row = mysqli_fetch_array($result)){

       $i++;
       $productid = $row['productid'];
       $name = ucwords($row['name']);
       $price = $row['price'];
       $description = $row['description'];
       $imagename = $row['image'];
       $nprice =number_format($price,2);
       

   
        echo $data ="<div class='cards'>

        <div class='card' style='width: 18rem;height:70vh;margin-top:1px'>
       <img src='../Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height='215' width:'160'>
       <div class='card-body'>
           <div style='height:'50px;background-color:green'>$name</div>
           <h5 class='card-title'></h5>
           <p class='card-text'><span>Price</span> $price</p>
           <a href='../Pages/product.php?productid=$productid' class='btn btn-primary' style='background-color:rgb(35, 53, 192)'>View Item</a>
           <button type='submit' class='btn btn-dark' id='addcart2' name='$name'  price=$price proid=$productid>add to cart</button>
           
        </div>
        </div>
        </div>";
      
      }

      mysqli_close($connection);
}



        if(isset($_POST['Getproduct'])){

        if(isset($_SESSION['pid'])){
          $pid=$_SESSION['pid'];

          // fetch product

          $connection = db_connect();
          $result = mysqli_query($connection,"SELECT * FROM product WHERE productid='$pid' ");
      
          $row = mysqli_fetch_array($result);
          $productid = $row['productid'];
          $name = ucwords($row['name']);
          $price = $row['price'];
          $description = $row['description'];
          $imagename = $row['image'];
          $nprice =number_format($price,2);
          

        }

        echo $data = "
        
        <div class='prodimg'>
          <div class='card' style='width: 90%;height;margin-top:1px'>
         <img src='../Assets/Images/siteImages/$imagename'  class='card-img-top' alt='...' height: width:160>
         
          </div>
        </div>
                <div class='prodesc'>
                    <p>$name</P>
                    <p> $description</P>
                    <p>$nprice</P>
                    <p>Add more</P>
                    <p><span><button class='butt'><i class='fa-solid fa-minus' style='font-size:25px;'></i></button></span>
                         <span id='qty' style='padding:4px;font-weight:bold'>1</span> 
                    <span><button type='submit' id='testing' proid='$productid' class='butt'><i class='fa-solid fa-plus' style='font-size:20px;border-color:whitesmoke'></i></buttton></span>
                </p>
                    
                    
                </div>


                <div class='prodcart'> 
                    <p><button type='submit' class='btn btn-dark' id='addcart2' name='$name'  price='$price' proid='$productid'>add to cart</button></p>
                </div>

                </div>
         ";
        }


 


   
if(isset($_POST['Addcart'])){

    if(isset($_SESSION['userprofile'])){
        $userinfo = $_SESSION['userprofile'];
        $name = $userinfo['firstname'];
        $uid = $userinfo['customerID'];

        $connection = db_connect();
        $pid = mysqli_escape_string($connection,$_POST['pid']);
        $price= mysqli_escape_string($connection,$_POST['price']);
        $product= mysqli_escape_string($connection,$_POST['product']);
        $qty = 1;
        $total = $price * $qty;

        // save item to cart
        $insert = mysqli_query($connection,"insert into cart(productid,customerid,price,name,qty,total)
         values ('$pid','$uid','$price','$product','$qty','$total')") or die(mysqli_error($connection));

         if($insert){
            $data = 'successful';
         }else{
            $data = 'failed';
         }
        
         mysqli_close($connection);  

    }
    
    else{

        $data = 'nosignin';


    }

    

    echo $data;
}


if(isset($_POST['Cartcount'])){
    $connection = db_connect();
    if(isset($_SESSION['userprofile'])){
        $userinfo = $_SESSION['userprofile'];
        $name = $userinfo['firstname'];
        $uid = $userinfo['customerID'];


        //count cart item for user


        $check= mysqli_query($connection,"select count(*) FROM cart WHERE customerid='$uid' ") or die(mysqli_error($connection));
  
        $getresult = mysqli_fetch_row($check);
        $data = $getresult[0]; 

    }else{
        $data ='0';
    }
    

echo $data;
}






if(isset($_POST['Success'])){
  $connection = db_connect();
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user

    $check= mysqli_query($connection,"DELETE FROM cart WHERE customerid='$uid' ") or die(mysqli_error($connection));

    if($check){
      $data = 'successful'; 

    }else{
        $data = 'failed';
      }
      

  }else{
      $data ='failed';
  }
  

echo $data;
}









 
if(isset($_POST['Showcart'])){

    if(isset($_SESSION['userprofile'])){
        $connection = db_connect();
        $userinfo = $_SESSION['userprofile'];
        $name = $userinfo['firstname'];
        $uid = $userinfo['customerID'];

        //count cart item for user
        $check= mysqli_query($connection,"select count(*) FROM cart WHERE customerid='$uid' ") or die(mysqli_error($connection));
  
        $getresult = mysqli_fetch_row($check);
        $res = $getresult[0]; 

            if($res >= 1) 

            {
                $connection = db_connect();
                $result = mysqli_query($connection,"SELECT * FROM cart WHERE customerid=$uid ORDER by cartid  ");
                  $data='';
                  $i = 0;
            
                   while($row = mysqli_fetch_array($result)){
            
                    $i++;
                    $cartid = $row['cartid'];
                    $productid = $row['productid'];
                    $name = ucwords($row['name']);
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'] * $qty;
                    $nprice =number_format($total,2);
                     $data .="
                     <div class='cart'>
                     <div class='delcart'><button type='submit' id='delcart' cartid='$cartid' type='submit' style='border:none'>
                     <i class='fa-solid fa-trash'></i></button>
                     </div>
                     <div class=' cartdesc'>
                          <div class='leftcartdesc'>
                              <span style='padding-bottom:20px'>$name</span><br><br>
                             
                           <span>$qty</span>&nbsp;  
                          <span><button type='submit' id='decrease' cartid='$cartid'><i class='fa-solid fa-minus'></i></button></span>
                          
                          <span><button type='submit' id='increase' cartid='$cartid'><i class='fa-solid fa-plus'></i></buttton></span>
                          </div>
                          <div class='reftcartdesc'><span>$name</span></div>
                     </div>
                     <div class='cartprice'> $nprice</div></div><div class='divider'></div>";
                      
                   }
                   
                }

                
                
                else{
                    $data="<div style='text-align:center;padding:20'>you have no items in your cart</div>";
                }


         }

           else{
            $data='You have no items in your cart';
           }       

           echo $data;

    }



 
    if(isset($_POST['Showtotal'])){

        if(isset($_SESSION['userprofile'])){
            $connection = db_connect();
            $userinfo = $_SESSION['userprofile'];
            $name = $userinfo['firstname'];
            $uid = $userinfo['customerID'];
    
            //count cart item for user
            $check= mysqli_query($connection,"select count(*) FROM cart WHERE customerid='$uid' ") or die(mysqli_error($connection));
      
            $getresult = mysqli_fetch_row($check);
            $res = $getresult[0]; 
    
                if($res >= 1) 
    
                {
                    $connection = db_connect();
                    $result = mysqli_query($connection,"SELECT * FROM cart WHERE customerid=$uid ORDER by cartid  ");
                      $data='';
                      $i = 0;
                      $sumtotal= 0;
                
                       while($row = mysqli_fetch_array($result)){
                
                        $i++;
                       
                        $cartid = $row['cartid'];
                        $productid = $row['productid'];
                        $name = ucwords($row['name']);
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $price*$qty;
                        $sumtotal += $total ;
                        $nprice =number_format($total,2);
                        $nsum =number_format($sumtotal,2);
                         
                          
                       }

                       $data ="
                       <div class='totalleft'><b>TOTAL</b></div>  
                       <div class='totalright'><b>$nsum</b><br>
                       <button total='$sumtotal' class='buttons' id='checkout'>Checkout</button></div> ";
                       
                    }
    
                    
                    
                    else{
                        $data="<div style='text-align:center;padding:20'>you have no items in your cart</div>";
                    }
    
    
             }
    
               else{
                $data='You have no items in your cart';
               }       
    
               echo $data;
    
        }









        
    if(isset($_POST['Showtotal1'])){

      if(isset($_SESSION['userprofile'])){
          $connection = db_connect();
          $userinfo = $_SESSION['userprofile'];
          $uname = $userinfo['firstname'].'&nbsp;'.$userinfo['lastname'];
          $uid = $userinfo['customerID'];
          $email = $userinfo['email'];
          $address = $userinfo['address'];
  
          //count cart item for user
          $check= mysqli_query($connection,"select count(*) FROM cart WHERE customerid='$uid' ") or die(mysqli_error($connection));
    
          $getresult = mysqli_fetch_row($check);
          $res = $getresult[0]; 
  
              if($res >= 1) 
  
              {
                  $connection = db_connect();
                  $result = mysqli_query($connection,"SELECT * FROM cart WHERE customerid=$uid ORDER by cartid  ") or die(mysqli_error($connection));
                  
                    $data='';
                    $i = 0;
                    $sumtotal= 0;
              
                     while($row = mysqli_fetch_array($result)){
              
                      $i++;
                     
                      $cartid = $row['cartid'];
                      $productid = $row['productid'];
                      $name = ucwords($row['name']);
                    
                      $price = $row['price'];
                      $qty = $row['qty'];
                      $total = $row['total']*$qty;
                      $sumtotal += $total;
                      $nprice =number_format($price,2);
                      $nsum =number_format($sumtotal,2);
                       
                        
                     }

                     $data ="
                     
                     <input type='hidden' name='productid' value='$productid' >
                     <input type='hidden' name='total' value='$sumtotal'>
                     <input type='hidden' name='cartid' value='$cartid'>
                     <input type='hidden' name='email' value='$email'>
                     <input type='hidden' name='userid' value='$uid'>
                     
                    <div class='payinner'>
                    <div class='payshipping'> 
                                <p><h4><b>Ship To</b></h4><p>
                                <p>$uname<p>
                                <p> $address<p>
                            </div>

                            <div class='paytotal'> 
                              <p><b>Subtotal</b> :$nsum</p>
                              <p><b>Shipping</b>:  0.00 </p>
                              <p>&nbsp; </p>
                              <p><b>GRAND TOTAL :$$nsum</b> <p>
                              <p><hr class='dropdown-divider'></p>
                              <button type='submit'  id='paybutto' name='confirmPay' class='buttons' ><b>Confirm & Pay</b></button>
                            </div>

                    </div>
                    
                      ";
                     
                  }
  
                  
                  
                  else{
                      $data="<div style='text-align:center;padding:20'>you have no items in your cart</div>";
                  }
  
  
           }
  
             else{
              $data='You have no items in your cart';
             }       
  
             echo $data;
  
      }
  


    



  

    //$data = 'can you see me in the cart page';
    




if(isset($_POST['Viewcart'])){
    //$connection = db_connect();
    if(isset($_SESSION['userprofile'])){
        $userinfo = $_SESSION['userprofile'];
        $name = $userinfo['firstname'];
        $uid = $userinfo['customerID'];

        //count cart item for user
        $check= mysqli_query($connection,"select count(*) FROM cart WHERE customerid='$uid' ") or die(mysqli_error($connection));
  
        $getresult = mysqli_fetch_row($check);
        $data = $getresult[0]; 
         
        if($data >= 1) 
          {

            $connection = db_connect();
            $result = mysqli_query($connection,"SELECT * FROM cart WHERE customerid='$uid'   ");
        
              $i = 0;
        
               while($row = mysqli_fetch_array($result)){
        
                $i++;
                $cartid = $row['cartid'];
                $productid = $row['productid'];
                $name = ucwords($row['name']);
                $price = $row['price'];
                $qty = $row['qty'];
                $total = $row['image'];
                $nprice =number_format($price,2);
            
                 echo $data ='am getting to the page';
        
              mysqli_close($connection);
              }if($data == 0){
                $data='noitem';
              }

    }else{

        // when no login info found
        $data ='nologin';
    }
    

echo $data;
}
}







if(isset($_POST['Checkout'])){
  //$connection = db_connect();
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      
      $data ='login';
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}





if(isset($_POST['Submitname'])){
  //$connection = db_connect();

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];

  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $connection = db_connect();
      $result = mysqli_query($connection,"UPDATE customer
      SET firstname = '$fname', lastname = '$lname' WHERE customerID = '$uid' ")
       or die(mysqli_error($connection));

       if($result){
        $data ='<div style="text-align:center;padding:20px"><b>Update Succcesful</b>';
       }else{
        $data ='<div style="text-align:center;padding:20px"><b>UnSucccesful</b>';

       }

      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}




if(isset($_POST['Submitaddress'])){
  //$connection = db_connect();

  $addy = $_POST['address'];
  //$lname = $_POST['lname'];

  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $connection = db_connect();
      $result = mysqli_query($connection,"UPDATE customer
      SET address = '$addy'  WHERE customerID = '$uid' ")
       or die(mysqli_error($connection));

       if($result){
        $data ='<div style="text-align:center;padding:20px"><b>Update Succcesful</b>';
       }else{
        $data ='<div style="text-align:center;padding:20px"><b>UnSucccesful</b>';

       }

      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}







if(isset($_POST['Submitmail'])){
  //$connection = db_connect();

  $mail = $_POST['mail'];
  //$lname = $_POST['lname'];

  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $connection = db_connect();
      $result = mysqli_query($connection,"UPDATE customer
      SET email = '$mail'  WHERE customerID = '$uid' ")
       or die(mysqli_error($connection));

       if($result){
        $data ='<div style="text-align:center;padding:20px"><b>Update Succcesful</b>';
       }else{
        $data ='<div style="text-align:center;padding:20px"><b>UnSucccesful</b>';

       }

      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}





if(isset($_POST['Submitphone'])){
  //$connection = db_connect();

  $phone = $_POST['phone'];
  //$lname = $_POST['lname'];

  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $connection = db_connect();
      $result = mysqli_query($connection,"UPDATE customer
      SET phone = '$phone'  WHERE customerID = '$uid' ")
       or die(mysqli_error($connection));

       if($result){
        $data ='<div style="text-align:center;padding:20px"><b>Update Succcesful</b>';
       }else{
        $data ='<div style="text-align:center;padding:20px"><b>UnSucccesful</b>';

       }

      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}




if(isset($_POST['Changename'])){
  //$connection = db_connect();
   //$newname = isset($_POST['name'])
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $data ='
       <input type="text" placeholder="Enter New First Name" name="firstname" id="firstname" >

       
      <input type="text" placeholder="Enter New Last Name" name="lastname" id="lastname" >

      <button type="button" id="submitname"
      style="color:white;width:;background-color:rgb(20, 51, 112); padding:11px;
       border:none;border-radius:4px;"><b>Submit</b></button>
      ';
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}






if(isset($_POST['Changemail'])){
  //$connection = db_connect();
   //$newname = isset($_POST['name'])
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $data ='
       
       
      <input type="text" placeholder="Enter New email" name="email" id="email" >

      <button type="button" id="submitmail"
      style="color:white;width:;background-color:rgb(20, 51, 112); padding:11px;
       border:none;border-radius:4px;"><b>Submit</b></button>
      ';
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}


if(isset($_POST['Changephone'])){
  //$connection = db_connect();
   //$newname = isset($_POST['name'])
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $data ='
      <input type="text" placeholder="Enter New Phone" name="phone" id="phone" >

      <button type="button" id="submitphone"
      style="color:white;width:;background-color:rgb(20, 51, 112); padding:11px;
       border:none;border-radius:4px;"><b>Submit</b></button>
      ';
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}




if(isset($_POST['Changeaddress'])){
  //$connection = db_connect();
   //$newname = isset($_POST['name'])
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $name = $userinfo['firstname'];
      $uid = $userinfo['customerID'];

      //count cart item for user
      $data ='
      

       
      <input type="text" placeholder="Enter New Address" name="address" id="address" >

      <button type="button" id="submitaddress"
      style="color:white;width:;background-color:rgb(20, 51, 112); padding:11px;
       border:none;border-radius:4px;"><b>Submit</b></button>
      ';
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}





if(isset($_POST['Showprofile'])){
  //$connection = db_connect();
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
     
      $uid = $userinfo['customerID'];
      


       //get current user profile
       $connection = db_connect();
       $result = mysqli_query($connection,"SELECT * FROM customer WHERE customerID = '$uid' ")
        or die(mysqli_error($connection));
       $row = mysqli_fetch_array($result);

       $email = $row['email'];
      $address = $row['address'];
      $phone = $row['phone'];
      $name = $row['firstname'].'&nbsp;'.$row['lastname'];


      //count cart item for user
      
      $data ="<div class='proinner'>
      <div style='padding:10px'>
   <p>$name</p>
   <button id='changename' style='border:none;background:whitesmoke'><a href='#' > Change Name</a></button>
   </div>
  </div>


  <div class='proinner'>
      <div style='padding:10px'>
   <p> $address</p>
   <button id='changeaddress' style='border:none;background:whitesmoke'><a href='#' > Change Address</a></button>
   </div>
  </div>



  <div class='proinner'>
      <div style='padding:10px'>
   <p> $email</p>
   <button id='changemail' style='border:none;background:whitesmoke'><a href='#' > Change Email</a></button>
   </div>
  </div>



  <div class='proinner'>
      <div style='padding:10px'>
   <p>$phone</p>
   <button id='changephone' style='border:none;background:whitesmoke'><a href='#' > Change Phone</a></button>
   </div>
  </div>
";
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}





if(isset($_POST['Deletecart'])){
  //$connection = db_connect();

  $cart = $_POST['cartid'];
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      
      // remove
      
      //get current user profile
      $connection = db_connect();
      $result = mysqli_query($connection,"DELETE FROM cart WHERE cartid='$cart' ")
       or die(mysqli_error($connection));

        if($result){
          $data ='successful';
        }else{
          $data ='Unsuccessful';
        }
      //count cart item for user
      
      
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}




if(isset($_POST['Increasecart'])){
  //$connection = db_connect();

  $cart = $_POST['cartid'];
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $connection = db_connect();
      // get the current quantity
      $result1 = mysqli_query($connection,"SELECT * FROM cart WHERE cartid='$cart' ")or die(mysqli_error($connection));
      $row = mysqli_fetch_array($result1);
      $qty= $row['qty'];

      $newqty = $qty + 1;
      //get current user profile
      
      
      $result = mysqli_query($connection,"UPDATE cart
      SET qty = '$newqty'  WHERE cartid='$cart' ")
       or die(mysqli_error($connection));

        if($result){
          $data ='successful';
        }else{
          $data ='Unsuccessful';
        }
      //count cart item for user
      
      
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}



if(isset($_POST['Decreasecart'])){
  //$connection = db_connect();

  $cart = $_POST['cartid'];
  if(isset($_SESSION['userprofile'])){
      $userinfo = $_SESSION['userprofile'];
      $connection = db_connect();
      // get the current quantity
      $result1 = mysqli_query($connection,"SELECT * FROM cart WHERE cartid='$cart' ")or die(mysqli_error($connection));
      $row = mysqli_fetch_array($result1);
      $qty= $row['qty'];
        if($qty > 1){
          $newqty = $qty - 1;
          $result = mysqli_query($connection,"UPDATE cart
          SET qty = '$newqty'  WHERE cartid='$cart' ")
           or die(mysqli_error($connection));
    
            if($result){
              $data ='successful';
            }else{
              $data ='Unsuccessful';
            }

        }
          else{
           $data = 'less';
          }
     
      //get current user profile
      
      
     
      //count cart item for user
      
      
      
  }
  
  else{

      // when no login info found
      $data ='nologin';
  }
  

echo $data;

}



?>