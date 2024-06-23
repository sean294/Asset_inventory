<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Position
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="position-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
            <a href="add_position.php"><button>Add New Position</button></a>
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
                        <th>Position Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                        $pos_no = 1;
                        $select_position = $conn->prepare("SELECT * FROM positions");
                        $select_position->execute();
                        $result_select_position = $select_position->get_result();

                        if ($result_select_position->num_rows > 0) {
                            while ($rows = $result_select_position->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?php echo $pos_no++.".)"; ?></td>
                            <td hidden class="position_id"><?php echo $rows['position_id']; ?></td>
                            <td><?php echo $rows['position_name']; ?></td>
                            <td class="position_td td_button"><input type="button" class="edit btn_action" value="Edit">
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