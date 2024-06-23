<?php

// <----------------------------------- USER DATA ENTRY ------------------------------------>
if (isset($_POST['btn_save_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);

    if (!preg_match('/^[A-za-z0-9]+$/', $username)) {
        echo "<script>alert('Username should be letters and numbers only!')</script>";
    }elseif (!preg_match('/^[A-za-z0-9 ]+$/', $password)) {
        echo "<script>alert('Password should be letters and numbers only!')</script>";
    }else {
        $check_username = $conn->prepare("SELECT * from users where username = ?");
        $check_username->bind_param("s", $username);
        $check_username->execute();
        $check_username_result = $check_username->get_result();

        $check_emp_id = $conn->prepare("SELECT * FROM users where emp_id = ?");
        $check_emp_id->bind_param("s", $emp_id);
        $check_emp_id->execute();
        $check_emp_id_result = $check_emp_id->get_result();

        if ($check_username_result->num_rows > 0) {
            echo "<script>alert('Username already Exist!')</script>";
        }elseif ($check_emp_id_result->num_rows > 0) {
            echo "<script>alert('Employee selection already Exist!')</script>";
        }else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert_employee = $conn->prepare("INSERT INTO users(username, password, emp_id) values(?, ?, ?)");
            $insert_employee->bind_param("ssi", $username, $hashPassword, $emp_id);
            
            if ($insert_employee->execute()) {
                echo "<script>alert('Users Data Successfully Added!')</script>";
                $username = "";
                $password = "";
                $co_password = "";
            }else {
                echo "<script>alert('Something went wrong! Failed to save Asset Data!')</script>";
            }
        }

    }
}
// <----------------------------------- USER DATA ENTRY ------------------------------------>

// <----------------------------------- USER POPUP MODAL UPDATE ------------------------------------>
if (isset($_POST['user_update'])) {
    try {
        $uid = mysqli_real_escape_string($conn, $_POST['user_id']);

        $select_users = $conn->prepare("SELECT * FROM users where user_id = ?");
        $select_users->bind_param("i", $uid);
        $select_users->execute();
        $select_users_result = $select_users->get_result();

        if ($select_users_result->num_rows > 0) {
            while ($rows = $select_users_result->fetch_assoc()) {
                echo "<div class='form-wrapper'>
                <form action='user.php' method='POST'>
                    <div class='heading'>
                        <h2>New Users</h2>
                    </div>
                    <div class='inputs'>
                        <label for='uid'>User ID:</label>
                        <input type='text' id='uid' name='uid' value='".$rows['user_id']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='username'>Username:</label>
                        <input type='text' id='username' name='username' value='".$rows['username']."'>
                    </div>
                    <div class='inputs'>
                        <label for='password'>Password:</label>
                        <input type='password' id='password' name='password' value=''>
                        <div class='show_password'>
                            <input type='checkbox' onclick='myFunction()'>Show Password
                        </div>
                    </div>
                    <div class='btn_submit'>
                        <button type='submit' name='btn_update_user'>Update</button>
                    </div>
                </form>
            </div>
            <script>
                function myFunction() {
                var x = document.getElementById('password');
                if (x.type === 'password') {
                    x.type = 'text';
                } else {
                    x.type = 'password';
                }
                }
            </script>";
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- USER POPUP MODAL UPDATE ------------------------------------>

// <----------------------------------- USER UPDATE ------------------------------------>
if (isset($_POST['btn_update_user'])) {
    try {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $uid = mysqli_real_escape_string($conn, $_POST['uid']);

        if (!preg_match('/^[A-za-z0-9]+$/', $username)) {
            echo "<script>alert('Username should be letters and numbers only!')</script>";
        }elseif (!preg_match('/^[A-za-z0-9 ]+$/', $password)) {
            echo "<script>alert('Password should be letters and numbers only!')</script>";
        }else {
            $check_username = $conn->prepare("SELECT * from users where username = ? and user_id != ?");
            $check_username->bind_param("si", $username, $uid);
            $check_username->execute();
            $check_username_result = $check_username->get_result();
    
            if ($check_username_result->num_rows > 0) {
                echo "<script>alert('Username already Exist!')</script>";
            }else {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $update_user = $conn->prepare("UPDATE users SET user_id = ?, username = ?, password = ? where user_id = ?");
                $update_user->bind_param("issi", $uid, $username, $hashPassword, $uid);
                if ($update_user->execute()) {
                    echo "<script>alert('Successfully updated users data!');</script>";
                }else {
                    echo "<script>alert('Something went wrong! Failed to update users data!". $conn->error. "');</script>";
                }
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- USER UPDATE ------------------------------------>

// <----------------------------------- LOGIN ------------------------------------>
if (isset($_POST['login'])) {
    try {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    
        $user = $conn->prepare("SELECT 
                                    u.user_id as user_id,
                                    u.username, 
                                    u.password,
                                    emp.emp_id,
                                    emp.fname as 'fname',
                                    p.position_name as 'position'
                                FROM 
                                    users u
                                LEFT JOIN
                                    employees emp on emp.emp_id = u.emp_id
                                LEFT JOIN
                                    positions p on p.position_id = emp.position_id
                                WHERE 
                                    u.username = ?");
        $user->bind_param("s", $username);
        $user->execute();
        $result = $user->get_result();

        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $hash_pass = $rows['password'];
            if (password_verify($password, $hash_pass)) {
                $_SESSION['username'] = $username;
               
                if (in_array($rows['position'], ["Admin", "Supervisor", "President", "IT"])) {
                    header("Location: main/home.php");
                    exit();
                } else {
                    echo "<script>alert('You do not have the required permissions to login!');</script>";
                }
            } else {
                echo "<script>alert('Incorrect username or password.');</script>";
            }
        } else {
            echo "<script>alert('No user found with that username.');</script>";
        }
        
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }   
}

// <----------------------------------- LOGIN ------------------------------------>