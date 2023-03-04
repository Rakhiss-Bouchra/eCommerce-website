<?php 
session_start();
include('server/connection.php');

if(isset($_POST['login_btn'])){
  $email = $_POST['email'];
  $password =md5($_POST['password']) ;

  $stmt = $conn ->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? AND user_password=? LIMIT 1");
  $stmt->bind_param('ss', $email, $password);
  if($stmt->execute()){
    $stmt->bind_result($user_id, $user_name,$user_email, $user_password);
    $stmt->store_result();

    if($stmt -> num_rows() == 1){
     $stmt ->fetch();
     $_SESSION['user_id']= $user_id;
     $_SESSION['user_name']= $user_name;
     $_SESSION['user_email']= $user_email;
     $_SESSION['logged_in']= true;

     header('location:index.php?login_success=logged in successfully');
    }else{
      header('location:login.php?error=There is no account with this informations');


    }


    
  }else{
    //error
    header('location:login.php?error=There is something going wrong');

  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="s.css">
</head>
<body>
<!--Navigation Bar-->
    <nav class="navbar navbar-expand-lg navbar-light  bg-white py-3 fixed-top">
            <div class="container">
           <img class="logo" src="assets/imgs/logo.jpeg" alt="">
           <h2 class="brand">Diamant</h2>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                  <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                  </li>
    
                  <li class="nav-item">
                    <a class="nav-link" href="#">Shop</a>
                  </li>
    
                  <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                  </li>
    
                  <li class="nav-item">
                    <a href="#"><i id="icn"  class="fas fa-shopping-bag"></i></a>
                    <a href="#"><i id="icn"  class="fas fa-user"></i></a>
                  </li>
                </ul>
                
            </div>
    </nav>

<!--Login-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="forme-weight-bold">Login</h2>
        <hr class="mx-auto">
    </div>
    <div class=" mx-auto container">
        <form id="login-form" action="login.php" method="POST">
          <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error'];}  ?></p>
            <div class="form-group">
                <label >Email</label>
                <input type="text" class="form-control" id="login-email" name="email", placeholder="Email" required>
            </div>
            <div class="form-group">
                <label >Password</label>
                <input type="password" class="form-control" id="login-password" name="password", placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login">
            </div>
            <div class="form-group">
                <a id="register-url" href="register.php" class="btn">Don't have an account? Register</a>
            </div>
        </form>
        </form>
        </form>
    </div>
</section>


        





















<!--Footer-->
 <footer class="mt-5 py-5">
    <div class="row container mx-auto pt-5 ">
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <img class="logo" src="assets/imgs/logo.jpeg"/>
        <p class="pt-3">We offer top-quality products at the most reasonable prices</p>
      </div>
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">Featured</h5>
        <ul class="text-uppercase">
          <li><a href="#">men</a></li>
          <li><a href="#">women</a></li>
          <li><a href="#">boys</a></li>
          <li><a href="#">girls</a></li>
          <li><a href="#">new arrivals</a></li>
          <li><a href="#">clothes</a></li>
        </ul>
      </div>
    <div class="footer-one col-lg-3 col-md-6 col-sm-12">
      <h5 class="pb-2">Contact Us</h5>
      <div>
        <h6 class="text-uppercase">Adress</h6>
        <p>1234 casablanca</p>
      </div>
      <div>
        <h6 class="text-uppercase">Phone</h6>
        <p>05 66 13 56 17</p>
      </div>
      <div>
        <h6 class="text-uppercase">Email</h6>
        <p>diamant@email.com</p>
      </div>   
    </div>
    <div class="footer-one col-lg-3 col-md-6 col-sm-12">
      <h5 class="pb-2">Instagram</h5>
      <div class="row">
        <img src="assets/imgs/footer1.jpeg" class="img-fluid w-25 h-100 m-2">
        <img src="assets/imgs/footer2.jpeg" class="img-fluid w-25 h-100 m-2">
        <img src="assets/imgs/footer3.jpeg" class="img-fluid w-25 h-100 m-2">
        <img src="assets/imgs/footer4.jpeg" class="img-fluid w-25 h-100 m-2">
        <img src="assets/imgs/footer5.jpeg" class="img-fluid w-25 h-100 m-2">
  
      </div>
    </div>
  </div>
  
  <div class="copyright mt-5">
    <div class="row container mx-auto">
      <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
        <img src="assets/imgs/payment.jpeg" >
      </div>
      <div class="col-lg-3 col-md-5 col-sm-12 mb-4 mb-2">
        <p>eCommerce @2022 All Rights Reserved</p>
      </div>
      <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
      </div>
    </div>
  </div>
 </footer>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>