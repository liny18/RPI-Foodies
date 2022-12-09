<?php
@session_start();

include '../time_function/time.php';

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

if ($_SESSION['type'] == 1) {
    $j = $_SESSION['i'] + 1;
    $len = $_SESSION['len'];
    $row = $_SESSION['rows'];
    if ($j > $len) {
        echo -1;
    }

    for ($i = $j; $i < $j + 10 && $i < $len; $i++) {
        // should only match if the userID, main Comment has some similar word, location is the same, tags are the same
        // or the foodName is the same as the search item
        if (str_contains($row[$i]['userID'], $_SESSION['query']) || str_contains(strtolower($row[$i]['mainComment']), $_SESSION['query']) || str_contains(strtolower($row[$i]['location']), $_SESSION['query']) || str_contains(strtolower($row[$i]['tag1']), $_SESSION['query']) || str_contains(strtolower($row[$i]['foodName']), $_SESSION['query'])) {
            $liked = $conn->prepare("SELECT * FROM likes WHERE postID = :postID AND userID = :userID");
            $liked->execute([":postID" => $row[$i]['postID'], ":userID" => $_SESSION['userID']]);
            echo '<div class="card text-center">';
            echo '<div class="card-header p-2"> <div class="location p-2">';
            echo '<i class="fa-solid fa-location-arrow"></i> ' . $row[$i]['location'] . '</div>';
            echo '<p class="time"><i class="fa-solid fa-clock"></i> ' . calculate_time($row[$i]['postTime']) . '</p>';
            echo '</div>';
            echo '<img class="card-img-top" src="../postImages/' . $row[$i]['postPhoto'] . '"alt="Card image">';
            echo '<div class="card-body"><h5 class="card-title"><i class="fa-solid fa-tags"></i> ';
            echo $row[$i]['tag1'] . '</h5>';
            echo '<p class="card-text">';
            echo '<i class="fa-solid fa-quote-left"></i> ';
            echo $row[$i]['mainComment'];
            echo ' <i class="fa-solid fa-quote-right"></i></p></div>';
            echo '<div class="card-footer d-flex justify-content-between pl-5 pr-5">';
            echo '<button class="like ';
            $count = $liked->fetchAll();
            if (count($count) != 0) {
                echo 'liked-this-post';
            }
            echo '" onclick="likeCounter(' . $row[$i]['postID'] . ', ' . $_SESSION['userID'];
            echo ', this)"><i class="fa-regular fa-heart';
            echo '"></i> ' . $row[$i]['likes'] . ' likes</button>';
            echo '<div class="comment"><i class="fa-regular fa-comment"></i> ';
            echo 'comments</div></div></div>';
        }
    }
    $_SESSION['i'] = $i;

} else if ($_SESSION['type'] == 2) {
    $j = $_SESSION['i'] + 1;
    $len = $_SESSION['len'];
    $row = $_SESSION['rows'];
    if ($j > $len) {
        echo -1;
    }
    for ($i = $j; $i < $j + 10 && $i < $len; $i++) {
        $liked = $conn->prepare("SELECT * FROM likes WHERE postID = :postID AND userID = :userID");
        $liked->execute([":postID" => $row[$i]['postID'], ":userID" => $_SESSION['userID']]);
        echo '<div class="card text-center">';
        echo '<div class="card-header p-2"> <div class="location p-2">';
        echo '<i class="fa-solid fa-location-arrow"></i> ' . $row[$i]['location'] . '</div>';
        echo '<p class="time"><i class="fa-solid fa-clock"></i> ' . calculate_time($row[$i]['postTime']) . '</p>';
        echo '</div>';
        echo '<img class="card-img-top" src="../postImages/' . $row[$i]['postPhoto'] . '"alt="Card image">';
        echo '<div class="card-body"><h5 class="card-title"><i class="fa-solid fa-tags"></i> ';
        echo $row[$i]['tag1'] . '</h5>';
        echo '<p class="card-text"><i class="fa-solid fa-quote-left"></i> ';
        echo $row[$i]['mainComment'];
        echo ' <i class="fa-solid fa-quote-right"></i></p></div>';
        echo '<div class="card-footer d-flex justify-content-between pl-5 pr-5">';
        echo '<button class="like ';
        $count = $liked->fetchAll();
        if (count($count) != 0) {
            echo 'liked-this-post';
        }
        echo '" onclick="likeCounter(' . $row[$i]['postID'] . ', ' . $_SESSION['userID'];
        echo ', this)"><i class="fa-regular fa-heart';
        echo '"></i> ' . $row[$i]['likes'] . ' likes</button>';
        echo '<div class="comment"><i class="fa-regular fa-comment"></i> ';
        echo 'comments</div></div></div>';
    }
    $_SESSION['i'] = $i;

} else if ($_SESSION['type'] == 3) {
    $j = $_SESSION['i'] + 1;
    $len = $_SESSION['len'];
    $row = $_SESSION['rows'];
    if ($j > $len) {
        echo -1;
    }
    for ($i = $j; $i < $j + 10 && $i < $len; $i++) {
        $liked = $conn->prepare("SELECT * FROM likes WHERE postID = :postID AND userID = :userID");
        $liked->execute([":postID" => $row[$i]['postID'], ":userID" => $_SESSION['userID']]);
        echo '<div class="card text-center">';
        echo '<div class="card-header p-2"> <div class="location p-2">';
        echo '<i class="fa-solid fa-location-arrow"></i> ' . $row[$i]['location'] . '</div>';
        echo '<p class="time"><i class="fa-solid fa-clock"></i> ' . calculate_time($row[$i]['postTime']) . '</p>';
        echo '</div>';
        echo '<img class="card-img-top" src="../postImages/' . $row[$i]['postPhoto'] . '"alt="Card image">';
        echo '<div class="card-body"><h5 class="card-title"><i class="fa-solid fa-tags"></i> ';
        echo $row[$i]['tag1'] . '</h5>';
        echo '<p class="card-text">';
        echo '<i class="fa-solid fa-quote-left"></i> ';
        echo $row[$i]['mainComment'];
        echo ' <i class="fa-solid fa-quote-right"></i></p></div>';
        echo '<div class="card-footer d-flex justify-content-between pl-5 pr-5">';
        echo '<button class="like ';
        $count = $liked->fetchAll();
        if (count($count) != 0) {
            echo 'liked-this-post';
        }
        echo '" onclick="likeCounter(' . $row[$i]['postID'] . ', ' . $_SESSION['userID'];
        echo ', this)"><i class="fa-regular fa-heart';
        echo '"></i> ' . $row[$i]['likes'] . ' likes</button>';
        echo '<div class="comment"><i class="fa-regular fa-comment"></i> ';
        echo 0 . ' comments</div></div></div>';
    }
    $_SESSION['i'] = $i;
}

?>