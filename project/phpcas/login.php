<?php
include_once("./CAS-1.4.0/CAS.php");
phpCAS::client(CAS_VERSION_2_0, 'cas.auth.rpi.edu', 443, '/cas');

// This is not recommended in the real world!
// But we don't have the apparatus to install our own certs...
phpCAS::setNoCasServerValidation();

if (!phpCAS::isAuthenticated()) {
    // not login yet
  phpCAS::forceAuthentication();
} else {
    // already login
    //back to index.php
    header('Location: ./index.php');

}
?>