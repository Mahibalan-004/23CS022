<?php
include "config/db.php";
include "admin_header.php";

/* ADD ITEM */
if (isset($_POST['add_item'])) {
    $name   = $_POST['name'];
    $desc   = $_POST['description'];
    $cat    = $_POST['category'];
    $price  = $_POST['price'];
    $status = $_POST['status'];

    $img = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);

    mysqli_query($conn,
        "INSERT INTO items (name,description,price,image,category,status)
         VALUES ('$name','$desc','$price','$img','$cat','$status')"
    );
}

/* DELETE ITEM */
if (isset($_GET['delete'])) {
    mysqli_query($conn, "DELETE FROM items WHERE id=" . $_GET['delete']);
}

/* UPDATE ITEM */
if (isset($_POST['update_item'])) {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $desc   = $_POST['description'];
    $price  = $_POST['price'];
    $cat    = $_POST['category'];
    $status = $_POST['status'];

    mysqli_query($conn,
        "UPDATE items SET
            name='$name',
            description='$desc',
            price='$price',
            category='$cat',
            status='$status'
         WHERE id=$id"
    );
}

/* SEARCH */
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $items = mysqli_query(
        $conn,
        "SELECT * FROM items WHERE name LIKE '%$search%'"
    );
} else {
    $items = mysqli_query($conn, "SELECT * FROM items");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>
<div class="container">

<h2>Food Items</h2>

<form method="get">
    <input name="search" placeholder="Search item..." value="<?php echo $search; ?>">
</form>

<table>
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while ($i = mysqli_fetch_assoc($items)) { ?>
<tr>
    <td>
        <img src="uploads/<?php echo $i['image']; ?>" width="60">
    </td>

    <td>
        <b><?php echo $i['name']; ?></b><br>
        <small><?php echo $i['description']; ?></small>
    </td>

    <td><?php echo $i['category']; ?></td>
    <td>₹<?php echo $i['price']; ?></td>

    <td>
        <span class="badge" style="background:
        <?php echo ($i['status'] == "Available") ? "#27ae60" : "#e74c3c"; ?>">
        <?php echo $i['status']; ?>
        </span>
    </td>

    <td>
        <a href="?edit=<?php echo $i['id']; ?>">Edit</a> |
        <a href="?delete=<?php echo $i['id']; ?>" onclick="return confirm('Delete item?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

<?php
/* EDIT FORM */
if (isset($_GET['edit'])) {
    $e = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM items WHERE id=" . $_GET['edit'])
    );
?>
<hr>

<h2>Edit Item</h2>

<form method="post">
<input type="hidden" name="id" value="<?php echo $e['id']; ?>">

<input name="name" value="<?php echo $e['name']; ?>" required>

<textarea name="description" required><?php echo $e['description']; ?></textarea>

<input name="price" value="<?php echo $e['price']; ?>" required>

<select name="category">
    <option <?php if ($e['category']=="Main") echo "selected"; ?>>Main</option>
    <option <?php if ($e['category']=="Healthy") echo "selected"; ?>>Healthy</option>
    <option <?php if ($e['category']=="Drinks") echo "selected"; ?>>Drinks</option>
</select>

<select name="status">
    <option <?php if ($e['status']=="Available") echo "selected"; ?>>Available</option>
    <option <?php if ($e['status']=="Out of Stock") echo "selected"; ?>>Out of Stock</option>
</select>

<button name="update_item">Save Changes</button>
<a href="admin_items.php">Close</a>
</form>
<?php } ?>

<hr>

<h2>Add New Item</h2>

<form method="post" enctype="multipart/form-data">
<input name="name" placeholder="Item Name" required>

<textarea name="description" placeholder="Item Description" required></textarea>

<select name="category">
    <option value="Main">Main</option>
    <option value="Healthy">Healthy</option>
    <option value="Drinks">Drinks</option>
</select>

<input name="price" placeholder="Price" required>

<select name="status">
    <option value="Available">Available</option>
    <option value="Out of Stock">Out of Stock</option>
</select>

<input type="file" name="image" required>

<button name="add_item">Add Item</button>
</form>

</div>
</body>
</html>
