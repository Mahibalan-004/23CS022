<?php
/* User authentication check */
if(!isset($_SESSION['user'])){
  header("Location: index.php");
}
?>

<div class="header">
  🍽️ College Canteen
</div>

<div class="nav">
  <a href="menu.php">Menu</a>
  <a href="my_orders.php">My Orders</a>
  <a href="cart.php">Cart</a>

  <span style="float:right;color:#fff;">
    Welcome, <?php echo $_SESSION['user']; ?> |
    <a href="logout.php" style="color:#f1c40f;">Logout</a>
  </span>
</div>
