<?php include("../theme/header.php"); ?>


&nbsp;>&nbsp;&nbsp;New Assets
</div>
<div class="search-bar">
    <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="dashboard-search">
</div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="add_assets.php" method="POST">
            <div class="heading">
                <h2>New Assets</h2>
            </div>
            <div class="inputs">
                <label for="brand_name">Brand Name:</label>
                <input type="text" id="brand_name" name="brand_name" required value="<?php echo $asset_name; ?>">
            </div>
            <div class="inputs">
                <label for="asset_type">Asset Type:</label>
                <select name="asset_type" id="asset_type" required class="select_two">
                    <option value="">--Select here--</option>
                    <option value="Mouse">Mouse</option>
                    <option value="Keyboard">Keyboard</option>
                    <option value="Monitor">Monitor</option>
                    <option value="System Unit">System Unit</option>
                    <option value="Printer">Printer</option>
                </select>
            </div>

            <div class="inputs">
                <label for="barcode">Barcode:</label>
                <input type="text" id="barcode" name="barcode_number" required value="<?php echo $barcode_number; ?>">
            </div>
            <div class="inputs">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required value="<?php echo $description; ?>">
            </div>
            <div class="inputs">
                <label for="dp_year">Depreciated Year:</label>
                <input type="number" name="dp_year" min="0" step="0.01" value="<?php echo $dp_year; ?>">
            </div>
            <div class="inputs">
                <label for="purchase_price">Purchase Price:</label>
                <input type="number" name="purchase_price" min="0" step="0.01" value="<?php echo $purchase_price; ?>">
            </div>
            <div class="inputs">
                <label for="purchase_date">Purchase Date:</label>
                <input type="date" id="purchase_date" name="purchase_date" required
                    value="<?php echo $purchase_date; ?>">
            </div>
            <div class="inputs">
                <label for="location">Location:</label>
                <select name="location_id" id="location" required class="select_two">
                    <option value="">--Select here--</option>
                    <?php 
                    $location_asset = "";
                    $location = "SELECT * from locations";
                    $location_result = $conn->query($location);

                    if ($location_result->num_rows > 0) {
                        while ($rows = $location_result->fetch_assoc()) {
                            echo "<option value='".$rows['location_id']."'>".$rows['address']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_assets">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>