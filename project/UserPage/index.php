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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../main/main.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script defer src="main.js"></script>
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

      $sql1 = 'SELECT * FROM users WHERE userID = :task_id';
      $stmt3 = $conn->prepare($sql1);
      $stmt3->bindValue(':task_id', $_SESSION['userID']);
      $stmt3->execute();
      $banned = $stmt3->fetchAll();
      if ($banned[0]['Banned'] == 1) {
        header("Location: ../errorPage/banned.php");
        exit;
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
  <header>
      <?php include '../headerLogin.php'; ?>
  </header>
  <div class="container">
    <?php
        function sanitize_xss($value) {
            return htmlspecialchars(strip_tags($value));
        }
        $user = sanitize_xss($_GET['userName']);
        $userID = sanitize_xss($_GET['userID']);
        echo '<h1>' . $user ."'s Posts</h1>";
    ?>
    <h1> </h1>
    <div class="row vh-100">
      <div class="col-md-6 py-3">
        <?php
          $posts = $conn->prepare("SELECT * FROM Posts WHERE userID = $userID");
          $posts->execute();
          $row = $posts->fetchAll();
          $len = count($row);
          if($len != 0){
            for ($i = 0; $i < $len; $i++) {
              echo '<div class="card text-center">';
              echo '<div class="card-header p-2"> <div class="location p-2">';
              echo '<i class="fa-solid fa-location-arrow"></i>' . $row[$i]['location'] . '</div>';
              echo '<p class="time"><i class="fa-solid fa-clock"></i> ' . calculate_time($row[$i]['postTime']) . '</p>';
              echo '</div>';
              echo '<img class="card-img-top" src="../postImages/' . $row[$i]['postPhoto'] . '"alt="Card image">';
              echo '<div class="card-body"><h5 class="card-title"><i class="fa-solid fa-tags"></i>';
              echo $row[$i]['tag1'] . '</h5>';
              echo '<p class="card-text">';
              echo '<i class="fa-solid fa-quote-left"></i>';
              echo $row[$i]['mainComment'];
              echo '<i class="fa-solid fa-quote-right"></i></p></div>';
              echo '<div class="card-footer d-flex justify-content-between pl-5 pr-5">';
              echo '<button class="like" onclick="likeCounter(' . $row[$i]['postID'] . ', ' . $_SESSION['userID'];
              echo ', this)"><i class="fa-regular fa-heart" ></i> ';
              echo $row[$i]['likes'] . ' likes</button>';
              echo '<form action="main.php" method="post">';
              if($_SESSION['postID'] == $row[$i]['postID']){
                echo '<input type="hidden" name="postID" value=" ' . $row[$i]['postID'] . '"/>';
                echo '<button type="submit" name="delete" value="delete" class="btn btn-danger">Delete</button>';
                echo '</form>'; 
              } else {
                echo '<button type="button" class="btn btn-danger" onclick="report(' . $row[$i]['postID'] . ", " . $_SESSION['userID'] . ', this)"> Report </button>';
              }    
              echo '<div class="comment"><i class="fa-regular fa-comment"></i>';
              echo ' comments</div></div></div>';
            }
          } else {
            echo '<h1> No posts </h1>';
          }
        ?>
      </div>
    </div>
  </div>
  <footer>
      <?php include '../footer.html'; ?>
  </footer>
</body>
</html>
