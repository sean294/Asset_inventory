<?php


// <----------------------------------- DATA ENTRY FOR ASSETS ASSIGN ------------------------------------>
if (isset($_POST['btn_save_asset_assign'])) {

    $asset_emp_id_assign = mysqli_real_escape_string($conn, $_POST['asset_assign_emp_id']);
    $asset_id_assign = mysqli_real_escape_string($conn, $_POST['asset_id_assign']);
    $dep_price = mysqli_real_escape_string($conn, $_POST['dep_price']);
    $asset_assign_date = mysqli_real_escape_string($conn, $_POST['assign_date']);
    $asset_assign_return_date = mysqli_real_escape_string($conn, $_POST['assign_returned_date']);
    $archived_assign = "Unarchived";
    

    $check_asset_assign_id = $conn->prepare("SELECT * FROM assets_assignments where asset_id = ? and status in ('In Used', 'Damaged')");
    $check_asset_assign_id->bind_param("i", $asset_id_assign);
    $check_asset_assign_id->execute();
    $check_asset_assign_id_result = $check_asset_assign_id->get_result();
    
    if ($check_asset_assign_id_result->num_rows > 0) {
        echo "<script>alert('This asset already been assigned!')</script>";
    }elseif (empty($asset_id_assign) || $asset_id_assign == '') {
        echo "<script>alert('Asset Not Found!')</script>";
    } else{

        if ($asset_assign_return_date !== '') {
            $asset_assign_return_date = mysqli_real_escape_string($conn, $_POST['assign_returned_date']);
            $status_assign = "Returned";
        }else {
            $asset_assign_return_date = null;
            $status_assign = "In Used";
        }

        $insert_asset_assign = $conn->prepare("INSERT INTO assets_assignments(asset_id, emp_id, depreciation_value, assign_date, 
        return_date, status, archived) values(?, ?, ?, ?, ?, ?, ?)");
        $insert_asset_assign->bind_param("iiissss", $asset_id_assign, $asset_emp_id_assign, $dep_price, $asset_assign_date, 
        $asset_assign_return_date, $status_assign, $archived_assign);

        if ($insert_asset_assign->execute()) {
            echo "<script>alert('Data successfully added!');</script>";

            $select_asset_status = $conn->prepare("SELECT status FROM assets WHERE asset_id = ?");
            $select_asset_status->bind_param("i", $asset_id_assign);
            $select_asset_status->execute();
            $select_asset_status_res = $select_asset_status->get_result();

            if ($select_asset_status_res->num_rows > 0) {
                $row = $select_asset_status_res->fetch_assoc();
                $current_status = $row['status'];
                if ($current_status === "Not Used" && $status_assign === "In Used") {
                    $status_asset = "In Used";
                }
                if ($current_status === "In Used" && $status_assign === "In Used") {
                    $status_asset = "In Used";
                }
                if ($current_status === "Maintenance(Not Used)" && $status_assign === "In Used") {
                    $status_asset = "Maintenance(In Used)";
                }
                if ($current_status === "Repaired(Not Used)" && $status_assign === "In Used") {
                    $status_asset = "Repaired(In Used)";
                }
                if ($current_status === "Returned(Not Used)" && $status_assign === "In Used") {
                    $status_asset = "In Used";
                }
                if ($status_assign === "Returned") {
                    $status_asset = "Returned(Not Used)";
                }
            }
            
            $update_assets = $conn->prepare("UPDATE assets set status = ? where asset_id = ?");
            $update_assets->bind_param("si", $status_asset, $asset_id_assign);
            $update_assets->execute();

            $asset_assign_date = "";
            $asset_assign_return_date = "";

            
        }else {
            echo "<script>alert('Something went wrong! Failed to save Data!');</script>";
        }
    }
}
// <----------------------------------- DATA ENTRY FOR ASSETS ASSIGN ------------------------------------>


// <----------------------------------- POPUP MODAL FOR ASSET_ASSIGN ------------------------------------>
if (isset($_POST['assets_assign_update'])) {
    try {
        $asset_assign_id = mysqli_real_escape_string($conn, $_POST['asset_assign_id']);

        $select_assign = $conn->prepare("SELECT
                                            assets_assign_id as assign_id,
                                            asset.asset_id as asset_id,
                                            emp.emp_id as emp_id,
                                            asset.asset_brandname as brandname,
                                            asset.barcode_number as barcode,
                                            CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                            assign_date,
                                            return_date,
                                            assign.depreciation_value,
                                            asset.barcode_number,
                                            asset.asset_brandname,
                                            assign.status as status
                                        from 
                                            assets_assignments assign
                                        left join
                                            assets asset on assign.asset_id = asset.asset_id
                                        left join
                                            employees emp on assign.emp_id = emp.emp_id
                                        where 
                                            assets_assign_id = ?");
                                    $select_assign->bind_param("i", $asset_assign_id);
                                    $select_assign->execute();
                                    $select_assign_result = $select_assign->get_result();

        if ($select_assign_result->num_rows > 0) {
            while ($rows = $select_assign_result->fetch_assoc()) {
                
                $employees = assign_employees("SELECT emp_id, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name 
                FROM employees", 'full_name', 'emp_id', $rows['emp_id']);

                $asset_assign = asset_assign("SELECT asset_id, asset_brandname, barcode_number from assets", 'barcode_number',
                'asset_id', 'asset_brandname', $rows['asset_id']);

                echo "<div class='form-wrapper'>
                <form action='' method='POST'>
                    <div class='heading'>
                        <h2>Update Asset Assigning</h2>
                    </div>
                    <div class='inputs'>
                        <label for='asset_id' hidden>ID:</label>
                        <input type='text' id='asset_id' name='asset_id' value='".$rows['asset_id']."' hidden readonly>
                    </div>
                    <div class='inputs'>
                        <label for='assign_id' hidden>ID:</label>
                        <input type='text' id='assign_id' name='assign_id' value='".$rows['assign_id']."' hidden readonly>
                    </div>            
                    <div class='inputs'>
                        <label for='employee_name'>Employee Name:</label>
                        <select name='emp_id' id='employee_name' class='select_two' required>
                            $employees
                        </select>
                    </div>
                    <div class='inputs'>
                        <label for='barcode'>Barcode:</label>
                        <input type='text' id='barcode' name='barcode' value='".$rows['barcode_number']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='asset_brandname'>Asset Brand Name:</label>
                        <input type='text' id='asset_brandname' value='".$rows['asset_brandname']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='depreciated_value'>Depreciated Amount:</label>
                        <input type='text' id='depreciated_value' name='dep_price' value='".$rows['depreciation_value']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='assign_date'>Assign Date:</label>
                        <input type='date' id='assign_date' name='assign_date' value='".$rows['assign_date']."'>
                    </div>
                    <div class='inputs'>
                        <label for='return_date'>Return Date:</label>
                        <input type='date' id='return_date' name='assign_returned_date' value='".$rows['return_date']."'>
                    </div>
                    <div class='inputs'>
                        <label for='assign_status'>Status:</label>
                        <input type='text' id='assign_status' name='assign_status' value='".$rows['status']."' readonly>
                    </div>
                    <div class='btn_submit'>
                        <button type='submit' name='btn_update_asset_assign'>Update</button>
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
// <----------------------------------- POPUP MODAL FOR ASSET_ASSIGN ------------------------------------>


function asset_assign($query, $barcode, $asset_id, $asset_name, $selectedValue){
    global $conn;

    $result = $conn->query($query);

    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text = $row[$barcode]; // Use a different variable name to avoid overwriting the function parameter
            $selected = ($row[$asset_id] == $selectedValue) ? "selected" : "";
            // Fixed variable name here from $valueColumn to $asset_id
            $options .= "<option value='{$row[$asset_id]}' {$selected} data-brandname='{$row[$asset_name]}'>{$text}</option>";
        }
    }

    return $options;
}

function assign_employees($query, $textValue, $valueColumn, $selectedValue){
    global $conn;

    $result = $conn->query($query);

    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text = $row[$textValue]; // Use a different variable name to avoid overwriting the function parameter
            $selected = ($row[$valueColumn] == $selectedValue) ? "selected" : "";
            $options .= "<option value='$row[$valueColumn]' {$selected}>{$text}</option>";
        }
    }

    return $options;
}

// <----------------------------------- UPDATE FOR ASSETS ASSIGN ------------------------------------>
if (isset($_POST['btn_update_asset_assign'])) {
    try {
        $assign_id = mysqli_real_escape_string($conn, $_POST['assign_id']);
        $asset_emp_id_assign = mysqli_real_escape_string($conn, $_POST['emp_id']);
        $asset_id_assign = mysqli_real_escape_string($conn, $_POST['asset_id']);
        $dep_price = mysqli_real_escape_string($conn, $_POST['dep_price']);
        $asset_assign_date = mysqli_real_escape_string($conn, $_POST['assign_date']);
        $asset_assign_return_date = mysqli_real_escape_string($conn, $_POST['assign_returned_date']);
        $status_assign = mysqli_real_escape_string($conn, $_POST['assign_status']);

        $check_assign_id = $conn->prepare("SELECT * FROM assets_assignments where asset_id = ? and emp_id = ? 
        and status = ? and assets_assign_id != ?");
        $check_assign_id->bind_param("iisi", $asset_id_assign, $asset_emp_id_assign, $status_assign_check, $assign_id);
        $check_assign_id->execute();
        $check_assign_id_result = $check_assign_id->get_result();

        if ($check_assign_id_result->num_rows > 0) {
            echo "<script>alert('This asset already been assigned!')</script>";
        }else {

            $check_status = $conn->prepare("SELECT * FROM assets_assignments where asset_id = ?");
            $check_status->bind_param("i", $asset_id_assign);
            $check_status->execute();
            $check_status_res = $check_status->get_result();

            if ($check_status_res->num_rows > 0) {
                $rows = $check_status_res->fetch_assoc();
                $current_status = $rows['status'];

                if ($current_status === "Maintenance(In Used)" && $asset_assign_return_date != '') {
                    echo "<script>alert('Cannot return asset while it is in Maintenance(In Used) status.')</script>";
                    return;
                }
                
                if ($current_status === "Returned" || $current_status === "Damaged") {
                    echo "<script>alert('This data cannot be update after Returned or Damaged!')</script>";
                    return;
                }
                
                if ($asset_assign_return_date !== '') {
                    $asset_assign_return_date = mysqli_real_escape_string($conn, $_POST['assign_returned_date']);
                    $status_assign = "Returned";
                }else {
                    $asset_assign_return_date = null;
                    $status_assign = "In Used";
                }

                $check_status = $conn->prepare("SELECT * FROM assets_assignments where asset_id = ? and status = 'Maintenance(In Used)'");
                $check_status->bind_param("i", $asset_id_assign);
                $check_status->execute();
                $check_status_res = $check_status->get_result();

                $update_asset_assign = $conn->prepare("UPDATE assets_assignments SET asset_id = ?, emp_id = ?, assign_date = ?,
                return_date = ?, status = ? where assets_assign_id = ?");
                $update_asset_assign->bind_param("iisssi", $asset_id_assign, $asset_emp_id_assign, $asset_assign_date, 
                $asset_assign_return_date, $status_assign, $assign_id);

                if ($update_asset_assign->execute()) {
                    echo "<script>alert('Data successfully updated!');</script>";

                    $select_asset_status = $conn->prepare("SELECT status FROM assets WHERE asset_id = ?");
                    $select_asset_status->bind_param("i", $asset_id_assign);
                    $select_asset_status->execute();
                    $select_asset_status_res = $select_asset_status->get_result();

                    if ($select_asset_status_res->num_rows > 0) {
                        $row = $select_asset_status_res->fetch_assoc();
                        $current_status = $row['status'];
                        if ($current_status === "Not Used" && $status_assign === "In Used") {
                            $status_asset = "In Used";
                        }
                        if ($current_status === "In Used" && $status_assign === "In Used") {
                            $status_asset = "In Used";
                        }
                        if ($current_status === "Maintenance(Not Used)" && $status_assign === "In Used") {
                            $status_asset = "Maintenance(In Used)";
                        }
                        if ($current_status === "Repaired(Not Used)" && $status_assign === "In Used") {
                            $status_asset = "Repaired(In Used)";
                        }
                        if ($status_assign === "Returned") {
                            $status_asset = "Returned(Not Used)";
                        }
                    }
                    
                    $update_assets = $conn->prepare("UPDATE assets set status = ? where asset_id = ?");
                    $update_assets->bind_param("si", $status_asset, $asset_id_assign);
                    $update_assets->execute();

                    $asset_assign_date = "";
                    $asset_assign_return_date = "";

                    
                }else {
                    echo "<script>alert('Something went wrong! Failed to save Data!');</script>";
                }
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE FOR ASSETS ASSIGN ------------------------------------>

// <----------------------------------- UPDATE ASSET ASSIGN TO ARCHIVED ------------------------------------>
if (isset($_POST['assets_assign_archived'])){
    try {
        $asset_assign_id = mysqli_real_escape_string($conn, $_POST['asset_assign_id']);
        $assign_status = mysqli_real_escape_string($conn, $_POST['assign_status']);

        if ($assign_status == "In Used") {
            echo "<script>alert('This data cannot be archived still in Used!');</script>";
        }elseif ($assign_status == "Maintenance(In Used)") {
            echo "<script>alert('This data cannot be archived still in Used!');</script>";
        }elseif ($assign_status == "Repaired(In Used)") {
            echo "<script>alert('This data cannot be archived still in Used!');</script>";
        }else {
            $update_asset_assign = $conn->prepare("UPDATE assets_assignments SET archived = ? where assets_assign_id = ?");
            $update_asset_assign->bind_param("si", $const_archived, $asset_assign_id);

            if ($update_asset_assign->execute()) {
                // $update_assets = $conn->prepare("UPDATE assets SET status = ? where asset_id = ?");
                // $update_assets->bind_param("si", $asset_status, $asset_id);
                // $update_assets->execute();
                echo "<script>window.location.reload();</script>";
            }else {
                echo "<script>alert('Something went wrong! Failed to Archived Data!');</script>";
            } 
        }        

    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE ASSET ASSIGN TO ARCHIVED ------------------------------------>


// <----------------------------------- UPDATE ASSET ASSIGN TO UNARCHIVED ------------------------------------>
if (isset($_POST['assets_assign_unarchived'])){
    try {
        $asset_assign_id = mysqli_real_escape_string($conn, $_POST['asset_assign_id']);
        $assign_status = mysqli_real_escape_string($conn, $_POST['assign_status']);

        $check_status = $conn->prepare("SELECT * FROM assets_assignments where status = ? and asset_id = ?");
        $check_status->bind_param("si", $assign_status, $asset_assign_id);
        $check_status->execute();
        $check_status_res = $check_status->get_result();

        if ($check_status_res->num_rows > 0) {
            echo "<script>alert('Cannot Unarchived this data asset in used!');</script>";
        }else {
            $update_asset_assign = $conn->prepare("UPDATE assets_assignments SET archived = ? where assets_assign_id = ?");
            $update_asset_assign->bind_param("si", $const_unarchived, $asset_assign_id);

            if ($update_asset_assign->execute()) {
                    // $update_assets = $conn->prepare("UPDATE assets SET status = ? where asset_id = ?");
                    // $update_assets->bind_param("si", $asset_status, $asset_id);
                    // $update_assets->execute();
                echo "<script>window.location.reload();</script>";
            }else {
                echo "<script>alert('Something went wrong! Failed to Unarchived Data!');</script>";
            }       
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE ASSET ASSIGN TO UNARCHIVED ------------------------------------>


// <----------------------------------- SEARCH ASSET ASSIGN FOR UNARCHIVED ------------------------------------>
if (isset($_POST['search_assign_unarchived'])) {
    $query_assign = mysqli_real_escape_string($conn, $_POST['query_assign']);

    $query_assign = '%' . $query_assign . '%'; 
    if ($query_assign !== '') {
        $query_assign = '%' . $query_assign; 
        $archived = $const_unarchived;
    }else {
        $query_assign = '%' . $query_assign . '%'; 
        $archived = $const_unarchived;
    }

    $assign_srch = $conn->prepare("SELECT
                                        assets_assign_id,
                                        assign.asset_id,
                                        asset_brandname as brandname,
                                        assign.depreciation_value as dep_value,
                                        assign_date,
                                        return_date,
                                        emp_no as emp_no,
                                        CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                        barcode_number as barcode,
                                        assign.status
                                    FROM
                                        assets_assignments assign
                                    LEFT JOIN
                                        assets a ON assign.asset_id = a.asset_id
                                    LEFT JOIN
                                        employees emp ON assign.emp_id = emp.emp_id
                                    WHERE
                                        (emp_no LIKE ? OR
                                        barcode_number LIKE ? OR
                                        CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) LIKE ?)
                                    AND 
                                        assign.archived = ?");
    $assign_srch->bind_param("ssss", $query_assign, $query_assign, $query_assign, $archived);
    $assign_srch->execute();
    $assign_srch_res = $assign_srch->get_result();
    $no = 1;

    if ($assign_srch_res->num_rows > 0) {
        while ($rows = $assign_srch_res->fetch_assoc()) {
            if ($rows['return_date'] !== null) {
                // Display the date normally
                $returned_date =  date("F d, Y", strtotime($rows['return_date']));
            } else {
                // Display a message indicating that the date is not available
                $returned_date =  "Not Yet Returned";
            }
            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td class='assets_assign_id'>".$rows['assets_assign_id']."</td>
                <td>".$rows['full_name']."</td>
                <td>".$rows['asset_id']."</td>
                <td>".$rows['brandname']."</td>
                <td>".$rows['barcode']."</td>
                <td>".$rows['dep_value']."</td>
                <td>".date("F d, Y", strtotime($rows['assign_date']))."</td>
                <td>".$returned_date."</td>
                <td class='assign_status'>".$rows['status']."</td>
                <td class='assets_assign_td td_button'><input type='button' class='edit btn_action' value='Edit'>
                </td>
                <td class='assets_assign_td_archived td_button'><input type='button' class='archived btn_action' value='Archived'></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH ASSET ASSIGN FOR UNARCHIVED ------------------------------------>


// <----------------------------------- SEARCH ASSET ASSIGN FOR ARCHIVED ------------------------------------>
if (isset($_POST['search_assign_archived'])) {
    $query_assign = mysqli_real_escape_string($conn, $_POST['query_assign']);

    $query_assign = '%' . $query_assign . '%'; 
    if ($query_assign !== '') {
        $query_assign = '%' . $query_assign; 
        $archived = $const_archived;
    }else {
        $query_assign = '%' . $query_assign . '%'; 
        $archived = $const_archived;
    }

    $assign_srch = $conn->prepare("SELECT
                                        assets_assign_id,
                                        assign.asset_id,
                                        asset_brandname as brandname,
                                        assign.depreciation_value as dep_value,
                                        assign_date,
                                        return_date,
                                        emp_no as emp_no,
                                        CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                        barcode_number as barcode,
                                        assign.status
                                    FROM
                                        assets_assignments assign
                                    LEFT JOIN
                                        assets a ON assign.asset_id = a.asset_id
                                    LEFT JOIN
                                        employees emp ON assign.emp_id = emp.emp_id
                                    WHERE
                                        (emp_no LIKE ? OR
                                        barcode_number LIKE ? OR
                                        CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) LIKE ?)
                                        AND assign.archived = ?");
    $assign_srch->bind_param("ssss", $query_assign, $query_assign, $query_assign, $archived);
    $assign_srch->execute();
    $assign_srch_res = $assign_srch->get_result();
    $no = 1;

    if ($assign_srch_res->num_rows > 0) {
        while ($rows = $assign_srch_res->fetch_assoc()) {
            if ($rows['return_date'] !== null) {
                // Display the date normally
                $returned_date =  date("F d, Y", strtotime($rows['return_date']));
            } else {
                // Display a message indicating that the date is not available
                $returned_date =  "Not Yet Returned";
            }
            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td class='assets_assign_id'>".$rows['assets_assign_id']."</td>
                <td>".$rows['full_name']."</td>
                <td>".$rows['asset_id']."</td>
                <td>".$rows['brandname']."</td>
                <td>".$rows['barcode']."</td>
                <td>".$rows['dep_value']."</td>
                <td>".date("F d, Y", strtotime($rows['assign_date']))."</td>
                <td>".$returned_date."</td>
                <td class='assign_status'>".$rows['status']."</td>
                <td class='assets_assign_td_unarchived td_button'><input type='button' class='archived btn_action' value='Unarchived'></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH ASSET ASSIGN FOR ARCHIVED ------------------------------------>



