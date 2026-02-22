<?php
include "config/db.php";
include "user_header.php";

/* START SESSION (required to check login) */
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/* CATEGORY FILTER */
$cat = "All";
if (isset($_GET['cat'])) {
  $cat = $_GET['cat'];
}

/* QUERY BASED ON CATEGORY */
if ($cat == "All") {
  $sql = "SELECT * FROM items 
          WHERE status='Available'";
} else {
  $sql = "SELECT * FROM items 
          WHERE category='$cat' 
          AND status='Available'";
}

$items = mysqli_query($conn, $sql);

/* CHECK USER LOGIN */
$isLoggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>
  <div class="container">

    <h2>Food Menu</h2>

    <!-- CATEGORY TABS -->
    <div style="margin-bottom:15px;">
      <a href="index.php?cat=All" class="badge">All</a>
      <a href="index.php?cat=Main" class="badge">Main</a>
      <a href="index.php?cat=Healthy" class="badge">Healthy</a>
      <a href="index.php?cat=Drinks" class="badge">Drinks</a>
    </div>

    <table>
      <tr>
        <th>Photo</th>
        <th>Item</th>
        <th>Price</th>
        <th>Action</th>
      </tr>

      <?php
      if (mysqli_num_rows($items) == 0) {
        echo "<tr><td colspan='4'>No items found</td></tr>";
      }

      while ($i = mysqli_fetch_assoc($items)) {
      ?>
        <tr>
          <td>
            <img src="uploads/<?php echo $i['image']; ?>" width="80">
          </td>

          <td>
            <b><?php echo $i['name']; ?></b><br>
            <small><?php echo $i['description']; ?></small>
          </td>

          <td>₹<?php echo $i['price']; ?></td>

          <td>
            <?php if ($isLoggedIn) { ?>
              <a href="cart.php?add=<?php echo $i['id']; ?>">
                <button>Add to Cart</button>
              </a>
            <?php } else { ?>
              <a href="login.php">
                <button style="background:#e67e22;">Login to Buy</button>
              </a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>

    </table>

  </div>
</body>

</html>