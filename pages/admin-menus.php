<?php
$sql = "SELECT * FROM menus  ORDER BY `status` DESC";
$qr = mysqli_query($conn, $sql);
?>
<html>
<style>
    .btn-warning {
        background-color: #faae58;
        border-color: #faae58;
    }
</style>
<div class="container">
    <a href="/nb_res/home.php?page=admin-menuAdd" class="btn btn-success my-2">เพิ่มเมนู</a>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">รูป</th>
                <th scope="col">ชื่อ</th>
                <th scope="col">รายละเอียด</th>
                <th scope="col">สถานะ</th>
                <th scope="col">ราคาเต็ม</th>
                <th scope="col">ส่วนลด</th>
                <th scope="col">ราคา</th>
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
                    <td><img src="./images/<?php echo $row["image"] == null ? "NoImage.jpg" : $row["image"] ?>" alt="" width="50px"></td>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["detail"] ?></td>
                    <td><span style="color:<?= $row["status"] == 0 ? 'red' : 'green' ?>">
                            <?= $row["status"] == 0 ? "ปลด" : "ปกติ" ?></td>
                    </span>
                    <td><?= $row["price"] ?></td>
                    <td><?= $row["discount"] ?>%</td>
                    <td><?= $row["price"] - ($row["price"] * $row["discount"] / 100) ?></td>
                    <td><a href="/nb_res/home.php?page=admin-menuEdit&id=<?= $row["id"] ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                    <td>
                        <?= $row["status"] == 0 ? '<button class="btn btn-success btn-sm" id="active" onclick="userActive(\'' . $row['name'] . '\', ' . $row['id'] . ')">เปิดใช้</button>' : '<button class="btn btn-danger btn-sm" id="userRemove" onclick="userRemove(\'' . $row['name'] . '\', ' . $row['id'] . ')">ปลด</button>' ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script src="./js/menus.js"></script>

</html>