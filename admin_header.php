<?php
/* Admin authentication check */
if(!isset($_SESSION['admin'])){
  header("Location: admin_login.php");
}
?>

<div class="header">Canteen Admin Dashboard</div>

<div class="nav">
  <a href="admin_dashboard.php">Dashboard</a>
  <a href="admin_items.php">Menu Items</a>
  <a href="admin_orders.php">Orders</a>
  <a href="admin_users.php">Users</a>
  <a href="logout.php">Logout</a>
</div>
