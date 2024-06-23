<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Archived Assets
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="asset-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
        </div>
        <div class="table-container">
            <div class="search-bar-asset">
                <label for="search-bar">Search:</label>
                <input type="text" id="search-asset-archived" placeholder="Search here...">
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <th>No.</th>
                        <th>Asset ID</th>
                        <th>Brand Name</th>
                        <th>Type</th>
                        <th>Barcode</th>
                        <th>Description</th>
                        <th>Purchase Date</th>
                        <th>Current Location</th>
                        <th>status</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="table-search-archived">
                        <?php

                        $no = 1;
                        
                        $select_assets = $conn->prepare("SELECT 
                                                            a.asset_id,
                                                            a.asset_brandname, 
                                                            a.asset_type,
                                                            a.barcode_number,
                                                            a.description,
                                                            a.purchase_date,
                                                            loc.address as address,
                                                            status
                                                        FROM 
                                                            assets a
                                                        left join
                                                            locations loc on a.location_id = loc.location_id
                                                        where
                                                            a.archived = 'Archived'");
                        $select_assets->execute();
                        $result_select_assets = $select_assets->get_result();
                        if ($result_select_assets->num_rows > 0) {
                            while ($rows = $result_select_assets->fetch_assoc()) {
                            ?>
                        <tr>
                            <td><?php echo $no++.".)"; ?></td>
                            <td class="asset_id"><?php echo $rows['asset_id']; ?></td>
                            <td><?php echo $rows['asset_brandname']; ?></td>
                            <td><?php echo $rows['asset_type']; ?></td>
                            <td><?php echo $rows['barcode_number']; ?></td>
                            <td><?php echo $rows['description']; ?></td>
                            <td><?php echo date('F d, Y', strtotime($rows['purchase_date'])); ?></td>
                            <td><?php echo $rows['address']; ?></td>
                            <td class="asset_status"><?php echo $rows['status']; ?></td>
                            <td class="asset_td_unarchived td_button"><a href="#"><input type="button" class="archived btn_action"
                                    value="Unarchived"></a></td>
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