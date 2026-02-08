<?php
include "config/db.php";
include "user_header.php";

/* SAFETY CHECK */
if(empty($_SESSION['cart'])){
  header("Location: menu.php");
}

/* FETCH USER */
$user = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT * FROM users WHERE email='".$_SESSION['user']."'")
);

$subtotal = 0;

/* CALCULATE SUBTOTAL */
foreach($_SESSION['cart'] as $id=>$qty){
  $item = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM items WHERE id=$id")
  );
  $subtotal += $item['price'] * $qty;
}

/* TAX & TOTAL */
$tax = $subtotal * 0.05;   // 5% tax
$total = $subtotal + $tax;

/* INSERT ORDER */
mysqli_query($conn,"
  INSERT INTO orders(user_id,total,status)
  VALUES(".$user['id'].",$total,'Preparing')
");

$order_id = mysqli_insert_id($conn);

/* INSERT ORDER ITEMS */
foreach($_SESSION['cart'] as $id=>$qty){
  $item = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM items WHERE id=$id")
  );

  mysqli_query($conn,"
    INSERT INTO order_items(order_id,item_name,qty,price)
    VALUES(
      $order_id,
      '".$item['name']."',
      $qty,
      ".$item['price']."
    )
  ");
}

/* CLEAR CART */
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
<h2>Order Placed Successfully 🎉</h2>

<p><b>Order ID:</b> #<?php echo $order_id; ?></p>

<table>
<tr><td>Subtotal</td><td>₹<?php echo number_format($subtotal,2); ?></td></tr>
<tr><td>Tax (5%)</td><td>₹<?php echo number_format($tax,2); ?></td></tr>
<tr><th>Total</th><th>₹<?php echo number_format($total,2); ?></th></tr>
</table>

<br>

<p>Scan QR Code to Pay</p>
<img src="uploads/qr.png" width="200">

<br><br>

<a href="menu.php">
  <button>Back to Menu</button>
</a>

<a href="my_orders.php">
  <button>View My Orders</button>
</a>

</div>
</body>
</html>
