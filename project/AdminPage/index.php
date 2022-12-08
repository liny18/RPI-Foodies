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
  <link rel="stylesheet" href="../main/main.css">
  <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
  <title>RPI Foodies</title>
  <script defer src="https://kit.fontawesome.com/bb67f860a0.js" crossorigin="anonymous"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script defer src="../main/main.js"></script>
</head>
<body>

  <div id="content-wrap">
    <?php 
      include '../errorPage/check_if_banned.php';
      include '../time_function/time.php';

      @session_start();

      if (!isset($_SESSION['admin'])) {
        header("Location: ../errorPage/banned.php");
      }

      $servername = "localhost";
      $database = "rpiFoodies";
      $username = "root";
      $password = "";
          
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }

      $taskId = $_POST["postID"];
      if(isset($_POST["delete"]) && array_key_exists('delete', $_POST)){
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
        $date = date("Y-m-d");
        if($stmt5[0]['BannedPosts'] == 0){
          $sql12 = 'UPDATE users SET DateBanned = DATE_ADD('.$date.', INTERVAL 5 DAY) WHERE userID = :task_id';
          $stmt6 = $conn->prepare($sql12);
          $stmt6->bindValue(':task_id', $username);
          $stmt6->execute(); 
          
          $sql13 =  'UPDATE users SET Banned = 1 WHERE userID = :task_id';
          $stmt6 = $conn->prepare($sql13);
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

      if(isset($_POST["aprove"]) && array_key_exists('aprove', $_POST)){
        $sql = 'DELETE FROM Reports WHERE postID = :task_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':task_id', $taskId);
        $stmt->execute();
      }

      if(isset($_POST["ban"]) && array_key_exists('ban', $_POST)){
        $sql13 =  'UPDATE users SET Banned = 1 WHERE userID = :task_id';
        $stmt6 = $conn->prepare($sql13);
        $username = $_POST['userID'];
        $stmt6->bindValue(':task_id', $username);
        $stmt6->execute(); 
      }
    ?>

    <div class="container">
          <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-6 py-3">
                  <h1 class="display-4">Reported Posts</h1>
                  <?php
                      $posts = $conn->prepare("SELECT * FROM Reports");
                      $posts->execute();
                      $numPosts = $posts->fetchAll();
                      $hosts = $conn->prepare("SELECT * FROM Posts WHERE postID = :postID");
                      for ($i = 0; $i < count($numPosts); $i++) {
                        $hosts->execute([':postID' => $numPosts[$i]['postID']]);
                        $row = $hosts->fetchAll();
                        echo '<div class="card text-center">';
                        echo '<div class="card-header p-2"> <div class="location p-2">';
                        echo '<i class="fa-solid fa-location-arrow"></i>' . $row[0]['location'] . '</div>';
                        echo '<p class="time"><i class="fa-solid fa-clock"></i> ' . calculate_time($row[0]['postTime']) . '</p>';
                        echo '</div>';
                        echo '<img class="card-img-top" src="../postImages/' . $row[0]['postPhoto'] . '"alt="Card image">';
                        echo '<div class="card-body"><h5 class="card-title"><i class="fa-solid fa-tags"></i>';
                        echo $row[0]['tag1'] . '</h5>';
                        echo '<p class="card-text">';
                        echo '<i class="fa-solid fa-quote-left"></i>';
                        echo $row[0]['mainComment'];
                        echo '<i class="fa-solid fa-quote-right"></i></p></div>';
                        echo '<div class="card-footer d-flex justify-content-between pl-5 pr-5">';
                        echo '<button class="like" onclick="likeCounter(' . $row[0]['postID'] . ', ' . $_SESSION['userID'];
                        echo ', this)"><i class="fa-regular fa-heart" ></i> ';
                        echo $row[0]['likes'] . ' likes</button>';
                        echo '<div class="comment"><i class="fa-regular fa-comment"></i>';
                        echo 0 . ' comments</div></div>';
                        echo '<form action="index.php" method="post">';
                        echo  '<input type="hidden" name="postID" value=" ' . $row[0]['postID'] . '"/>';
                        echo '<button type="submit" name="aprove" value="aprove" class="btn btn-danger">Approve</button>';
                        echo '</form>';
                        echo  '<input type="hidden" name="postID" value=" ' . $row[0]['postID'] . '"/>';
                        echo '<button type="submit" name="delete" value="delete" class="btn btn-danger">Delete</button>';
                        echo '</form>';
                        echo '<form action="index.php" method="post">';
                        echo  '<input type="hidden" name="userID" value=" ' . $row[0]['userID'] . '"/>';
                        echo '<button type="submit" name="ban" value="ban" class="btn btn-danger">Ban User</button>';
                        echo '</form>';
                        echo '</div>';
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