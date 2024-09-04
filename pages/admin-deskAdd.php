<html>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>เพิ่มโต๊ะ</h2>
                <form action="" method="post" id="deskAdd">
                    <div class="form-group">
                        <label for="label">หมายเลขโต๊ะ</label>
                        <input type="text" class="form-control" id="label" name="label">
                    </div>
                    <div class="form-group">
                        <label for="sheets">จำนวนที่นั่ง</label>
                        <input type="number" class="form-control" id="sheets" name="sheets">
                    </div>
                    <br>
                    <div>
                        <p><input type="checkbox" name="takeAway" id="takeAway"> โต๊ะนี้สำหรับซื้อกลับ</p>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">บันทึก</button>
                </form>
            </div>
        </div>
    </div>


    <script src="./js/desks.js"></script>
</body>

</html>