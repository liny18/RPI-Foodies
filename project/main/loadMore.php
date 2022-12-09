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
    $i = $_SESSION['i'] + 1;
    $len = $_SESSION['len'];
    $row = $_SESSION['rows'];
    if ($i > $len) {
        echo -1;
    }
    $result_count = 0;
    for ($i = $i; $result_count < 10 && $i < $len; $i++) {
      // $_SESSION['query'] = sanitize_xss($_SESSION['query']); // only needs to happen once
      $query = $_SESSION['query'];
      // should only match if the userID, main Comment has some similar word, location is the same, tags are the same
      // or the foodName is the same as the search item
      if (str_contains($row[$i]['userID'], $query) || str_contains(strtolower($row[$i]['mainComment']), $query) || str_contains($row[$i]['location'], $query) || str_contains($row[$i]['tag1'], $query) || str_contains($row[$i]['foodName'], $query)) {
        $result_count++;
        $liked = $conn->prepare("SELECT * FROM likes WHERE postID = :postID AND userID = :userID");
        $liked->execute([":postID" => $row[$i]['postID'], ":userID" => $_SESSION['userID']]);
        echo '<div class="card text-center">';
        $sql = 'SELECT * FROM users WHERE userID = :task_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':task_id', $row[$i]['userID']);
        $stmt->execute();
        $user = $stmt->fetchAll();
        echo '<div class="card-header p-2">';
        echo '<div class="d-flex justify-content-between p-1">';
        echo '<form action="../UserPage/index.php?userID=' . $row[$i]['userID'] . '&userName=' . $user[0]['username'] . '" method="post">';
        echo '<button type="submit" name="submit" value="submit" class="btn tbn-link text-decoration-none postRCS">' . $user[0]['username'] . '</button>';
        echo '</form>';

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
          echo '<div class="container d-flex justify-content-end">';
          echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row[$i]['postID'] . '">';
          echo 'Delete';
          echo '</button>';
          echo '<div class="modal fade" id="deleteModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="deleteModalLabel' . $row[$i]['postID'] . '">Delete post?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<form action="main.php" method="post">';
          echo '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
          echo '<button type="submit" name="deleteAdmin" value="deleteAdmin" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
          echo '</form>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#banModal' . $row[$i]['postID'] . '">';
          echo 'Ban User';
          echo '</button>';
          echo '<div class="modal fade" id="banModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="banModalLabel' . $row[$i]['postID'] . '">Ban ' . $user[0]['username'] . '?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<form class="me-3" action="main.php" method="post">';
          echo  '<input type="hidden" name="userID" value=" ' . $row[0]['userID'] . '"/>';
          echo '<button type="submit" name="ban" value="ban" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
          echo '</form>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        } else {
          if($row[$i]['userID'] == $_SESSION['userID']){
            echo '<div class="container d-flex justify-content-end">';
            echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">';
            echo 'Delete';
            echo '</button>';
            echo '<div class="modal fade" id="deleteModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog modal-sm">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="deleteModalLabel' . $row[$i]['postID'] . '">Delete post?</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<div class="container d-flex flex-row justify-content-center">';
            echo '<form action="main.php" method="post">';
            echo '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
            echo '<button type="submit" name="delete" value="delete" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
            echo '</form>';
            echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>'; 
            echo '</div>';
          } else {
            echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#reportModal' . $row[$i]['postID'] . '">';
            echo 'Report';
            echo '</button>';
            echo '<div class="modal fade" id="reportModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog modal-sm">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="reportModalLabel' . $row[$i]['postID'] . '">Report post?</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<div class="container d-flex flex-row justify-content-center">';
            echo '<button type="button" class="me-3 btn btn-outline-danger" onclick="report(' . $row[$i]['postID'] . ", " . $_SESSION['userID'] . ', this)" data-bs-dismiss="modal">Yes</button>';
            echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>'; 
          }
        }
        echo '</div>';
        echo '<div class="location p-2">';
        echo '<i class="fa-solid fa-location-arrow"></i> ' . $row[$i]['location'] . '</div>';
        echo '<p class="time mt-1"><i class="fa-solid fa-clock pt-1"></i> ' . calculate_time($row[$i]['postTime']) . '</p>';
        echo '</div>';
        echo '<div>';
        echo '<h5 class="card-title"><i class="fa-solid fa-utensils me-2 mt-2"></i>';
        echo $row[$i]["foodName"];
        echo '</h5>';
        echo '</div>';
        echo '<img class="card-img-top mt-0" src="../postImages/' . $row[$i]['postPhoto'] . '"alt="Card image">';
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
        // modal for comments that pops up and displays
        echo '<div class="comment" data-bs-toggle="modal" data-bs-target="#commentModal' . $row[$i]['postID'] . ' "><i class="fa-regular fa-comment"></i> ';
        echo ' comments</div></div>';
        //modal
        echo '<div class="modal fade" id="commentModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">';
        echo '<h1 class="modal-title fs-5" id="commentModalLabel' . $row[$i]['postID'] . '">Comments</h1>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body" style="background-color: #f7f6f6;">';
        echo '<section>';
        echo '<div class="container">';
        echo '<div class="row d-flex">';
        echo '<div class="comment-container container w-100 d-flex justify-content-between" id="comment' . $row[$i]['postID'] . '">';
        echo '<div class="f">';
        echo '<textarea name="text ' . $row[$i]['postID'] . '" maxlength="255" placeholder="Add Your Comment" id="text' . $row[$i]['postID'] . '"></textarea>';
        echo '<div class="d-flex justify-content-between">';
        echo '<button class="btn btn-dark" onclick="createComt(' . $_SESSION['userID'] . ',' . $row[$i]['postID'] . ',\'text' . $row[$i]['postID'] . '\',\'CommentPlace' . $row[$i]['postID'] . '\')">Comment</button>';
        echo '<div class="d-flex justify-content-between">';
        echo '<div class="card m-0">';
        echo '<div class="card-body p-1 d-flex align-items-center">';
        echo '<h6 class="text-primary fw-bold small mb-0 me-2">Sort by Likes</h6>';
        echo '<div class="form-check form-switch pt-1">';
        echo '<input class="form-check-input" type="checkbox" id="switch' . $row[$i]['postID'] . '" />';
        echo '<label class="form-check-label" for="switch' . $row[$i]['postID'] . '"></label>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-12" id="CommentPlace' . $row[$i]['postID'] . '">';

        // prepare query for comments table
        $comments = $conn->prepare('SELECT * FROM Comments WHERE postID = :postID ORDER BY commentID DESC');
        $comments->execute(['postID' => $row[$i]['postID']]);
        $comments = $comments->fetchAll();
        // commenting starts here
        for ($j = 0; $j < count($comments); $j++) {
          // references commentLikes table to get who liked what comment
          $commentLikes = $conn->prepare('SELECT * FROM commentLikes WHERE commentID = :commentID');
          $commentLikes->execute(['commentID' => $comments[$j]['commentID']]);
          $commentLikes = $commentLikes->fetchAll();
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
          $user->execute(['userID' => $comments[$j]['userID']]);
          $user = $user->fetch();
          echo $user['username'];
          echo '</h6>';
          echo '</div>';
          echo '<div class="border-top border-bottom pt-2 pb-2">';
          echo '<p class="mb-0">';
          // comment goes here
          echo $comments[$j]['comment'];
          echo '</p>';
          echo '</div>';
          echo '<div>';
          echo '<p class="small text-secondary mb-1">';
          // date goes here
          //use time function in time_function, calculate the time difference
          $temp = $comments[$j]['commentTime'];
          $temp_out = calculate_time($temp);
          echo $temp_out;
          echo '</p>';
          echo '</div>';
          echo '</div>';
          echo '<div class="d-flex justify-content-between align-items-center">';
          echo '<div class="semi-like border-0 p-0 bg-transparent">';
          echo '<button class="like ';
          if (count($commentLikes) != 0) {
            echo 'liked-this-post';
          }
          echo '" onclick="likeCounterComment(' . $comments[$j]['commentID'] . ', ' . $_SESSION['userID'];
          echo ', this)"><i class="fa-regular fa-heart';
          echo '"></i></button>';
          echo '</div>';
          echo '<div>';
          // only show delete if the user is the one who posted the comment
          if ($comments[$j]['userID'] == $_SESSION['userID'] || (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)) {
            echo '<button type="button" class="del btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteCommentModal' . $comments[$j]['commentID'] . '">';
            echo 'Delete';
            echo '</button>';
            echo '<div class="modal fade" id="deleteCommentModal' . $comments[$j]['commentID'] . '" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog modal-sm">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="deleteCommentModalLabel' . $comments[$j]['commentID'] . '">Delete comment?</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<div class="container d-flex flex-row justify-content-center">';
            echo '<button class="del btn btn-outline-danger" data-bs-dismiss="modal">';
            // link to deleteComments.php if user click on delete, delete the comment
            echo '<a class="commentA" href="deleteComments.php?commentID=' . $comments[$j]['commentID'] . '">Yes</a>';
            echo '</button>';
            echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        // commenting ends here
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
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
      $sql = 'SELECT * FROM users WHERE userID = :task_id';
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':task_id', $row[$i]['userID']);
      $stmt->execute();
      $user = $stmt->fetchAll();
      echo '<div class="card-header p-2">';
      echo '<div class="d-flex justify-content-between p-1">';
      echo '<form action="../UserPage/index.php?userID=' . $row[$i]['userID'] . '&userName=' . $user[0]['username'] . '" method="post">';
      echo '<button type="submit" name="submit" value="submit" class="btn tbn-link text-decoration-none postRCS">' . $user[0]['username'] . '</button>';
      echo '</form>';
      if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo '<div class="container d-flex justify-content-end">';
        echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row[$i]['postID'] . '">';
        echo 'Delete';
        echo '</button>';
        echo '<div class="modal fade" id="deleteModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog modal-sm">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="deleteModalLabel' . $row[$i]['postID'] . '">Delete post?</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<div class="container d-flex flex-row justify-content-center">';
        echo '<form class="me-3" action="main.php" method="post">';
        echo '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
        echo '<button type="submit" name="deleteAdmin" value="deleteAdmin" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
        echo '</form>';
        echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#banModal' . $row[$i]['postID'] . '">';
        echo 'Ban User';
        echo '</button>';
        echo '<div class="modal fade" id="banModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog modal-sm">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="banModalLabel' . $row[$i]['postID'] . '">Ban ' . $user[0]['username'] . '?</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<div class="container d-flex flex-row justify-content-center">';
        echo '<form class="me-3" action="main.php" method="post">';
        echo  '<input type="hidden" name="userID" value=" ' . $row[0]['userID'] . '"/>';
        echo '<button type="submit" name="ban" value="ban" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
        echo '</form>';
        echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      } else {
        if($row[$i]['userID'] == $_SESSION['userID']){
          echo '<div class="container d-flex justify-content-end">';
          echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">';
          echo 'Delete';
          echo '</button>';
          echo '<div class="modal fade" id="deleteModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="deleteModalLabel' . $row[$i]['postID'] . '">Delete post?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<form class="me-3" action="main.php" method="post">';
          echo '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
          echo '<button type="submit" name="delete" value="delete" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
          echo '</form>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>'; 
          echo '</div>';
        } else {
          echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#reportModal' . $row[$i]['postID'] . '">';
          echo 'Report';
          echo '</button>';
          echo '<div class="modal fade" id="reportModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="reportModalLabel' . $row[$i]['postID'] . '">Report post?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<button type="button" class="me-3 btn btn-outline-danger" onclick="report(' . $row[$i]['postID'] . ", " . $_SESSION['userID'] . ', this)" data-bs-dismiss="modal">Yes</button>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>'; 
        }
      }
      echo '</div>';
      echo '<div class="location p-2">';
      echo '<i class="fa-solid fa-location-arrow"></i> ' . $row[$i]['location'] . '</div>';
      echo '<p class="time mt-1"><i class="fa-solid fa-clock pt-1"></i> ' . calculate_time($row[$i]['postTime']) . '</p>';
      echo '</div>';
      echo '<div>';
      echo '<h5 class="card-title"><i class="fa-solid fa-utensils me-2 mt-2"></i>';
      echo $row[$i]["foodName"];
      echo '</h5>';
      echo '</div>';
      echo '<img class="card-img-top mt-0" src="../postImages/' . $row[$i]['postPhoto'] . '"alt="Card image">';
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
      // modal for comments that pops up and displays
      echo '<div class="comment" data-bs-toggle="modal" data-bs-target="#commentModal' . $row[$i]['postID'] . ' "><i class="fa-regular fa-comment"></i> ';
      echo ' comments</div></div>';
      //modal
      echo '<div class="modal fade" id="commentModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">';
      echo '<h1 class="modal-title fs-5" id="commentModalLabel' . $row[$i]['postID'] . '">Comments</h1>';
      echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
      echo '</div>';
      echo '<div class="modal-body" style="background-color: #f7f6f6;">';
      echo '<section>';
      echo '<div class="container">';
      echo '<div class="row d-flex">';
      echo '<div class="comment-container container w-100 d-flex justify-content-between" id="comment' . $row[$i]['postID'] . '">';
      echo '<div class="f">';
      echo '<textarea name="text ' . $row[$i]['postID'] . '" maxlength="255" placeholder="Add Your Comment" id="text' . $row[$i]['postID'] . '"></textarea>';
      echo '<div class="d-flex justify-content-between">';
      echo '<button class="btn btn-dark" onclick="createComt(' . $_SESSION['userID'] . ',' . $row[$i]['postID'] . ',\'text' . $row[$i]['postID'] . '\',\'CommentPlace' . $row[$i]['postID'] . '\')">Comment</button>';
      echo '<div class="d-flex justify-content-between">';
      echo '<div class="card m-0">';
      echo '<div class="card-body p-1 d-flex align-items-center">';
      echo '<h6 class="text-primary fw-bold small mb-0 me-2">Sort by Likes</h6>';
      echo '<div class="form-check form-switch pt-1">';
      echo '<input class="form-check-input" type="checkbox" id="switch' . $row[$i]['postID'] . '" />';
      echo '<label class="form-check-label" for="switch' . $row[$i]['postID'] . '"></label>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '<div class="col-12" id="CommentPlace' . $row[$i]['postID'] . '">';

      // prepare query for comments table
      $comments = $conn->prepare('SELECT * FROM Comments WHERE postID = :postID ORDER BY commentID DESC');
      $comments->execute(['postID' => $row[$i]['postID']]);
      $comments = $comments->fetchAll();
      // commenting starts here
      for ($j = 0; $j < count($comments); $j++) {
        // references commentLikes table to get who liked what comment
        $commentLikes = $conn->prepare('SELECT * FROM commentLikes WHERE commentID = :commentID');
        $commentLikes->execute(['commentID' => $comments[$j]['commentID']]);
        $commentLikes = $commentLikes->fetchAll();
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
        $user->execute(['userID' => $comments[$j]['userID']]);
        $user = $user->fetch();
        echo $user['username'];
        echo '</h6>';
        echo '</div>';
        echo '<div class="border-top border-bottom pt-2 pb-2">';
        echo '<p class="mb-0">';
        // comment goes here
        echo $comments[$j]['comment'];
        echo '</p>';
        echo '</div>';
        echo '<div>';
        echo '<p class="small text-secondary mb-1">';
        // date goes here
        $temp = $comments[$j]['commentTime'];
        $temp_out = calculate_time($temp);
        echo $temp_out;
        echo '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="d-flex justify-content-between align-items-center">';
        echo '<div class="semi-like border-0 p-0 bg-transparent">';
        echo '<button class="like ';
        if (count($commentLikes) != 0) {
          echo 'liked-this-post';
        }
        echo '" onclick="likeCounterComment(' . $comments[$j]['commentID'] . ', ' . $_SESSION['userID'];
        echo ', this)"><i class="fa-regular fa-heart';
        echo '"></i></button>';
        echo '</div>';
        echo '<div>';
        // only show delete if the user is the one who posted the comment
        if ($comments[$j]['userID'] == $_SESSION['userID'] || (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)) {
          echo '<button type="button" class="del btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteCommentModal' . $comments[$j]['commentID'] . '">';
          echo 'Delete';
          echo '</button>';
          echo '<div class="modal fade" id="deleteCommentModal' . $comments[$j]['commentID'] . '" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="deleteCommentModalLabel' . $comments[$j]['commentID'] . '">Delete comment?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<button class="del btn btn-outline-danger" data-bs-dismiss="modal">';
          // link to deleteComments.php if user click on delete, delete the comment
          echo '<a class="commentA" href="deleteComments.php?commentID=' . $comments[$j]['commentID'] . '">Yes</a>';
          echo '</button>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      // commenting ends here
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</section>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
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
      $sql = 'SELECT * FROM users WHERE userID = :task_id';
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':task_id', $row[$i]['userID']);
      $stmt->execute();
      $user = $stmt->fetchAll();
      echo '<div class="card-header p-2">';
      echo '<div class="d-flex justify-content-between p-1">';
      echo '<form action="../UserPage/index.php?userID=' . $row[$i]['userID'] . '&userName=' . $user[0]['username'] . '" method="post">';
      echo '<button type="submit" name="submit" value="submit" class="btn tbn-link text-decoration-none postRCS">' . $user[0]['username'] . '</button>';
      echo '</form>';
      if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo '<div class="container d-flex justify-content-end">';
        echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row[$i]['postID'] . '">';
        echo 'Delete';
        echo '</button>';
        echo '<div class="modal fade" id="deleteModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog modal-sm">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="deleteModalLabel' . $row[$i]['postID'] . '">Delete post?</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<div class="container d-flex flex-row justify-content-center">';
        echo '<form class="me-3"action="main.php" method="post">';
        echo '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
        echo '<button type="submit" name="deleteAdmin" value="deleteAdmin" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
        echo '</form>';
        echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#banModal' . $row[$i]['postID'] . '">';
        echo 'Ban User';
        echo '</button>';
        echo '<div class="modal fade" id="banModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog modal-sm">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="banModalLabel' . $row[$i]['postID'] . '">Ban ' . $user[0]['username'] . '?</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<div class="container d-flex flex-row justify-content-center">';
        echo '<form class="me-3" action="main.php" method="post">';
        echo  '<input type="hidden" name="userID" value=" ' . $row[$i]['userID'] . '"/>';
        echo '<button type="submit" name="ban" value="ban" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
        echo '</form>';
        echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      } else {
        if($row[$i]['userID'] == $_SESSION['userID']){
          echo '<div class="container d-flex justify-content-end">';
          echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">';
          echo 'Delete';
          echo '</button>';
          echo '<div class="modal fade" id="deleteModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="deleteModalLabel' . $row[$i]['postID'] . '">Delete post?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<form class="me-3" action="main.php" method="post">';
          echo '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
          echo '<button type="submit" name="delete" value="delete" class="btn btn-outline-danger" data-bs-dismiss="modal">Yes</button>';
          echo '</form>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>'; 
          echo '</div>';
        } else {
          echo '<button type="button" class="btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#reportModal' . $row[$i]['postID'] . '">';
          echo 'Report';
          echo '</button>';
          echo '<div class="modal fade" id="reportModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="reportModalLabel' . $row[$i]['postID'] . '">Report post?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<button type="button" class="me-3 btn btn-outline-danger" onclick="report(' . $row[$i]['postID'] . ", " . $_SESSION['userID'] . ', this)" data-bs-dismiss="modal">Yes</button>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>'; 
        }
      }
      echo '</div>';
      echo '<div class="location p-2">';
      echo '<i class="fa-solid fa-location-arrow"></i> ' . $row[$i]['location'] . '</div>';
      echo '<p class="time mt-1"><i class="fa-solid fa-clock pt-1"></i> ' . calculate_time($row[$i]['postTime']) . '</p>';
      echo '</div>';
      echo '<div>';
      echo '<h5 class="card-title"><i class="fa-solid fa-utensils me-2 mt-2"></i>';
      echo $row[$i]["foodName"];
      echo '</h5>';
      echo '</div>';
      echo '<img class="card-img-top mt-0" src="../postImages/' . $row[$i]['postPhoto'] . '"alt="Card image">';
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
      // modal for comments that pops up and displays
      echo '<div class="comment" data-bs-toggle="modal" data-bs-target="#commentModal' . $row[$i]['postID'] . ' "><i class="fa-regular fa-comment"></i> ';
      echo ' comments</div></div>';
      //modal
      echo '<div class="modal fade" id="commentModal' . $row[$i]['postID'] . '" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">';
      echo '<h1 class="modal-title fs-5" id="commentModalLabel' . $row[$i]['postID'] . '">Comments</h1>';
      echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
      echo '</div>';
      echo '<div class="modal-body" style="background-color: #f7f6f6;">';
      echo '<section>';
      echo '<div class="container">';
      echo '<div class="row d-flex">';
      echo '<div class="comment-container container w-100 d-flex justify-content-between" id="comment' . $row[$i]['postID'] . '">';
      echo '<div class="f">';
      echo '<textarea name="text ' . $row[$i]['postID'] . '" maxlength="255" placeholder="Add Your Comment" id="text' . $row[$i]['postID'] . '"></textarea>';
      echo '<div class="d-flex justify-content-between">';
      echo '<button class="btn btn-dark" onclick="createComt(' . $_SESSION['userID'] . ',' . $row[$i]['postID'] . ',\'text' . $row[$i]['postID'] . '\',\'CommentPlace' . $row[$i]['postID'] . '\')">Comment</button>';
      echo '<div class="d-flex justify-content-between">';
      echo '<div class="card m-0">';
      echo '<div class="card-body p-1 d-flex align-items-center">';
      echo '<h6 class="text-primary fw-bold small mb-0 me-2">Sort by Likes</h6>';
      echo '<div class="form-check form-switch pt-1">';
      echo '<input class="form-check-input" type="checkbox" id="switch' . $row[$i]['postID'] . '" />';
      echo '<label class="form-check-label" for="switch' . $row[$i]['postID'] . '"></label>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '<div class="col-12" id="CommentPlace' . $row[$i]['postID'] . '">';

      // prepare query for comments table
      $comments = $conn->prepare('SELECT * FROM Comments WHERE postID = :postID ORDER BY commentID DESC');
      $comments->execute(['postID' => $row[$i]['postID']]);
      $comments = $comments->fetchAll();
      // commenting starts here
      for ($j = 0; $j < count($comments); $j++) {
        // references commentLikes table to get who liked what comment
        $commentLikes = $conn->prepare('SELECT * FROM commentLikes WHERE commentID = :commentID');
        $commentLikes->execute(['commentID' => $comments[$j]['commentID']]);
        $commentLikes = $commentLikes->fetchAll();
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
        $user->execute(['userID' => $comments[$j]['userID']]);
        $user = $user->fetch();
        echo $user['username'];
        echo '</h6>';
        echo '</div>';
        echo '<div class="border-top border-bottom pt-2 pb-2">';
        echo '<p class="mb-0">';
        // comment goes here
        echo $comments[$j]['comment'];
        echo '</p>';
        echo '</div>';
        echo '<div>';
        echo '<p class="small text-secondary mb-1">';
        // date goes here
        $temp = $comments[$j]['commentTime'];
        $temp_out = calculate_time($temp);
        echo $temp_out;
        echo '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="d-flex justify-content-between align-items-center">';
        echo '<div class="semi-like border-0 p-0 bg-transparent">';
        echo '<button class="like ';
        if (count($commentLikes) != 0) {
          echo 'liked-this-post';
        }
        echo '"onclick="likeCounterComment(' . $comments[$j]['commentID'] . ', ' . $_SESSION['userID'];
        echo ', this)"><i class="fa-regular fa-heart';
        echo '"></i></button>';
        echo '</div>';
        echo '<div>';
        // only show delete if the user is the one who posted the comment
        if ($comments[$j]['userID'] == $_SESSION['userID'] || (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)) {
          echo '<button type="button" class="del btn btn-link text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteCommentModal' . $comments[$j]['commentID'] . '">';
          echo 'Delete';
          echo '</button>';
          echo '<div class="modal fade" id="deleteCommentModal' . $comments[$j]['commentID'] . '" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">';
          echo '<div class="modal-dialog modal-sm">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="deleteCommentModalLabel' . $comments[$j]['commentID'] . '">Delete comment?</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<div class="container d-flex flex-row justify-content-center">';
          echo '<button class="del btn btn-outline-danger" data-bs-dismiss="modal">';
          // link to deleteComments.php if user click on delete, delete the comment
          echo '<a class="commentA" href="deleteComments.php?commentID=' . $comments[$j]['commentID'] . '">Yes</a>';
          echo '</button>';
          echo '<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      // commenting ends here
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</section>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
    $_SESSION['i'] = $i;
}

?>