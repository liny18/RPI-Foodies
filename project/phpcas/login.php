<?php
include_once("./CAS-1.4.0/CAS.php");
phpCAS::client(CAS_VERSION_2_0, 'cas.auth.rpi.edu', 443, '/cas');

// This is not recommended in the real world!
// But we don't have the apparatus to install our own certs...
phpCAS::setNoCasServerValidation();

if (!phpCAS::isAuthenticated()) {
  phpCAS::forceAuthentication();
} else {
  try {
    // connect to database using pdo
    $db = new PDO('mysql:host=localhost;dbname=rpiFoodies', 'phpmyadmin', 'Err0rC@ts2022');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  // check the connection

  // get the user's username, this is the RCS id of the user, this is the userID in the table
  $username = phpCAS::getUser();
  // check if the userID is already in the database, if not, insert the userID into the database, and make the username same with the userID as default
  $sql = "SELECT * FROM users WHERE userID = '$username'";
  $result = $db->query($sql);
  if ($result->rowCount() == 0) {
    $user = $sql->prepare("INSERT INTO users (username, admin) VALUES (:username, 0)");
    $user->execute([':username' => $username]);
  }
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = $db->query($sql);
  // set the session variable to the userID
  $_SESSION['userID'] = $result['userID'];

  // temporary return address, go back to index.php in php cas system, need to change later when user can have their own page
  header('Location: index.php');
}
?>