<?php
session_start();

// Variable innitialisation

/* $username = "";
$email = "";
$password1 = "";
$password2 = ""; */

$username = $_POST['username'];
$email = $_POST['email'];
$password1 = $_POST['password_1'];
$password2 = $_POSTT['password_2'];

$errors = array();

// Database connection

$db = mysqli_connect("localhost", "root", "", "elearning") or die("Error! Couldn't connect to the specified database...");

// Trying the registration of users

$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

// Form validation

if (empty($username)){
    array_push($errors, "Username is required!");
}

if (empty($email)){
    array_push($errors, "Email is required!");
}

if (empty($password_1)){
    array_push($errors, "Password is required!");
}

if ($password_1 != $password_2){
    array_push($errors, "Baka! don't you see the passwords don't match!");
}

// Check if the existing users have the same username and *...

$user_check_query = "SELECT * FROM students WHERE username = '$username' OR email = '$email' LIMIT 1";
$results = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($results);

if ($user){
    if ($user['username'] === $username){
        array_push($errors, "User with similar username already exists, find a different username...");
    }

    if ($email['email'] === $email){
        array_push($errors, "User with the same email already exists, use a different email...");
    }
}

// Proceed to user registration if no error is encountered
if (count($errors) == 0){
    $password = md5($password_1); // This will encrypt the password
    $query = "INSERT INTO students (username, email, password) VALUES ('$username', '$email', '$password')";
    mysqli_query($db, $query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "Welcome to eLearning library...";
    header('location: registered.php');
}

?>