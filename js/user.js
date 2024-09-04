$(document).ready(function () {
    $('#userEdit').on('submit', function (e) {
        e.preventDefault();

        // Show SweetAlert before sending the AJAX request
        Swal.fire({
            title: "แก้ไขข้อมูล?",
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
                    type: 'POST',
                    url: 'functions/patch-updateUser.php',
                    data: $('#userEdit').serialize(), // Serialize form data
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
                    }
                });
            }
        });
    });

    $('#userAdd').on('submit', function (e) {
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
                $.ajax({
                    type: 'POST',
                    url: 'functions/post-createUser.php',
                    data: $('#userAdd').serialize(), // Serialize form data
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
                    }
                });
            }
        });
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
                type: 'PATCH',
                url: 'functions/patch-removeUser.php',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
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
                }
            });
        }
    });
}