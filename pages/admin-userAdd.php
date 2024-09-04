<html>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>เพิ่มผู้ใช้ใหม่</h2>
                <form action="" method="post" id="userAdd">
                    <div class="form-group mb-2">
                        <label for="name">ชื่อ</label>
                        <input type="text" class="form-control" id="name" name="name"">
                    </div>
                    <div class=" form-group mb-2">
                        <label for="surname">นามสกุล</label>
                        <input type="text" class="form-control" id="surname" name="surname"">
                    </div>
                    <div class=" form-group mb-2">
                        <label for="username">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" id="username" name="username" ">
                    </div>
                    <div class=" form-group mb-2">
                        <label for="password">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" name="password" ">
                    </div>
                    <div class=" form-group mb-2">
                        <label for="role">ระดับ</label>
                        <select class="form-control" id="role" name="role">
                            <option value="employee">พนักงาน</option>
                            <option value="manager">ผู้จัดการ</option>
                            <option value="admin">เจ้าของร้าน</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3  btn-block">บันทึก</button>
                </form>
            </div>
        </div>
    </div>

    <script src="./js/user.js"></script>
</body>

</html>