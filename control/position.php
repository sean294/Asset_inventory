<?php

// <----------------------------------- POSITION DATA ENTRY ------------------------------------>
if (isset($_POST['btn_save_position'])) {
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    if (!preg_match('/^[A-Za-z ]+$/', $position)) {
        echo "<script>alert('Position name letters only!');</script>";
    }else {
        $check_position = $conn->prepare("SELECT * FROM positions where position_name = ?");
        $check_position->bind_param("s", $position);
        $check_position->execute();
        $result_check_position = $check_position->get_result();

        if ($result_check_position->num_rows > 0) {
            echo "<script>alert('Position already Exist!')</script>";
        }else {
            $insert_position = $conn->prepare("INSERT INTO positions(position_name) values(?)");
            $insert_position->bind_param("s", $position);

            if ($insert_position->execute()) {
                echo "<script>alert('Position Data Successfully Added!');</script>";
                $position = "";
            }else {
                echo "<script>alert('Something went wrong! Failed to save Position Data!')</script>";
            }
        }
    }
}
// <----------------------------------- POSITION DATA ENTRY ------------------------------------>

// <----------------------------------- POSITION POPUP MODAL UPDATE ------------------------------------>
if (isset($_POST['position_update'])) {
    try {
        $position_id = mysqli_real_escape_string($conn, $_POST['position_id']);

        $select_position = $conn->prepare("SELECT * FROM positions where position_id = ?");
        $select_position->bind_param("i", $position_id);
        $select_position->execute();
        $select_position_result = $select_position->get_result();

        if ($select_position_result->num_rows > 0) {
            while ($rows = $select_position_result->fetch_assoc()) {
                echo "<div class='form-wrapper'>
                <form action='position.php' method='POST'>
                    <div class='heading'>
                        <h2>Update Position</h2>
                    </div>
                    <div class='inputs'>
                        <label for='position_id'>Position ID:</label>
                        <input type='text' id='position_id' name='position_id' required value='".$rows['position_id']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='position_name'>Position Name:</label>
                        <input type='text' id='position_name' name='position_name' required value='".$rows['position_name']."'>
                    </div>
                    <div class='btn_submit'>
                        <button type='submit' name='btn_update_position'>Update</button>
                    </div>
                </form>
            </div>";
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- POSITION POPUP MODAL UPDATE ------------------------------------>

// <----------------------------------- POSITION UPDATE ------------------------------------>
if (isset($_POST['btn_update_position'])) {
    try {
        $loc_id = mysqli_real_escape_string($conn, $_POST['location_id']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        if (!preg_match('/^[A-Za-z ]+$/', $address)) {
            echo "<script>alert('Letters only!');</script>";
        }else {
            $check_location = $conn->prepare("SELECT * FROM locations where address = ? and location_id != ?");
            $check_location->bind_param("si", $address, $loc_id);
            $check_location->execute();
            $result_check_location = $check_location->get_result();
    
            if ($result_check_location->num_rows > 0) {
                echo "<script>alert('Department name already Exist!')</script>";
            }else {
                $update_location = $conn->prepare("UPDATE locations SET location_id = ?, address = ? where location_id = ?");
                $update_location->bind_param("isi", $loc_id, $address, $loc_id);
                if ($update_location->execute()) {
                    echo "<script>alert('Successfully updated location data!');</script>";
                }else {
                    echo "<script>alert('Something went wrong! Failed to update location data!". $conn->error. "');</script>";
                }
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- POSITION UPDATE ------------------------------------>