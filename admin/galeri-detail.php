<?php
require "session.php";
require "../db/database.php";

// detail kategori
$id = $_GET['i'];

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM galeri a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id' ");
$data = mysqli_fetch_array($query);

$querykategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id!='$data[kategori_id]' ");


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

    <div class=" d-flex  flex-column justify-content-center align-items-center mt-5 mb-5 text-center">
        <h2>Informasi Galeri</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">

                <div>
                    <label for='nama' class="mb-1">Nama</label>
                    <input type='text' name='nama' id='nama' value='<?= $data['nama']; ?>' class="form-control mb-1 text-center" autocomplete="off" required>
                </div>

                <div>
                    <label for="kategori" class="mb-2">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control mb-2 text-center " required>
                        <option value="<?= $data['kategori_id']; ?>" class=""><?= $data['nama_kategori']; ?></option>
                        <?php
                        while ($datakategori = mysqli_fetch_array($querykategori)) {
                        ?>
                            <option value="<?= $datakategori['id']; ?>"><?= $datakategori['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for='pelukis' class="mb-1">Pelukis</label>
                    <input type='text' value="<?= $data['pelukis']; ?>" name='pelukis' id='pelukis' class="form-control mb-2 text-center" autocomplete="off" required>
                </div>
                <div>
                    <label for='tahun' class="mb-1">Tahun</label>
                    <input type='number' value="<?= $data['tahun']; ?>" name='tahun' id='tahun' class="form-control mb-2 text-center">
                </div>
                <div>
                    <label for='karya'></label>
                    <img src="../dbimg/<?= $data['gambar']; ?>" alt="" width="200px">
                </div>
                <div class="text-center">
                    <label for="gambar" class="mb-1">Karya</label>
                    <input type="file" name="gambar" id="gambar" class="form-control mb-2 text-center">
                </div>
                <div>
                    <label for='pelukis' class="mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control mb-2 text-center" rows="5">
                        <?= $data['deskripsi']; ?>
                    </textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" name="simpan" class="btn btn-primary col-md-5 col-sm-12">Ubah</button>
                    <button type="submit" name="hapus" class="btn btn-danger col-md-5 col-sm-12">Hapus</button>
                </div>
            </form>

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
                    $queryupdate = mysqli_query($conn, " UPDATE galeri SET kategori_id='$kategori', nama='$nama', pelukis='$pelukis', tahun='$tahun', deskripsi='$deskripsi' WHERE id=$id ");

                    if ($namafile != '') {
                        if ($imgsize > 5000000) {
                    ?>
                            <div class="alert alert-warning col-md-12 mt-2" role="alert">
                                <i class="bi bi-exclamation-circle-fill"></i> File tidak boleh lebih dari 5 MB
                            </div>
                            <?php
                        } else {
                            if ($filetype != 'jpg' && $filetype != 'png' && $filetype != 'gif') {
                            ?>
                                <div class="alert alert-warning col-md-12 mt-2" role="alert">
                                    <i class="bi bi-exclamation-circle-fill"></i> File wajib berformat .JPG, .PNG, atau .GIF
                                </div>
                                <?php
                            } else {
                                move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetfile);

                                $queryupdate = mysqli_query($conn, " UPDATE galeri SET gambar='$namafile' WHERE id='$id' ");

                                if ($queryupdate) {
                                ?>
                                    <div class="alert alert-success col-md-12 mt-2" role="alert">
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
                    }
                }
            }

            if (isset($_POST['hapus'])) {
                $queryhapus = mysqli_query($conn, "DELETE FROM galeri WHERE id='$id' ");

                if ($queryhapus) {
                    ?>
                    <div class="alert alert-success col-md-12 mt-2" role="alert">
                        <i class="bi bi-check-circle-fill"></i> Karya berhasil dihapus
                    </div>

                    <!-- refresh -->
                    <meta http-equiv="refresh" content="2; url=galeri.php">
            <?php
                }
            }
            ?>
        </div>
    </div>






    <?php require 'footer.php' ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>