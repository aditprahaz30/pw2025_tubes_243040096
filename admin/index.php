<?php
require "session.php";
require "../db/database.php";

$querykategori = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahkategori = mysqli_num_rows($querykategori);

$querygaleri = mysqli_query($conn, "SELECT * FROM galeri");
$jumlahgaleri = mysqli_num_rows($querygaleri);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Home</title>
</head>
<style>
    .kotak .icon {
        font-size: 5rem;
    }

    .kotak a {
        text-decoration: none;
        color: white;
    }

    .summary-kategori {
        width: 300px;
        height: 200px;
        border-radius: 20px;
        background-color: red;
        color: white;

    }

    .summary-galeri {
        width: 300px;
        height: 200px;
        border-radius: 20px;
        background-color: green;
        color: white;

    }
</style>

<body>
    <?php require "navbar.php" ?>

        <div class="container mt-5 text-center ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Home</li>
            </ol>
        </nav>
        <h1>Halaman Admin</h1>

        <div class=" d-flex flex-column justify-content-center align-items-center container mt-5 text-center">
            <div class="row ">
                <div class=" col-lg-6 col-md-6 col-sm-12 mb-2 kotak p-2">
                    <div class="summary-kategori p-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="bi bi-list icon"></i>
                            </div>
                            <div class="col-6 mb-2">
                                <h3 class="fs-3">KATEGORI</h3>
                                <p class="fs-4"><?php echo $jumlahkategori; ?> Kategori</p>
                                <a href="kategori.php">Lihat detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-2 kotak p-2">
                    <div class="summary-galeri p-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="bi bi-palette-fill icon"></i>
                            </div>
                            <div class="col-6 mb-2">
                                <h3 class="fs-3">GALERI</h3>
                                <p class="fs-4"><?php echo $jumlahgaleri; ?> Galeri</p>
                                <a href="galeri.php">Lihat detail</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>



    


 


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>