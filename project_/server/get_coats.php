<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='coat' LIMIT 4");
$stmt-> execute();

$coats_products= $stmt->get_result();
?>