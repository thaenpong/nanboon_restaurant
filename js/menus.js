$(document).ready(function () {
  $("#menuAdd").on("submit", function (e) {
    e.preventDefault();

    // Show SweetAlert before sending the AJAX request
    Swal.fire({
      title: "บันทึกข้อมูล?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ตกลง",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        // Send AJAX request to editUser.php
        var formData = new FormData(this);

        $.ajax({
          type: "POST",
          url: "functions/post-createMenu.php",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            // Parse the JSON response
            var responseData = JSON.parse(response);

            // Check if the message is equal to "success"
            if (responseData.message === "success") {
              // Show SweetAlert for success
              Swal.fire({
                title: "สำเร็จ!",
                text: "บันทึกข้อมูลสำเร็จ",
                icon: "success",
              }).then(() => {
                history.back();
              });
            } else {
              // Show SweetAlert for other cases (error, etc.)
              Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
                icon: "error",
              });
            }
          },
          error: function () {
            // Show SweetAlert if an error occurs during the AJAX request
            Swal.fire({
              title: "ไม่สำเร็จ!",
              text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
              icon: "error",
            });
          },
        });
      }
    });
  });

  $("#menuEdit").on("submit", function (e) {
    e.preventDefault();

    // Show SweetAlert before sending the AJAX request
    Swal.fire({
      title: "บันทึกข้อมูล?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ตกลง",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        // Send AJAX request to editUser.php
        var formData = new FormData(this);

        $.ajax({
          type: "POST",
          url: "functions/patch-updateMenu.php",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            // Parse the JSON response
            var responseData = JSON.parse(response);

            // Check if the message is equal to "success"
            if (responseData.message === "success") {
              // Show SweetAlert for success
              Swal.fire({
                title: "สำเร็จ!",
                text: "บันทึกข้อมูลสำเร็จ",
                icon: "success",
              }).then(() => {
                history.back();
              });
            } else {
              // Show SweetAlert for other cases (error, etc.)
              Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
                icon: "error",
              });
            }
          },
          error: function () {
            // Show SweetAlert if an error occurs during the AJAX request
            Swal.fire({
              title: "ไม่สำเร็จ!",
              text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
              icon: "error",
            });
          },
        });
      }
    });
  });

  // Calculate net price when the page is loaded
  calculateNetPrice();

  // Calculate net price when discount input changes
  $("#discount").on("input", function () {
    calculateNetPrice();
  });
});

function userRemove(name, id) {
  Swal.fire({
    title: "ลบข้อมูล?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ตกลง",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      // Send AJAX request to editUser.php
      $.ajax({
        type: "PATCH",
        url: "functions/patch-removeMenu.php",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        data: `id=${id}`, // Serialize form data
        success: function (response) {
          // Parse the JSON response
          var responseData = JSON.parse(response);

          // Check if the message is equal to "success"
          if (responseData.message === "success") {
            // Show SweetAlert for success
            Swal.fire({
              title: "สำเร็จ!",
              text: "บันทึกข้อมูลสำเร็จ",
              icon: "success",
            }).then(() => {
              window.location.reload();
            });
          } else {
            // Show SweetAlert for other cases (error, etc.)
            Swal.fire({
              title: "ไม่สำเร็จ!",
              text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
              icon: "error",
            });
          }
        },
        error: function () {
          // Show SweetAlert if an error occurs during the AJAX request
          Swal.fire({
            title: "ไม่สำเร็จ!",
            text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
            icon: "error",
          });
        },
      });
    }
  });
}

function userActive(name, id) {
  Swal.fire({
    title: "เปิดใช้เมนู?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ตกลง",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      // Send AJAX request to editUser.php
      $.ajax({
        type: "PATCH",
        url: "functions/patch-activeMenu.php",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        data: `id=${id}`, // Serialize form data
        success: function (response) {
          // Parse the JSON response
          var responseData = JSON.parse(response);

          // Check if the message is equal to "success"
          if (responseData.message === "success") {
            // Show SweetAlert for success
            Swal.fire({
              title: "สำเร็จ!",
              text: "บันทึกข้อมูลสำเร็จ",
              icon: "success",
            }).then(() => {
              window.location.reload();
            });
          } else {
            // Show SweetAlert for other cases (error, etc.)
            Swal.fire({
              title: "ไม่สำเร็จ!",
              text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
              icon: "error",
            });
          }
        },
        error: function () {
          // Show SweetAlert if an error occurs during the AJAX request
          Swal.fire({
            title: "ไม่สำเร็จ!",
            text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
            icon: "error",
          });
        },
      });
    }
  });
}

function calculateNetPrice() {
  var originalPrice = parseFloat($("#originalPrice").val());
  var discount = parseFloat($("#discount").val());

  if (discount != 0) {
    var netPrice = originalPrice - (originalPrice * discount) / 100;
    $("#netPrice").text("ราคา " + netPrice.toFixed(2) + " บาท");
  } else {
    $("#netPrice").text("ราคา " + originalPrice + " บาท");
  }
}
