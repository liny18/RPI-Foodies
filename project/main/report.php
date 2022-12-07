<?php
@session_start();
// a function to increase or decrease the like counter by 1 or maybe leave it the same
$userID = $_GET['userID'];
if ($userID != $_SESSION['userID']) {
    echo -1;
    exit;
}
$postID = $_GET['postID'];
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

$posts = $conn->prepare("SELECT * FROM Reports WHERE postID = $postID");
$posts->execute();
$rows = $posts->fetchAll();
$len = count($rows);
if($len == 0){
  $sql = "INSERT INTO Reports (userID, postID) VALUES (".$userID.",".$postID.")";
  $insert = $conn->prepare($sql);
  $insert->execute();
}

?>