<?php
include "koneksi.php";

$query = "SELECT * FROM produksi";
$result = mysqli_query($conn, $query);
?>

<h2>DATA PRODUKSI STO</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Shift</th>
        <th>Line</th>
        <th>Part Number</th>
        <th>Plan</th>
        <th>Actual</th>
        <th>Reject</th>
        <th>Downtime</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['tanggal']; ?></td>
        <td><?= $row['shift']; ?></td>
        <td><?= $row['line']; ?></td>
        <td><?= $row['part_number']; ?></td>
        <td><?= $row['qty_plan']; ?></td>
        <td><?= $row['qty_actual']; ?></td>
        <td><?= $row['reject']; ?></td>
        <td><?= $row['downtime']; ?></td>
    </tr>
    <?php } ?>
</table>