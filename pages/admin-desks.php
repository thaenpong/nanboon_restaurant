<?php
$sql = "SELECT * FROM desks";
$qr = mysqli_query($conn, $sql);
?>
<html>
<a href="/nb_res/home.php?page=admin-deskAdd" class="btn btn-success" style="margin: 10px;">เพิ่มโต๊ะใหม่</a>
<div class="mb-3">
    <center>
        <h3>จัดการโต๊ะ</h3>
    </center>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">หมายเลข</th>
            <th scope="col">จำนวนที่นั่ง</th>
            <th scope="col">สถานะ</th>
            <th scope="col">จัดการ</th>
            <th scope="col">ปลด</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        while ($row = mysqli_fetch_assoc($qr)) {
            $index++;
        ?>
            <tr>
                <td scope="row"><?= $index ?></td>
                <td><?= $row["label"] ?></td>
                <td><?= $row["sheets"] ?></td>
                <td><?php if ($row["status"] == 2) : ?><span class="text-danger">ยกเลิก</span><?php else : ?><span class="success">ใช้งาน</span><?php endif; ?></td>
                <td><a href="/nb_res/home.php?page=admin-deskEdit&id=<?= $row["id"] ?>" class="btn btn-warning">แก้ไข</a></td>
                <td>
                    <?php if ($row['status'] == 1) : ?>
                        <button class="btn btn-danger" id="deskRemove" onclick="deskRemove('<?= $row['label'] ?>', <?= $row['id'] ?>)">ปลด</button>
                    <?php elseif ($row['status'] == 2) : ?>
                        <button class="btn btn-primary" id="deskRemove" onclick="deskActive('<?= $row['label'] ?>', <?= $row['id'] ?>)">ใช้งาน</button>
                    <?php elseif ($row['status'] == 0) : ?>

                        <button class="btn btn-danger" disabled id="deskRemove" onclick="deskRemove('<?= $row['label'] ?>', <?= $row['id'] ?>)"><?= $row["label"] ?>ถูกใช้งาน</button><?php endif; ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script src="./js/desks.js"></script>

</html>