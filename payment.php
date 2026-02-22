<?php
include "config/db.php";
include "user_header.php";

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

if(empty($_SESSION['cart'])){
    echo "<div class='container'><h3>Cart is empty</h3></div>";
    exit();
}

/* CALCULATE TOTAL */
$subtotal = 0;
$items_list = "";

foreach($_SESSION['cart'] as $id=>$qty){
  $item = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM items WHERE id=$id"));
  $total = $item['price'] * $qty;
  $subtotal += $total;

  $items_list .= $item['name']." x ".$qty.", ";
}

$tax = $subtotal * 0.05;
$grand = $subtotal + $tax;
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

<h2>Scan & Pay</h2>

<h3>Order Details</h3>
<p><?php echo $items_list; ?></p>

<table>
<tr><td>Subtotal</td><td>₹<?php echo $subtotal; ?></td></tr>
<tr><td>Tax (5%)</td><td>₹<?php echo number_format($tax,2); ?></td></tr>
<tr><th>Total Payable</th><th>₹<?php echo number_format($grand,2); ?></th></tr>
</table>

<br>

<!-- QR CODE -->
<div style="text-align:center;">
  <img src="assets/qr.jpeg" width="220">
  <p>Scan to Pay</p>
  <p>Add the E-mail at the command of the payment for the Payment confirmation.</p>
</div>

<form method="post">
  <button name="confirm_payment" style="background:#27ae60;">
    I Have Paid
  </button>
</form>

</div>

</body>
</html>

<?php
/* AFTER PAYMENT CONFIRM */
if(isset($_POST['confirm_payment'])){
    $_SESSION['payment_done'] = true;
    header("Location: place_order.php");
}
?>