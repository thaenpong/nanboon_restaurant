let orders = [];

async function getItems() {
  const res = [];
  // Iterate over each id in the orders array
  for (const id of orders) {
    // Fetch data for the current id
    const response = await fetch("functions/get-order.php?id=" + id);
    const data = await response.json();
    for (const item of data) {
      res.push(item);
    }
  }
  //console.log(res);
  return res;
}

async function decreaseItem(id) {
  const res = await fetch("functions/get-order.php?id=" + id);
  const data = await res.json();
  if (data.message == "success") {
    const count = document.getElementsByClassName("count");
  }
}

async function print() {
  for (const id of orders) {
    await fetch("functions/patch-printOrder.php?id=" + id);
  }
  window.open(`functions/get-receipt.php?orders=${orders}`, "_blank");
  getTable(id);
}

async function pay() {
  Swal.fire({
    title: "รับชำระด้วย?",
    icon: "warning",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    denyButtonColor: "#fbbf2b",
    confirmButtonText: "เงินสด",
    denyButtonText: `โอน`,
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      fetch("functions/patch-updateOrder.php", {
        method: "PATCH",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `orders=${orders}&paytype=0`,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json(); // Assuming the response is JSON
        })
        .then((data) => {
          // Check for success message
          if (data.message === "success") {
            // Display success message using SweetAlert
            Swal.fire({
              icon: "success",
              title: "สำเร็จ",
              text: "ปิดการขายสำเร็จ",
            }).then(() => {
              window.location.reload();
            });
          } else {
            // Handle other cases if needed
            Swal.fire({
              icon: "error",
              title: "ไม่สำเร็จ",
              text: "มีบางอย่างผิดพลาด",
            });
          }
        })
        .catch((error) => {
          // Handle specific HTTP status codes and other errors
          Swal.fire({
            icon: "error",
            title: "ไม่สำเร็จ",
            text: "มีบางอย่างผิดพลาด",
          });
        });
    } else if (result.isDenied) {
      fetch("functions/patch-updateOrder.php", {
        method: "PATCH",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `orders=${orders}&paytype=1`,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json(); // Assuming the response is JSON
        })
        .then((data) => {
          // Check for success message
          if (data.message === "success") {
            // Display success message using SweetAlert
            Swal.fire({
              icon: "success",
              title: "สำเร็จ",
              text: "ปิดการขายสำเร็จ",
            }).then(() => {
              window.location.reload();
            });
          } else {
            // Handle other cases if needed
            Swal.fire({
              icon: "error",
              title: "ไม่สำเร็จ",
              text: "มีบางอย่างผิดพลาด",
            });
          }
        })
        .catch((error) => {
          // Handle specific HTTP status codes and other errors
          Swal.fire({
            icon: "error",
            title: "ไม่สำเร็จ",
            text: "มีบางอย่างผิดพลาด",
          });
        });
    }
  });
}

//---------------------------------------------------------------------------------------------------

async function cancleOrder(id, deskId) {
  Swal.fire({
    title: "ยกเลิกออเดอร์ โต๊ะ " + deskId + " ใช่หรือไม่",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ตกลง",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      // User clicked "Yes," proceed with form submission

      // AJAX request to send data to PHP
      fetch("functions/patch-removeOrder.php", {
        method: "PATCH",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}&deskId=${deskId}`,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json(); // Assuming the response is JSON
        })
        .then((data) => {
          // Check for success message
          if (data.message === "success") {
            // Display success message using SweetAlert
            Swal.fire({
              icon: "success",
              title: "สำเร็จ",
              text: "ยกเลิกออเดอร์สำเร็จ",
            }).then(() => {
              window.location.reload();
            });
          } else {
            // Handle other cases if needed
            Swal.fire({
              icon: "error",
              title: "ไม่สำเร็จ",
              text: "มีบางอย่างผิดพลาด",
            });
          }
        })
        .catch((error) => {
          // Handle specific HTTP status codes and other errors
          Swal.fire({
            icon: "error",
            title: "ไม่สำเร็จ",
            text: "มีบางอย่างผิดพลาด",
          });
        });
    }
  });
}

async function sumTable(id) {
  try {
    if (!orders.includes(id)) {
      // Add the id to the orders array
      orders.push(id);
    }
    getOrders();
  } catch (error) {}
}

async function getTable(id) {
  try {
    orders.forEach((id) => {
      // Construct the id of the button
      const buttonId = "sum" + id;

      // Get the button element by id
      const button = document.getElementById(buttonId);

      // Set the background color of the button to red
      button.style.backgroundColor = "#0d6efd";
    });
    // Clear the orders array
    orders = [];
    // Push the new id to the orders array
    orders.push(id);
    getOrders();
  } catch (error) {
    console.error("Error:", error);
  }
}

async function getOrders() {
  orders.forEach((id) => {
    // Construct the id of the button
    const buttonId = "sum" + id;

    // Get the button element by id
    const button = document.getElementById(buttonId);

    // Set the background color of the button to red
    button.style.backgroundColor = "#198754";
  });

  let data = await getItems();
  const checkbillDiv = document.getElementById("billItems");
  const totalPriceDiv = document.getElementById("totalPrice");
  const discountTagDiv = document.getElementById("discountTag");
  const sumTables = document.querySelectorAll(".sumTable");
  sumTables.forEach((button) => {
    button.hidden = false;
  });
  const spanTotal = document.getElementById("spanTotal");
  const netPrice = document.getElementById("netPrice");
  const spanNetPrice = document.getElementById("spanNetPrice");
  const discountOrder = document.getElementById("discount");
  spanTotal.hidden = false;
  // Clear previous content in the checkbill, totalPrice, and discountTag divs
  checkbillDiv.innerHTML = "";
  totalPriceDiv.innerHTML = "";

  // Create an unordered list element
  const ul = document.createElement("ul");
  ul.classList.add("listItems");
  let totalPriceSum = 0; // Initialize the sum variable
  let netPriceSum = 0;
  let discount = 0;

  // Loop through the data and create list items
  for (const item of data) {
    //console.log(item);
    const li = document.createElement("li");
    let containerDiv = document.createElement("div");
    containerDiv.classList.add("item-container");

    // Column 1
    let name = document.createElement("span");
    name.classList.add("nameSpan");
    name.innerHTML = item.name;
    containerDiv.appendChild(name);

    //count
    let countSpan = document.createElement("span");
    countSpan.classList.add("countSpan");

    let count = document.createElement("span");
    count.classList.add("count");
    count.textContent = item.quantity; // Add some content to the div
    countSpan.appendChild(count);
    containerDiv.appendChild(countSpan);

    let noteSpan = document.createElement("span");
    noteSpan.classList.add("noteSpan"); // You may want to add a class for styling
    noteSpan.textContent = item.note;
    containerDiv.appendChild(noteSpan);

    // Column 3 with Remove Button
    let priceSpan = document.createElement("span");
    priceSpan.classList.add("priceSpan"); // You may want to add a class for styling
    const itemPrice = item.price - (item.price * item.discount) / 100;
    if (item.discount > 0) {
      const originalPrice = document.createElement("del");
      originalPrice.classList.add("originalPrice");
      originalPrice.textContent = `฿${item.price * item.quantity}`;
      priceSpan.appendChild(originalPrice);

      const discountedPrice = document.createElement("span");
      discountedPrice.classList.add("discountedPrice");
      discountedPrice.textContent = `฿${itemPrice.toFixed(2) * item.quantity}`;
      priceSpan.appendChild(discountedPrice);
    } else {
      priceSpan.textContent = `฿${itemPrice.toFixed(2) * item.quantity}`;
    }

    containerDiv.appendChild(priceSpan);

    // Append the container div to the li
    li.appendChild(containerDiv);

    ul.appendChild(li);

    // Add the totalPrice of the current item to the sum
    totalPriceSum += parseFloat(item.price * item.quantity);
    discount += parseFloat((item.price * item.discount * item.quantity) / 100);
    netPriceSum += parseFloat(itemPrice * item.quantity);
  }

  // Append the unordered list to the checkbill div
  checkbillDiv.appendChild(ul);

  // Display the total price in the totalPrice div

  totalPriceDiv.textContent = `฿${totalPriceSum}`;
  discountOrder.textContent = `฿${discount}`;
  netPrice.textContent = `฿${totalPriceSum - discount}`;

  // Show the discountTag element
  discountTagDiv.hidden = false;
  spanNetPrice.hidden = false;
  discountOrder.hidden = false;

  const button1 = document.getElementById("payButton");
  if (button1) {
    button1.remove();
  }

  const button2 = document.getElementById("printButton");
  if (button2) {
    button2.remove();
  }

  // Add click event listener to the "จ่ายเงิน" button
  const printButton = document.createElement("button");
  printButton.classList.add("btn");
  printButton.classList.add("btn-success");
  printButton.classList.add("payBtn");
  printButton.classList.add("w-100");
  printButton.id = "printButton"; // Set the id of the button
  printButton.textContent = "พิมพ์ใบเสร็จ"; // Set the button text
  if (data[0].printed == "1") {
    printButton.setAttribute("disabled", ""); // Set the button as disabled
  }
  printButton.addEventListener("click", () => {
    // Log the required data when the button is clicked
    print();
  });

  // Append the button to a container or the body
  document.getElementById("print").appendChild(printButton); // Adjust this line based on where you want to append the button

  // Add click event listener to the "จ่ายเงิน" button
  const payButton = document.createElement("button");
  payButton.classList.add("btn");
  payButton.classList.add("btn-success");
  payButton.classList.add("payBtn");
  payButton.classList.add("w-100");
  payButton.id = "payButton"; // Set the id of the button
  payButton.textContent = "ชำระเงิน"; // Set the button text
  payButton.addEventListener("click", () => {
    // Log the required data when the button is clicked
    pay();
  });

  // Append the button to a container or the body

  document.getElementById("pay").appendChild(payButton); // Adjust this line based on where you want to append the button

  document.getElementById("clear").innerHTML = "";

  const clearButton = document.createElement("button");
  clearButton.classList.add("btn");
  clearButton.classList.add("btn-danger");
  clearButton.classList.add("w-100");
  clearButton.id = "clearButton"; // Set the id of the button
  clearButton.textContent = "เคลียร์"; // Set the button text
  clearButton.addEventListener("click", () => {
    // Log the required data when the button is clicked
    clear();
  });
  document.getElementById("clear").appendChild(clearButton); // Adjust this line based on where you want to append the button
}

function clear() {
  orders.forEach((id) => {
    // Construct the id of the button
    const buttonId = "sum" + id;

    // Get the button element by id
    const button = document.getElementById(buttonId);

    // Set the background color of the button to red
    button.style.backgroundColor = "#0d6efd";
  });
  document.getElementById("clear").innerHTML = "";
  orders = [];
  getOrders();
}
