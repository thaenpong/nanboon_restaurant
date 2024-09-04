<html>

<body>

    <?php
    $sql = "SELECT * FROM users WHERE id = {$_GET["id"]}";
    $qr = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($qr);
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>แก้ไขชื่อผู้ใช้</h2>
                <form action="" method="post" id="userEdit">
                    <div class="form-group mb-2">
                        <label for="name">ชื่อ</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $rs["name"] ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="surname">นามสกุล</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="<?= $rs["surname"] ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="username">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $rs["username"] ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="password">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?= $rs["password"] ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="role">ระดับ</label>
                        <select class="form-control" id="role" name="role">
                            <option value="employee" <?= $rs["role"] == "employee" ? 'selected' : '' ?>>พนักงาน</option>
                            <option value="manager" <?= $rs["role"] == "manager" ? 'selected' : '' ?>>ผู้จัดการ</option>
                            <option value="admin" <?= $rs["role"] == "admin" ? 'selected' : '' ?>>เจ้าของร้าน</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?= $rs["id"] ?>">
                    <button type="submit" class="btn btn-primary mt-3  btn-block">บันทึก</button>
                </form>
            </div>
        </div>
    </div>

    <script src="./js/user.js"></script>
</body>

</html>