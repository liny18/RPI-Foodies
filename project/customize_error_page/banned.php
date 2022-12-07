<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
    <title>You're banned</title>
    <link rel="stylesheet" href="./error_style.css">
    <script defer src="https://kit.fontawesome.com/bb67f860a0.js" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
<header>
    <?php include '../header.php'; ?>
</header>


<div class="error">
    <img src="./error.png" alt="error" id="error_image">
    <br>
    <br>
    <h1>Your banned</h1>
    <br>
    <?php
        @session_start();

        $servername = "localhost";
        $database = "rpiFoodies";
        $username = "root";
        $password = "";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        $userID = $_SESSION["userID"];
        $sql = $conn->prepare("SELECT * FROM users WHERE userID = :userID");
        $sql->execute([":userID" => $userID]);
        $result = $sql->fetch();
        $time = $result[0]["DateBanned"];

        $currentDate = date("Y-m-d");
        $days = $time - $currentDate;
        echo '<p>You have been banned, please wait for ' . $days . ' to gain acccess to your account</p>';
    ?>
</div>


<footer>
    <?php include '../footer.html'; ?>
</footer>
</body>
</html>