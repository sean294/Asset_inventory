<?php include("../theme/header.php"); ?>

        &nbsp;>&nbsp;&nbsp;New Position
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="add-position-search">
    </div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="" method="POST">
            <div class="heading">
                <h2>New Position</h2>
            </div>
            <div class="inputs">
                <label for="position_name">Position Name:</label>
                <input type="text" id="position_name" name="position" value="<?php echo $position; ?>" required>
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_position">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>