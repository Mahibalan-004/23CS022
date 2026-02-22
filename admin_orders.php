<?php
include "config/db.php";
include "admin_header.php";

/* STATUS FLOW */

/* APPROVE ORDER */
if(isset($_GET['approve'])){
    mysqli_query($conn,"UPDATE orders SET status='Preparing' WHERE id=".$_GET['approve']);
    header("Location: admin_orders.php");
}

/* READY */
if(isset($_GET['ready'])){
    mysqli_query($conn,"UPDATE orders SET status='Ready' WHERE id=".$_GET['ready']);
    header("Location: admin_orders.php");
}

/* COMPLETED */
if(isset($_GET['complete'])){
    mysqli_query($conn,"UPDATE orders SET status='Completed' WHERE id=".$_GET['complete']);
    header("Location: admin_orders.php");
}

/* DELIVERED */
if(isset($_GET['delivered'])){
    mysqli_query($conn,"UPDATE orders SET status='Delivered' WHERE id=".$_GET['delivered']);
    header("Location: admin_orders.php");
}

/* FETCH ORDERS */
$orders = mysqli_query($conn,"
SELECT o.*,u.name AS uname,u.id AS uid
FROM orders o
JOIN users u ON o.user_id=u.id
ORDER BY o.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>
<div class="container">

<h2>All Orders</h2>

<table>
<tr>
<th>Order ID</th>
<th>Status</th>
<th>User(with ID)</th>
<th>Total</th>
<!-- <th>Payment</th> -->
<th>Actions</th>
</tr>

<?php while($o=mysqli_fetch_assoc($orders)){ ?>

<tr>
<td>#<?php echo $o['id']; ?></td>

<td>
<span class="badge"
style="background:
<?php
if($o['status']=="Pending") echo '#f39c12';
else if($o['status']=="Preparing") echo '#3498db';
else if($o['status']=="Ready") echo '#8e44ad';
else if($o['status']=="Completed") echo '#2ecc71';
else if($o['status']=="Delivered") echo '#27ae60';
?>">
<?php echo $o['status']; ?>
</span>
</td>

<td><?php echo $o['uname']; ?> (<?php echo $o['uid']; ?>)</td>

<td>₹<?php echo $o['total']; ?></td>

<!-- <td>
<?php echo isset($o['payment_status']) ? $o['payment_status'] : "Paid"; ?>
</td> -->

<td>

<a href="?details=<?php echo $o['id']; ?>">Details</a>

<?php if($o['status']=="Pending"){ ?>
 | <a href="?approve=<?php echo $o['id']; ?>">Approve</a>
<?php } ?>

<?php if($o['status']=="Preparing"){ ?>
 | <a href="?ready=<?php echo $o['id']; ?>">Mark Ready</a>
<?php } ?>

<?php if($o['status']=="Ready"){ ?>
 | <a href="?complete=<?php echo $o['id']; ?>">Mark Completed</a>
<?php } ?>

<?php if($o['status']=="Completed"){ ?>
 | <a href="?delivered=<?php echo $o['id']; ?>">Mark Delivered</a>
<?php } ?>

</td>
</tr>

<?php } ?>
</table>

<?php
/* ORDER DETAILS VIEW */
if(isset($_GET['details'])){
$oid=$_GET['details'];

$ord=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT o.*,u.name,u.id uid 
FROM orders o
JOIN users u ON o.user_id=u.id
WHERE o.id=$oid
"));

$items=mysqli_query($conn,"SELECT * FROM order_items WHERE order_id=$oid");
?>

<hr>

<h3>Order #<?php echo $oid; ?></h3>
<p><b>Status:</b> <?php echo $ord['status']; ?></p>
<p><b>Placed on:</b> <?php echo date("F jS, Y h:i A",strtotime($ord['created_at'])); ?></p>

<h3>Customer Details</h3>
<p><b>Name:</b> <?php echo $ord['name']; ?></p>
<p><b>User ID:</b> <?php echo $ord['uid']; ?></p>

<h3>Order Items</h3>
<table>
<tr>
<th>Item</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php while($i=mysqli_fetch_assoc($items)){ ?>
<tr>
<td><?php echo $i['item_name']; ?></td>
<td><?php echo $i['qty']; ?></td>
<td>₹<?php echo $i['price']; ?></td>
<td>₹<?php echo $i['qty']*$i['price']; ?></td>
</tr>
<?php } ?>
</table>

<br>
<a href="admin_orders.php">
<button>Close</button>
</a>

<?php } ?>

</div>
</body>
</html>