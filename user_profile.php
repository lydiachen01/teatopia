<?php
session_start();

$server = "localhost";
$userid = "u9rnmkwnhqk3j";
$pw = "@*2l@2f7i%&2";
$db = "dbygr11xzpv4y5";

$conn = new mysqli($server, $userid, $pw, $db);

$userID = $_SESSION['userID'];

// Fetch user information from the database
$stmt = $conn->prepare("SELECT * FROM user_table WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // User found, fetch user details
    $userDetails = $result->fetch_assoc();
    $email = $userDetails['email'];
    $username = $userDetails['username'];
}

$stmt->close();

$stmt_orders = $conn->prepare("SELECT ot.orderID, oi.quantity, pt.productName
                            FROM order_table ot
                            JOIN OrderItem oi ON ot.orderID = oi.orderID
                            JOIN product_table pt ON oi.productID = pt.productID
                            WHERE ot.userID = ?"
);

$stmt_orders->bind_param("i", $userID);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();

$orders = [];
while ($row = $result_orders->fetch_assoc()) {
    $orders[] = $row;
}

$stmt_orders->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100;0,9..144,200;0,9..144,300;0,9..144,400;0,9..144,500;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,100&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap"
        rel="stylesheet">
    <title>Profile</title>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            font-size: 16px;
            margin: 0;
            line-height: 1.6;
            color: #333;
        }

        .parent {
            display: flex;
            position: relative;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .profile {
            display: block;
            margin: 100px 10%;
            max-width: 1000px;
            padding: 2em;
            font-family: 'Fraunces', serif;
            border: 1px solid olivedrab;
            background-color: #fff; /* Set background color */
            border-radius: 20px; /* Add border-radius for rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
        }

        .left {
            position: relative;
            padding-right: 20px; /* Add padding to separate from the right content */
        }

        .category {
            position: relative;
        }

        .left nav {
            background-color: #f5f5f5; /* Set background color for the sidebar */
            border-radius: 10px; /* Add border-radius for rounded corners */
            padding: 10px; /* Add padding */
        }

        .left a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease-in-out;
        }

        .left a:hover {
            background-color: #e0e0e0; /* Add a hover effect */
        }

        .right {
            padding: 0 0 0 20px; /* Adjust padding */
        }

        label {
            font-size: 25px;
            font-weight: bold;
        }

        .box {
            height: 160px;
            margin-bottom: 80px;
            text-align: left;
            background-color: rgba(106, 142, 35, 0.225);
            padding: 20px; /* Add padding */
            border-radius: 10px; /* Add border-radius for rounded corners */
        }
    </style>
</head>
<body>
    <!-- Navbar Component -->
    <div id="header" style="z-index:100;"></div>
    <script>
        $(function() {
            $("#header").load("navbar.php");
        });
    </script>

    <div class="parent">
        <div class="profile grid-cols-2 grid mx-6" style="width:1200px;">
            <!-- Sidebar -->
            <div class="left">
                <nav class="category">
                    <a href="#user-info"><div>User Info</div></a>
                    <a href="#order-history"><div>Order History</div></a>
                </nav>
            </div>

            <div class="right">

                <!-- User Info/Contact Info -->
                <div id="user-info">
                    <label class="block text-lg mb-2">User Info</label>
                    <div class="box">
                        <div>Username: <?php echo $username; ?></div>
                        <div>Email: <?php echo $email; ?></div>
                    </div>
                </div>

                <!-- Order History -->
                <div id="order-history" class="mt-4 block">
                    <label class="block text-lg">Order History</label>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="box">
                                <div><?php echo $order['productName']; ?> x <?php echo $order['quantity']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>No order history available.</div>
                    <?php endif; ?>
                </div>
                
            </div>
            <!-- end of profile -->
        </div>
        <!-- end of parent -->
    </div>
</body>
</html>