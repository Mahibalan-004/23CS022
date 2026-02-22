<?php
include "config/db.php";
include "user_header.php";


if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

/* ADD ITEM */
if(isset($_GET['add'])){
  $id = $_GET['add'];
  if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]++;
  }else{
    $_SESSION['cart'][$id]=1;
  }
  header("Location: cart.php");
}

/* REMOVE ITEM */
if(isset($_GET['remove'])){
  unset($_SESSION['cart'][$_GET['remove']]);
  header("Location: cart.php");
}

/* INCREASE QTY */
if(isset($_GET['plus'])){
  $_SESSION['cart'][$_GET['plus']]++;
  header("Location: cart.php");
}

/* DECREASE QTY */
if(isset($_GET['minus'])){
  if($_SESSION['cart'][$_GET['minus']] > 1){
    $_SESSION['cart'][$_GET['minus']]--;
  }
  header("Location: cart.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
<h2>Your Cart</h2>

<?php if(empty($_SESSION['cart'])){ ?>
<p>Your cart is empty</p>
<?php } else { ?>

<table>
<tr>
  <th>Item</th>
  <th>Qty</th>
  <th>Rate</th>
  <th>Total</th>
  <th>Action</th>
</tr>

<?php
$subtotal = 0;

foreach($_SESSION['cart'] as $id=>$qty){
  $item = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM items WHERE id=$id"));
  $total = $item['price'] * $qty;
  $subtotal += $total;
?>
<tr>
<td style="text-align:left;">
  <img src="uploads/<?php echo $item['image']; ?>" width="50" style="vertical-align:middle;">
  <?php echo $item['name']; ?>
</td>

<td>
  <a href="?minus=<?php echo $id; ?>">−</a>
  <?php echo $qty; ?>
  <a href="?plus=<?php echo $id; ?>">+</a>
</td>

<td>₹<?php echo $item['price']; ?></td>
<td>₹<?php echo $total; ?></td>

<td>
  <a href="?remove=<?php echo $id; ?>" onclick="return confirm('Remove item?')">Remove</a>
</td>
</tr>
<?php } ?>

</table>

<?php
$tax = $subtotal * 0.05;   // 5% tax
$grand = $subtotal + $tax;
?>

<hr>

<h3>Order Summary</h3>
<table>
<tr><td>Subtotal</td><td>₹<?php echo $subtotal; ?></td></tr>
<tr><td>Tax (5%)</td><td>₹<?php echo number_format($tax,2); ?></td></tr>
<tr><th>Total</th><th>₹<?php echo number_format($grand,2); ?></th></tr>
</table>

<br>
<a href="payment.php">
  <button style="background:#27ae60;">Proceed to Payment</button>
</a>

<?php } ?>

</div>
</body>
</html>
