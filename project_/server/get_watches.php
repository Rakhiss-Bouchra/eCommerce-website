<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='watche' LIMIT 4");
$stmt-> execute();

$watches_products= $stmt->get_result();
?>