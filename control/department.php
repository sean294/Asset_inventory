<?php

// <----------------------------------- DEPARTMENT DATA ENTRY ------------------------------------>
if (isset($_POST['btn_save_department'])) {
    $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);

    if (!preg_match('/^[A-Za-z ]+$/', $department_name)) {
        echo "<script>alert('Letters only!');</script>";
    }else {
        $check_department = $conn->prepare("SELECT * FROM departments where dept_name = ?");
        $check_department->bind_param("s", $department_name);
        $check_department->execute();
        $result_check_department = $check_department->get_result();

        if ($result_check_department->num_rows > 0) {
            echo "<script>alert('Department name already Exist!')</script>";
        }else {
            $insert_department = $conn->prepare("INSERT INTO departments(dept_name) values(?)");
            $insert_department->bind_param("s", $department_name);

            if ($insert_department->execute()) {
                echo "<script>alert('Department Data Successfully Added!');</script>";
                $department_name = "";
            }else {
                echo "<script>alert('Something went wrong! Failed to save Department Data!')</script>";
            }
        }
    }
}
// <----------------------------------- DEPARTMENT DATA ENTRY ------------------------------------>

// <----------------------------------- DEPARTMENT POPUP MODAL UPDATE ------------------------------------>
if (isset($_POST['department_update'])) {
    try {
        $dept_id = mysqli_real_escape_string($conn, $_POST['department_id']);

        $select_department = $conn->prepare("SELECT * FROM departments where dept_id = ?");
        $select_department->bind_param("i", $dept_id);
        $select_department->execute();
        $select_department_result = $select_department->get_result();

        if ($select_department_result->num_rows > 0) {
            while ($rows = $select_department_result->fetch_assoc()) {
                echo "<div class='form-wrapper'>
                <form action='department.php' method='POST'>
                    <div class='heading'>
                        <h2>Update Department</h2>
                    </div>
                    <div class='inputs'>
                        <label for='dept_id'>Department ID:</label>
                        <input type='text' id='dept_id' name='dept_id' required value='".$rows['dept_id']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='department_name'>Department Name:</label>
                        <input type='text' id='department_name' name='department_name' required value='".$rows['dept_name']."'>
                    </div>
                    <div class='btn_submit'>
                        <button type='submit' name='btn_update_department'>Update</button>
                    </div>
                </form>
            </div>";
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- DEPARTMENT POPUP MODAL UPDATE ------------------------------------>

// <----------------------------------- DEPARTMENT UPDATE------------------------------------>
if (isset($_POST['btn_update_department'])) {
    try {
        $dept_id = mysqli_real_escape_string($conn, $_POST['dept_id']);
        $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);

        if (!preg_match('/^[A-Za-z ]+$/', $department_name)) {
            echo "<script>alert('Letters only!');</script>";
        }else {
            $check_department = $conn->prepare("SELECT * FROM departments where dept_name = ? and dept_id != ?");
            $check_department->bind_param("si", $department_name, $dept_id);
            $check_department->execute();
            $result_check_department = $check_department->get_result();
    
            if ($result_check_department->num_rows > 0) {
                echo "<script>alert('Department name already Exist!')</script>";
            }else {
                $update_department = $conn->prepare("UPDATE departments SET dept_id = ?, dept_name = ? where dept_id = ?");
                $update_department->bind_param("isi", $dept_id, $department_name, $dept_id);
                if ($update_department->execute()) {
                    echo "<script>alert('Successfully updated department data!');</script>";
                }else {
                    echo "<script>alert('Something went wrong! Failed to update department data!". $conn->error. "');</script>";
                }
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- DEPARTMENT UPDATE------------------------------------>