<style>
    header {
        box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.3);
        background-color: #f04320;
        padding: 5px;
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

<?php
@session_start();

if(array_key_exists('submitSearch', $_POST)){
    $_SESSION['isSearch'] = true;
    $_SESSION['query'] = strtolower($_POST['search']);
    header("Location: main/main.php");
}

?>

<nav class="navbar navbar-expand-lg sticky-top navbar-light">
    <a class="navbar-brand" href="../main/main.php">
        <img src="../pictures/logo.png" alt="Error Cats logo" width="40" height="40" style="border-radius: 50%;">
        RPI Foodies
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline justify-content-center align-items-center container" method="post" action="../header.php">
            <div class="row">
                <div class="col-11">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                </div>
                <div class="col-1">
                    <button class="btn btn-outline-light" type="submit" name="submitSearch" id="submitSearch" value="submitSearch">
                        <img src="../pictures/search_ideogram.svg" alt="Magnifying glass" width="30" height="30">
                    </button>
                </div>
            </div>
        </form>
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item trending">
                <a href="../Dining Hall Page/index.php" class="navbar-brand">
                    <img src="../pictures/trendingIcon.svg" alt="trending button" width="40" height="40">
                </a>
            </li>
            <li class="nav-item post">
                <a href="../uploadPage/upload.php" class="navbar-brand">
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
</nav>