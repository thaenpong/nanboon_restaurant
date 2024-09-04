<html>

<body>

    <?php
    $sql = "SELECT * FROM desks WHERE id = {$_GET["id"]}";
    $qr = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($qr);
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>แก้ไขโต๊ะ</h2>
                <p>สถานะ : <?php echo ($rs["status"] == 2) ? 'ยกเลิกใช้งาน' :  'ใช้งาน'; ?></p>
                <form action="" method="post" id="deskEdit">
                    <div class="form-group">
                        <label for="label">หมายเลขโต๊ะ</label>
                        <input type="text" class="form-control" id="label" name="label" value="<?= $rs["label"] ?>">
                    </div>
                    <div class="form-group">
                        <label for="sheets">จำนวนที่นั่ง</label>
                        <input type="number" class="form-control" id="sheets" name="sheets" value="<?= $rs["sheets"] ?>">
                    </div>
                    <br>
                    <div>
                        <p><input type="checkbox" name="takeAway" id="takeAway" <?php echo ($rs["takeAway"] == 1) ? 'checked' : ''; ?>> โต๊ะนี้สำหรับซื้อกลับ</p>
                    </div>
                    <input type="hidden" name="id" value="<?= $rs["id"] ?>">
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary mt-3 mr-auto">บันทึก</button>
                        <?php if ($rs["status"] == 2) {
                        ?>
                            <button type="button" class="btn btn-success mt-3" onclick="deskActive('<?= $rs['label'] ?>', <?= $rs['id'] ?>)">ใช้งาน</button>
                        <?php
                        } elseif ($rs["status"] == 1) {
                        ?>
                            <button type="button" class="btn btn-danger mt-3" onclick="deskRemove('<?= $rs['label'] ?>', <?= $rs['id'] ?>)">ปลด</button>
                        <?php
                        } elseif ($rs["status"] == 0) { ?>
                            <button type="button" disabled class="btn btn-danger mt-3" onclick="deskRemove('<?= $rs['label'] ?>', <?= $rs['id'] ?>)"><?= $rs["label"] ?> กำลังใช้งาน</button>
                        <?php
                        } ?>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <script src="./js/desks.js"></script>
</body>

</html>