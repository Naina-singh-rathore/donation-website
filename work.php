<?php  
include("connect.php");

function url($url) {
    header("Location: " . $url);
    exit(); // Ensure script stops execution after redirect
}

function infom($con, $email) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        if (!isset($_POST['number'], $_POST['aadhar'], $_POST['ngo'], $_POST['amount'])) {
            return "All fields are required.";
        }

        $mobile = mob($_POST['number']);
        $aadhar = adhar($_POST['aadhar']);
        $ngo = $_POST['ngo'];
        $amount = donation($_POST['amount']);
        $date = date("F, d Y");

        if ($mobile != $_POST['number']) return $mobile;
        if ($aadhar != $_POST['aadhar']) return $aadhar;
        if ($amount != $_POST['amount']) return $amount;

        $insertQuery = "INSERT INTO info(`Name`, NGO, Mobile, Aadhar, Amount, `Date`) VALUES(?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($con, $insertQuery)) {
            mysqli_stmt_bind_param($stmt, "ssssss", $email, $ngo, $mobile, $aadhar, $amount, $date);
            if (mysqli_stmt_execute($stmt)) {
                url('pay.php'); // Redirect after successful insertion
            } else {
                return "Error in inserting your information";
            }
            mysqli_stmt_close($stmt);
        } else {
            return "Database error: Could not prepare statement.";
        }
    }
}

function mob($data) {
    if (!ctype_digit($data) || strlen($data) != 10) {
        return "Mobile Number must be exactly 10 digits.";
    }
    return $data;
}

function adhar($data) {
    if (!ctype_digit($data) || strlen($data) != 12) {
        return "Aadhar Number must be exactly 12 digits.";
    }
    return $data;
}

function donation($data) {
    if (!ctype_digit($data)) {
        return "Invalid donation amount. Please enter numbers only.";
    }
    return $data;
}
?>
