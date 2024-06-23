<?php include("../theme/header.php"); ?>


        &nbsp;>&nbsp;&nbsp;New Employee's
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="add-employee-search">
    </div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="" method="POST">
            <div class="heading">
                <h2>New Employee's</h2>
            </div>
            <div class="inputs">
                <label for="emp_id_np">Employee ID No:</label>
                <input type="text" id="emp_id_np" name="emp_no" value="<?php echo $emp_no; ?>" required>
            </div>
            <div class="inputs">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="fname" value="<?php echo $fname; ?>" required>
            </div>
            <div class="inputs">
                <label for="middlename">Middle Name:</label>
                <input type="text" id="middlename" name="mname" value="<?php echo $mname; ?>">
            </div>
            <div class="inputs">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lname" value="<?php echo $lname; ?>" required>
            </div>
            <div class="inputs">
                <label for="gender">Gender:</label>
                <select id="gender" class="select_two" name="gender" required>
                    <option value="">--Select here--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="inputs">
                <label for="contact">Contact No:</label>
                <input type="text" id="contact" name="contact_no" value="<?php echo $contact_no; ?>" required>
            </div>
            <div class="inputs">
                <label for="location">Location:</label>
                
                <select id="location" class="select_two" name="location_emp" required>
                    <option value="">--Select here--</option>
                    <?php
                    
                    $s_location_emp = $conn->prepare("SELECT * from locations");
                    $s_location_emp->execute();
                    $s_location_emp_result = $s_location_emp->get_result();
                    
                    if ($s_location_emp_result->num_rows > 0) {
                        while ($rows = $s_location_emp_result->fetch_assoc()) {
                            echo "<option value='".$rows['location_id']."'>".$rows['address']."</option>";
                        }
                    }
                    
                    ?>
                    
                </select>
            </div>
            <div class="inputs">
                <label for="position">Position:</label>
                <select id="position" class="select_two" name="position_emp" required>
                    <option value="">--Select here--</option>
                    <?php
                    
                    $s_position_emp = $conn->prepare("SELECT * from positions");
                    $s_position_emp->execute();
                    $s_position_emp_result = $s_position_emp->get_result();
                    
                    if ($s_position_emp_result->num_rows > 0) {
                        while ($rows = $s_position_emp_result->fetch_assoc()) {
                            echo "<option value='".$rows['position_id']."'>".$rows['position_name']."</option>";
                        }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="inputs">
                <label for="status_emp">Department:</label>
                <select id="department_id" class="select_two" name="dept_emp" required>
                    <option value="">--Select here--</option>
                    <?php
                    
                    $s_department_emp = $conn->prepare("SELECT * from departments");
                    $s_department_emp->execute();
                    $s_department_emp_result = $s_department_emp->get_result();
                    
                    if ($s_department_emp_result->num_rows > 0) {
                        while ($rows = $s_department_emp_result->fetch_assoc()) {
                            echo "<option value='".$rows['dept_id']."'>".$rows['dept_name']."</option>";
                        }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="inputs">
                <label for="hired_date">Hired Date:</label>
                <input type="date" id="hired_date" name="hired_date" value="<?php echo $hired_date; ?>" required>
            </div>
            <div class="inputs">
                <label for="resigned_date">Resigned Date:</label>
                <input type="date" id="resigned_date" name="resigned_date" value="<?php echo $resigned_date; ?>">
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_employee">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>