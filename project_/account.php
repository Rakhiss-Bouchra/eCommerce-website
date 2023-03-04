<?php 
session_start();
include('server/connection.php');
if(!isset($_SESSION['logged_in'])){
  header('location:login.php');
  exit;
}

if(isset($_GET['logout'])){
  if(isset($_SESSION['logged_in'])){
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    header('location:login.php');
    exit;

  }
}

if(isset($_POST['change_password'])){
  $password = $_POST['password'];
  $confirmpassword = $_POST['confirmpassword'];
  $user_email = $_SESSION['user_email'];

  if(strlen($password)<5){
    header('location: account.php?error=password must be at least 5 charachters');
}else{
  $stmt= $conn ->prepare(" UPDATE users SET user_password=? WHERE user_email=? ");
  $stmt ->bind_param('ss',md5($password), $user_email);
  if($stmt ->execute()){
    header('location:account.php?message=The password has been updated successfully');
  }else{
    header('location:account.php?error=Could not update the password');
  }
}}

//get orders
if(isset($_SESSION['logged_in'])){
  $user_id =$_SESSION['user_id'];
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ");
  $stmt->bind_param('i',$user_id);
  $stmt-> execute();

$orders= $stmt->get_result();
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
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <a class="nav-link" href="index.php">Home</a>
                  </li>
    
                  <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                  </li>
    
                  <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact Us</a>
                  </li>
    
                  <li class="nav-item">
                    <a href="cart.php"><i id="icn"  class="fas fa-shopping-bag"></i></a>
                    <a href="account.php"><i id="icn"  class="fas fa-user"></i></a>
                  </li>
          
                </ul>
                
            </div>
    </nav>




    <!--Account-->
<section class="my-5 py-5">
    <div class="row container mx-auto">
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
        <p clas="text-center" style="color:green"><?php if(isset($_GET['register_success'])){echo $_GET['register_success'];} ?></p>
        <p clas="text-center" style="color:green"><?php if(isset($_GET['login_success'])){echo $_GET['login_success'];} ?></p>
            <h3 class="font-weight-bold">Account Informations</h3>
            <hr class="mx-auto">
            <div class="account-info">
                <p>Name : <span><?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];} ?>  </span></p>
                <p>Email : <span><?php if(isset($_SESSION['user_email'])){echo $_SESSION['user_email'];} ?></span></p>
                <p><a href="#orders" id="orders-btn">Your Orders</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <form id="account-form" method="POST" action="account.php" >
              <p clas="text-center" style="color:red"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
              <p clas="text-center" style="color:green"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></p>
                <h3>Change The Password</h3>
                <hr class="mx-auto">
                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control" id="account-password" name= "password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label >Confirm Password</label>
                    <input type="password" class="form-control" id="account-password-confirm" name= "confirmpassword" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Change Password" name=" change_password" class="btn" id="change-pass-btn">
                </div>
            </form>
        </div>

    </div>
    
</section>

<!--Orders-->
<section id="orders" class="orders container my-5 py-3">
  <div clas="container mt-2">
      <h2 class="font-weight-bold text-center">Your Order</h2>
      <hr class="mx-auto">
  </div>
  <table class="mt-5 pt-5">
      <tr>
          <th>Order id</th>
          <th>Order cost</th>
          <th>Order status</th>
          <th>Order date</th>
          <th>Order Details</th>
      </tr>
    
      <?php while($row = $orders -> fetch_assoc()){?>
        <tr>
          <td>
          <span><?php echo $row['order_id'];?></span>        
          </td>
          <td>
            <span>$<?php echo $row['order_cost'];?></span>
          </td>
          <td>
            <span><?php echo $row['order_status'];?></span>
          </td>
          <td>
            <span><?php echo $row['order_date'];?></span>
          </td>
          <td>
            <form method="POST" action="order_details.php">
              <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status">
              <input type="hidden" value="<?php echo $row['order_id'];?>" name="order_id">
              <input class="btn order-details-btn" name="order_details_btn" type="submit" value="details">
            </form>
          </td>
      </tr>
      <?php } ?>
  </table>
  


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