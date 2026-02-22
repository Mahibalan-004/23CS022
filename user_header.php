<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$isLoggedIn = isset($_SESSION['user']);
?>

<div class="header">
  🍽️ College Canteen
</div>

<div class="nav">

  <a href="index.php">Menu</a>

  <?php if ($isLoggedIn) { ?>
    <a href="my_orders.php">My Orders</a>
    <a href="cart.php">Cart</a>
  <?php } ?>

  <span style="float:right;color:#fff;">

    <?php if ($isLoggedIn) { ?>
      Welcome, <?php echo $_SESSION['user']; ?> |
      <a href="logout.php" style="color:#f1c40f;">Logout</a>
    <?php } else { ?>
      <a href="login.php" style="color:#f1c40f;">Login</a>
      |
      <a href="register.php" style="color:#f1c40f;">Register</a>
    <?php } ?>

  </span>

</div>