<?php
include "config/db.php";
include "user_header.php";

/* FETCH USER */
$user = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT * FROM users WHERE email='".$_SESSION['user']."'")
);

/* FETCH ORDERS */
$orders = mysqli_query($conn,"
  SELECT * FROM orders 
  WHERE user_id=".$user['id']." 
  ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
<h2>My Orders</h2>

<table>
<tr>
  <th>Order ID</th>
  <th>Placed On</th>
  <th>Total</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php
if(mysqli_num_rows($orders)==0){
  echo "<tr><td colspan='5'>No orders found</td></tr>";
}

while($o=mysqli_fetch_assoc($orders)){
?>
<tr>
  <td>#<?php echo $o['id']; ?></td>
  <td><?php echo date("d M Y h:i A",strtotime($o['created_at'])); ?></td>
  <td>₹<?php echo number_format($o['total'],2); ?></td>
  <td>
    <span class="badge"><?php echo $o['status']; ?></span>
  </td>
  <td>
    <a href="?details=<?php echo $o['id']; ?>">View</a>
  </td>
</tr>
<?php } ?>
</table>

<?php
/* ORDER DETAILS */
if(isset($_GET['details'])){
  $oid = $_GET['details'];
  $items = mysqli_query($conn,"
    SELECT * FROM order_items WHERE order_id=$oid
  ");
?>
<hr>

<h3>Order #<?php echo $oid; ?> Details</h3>

<table>
<tr>
  <th>Item</th>
  <th>Qty</th>
  <th>Price</th>
  <th>Total</th>
</tr>

<?php
$subtotal=0;
while($i=mysqli_fetch_assoc($items)){
  $line = $i['qty'] * $i['price'];
  $subtotal += $line;
?>
<tr>
  <td><?php echo $i['item_name']; ?></td>
  <td><?php echo $i['qty']; ?></td>
  <td>₹<?php echo $i['price']; ?></td>
  <td>₹<?php echo $line; ?></td>
</tr>
<?php } ?>

<tr>
  <th colspan="3">Subtotal</th>
  <th>₹<?php echo number_format($subtotal,2); ?></th>
</tr>

<tr>
  <th colspan="3">Tax (5%)</th>
  <th>₹<?php echo number_format($subtotal*0.05,2); ?></th>
</tr>

<tr>
  <th colspan="3">Total</th>
  <th>₹<?php echo number_format($subtotal*1.05,2); ?></th>
</tr>

</table>

<br>
<a href="my_orders.php">
  <button>Close</button>
</a>

<?php } ?>

</div>
</body>
</html>
