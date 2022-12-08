<?php
@session_start();
if (isset($_SESSION['Banned'])) {
    header("Location: ../errorPage/banned.php");
}
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

// get the current like count
$likes = $conn->prepare("SELECT likes FROM Posts WHERE postID = :postID");
$likes->execute([":postID" => $postID]);
// make sure the postID is valid
if ($likes->rowCount() == 0) {
    echo -1;
    exit;
}

// check to see who has liked the post
$liked = $conn->prepare("SELECT * FROM likes WHERE postID = :postID AND userID = :userID");
$liked->execute([":postID" => $postID, ":userID" => $userID]);
$actual = $conn->prepare("SELECT likes FROM Posts WHERE postID = :postID");
$actual->execute([":postID" => $postID]);
$numLikes = $actual->fetch(PDO::FETCH_ASSOC);
$numLikes = $numLikes['likes'];

// if the user has liked the post, unlike it
if ($liked->rowCount() != 0) {
    $decrease = $conn->prepare("DELETE FROM likes WHERE postID = :postID AND userID = :userID");
    $decrease->execute([":postID" => $postID, ":userID" => $userID]);
    $numLikes--;
} else {
    // if the user has not liked the post, like it
    $increase = $conn->prepare("INSERT INTO likes (postID, userID) VALUES (:postID, :userID)");
    $increase->execute([":postID" => $postID, ":userID" => $userID]);
    $numLikes++;
}

// update the like count
$update = $conn->prepare("UPDATE Posts SET likes = :likes WHERE postID = :postID");
$update->execute([":likes" => $numLikes, ":postID" => $postID]);
echo $numLikes;


?>