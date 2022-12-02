<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="index.css">
  <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script defer src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
  crossorigin="anonymous"></script>
  <script defer src="script.js"></script>
  <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0d_qUGjTvVflSTk7-WhGem3bq7bhARUk&callback=initMap">
    </script>
  <title>RPI Foodies</title>
</head>

<body>
  <!-- Top navbar includes links to login and search bar along with  -->
  <header>
    <?php include '../header.php'; ?>
  </header>

  <div class="d-flex pt-5 align-items-center justify-content-center">
    <h1 class="">Dining Halls</h1>
  </div>
  <div class="p-5">
    <div class="container">
      <div class="row text-center">
        <div class="col-md">
          <div class="card">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <img src="../pictures/commons.webp" style="height: 150px;" alt="" class="w-100">
              </div>
              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#info">
                Commons
              </button>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <img src="../pictures/sage.jpeg" style="height: 150px;" alt="" class="w-100">
              </div>
              <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#info2">
                Sage
              </button>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <img src="../pictures/blitman.jpeg" style="height: 150px;" alt="" class="w-100">
              </div>
              <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#info3">
                Blitman
              </button>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <img src="../pictures/barh.jpeg" style="height: 150px;" alt="" class="w-100">
              </div>
              <button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#info4">
                BarH
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="infoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content w-100">
        <div class="modal-header">
          <h5 class="modal-title" id="infoLabel">Timings</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-info">
          <section class="text-light p-2 text-center">
            <div class="container">
              <h5><u>Breakfast</u></h5>
              <p>7:30AM - 9:30AM</p>
              <h5><u>Lunch</u></h5>
              <p>11:00AM - 2:00PM</p>
              <h5><u>Dinner</u></h5>
              <p>4:30PM - 9:00PM</p>
            </div>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="info2" tabindex="-1" role="dialog" aria-labelledby="infoLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content w-100">
        <div class="modal-header">
          <h5 class="modal-title" id="infoLabel2">Timings</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-success">
          <section class="text-light p-2 text-center">
            <div class="container">
              <h5><u>Breakfast</u></h5>
              <p>7:00AM - 10:00AM</p>
              <h5><u>Lunch</u></h5>
              <p>11:00AM - 2:00PM</p>
              <h5><u>Dinner</u></h5>
              <p>5:00PM - 8:00PM</p>
            </div>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="info3" tabindex="-1" role="dialog" aria-labelledby="infoLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content w-100">
        <div class="modal-header">
          <h5 class="modal-title" id="infoLabel3">Timings</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-warning">
          <section class="text-light p-2 text-center">
            <div class="container">
              <h5><u>Breakfast</u></h5>
              <p>7:00AM - 9:30AM</p>
              <h5><u>Dinner</u></h5>
              <p>5:00PM - 8:00PM</p>
            </div>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="info4" tabindex="-1" role="dialog" aria-labelledby="infoLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content w-100">
        <div class="modal-header">
          <h5 class="modal-title" id="infoLabel4">Timings</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-secondary">
          <section class="text-light p-2 text-center">
            <div class="container">
              <h5><u>Breakfast</u></h5>
              <p>7:00AM - 9:30AM</p>
              <h5><u>Dinner</u></h5>
              <p>5:00PM - 9:00PM</p>
            </div>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-light text-light p-5 text-center">
    <div class="container">
      <div class="d-flex align-items-center justify-content-center">
        <div id="map" style="height: 500px; width: 100%;">
          <p class="text-primary lead my-4">Map</p>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <?php include '../footer.php';?>
  </footer>

</body>

</html>