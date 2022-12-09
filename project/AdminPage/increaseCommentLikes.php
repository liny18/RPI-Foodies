<?php
@session_start();
if (isset($_SESSION['Banned'])) {
    header("Location: ../errorPage/banned.php");
}
// a function to increase or decrease the like counter by 1 or maybe leave it the same
$userID = $_GET['userID'];
$userID = htmlspecialchars(trim($userID));
if ($userID != $_SESSION['userID']) {
    echo -1;
    exit;
}
$commentID = $_GET['commentID'];
$commentID = htmlspecialchars(trim($commentID));
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
$likes = $conn->prepare("SELECT likes FROM Comments WHERE commentID = :commentID");
$likes->execute([":commentID" => $commentID]);
// make sure the  commentID is valid
if ($likes->rowCount() == 0) {
    echo -1;
    exit;
}

// check to see who has liked the post
$liked = $conn->prepare("SELECT * FROM commentLikes WHERE commentID = :commentID AND userID = :userID");
$liked->execute([":commentID" => $commentID, ":userID" => $userID]);
$actual = $conn->prepare("SELECT likes FROM Comments WHERE commentID = :commentID");
$actual->execute([":commentID" => $commentID]);
$numLikes = $actual->fetch(PDO::FETCH_ASSOC);
$numLikes = $numLikes['likes'];

// if the user has liked the post, unlike it
if ($liked->rowCount() != 0) {
    $decrease = $conn->prepare("DELETE FROM commentLikes WHERE commentID = :commentID AND userID = :userID");
    $decrease->execute([":commentID" => $commentID, ":userID" => $userID]);
    $numLikes--;
} else {
    // if the user has not liked the post, like it
    $increase = $conn->prepare("INSERT INTO commentLikes (userID, commentID) VALUES (:userID, :commentID)");
    $increase->execute([":userID" => $userID, ":commentID" => $commentID]);
    $numLikes++;
}

// update the like count
$update = $conn->prepare("UPDATE Comments SET likes = :likes WHERE commentID = :commentID");
$update->execute([":likes" => $numLikes, ":commentID" => $commentID]);
echo $numLikes;

?>