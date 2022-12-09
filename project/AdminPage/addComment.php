<?php
include '../errorPage/check_if_banned.php';
include "../time_function/time.php";

@session_start();

// a function to increase or decrease the like counter by 1 or maybe leave it the same
$userID = $_GET['userID'];
$userID = htmlspecialchars(trim($userID));
if ($userID != $_SESSION['userID']) {
    echo -1;
    exit;
}

function sanitize_xss($value) {
    return htmlspecialchars(strip_tags($value));
}

$postID = $_GET['postID'];
$postID = sanitize_xss(trim($postID));

// get comment
$comment = $_GET['comment'];
$comment = sanitize_xss(trim($comment));

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

// check to make sure the postID is valid
$check = $conn->prepare("SELECT * FROM Posts WHERE postID = :postID");
$check->execute([":postID" => $postID]);
if ($check->rowCount() == 0) {
    echo -1;
    exit;
}

// get the US time
date_default_timezone_set('America/New_York');
$commentTime = date("Y-m-d H:i:s");

// add the comment
$add = $conn->prepare("INSERT INTO Comments (postID, comment, userID, likes, commentTime) VALUES (:postID, :comment, :userID, 0, :commentTime)");
$add->execute([":postID" => $postID, ":comment" => $comment, ":userID" => $userID, ":commentTime" => $commentTime]);

// get the commentID
$commentID = $conn->lastInsertId();
// print out the comment
echo '<div class="card mb-3">';
echo '<div class="card-body">';
echo '<div class="d-flex flex-start">';
echo '<div class="w-100">';
echo '<div class="d-flex text-start flex-column">';
echo '<div>';
echo '<h6 class="color fw-bold">';
// username goes here
// also grab username from users table
$user = $conn->prepare('SELECT * FROM users WHERE userID = :userID');
$user->execute(['userID' => $userID]);
$user = $user->fetch();
echo $user['username'];
echo '</h6>';
echo '</div>';
echo '<div class="border-top border-bottom pt-2 pb-2">';
echo '<p class="mb-0">';
// comment goes here
echo $comment;
echo '</p>';
echo '</div>';
echo '<div>';
echo '<p class="small text-secondary mb-1">';
// date goes here
$temp = $commentTime;
$temp_out = calculate_time($temp);
echo $temp_out;
echo '</p>';
echo '</div>';
echo '</div>';
echo '<div class="d-flex justify-content-between align-items-center">';
echo '<div class="semi-like border-0 p-0 bg-transparent">';
echo '<i class="fa-regular fa-heart"></i>';
echo '</div>';
echo '<div>';
echo '<button class="del btn btn-link p-0 text-danger text-decoration-none">';
// link to deleteComment.php to delete the comment
echo '<a class="commentA text-danger text-decoration-none" href="deleteComments.php?commentID=' . $commentID . '&postID=' . $postID . '">Delete</a>';
echo '</button>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

?>