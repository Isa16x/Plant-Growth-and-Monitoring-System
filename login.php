<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Design your garden - Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.css">
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis:wght@200&family=Montserrat:wght@200&family=Sacramento&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Tangerine&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Great+Vibes&family=Sacramento&family=Tangerine&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include "conectarebd.php";
    ?>
    <?php include "meniu.php"; ?>
    <br><br><br><br>

    <h1 class="titlu_graph">Login</h1>
    <br><br><br>

    <div class="page_interior">
        <?php
        if (isset($_POST['btn_login'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];
            $sql = "SELECT * from users where email = '$email'";
            $result = mysqli_query($link2, $sql);
            $resultCheck = mysqli_num_rows($result);
            $canproceed = 1;
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $emailbd = $row['email'];
                    $passwordbd = $row['password'];
                }
            }
            if ($emailbd == $email && $passwordbd == $password) {
                // $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;
                echo "<script type='text/javascript'> window.location.href = 'index.php';</script>";
            }
            if ($emailbd != $email || $passwordbd != $password) {
                echo "Wrong data for login";
            }
            if ($email == '' || $password == '') {
                echo "Please fill in all fields";
            }
        }
        ?>
        <div class="register_form">
            <form action="login.php" method="POST" class="form-horizontal">
                <br>
                <br><br><br>
                <div class="form-plant-register">
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label-plant" style="margin-left:0.2px;">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control-plant" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label-plant">Password:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control-plant" id="password" name="password" required>
                        </div>
                    </div>
                    <br>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary btn-register" id="btn_login" name="btn_login" style="margin-top:15px">Login</button>
                    </div>
                </div>
                <br>
            </form>
        </div>

    </div>
    <br>



    <script src="jquery-3.6.1.js"></script>
</body>

</html>