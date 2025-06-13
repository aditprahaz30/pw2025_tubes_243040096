<?php
session_start();
require "../db/database.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>Document</title>
</head>
<style>
    .main {
        height: 100vh;
    }

    .login-box {
        width: 500px;
        height: 300px;
        border-radius: 10px;
        box-sizing: border-box;
    }

    .login-box label {
        border-radius: 20px;
    }
</style>

<body>

    <div class="main d-flex  flex-column justify-content-center align-items-center">
        <div class="login-message text-center ">
            <?php
            if (isset($_POST['login-btn'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($conn, "SELECT * FROM admin where username= '$username' ");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);

                if ($countdata > 0) {
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: index.php');
                    } else {
            ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i> Username atau password salahi
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Akun tidak ada
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="login-box p-5 shadow">
            <form action="" method="post">

                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" autocomplete="off">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off">
                </div>
                <div>
                    <button type="submit" class="btn btn-success form-control mt-4 " name="login-btn">Login</button>
                </div>
            </form>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>