<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: /nb_res/home.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            height: 100vh;
            overflow: hidden;
            justify-content: center;
            align-items: center;
            display: flex;
        }

        .main {
            width: 50%;
            min-width: 380px;
            background: rebeccapurple;
            padding: 20px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="css/gobalstyle.css">
</head>

<body>
    <div class="main">
        <form action="functions/login.php" method="post">
            <div class="title">
                <h2>เข้าสู่ระบบ</h2>
            </div>
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">usrename</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <?php
            if (isset($_GET["error"])) {
                echo "<div class='error mb-2'>ไม่พบพนักงานในระบบ</div>";
            }
            ?>
            <div class="mb-3">
                <center>
                    <button type="submit" name="submit" class="btn btn-primary btn-lg">เข้าสู่ระบบ</button>
                </center>
            </div>
        </form>
    </div>

</body>

</html>