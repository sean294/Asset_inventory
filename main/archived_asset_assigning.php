<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Archived Assets Assigning
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="asset-assign-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
        </div>
        <div class="table-container">
            <div class="search-bar-asset">
                <label for="search-bar">Search:</label>
                <input type="text" id="search-assign-archived" placeholder="Search here...">
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <th>No.</th>
                        <th hidden>ID</th>
                        <th>Employee Name</th>
                        <th>Asset ID</th>
                        <th>Brand Name</th>
                        <th>Barcode Number</th>
                        <th>Depreciated Value</th>
                        <th>Assign Date</th>
                        <th>Return Date</th>
                        <th>status</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="table-search-archived">
                        <?php
                        
                        $no = 1;
                        $select_assign = $conn->prepare("SELECT
                                                            assets_assign_id,
                                                            asset.asset_id as asset_id,
                                                            asset.asset_brandname as brandname,
                                                            asset.barcode_number as barcode,
                                                            CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                                            assign_date,
                                                            return_date,
                                                            assign.depreciation_value,
                                                            assign.status as status
                                                        from 
                                                            assets_assignments assign
                                                        left join
                                                            assets asset on assign.asset_id = asset.asset_id
                                                        left join
                                                            employees emp on assign.emp_id = emp.emp_id
                                                        where 
                                                            assign.archived = 'Archived'");

                        $select_assign->execute();
                        $select_assign_result = $select_assign->get_result();
                        if ($select_assign_result->num_rows > 0) {
                            while ($rows = $select_assign_result->fetch_assoc()) {
                                if ($rows['return_date'] !== null) {
                                    // Display the date normally
                                    $returned_date =  date("F d, Y", strtotime($rows['return_date']));
                                } else {
                                    // Display a message indicating that the date is not available
                                    $returned_date =  "Not Yet Returned";
                                }
                                ?>

                        <tr>
                            <td><?php echo $no++.".)"; ?></td>
                            <td hidden class="assets_assign_id"><?php echo $rows['assets_assign_id'] ?></td>
                            <td><?php echo $rows['full_name']; ?></td>
                            <td><?php echo $rows['asset_id']; ?></td>
                            <td><?php echo $rows['brandname']; ?></td>
                            <td><?php echo $rows['barcode']; ?></td>
                            <td><?php echo $rows['depreciation_value']; ?></td>
                            <td><?php echo date("F d, Y", strtotime($rows['assign_date'])); ?></td>
                            <td><?php echo $returned_date; ?></td>
                            <td class="assign_status"><?php echo $rows['status']; ?></td>
                            <td class="assets_assign_td_unarchived td_button"><input type="button" class="archived btn_action" value="Unarchived"></td>
                        </tr>

                        <?php
                            }
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("../theme/footer.php"); ?>