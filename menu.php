<?php
include "config/db.php";
include "user_header.php";

/* CATEGORY FILTER */
$cat = "All";
if(isset($_GET['cat'])){
  $cat = $_GET['cat'];
}

/* QUERY BASED ON CATEGORY */
if($cat == "All"){
  $sql = "SELECT * FROM items 
          WHERE is_active=1 AND status='Available'";
}else{
  $sql = "SELECT * FROM items 
          WHERE category='$cat' 
          AND is_active=1 
          AND status='Available'";
}

$items = mysqli_query($conn,$sql);
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
  <a href="menu.php?cat=All" class="badge">All</a>
  <a href="menu.php?cat=Main" class="badge">Main</a>
  <a href="menu.php?cat=Healthy" class="badge">Healthy</a>
  <a href="menu.php?cat=Drinks" class="badge">Drinks</a>
</div>

<!-- FOOD ITEMS GRID -->
<table>
<tr>
  <th>Photo</th>
  <th>Item</th>
  <th>Price</th>
  <th>Action</th>
</tr>

<?php
if(mysqli_num_rows($items)==0){
  echo "<tr><td colspan='4'>No items found</td></tr>";
}

while($i=mysqli_fetch_assoc($items)){
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
<a href="cart.php?add=<?php echo $i['id']; ?>">
      <button>Add to Cart</button>
    </a>
  </td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
