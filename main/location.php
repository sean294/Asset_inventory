<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Location
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="location-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
            <a href="add_location.php"><button>Add New Location</button></a>
        </div>
        <div class="table-container">
            <div class="search-bar-asset">
                <label hidden for="search-bar">Search:</label>
                <input hidden type="text" id="search-bar-asset" placeholder="Search here...">
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <th>No.</th>
                        <th hidden>ID</th>
                        <th>Address</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                        $loc_no = 1;
                        $select_location = $conn->prepare("SELECT * FROM locations");
                        $select_location->execute();
                        $result_select_location = $select_location->get_result();

                        if ($result_select_location->num_rows > 0) {
                            while ($rows = $result_select_location->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?php echo $loc_no++.".)"; ?></td>
                            <td hidden class="loc_id"><?php echo $rows['location_id']; ?></td>
                            <td><?php echo $rows['address']; ?></td>
                            <td class="loc_td td_button"><input type="button" class="edit btn_action" value="Edit">
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