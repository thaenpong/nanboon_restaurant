<html>
<div class="container mt-5">
    <div style="display: flex; justify-content: flex-end;" id="btn-print">

    </div>
    <center>
        <h2>เมนูขายดี</h2>
    </center>
    <div class="form-group mb-3">
        <label for="date">เลือกวันที่: </label>
        <input type="date" class="form-control" id="from-date" name="from-date">
    </div>
    <div class="form-group mb-3">
        <label for="date">ถึงวันที่วันที่: </label>
        <input type="date" class="form-control" id="to-date" name="to-date">
    </div>
    <div>
        <p>ยอดขาย : <span id="totalPrice"> </span> </p>
        <p>ส่วนลด : <span id="totalDiscount"> </span> </p>
        <p>รวมทั้งหมด : <span id="total"> </span> </p>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อเมนู</th>
                <th>จำนวน</th>
                <th>ยอดขาย</th>
                <th>ส่วนลด</th>
                <th>ยอดขายสุทธิ</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>
</div>
<script src="./js/selling.js"></script>

</html>