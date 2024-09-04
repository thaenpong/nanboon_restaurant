<html>

<div class="container mt-5">
    <div style="display: flex; justify-content: flex-end;" id="btn-print">

    </div>
    <center>
        <h2>ยอดขายรายเดือน</h2>
    </center>
    <p>เลือกเดือน : <select class="form-control" name="month" id="month">
            <option value="01">มกราคม</option>
            <option value="02">กุมภาพันธ์</option>
            <option value="03">มีนาคม</option>
            <option value="04">เมษายน</option>
            <option value="05">พฤษภาคม</option>
            <option value="06">มิถุนายน</option>
            <option value="07">กรกฎาคม</option>
            <option value="08">สิงหาคม</option>
            <option value="09">กันยายน</option>
            <option value="10">ตุลาคม</option>
            <option value="11">พฤศจิกายน</option>
            <option value="12">ธันวาคม</option>
        </select>
    </p>

    <div>
        <p>ออเดอร์ : <span id="totalOrders"> </span> </p>
        <p>ยอดขาย : <span id="totalPrice"> </span> </p>
        <p>ส่วนลด : <span id="totalDiscount"> </span> </p>
        <p>รวมทั้งหมด : <span id="total"> </span> </p>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>ลำดับ</th>
                <th>รหัส</th>
                <th>วันที่</th>
                <th>ยอดขาย</th>
                <th>รายละเอียด</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>
</div>
<script src="./js/selling.js"></script>

</html>