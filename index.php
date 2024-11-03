<?php include_once("config/session.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet/css/index.css">
     <!-- Bootsraap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   
    <link rel="stylesheet" href="Libs/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="Libs/jQuery-3.2.1/jquery-3.2.1.js"></script>
    <script src="https://kit.fontawesome.com/4be88f6315.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="Assets/Images/icons/favicon-32x32.png">
    <title>TrustElectronicsABC</title>
    <style>
        .example1 {
            height: 50px;
            overflow: hidden;
            position: relative;
        }
        .example1 p {
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0;
            line-height: 50px;
            text-align: center;
            /* Apply animation to this element */
            animation: example1 15s linear;
        }
        /* Define the animation */
        @keyframes example1 {
            0% {
                transform: translateX(300%);
            }
            100% {
                transform: translateX(0);
            }
        }

       
    </style>
</head>


<body>

<!-- mobile header start-->
<!-- Top Navigation Menu -->
<div class="topnav">
  <a href="#home" class="active">

  <form action="../WebAssessment/Pages/search.php" method='post'>
                <input type="text" placeholder="Search.." name="search" class='searchind'>
                <button type="submit" name='searchIT' class='searchind2'><i class="fa fa-search"></i></button>
            </form>
  </a>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
  <a href="Pages/electronics.php">Electronics</a>
  <a href="Pages/computing.php">Computing</a>
  <a href="Pages/phones.php">Phones</a>
  <a href="Pages/games.php">Games & consoles</a> 

  <?php 

                                            
            if(isset($_SESSION['userprofile'])){
                echo" <span style='font-weight:bold'> <a href='Pages/profile.php' class='log'>Profile</a>
                <a href='Pages/logout.php' class='log'>Log out</a>
                </span>
                ";
            }else{
                echo" <span style='font-weight:bold'><a href='Pages/login.php' class='log'>Log In</a>
                    <a href='Pages/registration.php' class='reg'>Register</a>
                    </span>
                    ";
                                    
            }
                        
            ?>


  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="my()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<!-- mobile header ends-->


<!-- top div starts here -->
<div id="myHeader">
    <div class="top-container">
     <!--inner top div starts-->  
     <div class="container">

        <div class="row">
            <div class="col">
        
            </div>
            <div class="col-5">

            <div class="search-container">
            <form action="../WebAssessment/Pages/search.php" method='post'>
                <input type="text" placeholder="Search.." name="search" class='searchind'>
                <button type="submit" name='searchIT' class='searchind2'><i class="fa fa-search"></i></button>
            </form>
            </div>
        
            </div>
            <div class="col-3">
            
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
                <a href='index.php' class='text-decoration-none'><h4 style='font-weight:bold'>
                <img src='Assets/Images/siteImages/logomain.png' alt='logo image' style='width:50%'></h4></a>
                </span>
            </div>

            <div class="col-md-5" style='padding:0;margin:0' >
                <span  >
                    <ul class='navp'>
                        <li><a href="Pages/electronics.php">Electronics</a></li> |
                        <li><a href="Pages/computing.php">Computing</a></li>|
                        <li><a href="Pages/phones.php">Phones</a></li>|
                        <li><a href="Pages/games.php">Games & consoles</a> </li>
                        
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
                    $uid = $userinfo['customerID'];

                    $nam = substr($name, 0, 3);
                    $upper =  ucfirst($nam);

                    //$name = $userinfo['name'];

                    echo" <li class='loga'><a href='Pages/logout.php' class='log'>Log out</a></li>
                    <li class='rega' style='background-color:black'><a href='#' class='reg' style='background-color:black'><i class='fa-regular fa-user'></i>  </a></li> 
                    <div class='btn-group' >&nbsp
                    <a type='button'  style='border:none;background-color:whitesmoke;color:black;font-weight:bold' class='tn btn-secondary dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                        Hi $upper
                    </a>
                    <ul class='dropdown-menu'>
                        <li><a class='dropdown-item' href='../WebAssessment/Pages/profile.php'>Profile</a></li>
                        <li><a class='dropdown-item' href='#'>History</a></li>
                        <li><hr class='dropdown-divider'></li>
                        
                    </ul>
                    </div>";
 ;
                }else{

                   echo" <li class='loga'><a href='Pages/login.php' class='log'>Log In</a></li>
                    <li class='rega'><a href='Pages/registration.php' class='reg'>Register</a></li> 
                    <li >";
                        
                }
                ?>
  
                    <li>
                        <span ><button  userid=<?php if(isset($userinfo)){ echo $uid ;} else echo 'nologin'?> style='border:none;background-color:white; padding-top:3px' type='submit' id='viewcart'><i style='font-size:20px;color:grey;margin-top:2px' class="fa fa-shopping-cart" aria-hidden="true">

                    </i></button></span></li> 
                    <span style='color:white' id='cartcount' class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">0</span>
                </ul>
                
                </span>
                
            </div>
        </div>
     </div>
    </div>
</div>
<!-- top div ends here -->

<!-- content div starts here -->

<div class="content">

  <div class='banner'>
  <div class='example'><p><span style='color:red'>30% OFF </span>  - Black Friday
  </p> 
</div>
  
</div>
  
  <!-- div todays deal heading start -->
  <div style='padding:20px;text-align:left'><p><h3>Explore Top Deals <button type="button" class="btn btn-link">See more</button></h3></p></div>

  <!-- todays deal heading end -->

  <!-- div product for todays deals start-->
  <div class='cont'>
   
  <div id="allcat">here</div>
     
    </div>
     
 </div>
 <!-- div product for todays deals ends-->

 <div class='divider'></div>


<!-- div all categories starts -->

<div style='width:100%;background-color:whitesmoke'>
   <!-- products card -->
     
    <div style='width:100%;background-color:white; margin:auto;height:250px'>
    <div style='padding:10px;text-align:left;background-color:whitesmoke'><p><h3>Explore ther categories <button type="button" class="btn btn-link">See more</button></h3></p></div>
   
        </div>
     

    </div>
   

</div>
 

<!-- content div ends here -->

<!-- footer div starts here -->
<div class="footer">
 

  <div>

  <div class='container'>
    <div class='row'>

    <div class='col'>
       <p class='foot1'>Get To Know Us</p> 
       <p class='foot2'>Career</P> 
       <p class='foot2'>About Us</P> 
       <p class='foot1'>Get In Touch</p> 
       <p class='foot2'>Tel: 03303 200 880</P> 
       <p class='foot2'>Email: support@placeholder.co.uk</P> 
       <p class='foot3'> Registered Address: Durham House, 38 Street Lane, Denby, Ripley, Derbyshire, England, DE5 8NE</P> 
       <p>&nbsp;</P> 
       <p class='foot2'> <img src='Assets/Images/siteImages/payments (1).png' alt='payment' /></P> 
       <p>&nbsp;</P> 
       <p class='foot1'>TrustElectronicsABC LLP 2024 </P> 
    </div>
    <div class='col'>

       <p class='foot1'>Useful Information</p> 
       <p class='foot2'>Company Policy</P> 
       <p class='foot2'>Terms & Condition</P> 
       <p class='foot2'>Child Protection</p> 
       <p class='foot2'>Covid Risk Assessment</P> 
       <p class='foot2'>Health & Safety Policy</P> 
       <p class='foot2'>Noise Protection Policy</P> 
       <p class='foot2'>Privacy Policy</P> 
       <p class='foot2'>User Infromation Protection Policy</P> 
       <p>&nbsp;</P> 
    </div>
    <div class='col'>

    <p class='foot1'>Our Payment Method</p> 
       <p class='foot2'>Installment by Barclays</P> 
       <p class='foot2'>Trust Platnum Maastercard</P> 
       <p class='foot2'>Trust Classic Mastercard</p> 
       <p class='foot2'>Gift Card</P> 
       <p class='foot2'>Trust Currency Converter</P> 
       <p class='foot2'>Payment Method Help</P> 
       <p class='foot2'>Shop With Points</P> 
       <p class='foot2'>Top Up Your Account</P> 
       <p class='foot2'>Top Up Your Account in Store</P>
       <p>&nbsp;</P>
    </div>
    </div>
  </div>

  </div>
  
</div>
 
<!-- footer div ends here -->

<script >
function get() {
  alert('am here')
}



function my() {
    var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
<script src="Api/ajaxApi.js"></script>
<script src="Javascript/scroller.js"></script>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>