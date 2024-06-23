<?php include("../theme/header.php"); ?>

        &nbsp;>&nbsp;&nbsp;New Maintenance
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="add-maintenance-search">
    </div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="maintenance.php" method="POST">
            <div class="heading">
                <h2>New Maintenance</h2>
            </div>
            <div class="inputs">
                <label for="barcodeInput">Asset Barcode:</label>
                <input type="text" id="barcodeInput-maintenance" name="barcode" placeholder="Scan barcode here" required>
                <img src="../img/close.png" alt="" class="clear">
            </div>
            <div class="dynamic_info">
                
            </div>

            <div class="inputs">
                <label for="date_maintenance">Maintenance Date:</label>
                <input type="date" id="date_maintenance" name="maintenance_date" value="<?php echo $maintenance_date; ?>" required>
            </div>

            <div class="inputs">
                <label for="date_maintenance">Return Date:</label>
                <input type="date" id="date_maintenance" name="repaired_date" value="<?php echo $repaired_date; ?>">
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_maintenance">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>