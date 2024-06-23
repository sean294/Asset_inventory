<?php

// <----------------------------------- LOCATION DATA ENTRY ------------------------------------>
if (isset($_POST['btn_save_location'])) {
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    if (!preg_match('/^[A-Za-z ]+$/', $location)) {
        echo "<script>alert('Location name letters only!');</script>";
    }else {
        $check_location = $conn->prepare("SELECT * FROM locations where address = ?");
        $check_location->bind_param("s", $location);
        $check_location->execute();
        $result_check_location = $check_location->get_result();

        if ($result_check_location->num_rows > 0) {
            echo "<script>alert('Location already Exist!')</script>";
        }else {
            $insert_department = $conn->prepare("INSERT INTO locations(address) values(?)");
            $insert_department->bind_param("s", $location);

            if ($insert_department->execute()) {
                echo "<script>alert('Location Data Successfully Added!');</script>";
                $location = "";
            }else {
                echo "<script>alert('Something went wrong! Failed to save :ocation Data!')</script>";
            }
        }
    }
}
// <----------------------------------- LOCATION DATA ENTRY ------------------------------------>

// <----------------------------------- LOCATION POPUP MODAL UPDATE ------------------------------------>
if (isset($_POST['location_update'])) {
    try {
        $loc_id = mysqli_real_escape_string($conn, $_POST['loc_id']);

        $select_location = $conn->prepare("SELECT * FROM locations where location_id = ?");
        $select_location->bind_param("i", $loc_id);
        $select_location->execute();
        $select_location_result = $select_location->get_result();

        if ($select_location_result->num_rows > 0) {
            while ($rows = $select_location_result->fetch_assoc()) {
                echo "<div class='form-wrapper'>
                <form action='location.php' method='POST'>
                    <div class='heading'>
                        <h2>Update Location</h2>
                    </div>
                    <div class='inputs'>
                        <label for='loc_id'>Location ID:</label>
                        <input type='text' id='loc_id' name='location_id' required value='".$rows['location_id']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='address'>Address:</label>
                        <input type='text' id='address' name='address' required value='".$rows['address']."'>
                    </div>
                    <div class='btn_submit'>
                        <button type='submit' name='btn_update_location'>Update</button>
                    </div>
                </form>
            </div>";
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- LOCATION POPUP MODAL UPDATE ------------------------------------>


// <----------------------------------- LOCATION UPDATE ------------------------------------>
if (isset($_POST['btn_update_location'])) {
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
// <----------------------------------- LOCATION UPDATE ------------------------------------>