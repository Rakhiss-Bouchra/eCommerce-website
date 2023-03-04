<?php 
include('server/connection.php');
session_start();

if(isset($_POST['register'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmpassword = $_POST['cofirmpassword'];

if(strlen($password)<5){
    header('location: register.php?error=password must be at least 5 charachters');
 
  }else{  
      //check if there is a user with this email or not
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
    $stmt1 ->bind_param('s',$email);
    $stmt1 ->execute();
    $stmt1 ->bind_result($num_rows);
    $stmt1 ->store_result();
    $stmt1 ->fetch();
    //check if there is a user with the same email
    if($num_rows!=0){
      header('location:register.php?error=A user with the same email already exists' );
    }else{
       //create a new user
       $stmt = $conn->prepare("INSERT INTO users(user_name, user_email, user_password)
       VALUES(?,?,?)");
       $stmt ->bind_param('sss',$name,$email,md5($password));


      if($stmt ->execute()) {
        $user_id =$stmt->insert_id;
        $_SESSION['user_id']=$user_id;
        $_SESSION['user_email']=$email;
        $_SESSION['user_name']=$name;
        $_SESSION['logged_in']=TRUE;
        header('location:account.php?register_succes=You registred successfully');

      }else{
        header('location:register.php?error= Could not create your account');

      }
    }
  }}




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

<!--Register-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="forme-weight-bold">Register</h2>
        <hr class="mx-auto">
    </div>
    <div class=" mx-auto container">
        <form id="register-form" method="POST" action="register.php">
          <p><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
            <div class="form-group">
                <label >Name</label>
                <input type="text" class="form-control" id="register-name" name="name", placeholder="Name" required>
            </div>
            <div class="form-group">
                <label >Email</label>
                <input type="text" class="form-control" id="register-email" name="email", placeholder="Email" required>
            </div>
            <div class="form-group">
                <label >Password</label>
                <input type="password" class="form-control" id="login-password" name="password", placeholder="Password" required>
            </div>
            <div class="form-group">
                <label >Confirm Password</label>
                <input type="password" class="form-control" id="register-confirm-password" name="confirmpassword", placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="register-btn" value="Register" name="register">
            </div>
            <div class="form-group">
                <a id="login-url" href="login.php" class="btn">Already have an account? Login</a>
            </div>
        </form>

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