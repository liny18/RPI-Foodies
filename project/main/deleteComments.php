<?php

@session_start();
//get user id
$userID = $_SESSION['userID'];
$userID = htmlspecialchars(trim($userID));
if ($userID != $_SESSION['userID']) {
    echo -1;
    exit;
}

// connect to database using pdo
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

// get the commentID
$commentID = $_GET['commentID'];
$commentID = htmlspecialchars(trim($commentID));



// delete all the commentLikes
$conn->prepare("DELETE FROM CommentLikes WHERE commentID = :commentID")->execute([":commentID" => $commentID]);

$conn->prepare("DELETE FROM Comments WHERE commentID = :commentID")->execute([":commentID" => $commentID]);

header("Location: ../main/main.php");

?>
