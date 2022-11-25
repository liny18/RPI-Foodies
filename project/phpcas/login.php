<?php
include_once("./CAS-1.4.0/CAS.php");
phpCAS::client(CAS_VERSION_2_0,'cas.auth.rpi.edu',443,'/cas');

// This is not recommended in the real world!
// But we don't have the apparatus to install our own certs...
phpCAS::setNoCasServerValidation();

if (!phpCAS::isAuthenticated()) {
  phpCAS::forceAuthentication();
} else {
  // connect to database using pdo
  $db = new PDO('mysql:host=localhost;dbname=rpiFoodies', 'phpmyadmin', 'Err0rC@ts2022');
// check the connection
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }
// get the user's username, this is the RCS id of the user, this is the userID in the table
  $username = phpCAS::getUser();
// check if the userID is already in the database, if not, insert the userID into the database, and make the username same with the userID as default
  $sql = "SELECT * FROM users WHERE userID = '$username'";
  $result = $db->query ($sql);
  if ($result->rowCount() == 0) {
    $sql = "INSERT INTO users (userID, username) VALUES ('$username', '$username')";
    $db->query ($sql);
  }
  // temporary return address, go back to index.php in php cas system, need to change later when user can have their own page
  header('Location: index.php');
}
?>
