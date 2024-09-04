<?php
$sql = "SELECT * FROM users WHERE isactive = '1'";
$qr = mysqli_query($conn, $sql);
?>
<html>
<div class="container">
    <a href="/nb_res/home.php?page=admin-userAdd" class="btn btn-success my-2">เพิ่มพนักงาน</a>
    <div class="mb-3">
        <center>
            <h3>จัดการพนักงาน</h3>
        </center>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">ชื่อผู้ใช้</th>
                <th scope="col">ชื่อ</th>
                <th scope="col">นามสกุล</th>
                <th scope="col">ตำแหน่ง</th>
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
                    <td><?= $index ?></td>
                    <td><?= $row["username"] ?></td>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["surname"] ?></td>
                    <td><?= $row["role"] ?></td>
                    <td><a href="/nb_res/home.php?page=admin-userEdit&id=<?= $row["id"] ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                    <td><button class="btn btn-danger btn-sm" id="userRemove" onclick="userRemove('<?= $row['name'] . ' ' . $row['surname'] ?>', <?= $row['id'] ?>)">ปลด</button></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<script src="./js/user.js"></script>

</html>