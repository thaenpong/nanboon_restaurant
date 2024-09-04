<html>

<style>
    .menuList {
        position: relative;
        height: 80vh;
    }

    .inner {
        position: absolute;
        bottom: -70px;
        width: 93%;
    }

    #menuList {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    span {
        margin: 0 10px;
    }

    button {
        padding: 8px 12px;
        background-color: #70998b;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        border-color: #70998b;
    }

    button:hover {
        background-color: #45a049;
    }

    .btn-success {
        background-color: #70998b;
    }

    button:hover {
        background-color: #45a049;
    }

    #menuItems {
        margin-top: 10px;
    }

    .item-container {
        background-color: #f0f0f0;
        padding-top: 1px;
        padding-bottom: 1px;
        display: flex;
        justify-content: left;
        align-items: center;
        margin-bottom: 5px;
        border-radius: 5px;

    }

    .is1 {
        color: #45a049;
    }

    .is0 {
        color: #7B241C;
    }


    .nameSpan {
        flex: 1.5;
        max-height: 44px;
        overflow: hidden;
    }

    .countSpan {
        flex: 2;
    }
</style>
<div class="billingItems">
    <form action="" method="post" id="menuForm">
        <div id="menuContainer" class="menuList container">
            <center>
                <h3>รายการเมนู</h3>
            </center>

            <ul id="menuList"></ul>

            <!-- Hidden input fields for id and count -->
            <input type="hidden" name="menuItems" id="menuItems" value="">
            <div class="inner">
                <input type="number" class="form-control" name="price" id="price" style="text-align: right" value="0" disabled>
                <button class="btn btn-success mt-2" type="button" onclick="submitForm()" id="submit" style="width: 100%; ">บันทึก</button>
            </div>
        </div>
    </form>
</div>


</html>