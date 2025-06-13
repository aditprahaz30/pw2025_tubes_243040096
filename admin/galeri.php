<?php
require "../db/database.php";
require "session.php";

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM galeri a JOIN kategori b ON a.kategori_id=b.id");
$jumlahgaleri = mysqli_num_rows($query);

$querykategori = mysqli_query($conn, "SELECT * FROM kategori");
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
    <title>Galeri</title>
</head>

<body>
    <?php require 'navbar.php' ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Home
                </li>
                <li class="breadcrumb-item" aria-current="page">Galeri
                </li>
            </ol>
        </nav>

        <!-- tambah -->
        <div class=" d-flex flex-column justify-content-center align-items-center mt-4 text-center">
            <h3>Tambah Baru</h3>
            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $pelukis = htmlspecialchars($_POST['pelukis']);
                $tahun = htmlspecialchars($_POST['tahun']);
                $deskripsi = htmlspecialchars($_POST['deskripsi']);

                // menambahkan gambar ke db
                $targetimg =  "../dbimg/";
                $namafile = basename($_FILES['gambar']['name']);
                $targetfile = $targetimg . $namafile;
                $filetype = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));
                $imgsize = $_FILES['gambar']['size'];

                if ($nama == '' || $kategori == '' || $pelukis == '') {
            ?>
                    <div class="alert alert-warning mt-2 col-md-6" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Kategori, nama, dan pelukis wajib diisi
                    </div>
                    <?php
                } else {
                    if ($namafile != '') {
                        if ($imgsize > 500000) {
                        } else {
                            if ($filetype != 'jpg' && $filetype != 'png' && $filetype != 'gif') {
                            } else {
                                move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetfile);
                            }
                        }
                    }

                    // query insert to galeri db
                    $querysimpan = mysqli_query($conn, "INSERT INTO galeri ( nama, kategori_id, pelukis, tahun, deskripsi, gambar ) VALUES ('$nama', '$kategori', '$pelukis', '$tahun', '$deskripsi', '$namafile')");

                    if ($querysimpan) {
                    ?>
                        <div class="alert alert-success col-md-6 mt-2" role="alert">
                            <i class="bi bi-check-circle-fill"></i> Karya berhasil disimpan
                        </div>

                        <!-- refresh -->
                        <meta http-equiv="refresh" content="2; url=galeri.php">
            <?php
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }

            ?>

            <form action="" method="post" enctype="multipart/form-data" class="col-12 col-md-6">

                <div>
                    <label for='nama' class="mb-1">Nama</label>
                    <input type='text' name='nama' id='nama' class="form-control mb-1 text-center" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori" class="mb-2">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control mb-2 text-center " required>
                        <option value="" class="">-- Pilih salah satu --</option>
                        <?php
                        while ($data = mysqli_fetch_array($querykategori)) {
                        ?>
                            <option value="<?= $data['id']; ?>"><?= $data['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for='pelukis' class="mb-1">Pelukis</label>
                    <input type='text' name='pelukis' id='pelukis' class="form-control mb-1 text-center" autocomplete="off" required>
                </div>
                <div>
                    <label for='tahun' class="mb-1">Tahun</label>
                    <input type='number' name='tahun' id='tahun' class="form-control mb-1 text-center">
                </div>
                <div>
                    <label for='pelukis' class="mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control mb-1 text-center" rows="5"></textarea>
                </div>
                <div class="text-center">
                    <label for="gambar" class="mb-1">Karya</label>
                    <input type="file" name="gambar" id="gambar" class="form-control mb-2 text-center">
                </div>
                <div>
                    <button type="submit" name="simpan" class="btn btn-success col-md-12 col-sm-12">Simpan</button>
                </div>
            </form>
        </div>

        <div class="mt-5 text-center mb-5">
            <h3>Galeri</h3>

            <div class="table-responsive mt-2 text-center">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Pelukis</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahgaleri == 0) {
                        ?>
                            <tr>
                                <td colspan=6 class="text-center">Data galeri tidak ada
                                <td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?= $jumlah; ?></td>
                                    <td><?= $data['nama']; ?></td>
                                    <td><?= $data['nama_kategori']; ?></td>
                                    <td><?= $data['pelukis']; ?></td>
                                    <td><?= $data['tahun']; ?></td>
                                    <td>
                                        <a href="galeri-detail.php?i=<?= $data['id']; ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i>

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