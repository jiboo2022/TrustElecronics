<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="Assets/Images/icons/favicon-32x32.png">
    
    <!-- Bootsraap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stylesheet/css/index.css">
    <title>TrustElectronicABC</title>
</head>
<body>
   
    <div class='container' id='topheader'>

    <!--div for the top menu starts here -->
    <div class='row' id='topheader'>
    <h1>TrustElectronicABC</h1> 
        top header</div>
    </div>
    <!--div for the top menu ends here-->


    <div class='container' id='container2'>
    
    
    <!--div for the banner starts here-->
    <div class='row' id='banner'> banner</div>
    <!--div for the banner ends here-->

    <!--div for the products starts here-->
    <div class='row' id='products'>Products</div>
    <!--div for the products ends here-->

    <!--div for the footer starts here  -->   
    <div class='row' id='footer'> footer</div>
  
    </div>


<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("topheader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>