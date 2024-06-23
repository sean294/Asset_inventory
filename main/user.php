<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Users
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="users-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
            <a href="add_user.php"><button>Add New Users</button></a>
        </div>
        <div class="table-container">
            <div class="search-bar-asset" hidden>
                <label hidden for="search-bar">Search:</label>
                <input hidden type="text" id="search-bar-asset" placeholder="Search here...">
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <th>No.</th>
                        <th hidden>User ID</th>
                        <th>Username</th>
                        <th >Employee Name</th>
                        <th >Position</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php

                        $no = 1;

                        $select_user = $conn->prepare("SELECT
                                                            user_id,
                                                            username,
                                                            CONCAT(emp.fname, ' ', COALESCE(emp.mname, ''), ' ', emp.lname) as full_name,
                                                            status,
                                                            position_name as position
                                                        FROM 
                                                            users u
                                                        left join
                                                            employees emp on u.emp_id = emp.emp_id
                                                        left join
                                                            positions p on emp.position_id = p.position_id
                                                        where
                                                            user_id");
                        $select_user->execute();
                        $result_select_user = $select_user->get_result();
                        if ($result_select_user->num_rows > 0) {
                            while ($rows = $result_select_user->fetch_assoc()) {
                            ?>
                        <tr>
                            <td><?php echo $no++.".)"; ?></td>
                            <td hidden class="uid"><?php echo $rows['user_id']; ?></td>
                            <td><?php echo $rows['username']; ?></td>
                            <td><?php echo $rows['full_name']; ?></td>
                            <td><?php echo $rows['position']; ?></td>
                            <td class="uid_td td_button"><input type="button" class="edit btn_action" value="Edit">
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