<?php
include "config/db.php";

$error = "";
$success = "";

if (isset($_POST['reg'])) {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $pass     = trim($_POST['password']);
    $cpass    = trim($_POST['cpassword']);

    /* BASIC VALIDATION */
    if ($name=="" || $email=="" || $pass=="" || $cpass=="") {
        $error = "All fields are required";
    }
    else if ($pass != $cpass) {
        $error = "Passwords do not match";
    }
    else {

        /* CHECK EMAIL EXISTS */
        $check = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered";
        } 
        else {

            /* INSERT USER */
            mysqli_query(
                $conn,
                "INSERT INTO users(name,email,password,role,status)
                 VALUES('$name','$email','$pass','user','Active')"
            );

            $success = "Registration successful. Please login.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>/* PAGE BACKGROUND */
body{
    margin:0;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: linear-gradient(135deg,#eef2f7,#ffffff);
}

/* CENTER CONTAINER */
.container{
    width: 520px;
    margin: 60px auto;
    background: #ffffff;
    padding: 35px 40px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* HEADING */
.container h2{
    margin-bottom: 25px;
    font-size: 26px;
    color: #2c3e50;
}

/* INPUT FIELDS */
input{
    width: 100%;
    padding: 14px 15px;
    margin-bottom: 18px;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    font-size: 15px;
    transition: 0.3s;
    box-sizing: border-box;
}

/* INPUT FOCUS EFFECT */
input:focus{
    border-color: #27ae60;
    outline: none;
    box-shadow: 0 0 0 2px rgba(39,174,96,0.15);
}

/* BUTTON */
button{
    width: 100%;
    padding: 14px;
    background: #27ae60;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

button:hover{
    background: #219150;
}

/* SUCCESS & ERROR MESSAGES */
.success{
    color: #27ae60;
    background: #eafaf1;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.error{
    color: #e74c3c;
    background: #fdecea;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* LOGIN TEXT */
.container p{
    margin-top: 18px;
    font-size: 14px;
}

.container a{
    color: #2980b9;
    text-decoration: none;
    font-weight: 600;
}

.container a:hover{
    text-decoration: underline;
}
</style>
<!-- <link rel="stylesheet" href="assets/style.css"> -->
</head>

<body>
<div class="container">

<h2>User Registration</h2>

<?php if ($error != "") { ?>
    <p style="color:red;font-weight:bold;"><?php echo $error; ?></p>
<?php } ?>

<?php if ($success != "") { ?>
    <p style="color:green;font-weight:bold;"><?php echo $success; ?></p>
<?php } ?>

<form method="post">
    <input name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="cpassword" placeholder="Confirm Password" required>
    <button name="reg">Register</button>
</form>

<p>
    Already registered? <a href="index.php">Login</a>
</p>

</div>
</body>
</html>
