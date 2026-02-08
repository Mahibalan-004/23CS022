<?php
include "config/db.php";
include "admin_header.php";

/* STATUS UPDATE */
if (isset($_GET['ready'])) {
    mysqli_query($conn, "UPDATE orders SET status='Ready' WHERE id=" . $_GET['ready']);
}

if (isset($_GET['complete'])) {
    mysqli_query($conn, "UPDATE orders SET status='Completed' WHERE id=" . $_GET['complete']);
}

/* MARK AS DELIVERED */
if (isset($_GET['delivered'])) {
    mysqli_query(
        $conn,
        "UPDATE orders SET status='Delivered' WHERE id=" . $_GET['delivered']
    );
}

/* FETCH ORDERS */
$orders = mysqli_query($conn, "
SELECT o.*,u.name AS uname,u.id AS uid
FROM orders o, users u
WHERE o.user_id=u.id
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
        <table>
            <tr>
                <th>Order ID</th>
                <th>Status</th>
                <th>User Name</th>
                <th>User ID</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>

            <?php while ($o = mysqli_fetch_assoc($orders)) { ?>
                <tr>
                    <td>#<?php echo $o['id']; ?></td>
                    <td><?php echo $o['status']; ?></td>
                    <td><?php echo $o['uname']; ?></td>
                    <td><?php echo $o['uid']; ?></td>
                    <td>₹<?php echo $o['total']; ?></td>
                    <td>
    <a href="?details=<?php echo $o['id']; ?>">Details</a>

    <?php if ($o['status'] == "Preparing") { ?>
        | <a href="?ready=<?php echo $o['id']; ?>">Mark Ready</a>
    <?php } ?>

    <?php if ($o['status'] == "Ready") { ?>
        | <a href="?complete=<?php echo $o['id']; ?>">Mark Completed</a>
    <?php } ?>

    <?php if ($o['status'] == "Completed") { ?>
        | <a href="?delivered=<?php echo $o['id']; ?>">Mark Delivered</a>
    <?php } ?>
</td>

                </tr>
            <?php } ?>
        </table>

        <?php
        /* DETAILS VIEW */
        if (isset($_GET['details'])) {
            $oid = $_GET['details'];
            $ord = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT o.*,u.name,u.id uid 
    FROM orders o, users u 
    WHERE o.user_id=u.id AND o.id=$oid
  "));
            $items = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id=$oid");
        ?>
            <hr>
            <h3>Order #<?php echo $oid; ?></h3>
            <p><b>Status:</b> <?php echo $ord['status']; ?></p>
            <p><b>Placed on:</b> <?php echo date("F jS, Y h:i A", strtotime($ord['created_at'])); ?></p>

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
                <?php while ($i = mysqli_fetch_assoc($items)) { ?>
                    <tr>
                        <td><?php echo $i['item_name']; ?></td>
                        <td><?php echo $i['qty']; ?></td>
                        <td>₹<?php echo $i['price']; ?></td>
                        <td>₹<?php echo $i['qty'] * $i['price']; ?></td>
                    </tr>
                <?php } ?>
            </table>

            <a href="admin_orders.php">Close</a>
        <?php } ?>

    </div>
</body>

</html>