<?php include("../theme/header.php") ?>

        &nbsp;>&nbsp;&nbsp;Dashboard
    </div>
    <div class="search-bar">
        <i class="fa fa-search" aria-hidden="true"></i><input type="text" class="dashboard-search">
    </div>
</div>
<div class="main-content">
    <div class="first-row">
        <div class="icons users">
            <span class="icon"><a href=""><i class="fa fa-users" aria-hidden="true"></i></a></span>
            <?php 
            
            $employee_count = "SELECT COUNT(*) AS 'employee' from employees where status = 'Employeed' || archived = 'Unarchived'";
                                    $result = $conn->query($employee_count);

                                    if ($result->num_rows > 0) {
                                        # code...
                                        $rows = $result->fetch_assoc();
                                        echo "<span class='count'>".$rows['employee']."</span>";
                                    }else{
                                        echo "<span>Error</span>";
                                    }
            
            ?>
            <p>Total Employees</p>
        </div>
        <div class="icons assets">
            <span class="icon"><a href=""><i class="fa fa-archive" aria-hidden="true"></i></a></span>
            <?php 
            
            $asset_count = "SELECT COUNT(*) AS 'asset' from assets where status in ('In Used', 'Not Used', 'Maintenance(Not Used',
            'Maintenance(In Used)', 'Repaired') || archived = 'Unarchived'";
                                    $result = $conn->query($asset_count);

                                    if ($result->num_rows > 0) {
                                        $rows = $result->fetch_assoc();
                                        echo "<span class='count'>".$rows['asset']."</span>";
                                    }else{
                                        echo "<span>Error</span>";
                                    }
            
            ?>
            <p>Total Assets</p>
        </div>
        <div class="icons departments">
            <span class="icon"><a href=""><i class="fa fa-building" aria-hidden="true"></i></a></span>
            <?php 
            
            $asset_count = "SELECT COUNT(*) AS 'department' from departments";
                                    $result = $conn->query($asset_count);

                                    if ($result->num_rows > 0) {
                                        $rows = $result->fetch_assoc();
                                        echo "<span class='count'>".$rows['department']."</span>";
                                    }else{
                                        echo "<span>Error</span>";
                                    }
            
            ?>
            <p>Total Departments</p>
        </div>
        <div class="icons notUse">
            <span class="icon"><a href=""><i class="fa fa-check-square" aria-hidden="true"></i></a></span>
            <?php 
            
            $asset_count = "SELECT COUNT(*) AS 'assign' from assets_assignments where status = 'In Used'";
                                    $result = $conn->query($asset_count);

                                    if ($result->num_rows > 0) {
                                        $rows = $result->fetch_assoc();
                                        echo "<span class='count'>".$rows['assign']."</span>";
                                    }else{
                                        echo "<span>Error</span>";
                                    }
            
            ?>
            <p>Total In Used Assets</p>
        </div>
    </div>
    <div class="second-row">
        <div class="icons buttons-adds">
            <span class="icon"><a href="add_employee.php"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></span>
            <p>New Employees</p>
        </div>
        <div class="icons buttons-adds">
            <span class="icon"><a href="add_assets.php"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></span>
            <p>New Assets</p>
        </div>
        <div class="icons buttons-adds">
            <span class="icon"><a href="add_asset_assigning.php"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></span>
            <p>New Asset Assign</p>
        </div>
        <div class="icons buttons-adds">
            <span class="icon"><a href="add_maintenance.php"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></span>
            <p>New Maintenance</p>
        </div>
    </div>

</div>

<?php include("../theme/footer.php"); ?>