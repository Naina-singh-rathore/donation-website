<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("connect.php");
include("work.php");

$n = "User"; // Default name
$r = ""; // Default error message

if (isset($_SESSION['Email'])) {
    $email = $_SESSION['Email'];

    // Use a prepared statement for better security
    if ($stmt = mysqli_prepare($con, "SELECT `Name` FROM users WHERE Email=?")) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($res = mysqli_fetch_assoc($result)) {
            $n = $res["Name"];
        }
        
        mysqli_stmt_close($stmt);
    }
    
    // Ensure infom() function exists in work.php
    if (function_exists('infom')) {
        $r = infom($con, $email);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Givers - Donate Here</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:white; background-image:none;">
    <div id="block">
        <img src="image/Capturre.jpg" height="120px" width="200px">
    </div>
    <hr>
    <center>
        <img src="quote.png">
        <p style="color:gold; font-size:50px; font-family:vivaldi;">Donation Details</p>
    </center>
    
    <div id="come">
        <div id="form">
            <form method="POST" action="info.php">
                <p style="color:orange; font-size:25px;"><b>Hello <?php echo htmlspecialchars($n); ?>,</b></p>
                <p style="color:gold; font-family:impact; font-size:15px;">
                    Please fill out the details below to carry out your Good Work.
                </p>

                <label>Select your NGO: </label><br/>
                <select name="ngo" required>
                    <option value="Sarthak Foundation">Sarthak Foundation</option>
                    <option value="Humsafar">Humsafar</option>
                    <option value="Pratham">Pratham</option>
                    <option value="Dada-Dadi">Dada-Dadi</option>
                    <option value="NHFDC">NHFDC</option>
                </select>
                
                <br/><br/>
                <label>Mobile Number: </label><br/>
                <input type="text" name="number" class="inputFields" required pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number">
                <br><br/>

                <label>Aadhar Number: </label><br/>
                <input type="text" name="aadhar" class="inputFields" required pattern="[0-9]{12}" title="Enter a valid 12-digit Aadhar number">
                <br><br/>

                <label>Donation Amount: </label><br/>
                <input type="text" name="amount" class="inputFields" required pattern="[0-9]+" title="Enter a valid numeric amount">
                <p style="font-size:15px;">Example: 10000, 50000, 100000</p>

                <input type="checkbox" name="condition" required> 
                I have read through the website's Privacy Policy & Donor's Policy and Terms and Conditions to make a donation.<br><br/>

                <input type="submit" class="thebuttons" name="submit" value="Make Payment"><br>

                <?php
                if (!empty($r)) {
                    echo "<p style='color:red'>$r</p>";
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>
