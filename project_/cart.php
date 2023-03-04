<?php
session_start();

if(isset($_POST['add_to_cart'])){
  if(isset($_SESSION['cart'])){
    $products_array_ids = array_column($_SESSION['cart'],'product_id');
    if(!in_array($_POST['product_id'], $products_array_ids )){
      
      $product_id=$_POST['product_id'];
      $product_array= array(
         'product_id'=> $_POST['product_id'],
         'product_name'=> $_POST['product_name'],
         'product_price'=> $_POST['product_price'],
         'product_image'=> $_POST['product_image'],
         'product_quantity'=> $_POST['product_quantity']

   );
   $_SESSION['cart'][$product_id]=$product_array;


    }else{ //product already in the cart
      echo '<script>alert("Product Already Added") </script>';

    }

  }else{
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price= $_POST['product_price'];
   $product_image= $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $product_array= array(
    'product_id'=> $product_id,
    'product_name'=> $product_name,
    'product_price'=> $product_price,
    'product_image'=> $product_image,
    'product_quantity'=> $product_quantity

   );
   $_SESSION['cart'][$product_id]=$product_array;
  }
   //calculate total price
   calculateTotalCart();

//remove product from the cart
  }else if(isset($_POST['remove_product'])){

    $product_id=$_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    calculateTotalCart();


}else if( isset($_POST['edit_quantity'])){
  //get id and quantity from the form
  $product_id= $_POST['product_id'];
  $product_quantity= $_POST['product_quantity'];
  //get the product array fromthe session
  $product_array = $_SESSION['cart'][$product_id];
  //update
  $product_array['product_quantity'] = $product_quantity;
  //return 
  $_SESSION['cart'][$product_id]= $product_array;
  calculateTotalCart();


}
else{
  //header('location= index.php');
}

function calculateTotalCart(){
  $total=0;
  foreach($_SESSION['cart'] as $key => $value ){
    $product = $_SESSION['cart'][$key];
    $price = $product['product_price'];
    $quantity= $product['product_quantity'];

    $total= $total + ($price * $quantity);

  }
  
  $_SESSION['total']= $total;
  
  
  
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

<!--Cart-->
<section class="cart container my-5 py-5">
    <div clas="container mt-5">
        <h2 class="font-weight-bolde">Your Cart</h2>
        <hr>
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach($_SESSION['cart'] as $key => $value ){ ?>
        <tr>
            <td>
                <div class="product-info">
                    <img src="assets/imgs/<?php echo $value['product_image'];?>" >
                    <div>
                        <p><?php echo $value['product_name'];?></p>
                        <small><span>$</span><?php echo $value['product_price'];?></small>
                        <br>
                        <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id"  value="<?php echo $value['product_id'];?>"/>
                        <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                        </form>
                       
                    </div>
                </div>
            </td>
            <td>
              
              <form method="POST" action="cart.php">
              <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>" />
              <input type="number" name= "product_quantity" value="<?php echo $value['product_quantity'];?>">
              <input type="submit" class="edit-btn" value="edit" name="edit_quantity" />
              </form>
            </td>
            <td>
              <span>$</span>
              <span class="product-price"><?php echo $value['product_quantity']* $value['product_price'];?></span>
            </td>
        </tr>
        <?php }?>
    </table>
    <div class="cart-total">
      <table>
        <tr>
          <td>Total</td>
          <td>$ <?php echo $_SESSION['total'];?></td>
        </tr>
      </table>
    </div>

   <div class="checkout-container">
    <form method="POST" action="checkout.php">
      <input type="submit" class="btn ckeckout-btn" value="Checkout" nam="checkout">
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
        

