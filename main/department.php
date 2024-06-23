<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Department
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="department-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
            <a href="add_department.php"><button>Add New Departments</button></a>
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
                        <th hidden>Department ID</th>
                        <th>Department Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $dept_no = 1;
                        $select_department = $conn->prepare("SELECT * FROM departments");
                        $select_department->execute();
                        $result_select_department = $select_department->get_result();

                        if ($result_select_department->num_rows > 0) {
                            while ($rows = $result_select_department->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?php echo $dept_no++.".)"; ?></td>
                            <td hidden class="dept_id"><?php echo $rows['dept_id']; ?></td>
                            <td><?php echo $rows['dept_name']; ?></td>
                            <td class="dept_td td_button"><input type="button" class="edit btn_action" value="Edit">
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