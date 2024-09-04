<style>
    .total-Price,
    .net-price {
        display: flex;
        justify-content: space-between;

    }

    .net-price {
        background-color: #f0f0f0;
    }

    #discountTag {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .listItems {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nameSpan {
        flex: 1.5;
        max-height: 44px;
        overflow: hidden;
    }

    .countSpan {
        flex: 2;
    }

    span {
        margin: 0 10px;
    }

    button {
        padding: 8px 12px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
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

    .pay-area {
        position: relative;
    }
</style>

<div class="container">
    <div>
        <center>
            <h3>รายการเมนู</h3>
        </center>
    </div>
    <div id="billItems">

    </div>
    <div class="pay-area">
        <div class="total-Price">
            <span hidden="true" id="spanTotal">
                รวม :
            </span>
            <span id="totalPrice">

            </span>
        </div>
        <div id="discountTag" hidden="true" class="mb-3">
            <span>
                ส่วนลด :
            </span>
            <span hidden="true" id="discount">

            </span>
        </div>
        <div id="net-price" class="net-price">
            <span hidden="true" id="spanNetPrice">
                ราคาสุทธิ :
            </span>
            <span id="netPrice"></span>
        </div>
        <div id="print" class="mt-2">

        </div>
        <div id="pay" class="mt-2">

        </div>
        <div id="clear" class="mt-2">

        </div>
    </div>
</div>