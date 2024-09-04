<?php
$sql = "SELECT * FROM orders WHERE status = '2' ORDER BY id DESC";
$qr = mysqli_query($conn, $sql);
?>
<html>
<table>
    <thead>
        <tr>
            <th>ลำดับ</th>
            <th>หมายเลข</th>
            <th>จำนวนที่นั่ง</th>
            <th>จัดการ</th>
            <th>ปลด</th>
        </tr>

    </thead>
    <tbody>
        <?php
        $index = 0;
        while ($row = mysqli_fetch_assoc($qr)) {
            $index++;
        ?>
            <tr>
                <td><?= $index ?></td>
                <td><?= $row["id"] ?></td>
                <td><?= $row["createdAt"] ?></td>

                <td><a href="/nb_res/home.php?page=manage-orderDetail&id=<?= $row["id"] ?>">รายละเอียด</a></td>

            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script src="./js/desks.js"></script>

</html>