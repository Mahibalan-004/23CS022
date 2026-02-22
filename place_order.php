<?php
include "config/db.php";
include "user_header.php";

/* LOGIN CHECK */
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}

/* CART CHECK */
if (empty($_SESSION['cart'])) {
  header("Location: menu.php");
  exit();
}

/* OPTIONAL: PAYMENT CONFIRM CHECK */
if (!isset($_SESSION['payment_done'])) {
  header("Location: cart.php");
  exit();
}

/* FETCH USER */
$user = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM users WHERE email='" . $_SESSION['user'] . "'")
);

$subtotal = 0;

/* CALCULATE SUBTOTAL */
foreach ($_SESSION['cart'] as $id => $qty) {
  $item = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM items WHERE id=$id")
  );
  $subtotal += $item['price'] * $qty;
}

/* TAX & TOTAL */
$tax = $subtotal * 0.05;
$total = $subtotal + $tax;

/* CREATE ORDER (Pending for admin approval) */
mysqli_query($conn, "
  INSERT INTO orders(user_id,total,status)
  VALUES(" . $user['id'] . ",$total,'Pending')
");

$order_id = mysqli_insert_id($conn);

/* INSERT ORDER ITEMS */
foreach ($_SESSION['cart'] as $id => $qty) {
  $item = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM items WHERE id=$id")
  );

  mysqli_query($conn, "
    INSERT INTO order_items(order_id,item_name,qty,price)
    VALUES(
      $order_id,
      '" . $item['name'] . "',
      $qty,
      " . $item['price'] . "
    )
  ");
}

/* CLEAR CART + PAYMENT FLAG */
unset($_SESSION['cart']);
unset($_SESSION['payment_done']);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

<h2>✅ Order Placed Successfully</h2>

<p><b>Order ID:</b> #<?php echo $order_id; ?></p>
<p>Status: <b style="color:#e67e22;">Waiting for Admin Approval</b></p>

<table>
<tr>
  <td>Subtotal</td>
  <td>₹<?php echo number_format($subtotal, 2); ?></td>
</tr>
<tr>
  <td>Tax (5%)</td>
  <td>₹<?php echo number_format($tax, 2); ?></td>
</tr>
<tr>
  <th>Total Paid</th>
  <th>₹<?php echo number_format($total, 2); ?></th>
</tr>
</table>

<br>

<a href="index.php">
  <button>Back to Menu</button>
</a>

<a href="my_orders.php">
  <button style="background:#27ae60;">View My Orders</button>
</a>

</div>
</body>
</html>