<?php

// <----------------------------------- EMPLOYEE DATA ENRYU ------------------------------------>
if (isset($_POST['btn_save_employee'])) {
    $emp_no = mysqli_real_escape_string($conn, $_POST['emp_no']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $location_emp = mysqli_real_escape_string($conn, $_POST['location_emp']);
    $position_emp = mysqli_real_escape_string($conn, $_POST['position_emp']);
    $dept_emp = mysqli_real_escape_string($conn, $_POST['dept_emp']);
    $hired_date = mysqli_real_escape_string($conn, $_POST['hired_date']);
    $resigned_date = mysqli_real_escape_string($conn, $_POST['resigned_date']);
    $status_emp = "";

    if (!preg_match('/^[A-Za-z ]+$/', $fname)) {
        echo "<script>alert('Firstname should be letters only!')</script>";
    }elseif (!preg_match('/^[A-Za-z ]+$/', $lname)) {
        echo "<script>alert('Lastname should be letters only!')</script>";
    }elseif (!preg_match('/^[0-9+]+$/', $contact_no)) {
        echo "<script>alert('Contact Number numbers and + sign only!')</script>";
    }else {

        if ($resigned_date !== '') {
            $resigned_date = mysqli_real_escape_string($conn, $_POST['resigned_date']);
            $status_emp = "Unemployed";
        }else {
            $resigned_date = null;
            $status_emp = "Employed";
        }

        $check_fullname = $conn->prepare("SELECT * from employees where fname = ? and mname = ? and lname = ?");
        $check_fullname->bind_param("sss", $fname, $mname, $lname);
        $check_fullname->execute();
        $check_fullname_result = $check_fullname->get_result();

        $check_contact = $conn->prepare("SELECT * FROM employees where contact_no = ?");
        $check_contact->bind_param("s", $contact_no);
        $check_contact->execute();
        $check_contact_result = $check_contact->get_result();

        $check_emp_no = $conn->prepare("SELECT * FROM employees where emp_no = ?");
        $check_emp_no->bind_param("s", $emp_no);
        $check_emp_no->execute();
        $check_emp_no_result = $check_emp_no->get_result();

        if ($check_fullname_result->num_rows > 0) {
            echo "<script>alert('Employee name already Exist!')</script>";
        }elseif ($check_contact_result->num_rows > 0) {
            echo "<script>alert('Contact Number already Exist!')</script>";
        }elseif ($check_emp_no_result->num_rows > 0) {
            echo "<script>alert('Employee Number is already exist!')</script>";
        }else {
            $insert_employee = $conn->prepare("INSERT INTO employees(emp_no, fname, mname, lname, gender, contact_no, location_id, 
            position_id, dept_id, hired_date, resigned_date, status, archived) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_employee->bind_param("ssssssiiissss", $emp_no, $fname, $mname, $lname, $gender, $contact_no, $location_emp, $position_emp,
            $dept_emp, $hired_date, $resigned_date, $status_emp, $const_unarchived);
            
            if ($insert_employee->execute()) {
                echo "<script>alert('Employee Data Successfully Added!')</script>";
                $fname = "";
                $mname = "";
                $lname = "";
                $contact_no = "";
                $emp_no = "";
            }else {
                echo "<script>alert('Something went wrong! Failed to save Asset Data!')</script>";
            }
        }

    }
}
// <----------------------------------- EMPLOYEE DATA ENRYU ------------------------------------>

// <----------------------------------- POPUP MODAL IN EMPLOYEE DATA ------------------------------------>
if (isset($_POST['employee_update'])) {
    try {
        $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);

        $select_employee = $conn->prepare("SELECT 
                                                emp_id,
                                                emp_no,
                                                fname,
                                                lname,
                                                mname,
                                                gender,
                                                contact_no,
                                                loc.address as address,
                                                p.position_name as position,
                                                dept.dept_name as department,
                                                emp.location_id,
                                                emp.position_id,
                                                emp.dept_id,
                                                hired_date,
                                                resigned_date,
                                                emp.status as status
                                            FROM 
                                                employees emp
                                            left join
                                                locations loc on emp.location_id = loc.location_id
                                            left join
                                                positions p on emp.position_id = p.position_id
                                            left join
                                                departments dept on emp.dept_id = dept.dept_id
                                            where
                                                emp_id = ?");
        $select_employee->bind_param("i", $emp_id);
        $select_employee->execute();
        $select_employee_result = $select_employee->get_result();

        if ($select_employee_result->num_rows > 0) {
            while ($rows = $select_employee_result->fetch_assoc()) {
                if ($rows['gender'] == "Male") {
                    $gender = "<option value='Male'>Male</option>
                    <option value='Female'>Female</option>";
                }else {
                    $gender = "<option value='Female'>Female</option>
                    <option value='Male'>Male</option>";
                }

                $position = emp_position("SELECT * FROM positions", 'position_name', 'position_id', $rows['position_id']);

                $location = emp_location("SELECT * FROM locations", 'address', 'location_id', $rows['location_id']);

                $department = emp_department("SELECT * FROM departments", 'dept_name', 'dept_id', $rows['dept_id']);

                echo "<div class='form-wrapper'>
                <form action='employee.php' method='POST'>
                    <div class='heading'>
                        <h2>Update Employee</h2>
                    </div>
                    <div class='inputs'>
                        <label for='emp_id'>Unique ID:</label>
                        <input type='text' id='emp_id' name='emp_id' value='".$rows['emp_id']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='employee_id_no'>Employee ID No:</label>
                        <input type='text' id='employee_id_no' name='emp_no' value='".$rows['emp_no']."'>
                    </div>
                    <div class='inputs'>
                        <label for='firstname'>First Name:</label>
                        <input type='text' id='firstname' name='fname' value='".$rows['fname']."'>
                    </div>
                    <div class='inputs'>
                        <label for='middlename'>Middle Name:</label>
                        <input type='text' id='middlename' name='mname' value='".$rows['mname']."'>
                    </div>
                    <div class='inputs'>
                        <label for='lastname'>Last Name:</label>
                        <input type='text' id='lastname' name='lname' value='".$rows['lname']."'>
                    </div>
                    <div class='inputs'>
                        <label for='gender'>Gender:</label>
                        <select id='gender' class='select_two' name='gender'>
                            $gender
                        </select>
                    </div>
                    <div class='inputs'>
                        <label for='contact'>Contact No:</label>
                        <input type='text' id='contact' name='contact_no' value='".$rows['contact_no']."'>
                    </div>
                    <div class='inputs'>
                        <label for='location'>Location:</label>
                        
                        <select id='location' class='select_two' name='location_emp'>
                            $location 
                        </select>
                    </div>
                    <div class='inputs'>
                        <label for='position'>Position:</label>
                        <select id='position' class='select_two' name='position_emp'>
                            $position
                        </select>
                    </div>
                    <div class='inputs'>
                        <label for='department_id'>Department:</label>
                        <select id='department_id' class='select_two' name='dept_emp'>
                            $department
                        </select>
                    </div>
                    <div class='inputs'>
                        <label for='hired_date'>Hired Date:</label>
                        <input type='date' id='hired_date' name='hired_date' value='".$rows['hired_date']."' required>
                    </div>
                    <div class='inputs'>
                        <label for='resigned_date'>Resigned Date:</label>
                        <input type='date' id='resigned_date' name='resigned_date' value='".$rows['resigned_date']."'>
                    </div>
                    <div class='btn_submit'>
                        <button type='submit' name='btn_update_employee'>Update</button>
                    </div>
                </form>
            </div>
            <script>
            $(document).ready(function() {

                //this is for upgrading select element
                $('.select_two').select2();

                //displaying asset_brandname in maintenance add and asset_assigning add
                $('#asset_id').on('select2:select', function (e) {
                var brandname = $(this).find(':selected').data('brandname');
                console.log(brandname);
                $('#asset_brandname').val(brandname);
                });

            });
            </script>";
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- POPUP MODAL IN EMPLOYEE DATA ------------------------------------>

function emp_position($query, $position_name, $position_id, $selectedValue){
    global $conn;

    $result = $conn->query($query);

    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text = $row[$position_name]; // Use a different variable name to avoid overwriting the function parameter
            $selected = ($row[$position_id] == $selectedValue) ? "selected" : "";
            $options .= "<option value='$row[$position_id]' {$selected}>{$text}</option>";
        }
    }

    return $options;
}

function emp_department($query, $dept_name, $dept_id, $selectedValue){
    global $conn;

    $result = $conn->query($query);

    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text = $row[$dept_name]; // Use a different variable name to avoid overwriting the function parameter
            $selected = ($row[$dept_id] == $selectedValue) ? "selected" : "";
            $options .= "<option value='$row[$dept_id]' {$selected}>{$text}</option>";
        }
    }

    return $options;
}

function emp_location($query, $address, $location_id, $selectedValue){
    global $conn;

    $result = $conn->query($query);

    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text = $row[$address]; // Use a different variable name to avoid overwriting the function parameter
            $selected = ($row[$location_id] == $selectedValue) ? "selected" : "";
            $options .= "<option value='$row[$location_id]' {$selected}>{$text}</option>";
        }
    }

    return $options;
}

// <----------------------------------- UPDATE EMPLOYEE DATA ------------------------------------>
if (isset($_POST['btn_update_employee'])) {
    try {
        $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
        $emp_no = mysqli_real_escape_string($conn, $_POST['emp_no']);
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $mname = mysqli_real_escape_string($conn, $_POST['mname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $location_emp = mysqli_real_escape_string($conn, $_POST['location_emp']);
        $position_emp = mysqli_real_escape_string($conn, $_POST['position_emp']);
        $dept_emp = mysqli_real_escape_string($conn, $_POST['dept_emp']);
        $hired_date = mysqli_real_escape_string($conn, $_POST['hired_date']);
        $resigned_date = mysqli_real_escape_string($conn, $_POST['resigned_date']);
        $status_emp = '';

        if (!preg_match('/^[A-Za-z ]+$/', $fname)) {
            echo "<script>alert('Firstname should be letters only!')</script>";
        }elseif (!preg_match('/^[A-Za-z ]+$/', $mname)) {
            echo "<script>alert('Middlename should be letters only!')</script>";
        }elseif (!preg_match('/^[A-Za-z ]+$/', $lname)) {
            echo "<script>alert('Lastname should be letters only!')</script>";
        }elseif (!preg_match('/^[0-9+]+$/', $contact_no)) {
            echo "<script>alert('Contact Number numbers and + sign only!')</script>";
        }else {
            $check_fullname = $conn->prepare("SELECT * from employees where fname = ? and mname = ? and lname = ? and emp_id != ?");
            $check_fullname->bind_param("sssi", $fname, $mname, $lname, $emp_id);
            $check_fullname->execute();
            $check_fullname_result = $check_fullname->get_result();

            $check_contact = $conn->prepare("SELECT * FROM employees where contact_no = ? and emp_id != ?");
            $check_contact->bind_param("si", $contact_no, $emp_id);
            $check_contact->execute();
            $check_contact_result = $check_contact->get_result();

            $check_emp_no = $conn->prepare("SELECT * FROM employees where emp_no = ? and emp_id != ?");
            $check_emp_no->bind_param("si", $emp_no, $emp_id);
            $check_emp_no->execute();
            $check_emp_no_result = $check_emp_no->get_result();

            $check_assign_asset = $conn->prepare("SELECT * FROM assets_assignments where emp_id = ? and status = 'In Used'");
            $check_assign_asset->bind_param("i", $emp_id);
            $check_assign_asset->execute();
            $check_assign_asset_result = $check_assign_asset->get_result();

            if ($check_fullname_result->num_rows > 0) {
                echo "<script>alert('Employee name already Exist!')</script>";
            }elseif ($check_contact_result->num_rows > 0) {
                echo "<script>alert('Contact Number already Exist!')</script>";
            }elseif ($check_emp_no_result->num_rows > 0) {
                echo "<script>alert('Employee number already exist!')</script>";
            }elseif ($check_assign_asset_result->num_rows > 0) {
                echo "<script>alert('This employee cannot be resigned because there are still some assets assigned to them.')</script>";
            }else {

                if ($resigned_date !== '') {
                    $resigned_date = mysqli_real_escape_string($conn, $_POST['resigned_date']);
                    $status_emp = "Unemployed";
                }else {
                    $resigned_date = null;
                    $status_emp = "Employed";
                }   

                $update_employee = $conn->prepare("UPDATE employees SET emp_no = ?, fname = ?, mname = ?, lname = ?, gender = ?, contact_no = ?, 
                location_id = ?, position_id = ?, dept_id = ?, hired_date = ?, resigned_date = ?, status = ? where emp_id = ?");
                $update_employee->bind_param("ssssssiiisssi", $emp_no, $fname, $mname, $lname, $gender, $contact_no, $location_emp, $position_emp,
                $dept_emp, $hired_date, $resigned_date, $status_emp, $emp_id);
                
                if ($update_employee->execute()) {
                    if ($status_emp == 'Unemployed') {
                        $update_asset_assign = $conn->prepare("UPDATE assets_assignments SET status = 'Returned' where emp_id = ?");
                        $update_asset_assign->bind_param("i", $emp_id);
                        
                        $update_asset = $conn->prepare("UPDATE assets SET status = 'Returned(Not Used)' where asset_id in (SELECT asset_id 
                        FROM assets_assignments WHERE emp_id = ?)");
                        $update_asset->bind_param("i", $emp_id);

                        if ($update_asset_assign->execute()) {
                            echo "<script>console.log('Success Asset Assign')</script>";
                        }else {
                            echo "<script>console.log('unSuccess Asset Assign')</script>";
                        }
                        if ($update_asset->execute()) {
                            echo "<script>console.log('Success Asset')</script>";
                        }else {
                            echo "<script>console.log('unSuccess Asset ')</script>";
                        }
                       
                    }
                    echo "<script>alert('Employee Data Successfully Updated!')</script>";

                }else {
                    echo "<script>alert('Something went wrong! Failed to save Asset Data!')</script>";
                }
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }

}
// <----------------------------------- UPDATE EMPLOYEE DATA ------------------------------------>


// <----------------------------------- UPDATE THE EMPLOYEE DATA TO ARCHIVED ------------------------------------>
if (isset($_POST['employee_archived'])){
    try {
        $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
        $emp_status = mysqli_real_escape_string($conn, $_POST['emp_status']);

        if ($emp_status == "Employed") {
            echo "<script>alert('Cannot archived this data!')</script>";
        }else {
            $update_emp = $conn->prepare("UPDATE employees SET archived = ? where emp_id = ?");
            $update_emp->bind_param("si", $const_archived, $emp_id);

            if ($update_emp->execute()) { 
                echo "<script>window.location.reload();</script>";
            }else {
                echo "<script>alert('Something went wrong! Failed to update Asset Data!')</script>";
            }
        }



    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE THE EMPLOYEE DATA TO ARCHIVED ------------------------------------>


// <----------------------------------- TO UPDATE THE EMPLOYEE DATA TO UNARCHIVED ------------------------------------>
if (isset($_POST['employee_unarchived'])){
    try {
        $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
        $emp_status = mysqli_real_escape_string($conn, $_POST['emp_status']);

        $update_emp = $conn->prepare("UPDATE employees SET archived = ? where emp_id = ?");
        $update_emp->bind_param("si", $const_unarchived, $emp_id);

        if ($update_emp->execute()) { 
            echo "<script>window.location.reload();</script>";
        }else {
            echo "<script>alert('Something went wrong! Failed to update Asset Data!')</script>";
        }

    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- TO UPDATE THE EMPLOYEE DATA TO UNARCHIVED ------------------------------------>

// <----------------------------------- SEARCH UNARCHIVED EMPLOYEES ------------------------------------>
if (isset($_POST['search_employee_unarchived'])) {
    $query_employee = mysqli_real_escape_string($conn, $_POST['query_employee']);

    $query_employee = '%' . $query_employee . '%'; 
    if ($query_employee !== '') {
        $query_employee = '%' . $query_employee . '%'; 
        $archived = $const_unarchived;
    }else {
        $query_employee = '%' . $query_employee . '%'; 
        $archived = $const_unarchived;
    }

    $employee_srch = $conn->prepare("SELECT 
                                        emp_id,
                                        emp_no,
                                        CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                        gender,
                                        contact_no,
                                        loc.address as address,
                                        p.position_name as position,
                                        dept.dept_name as department,
                                        hired_date,
                                        resigned_date,
                                        status
                                    FROM 
                                        employees emp
                                    left join
                                        locations loc on emp.location_id = loc.location_id
                                    left join
                                        positions p on emp.position_id = p.position_id
                                    left join
                                        departments dept on emp.dept_id = dept.dept_id
                                    where
                                        (CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) LIKE ? OR emp_no LIKE ?)
                                    and
                                        emp.archived = ?");
    $employee_srch->bind_param("sss", $query_employee, $query_employee, $archived);
    $employee_srch->execute();
    $employee_srch_res = $employee_srch->get_result();
    $no = 1;

    if ($employee_srch_res->num_rows > 0) {
        while ($rows = $employee_srch_res->fetch_assoc()) {
            if ($rows['resigned_date'] !== null) {
                // Display the date normally
                $resigned_date =  date("F d, Y", strtotime($rows['resigned_date']));
            } else {
                // Display a message indicating that the date is not available
                $resigned_date =  "";
            }
            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td hidden class='emp_id'>".$rows['emp_id']."</td>
                <td>".$rows['emp_no']."</td>
                <td>".$rows['full_name']."</td>
                <td>".$rows['contact_no']."</td>
                <td>".$rows['address']."</td>
                <td>".$rows['position']."</td>
                <td>".$rows['department']."</td>
                <td>".date("F d, Y", strtotime($rows['hired_date']))."</td>
                <td>".$resigned_date."</td>
                <td class='emp_status'>".$rows['status']."</td>
                <td class='emp_td td_button'><input type='button' class='edit btn_action' value='Edit'>
                </td>
                <td class='emp_archived_td td_button'><input type='button' class='archived btn_action'
                        value='Archived'></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH UNARCHIVED EMPLOYEES ------------------------------------>

// <----------------------------------- SEARCH ARCHIVED EMPLOYEES ------------------------------------>
if (isset($_POST['search_employee_archived'])) {
    $query_employee = mysqli_real_escape_string($conn, $_POST['query_employee']);

    $query_employee = '%' . $query_employee . '%'; 
    if ($query_employee !== '') {
        $query_employee = '%' . $query_employee . '%'; 
        $archived = $const_archived;
    }else {
        $query_employee = '%' . $query_employee . '%'; 
        $archived = $const_archived;
    }

    $employee_srch = $conn->prepare("SELECT 
                                        emp_id,
                                        emp_no,
                                        CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                        gender,
                                        contact_no,
                                        loc.address as address,
                                        p.position_name as position,
                                        dept.dept_name as department,
                                        hired_date,
                                        resigned_date,
                                        status
                                    FROM 
                                        employees emp
                                    left join
                                        locations loc on emp.location_id = loc.location_id
                                    left join
                                        positions p on emp.position_id = p.position_id
                                    left join
                                        departments dept on emp.dept_id = dept.dept_id
                                    where
                                        (CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) LIKE ? OR emp_no LIKE ?)
                                    and
                                        emp.archived = ?");
    $employee_srch->bind_param("sss", $query_employee, $query_employee, $archived);
    $employee_srch->execute();
    $employee_srch_res = $employee_srch->get_result();
    $no = 1;

    if ($employee_srch_res->num_rows > 0) {
        while ($rows = $employee_srch_res->fetch_assoc()) {
            if ($rows['resigned_date'] !== null) {
                // Display the date normally
                $resigned_date =  date("F d, Y", strtotime($rows['resigned_date']));
            } else {
                // Display a message indicating that the date is not available
                $resigned_date =  "";
            }
            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td hidden class='emp_id'>".$rows['emp_id']."</td>
                <td>".$rows['emp_no']."</td>
                <td>".$rows['full_name']."</td>
                <td>".$rows['contact_no']."</td>
                <td>".$rows['address']."</td>
                <td>".$rows['position']."</td>
                <td>".$rows['department']."</td>
                <td>".date("F d, Y", strtotime($rows['hired_date']))."</td>
                <td>".$resigned_date."</td>
                <td class='emp_status'>".$rows['status']."</td>
                <td class='maintenance_td_unarchived td_button'><input type='button' class='archived btn_action'
                        value='Unarchived'></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH ARCHIVED EMPLOYEES ------------------------------------>
