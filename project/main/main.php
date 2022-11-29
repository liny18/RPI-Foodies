<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="main.css">
  <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
  <title>RPI Foodies</title>
  <script src="https://kit.fontawesome.com/bb67f860a0.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <?php include '../header.html'; ?>
  </header>

  <div class="container">
    <div class="row vh-100">
      <div class="col-md-3 py-3">
        <div class="card text-center">
          <div class="card-header">
            <i class="fa-regular fa-face-laugh-squint"></i> Best Dinners Last Week
          </div>
          <div class="card-body">
            <h5 class="card-title">Commons Dinning Hall</h5>
            <ul class="list-group">
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-bowl-food"></i> Pasta
                </li>
              </a>
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-bowl-food"></i> Orange chicken
                </li>
              </a>
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-bowl-food"></i> Korean pulled pork
                </li>
              </a>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6 py-3">
        <div class="card text-center">
          <div class="card-header p-2">
            <div class="location p-2">
              <i class="fa-solid fa-location-arrow"></i> Blitman Dining Hall
            </div>
            <p class="time">
              <i class="fa-solid fa-clock"></i> Just Now
            </p>
          </div>
          <img class="card-img-top" src="../pictures/food1.svg" alt="Card image">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fa-solid fa-tags"></i>
              Asian, Noodles, Spicy
            </h5>
            <p class="card-text">
              <i class="fa-solid fa-quote-left"></i>
              The Stir Fry is amazing! I love Blitman Dining Hall!
              <i class="fa-solid fa-quote-right"></i>
            </p>
          </div>
          <div class="card-footer d-flex justify-content-between pl-5 pr-5">
            <div class="like">
              <i class="fa-regular fa-heart"></i>
              0 likes
            </div>
            <div class="comment">
              <i class="fa-regular fa-comment"></i>
              0 comments
            </div>
          </div>
        </div>

        <div class="card text-center">
          <div class="card-header p-2">
            <p class="location p-2">
              <i class="fa-solid fa-location-arrow"></i> Commons Dining Hall
            </p>
            <p class="time">
              <i class="fa-solid fa-clock"></i> 2 minutes ago
            </p>
          </div>
          <img class="card-img-top" src="../pictures/food2.webp" alt="Card image">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fa-solid fa-tags"></i>
              Burger
            </h5>
            <p class="card-text">
              <i class="fa-solid fa-quote-left"></i>
              cheeks
              <i class="fa-solid fa-quote-right"></i>
            </p>
          </div>
          <div class="card-footer d-flex justify-content-between pl-5 pr-5">
            <div class="like">
              <i class="fa-regular fa-heart"></i>
              5 likes
            </div>
            <div class="comment">
              <i class="fa-regular fa-comment"></i>
              1 comments
            </div>
          </div>
        </div>

        <div class="card text-center">
          <div class="card-header">
            <p class="location p-2">
              <i class="fa-solid fa-location-arrow"></i> Sage Dining Hall
            </p>
            <p class="time">
              <i class="fa-solid fa-clock"></i> 5 minutes ago
            </p>
          </div>
          <img class="card-img-top" src="../pictures/food3.jpg" alt="Card image">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fa-solid fa-tags"></i>
              Salad, Vegetables
            </h5>
            <p class="card-text">
              <i class="fa-solid fa-quote-left"></i>
              mid asf salad
              <i class="fa-solid fa-quote-right"></i>
            </p>
          </div>
          <div class="card-footer d-flex justify-content-between pl-5 pr-5">
            <div class="like">
              <i class="fa-regular fa-heart"></i>
              4 likes
            </div>
            <div class="comment">
              <i class="fa-regular fa-comment"></i>
              0 comments
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 py-3">
        <div class="card text-center">
          <div class="card-header">
            <i class="fa-solid fa-utensils"></i> Quick Search
          </div>
          <div class="card-body">
            <h5 class="card-title">Popular tags</h5>
            <ul class="list-group">
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-hashtag"></i> Vegetable
                </li>
              </a>
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-hashtag"></i> Beef
                </li>
              </a>
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-hashtag"></i> Chicken
                </li>
              </a>
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-hashtag"></i> Non-dairy
                </li>
              </a>
              <a href="">
                <li class="list-group-item">
                  <i class="fa-solid fa-hashtag"></i> Dessert
                </li>
              </a>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <?php include '../footer.html'; ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</body>

</html>