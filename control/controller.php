<?php
 $conn = mysqli_connect("localhost", "root", "", "asset_inventory");

 if (!$conn) {
    die("Connection Failed".mysqli_connect_error());
 }

 session_start();
// Asset 
$asset_name       = "";
$barcode_number   = "";
$description      = "";
$purchase_date    = "";
$purchase_price   = "";
$dp_year          = "";

// department
$department_name  = "";

// employee
$fname            = "";
$mname            = "";
$lname            = "";
$contact_no       = "";
$location         = "";
$position         = "";
$hired_date      = "";
$resigned_date    = "";
$emp_no    = "";

// user
$user_name         = "";
$password         = "";
$co_password      = "";
$emp_id           = "";

// maintenance
$maintenance_date = "";
$repaired_date = "";

// asset_assign
$asset_assign_date = "";
$asset_assign_return_date = "";

$const_archived = "Archived";
$const_unarchived = "Unarchived";


include("asset.php");
include("department.php");
include("employee.php");
include("position.php");
include("location.php");
include("user.php");
include("maintenance.php");
include("asset_assigning.php");

// <----------------------------------- SEARCH ASSET ASSIGN BARCODE ------------------------------------>
if (isset($_POST['barcodescan_assign'])) {
   $query_barcode = mysqli_real_escape_string($conn, $_POST['query_barcode']);

   $assign_srch = $conn->prepare("SELECT
                                       asset_id,
                                       barcode_number,
                                       description,
                                       asset_brandname,
                                       purchase_price,
                                       asset_type,
                                       purchase_price
                                   FROM
                                       assets
                                   WHERE
                                       barcode_number = ?
                                   and 
                                       status in ('Not Used', 'Maintenance(Not Used)', 'Repaired(Not Used)', 'Returned(Not Used)')");
   $assign_srch->bind_param("s", $query_barcode);
   $assign_srch->execute();
   $assign_srch_res = $assign_srch->get_result();
   $no = 1;

   if ($assign_srch_res->num_rows > 0) {
       while ($rows = $assign_srch_res->fetch_assoc()) {
           echo "
               <div class='inputs' hidden>
                   <label hidden for='asset_id'>Asset Brand Name:</label>
                   <input type='text' name='asset_id_assign' id='asset_id' value='".$rows['asset_id']."' hidden readonly>
               </div>
               <div class='inputs'>
                   <label for='assetBrandName'>Asset Brand Name:</label>
                   <input type='text' id='assetBrandName' name='brand_name' value='".$rows['asset_brandname']."' readonly>
               </div>
               <div class='inputs'>
                   <label for='asset_type'>Asset type:</label>
                   <input type='text' id='asset_type' name='asset_type' value='".$rows['asset_type']."' readonly>
               </div>
               <div class='inputs'>
                   <label for='description'>Description:</label>
                   <input type='text' id='description' name='description' value='".$rows['description']."' readonly>
               </div>
               <div class='inputs'>
                   <label for='purchase_price'>Purchase Price:</label>
                   <input type='text' id='purchase_price' name='purchase_price' value='".$rows['purchase_price']."' readonly>
               </div>
           ";
       }
   }else {
       echo "
               <div class='inputs' hidden>
                   <label hidden for='asset_id'>Asset Brand Name:</label>
                   <input type='text' name='asset_id_assign' id='asset_id' value='' hidden readonly>
               </div>
               <div class='inputs'>
                   <label for='assetBrandName'>Asset Brand Name:</label>
                   <input type='text' id='assetBrandName' placeholder='No Results Found' required readonly>
               </div>
               <div class='inputs'>
                   <label for='description'>Description:</label>
                   <input type='text' id='description' placeholder='No Results Found' required readonly>
               </div>
           ";
   }
}
// <----------------------------------- SEARCH ASSET ASSIGN BARCODE ------------------------------------>

// <----------------------------------- SEARCH ASSET ASSIGN BARCODE ------------------------------------>
if (isset($_POST['barcodescan_maintenance'])) {
    $query_barcode = mysqli_real_escape_string($conn, $_POST['query_barcode']);
 
    $assign_srch = $conn->prepare("SELECT
                                        asset_id,
                                        barcode_number,
                                        description,
                                        asset_brandname,
                                        purchase_price,
                                        asset_type,
                                        purchase_price
                                    FROM
                                        assets
                                    WHERE
                                        barcode_number = ?
                                    and 
                                        status in ('Not Used', 'In Used', 'Repaired(Not Used)', 'Repaired(In Used)', 
                                        'Returned(In Used)', 'Returned(Not Used)', 'Damaged')");
    $assign_srch->bind_param("s", $query_barcode);
    $assign_srch->execute();
    $assign_srch_res = $assign_srch->get_result();
    $no = 1;
 
    if ($assign_srch_res->num_rows > 0) {
        while ($rows = $assign_srch_res->fetch_assoc()) {
            echo "
                <div class='inputs' hidden>
                    <label hidden for='asset_id'>Asset Brand Name:</label>
                    <input type='text' name='asset_id_assign' id='asset_id' value='".$rows['asset_id']."' hidden readonly>
                </div>
                <div class='inputs'>
                    <label for='barcode_number'>Barcode:</label>
                    <input type='text' name='barcode_number' id='barcode_number' value='".$rows['barcode_number']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='assetBrandName'>Asset Brand Name:</label>
                    <input type='text' id='assetBrandName' name='brand_name' value='".$rows['asset_brandname']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='asset_type'>Asset type:</label>
                    <input type='text' id='asset_type' name='asset_type' value='".$rows['asset_type']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='description'>Description:</label>
                    <input type='text' id='description' name='description' value='".$rows['description']."' readonly>
                </div>
                <div class='inputs'>
                    <label for='purchase_price'>Purchase Price:</label>
                    <input type='text' id='purchase_price' name='purchase_price' value='".$rows['purchase_price']."' readonly>
                </div>
            ";
        }
    }else {
        echo "
                <div class='inputs' hidden>
                    <label hidden for='asset_id'>Asset Brand Name:</label>
                    <input type='text' name='asset_id_assign' id='asset_id' value='' hidden readonly>
                </div>
                <div class='inputs'>
                    <label for='assetBrandName'>Asset Brand Name:</label>
                    <input type='text' id='assetBrandName' placeholder='No Results Found' required readonly>
                </div>
                <div class='inputs'>
                    <label for='description'>Description:</label>
                    <input type='text' id='description' placeholder='No Results Found' required readonly>
                </div>
            ";
    }
 }
 // <----------------------------------- SEARCH ASSET ASSIGN BARCODE ------------------------------------>