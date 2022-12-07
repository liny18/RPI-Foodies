<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="main.css">
  <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
  <title>RPI Foodies</title>
  <script defer src="https://kit.fontawesome.com/bb67f860a0.js" crossorigin="anonymous"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script defer src="main.js"></script>
</head>

<body>
  <div id="content-wrap">
    <header>
      <?php include '../header.php'; ?>
    </header>

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

    // if something is submited go to search.php and do the query
    if (array_key_exists('submitSearch', $_POST)) {
      $_SESSION['query'] = $_POST['search'];
      $_SESSION['isSearch'] = true;
    }


    // based on if a button is clicked then go to the search page with the query needed
    if (array_key_exists('mostLiked0', $_POST) && isset($_SESSION['topPost1'])) {
      $_SESSION['query'] = 'SELECT * FROM Posts WHERE location = "Commons" AND foodName = "' . $_SESSION['topPost1'] . '" ORDER BY likes DESC';
    } else if (array_key_exists('mostLiked1', $_POST) && isset($_SESSION['topPost2'])) {
      $_SESSION['query'] = 'SELECT * FROM Posts WHERE location = "Commons" AND foodName = "' . $_SESSION['topPost2'] . '" ORDER BY likes DESC';
    } else if (array_key_exists('mostLiked2', $_POST) && isset($_SESSION['topPost3'])) {
      $_SESSION['query'] = 'SELECT * FROM Posts WHERE location = "Commons" AND foodName = "' . $_SESSION['topPost3'] . '" ORDER BY likes DESC';
    }

    // based on if a button is hit change what is being shown
    // and jump to the next page to show the new data
    if (array_key_exists('quick1', $_POST)) {
      $_SESSION['query'] = "SELECT * FROM Posts WHERE tag1 = 'Vegetable' ORDER BY likes DESC";
    } else if (array_key_exists('quick2', $_POST)) {
      $_SESSION['query'] = "SELECT * FROM Posts WHERE tag1 = 'Beef' ORDER BY likes DESC";
    } else if (array_key_exists('quick3', $_POST)) {
      $_SESSION['query'] = "SELECT * FROM Posts WHERE tag1 = 'Chicken' ORDER BY likes DESC";
    } else if (array_key_exists('quick4', $_POST)) {
      $_SESSION['query'] = "SELECT * FROM Posts WHERE tag1 = 'Non-dairy' ORDER BY likes DESC";
    } else if (array_key_exists('quick5', $_POST)) {
      $_SESSION['query'] = "SELECT * FROM Posts WHERE tag1 = 'Dessert' ORDER BY likes DESC";
    }


    if (array_key_exists('delete', $_POST)) {
      $taskId = $_POST["postID"];
      $sql1 = 'SELECT * FROM Posts WHERE postID = :task_id';
      $stmt3 = $conn->prepare($sql1);
      $stmt3->bindValue(':task_id', $_POST['postID']);
      $stmt3->execute();
      $username = $stmt3->fetchAll();
      $username = $username[0]['userID'];
      $sql11 = 'UPDATE users SET BannedPosts = BannedPosts-1 WHERE userID = :task_id';
      $stmt4 = $conn->prepare($sql11);
      $stmt4->bindValue(':task_id', $username);
      $stmt4->execute();

      $users = 'SELECT * FROM users WHERE userID = :task_id';
      $stmt5 = $conn->prepare($users);
      $stmt5->bindValue(':task_id', $username);
      $stmt5->execute();
      $stmt5 = $stmt5->fetchAll();
      if ($stmt5[0]['BannedPosts'] == 0) {
        $sql12 = 'UPDATE users SET DateBanned = DATE_ADD(CURDATE(), INTERVAL 5 DAY) WHERE userID = :task_id';
        $stmt6 = $conn->prepare($sql12);
        $stmt6->bindValue(':task_id', $username);
        $stmt6->execute();
      }
      $sql = 'DELETE FROM Reports WHERE postID = :task_id';
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':task_id', $taskId);
      $stmt->execute();

      $sql2 = 'DELETE FROM Posts WHERE postID = :task_id';
      $stmt2 = $conn->prepare($sql2);
      $stmt2->bindValue(':task_id', $taskId);
      $stmt2->execute();
    }

    if (array_key_exists('deleteAdmin', $_POST)) {
      $taskId = $_POST["postID"];
      $sql2 = 'DELETE FROM Posts WHERE postID = :task_id';
      $stmt2 = $conn->prepare($sql2);
      $stmt2->bindValue(':task_id', $taskId);
      $stmt2->execute();
    }

    // first grab all the data in descending order because newer posts will have a larger postid
    $grabByPostID = $conn->prepare("SELECT * FROM Posts ORDER BY postID DESC");
    $grabByPostID->execute();

    // grab data by most likes
    $grabByLikes = $conn->prepare("SELECT * FROM Posts ORDER BY likes DESC");
    $grabByLikes->execute();

    // grab data by most likes in commons
    $grabByLikesCommons = $conn->prepare("SELECT * FROM Posts WHERE location = 'Commons' ORDER BY likes DESC");
    $grabByLikesCommons->execute();
    ?>

    <div class="container">
      <div class="row">
        <div class="col-md-3 py-3">
          <div class="card text-center">
            <div class="card-header">
              <i class="fa-regular fa-face-laugh-squint"></i> Best Food Today in Commons
            </div>
            <form class="card-body" action="main.php" method="post">
              <h5 class="card-title">Commons Dinning Hall</h5>
              <ul class="list-group">

                <?php

                // grab the rows of the query
                $row = $grabByLikesCommons->fetchAll();
                $len = count($row);
                // print out data for most liked foods
                for ($i = 0; $i < 3 && $i < $len; $i++) {
                  echo "<button type='submit' name='mostLiked" . $i . "' value='mostLiked" . $i . "' id='mostLiked" . $i . "'>";
                  echo '<li class="list-group-item">';
                  echo '<i class="fa-solid fa-bowl-food"></i> ' . $row[$i]['foodName'];
                  echo '</li>';
                  echo '</button>';
                  if ($i == 0) {
                    $_SESSION['topPost1'] = $row[$i]['foodName'];
                  } else if ($i == 1) {
                    $_SESSION['topPost2'] = $row[$i]['foodName'];
                  } else if ($i == 2) {
                    $_SESSION['topPost3'] = $row[$i]['foodName'];
                  }
                }
                ?>
              </ul>
            </form>
          </div>
        </div>
        <div class="col-md-6 py-3">


          <?php
          // we need to see if the query should be based on a search or not
          if (isset($_SESSION['isSearch']) && $_SESSION['isSearch'] == true) {
            // grab the rows of the query
            $row = $grabByPostID->fetchAll();
            $len = count($row);
            // print out data for the specific searched item
            for ($i = 0; $i < 10 && $i < $len; $i++) {
              // should only match if the userID, main Comment has some similar word, location is the same, tags are the same
              // or the foodName is the same as the search item
              if (str_contains($row[$i]['userID'], $_SESSION['query']) || str_contains(strtolower($row[$i]['mainComment']), $_SESSION['query']) || str_contains($row[$i]['location'], $_SESSION['query']) || str_contains($row[$i]['tag1'], $_SESSION['query']) || str_contains($row[$i]['foodName'], $_SESSION['query'])) {
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
                echo '<form action="../UserPage/index.php?userID='.$row[$i]['userID'].'&userName='.$user[0]['username'].'" method="get">';
                echo '<button type="submit" name="submit" value="submit" class="btn tbn-link text-decoration-none postRCS">' . $user[0]['username'] . '</button>';
                echo '</form>';
                if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                  if($row[$i]['admin'] == 1){
                    echo '<form action="main.php" method="post">';
                    echo  '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
                    echo '<button type="submit" name="deleteAdmin" value="deleteAdmin" class="btn btn-link text-danger text-decoration-none">Delete</button>';
                    echo '</form>';
                  } else {
                    echo '<form action="main.php" method="post">';
                    echo  '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
                    echo '<button type="submit" name="delete" value="delete" class="btn btn-link text-danger text-decoration-none">Delete</button>';
                    echo '</form>';
                  }
                } else {
                  echo '<button type="button" class="btn btn-link text-danger text-decoration-none" onclick="report('.$row[$i]['postID'].", ".$_SESSION['userID'].', this)"> Report </button>';
                }
                echo '</div>';
                echo '<div class="location p-2">';
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
                // ADD A BUTTON THAT ON SUBMIT WILL INCREMENT LIKES BY 1 
                // ALSO HAVE IT AS A FUNCTION THAT TAKES IN A POST ID
                // CAN BE DONE IN THE FOR LOOP SHIT
          
                // When terry does modals add that shit to the end of this for loop
              }
            }

            $_SESSION['isSearch'] = false;
            $_SESSION['query'] = "";
          } else if (isset($_SESSION['query']) && $_SESSION['query'] != '') {
            // create new query based on the button pressed
            $grabByPostID = $conn->prepare($_SESSION['query']);
            $grabByPostID->execute();
            // grab the rows of the query
            $row = $grabByPostID->fetchAll();
            $len = count($row);
            // print out data for most liked foods
            for ($i = 0; $i < 10 && $i < $len; $i++) {
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
              echo '<form action="../UserPage/index.php?userID='.$row[$i]['userID'].'&userName='.$user[0]['username'].'" method="get">';
              echo '<button type="submit" name="submit" value="submit" class="btn tbn-link text-decoration-none postRCS">' . $user[0]['username'] . '</button>';
              echo '</form>';
              if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                if($row[$i]['admin'] == 1){
                  echo '<form action="main.php" method="post">';
                  echo  '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
                  echo '<button type="submit" name="deleteAdmin" value="deleteAdmin" class="btn btn-link text-danger text-decoration-none">Delete</button>';
                  echo '</form>';
                } else {
                  echo '<form action="main.php" method="post">';
                  echo  '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
                  echo '<button type="submit" name="delete" value="delete" class="btn btn-link text-danger text-decoration-none">Delete</button>';
                  echo '</form>';
                }
              } else {
                echo '<button type="button" class="btn btn-link text-danger text-decoration-none" onclick="report('.$row[$i]['postID'].", ".$_SESSION['userID'].', this)"> Report </button>';
              }
              echo '</div>';
              echo '<div class="location p-2">';
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
            // reset querys to 0
            $_SESSION['query'] = "";
          }
          // print out a normal post stream
          else {
            // grab the rows of the query
            $row = $grabByPostID->fetchAll();
            $len = count($row);
            // print out data for most liked foods
            for ($i = 0; $i < 10 && $i < $len; $i++) {
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
              echo '<form action="../UserPage/index.php?userID='.$row[$i]['userID'].'&userName='.$user[0]['username'].'" method="get">';
              echo '<button type="submit" name="submit" value="submit" class="btn tbn-link text-decoration-none postRCS">' . $user[0]['username'] . '</button>';
              echo '</form>';
              if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                if($row[$i]['admin'] == 1){
                  echo '<form action="main.php" method="post">';
                  echo  '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
                  echo '<button type="submit" name="deleteAdmin" value="deleteAdmin" class="btn btn-link text-danger text-decoration-none">Delete</button>';
                  echo '</form>';
                } else {
                  echo '<form action="main.php" method="post">';
                  echo  '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
                  echo '<button type="submit" name="delete" value="delete" class="btn btn-link text-danger text-decoration-none">Delete</button>';
                  echo '</form>';
                }
              } else {
                echo '<button type="button" class="btn btn-link text-danger text-decoration-none" onclick="report('.$row[$i]['postID'].", ".$_SESSION['userID'].', this)"> Report </button>';
              }
              echo '</div>';
              echo '<div class="location p-2">';
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
          ?>
        </div>

        <!-- using a button gropu and the forms we will save the required query and transfer to the next page -->
        <div class="col-md-3 py-3">
          <div class="card text-center">
            <div class="card-header">
              <i class="fa-solid fa-utensils"></i> Quick Search
            </div>
            <form class="card-body" action="main.php" method="post">
              <h5 class="card-title">Popular tags</h5>
              <ul class="list-group">
                <button type="submit" name="quick1" value="quick1" id="quick1">
                  <li class="list-group-item">
                    <i class="fa-solid fa-hashtag"></i> Vegetable
                  </li>
                </button>
                <button type="submit" name="quick2" value="quick2" id="quick2">
                  <li class="list-group-item">
                    <i class="fa-solid fa-hashtag"></i> Beef
                  </li>
                </button>
                <button type="submit" name="quick3" value="quick3" id="quick3">
                  <li class="list-group-item">
                    <i class="fa-solid fa-hashtag"></i> Chicken
                  </li>
                </button>
                <button type="submit" name="quick4" value="quick4" id="quick4">
                  <li class="list-group-item">
                    <i class="fa-solid fa-hashtag"></i> Non-dairy
                  </li>
                </button>
                <button type="submit" name="quick5" value="quick5" id="quick5">
                  <li class="list-group-item">
                    <i class="fa-solid fa-hashtag"></i> Dessert
                  </li>
                </button>
              </ul>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <?php include '../footer.html'; ?>
  </footer>

</body>

</html>