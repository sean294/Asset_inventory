<?php


// <----------------------------------- DATA ENTRY FOR ASSETS ------------------------------------>
if (isset($_POST['btn_save_assets'])) {

    $asset_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $asset_type = mysqli_real_escape_string($conn, $_POST['asset_type']);
    $barcode_number = mysqli_real_escape_string($conn, $_POST['barcode_number']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $dp_year = mysqli_real_escape_string($conn, $_POST['dp_year']);
    $purchase_price = mysqli_real_escape_string($conn, $_POST['purchase_price']);
    $purchase_date = mysqli_real_escape_string($conn, $_POST['purchase_date']);
    $location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
    $status_asset = 'Not Used';
    $archived_asset = "Unarchived";

    if (!preg_match('/^[A-Za-z0-9 ]+$/', $asset_name)) {
        echo "<script>alert('Letter and Numbers only in Asset Brand Name')</script>";
    }else{
        $check_asset = $conn->prepare("SELECT * FROM assets where barcode_number = ?");
        $check_asset->bind_param("s", $barcode_number);
        $check_asset->execute();
        $result_check_asset = $check_asset->get_result();

        if ($result_check_asset->num_rows > 0) {
            echo "<script>alert('Barcode number already Exist!')</script>";
        }else {
            $insert_asset = $conn->prepare("INSERT INTO assets(asset_brandname, asset_type, barcode_number, description, 
            purchase_price, dp_year, depreciation_value, purchase_date, location_id, status, archived) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $insert_asset->bind_param("ssssiiisiss", $asset_name, $asset_type, $barcode_number, $description, 
            $purchase_price, $dp_year, $purchase_price, $purchase_date, $location_id, $status_asset, $archived_asset);

            if ($insert_asset->execute()) {
                echo "<script>alert('Asset Data Successfully Added!')</script>";
                $asset_name = "";
                $barcode_number = "";
                $description = "";
                $purchase_price = "";
                $purchase_date = "";
                $dp_year = "";
            }else {
                echo "<script>alert('Something went wrong! Failed to save Asset Data!')</script>";
            }

        }
    }
}
// <----------------------------------- DATA ENTRY FOR ASSETS ------------------------------------>


// <----------------------------------- POPUP MODAL IN ASSETS TO UPDATE ------------------------------------>
if (isset($_POST['asset_update'])) {
    try {
        $asset_id = mysqli_real_escape_string($conn, $_POST['asset_id']);

        $select_asset = $conn->prepare("SELECT
                                            asset_id,
                                            asset_brandname,
                                            asset_type,
                                            barcode_number,
                                            description,
                                            purchase_price,
                                            purchase_date,
                                            loc.location_id,
                                            loc.address as address,
                                            dp_year,
                                            status
                                        from
                                            assets a
                                        left join
                                            locations loc on a.location_id = loc.location_id
                                        where
                                            asset_id = ?");
        $select_asset->bind_param("i", $asset_id);
        $select_asset->execute();
        $select_asset_result = $select_asset->get_result();

        if ($select_asset_result->num_rows > 0) {
            while ($rows = $select_asset_result->fetch_assoc()) {
                $location = location("SELECT location_id, address from locations", 'address', 'location_id', $rows['location_id']);

                echo "<div class='form-wrapper'>
                <form action='asset.php' method='POST'>
                    <div class='heading'>
                        <h2>Update Assets</h2>
                    </div>
                    <div class='inputs'>
                        <label for='asset_id'>Asset ID:</label>
                        <input type='text' id='asset_id' name='asset_id' required value='".$rows['asset_id']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='brand_name'>Brand Name:</label>
                        <input type='text' id='brand_name' name='brand_name' required value='".$rows['asset_brandname']."'>
                    </div>
                    <div class='inputs'>
                        <label for='type'>Asset Type:</label>
                        <input type='text' id='type' name='asset_type' required value='".$rows['asset_type']."'>
                    </div>
        
                    <div class='inputs'>
                        <label for='barcode'>Barcode:</label>
                        <input type='text' id='barcode' name='barcode_number' required value='".$rows['barcode_number']."' readonly>
                    </div>
                    <div class='inputs'>
                        <label for='description'>Description:</label>
                        <input type='text' id='description' name='description' required value='".$rows['description']."'>
                    </div>
                    <div class='inputs'>
                        <label for='dp_year'>Depreciated Year:</label>
                        <input type='number' name='dp_year' min='0' step='0.01' value='".$rows['dp_year']."'>
                    </div>
                    <div class='inputs'>
                        <label for='purchase_price'>Purchase Date:</label>
                        <input type='number' name='purchase_price' min='0' step='0.01' value='".$rows['purchase_price']."'>
                    </div>
                    <div class='inputs'>
                        <label for='purchase_date'>Purchase Date:</label>
                        <input type='date' id='purchase_date' name='purchase_date' required
                            value='".$rows['purchase_date']."'>
                    </div>
                    <div class='inputs'>
                        <label for='location'>Location:</label>
                        <select name='location_id' id='location' required class='select_two'>
                            $location
                        </select>
                    </div>
                    <div class='inputs'>
                        <label for='status_asset'>Status:</label>
                        <input type='text' id='status_asset' name='status_asset' required value='".$rows['status']."' readonly>
                    </div>
                    <div class='btn_submit'>
                        <button type='submit' name='btn_update_assets'>Update</button>
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
// <----------------------------------- POPUP MODAL IN ASSETS TO UPDATE ------------------------------------>
function location($query, $textValue, $valueColumn, $selectedValue){
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

// <----------------------------------- UPDATE ASSETS ------------------------------------>
if (isset($_POST['btn_update_assets'])) {

    $asset_id = mysqli_real_escape_string($conn, $_POST['asset_id']);
    $asset_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $asset_type = mysqli_real_escape_string($conn, $_POST['asset_type']);
    $barcode_number = mysqli_real_escape_string($conn, $_POST['barcode_number']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $purchase_price = mysqli_real_escape_string($conn, $_POST['purchase_price']);
    $purchase_date = mysqli_real_escape_string($conn, $_POST['purchase_date']);
    $location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
    $status_asset = mysqli_real_escape_string($conn, $_POST['status_asset']);
    $dp_year = mysqli_real_escape_string($conn, $_POST['dp_year']);

    if (!preg_match('/^[A-zA-Za-z0-9 ]+$/', $asset_name)) {
        echo "<script>alert('Letter and Numbers only in Asset Brand Name')</script>";
    }else {        
        $check_asset = $conn->prepare("SELECT * FROM assets where barcode_number = ? and asset_id != ?");
        $check_asset->bind_param("si", $barcode_number, $asset_id);
        $check_asset->execute();
        $result_check_asset = $check_asset->get_result();

        if ($result_check_asset->num_rows > 0) {
            echo "<script>alert('Barcode number already Exist!')</script>";
        }else {
            $update_asset = $conn->prepare("UPDATE assets SET asset_id = ?, asset_brandname = ?, asset_type = ?, barcode_number = ?,
            description = ?, dp_year = ?, purchase_price = ?, purchase_date = ?, location_id = ?, status = ? where asset_id = ?");
            $update_asset->bind_param("issssiisisi", $asset_id, $asset_name, $asset_type, $barcode_number, $description, 
            $dp_year, $purchase_price, $purchase_date, $location_id, $status_asset, $asset_id);

            if ($update_asset->execute()) {
                echo "<script>alert('Asset Data Successfully Updated!')</script>";
            }else {
                echo "<script>alert('Something went wrong! Failed to update Asset Data!')</script>";
            } 
        }

    }

}
// <----------------------------------- UPDATE ASSETS ------------------------------------>


// <----------------------------------- UPDATE TO ARCHIVED ASSETS ------------------------------------>
if (isset($_POST['asset_archived'])){
    try {
        $asset_id = mysqli_real_escape_string($conn, $_POST['asset_id']);
        $asset_status = mysqli_real_escape_string($conn, $_POST['asset_status']);

        if ($asset_status == "In Used") {

            echo "<script>alert('This data cannot be archived!');</script>";

        }elseif ($asset_status == "Not Used") {

            echo "<script>alert('This data cannot be archived!');</script>";
            
        }elseif ($asset_status == "Maintenance(In Used)") {

            echo "<script>alert('This data cannot be archived!');</script>";
            
        }elseif ($asset_status == "Maintenance(Not Used)") {

            echo "<script>alert('This data cannot be archived!');</script>";

        }elseif ($asset_status == "Repaired(In Used)") {

            echo "<script>alert('This data cannot be archived!');</script>";
            
        }elseif ($asset_status == "Returned(Not Used)") {

            echo "<script>alert('This data cannot be archived!');</script>";
        }else {
            $archived = "Archived";
            $update_asset = $conn->prepare("UPDATE assets SET archived = ? where asset_id = ?");
            $update_asset->bind_param("si", $archived, $asset_id);
            if ($update_asset->execute()) { 
                echo "<script>window.location.reload();</script>";
            }else {
                echo "<script>alert('Something went wrong! Failed to update Asset Data!')</script>";
            }

        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE TO ARCHIVED ASSETS ------------------------------------>


// <----------------------------------- UPDATE TO UNARCHIVED ASSETS ------------------------------------>
if (isset($_POST['asset_unarchived'])){
    try {
        $asset_id = mysqli_real_escape_string($conn, $_POST['asset_id']);
        $asset_status = mysqli_real_escape_string($conn, $_POST['asset_status']);

        $update_asset = $conn->prepare("UPDATE assets SET archived = ? where asset_id = ?");
        $update_asset->bind_param("si", $const_unarchived, $asset_id);

        if ($update_asset->execute()) { 
            echo "<script>window.location.reload();</script>";
        }else {
            echo "<script>alert('Something went wrong! Failed to update Asset Data!')</script>";
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE TO UNARCHIVED ASSETS ------------------------------------>


// <----------------------------------- DEPRECIATED VALUE ASSETS ------------------------------------>
if (isset($_POST['depreciation_update'])) {
    $dep_asset_id = mysqli_real_escape_string($conn, $_POST['asset_id']);
    $depreciated_value = mysqli_real_escape_string($conn, $_POST['depreciated_value']);

    $update_asset = $conn->prepare("UPDATE assets SET depreciation_value = ? where asset_id = ?");
    $update_asset->bind_param("ii", $depreciated_value, $dep_asset_id);


    if ($update_asset->execute()) {
        echo "<script>alert('Successfully Updated!')</script>";
        $check_assign = $conn->prepare("SELECT * FROM assets_assignments WHERE asset_id = ? and status in ('In Used', 
        'Maintenance(In Used)')");
        $check_assign->bind_param("i", $dep_asset_id);
        $check_assign->execute();
        $check_assign_res = $check_assign->get_result();

        if ($check_assign_res->num_rows > 0) {
            $update_assign = $conn->prepare("UPDATE assets_assignments SET depreciation_value = ? where asset_id = ?");
            $update_assign->bind_param("ii", $depreciated_value, $dep_asset_id);
            $update_assign->execute();
        }

    }else {
        echo "<script>alert('Something went wrong! Failed to update depreciation data!')</script>";
    }
}
// <----------------------------------- DEPRECIATED VALUE ASSETS ------------------------------------>


// <----------------------------------- SEARCH UNARCHIVED ASSETS ------------------------------------>
if (isset($_POST['search_asset_unarchived'])) {
    $query_asset = mysqli_real_escape_string($conn, $_POST['query_asset']);

    $query_asset = '%' . $query_asset . '%'; 
    if ($query_asset !== '') {
        $query_asset = '%' . $query_asset . '%'; 
        $archived = $const_unarchived;
    }else {
        $query_asset = '%' . $query_asset . '%'; 
        $archived = $const_unarchived;
    }

    $asset_srch = $conn->prepare("SELECT 
                                        a.asset_id,
                                        a.asset_brandname, 
                                        a.asset_type,
                                        a.barcode_number,
                                        a.description,
                                        a.purchase_price,
                                        a.purchase_date,
                                        dp_year,
                                        loc.address as address,
                                        status
                                    FROM 
                                        assets a
                                    left join
                                        locations loc on a.location_id = loc.location_id
                                    where
                                        (asset_brandname LIKE ? OR barcode_number LIKE ?)
                                    and
                                        a.archived = ?");
    $asset_srch->bind_param("sss", $query_asset, $query_asset, $archived);
    $asset_srch->execute();
    $asset_srch_res = $asset_srch->get_result();
    $no = 1;

    if ($asset_srch_res->num_rows > 0) {
        while ($rows = $asset_srch_res->fetch_assoc()) {

            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td hidden class='asset_id'>".$rows['asset_id']."</td>
                <td>".$rows['asset_brandname']."</td>
                <td>".$rows['asset_type']."</td>
                <td>".$rows['barcode_number']."</td>
                <td>".$rows['description']."</td>
                <td>".$rows['purchase_price']."</td>
                <td>".date('F d, Y', strtotime($rows['purchase_date']))."</td>
                <td style='text-align:center;'>".$rows['dp_year']."</td>
                <td>".$rows['address']."</td>
                <td class='asset_status'>".$rows['status']."</td>
                <td class='asset_td td_button'><a href=''><input type='button' class='edit btn_action' value='Edit'></a>
                </td>
                <td class='asset_td_archived td_button'><a href='#'><input type='button' class='archived btn_action'
                        value='Archived'></a></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH UNARCHIVED ASSETS ------------------------------------>


// <----------------------------------- SEARCH ARCHIVED ASSETS ------------------------------------>
if (isset($_POST['search_asset_archived'])) {
    $query_asset = mysqli_real_escape_string($conn, $_POST['query_asset']);

    $query_asset = '%' . $query_asset . '%'; 
    if ($query_asset !== '') {
        $query_asset = '%' . $query_asset . '%'; 
        $archived = $const_archived;
    }else {
        $query_asset = '%' . $query_asset . '%'; 
        $archived = $const_archived;
    }

    $asset_srch = $conn->prepare("SELECT 
                                        a.asset_id,
                                        a.asset_brandname, 
                                        a.asset_type,
                                        a.barcode_number,
                                        a.description,
                                        a.purchase_price,
                                        a.purchase_date,
                                        loc.address as address,
                                        status
                                    FROM 
                                        assets a
                                    left join
                                        locations loc on a.location_id = loc.location_id
                                    where
                                        (asset_brandname LIKE ? OR barcode_number LIKE ?)
                                    and
                                        a.archived = ?");
    $asset_srch->bind_param("sss", $query_asset, $query_asset, $archived);
    $asset_srch->execute();
    $asset_srch_res = $asset_srch->get_result();
    $no = 1;

    if ($asset_srch_res->num_rows > 0) {
        while ($rows = $asset_srch_res->fetch_assoc()) {

            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td class='asset_id'>".$rows['asset_id']."</td>
                <td>".$rows['asset_brandname']."</td>
                <td>".$rows['asset_type']."</td>
                <td>".$rows['barcode_number']."</td>
                <td>".$rows['description']."</td>
                <td>".$rows['purchase_price']."</td>
                <td>".date('F d, Y', strtotime($rows['purchase_date']))."</td>
                <td>".$rows['address']."</td>
                <td class='asset_status'>".$rows['status']."</td>
                <td class='asset_td_unarchived td_button'><a href='#'><input type='button' class='archived btn_action'
                                    value='Unarchived'></a></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH ARCHIVED ASSETS ------------------------------------>


// <----------------------------------- SEARCH ARCHIVED ASSETS ------------------------------------>
if (isset($_POST['search_depreciated'])) {
    $query_depreciated = mysqli_real_escape_string($conn, $_POST['query_depreciated']);

    $query_depreciated = '%' . $query_depreciated . '%'; 
    if ($query_depreciated !== '') {
        $query_depreciated = '%' . $query_depreciated . '%'; 
        $archived = $const_unarchived;
    }else {
        $query_depreciated = '%' . $query_depreciated . '%'; 
        $archived = $const_unarchived;
    }

    $asset_srch = $conn->prepare("SELECT 
                                        a.asset_id,
                                        a.asset_brandname, 
                                        a.asset_type,
                                        a.barcode_number,
                                        a.description,
                                        a.purchase_price,
                                        a.purchase_date,
                                        loc.address as address,
                                        status
                                    FROM 
                                        assets a
                                    left join
                                        locations loc on a.location_id = loc.location_id
                                    where
                                        (barcode_number like ? || asset_brandname like ? || asset_type like ?)
                                    and
                                        archived = ?");
    $asset_srch->bind_param("ssss", $query_depreciated, $query_depreciated, $query_depreciated, $archived);
    $asset_srch->execute();
    $asset_srch_res = $asset_srch->get_result();
    $no = 1;

    if ($asset_srch_res->num_rows > 0) {
        while ($rows = $asset_srch_res->fetch_assoc()) {

            $current_price = $rows['purchase_price'];
            $purchase_date_str = $rows['purchase_date'];
            $current_date_str = date('Y-m-d');

            $purchase_date = new DateTime($purchase_date_str);
            $current_date = new DateTime($current_date_str);

            $interval = $current_date->diff($purchase_date);
            $month_difference = $interval->m + ($interval->y * 12);

            $formula_total =  ($current_price - (($current_price / 60) * $month_difference));

            $dep_status = $formula_total;
            

            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td hidden class='asset_id'>".$rows['asset_id']."</td>
                <td>".$rows['barcode_number']."</td>
                <td>".$rows['asset_brandname']."</td>
                <td>".$rows['asset_type']."</td>
                <td>".$rows['status']."</td>
                <td>".date('F d, Y', strtotime($rows['purchase_date']))."</td>
                <td>".$rows['purchase_price']."</td>
                <td class='depreciated_value'>".$dep_status."</td>
                <td>".$month_difference.' Month/s'."</td>
                <td class='asset_depreciated td_button'><a href=''><input type='button' class='edit btn_action' value='Update'></a>
                </td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH ARCHIVED ASSETS ------------------------------------>