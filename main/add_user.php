<?php include("../theme/header.php"); ?>

&nbsp;>&nbsp;&nbsp;New Users
</div>
<div class="search-bar">
    <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="add-user-search">
</div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="" method="POST">
            <div class="heading">
                <h2>New Users</h2>
            </div>
            <div class="inputs">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user_name; ?>" required>
            </div>
            <div class="inputs">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
                <div class="show_password">
                    <img src="../img/download.png" alt="show" onclick="myFunction()">
                </div>
            </div>
            <div class="inputs">
                <label for="emp_id">Employee Name:</label>
                <select name="emp_id" id="emp_id" class="select_two" required>
                    <option value="">--Select here--</option>
                    <?php
                    
                    $s_employee_user = $conn->prepare("SELECT 
                                                            emp_id, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as full_name,
                                                            position_name as position
                                                        from 
                                                            employees emp 
                                                        left join 
                                                            positions p on emp.position_id = p.position_id
                                                        where 
                                                            status = 'Employed' 
                                                        and 
                                                            archived = 'Unarchived' 
                                                        and 
                                                            position_name in ('Admin', 'Supervisor', 'President', 'IT')");
                    $s_employee_user->execute();
                    $s_employee_user_result = $s_employee_user->get_result();
                    
                    if ($s_employee_user_result->num_rows > 0) {
                        while ($rows = $s_employee_user_result->fetch_assoc()) {
                            echo "<option value='".$rows['emp_id']."'>".$rows['full_name']."</option>";
                        }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_user">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>
<script>
function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>