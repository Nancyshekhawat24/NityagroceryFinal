<?php
// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'mydborder');

if ($mysqli->connect_error) {
    die('Connection Failed: ' . $mysqli->connect_error);
}

$message = "";

// Check if a status update was requested
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Prepare update query
    $stmt = $mysqli->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $order_id);
    
    if ($stmt->execute()) {
        $message = "Order status updated successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all orders
$query = "SELECT id, product_name, quantity, customer_name, address, status FROM orders";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #f1f1f1;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-image: url(bgadmin.jpg );
            background-size: cover;    
        }
        .container {
            background: white;
            max-width: 1000px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        select, button {
            padding: 10px;
            margin-top: 5px;
        }
        .popup {
            background-color: #17a2b8;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        
        
    </style>
</head>
<body>
<button class="back" onclick="location.href='productmgmt.html'"> Back</button></div><br><br>


<div class="container">
    <h2>Admin - Orders</h2>

    <?php if ($message != ""): ?>
        <div class="popup" id="popupMessage"><?php echo $message; ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['status'] ? $row['status'] : 'Pending'; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processed" <?php echo ($row['status'] == 'Processed') ? 'selected' : ''; ?>>Processed</option>
                                <option value="Shipped" <?php echo ($row['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo ($row['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
// Show success message popup
<?php if ($message != ""): ?>
    document.getElementById('popupMessage').style.display = 'block';
    setTimeout(() => {
        document.getElementById('popupMessage').style.display = 'none';
    }, 3000);
<?php endif; ?>
</script>

</body>
</html>