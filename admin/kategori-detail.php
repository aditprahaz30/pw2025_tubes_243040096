<?php
require "session.php";
require "../db/database.php";

// detail kategori
$id = $_GET['i'];

$query = mysqli_query($conn, "SELECT * FROM kategori WHERE id='$id' ");
$data = mysqli_fetch_array($query);

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


<body>
    <?php require "navbar.php" ?>

    <div class=" d-flex  flex-column justify-content-center align-items-center mt-5 text-center">
        <h2>Ubah</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control mt-2 text-center" value="<?= $data['nama']; ?>">
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2 ">
                    <button type="submit" class="col-6 col-md-5 col-sm-4 btn btn-primary " name="edit-btn">Ubah</button>
                    <button type="submit" class="col-6 col-md-5 col-sm-4 btn btn-danger" name="delete-btn">Hapus</button>

                </div>


            </form>

            <?php
            if (isset($_POST['edit-btn'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                if ($data['nama'] == $kategori) {
            ?>
                    <meta http-equiv="refresh" content="0; url=kategori.php">
                    <?php
                } else {
                    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE nama ='$kategori'");
                    $jumlahdata = mysqli_num_rows($query);

                    if ($jumlahdata > 0) {
                    } else {
                        $querysimpan = mysqli_query($conn, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                        if ($querysimpan) {
                    ?>
                            <div class="alert alert-success mt-2" role="alert">
                                <i class="bi bi-check-circle-fill"></i> Kategori berhasil diubah
                            </div>

                            <!-- refresh -->
                            <meta http-equiv="refresh" content="2; url=kategori.php">
                    <?php
                        } else {
                            echo mysqli_error($conn);
                        }
                    }
                }
            }

            // delete
            if (isset($_POST['delete-btn'])) {
                $querycheck = mysqli_query($conn, "SELECT * FROM galeri WHERE kategori_id='$id'");
                $datacount = mysqli_num_rows($querycheck);

                if ($datacount > 0) {
                    ?>
                    <div class="alert alert-danger mt-2" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Kategori tidak bisa dihapus karena sudah digunakan di produk
                    </div>
                <?php
                    die();
                }

                $querydelete = mysqli_query($conn, "DELETE FROM kategori WHERE id='$id'");

                if ($querydelete) {
                ?>
                    <div class="alert alert-success mt-2" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Kategori berhasil dihapus
                    </div>


                    <!-- refresh -->
                    <meta http-equiv="refresh" content="2; url=kategori.php">
            <?php
                } else {
                    echo mysqli_error($conn);
                }
            }
            ?>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>