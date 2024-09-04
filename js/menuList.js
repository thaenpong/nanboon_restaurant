var i = [];
let totalPrice = 0;

$(document).ready(function () {
  document.getElementById("submit").disabled = true;
  function updateSubmit() {
    if (i.length === 0) {
      document.getElementById("submit").disabled = true;
    } else {
      document.getElementById("submit").disabled = false;
    }
  }

  // Array to store menu items

  function removeItems(keyValue) {
    for (let j = 0; j < i.length; j++) {
      if (i[j].key === keyValue) {
        itemPrice = i[j].price - (i[j].price * i[j].discount) / 100;
        totalPrice = totalPrice - parseFloat(itemPrice) * i[j].count;
        document.getElementById("price").value = totalPrice;
        // Remove the element at index j from the array
        i.splice(j, 1);

        // Find the corresponding li element in the DOM and remove it
        let menuList = document.getElementById("menuList");
        let listItemToRemove = menuList.querySelector(`[key="${keyValue}"]`);

        if (listItemToRemove) {
          listItemToRemove.remove();
        }

        break;
      }
    }
    updateSubmit();
  }

  function addCount(keyValue) {
    for (let j = 0; j < i.length; j++) {
      if (i[j].key === keyValue) {
        i[j].count++;
        itemPrice = i[j].price - (i[j].price * i[j].discount) / 100;
        totalPrice = totalPrice + parseFloat(itemPrice);
        document.getElementById("price").value = totalPrice;

        // Update the corresponding HTML element
        let menuList = document.getElementById("menuList");
        let listItemToUpdate = menuList.querySelector(`[key="${keyValue}"]`);

        if (listItemToUpdate) {
          let countElement = listItemToUpdate.querySelector(".count");
          countElement.textContent = i[j].count;
          let priceElement = listItemToUpdate.querySelector(".priceSpan");
          priceElement.textContent = "฿" + i[j].count * itemPrice;
        }

        break;
      }
    }
    updateSubmit();
  }

  function decreaseItem(keyValue) {
    for (let j = 0; j < i.length; j++) {
      if (i[j].key === keyValue) {
        if (i[j].count === 1) {
          removeItems(keyValue);
        } else {
          itemPrice = i[j].price - (i[j].price * i[j].discount) / 100;
          totalPrice = totalPrice - parseFloat(itemPrice);
          document.getElementById("price").value = totalPrice;
          i[j].count--;
          // Update the corresponding HTML elements
          let menuList = document.getElementById("menuList");
          let listItemToUpdate = menuList.querySelector(`[key="${keyValue}"]`);
          if (listItemToUpdate) {
            let countElement = listItemToUpdate.querySelector(".count");
            countElement.textContent = i[j].count;
            let priceElement = listItemToUpdate.querySelector(".priceSpan");
            priceElement.textContent = "฿" + i[j].count * itemPrice;
          }
          break;
        }
      }
    }
    updateSubmit();
  }

  // Function to add a new menu item or update count if it already exists
  // Function to add a new menu item or update count if it already exists
  async function addMenuItem(menuItem) {
    let menuList = document.getElementById("menuList");
    const ItemPrice =
      menuItem.price - (menuItem.price * menuItem.discount) / 100;
    totalPrice += parseFloat(ItemPrice);
    //console.log(totalPrice)
    document.getElementById("price").value = totalPrice;

    // Check if the menu item is already in the list
    /* let existingItem = menuList.querySelector(`[data_id="${menuItem.id}"]`); */
    const existingItem = false;

    //console.log(ItemPrice);
    if (existingItem) {
      //console.log(ItemPrice);
      // If the item already exists, update the count
      let countElement = existingItem.querySelector(".count");
      countElement.textContent = menuItem.count;

      let priceElement = existingItem.querySelector(".priceSpan");
      priceElement.textContent = "฿" + menuItem.count * ItemPrice;
    } else {
      let li = document.createElement("li");
      li.setAttribute("data_id", menuItem.id);
      li.setAttribute("key", menuItem.key);

      let containerDiv = document.createElement("div");
      containerDiv.classList.add("item-container");

      // Column 1
      let name = document.createElement("span");
      name.classList.add("nameSpan");
      name.innerHTML = menuItem.name;
      containerDiv.appendChild(name);

      //count
      let countSpan = document.createElement("span");
      countSpan.classList.add("countSpan");

      let decreaseButton = document.createElement("button");
      decreaseButton.textContent = "-"; // Fix: Set the text content for decreaseButton
      decreaseButton.addEventListener("click", function (event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        // Remove the menu item when the remove button is clicked
        decreaseItem(menuItem.key);
      });
      countSpan.appendChild(decreaseButton);

      let count = document.createElement("span");
      count.classList.add("count");
      count.textContent = menuItem.count; // Add some content to the div
      countSpan.appendChild(count);

      let addButton = document.createElement("button");
      addButton.textContent = "+";
      addButton.addEventListener("click", function (event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        // Increment the count when the add button is clicked
        addCount(menuItem.key);
      });
      countSpan.appendChild(addButton);

      containerDiv.appendChild(countSpan);

      // Price
      let noteSpan = document.createElement("span");
      noteSpan.classList.add("noteSpan"); // You may want to add a class for styling
      noteSpan.textContent = menuItem.note;
      containerDiv.appendChild(noteSpan);

      // Price
      let priceSpan = document.createElement("span");
      priceSpan.classList.add("priceSpan"); // You may want to add a class for styling
      priceSpan.textContent = "฿" + ItemPrice * menuItem.count;
      containerDiv.appendChild(priceSpan);

      // Append the container div to the li
      li.appendChild(containerDiv);

      // Append the li to the menuList
      menuList.appendChild(li);
    }
  }

  // Click event for the ".add" buttons
  $(".add").click(async function () {
    let keyValue = $(this).attr("key");
    let found = false;
    //console.log(keyValue);

    // Fetch menu data
    const menuDataResponse = await fetch(
      "functions/getmenuData.php?id=" + keyValue
    );
    const menuData = await menuDataResponse.json();

    let note = "";

    await Swal.fire({
      title: "รายละเอียด",
      input: "text",
      showCancelButton: true,
      confirmButtonText: "บันทึก",
    }).then((result) => {
      if (result.isConfirmed) {
        note = result.value;
        menuData.count = 1;
        menuData.note = note;
        menuData.key = Math.random().toString(36).substring(7);
        i.push(menuData);
        addMenuItem(menuData);
        updateSubmit();
      }
    });

    /*  if (!found) {
    } else {
      addMenuItem(menuData);
      updateSubmit();
    } */
  });
});

async function submitForm() {
  //const selectedValue = document.getElementById("menuItemSelect").value;
  const res = await fetch("functions/get-desks.php");
  const desks = await res.json();
  let deskOptions = {};

  // Loop through the desks array and populate the deskOptions object
  desks.forEach(function (desk) {
    let status = "ว่าง";
    if (desk.status != 1) {
      status = "ไม่ว่าง";
    }
    let deskOption = desk.label;
    if (desk.takeAway != 1) {
      deskOption += ` (${status})`;
    }
    deskOptions[desk.id] = deskOption;
  });

  //console.log(desks);
  const menuItems = i.map(function (item) {
    console.log(item.note);
    return { itemId: item.id, quantity: item.count, note: item.note };
  });

  document.getElementById("menuItems").value = JSON.stringify(menuItems);
  //alert("Form submitted with data: " + JSON.stringify(menuItems) + "\nSelected Value: " + selectedValue);

  Swal.fire({
    title: "เลือกที่นั่ง",
    input: "select",
    inputOptions: deskOptions,
    showCancelButton: true,
    inputValidator: function (value) {
      return new Promise(function (resolve, reject) {
        if (value !== "") {
          resolve();
        } else {
          resolve("You need to select a Tier");
        }
      });
    }, //result.value,
  }).then(function (result) {
    if (result.isConfirmed) {
      const selectedValue = result.value;
      Swal.fire({
        title: "เปิดบิล?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ตกลก",
        cancelButtonText: "ยกเลิก",
      }).then((result) => {
        if (result.isConfirmed) {
          // User clicked "Yes," proceed with form submission

          // AJAX request to send data to PHP
          fetch("functions/post-createOrder.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body:
              "menuItems=" +
              encodeURIComponent(JSON.stringify(menuItems)) +
              "&selectedValue=" +
              encodeURIComponent(selectedValue),
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
                // Reset the array 'i'
                i = [];
                // Clear the menu list in the DOM (assuming you have an element with the id 'menuList')
                document.getElementById("menuList").innerHTML = "";
                document.getElementById("price").value = "0";
                const order_id = data.id;

                // Display success message using SweetAlert
                Swal.fire({
                  icon: "success",
                  title: "สำเร็จ",
                  text: "เปิดบิลเรียบร้อย",
                }).then((result) => {
                  if (result.isConfirmed) {
                    // Reload the page

                    window.open(
                      `functions/get-menubill.php?selectedValue=${selectedValue}&menuItems=${JSON.stringify(
                        menuItems
                      )}&id=${order_id}`,
                      "_blank"
                    );
                    location.reload();
                  }
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
  });

  // You can uncomment the following line to prevent the form from submitting in the traditional way
  // event.preventDefault();
}

async function filterMenuList(categoryId) {
  const menuItems = document.querySelectorAll(".cardMenu");

  if (categoryId === "0") {
    const res = await fetch("functions/get-top5menu.php");
    const top5menu = await res.json();
    menuItems.forEach(function (menuItem) {
      // Check if menuItem.id exists in top5menu array

      const menuItemId = menuItem.getAttribute("data-id");
      const isInTop5Menu = top5menu.some((item) => item.id === menuItemId);

      if (isInTop5Menu) {
        menuItem.classList.remove("hidden");
      } else {
        menuItem.classList.add("hidden");
      }
    });
  } else {
    menuItems.forEach(function (menuItem) {
      const menuItemCategory = menuItem.getAttribute("data-category");

      if (categoryId === "all" || categoryId === menuItemCategory) {
        menuItem.classList.remove("hidden");
      } else {
        menuItem.classList.add("hidden");
      }
    });
  }
}
