<?php 
require "db/database.php";

$querykategori = mysqli_query($conn, "SELECT * FROM kategori");

// difilter sesuai kategori
if(isset($_GET['kategori'])){
    $querykategori = mysqli_query($conn, " SELECT id FROM kategori WHERE nama='$_GET[kategori]' ");
    $kategoriid = mysqli_fetch_array($querykategori);
    echo $kategoriid['id'];
}
// galeri default
else{
    $querygaleri = mysqli_query($conn, "SELECT * FROM galeri");
}

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
    <link rel="stylesheet" href="css/user.css">
    <title>La Galleria | Home</title>
</head>

<body>
<?php require 'nav.php' ?>

<div class="container-fluid banner-galeri d-flex ">
    <div class="container title">
        <h1>Galeri Kami</h1>
    </div>
</div>

<!-- konten -->
 <section id="galeri">
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-5">
            <h3>Kategori</h3>
            <ul class=list-group>
    <?php while($kategori= mysqli_fetch_array($querykategori)){ ?>
        <a href="galeri.php?kategori=<?= $kategori ['nama'];?>">
            <li class="list-group-item"><?= $kategori['nama']; ?></li>
        </a>
                <?php } ?>
            </ul>
        </div>

        <div class="col-lg-9">
            <h3 class="text-center mb-3">Karya</h3>
            <div class="row">
                
                <?php while ?>

                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="dbimg/a1.jpg" class="card-img-top" alt="">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">zhhx</h4>
                            <p class="card-text-pelukis">fdagagd</p>
                            <p class="card-text-tahun">xs</p>
                            <a href="galeri-detail.php?nama=<?=$data['nama'];?>" class="btn-card">Lihat Karya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>