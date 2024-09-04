 <html>

 <body>
     <?php
        $sql = "SELECT * FROM menus";
        $qr = mysqli_query($conn, $sql);
        $rs = mysqli_fetch_assoc($qr);

        $sqlcat = "SELECT * FROM categories";
        $qrcat = mysqli_query($conn, $sqlcat);
        ?>
     <div class="container mt-5">
         <div class="row justify-content-center">
             <div class="col-md-6">
                 <h2>เพิ่มเมนูใหม่</h2>
                 <form action="" method="post" id="menuAdd" enctype="multipart/form-data">
                     <div class="form-group mb-2">
                         <label for="name">ชื่อ</label>
                         <input type="text" class="form-control" name="name">
                     </div>
                     <div class="form-group mb-2">
                         <label for="detail">รายระเอียด</label>
                         <textarea class="form-control" name="detail" id="detail" cols="30" rows="5"></textarea>
                     </div>
                     <div class="form-group mb-2">
                         <label for="price">ราคา</label>
                         <input type="number" class="form-control" name="price">
                     </div>
                     <div class="form-group mb-2">
                         <label for="categorieId">หมวด</label>
                         <select class="form-control" name="categorieId" id="categorieId">
                             <?php
                                while ($row = mysqli_fetch_assoc($qrcat)) {
                                ?>
                                 <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                             <?php
                                }
                                ?>
                         </select>
                     </div>
                     <div class="form-group mb-2">
                         <label for="image">รูปภาพ</label>
                         <input type="file" class="form-control-file" name="image" id="image" accept="image/*">
                     </div>
                     <button type="submit" class="btn btn-primary mt-3 btn-block">บันทึก</button>
                 </form>
             </div>
         </div>
     </div>

     <script src="./js/menus.js"></script>
 </body>

 </html>