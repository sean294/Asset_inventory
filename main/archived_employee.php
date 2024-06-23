<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Archived Employees
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="employee-search">
    </div>
</div>

<div class="body-container">
    <div class="body-wrapper">
        <div class="btn-add-asset">
        </div>
        <div class="table-container">
            <div class="search-bar-asset">
                <label for="search-bar">Search:</label>
                <input type="text" id="search-employee-archived" placeholder="Search here...">
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <th>No.</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Contact #.</th>
                        <th>Current Location</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Hired Date</th>
                        <th>Resigned Date</th>
                        <th >Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="table-search-archived">
                        <?php

                        $emp_no = 1;
                        $select_employee = $conn->prepare("SELECT 
                                                                emp_id,
                                                                CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                                                gender,
                                                                contact_no,
                                                                loc.address as address,
                                                                p.position_name as position,
                                                                dept.dept_name as department,
                                                                hired_date,
                                                                resigned_date,
                                                                status
                                                            FROM 
                                                                employees emp
                                                            left join
                                                                locations loc on emp.location_id = loc.location_id
                                                            left join
                                                                positions p on emp.position_id = p.position_id
                                                            left join
                                                                departments dept on emp.dept_id = dept.dept_id
                                                            where
                                                                status in ('Employed', 'Unemployed')
                                                            and
                                                                emp.archived = 'Archived'");
                        $select_employee->execute();
                        $result_select_employee = $select_employee->get_result();

                        if ($result_select_employee->num_rows > 0) {
                            while ($rows = $result_select_employee->fetch_assoc()) {

                                if ($rows['resigned_date'] !== null) {
                                    // Display the date normally
                                    $resigned_date =  date("F d, Y", strtotime($rows['resigned_date']));
                                } else {
                                    // Display a message indicating that the date is not available
                                    $resigned_date =  "";
                                }
                                ?>
                                

                        <tr>
                            <td><?php echo $emp_no++.".)"; ?></td>
                            <td class="emp_id"><?php echo $rows['emp_id']; ?></td>
                            <td><?php echo $rows['full_name'] ?></td>
                            <td><?php echo $rows['contact_no'] ?></td>
                            <td><?php echo $rows['address'] ?></td>
                            <td><?php echo $rows['position'] ?></td>
                            <td><?php echo $rows['department'] ?></td>
                            <td><?php echo date("F d, Y", strtotime($rows['hired_date'])); ?></td>
                            <td><?php echo $resigned_date; ?></td>
                            <td class="emp_status"><?php echo $rows['status']; ?></td>
                            <td class="emp_unarchived_td td_button"><input type="button" class="archived btn_action"
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