<?php 
include("control/controller.php");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="frameworks/jquery-3.6.0.js"></script>
    <script src="frameworks/select2.min.js"></script>
    <link href="frameworks/select2.min.css" rel="stylesheet">
    <title>Assets Management | Mitsubishi Motors</title>
    <link rel="icon" href="img/mitsubishi1.png" type="image/x-icon">
    <script src="js/script.js"></script>
    <script src="js/select2.js"></script>
</head>
<body>
    <div class="form-container-index">
        <div class="form-wrapper-index">
            <form action="" method="POST">
                <div class="header-index">
                    <div class="hero-img">
                        <img src="img/micei1.png" alt="">
                    </div>
                    
                    <div class="hero-heading">
                        <span>Login Here!</span>
                    </div>
                    
                </div>
                <div class="input">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="btn-submit">
                    <button type="submit" name="login">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>