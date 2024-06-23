<?php include("../theme/header.php"); ?>


        &nbsp;>&nbsp;&nbsp;New Department
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="dashboard-search">
    </div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="" method="POST">
            <div class="heading">
                <h2>New Department</h2>
            </div>
            <div class="inputs">
                <label for="department_name">Department Name:</label>
                <input type="text" id="department_name" name="department_name" required value="<?php echo $department_name; ?>">
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_department">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>