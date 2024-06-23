<?php

// <----------------------------------- MAINTENANCE DATA ENTRY ------------------------------------>
if (isset($_POST['btn_save_maintenance'])) {
    try {
        $maintenance_date = mysqli_real_escape_string($conn, $_POST['maintenance_date']);
        $repaired_date = mysqli_real_escape_string($conn, $_POST['repaired_date']);
        $barcode_number = mysqli_real_escape_string($conn, $_POST['barcode_number']);
        $asset_id_maintenance = mysqli_real_escape_string($conn, $_POST['asset_id_assign']);
        $asset_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
        $asset_type = mysqli_real_escape_string($conn, $_POST['asset_type']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $purchase_price = mysqli_real_escape_string($conn, $_POST['purchase_price']);
        $maintenance_status = "Maintenance";
        $archived_maintenance = "Unarchived";

        $c_a_id = $conn->prepare("SELECT * FROM maintenance WHERE asset_id = ? and status = 'Maintenance'");
        $c_a_id->bind_param("i", $asset_id_maintenance);
        $c_a_id->execute();
        $c_a_id_res = $c_a_id->get_result();


        if ($c_a_id_res->num_rows > 0) {
            echo "<script>alert('This asset still under maintenance!');</script>";
        } else {
            if ($repaired_date !== '') {
                $repaired_date = mysqli_real_escape_string($conn, $_POST['repaired_date']);
                $maintenance_status = "Repaired";
            }else {
                $repaired_date = null;
                $maintenance_status = "Maintenance";
            }

            $status_maintenance = "Maintenance(Not Used)"; // Default status
            
            $select_asset_status = $conn->prepare("SELECT status FROM assets WHERE asset_id = ?");
            $select_asset_status->bind_param("i", $asset_id_maintenance);
            $select_asset_status->execute();
            $select_asset_status_res = $select_asset_status->get_result();

            if ($select_asset_status_res->num_rows > 0) {
                $row = $select_asset_status_res->fetch_assoc();
                $current_status = $row['status'];
                if ($current_status === "In Used") {
                    $status_maintenance = "Maintenance(In Used)";
                }
                if ($current_status === "Not Used") {
                    $status_maintenance = "Maintenance(Not Used)";
                }
                if ($current_status === "Maintenance(Not Used)") {
                    $status_maintenance = "Maintenance(Not Used)";
                }
                if ($current_status === "Maintenance(In Used)") {
                    $status_maintenance = "Maintenance(In Used)";
                }
                if ($current_status === "Repaired(Not Used)") {
                    $status_maintenance = "Maintenance(Not Used)";
                }
                if ($current_status === "Repaired(In Used)") {
                    $status_maintenance = "Maintenance(In Used)";
                }
                if ($current_status === "Damaged") {
                    $status_maintenance = "Maintenance(Damaged)";
                }
            }
            
            $insert_maintenance = $conn->prepare("INSERT INTO maintenance(asset_id, maintenance_date, repaired_date, status, 
            archived) 
            values(?,?,?,?, ?)");
            $insert_maintenance->bind_param("issss", $asset_id_maintenance, $maintenance_date, $repaired_date, $maintenance_status, 
            $archived_maintenance);

            if ($insert_maintenance->execute()) {
                echo "<script>alert('Maintenance Data successfully added!');</script>";
                $update_assets = $conn->prepare("UPDATE assets set status = ? where asset_id = ?");
                $update_assets->bind_param("si", $status_maintenance, $asset_id_maintenance);
                $update_assets->execute();

                $update_assign = $conn->prepare("UPDATE assets_assignments set status = ? where asset_id = ?");
                $update_assign->bind_param("si", $status_maintenance, $asset_id_maintenance);
                $update_assign->execute();

                $insert_log = $conn->prepare("INSERT INTO log_maintenance(asset_brandname, asset_type, barcode_number, value, 
                status) VALUES(?,?,?,?,?)");
                $insert_log->bind_param("sssis", $asset_name, $asset_type, $barcode_number, $purchase_price, $maintenance_status);
                $insert_log->execute();

                $maintenance_date = "";
                $repaired_date = "";      

            }else {
                echo "<script>alert('Something went wrong! Failed to save Asset Data!');</script>";
            }

        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
    
}
// <----------------------------------- MAINTENANCE DATA ENTRY ------------------------------------>


// <----------------------------------- POPUP MODAL IN MAINTENANCE UPDATE DATA ------------------------------------>
if (isset($_POST['maintenance_update'])) {
    $main_id = mysqli_real_escape_string($conn, $_POST['maintenance_id']);

    $select_maintenance = $conn->prepare("SELECT
                                                m.maintenance_id,
                                                a.asset_id as asset_id,
                                                a.asset_brandname as asset_name,
                                                a.asset_type,
                                                a.description,
                                                a.barcode_number,
                                                maintenance_date,
                                                repaired_date,
                                                a.depreciation_value,
                                                m.status as status
                                            FROM 
                                                maintenance m
                                            left join
                                                assets a on a.asset_id = m.asset_id
                                            where
                                                maintenance_id = ?");
    $select_maintenance->bind_param("i", $main_id);
    $select_maintenance->execute();
    $select_maintenance_result = $select_maintenance->get_result();

    if ($select_maintenance_result->num_rows > 0) {
        while ($rows = $select_maintenance_result->fetch_assoc()) {

            $asset_maintenance = asset_maintenance("SELECT asset_id, asset_brandname, barcode_number from assets", 'barcode_number',
            'asset_id', 'asset_brandname', $rows['asset_id']);

            if ($rows['status'] == "Repaired") {
                $status = "
                <option value='Repaired'>Repaired</option>
                <option value='Damaged'>Damaged</option>
                <option value='Maintenance'>Maintenance</option>";
            }elseif ($rows['status'] == "Maintenance") {
                $status = "
                <option value='Maintenance'>Maintenance</option>
                <option value='Repaired'>Repaired</option>
                <option value='Damaged'>Damaged</option>";
            }elseif ($rows['status'] == "Damaged") {
                $status = "<option value='Damaged'>Damaged</option>";
            }

            echo "<div class='form-wrapper'>
            <form action='maintenance.php' method='POST'>
                <div class='heading'>
                    <h2>Update Maintenance</h2>
                </div>
                <div class='inputs' hidden>
                    <label for='maintenance_id' hidden>ID:</label>
                    <input type='text' id='maintenance_id' name='maintenance_id' value='".$rows['maintenance_id']."' readonly hidden>
                </div>
                <div class='inputs' hidden>
                    <label for='asset_id' hidden>ID:</label>
                    <input type='text' id='asset_id' name='asset_id_maintenance' value='".$rows['asset_id']."' readonly hidden>
                </div>
                <div class='inputs'>
                    <label for='barcode_number'>Barcode:</label>
                    <input type='text' name='barcode_number' id='barcode_number' value='".$rows['barcode_number']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='assetBrandName'>Asset Brand Name:</label>
                    <input type='text' id='assetBrandName' name='brand_name' value='".$rows['asset_name']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='asset_type'>Asset type:</label>
                    <input type='text' id='asset_type' name='asset_type' value='".$rows['asset_type']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='description'>Description:</label>
                    <input type='text' id='description' name='description' value='".$rows['description']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='depreciation_value'>Depreciation Value:</label>
                    <input type='text' id='depreciation_value' name='depreciation_value' value='".$rows['depreciation_value']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='date_maintenance'>Maintenance Date:</label>
                    <input type='date' id='date_maintenance' name='maintenance_date' value='".$rows['maintenance_date']."'>
                </div>
    
                <div class='inputs'>
                    <label for='date_maintenance'>Return Date:</label>
                    <input type='date' id='date_maintenance' name='repaired_date' value='".$rows['repaired_date']."'>
                </div>
                <div class='inputs'>
                    <label for='maintenance_status'>Status:</label>
                    <select id='maintenance_status' class='' name='maintenance_status'>
                        $status
                    </select>
                </div>
                <div class='btn_submit'>
                    <button type='submit' name='btn_update_maintenance'>Update</button>
                </div>
            </form>
        </div>";
        }
    }
}
// <----------------------------------- POPUP MODAL IN MAINTENANCE UPDATE DATA ------------------------------------>

function asset_maintenance($query, $barcode, $asset_id, $asset_name, $selectedValue){
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

// <----------------------------------- UPDATE MAINTENANCE DATA ------------------------------------>
if (isset($_POST['btn_update_maintenance'])) {
    try {
        $main_id = mysqli_real_escape_string($conn, $_POST['maintenance_id']);
        $asset_id_maintenance = mysqli_real_escape_string($conn, $_POST['asset_id_maintenance']);
        $maintenance_date = mysqli_real_escape_string($conn, $_POST['maintenance_date']);
        $repaired_date = mysqli_real_escape_string($conn, $_POST['repaired_date']);
        $maintenance_status =  mysqli_real_escape_string($conn, $_POST['maintenance_status']);
        $asset_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
        $asset_type = mysqli_real_escape_string($conn, $_POST['asset_type']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $barcode_number = mysqli_real_escape_string($conn, $_POST['barcode_number']);
        $depreciation_value = mysqli_real_escape_string($conn, $_POST['depreciation_value']); 

        $c_a_id = $conn->prepare("SELECT * FROM maintenance WHERE asset_id = ? and status = 'Maintenance' and maintenance_id != ?");
        $c_a_id->bind_param("ii", $asset_id_maintenance, $main_id);
        $c_a_id->execute();
        $c_a_id_res = $c_a_id->get_result();

        if ($c_a_id_res->num_rows > 0) {
            echo "<script>alert('This asset still under maintenance!');</script>";
        }else{

            if ($repaired_date !== "") {
                $repaired_date = mysqli_real_escape_string($conn, $_POST['repaired_date']);
            }else {
                $repaired_date = null;
            }

            $status_asset = "Maintenance(Not Used)"; // Default status
            
            $select_asset_status = $conn->prepare("SELECT status FROM assets WHERE asset_id = ?");
            $select_asset_status->bind_param("i", $asset_id_maintenance);
            $select_asset_status->execute();
            $select_asset_status_res = $select_asset_status->get_result();

            if ($select_asset_status_res->num_rows > 0) {
                $row = $select_asset_status_res->fetch_assoc();
                $current_status = $row['status'];
                if (($current_status === "In Used" && $maintenance_status === "Maintenance") || 
                ($current_status === "Maintenance(In Used)" && $maintenance_status === "Maintenance") || 
                ($current_status === "Repaired(In Used)" && $maintenance_status === "Maintenance")) {

                    $status_asset = "Maintenance(In Used)";
                    $status_assign = "Maintenance";

                }
                elseif (($current_status === "In Used" && $maintenance_status === "Repaired") || 
                ($current_status === "Maintenance(In Used)" && $maintenance_status === "Repaired") || 
                ($current_status === "Repaired(In Used)" && $maintenance_status === "Repaired")) {

                    $status_asset = "Repaired(In Used)";
                    $status_assign = "In Used";

                }
                elseif (($current_status === "Not Used" && $maintenance_status === "Maintenance") || 
                ($current_status === "Maintenance(Not Used)" && $maintenance_status === "Maintenance") || 
                ($current_status === "Repaired(Not Used)" && $maintenance_status === "Maintenance")) {

                    $status_asset = "Maintenance(Not Used)";

                }
                elseif (($current_status === "Not Used" && $maintenance_status === "Repaired") || 
                ($current_status === "Maintenance(Not Used)" && $maintenance_status === "Repaired") || 
                ($current_status === "Repaired(Not Used)" && $maintenance_status === "Repaired")) {

                    $status_asset = "Repaired(Not Used)";

                }
                elseif ($current_status === "Damaged" && $maintenance_status === "Maintenance") {

                    $status_asset = "Maintenance(Damaged)";
                    $status_assign = "In Used";

                }
                else {

                    $status_asset = "Damaged";

                }
            }

            $update_maintenance = $conn->prepare("UPDATE maintenance SET asset_id = ?, maintenance_date = ?,
            repaired_date = ?, status = ? where maintenance_id = ?");
            $update_maintenance->bind_param("isssi", $asset_id_maintenance, $maintenance_date, $repaired_date, $maintenance_status, 
            $main_id);

            if ($update_maintenance->execute()) {
                echo "<script>alert('Successfully updated maintenance data!');</script>";
                $update_asset_maintenance = $conn->prepare("UPDATE assets SET status = ? where asset_id = ?");
                $update_asset_maintenance->bind_param("si", $status_asset, $asset_id_maintenance);
                $update_asset_maintenance->execute();

                $select_assign_status = $conn->prepare("SELECT status FROM assets_assignments WHERE asset_id = ?");
                $select_assign_status->bind_param("i", $asset_id_maintenance);
                $select_assign_status->execute();
                $select_assign_status_res = $select_assign_status->get_result();

                if ($select_assign_status_res->num_rows > 0) {
                    $row = $select_assign_status_res->fetch_assoc();
                    $current_status = $row['status'];

                    if ($current_status === "Returned") {
                        $update_assign_maintenance = $conn->prepare("UPDATE assets_assignments SET status = 'Returned' where asset_id = ?");
                        $update_assign_maintenance->bind_param("i", $asset_id_maintenance);
                        $update_assign_maintenance->execute();
                    }else {
                        $update_assign_maintenance = $conn->prepare("UPDATE assets_assignments SET status = ? where asset_id = ?");
                        $update_assign_maintenance->bind_param("si", $status_asset, $asset_id_maintenance);
                        $update_assign_maintenance->execute();
                    }
                }

                

                $insert_log = $conn->prepare("INSERT INTO log_maintenance(asset_brandname, asset_type, barcode_number, value, 
                status) VALUES(?,?,?,?,?)");
                $insert_log->bind_param("sssis", $asset_name, $asset_type, $barcode_number, $depreciation_value, $maintenance_status);
                $insert_log->execute();
            }else {
                echo "<script>alert('Something went wrong! Failed to update maintenance data!". $conn->error. "');</script>";
            }
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
    
}
// <----------------------------------- UPDATE MAINTENANCE DATA ------------------------------------>

// <----------------------------------- UPDATE MAINTENANCE DATA ARCHIVED ------------------------------------>
if (isset($_POST['maintenance_archived'])){
    try {
        $maintenance_id = mysqli_real_escape_string($conn, $_POST['maintenance_id']);
        $maintenance_status = mysqli_real_escape_string($conn, $_POST['maintenance_status']);

        if ($maintenance_status == "Maintenance") {
            echo "<script>alert('This data cannot be archived!');</script>";
        }elseif ($maintenance_status == "Repaired") {
            echo "<script>alert('This data cannot be archived!');</script>";
        }else {
            $update_maintenance = $conn->prepare("UPDATE maintenance SET archived = ? where maintenance_id = ?");
            $update_maintenance->bind_param("si", $const_archived, $maintenance_id);

            if ($update_maintenance->execute()) {

                echo "<script>window.location.reload();</script>";
            }else {
                echo "<script>alert('Something went wrong! Failed to Archived Data!');</script>";
            } 
        }        

    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE MAINTENANCE DATA ARCHIVED ------------------------------------>

// <----------------------------------- UPDATE MAINTENANCE DATA UNARCHIVED ------------------------------------>
if (isset($_POST['maintenance_unarchived'])){
    try {
        $maintenance_id = mysqli_real_escape_string($conn, $_POST['maintenance_id']);
        $maintenance_status = mysqli_real_escape_string($conn, $_POST['maintenance_status']);

        $update_maintenance = $conn->prepare("UPDATE maintenance SET archived = ? where maintenance_id = ?");
        $update_maintenance->bind_param("si", $const_unarchived, $maintenance_id);

        if ($update_maintenance->execute()) {

            echo "<script>window.location.reload();</script>";
        }else {
            echo "<script>alert('Something went wrong! Failed to Archived Data!');</script>";
        }
    } catch (Exception $error) {
        echo "<script>alert('Error: " . $error->getMessage() . "');</script>";
    }
}
// <----------------------------------- UPDATE MAINTENANCE DATA UNARCHIVED ------------------------------------>

// <----------------------------------- SEARCH UNARCHIVED MAINTENANCE ------------------------------------>
if (isset($_POST['search_maintenance_unarchived'])) {
    $query_maintenance = mysqli_real_escape_string($conn, $_POST['query_maintenance']);

    $query_maintenance = '%' . $query_maintenance . '%'; 
    if ($query_maintenance !== '') {
        $query_maintenance = '%' . $query_maintenance . '%'; 
        $archived = $const_unarchived;
    }else {
        $query_maintenance = '%' . $query_maintenance . '%'; 
        $archived = $const_unarchived;
    }

    $maintenance_srch = $conn->prepare("SELECT
                                            m.maintenance_id,
                                            a.asset_brandname as asset_name,
                                            maintenance_date,
                                            repaired_date,
                                            m.status as status
                                        FROM 
                                            maintenance m
                                        left join
                                            assets a on a.asset_id = m.asset_id
                                        where
                                            (a.asset_brandname LIKE ? OR maintenance_date LIKE ? OR m.status LIKE ?)
                                        and 
                                            m.archived = ?");
    $maintenance_srch->bind_param("ssss", $query_maintenance, $query_maintenance, $query_maintenance, $archived);
    $maintenance_srch->execute();
    $maintenance_srch_res = $maintenance_srch->get_result();
    $no = 1;

    if ($maintenance_srch_res->num_rows > 0) {
        while ($rows = $maintenance_srch_res->fetch_assoc()) {
            if ($rows['repaired_date'] !== null) {
                // Display the date normally
                $returned_date =  date("F d, Y", strtotime($rows['repaired_date']));
            } else {
                // Display a message indicating that the date is not available
                $returned_date =  "Not Yet Repaired";
            }
            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td class='maintenance_id'>".$rows['maintenance_id']."</td>
                <td>".$rows['asset_name']."</td>
                <td>".date('F d, Y', strtotime($rows['maintenance_date']))."</td>
                <td>".$returned_date."</td>
                <td class='maintenance_status'>".$rows['status']."</td>
                <td class='maintenance_td td_button'><input type='button' class='edit btn_action' value='Edit'>
                </td>
                <td class='maintenance_td_archived td_button'><input type='button' class='archived btn_action'
                        value='Archived'></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH UNARCHIVED MAINTENANCE ------------------------------------>

// <----------------------------------- SEARCH ARCHIVED MAINTENANCE ------------------------------------>
if (isset($_POST['search_maintenance_archived'])) {
    $query_maintenance = mysqli_real_escape_string($conn, $_POST['query_maintenance']);

    $query_maintenance = '%' . $query_maintenance . '%'; 
    if ($query_maintenance !== '') {
        $query_maintenance = '%' . $query_maintenance . '%'; 
        $archived = $const_archived;
    }else {
        $query_maintenance = '%' . $query_maintenance . '%'; 
        $archived = $const_archived;
    }

    $maintenance_srch = $conn->prepare("SELECT
                                            m.maintenance_id,
                                            a.asset_brandname as asset_name,
                                            maintenance_date,
                                            repaired_date,
                                            m.status as status
                                        FROM 
                                            maintenance m
                                        left join
                                            assets a on a.asset_id = m.asset_id
                                        where
                                            (a.asset_brandname LIKE ? OR maintenance_date LIKE ? OR m.status LIKE ?)
                                        and 
                                            m.archived = ?");
    $maintenance_srch->bind_param("ssss", $query_maintenance, $query_maintenance, $query_maintenance, $archived);
    $maintenance_srch->execute();
    $maintenance_srch_res = $maintenance_srch->get_result();
    $no = 1;

    if ($maintenance_srch_res->num_rows > 0) {
        while ($rows = $maintenance_srch_res->fetch_assoc()) {
            if ($rows['repaired_date'] !== null) {
                // Display the date normally
                $returned_date =  date("F d, Y", strtotime($rows['repaired_date']));
            } else {
                // Display a message indicating that the date is not available
                $returned_date =  "Not Yet Repaired";
            }
            echo "                        
            <tr>
                <td>".$no++.'.)'."</td>
                <td class='maintenance_id'>".$rows['maintenance_id']."</td>
                <td>".$rows['asset_name']."</td>
                <td>".date('F d, Y', strtotime($rows['maintenance_date']))."</td>
                <td>".$returned_date."</td>
                <td class='maintenance_status'>".$rows['status']."</td>
                <td class='maintenance_td_unarchived td_button'><input type='button' class='archived btn_action'
                        value='Unarchived'></td>
            </tr>";
        }
    }else {
        echo "<p style='padding-left:10px;width:300px;font-size:1.2em'>No Results Found</p>";
    }
}
// <----------------------------------- SEARCH ARCHIVED MAINTENANCE ------------------------------------>