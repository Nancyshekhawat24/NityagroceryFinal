<?php
$mysqli = new mysqli('localhost', 'root', '', 'mydbsnacks');

if ($mysqli->connect_error) {
    die('Connection Failed: ' . $mysqli->connect_error);
}

$message = "";

// Handle Insert
if (isset($_POST['add'])) {
    $snack_name = $_POST['snack_name'];
    $quantity = $_POST['quantity'];
    $mysqli->query("INSERT INTO snacks (snack_name, quantity) VALUES ('$snack_name', '$quantity')");
    $message = "Snack Added Successfully!";
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM snacks WHERE id=$id");
    $message = "Snack Deleted Successfully!";
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $snack_name = $_POST['snack_name'];
    $quantity = $_POST['quantity'];
    $mysqli->query("UPDATE snacks SET snack_name='$snack_name', quantity='$quantity' WHERE id=$id");
    $message = "Snack Updated Successfully!";
}

// Fetch all snacks
$result = $mysqli->query("SELECT * FROM snacks");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Snacks Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #444;
        }

        form.add-form {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        input[type="text"], input[type="search"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button, a.button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px 0;
        }

        button:hover, a.button:hover {
            background-color: #0069d9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .search-box {
            max-width: 300px;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popup {
            background-color: #28a745;
            color: white;
            padding: 15px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 999;
            border-radius: 5px;
            display: none;
        }

        @media (max-width: 600px) {
            th, td {
                padding: 10px;
                font-size: 14px;
            }

            input[type="text"], button {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
<button onclick="location.href='productmgmt.html'"> Back</button></div><br><br>


<h2>Snacks Management (Quantity as Text)</h2>

<?php if ($message != ""): ?>
    <div class="popup" id="popupMessage"><?php echo $message; ?></div>
<?php endif; ?>

<!-- Add Snack Form -->
<form class="add-form" method="post">
    <input type="text" name="snack_name" placeholder="Enter Snack Name" required>
    <input type="text" name="quantity" placeholder="Enter Quantity (e.g., 200 grams)" required>
    <button type="submit" name="add">Add Snack</button>
</form>

<!-- Search Bar -->
<div class="search-box">
    <input type="search" id="searchInput" placeholder="Search Snack Name...">
</div>

<!-- Snacks Table -->
<table id="snackTable">
    <tr>
        <th>ID</th><th>Snack Name</th><th>Quantity</th><th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <form method="post">
            <td><?php echo $row['id']; ?></td>
            <td><input type="text" name="snack_name" value="<?php echo $row['snack_name']; ?>"></td>
            <td><input type="text" name="quantity" value="<?php echo $row['quantity']; ?>"></td>
            <td>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="update">Update</button>
                <a class="button" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </form>
    </tr>
    <?php endwhile; ?>
</table>

<script>
// Success Popup
<?php if ($message != ""): ?>
    document.getElementById('popupMessage').style.display = 'block';
    setTimeout(() => {
        document.getElementById('popupMessage').style.display = 'none';
    }, 3000);
<?php endif; ?>

// Search Filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    var filter = this.value.toUpperCase();
    var rows = document.querySelector("#snackTable").rows;
    
    for (var i = 1; i < rows.length; i++) {
        var snackCell = rows[i].cells[1].querySelector('input').value;
        if (snackCell.toUpperCase().indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
});
</script>

</body>
</html>