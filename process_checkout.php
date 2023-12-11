<?php
// Connect to the database
$conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// function to get the currently logged-in user ID
$userID = $_SESSION['userID'];; 

// Retrieve shipping address and cart data from the form
$shippingAddress = $_POST['shippingAddress'];
$cartData = json_decode($_POST['cartData'], true);

// Insert data into the Order table
$sqlOrder = "INSERT INTO `Order` (userID, shippingAddress) VALUES ($userID, '$shippingAddress')";
$conn->query($sqlOrder);

// Retrieve the auto-generated orderID
$orderID = $conn->insert_id;

// Insert order items into the OrderItem table
foreach ($cartData as $productName => $quantity) {
    // Retrieve productID from the Product table based on productName
    $sqlProductID = "SELECT productID FROM Product WHERE productName = '$productName'";
    $result = $conn->query($sqlProductID);
    $row = $result->fetch_assoc();
    $productID = $row['productID'];

    // Insert data into the OrderItem table
    $sqlOrderItem = "INSERT INTO OrderItem (orderID, productID, quantity) VALUES ($orderID, $productID, $quantity)";
    $conn->query($sqlOrderItem);
}

// Calculate total price for the order
$totalPrice = calculateTotalPrice($cartData);

// Update the price field in the Order table
$sqlUpdateOrder = "UPDATE `Order` SET price = $totalPrice WHERE orderID = $orderID";
$conn->query($sqlUpdateOrder);

// Close the database connection
$conn->close();

// Redirect to the thank-you page or order confirmation page
header("Location: thank_you_page.php");
exit();

function calculateTotalPrice($cartData) {
    $totalPrice = 0;

    foreach ($cartData as $productName => $quantity) {
        // Retrieve product price from the Product table based on productName
        $sqlProductPrice = "SELECT price FROM Product WHERE productName = '$productName'";
        $result = $conn->query($sqlProductPrice);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $productPrice = $row['price'];
            $totalPrice += $productPrice * $quantity;
        }
    }

    return $totalPrice;
}
?>
