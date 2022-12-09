<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script defer src="https://kit.fontawesome.com/bb67f860a0.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../main/main.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script defer src="../main/main.js"></script>
  <?php
      include '../errorPage/check_if_banned.php';
      include '../time_function/time.php';

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
      
      if (array_key_exists('delete', $_POST)) {
        $taskId = $_POST["postID"];
        $sql2 = 'DELETE FROM Posts WHERE postID = :task_id';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindValue(':task_id', $taskId);
        $stmt2->execute();
      }
  ?>
</head>
<body>
  <div id="content-wrap">
  <header>
      <?php include '../header.php'; ?>
  </header>
  <div class="container">
    <?php
        function sanitize_xss($value) {
            return htmlspecialchars(strip_tags($value));
        }
        $user = sanitize_xss($_GET['userName']);
        $userID = sanitize_xss($_GET['userID']);
    ?>
    <h1> </h1>
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-6 py-3">
        <h1 class="display-4 text-center fw-bold"><?php echo $user. "'s Posts"; ?></h1>
        <?php
          $posts = $conn->prepare("SELECT * FROM Posts WHERE userID = $userID");
          $posts->execute();
          $row = $posts->fetchAll();
          $len = count($row);
          if($len != 0){
            // print out data for most liked foods
            for ($i = 0; $i < $len; $i++) {
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
                  echo '<button class="del btn btn-link p-0 text-danger text-decoration-none">';
                  // link to deleteComments.php if user click on delete, delete the comment
                  echo '<a class="commentA text-danger text-decoration-none" href="deleteComments.php?commentID=' . $comments[$j]['commentID'] . '">Delete</a>';
                  echo '</button>';
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
          } else {
            echo '<h1> No posts </h1>';
          }
        ?>
      </div>
    </div>
  </div>
  </div>
  <footer>
      <?php include '../footer.html'; ?>
  </footer>
</body>
</html>
