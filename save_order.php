<?php
$mysqli = new mysqli('localhost', 'root', '', 'mydbcart');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$customer_name = $_POST['customer_name'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];

$products = json_decode($_POST['productsData'], true);

foreach ($products as $product) {
    $name = $product['name'];
    $quantity = $product['quantity'];
    $price = $product['price'];

    $mysqli->query("INSERT INTO cart_orders (product_name, quantity, price, customer_name, mobile, address)
        VALUES ('$name', '$quantity', '$price', '$customer_name', '$mobile', '$address')");
}

echo "<script>alert('Order Placed Successfully!'); window.location.href='cart.php';</script>";
?>