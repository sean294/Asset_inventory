<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Maintenance Logs
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="maintenance-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
        </div>
        <div class="table-container">
            <div class="search-bar-asset">
                <label for="search-bar">Search:</label>
                <input type="text" id="search-bar-asset" placeholder="Search here...">
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <th>No.</th>
                        <th>Asset Name</th>
                        <th>Asset Type</th>
                        <th>Barcode Number</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th>Date Time</th>
                    </thead>
                    <tbody>
                        <?php

                        $no = 1;

                        $select_logs = $conn->prepare("SELECT
                                                            *
                                                        FROM 
                                                            log_maintenance
                                                        where
                                                            log_m");
                        $select_logs->execute();
                        $result_select_logs = $select_logs->get_result();
                        if ($result_select_logs->num_rows > 0) {
                            while ($rows = $result_select_logs->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $no++.".)"; ?></td>
                            <td class=""><?php echo $rows['asset_brandname']; ?></td>
                            <td><?php echo $rows['asset_type']; ?></td>
                            <td><?php echo $rows['barcode_number']; ?></td>
                            <td><?php echo $rows['value']; ?></td>
                            <td><?php echo $rows['status']; ?></td>
                            <td><?php echo date('F d, Y h:i:s A', strtotime($rows['datetime'])); ?></td>
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