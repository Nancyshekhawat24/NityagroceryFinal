<?php
$mysqli = new mysqli('localhost', 'root', '', 'mydborder');

if ($mysqli->connect_error) {
    die('Connection Failed: ' . $mysqli->connect_error);
}

$order = null;
$error = "";

if (isset($_POST['track'])) {
    $order_id = $_POST['order_id'];

    $result = $mysqli->query("SELECT * FROM orders WHERE id = '$order_id'");
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        $error = "Order ID not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Your Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #f1f1f1;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: white;
            max-width: 500px;
            margin: 30px auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
            padding: 20px;
            background: #e7f3fe;
            border-left: 6px solid #2196F3;
            border-radius: 5px;
        }

        .error {
            background: #f8d7da;
            padding: 15px;
            border-left: 6px solid #f44336;
            margin-top: 20px;
            border-radius: 5px;
            color: #721c24;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Track Your Order</h2>

    <form method="post">
        <input type="text" name="order_id" placeholder="Enter Your Order ID" required>
        <button type="submit" name="track">Track Order</button>
    </form>

    <?php if ($order): ?>
        <div class="result">
            <strong>Order ID:</strong> <?php echo $order['id']; ?><br>
            <strong>Product:</strong> <?php echo $order['product_name']; ?><br>
            <strong>Quantity:</strong> <?php echo $order['quantity']; ?><br>
            <strong>Status:</strong> <span style="font-weight:bold; color:green;"><?php echo $order['status']; ?></span><br>
        </div>
    <?php elseif ($error): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>