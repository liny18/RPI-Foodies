<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
    <title>RPI Foodies</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="./login.css">
    <script src="./login.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar navbar-expand-md sticky-top navbar-light header">
        <a class="navbar-brand refresh" href="../main/main.html">
        <img src="../pictures/RPIFoodies.png" alt="Error Cats logo" width="40" height="40" style="border-radius: 50%;">
        RPI Foodies
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline justify-content-center align-items-center container">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">
                <img src="../pictures/search_ideogram.svg" alt="Magnifying glass" width="30" height="30">
            </button>
        </form>
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item trending">
                <a href="#" class="navbar-brand">
                    <img src="../pictures/trendingIcon.svg" alt="trending button" width="40" height="40">
                </a>
            </li>
            <li class="nav-item post">
                <a href="../uploadPage/upload.html" class="navbar-brand">
                    <img src="../pictures/addPostIcon.svg" alt="add post button" width="40" height="40">
                </a>
            </li>
            <li class="nav-item">
                <a href="../project-login/create.html" class="btn btn-dark" role="button">Sign Up</a>
            </li>
        </ul>
        </div>
    </nav>

    <main>
        <h1 class="main-slogan"> RPI Foodies, find out what you love!</h1>
        <div class="row">
            <div class="colm-logo">
                <img src="../pictures/RPIFoodies.png" alt="Logo" class="team-logo">
            </div>
            <div class="colm-form">
                <div class="form-container">
                    <form name="myform" onsubmit="validate()">
                    <input type="text" placeholder="Enter your RCS ID to login" name="RCS">
                    <input type="password" placeholder="Password" name="Password">
                    <button type ="submit" class="btn btn-login" onclick="login()">Login</button>
                    </form>
                    <button class="btn btn-new" onclick="create()">Create new Account</button>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container foot">
          <div class="foot-container d-flex justify-content-between">
            <div class="d-flex align-content-center">
              <a href="#">
                <img src="../pictures/logo.png" alt="team-logo" class="foot-logo">
              </a>
              <p class="pl-3" >© 2022 ErrorCats</p>
            </div>
            <a href="https://github.com/RPI-ITWS/ITWS2110-F22-ErrorCats" target="_blank">
              <img class="foot-logo" src="../pictures/git.png" alt="git-link">
            </a>
          </div>
        </div>
      </footer>
      <?php
include_once("./CAS-1.4.0/CAS.php");
phpCAS::client(CAS_VERSION_2_0,'cas.auth.rpi.edu',443,'/cas');

// This is not recommended in the real world!
// But we don't have the apparatus to install our own certs...
phpCAS::setNoCasServerValidation();

if (phpCAS::isAuthenticated()) {
  echo "User: " . phpCAS::getUser();
  echo "<a href='logout.php'>Logout</a>";
} else {
  echo "<a href='login.php'>Login</a>";
}
?>

</body>
</html>
