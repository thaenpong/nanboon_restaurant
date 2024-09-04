<html>
<div class="container mt-5">
    <div style="display: flex; justify-content: flex-end;" id="btn-print">

    </div>
    <center>
        <h2>ยอดขายรายปี</h2>
    </center>
    <!-- <p>เลือกปี : <select class="form-control" name="year" id="year"> -->
    <?php
    echo '<label>เลือกปี :</label><br><select class="form-control" name="year" id="year">';
    for ($year = date('Y'); $year >= 1900; $year--) {
        $selected = ($year == 2010) ? ' selected' : '';
        echo '<option value="' . $year . '"' . $selected . '>' . $year . '</option>';
    }
    echo '</select>';
    ?>

    </select>
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