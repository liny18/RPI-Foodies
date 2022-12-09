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
// get the postID
$postID = $_GET['postID'];
$postID = htmlspecialchars(trim($postID));

$conn->prepare("DELETE FROM Comments WHERE commentID = :commentID AND postID = :postID")->execute([":commentID" => $commentID]);

?>
