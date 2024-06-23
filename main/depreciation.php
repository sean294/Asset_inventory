<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Depreciated Table
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
                <input type="text" id="search-depreciated" placeholder="Search here...">
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <th>No.</th>
                        <th hidden>Asset ID</th>
                        <th>Barcode No.</th>
                        <th>Brand Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Purchase Date</th>
                        <th>Original Price</th>
                        <th>Salvage Value</th>
                        <th>Lapse Month</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="table-search">
                        <?php

                        $no = 1;
                        
                        $select_assets = $conn->prepare("SELECT 
                                                            a.asset_id,
                                                            a.asset_brandname, 
                                                            a.asset_type,
                                                            a.barcode_number,
                                                            a.description,
                                                            a.purchase_price,
                                                            a.purchase_date,
                                                            loc.address as address,
                                                            dp_year,
                                                            status
                                                        FROM 
                                                            assets a
                                                        left join
                                                            locations loc on a.location_id = loc.location_id
                                                        where
                                                            asset_id");
                        $select_assets->execute();
                        $result_select_assets = $select_assets->get_result();
                        if ($result_select_assets->num_rows > 0) {
                            while ($rows = $result_select_assets->fetch_assoc()) {

                            $current_price = $rows['purchase_price'];
                            $purchase_date_str = $rows['purchase_date'];
                            $current_date_str = date('Y-m-d');
                            $dpyear = $rows['dp_year'];

                            $purchase_date = new DateTime($purchase_date_str);
                            $current_date = new DateTime($current_date_str);

                            $interval = $current_date->diff($purchase_date);
                            $month_difference = $interval->m + ($interval->y * 12);

                            $dpyear = 12 * $dpyear;

                            $formula_total =  ($current_price - (($current_price / $dpyear) * $month_difference));

                            $dep_status = $formula_total;

                            ?>
                        <tr>
                            <td><?php echo $no++.".)"; ?></td>
                            <td hidden class="asset_id"><?php echo $rows['asset_id']; ?></td>
                            <td><?php echo $rows['barcode_number']; ?></td>
                            <td><?php echo $rows['asset_brandname']; ?></td>
                            <td><?php echo $rows['asset_type']; ?></td>
                            <td><?php echo $rows['status']; ?></td>
                            <td><?php echo date('F d, Y', strtotime($rows['purchase_date'])); ?></td>
                            <td><?php echo $rows['purchase_price']; ?></td>
                            <td class="depreciated_value"><?php echo $dep_status; ?></td>
                            <td><?php echo $month_difference." Month/s" ?></td>
                            <td class="asset_depreciated td_button"><a href=""><input type="button" class="edit btn_action" value="Update"></a>
                            </td>
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