<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
    <title>RPI Foodies</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./login.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body>
    <div id="content-wrap">
        <header>
            <?php include '../headerLogin.php'; ?>
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
                            try {
                                // connect to database using pdo
                                $db = new PDO('mysql:host=localhost;dbname=rpiFoodies', 'root', '');
                                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            } catch (PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }

                            // get the user's username, this is the RCS id of the user, this is the userID in the table
                            $username = phpCAS::getUser();
                            // check if the userID is already in the database, if not, insert the userID into the database, and make the username same with the userID as default
                            // if the userID is already in the database, do nothing
                            $sql = $db->prepare("SELECT * FROM users WHERE username = :username");
                            $sql->execute([":username" => $username]);
                            $result = $sql->fetch();
                            if ($result[0] == 0) {
                                $sql = $db->prepare("INSERT INTO users (username, admin) VALUES (:username, 0)");
                                $sql->execute([":username" => $username]);
                            }

                            // get the userID from the database
                            $sql = $db->prepare( "SELECT * FROM users WHERE username = :username");
                            $result = $sql->execute([":username" => $username]);
                            $row = $sql->fetch();
                            $_SESSION['userID'] = $row['userID'];
                            $_SESSION['userName'] = $row['userName'];
                            $_SESSION['admin'] = $row['admin'];

                            $date = date("Y-m-d");
                            if($date > $row['DateBanned']){
                                if($row['BannedPosts'] <= 0){
                                    $sql = $db->prepare( "UPDATE users SET BannedPosts = 3 WHERE username = :username");
                                    $result = $sql->execute([":username" => $username]);
                                }
                                echo "<script>window.location.href='../main/main.php';</script>";
                                exit;
                            } else {
                                header("Location: ../errorPage/banned.php");
                            }
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
    </div>
    <footer>
        <?php include '../footer.html'; ?>
    </footer>

</body>

</html>