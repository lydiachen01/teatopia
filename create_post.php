<?php

// Start the session
session_start();

// Assuming you have a database connection
$servername = "localhost";
$username = "u9rnmkwnhqk3j";
$password = "@*2l@2f7i%&2";
$dbname = "dbygr11xzpv4y";

$conn = new mysqli($servername, $username, $password, $dbname);


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch user data based on user ID
    $selectUserQuery = "SELECT * FROM user_table WHERE userID = $userId";
    $result = $conn->query($selectUserQuery);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];

        $content = $_POST['content'];

        if ($content) {
            // Insert post data into post_table
            $postInsertQuery = "INSERT INTO post_table (content, userID) VALUES ('$content', '$userId')";
            $conn->query($postInsertQuery);

            // Fetch the inserted post for response
            $postId = $conn->insert_id;
            $selectPostQuery = "SELECT * FROM post_table WHERE postID = $postId";
            $result = $conn->query($selectPostQuery);

            if ($result->num_rows > 0) {
                $post = $result->fetch_assoc();
                echo json_encode($post);
            } else {
                echo json_encode(['error' => 'Error fetching post']);
            }
        } else {
            echo json_encode(['error' => 'Invalid input']);
        }
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}

// Close the database connection
$conn->close();

?>
