<?php
$server = "localhost";
$username = "u9rnmkwnhqk3j";
$password = "@*2l@2f7i%&2";
$database = "dbygr11xzpv4y";

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT productName, description, image FROM product_table";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the data and store it in an array
    $products = array();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Output the products as JSON
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    // No products found
    echo "No products found in the database.";
}

// Close the database connection
$conn->close();
?>
