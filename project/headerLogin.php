<?php
@session_start();

if(array_key_exists('submitSearch', $_POST)){
    $_SESSION['isSearch'] = true;
    $_SESSION['query'] = strtolower($_POST['search']);
    header("Location: main/main.php");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <style>
            nav {
                box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.3);
                background-color: #f04320;
                padding: 5px;
            }

            .navbar .navbar-nav {
            display: inline-block;
            float: none;
            }

            .navbar .navbar-nav .nav-item{
            display: inline-block;
            margin-top: 10px;
            }

            .navbar .navbar-collapse {
            text-align: center;
            }

            .trending,
            .post,
            .navbar-brand {
                transition: 0.5s;
            }

            .trending:hover,
            .post:hover,
            .navbar-brand:hover {
                transform: scale(1.1);
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container-fluid">
            <a class="navbar-brand" href="../main/main.php">
                <img src="../pictures/logo.png" alt="Error Cats logo" width="40" height="40" style="border-radius: 50%;">
                RPI Foodies
            </a>
            <form class="d-flex" method="post" action="../header.php">
                <div class="row">
                    <div class="col">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    </div>
                    <div class="col">
                        <button class="btn btn-outline-light" type="submit" name="submitSearch" id="submitSearch" value="submitSearch" title="Search">
                            <img src="../pictures/search_ideogram.svg" alt="Magnifying glass" width="25" height="25">
                        </button>
                    </div>
                </div>
            </form>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
                <ul class="navbar-nav">
                <li class="nav-item trending">
                    <a href="../Dining Hall Page/index.php" class="navbar-brand" title="Dinning Halls">
                        <img src="../pictures/trendingIcon.svg" alt="trending button" width="40" height="40">
                    </a>
                </li>
                <li class="nav-item post">
                    <a href="../uploadPage/upload.php" class="navbar-brand" title="Upload">
                        <img src="../pictures/addPostIcon.svg" alt="add post button" width="40" height="40">
                    </a>
                </li>
                <li class="nav-item logOut">
                    <a href="../phpcas/logout.php" class="navbar-brand">
                        <button id="logOut" class="btn btn-outline-light" type="submit">Log Out</button>
                    </a>
                </li>
                </ul>
            </div>
            </div>
        </nav>
    </body>
</html>