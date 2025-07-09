<?php
// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'mydborder');

if ($mysqli->connect_error) {
    die('Connection Failed: ' . $mysqli->connect_error);
}

$message = "";
$orderData = [];

// Check if form submitted
if (isset($_POST['submit'])) {
    $product_details = $_POST['product_details'];
    $quantity = intval($_POST['quantity']);
    $address = $_POST['address'];
    $name = $_POST['name'];
    $total_price = $_POST['total_price'];

    // Insert order into the database
    $stmt = $mysqli->prepare("INSERT INTO orders (product_name, quantity, address, customer_name, total_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $product_details, $quantity, $address, $name, $total_price);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $message = "Order Placed Successfully!";
        $orderData = [
            'id' => $order_id,
            'name' => $name,
            'address' => $address,
            'product_details' => $product_details,
            'total_price' => $total_price
        ];
    } else {
        $message = "Error placing order!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Nitya Grocery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f1f1f1;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            max-width: 600px;
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
        textarea, input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
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
    </style>
</head>
<body>

<div class="container">

    <h2 style="text-align:center; color:green;">Checkout</h2>

    <form method="post">
        <label>Product Details:</label>
        <textarea id="productDetails" name="product_details" readonly required></textarea>

        <label>Total Price (₹):</label>
        <input type="text" id="totalPrice" name="total_price" readonly required>

        <label>Your Name:</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Quantity:</label>
        <input type="text" name="quantity" placeholder="Enter Quantity" required>

        <label>Delivery Address:</label>
        <textarea name="address" placeholder="Enter delivery address" required></textarea>

        <button type="submit" name="submit">Place Order</button>
    </form>

</div>

<script>
// Fill product details from URL
const urlParams = new URLSearchParams(window.location.search);
const cart = JSON.parse(decodeURIComponent(urlParams.get('cart')) || "[]");

let productText = '';
let grandTotal = 0;

cart.forEach(item => {
    productText +=` ${item.name} - ₹${item.price}\n`;
    grandTotal += item.price;
});

// Set values to form fields
document.getElementById('productDetails').value = productText.trim();
document.getElementById('totalPrice').value = grandTotal;

// If order placed successfully, show SweetAlert popup
<?php if (!empty($orderData)): ?>
Swal.fire({
    title: 'Order Placed!',
    html: `
        <strong>Order ID:</strong> <?php echo htmlspecialchars($orderData['id']); ?><br>
        <strong>Name:</strong> <?php echo htmlspecialchars($orderData['name']); ?><br>
        <strong>Address:</strong> <?php echo nl2br(htmlspecialchars($orderData['address'])); ?><br>
        <strong>Product Details:</strong><pre style="display:inline;"><?php echo htmlspecialchars($orderData['product_details']); ?></pre><br>
        <strong>Total Price:</strong> ₹<?php echo htmlspecialchars($orderData['total_price']); ?>
    `,
    icon: 'success',
    timer: 10000,
    timerProgressBar: true,
    showConfirmButton: false
}).then(() => {
    window.location.href = "index.html";
});

setTimeout(() => {
    window.location.href = "index.html";
}, 10000); // Auto-redirect after 5 seconds
<?php endif; ?>
</script>

</body>
</html>