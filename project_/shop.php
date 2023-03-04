<?php
include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products ");
$stmt-> execute();

$products= $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="s.css">
    <link rel="stylesheet" href="assets/css/style.css">
   <!-- <style>
        .product img{
            width: 100%;
            height: auto;
            box-sizing: border-box;
            object-fit: cover;
        }
    </style>-->
    <style>
        .pagination a{
            color: coral;
        }
        .pagination li:hover a{
            color: #fff;
            background-color: coral;
        }
    </style>
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


<!--Shop-->
<section id="featured" class="my-5 py-5">
    <div class="container  mt-5 py-5">
      <h3>Our Products</h3>
      <hr >
      <p>Here you can check out our products</p>
    </div>
    <div class="row mx-auto container">

    <?php while($row = $products->fetch_assoc()){?>
      <div onclick="window.location.href='single_product.html';" class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class= "img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image'];?>"/>
        <div class="star">
          <i id="str" class="fas fa-star"></i>
          <i id="str" class="fas fa-star"></i>
          <i id="str" class="fas fa-star"></i>
          <i id="str" class="fas fa-star"></i>
          <i id="str" class="fas fa-star"></i>
        </div>
        <h5 class="p-name"><?php echo $row['product_name'];?></h5>
        <h4 class="p-price">$<?php echo $row['product_price'];?></h4>
        <a class="btn buy-btn" href="<?php echo "single_product.php?product_id=".$row['product_id'];?>">Buy Now</a>
      </div>
      <?php } ?>
    

      <nav aria-label="Page navigation example">
        <ul class="pagination mt-5">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
      </nav>
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