<?php 
/* not paid ; delivered ; shipped*/
session_start();
include('server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])){
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];
    $stmt = $conn ->prepare("SELECT * FROM order_items WHERE order_id=?");
    $stmt -> bind_param('i',$order_id);
    $stmt ->execute();
    $order_details = $stmt ->get_result();
    $order_total_price = calculateTotalOrderPrice($order_details);

}else{
    header('location:account.php');
    exit();
}

function calculateTotalOrderPrice($order_details){
    $total=0;
    foreach($order_details as $row ){
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];

        $total= $total + ($product_price * $product_quantity);

    }
     return $total;
   
    
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

<!--Order details-->
<section id="orders" class="orders container my-5 py-3">
  <div clas="container mt-5">
      <h2 class="font-weight-bold text-center">Order Details</h2>
      <hr class="mx-auto">
  </div>
  <table class="mt-5 pt-5 mx_auto">
      <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
      </tr>
    
      <?php foreach($order_details as $row){?>
        <tr>
          <td>
            <div class="product-info">
                <img src="assets/imgs/<?php echo $row['product_image']; ?>" alt="">
                <div>
                    <p class="mt-3"><?php echo $row['product_name']; ?></p>
                </div>
            </div>     
          </td>
          <td>
            <span>$<?php echo $row['product_price']; ?></span>
          </td>
          <td>
            <span><?php echo $row['product_quantity']; ?></span>
          </td>
          
      </tr>
      <?php  }?>
  </table>
  
  <?php 
  if($order_status == "not paid"){?>
  <form style="float:right;" method="POST" action="payment.php">
    <input type="hidden" name= "order_total_price" value="<?php echo $order_total_price; ?>">
    <input type="hidden" name= "order_status" value="<?php echo $oredr_status; ?>">
    <input type="submit" class="btn btn-primary" value="Pay Now" name="order_pay_btn">
  </form>

<?php }?>
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