<?php
session_start();
include "work.php";
include "connect.php";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Use prepared statements to fetch user securely
    $stmt = $con->prepare("SELECT email, `password` FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stored_password = $user['password'];

        // Debugging: Print stored hashed password (Remove this after testing)
        echo "Stored hashed password: " . htmlspecialchars($stored_password) . "<br>";
        echo "Entered password: " . htmlspecialchars($password) . "<br>";

        // Check if stored password is a valid hash (Remove after testing)
        if (!password_get_info($stored_password)['algo']) {
            echo "Error: Password in DB is not hashed correctly!";
            exit();
        }

        // Verify the password
        if (password_verify($password, $stored_password)) {
            echo "Password verification successful!<br>";  // Debugging message
            $_SESSION['Email'] = $user['email'];
            header("Location: info.php");
            exit();
        } else {
            echo "Password verification failed.<br>";  // Debugging message
            $error_message = "Invalid email or password.";
        }
    } else {
        echo "No user found with that email.<br>";  // Debugging message
        $error_message = "Invalid email or password.";
    }

    $stmt->close();
    $con->close();
}
?>

<html>
<head>
    <title> Givers--Donate here</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="block">
    <a href="index.php"><img src="image/Capturre.jpg" height="120px" width="200px"></a>
</div>
<hr>
<div id="come">
    <div id="menuu">
        <a href="sign.php"><strong>Sign Up</strong></a>
        <a href="login.php"><strong>Login</strong></a>
    </div>

    <div id="form">
        <form method="POST" action="login.php">
            <p><strong>LOGIN</strong></p>
            <label>Email: </label><br/>
            <input type="email" name="email" class="inputFields" required /><br><br/>
            <label>Password: </label><br/>
            <input type="password" name="password" class="inputFields" required/><br><br/>
            <input type="submit" class="thebuttons" name="submit" /><br>
            <span style="color:red;"> <?php echo $error_message; ?> </span>
        </form>
    </div>
</div>
</body>
</html>
