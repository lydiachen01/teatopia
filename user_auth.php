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
        $status = 'success';
        header("Location: user_profile.html");
    } else {
        // Authentication failed
        $status = 'failure';
        header("Location: login.html?status=$status");
    }
}