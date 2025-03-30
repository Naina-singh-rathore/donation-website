<?php
include "work.php";
include "connect.php";
include("mail.php");

$res = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $passwordconfirm = mysqli_real_escape_string($con, $_POST['passwordconfirm']);
    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
    $gender = mysqli_real_escape_string($con, $_POST['g']);
    $birthday = mysqli_real_escape_string($con, $_POST['birthday']);

    // Check if passwords match
    if ($password !== $passwordconfirm) {
        $res = "Passwords do not match!";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user data into the database
        $query = "INSERT INTO users (`name`, email, `password`, `occupation`, gender, `birthday`) VALUES ('$name', '$email', '$hashed_password', '$occupation', '$gender', '$birthday')";
        
        if (mysqli_query($con, $query)) {
            $res = "Registration successful!";
        } else {
            $res = "Error: " . mysqli_error($con);
        }
    }
}
?>

<html>
<head>
<title> Givers--Donate here</title>
<link rel ="stylesheet" href="css/style.css">
</head>
<body>
<div id="block">
    <a href="index.php"><img src = "image/Capturre.jpg" height=120px width=200px></a>
</div>
<hr>
<div id="come">
    <div id="menuu">
        <a href="sign.php"><strong>Sign Up</strong></a>
        <a href="login.php"><strong>Login</strong></a>
    </div>

    <div id="form">
        <form method="POST" action="sign.php" enctype="multipart/form-data">
            <p><strong>SIGNUP</strong></p>
            <label> Name *: </label><br/>
            <input type="text" name="name" class="inputFields" required /><br><br/>

            <label>Email *: </label><br/>
            <input type="text" name="email" class="inputFields" required /><br><br/>
            <label>Password *: </label><br/>
            <input type="password" name="password" class="inputFields" required /><br><br/>
            <label>Re-enter Password *: </label><br/>
            <input type="password" name="passwordconfirm" class="inputFields" required/><br><br/>
            <label>Occupation *: </label><br/>
            <input type="text" name="occupation" class="inputFields" required /><br><br/>
            <label>Gender *:</label>
            <select name="g">
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select><br><br/>
            <label>Birthday *:</label>
            <pre style="font-size:10px"><input type="text" name="birthday" class="inputFields" required/> Example:06/12/1996</pre>
            <input type="checkbox" name="terms" required/>I agree with terms and conditions.<br><br/>
            <input type="submit"  name="submit" class="thebuttons"/><br><br/>
            <span style="color:red;"> <?php echo $res; ?> </span>
        </form>
    </div>
</div>
</body>
</html>