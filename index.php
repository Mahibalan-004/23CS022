<?php
include "config/db.php";

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "" || $password == "") {
        $error = "Please enter email and password";
    } else {

        $q = mysqli_query(
            $conn,
            "SELECT * FROM users 
             WHERE email='$email' 
             AND password='$password' 
             AND role='user'"
        );

        if (mysqli_num_rows($q) == 1) {

            $u = mysqli_fetch_assoc($q);

            /* CHECK USER STATUS */
            if ($u['status'] == "Inactive") {
                $error = "Your account is inactive. Contact admin.";
            } else {
                $_SESSION['user'] = $email;
                header("Location: menu.php");
            }

        } else {
            $error = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<!-- <link rel="stylesheet" href="assets/style.css"> -->
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
</head>

<body>
<div class="container">

<h2>User Login</h2>

<?php if ($error != "") { ?>
    <p style="color:red;font-weight:bold;"><?php echo $error; ?></p>
<?php } ?>

<form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

<p>
    New user? <a href="register.php">Register</a>
</p>

<p>
    <a href="admin_login.php">
        <button type="button">Admin Login</button>
    </a>
</p>

</div>
</body>
</html>
