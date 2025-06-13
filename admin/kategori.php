<?php
require "session.php";
require "../db/database.php";
$query = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahkategori = mysqli_num_rows($query);
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
    <title>Kategori</title>
</head>
<style>
    .text-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require 'navbar.php' ?>

    <div class="container text-center py-5">
        <nav aria-label="breadcrumb" class="breadcrumb">
            <ol class="breadcrumb text-center">
                <li class="breadcrumb-item" aria-current="page">
                    <a href="index.php" class="text-decoration text-center">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Kategori</li>
            </ol>
        </nav>


        <div class=" d-flex flex-column justify-content-center align-items-center mt-4 text-center">
            <h3>Tambah Baru</h3>

            <form action="" method="post" class="col-12 col-md-6">
                <div>
                    <label for='kategori'>Kategori</label>
                    <input type='text' name='kategori' id='kategori' placeholder="Masukkan nama kategori" class="form-control col-md-8 mt-2 text-center" autocomplete="off">
                </div>

                <div class="mt-2">
                    <button class="col-md-12 justify-content-center btn btn-primary" type="submit" name="simpan_kategori">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan_kategori'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                $queryexist = mysqli_query($conn, "SELECT nama FROM kategori WHERE nama = '$kategori'");
                $jumlahkategoribaru = mysqli_num_rows($queryexist);

                if ($jumlahkategoribaru > 0) {
            ?>
                    <div class="alert alert-danger col-12 col-md-6 mt-2" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Kategori sudah ada
                    </div>
                    <?php
                } else {
                    $querysimpan = mysqli_query($conn, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                    if ($querysimpan) {
                    ?>
                        <div class="alert alert-success col-12 col-md-6 mt-2" role="alert">
                            <i class="bi bi-check-circle-fill"></i> Kategori berhasil disimpan
                        </div>

                        <!-- refresh -->
                        <meta http-equiv="refresh" content="2; url=kategori.php">
            <?php
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-5 text-center mb-5">
            <h3>Daftar Kategori</h3>
            <div class=" table-responsive mt-2 text-center">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahkategori == 0) {
                        ?>
                            <tr>
                                <td colspan=3 class="text-center">Data Kategori tidak ada
                                <td>
                            </td>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?= $jumlah; ?></td>
                                    <td><?= $data['nama']; ?></td>
                                    <td>
                                        <a href="kategori-detail.php?i=<?= $data['id']; ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <?php require 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>