<?php
include "config/db.php";
include "admin_header.php";
/* STATUS TOGGLE */
if(isset($_GET['toggle'])){
  $u=$_GET['toggle'];
  $s=$_GET['status']=="Active" ? "Inactive" : "Active";
  mysqli_query($conn,"UPDATE users SET status='$s' WHERE id=$u");
}

/* SEARCH */
$key="";
if(isset($_GET['search'])){
  $key=$_GET['search'];
  $users=mysqli_query($conn,"
    SELECT * FROM users 
    WHERE role='user' 
    AND (name LIKE '%$key%' OR email LIKE '%$key%')
    ORDER BY id DESC
  ");
}else{
  $users=mysqli_query($conn,"SELECT * FROM users WHERE role='user' ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

<form method="get">
  <input name="search" placeholder="Search by name or email" value="<?php echo $key; ?>">
</form>

<table>
<tr>
  <th>Name</th>
  <th>Email</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php while($u=mysqli_fetch_assoc($users)){ ?>
<tr>
  <td><?php echo $u['name']; ?></td>
  <td><?php echo $u['email']; ?></td>
  <td>
    <span class="badge"><?php echo $u['status']; ?></span>
  </td>
  <td>
    <a href="?toggle=<?php echo $u['id']; ?>&status=<?php echo $u['status']; ?>">
      <?php echo $u['status']=="Active" ? "Deactivate" : "Activate"; ?>
    </a>
  </td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
