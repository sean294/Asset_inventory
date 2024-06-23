<?php 
    include("../control/controller.php");
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }else {
        header("Location: ../index.php");
        exit();
    }

    $dp_name = $conn->prepare("SELECT u.username, CONCAT(emp.fname, ' ', COALESCE(emp.mname, ''), ' ', emp.lname) as full_name from users u
    left join employees emp on u.emp_id = emp.emp_id where u.username = ?");
    $dp_name->bind_param("s", $username);
    $dp_name->execute();
    $dp_name_res = $dp_name->get_result();
    $dp_name_res->num_rows > 0;
    $rows = $dp_name_res->fetch_assoc();
    $fullname = $rows['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../frameworks/jquery-3.6.0.js"></script>
    <script src="../frameworks/select2.min.js"></script>
    <link href="../frameworks/select2.min.css" rel="stylesheet">
    <title>Assets Management | Mitsubishi Motors</title>
    <link rel="icon" href="../img/mitsubishi1.png" type="image/x-icon">
    <script src="../js/script.js"></script>
    <script src="../js/archived.js"></script>
    <script src="../js/unarchived.js"></script>
    <script src="../js/select2.js"></script>
    
</head>
<body>

    <div class="header">
        <header>
            <div class="hero-title">
                <h2>Asset Management</h2>
                <img src="../img/mitsubishi.png" alt="logo1" class="mitsubishi">
                <img src="../img/micei1.png" alt="logo2" class="micei">
            </div>
            <div class="user-setting">
                <p>Hi <?php echo $fullname; ?> &#9660;</p>
            </div>
        </header>
    </div>
    <div class="container">
        <div class="navbar">
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="asset_assign.php">Assets Assigns</a></li>
                    <li><a href="asset.php">Assets</a></li>
                    <li><a href="employee.php">Employees</a></li>
                    <li><a href="maintenance.php">Maintenance</a></li>
                    <li><a href="user.php">Users</a></li>
                    <li><a href="department.php">Department</a></li>
                    <li><a href="position.php">Positions</a></li>
                    <li><a href="location.php">Locations</a></li>
                    <li><a href="depreciation.php">Depreciation</a></li>
                    <li style="width:10%;"><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-body">
        <div class="hero-home">
            <div class="nav-home">
                <i class="fa fa-home" aria-hidden="true"
                    style="font-size:2.5em;position:absolute;top:0;left:0;padding-left:10px"></i>
                &nbsp;
                <span><a href="../main/home.php">Home</a></span>