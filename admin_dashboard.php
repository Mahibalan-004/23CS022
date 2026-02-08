<?php
include "config/db.php";
include "admin_header.php";

/* KPIs */
$totalRevenue = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT SUM(total) AS rev FROM orders"
))['rev'];

$totalOrders = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT id FROM orders"
));

$activeUsers = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT id FROM users WHERE role='user'"
));

$activeItems = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT id FROM items"
));

$recentOrders = mysqli_query(
    $conn,
    "SELECT o.id,o.total,o.status,u.name 
FROM orders o, users u 
WHERE o.user_id=u.id 
ORDER BY o.id DESC LIMIT 5"
);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Overview</h2>
        <div class="card-grid">
            <div class="card">
                <h3>Total Revenue</h3>
                <h1>₹<?php echo $totalRevenue ? $totalRevenue : 0; ?></h1>
            </div>
            <div class="card">
                <h3>Total Orders</h3>
                <h1><?php echo $totalOrders; ?></h1>
            </div>
            <div class="card">
                <h3>Active Users</h3>
                <h1><?php echo $activeUsers; ?></h1>
            </div>
            <div class="card">
                <h3>Active Menu Items</h3>
                <h1><?php echo $activeItems; ?></h1>
            </div>
        </div>
        <h3 style="margin-top:30px;">Recent Orders</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
            <?php while ($o = mysqli_fetch_assoc($recentOrders)) { ?>
                <tr>
                    <td>#<?php echo $o['id']; ?></td>
                    <td><?php echo $o['name']; ?></td>
                    <td>₹<?php echo $o['total']; ?></td>
                    <td><span class="badge"><?php echo $o['status']; ?></span></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>