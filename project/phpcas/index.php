<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
    <title>RPI Foodies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="./login.css">
    <script src="./login.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <?php include '../header.php'; ?>
    </header>

    <main>
        <h1 class="main-slogan"> RPI Foodies, find out what you love!</h1>
        <div class="row">
            <div class="colm-logo">
                <img src="../pictures/RPIFoodies.png" alt="Logo" class="team-logo">
            </div>
            <div class="colm-form">
                <div class="form-container">
                    <?php
                    include_once("./CAS-1.4.0/CAS.php");
                    phpCAS::client(CAS_VERSION_2_0, 'cas.auth.rpi.edu', 443, '/cas');

                    // This is not recommended in the real world!
                    // But we don't have the apparatus to install our own certs...
                    phpCAS::setNoCasServerValidation();

                    if (phpCAS::isAuthenticated()) {
                        header("Location: ../main/main/php");
                    } else {
                        echo "<a href='login.php' class='login_button'>Login</a>";
                    }
                    ?>
                    <p class="cas_info">*This website is connected to RPI CAS login system, you need to have a RPI
                        account to login.</p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include '../footer.html'; ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>