<?php include_once("config/session.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootsraap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stylesheet/css/index.css">
    <link rel="stylesheet" href="Libs/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="Libs/jQuery-3.2.1/jquery-3.2.1.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="Assets/Images/icons/favicon-32x32.png">
    <title>TrustElectronicsABC</title>
</head>
<body>

<!-- top div starts here -->
<div id="myHeader">
    <div class="top-container">
     <!--inner top div starts-->  
     <div class="container">

        <div class="row">
            <div class="col">
            1 of 3
            </div>
            <div class="col-5">
                345
            </div>
            <div class="col-3">
            3 of 3
            </div>
        </div>
     </div>

    <!--inner top  div ends-->  
    </div>

    <div class="header">
    
    <div class="container" style='margin:0px' >

        <div class="row" >
            
            <div class="col-md" style='padding:0;margin:0'>
                <span class='float-none'>
                <a href='' class='text-decoration-none'><h4 style='font-weight:bold'>TrustElectronicsABC</h4></a>
                </span>
            </div>

            <div class="col-md-5" style='padding:0;margin:0' >
                <span  >
                    <ul class='navp'>
                        <li><a href="">Electronics</a></li> |
                        <li><a href="">Computing</a></li>|
                        <li><a href="">Phones</a></li>|
                        <li><a href="">Games & consoles</a> </li>
                        
                    </ul>
                </span>

              
            </div>
            <div class="col-md" style='padding:0;margin:0'>
                <span style='position:relative;float:right'>
                <ul class='navs' >

                <?php 

                                
                if(isset($_SESSION['userprofile'])){

                    $userinfo = $_SESSION['userprofile'];
                    $name = $userinfo['firstname'];

                    //$name = $userinfo['name'];

                    echo" <li class='loga'><a href='Pages/logout.php' class='log'>Log out</a></li>
                    <li class='rega' style='background-color:black'><a href='#' class='reg' style='background-color:black'>Welcome $name</a></li> " ;
                }else{

                   echo" <li class='loga'><a href='Pages/login.php' class='log'>Log In</a></li>
                    <li class='rega'><a href='Pages/registration.php' class='reg'>Register</a></li> 
                    <li >";
                        
                }
                ?>
  
                    <a href="Pages/cart.php">
                        <span ><i   style='font-size:27px;color:grey' class="fa fa-shopping-cart" aria-hidden="true">

                    </i></span>  </a> </li> 
                    <span style='color:white' id='cartcount' class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">0</span>
                </ul>
                
                </span>
                
            </div>
        </div>
     </div>
    </div>
</div>
<!-- top div ends here -->