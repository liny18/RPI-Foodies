<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="upload.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../pictures/RPIFoodies.png">
    <title>RPI Foodies</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <!-- ADD HEADER -->
    <header>
        <?php include '../header.html'; ?>
    </header>

    <main>
        <div id="uploadPost" class="container">
            <div class="row">
                <section id="uploadPhoto" class="col shadow-lg p-3 mb-5 bg-body rounded">
                    <h1 class="picTitle">Upload Image</h1>
                    <hr class="bg-dark border-5 border-top border-dark">
                    <input type="file" id="postPhoto" accept="image/jpg, image/png" onchange="previewFile()" />
                    <div class="imgCont"><img src="#" alt="Image preview" class="photo" /></div>
                </section>
                <section class="col shadow-lg p-3 mb-5 bg-body rounded">
                    <h1 class="Caption">Finish Your Post!</h1>
                    <hr class="bg-dark border-5 border-top border-dark">
                    <form id="postText" novalidate>
                        <div class="form-floating fix-floating-label p-1">
                            <textarea class="form-control" id="Caption" rows="5" required></textarea>
                            <label class="form-label" for="Caption">Enter A Caption</label>
                        </div>
                        <div class="row">
                            <div class="col-6 p-3">
                                <select class="form-select" aria-label="Dining Hall Selection" required>
                                    <option selected>What Dining Hall</option>
                                    <option value="1">Commons</option>
                                    <option value="2">Sage</option>
                                    <option value="3">Blitman</option>
                                    <option value="4">BarH</option>
                                </select>
                            </div>
                            <div class="col-6 p-3">
                                <select class="form-select" aria-label="Dining Hall Selection" required>
                                    <option selected>What type of food was it?</option>
                                    <option value="1">Vegitarian</option>
                                    <option value="2">Beef</option>
                                    <option value="3">Chicken</option>
                                    <option value="4">Non-Dairy</option>
                                    <option value="4">Desert</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <!-- WHEN READING THIS IN AS DATA CONVERT IT TO ALL LOWERCASE USING EITHER JS OR PHP CAN DO BOTH -->
                            <div class="form-floating fix-floating-label p-1">
                                <input type="text" class="form-control" id="foodName" placeholder="Name of the Dish" required>
                                <label for="foodName">Name of the Dish</label>
                            </div>
                        </div>
                        <button type="submit" id="postButton" class="btn" disabled>Post!</button>
                    </form>
                </section>
            </div>
        </div>
    </main>

    <!-- ADD FOOTER -->
    <footer>
        <?php include '../footer.html'; ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="upload.js"></script>

</body>

</html>