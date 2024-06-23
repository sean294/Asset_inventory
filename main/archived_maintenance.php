<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Archived Maintenance
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
                        <th>ID</th>
                        <th>Asset Name</th>
                        <th>Maintenance Date</th>
                        <th>Returned Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php

                        $no = 1;

                        $select_maintenance = $conn->prepare("SELECT
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
                                                            m.status in ('Maintenance', 'Repaired','Damaged')
                                                        and 
                                                            m.archived = 'Archived'");
                        $select_maintenance->execute();
                        $result_select_maintenance = $select_maintenance->get_result();
                        if ($result_select_maintenance->num_rows > 0) {
                            while ($rows = $result_select_maintenance->fetch_assoc()) {
                                if ($rows['repaired_date'] !== null) {
                                    // Display the date normally
                                    $returned_date =  date("F d, Y", strtotime($rows['repaired_date']));
                                } else {
                                    // Display a message indicating that the date is not available
                                    $returned_date =  "Not Yet Repaired";
                                }
                        ?>
                        <tr>
                            <td><?php echo $no++.".)"; ?></td>
                            <td class="maintenance_id"><?php echo $rows['maintenance_id']; ?></td>
                            <td><?php echo $rows['asset_name']; ?></td>
                            <td><?php echo date('F d, Y', strtotime($rows['maintenance_date'])); ?></td>
                            <td><?php echo $returned_date; ?></td>
                            <td class="maintenance_status"><?php echo $rows['status']; ?></td>
                            <td class="maintenance_td_unarchived td_button"><input type="button" class="archived btn_action"
                                    value="Unarchived"></td>
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