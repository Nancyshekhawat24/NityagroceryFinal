<?php
$mysqli = new mysqli('localhost', 'root', '', 'mydb.drinks');

if ($mysqli->connect_error) {
    die('Connection Failed: ' . $mysqli->connect_error);
}

$message = "";

// Handle Insert
if (isset($_POST['add'])) {
    $drink_name = $_POST['drink_name'];
    $quantity = $_POST['quantity'];
    $mysqli->query("INSERT INTO drinks (drink_name, quantity) VALUES ('$drink_name', '$quantity')");
    $message = "Drink Added Successfully!";
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM drinks WHERE id=$id");
    $message = "Drink Deleted Successfully!";
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $drink_name = $_POST['drink_name'];
    $quantity = $_POST['quantity'];
    $mysqli->query("UPDATE drinks SET drink_name='$drink_name', quantity='$quantity' WHERE id=$id");
    $message = "Drink Updated Successfully!";
}

// Fetch all drinks
$result = $mysqli->query("SELECT * FROM drinks");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drink Management (Quantity Text)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form.add-form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
            max-width: 600px;
            margin: 20px auto;
        }

        input[type="text"], input[type="search"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
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

        td form {
            display: inline;
        }

        .search-box {
            max-width: 300px;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popup {
            background-color: #4CAF50;
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


<h2>Drink Management (Simple Quantity)</h2>

<?php if ($message != ""): ?>
    <div class="popup" id="popupMessage"><?php echo $message; ?></div>
<?php endif; ?>

<!-- Add Drink Form -->
<form class="add-form" method="post">
    <input type="text" name="drink_name" placeholder="Enter Drink Name" required>
    <input type="text" name="quantity" placeholder="Enter Quantity (e.g., 2 Bottles)" required>
    <button type="submit" name="add">Add Drink</button>
</form>

<!-- Search Bar inside Table -->
<div class="search-box">
    <input type="search" id="searchInput" placeholder="Search Drink Name...">
</div>

<!-- Drinks Table -->
<table id="drinkTable">
    <tr>
        <th>ID</th><th>Drink Name</th><th>Quantity</th><th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <form method="post">
            <td><?php echo $row['id']; ?></td>
            <td><input type="text" name="drink_name" value="<?php echo $row['drink_name']; ?>"></td>
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
// Show success popup if message exists
<?php if ($message != ""): ?>
    document.getElementById('popupMessage').style.display = 'block';
    setTimeout(() => {
        document.getElementById('popupMessage').style.display = 'none';
    }, 3000);
<?php endif; ?>

// Live Search Filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    var filter = this.value.toUpperCase();
    var rows = document.querySelector("#drinkTable").rows;
    
    for (var i = 1; i < rows.length; i++) {
        var drinkCell = rows[i].cells[1].querySelector('input').value;
        if (drinkCell.toUpperCase().indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
});
</script>

</body>
</html>