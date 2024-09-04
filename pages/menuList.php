<?php
include("./functions/get-categories.php");

?>
<html>

<head>
    <link rel="stylesheet" href="./css/menulist.css">

</head>

<body>

    <?php

    $sql = "SELECT * FROM `menus` WHERE status = 1";
    $result = mysqli_query($conn, $sql);

    ?>

    <div class="container mt-2">
        <div class="foodList">
            <div class="category">
                <ul id="categoryList">
                    <li class="categoryItem list-group-item">
                        <button type="button" class="btn btn-primary" onclick="filterMenuList('0')" data-category="0">เมนูขายดี</button>
                    </li>
                    <?php
                    while ($row = mysqli_fetch_assoc($foodcategory)) {
                    ?>
                        <li class="categoryItem list-group-item">
                            <button type="button" data-category="<?= $row['id'] ?>" onclick="filterMenuList('<?= $row['id'] ?>')" class="btn btn-primary"><?= $row['name'] ?></button>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="grid-main" id="menu-list">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="card cardMenu" data-category="<?= $row['categorieId'] ?>" data-id="<?= $row['id'] ?>">
                        <img src="./images/<?php echo $row["image"] == null ? "NoImage.jpg" : $row["image"] ?>" alt="" class="card-img-top" style="width: 100%;">
                        <div class="card-body">
                            <h3 class="card-title"><?= $row['name'] ?></h3>
                            <?php if ($row['discount'] != 0) : ?>
                                <p class="card-text">
                                    <span style="text-decoration: line-through;"><?= $row['price'] ?> บาท</span>
                                    <br>
                                    <span class="text-success">(ลด <?= $row['discount'] ?>%)</span>
                                    <br>
                                    <span><?= $row['price'] - ($row['price'] * $row['discount'] / 100) ?>บาท</span>
                                </p>
                            <?php else : ?>
                                <p class="card-text"><?= $row['price'] ?> บาท</p>
                            <?php endif; ?>

                            <button class="btn btn-primary add" key="<?= $row["id"] ?>">เลือก</button>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>


    <script src="./js/menuList.js"></script>
</body>

</html>