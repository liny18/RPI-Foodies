<?php
include_once("./CAS-1.4.0/CAS.php");
phpCAS::client(CAS_VERSION_2_0,'cas.auth.rpi.edu',443,'/cas');

// This is not recommended in the real world!
// But we don't have the apparatus to install our own certs...
phpCAS::setNoCasServerValidation();

if (!phpCAS::isAuthenticated()) {
  phpCAS::forceAuthentication();
} else {
  // temporary return address, go back to index.php in php cas system, need to change later when user can have their own page
  header('Location: index.php');
}
?>
