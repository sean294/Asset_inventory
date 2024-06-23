<?php include("../theme/header.php"); ?>


        &nbsp;>&nbsp;&nbsp;New Locations
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="add-location-search">
    </div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="" method="POST">
            <div class="heading">
                <h2>New Location</h2>
            </div>
            <div class="inputs">
                <label for="address">Address:</label>
                <input type="text" id="address" name="location" required value="<?php echo $location; ?>">
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_location">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>