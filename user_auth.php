<?php
session_start();

// Dummy data
$users = [
    'a@a.com' => 'pumpkin',
    'user2' => 'password2'
];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Validate the credentials
    if (isset($users[$username]) && $users[$username] === $password) {
        // Authentication passed
        $_SESSION['email'] = $username;
        echo 'Login successful';
    } else {
        // Authentication failed
        echo 'Invalid email or password';
    }
}
?>

<!-- Previous Node Attempt -->

<!-- document.querySelector('.btn').addEventListener('click', (e) => {
            e.preventDefault();
            const email = document.querySelector('#email').value;
            const password = document.querySelector('#password').value;
                        
            console.log(email);
            console.log(password);
        
            fetch('http:/.127.0.0.1:5500/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email,
                    password,
                })
            })
            .then((data) => {
                if (data) {
                    console.log("This is data:", data);
                    return data;
                } else {
                    console.log('No JSON data to parse');
                }
            })
            .catch((error) => console.log(error));            
        });         -->