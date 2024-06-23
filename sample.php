<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="frameworks/jquery-3.6.0.js"></script>
    <script src="frameworks/select2.min.js"></script>
    <link href="frameworks/select2.min.css" rel="stylesheet">
    <title>Assets Management | Mitsubishi Motors</title>
    <link rel="icon" href="img/Mitsubishi_motors_new_logo.svg.png" type="image/x-icon">
    <script src="js/script.js"></script>
    <script src="js/select2.js"></script>
</head>
<body>
<div class="form-container">
    <div class="form-wrapper">
        <form action="add_assets.php" method="POST">
            <div class="heading">
                <h2>New Assets</h2>
            </div>
            <div class="inputs">
                <label for="brand_name">Brand Name:</label>
                <input type="text" id="brand_name" name="brand_name" >
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
                <input type="text" id="barcode" name="barcode_number" required>
            </div>
            <div class="inputs">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div class="inputs">
                <label for="purchase_date">Purchase Date:</label>
                <input type="date" id="purchase_date" name="purchase_date" required>
            </div>
            <div class="inputs">
                <label for="location">Location:</label>
                <select name="location_id" id="location" required class="select_two">

                </select>
            </div>
            <div class="barcode-container">
                <div class="barcode-image">
                <svg id="barcode"></svg>
                </div>
                <div class="barcode-number">
                    <input type="text" value="" id="txt_input">
                </div>
                <div class="code-generator">
                    <button type="button" class="c-generator" id="codenumber_generate">Code Generator</button>
                </div>
                <div class="barcode-generator">
                    <input type="button" class="b-generator" id="barcode_generate" value="Barcode Generator">
                </div>
                            <script type="text/javascript" src="frameworks/JsBarcode.all.min.js"></script>
            <script type="text/javascript">
                document.getElementById("codenumber_generate").addEventListener("click", function() {
                    // Call the function to generate a random 5-digit number
                    const constNum = "1000"; 
                    var randomCode = generateRandomCode(1000000, 99999999);

                    // Set the generated code as the value of the input element
                    document.getElementById("txt_input").value = constNum + randomCode;
                });

                function generateRandomCode(min, max) {
                    // Generate a random number between min and max (inclusive)
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }

                document.getElementById("barcode_generate").addEventListener('click', function(){
                    var txt = document.getElementById("txt_input").value;
                    console.log(txt);

                            // Create a new SVG element
        var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute("id", "barcode-svg");

        // Append the SVG element to the container
        var container = document.getElementById("barcode");
        container.innerHTML = ""; // Clear previous content
        container.appendChild(svg);

                    JsBarcode("#barcode", txt, {format: "CODE128", displayValue: true, textMargin: 0, svg: true});
                })
            </script>
            </div>

            <div class="btn_submit">
                <button type="submit" name="btn_save_assets">Save</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>