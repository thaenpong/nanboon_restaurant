function formatBath(bath) {
  const formatted = new Intl.NumberFormat("th-TH", {
    style: "currency",
    currency: "THB",
  }).format(bath);
  return formatted;
}

function formatDate(inputDate) {
  var date = new Date(inputDate);
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  var hours = date.getHours();
  var minutes = date.getMinutes();

  // Add leading zero if day or month is less than 10
  day = day < 10 ? "0" + day : day;
  month = month < 10 ? "0" + month : month;

  // Add leading zero if minutes is less than 10
  minutes = minutes < 10 ? "0" + minutes : minutes;

  return day + "/" + month + "/" + year + " " + hours + ":" + minutes;
}

$(document).ready(function () {
  $("#month").change(function () {
    const selectedMonth = $(this).val();
    // Make an AJAX request
    $.ajax({
      type: "GET",
      url: "functions/get-selling.php",
      data: { month: selectedMonth },
      dataType: "json",
      success: function (data) {
        $("#totalPrice").text(formatBath(data.totalPrice));
        $("#totalDiscount").text(formatBath(data.totalDiscount));

        const btnPrintDiv = document.getElementById("btn-print");
        const existingButton = btnPrintDiv.querySelector("a.btn-success");
        if (!existingButton) {
          // Create a button element
          const button = document.createElement("a");

          // Set button class
          button.className = "btn btn-success";

          // Set button text
          button.textContent = "Print";
          button.setAttribute(
            "href",
            "/nb_res/functions/pdf-month.php?month=" +
              encodeURIComponent(selectedMonth)
          );
          button.setAttribute("target", "_blank");

          // Append the button to the div with id "btn-print"
          btnPrintDiv.appendChild(button);
        } else {
          existingButton.setAttribute(
            "href",
            "/nb_res/functions/pdf-month.php?month=" +
              encodeURIComponent(selectedMonth)
          );
        }

        // Calculate total (totalPrice - totalDiscount)
        const total =
          parseFloat(data.totalPrice) - parseFloat(data.totalDiscount);
        $("#total").text(formatBath(total));

        // Update table
        const tableBody = $("#tableBody");
        tableBody.empty(); // Clear existing rows

        // Loop through menuData and append rows to the table
        $.each(data.orders, function (index, order) {
          const row =
            "<tr>" +
            "<td>" +
            (index + 1) +
            "</td>" +
            "<td>" +
            order.id +
            "</td>" +
            "<td>" +
            formatDate(order.createdAt) +
            "</td>" +
            "<td>" +
            formatBath(order.total_menu_price) +
            "</td>" +
            `<td><a href="/nb_res/home.php?page=manage-orderDetail&id=${order.id}" target="_blank" class="btn btn-primary">ดู</a></td>` +
            "</tr>";
          tableBody.append(row);
        });
      },
      error: function (error) {
        console.log("Error fetching data:", error);
      },
    });
  });

  $("#year").change(function () {
    const selectedYear = $(this).val();
    // Make an AJAX request
    $.ajax({
      type: "GET",
      url: "functions/get-selling.php",
      data: { year: selectedYear },
      dataType: "json",
      success: function (data) {
        $("#totalPrice").text(formatBath(data.totalPrice));
        $("#totalDiscount").text(formatBath(data.totalDiscount));

        const btnPrintDiv = document.getElementById("btn-print");
        const existingButton = btnPrintDiv.querySelector("a.btn-success");
        if (!existingButton) {
          // Create a button element
          const button = document.createElement("a");

          // Set button class
          button.className = "btn btn-success";

          // Set button text
          button.textContent = "Print";
          button.setAttribute(
            "href",
            "/nb_res/functions/pdf-year.php?year=" +
              encodeURIComponent(selectedYear)
          );
          button.setAttribute("target", "_blank");

          // Append the button to the div with id "btn-print"
          btnPrintDiv.appendChild(button);
        } else {
          existingButton.setAttribute(
            "href",
            "/nb_res/functions/pdf-year.php?year=" +
              encodeURIComponent(selectedYear)
          );
        }

        // Calculate total (totalPrice - totalDiscount)
        const total =
          parseFloat(data.totalPrice) - parseFloat(data.totalDiscount);
        $("#total").text(formatBath(total));

        // Update table
        const tableBody = $("#tableBody");
        tableBody.empty(); // Clear existing rows

        // Loop through menuData and append rows to the table
        $.each(data.orders, function (index, order) {
          const row =
            "<tr>" +
            "<td>" +
            (index + 1) +
            "</td>" +
            "<td>" +
            order.name +
            "</td>" +
            "<td>" +
            order.sumQuantity +
            "</td>" +
            "<td>" +
            order.total_menu_price +
            "</td>" +
            "<td>" +
            order.discount +
            "</td>" +
            "<td>" +
            `${order.total_menu_price - order.discount}` +
            "</td>" +
            "</tr>";
          tableBody.append(row);
        });
      },
      error: function (error) {
        console.log("Error fetching data:", error);
      },
    });
  });

  $("#date").change(function () {
    const selectedDate = $("#date").val();

    // Make an AJAX request
    $.ajax({
      type: "GET",
      url: "functions/get-selling.php",
      data: { date: selectedDate },
      dataType: "json",
      success: function (data) {
        $("#totalPrice").text(formatBath(data.totalPrice));
        $("#totalDiscount").text(formatBath(data.totalDiscount));

        const btnPrintDiv = document.getElementById("btn-print");
        const existingButton = btnPrintDiv.querySelector("a.btn-success");
        if (!existingButton) {
          // Create a button element
          const button = document.createElement("a");

          // Set button class
          button.className = "btn btn-success";

          // Set button text
          button.textContent = "Print";
          button.setAttribute(
            "href",
            "/nb_res/functions/pdf-day.php?day=" +
              encodeURIComponent(selectedDate)
          );
          button.setAttribute("target", "_blank");

          // Append the button to the div with id "btn-print"
          btnPrintDiv.appendChild(button);
        } else {
          existingButton.setAttribute(
            "href",
            "/nb_res/functions/pdf-day.php?day=" +
              encodeURIComponent(selectedDate)
          );
        }

        // Calculate total (totalPrice - totalDiscount)
        const total =
          parseFloat(data.totalPrice) - parseFloat(data.totalDiscount);
        $("#total").text(formatBath(total));

        // Update table
        const tableBody = $("#tableBody");
        tableBody.empty(); // Clear existing rows

        // Loop through menuData and append rows to the table
        $.each(data.orders, function (index, order) {
          const row =
            "<tr>" +
            "<td>" +
            (index + 1) +
            "</td>" +
            "<td>" +
            order.name +
            "</td>" +
            "<td>" +
            order.sumQuantity +
            "</td>" +
            "<td>" +
            order.total_menu_price +
            "</td>" +
            "<td>" +
            order.discount +
            "</td>" +
            "<td>" +
            `${order.total_menu_price - order.discount}` +
            "</td>" +
            "</tr>";
          tableBody.append(row);
        });
      },
      error: function (error) {
        console.log("Error fetching data:", error);
      },
    });
  });

  $("#from-date, #to-date").change(function () {
    const fromDate = $("#from-date").val();
    const toDate = $("#to-date").val();

    // Make an AJAX request
    $.ajax({
      type: "GET",
      url: "functions/get-selling.php",
      data: { fromDate: fromDate, toDate: toDate },
      dataType: "json",
      success: function (data) {
        // Handle the data here

        // Update spans
        $("#totalPrice").text(formatBath(data.totalPrice));
        $("#totalDiscount").text(formatBath(data.totalDiscount));

        const btnPrintDiv = document.getElementById("btn-print");
        const existingButton = btnPrintDiv.querySelector("a.btn-success");
        if (!existingButton) {
          // Create a button element
          const button = document.createElement("a");

          // Set button class
          button.className = "btn btn-success";

          // Set button text
          button.textContent = "Print";
          button.setAttribute(
            "href",
            "/nb_res/functions/pdf-menu.php?fromDate=" +
              encodeURIComponent(fromDate) +
              "&toDate=" +
              encodeURIComponent(toDate)
          );
          button.setAttribute("target", "_blank");

          // Append the button to the div with id "btn-print"
          btnPrintDiv.appendChild(button);
        } else {
          existingButton.setAttribute(
            "href",
            "/nb_res/functions/pdf-menu.php?fromDate=" +
              encodeURIComponent(fromDate) +
              "&toDate=" +
              encodeURIComponent(toDate)
          );
        }

        // Calculate total (totalPrice - totalDiscount)
        const total =
          parseFloat(data.totalPrice) - parseFloat(data.totalDiscount);
        $("#total").text(formatBath(total));

        // Update table
        const tableBody = $("#tableBody");
        tableBody.empty(); // Clear existing rows

        // Loop through menuData and append rows to the table
        $.each(data.orders, function (index, order) {
          const row =
            "<tr>" +
            "<td>" +
            (index + 1) +
            "</td>" +
            "<td>" +
            order.name +
            "</td>" +
            "<td>" +
            order.sumQuantity +
            "</td>" +
            "<td>" +
            order.total_menu_price +
            "</td>" +
            "<td>" +
            order.discount +
            "</td>" +
            "<td>" +
            `${order.total_menu_price - order.discount}` +
            "</td>" +
            "</tr>";
          tableBody.append(row);
        });
      },
      error: function (error) {
        console.log("Error fetching data:", error);
      },
    });
  });

  const currentYear = new Date().getFullYear();

  // Populate the select element with the current year and the year before
  /* for (let year = currentYear; year >= currentYear - 3; year--) {
    const option = document.createElement("option");
    option.value = year;
    option.text = year;
    document.getElementById("year").appendChild(option);
  } */
});
