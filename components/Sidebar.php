<html lang="en">
<link rel="stylesheet" href="css/sidebar.css">

<?php if ($_SESSION["user"]["role"] == "manager" || $_SESSION["user"]["role"] == "employee") { ?>
    <ul class="sidebar-link">
        <li class="link">
            <a href="/nb_res/home.php" class="btn btn-side">ขาย</a>
        </li>
        <li class="link">
            <a href="/nb_res/home.php?page=billList" class="btn btn-side">เช็คบิล</a>
        </li>
        <li class="link collapsible">
            รายงาน
            <ul class="sub">
                <li class="link-sub ">
                    <a href="/nb_res/home.php?page=manage-sellingDay" class="btn btn-side">ยอดขายรายวัน</a>
                </li>
                <!-- <li class="link-sub">
                    <a href="/nb_res/home.php?page=manage-sellingMonth" class="btn btn-side">ยอดขายรายเดือน</a>
                </li> -->
                <li class="link-sub">
                    <a href="/nb_res/home.php?page=manage-sellingYear" class="btn btn-side">ยอดขายรายปี</a>
                </li>
                <li class="link-sub">
                    <a href="/nb_res/home.php?page=manage-sellingMenus" class="btn btn-side">เมนูขายดี</a>
                </li>

                <!-- Add other report links as needed -->
            </ul>
        </li>
        <li class="link collapsible">
            จัดการ
            <ul class="sub">
                <li class="link-sub">
                    <a href="/nb_res/home.php?page=admin-menus" class="btn btn-side">จัดการเมนู</a>
                </li>
                <li class="link-sub">
                    <a href="/nb_res/home.php?page=admin-desks" class="btn btn-side">จัดการโต๊ะ</a>
                </li>
            </ul>
        </li>
    </ul>
<?php } elseif ($_SESSION["user"]["role"] == "admin") { ?>
    <ul class="sidebar-link">

        <li class="link collapsible">
            <a href="/nb_res/home.php?page=admin-users" class="btn btn-side">จัดการพนักงาน</a>
        </li>
    </ul>

<?php } ?>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.querySelector(".sub");
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>

</html>