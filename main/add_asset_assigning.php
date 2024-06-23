<?php 
    include("../theme/header.php");
?>


&nbsp;>&nbsp;&nbsp;New Assets Assigning
</div>
<div class="search-bar">
    <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="asset-assigning-search">
</div>
</div>
<div class="form-container">
    <div class="form-wrapper">
        <form action="asset_assign.php" method="POST">
            <div class="heading">
                <h2>New Assets</h2>
            </div>
            <div class="inputs">
                <label for="employee_name">Employee Name:</label>
                <select name="asset_assign_emp_id" id="employee_name" class="select_two" required>
                    <option value="">--Select here--</option>
                    <?php
                    
                    $select_employee = $conn->prepare("SELECT emp_id, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) as 
                    full_name FROM employees where status = 'Employed' and archived = 'Unarchived'");
                    $select_employee->execute();
                    $select_employee_result = $select_employee->get_result();

                    if ($select_employee_result->num_rows > 0) {
                        while ($rows = $select_employee_result->fetch_assoc()) {
                            echo "<option value='".$rows['emp_id']."'>".$rows['full_name']."</option>";
                        }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="inputs">
                <label for="barcodeInput">Asset Barcode:</label>
                <input type="text" id="barcodeInput-assign" placeholder="Scan barcode here" required>
                <img src="../img/close.png" alt="" class="clear">
            </div>
            <div class="dynamic_info">
                
            </div>
            <div class="inputs" hidden>
                <label for="depreciated_value" hidden>Depreciated Amount:</label>
                <input type="text" id="depreciated_value" name="dep_price" hidden readonly>
            </div>
            <div class="inputs">
                <label for="assign_date">Assign Date:</label>
                <input type="date" id="assign_date" name="assign_date" value="<?php echo $asset_assign_date; ?>"
                    required>
            </div>
            <div class="inputs">
                <label for="return_date">Return Date:</label>
                <input type="date" id="return_date" name="assign_returned_date"
                    value="<?php echo $asset_assign_return_date; ?>">
            </div>
            <div class="btn_submit">
                <button type="submit" name="btn_save_asset_assign">Save</button>
            </div>
        </form>
    </div>
</div>
<?php include("../theme/footer.php"); ?>

<script>
    // const barcodeInput = document.getElementById('barcodeInput');
    

    // barcodeInput.addEventListener('keydown', function(event) {
    //         event.preventDefault();
    //     });
   
</script>