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

    $sql1 = 'SELECT * FROM users WHERE userID = :task_id';
    $stmt3 = $conn->prepare($sql1);
    $stmt3->bindValue(':task_id', $_SESSION['userID']);
    $stmt3->execute();
    $banned = $stmt3->fetchAll();
    if ($banned[0]['Banned'] == 1) {
      header("Location: ../errorPage/banned.php");
      exit;
    }

?>
